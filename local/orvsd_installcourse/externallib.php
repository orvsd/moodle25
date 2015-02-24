<?php
/**
 * ORVSD External Web Service
 * provides a facility to restore OSL managed courses into moodle
 *
 * @package    orvsd
 * @copyright  2012 OSU Open Source Lab
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir . "/externallib.php");

class local_orvsd_installcourse_external extends external_api {

  /**
   * Returns description of method parameters
   * @return external_function_parameters
   */
  public static function install_course_parameters() {
    return new external_function_parameters(
      array(
        'filepath'    => new external_value(PARAM_TEXT, 'Where the files are located'),
        'file'        => new external_value(PARAM_TEXT, 'The backup filename'),
        'courseid'    => new external_value(PARAM_TEXT, 'The OSL course id'),
        'coursename'  => new external_value(PARAM_TEXT, 'The course full name'),
        'shortname'   => new external_value(PARAM_TEXT, 'The course shortname'),
        'category'    => new external_value(PARAM_TEXT, 'The course category'),
        'firstname'   => new external_value(PARAM_TEXT, 'The user first name'),
        'lastname'    => new external_value(PARAM_TEXT, 'The user last name'),
        'city'        => new external_value(PARAM_TEXT, 'The user city'),
        'username'    => new external_value(PARAM_TEXT, 'The requested username'),
        'email'       => new external_value(PARAM_TEXT, 'The user email'),
        'pass'        => new external_value(PARAM_TEXT, 'The user password')
      )
    );
  }

  /**
   * Delegates course creation, user creation and user assignment tasks
   * Returns the status of the course creation
   * @return string status
   */
  public static function install_course(
      $filepath, $file, $courseid, $coursename, $shortname,
      $category, $firstname, $lastname, $city, $username,
      $email, $pass) {

    global $CFG, $USER, $DB;
    // Include the coursecat methods for creating the category
    require_once($CFG->libdir.'/coursecatlib.php');
    $status = true;

    $serial = $courseid;

    $param_array = array(
        'filepath'  => $filepath,
        'file'      => $file,
        'courseid'  => $courseid,
        'coursename'=> $coursename,
        'shortname' => $shortname,
        'category'  => $category,
        'firstname' => $firstname,
        'lastname'  => $lastname,
        'city'      => $city,
        'username'  => $username,
        'email'     => $email,
        'pass'      => $pass
      );

    $params = self::validate_parameters(self::install_course_parameters(), $param_array);

    //Context validation
    $context = get_context_instance(CONTEXT_USER, $USER->id);
    self::validate_context($context);

    //Capability checking
    if (!has_capability('moodle/course:create', $context)) {
      throw new moodle_exception('cannotcreatecourse');
    }
    if (!has_capability('moodle/user:create', $context)) {
      throw new moodle_exception('cannotcreateuser');
    }
    if (!has_capability('moodle/restore:restorecourse', $context)) {
      throw new moodle_exception('cannotrestorecourse');
    }

    // Create course category if it does not exist
    $coursecat_record = $DB->get_record('course_categories', array('name' => $params['category']));
    if (!$coursecat_record) {
        $created = coursecat::create(array('name' => $params['category']));
        $ccat_id = $created->id;
    } else {
        $ccat_id = $coursecat_record->id;
    }

    // Change from the name to the ID of the course category
    $param_array['category'] = $ccat_id;

    //Restore the course file into this site
    $courseid = local_orvsd_installcourse_external::restore_course($param_array);

    if (!$courseid) {
      return "Course creation failed.";
    } else {
        $course = $DB->get_record('course', array('id'=>$courseid));
        // Trigger a create course event
        events_trigger('course_created', $course);

        // update coursemeta table
        $coursemeta = $DB->get_record('coursemeta', array('courseid'=>$courseid));
        $coursemeta->serial = $serial;
        $DB->update_record('coursemeta', $coursemeta);
    }

    // if username is "none" we aren't creating/enrolling a user, so
    // skip all that stuff

    if($username != "none") {
        //if the user does not exist, create them
        $user = $DB->get_record('user', array('username'=>$username));
        if(!$user) {
          $user = local_orvsd_installcourse_external::create_user($param_array);
        }

        $user_fullname = $user->firstname . " " . $user->lastname;

        if(!$user) {
          return "Failed to create user " . $user_fullname;
        }

        //assign the user to the course
        $roleid = 3; // "Teacher" role
        $status = local_orvsd_installcourse_external::assign_user($courseid, $user, $roleid);

        if(!$status) {
          return "Failed to enrol user " . $user_fullname . " in course " . $coursename;
        }
    }

    return "Course " . $coursename . " created for " . $user_fullname;
  }

  /**
   * Returns description of method result value
   * @return external_description
   */
  public static function install_course_returns() {
    return new external_value(PARAM_TEXT, 'Success status.');
  }

  // private helper functions

  /**
   * Installs a given course by restoring from a file
   * Returns id of newly created/restored course
   * @return int course id
   */
  private static function restore_course($course_array) {
    global $CFG, $USER, $DB;

    require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');
    require_once($CFG->dirroot . '/lib/moodlelib.php');

    // extract the given backup file to a temp dir
    $backup_unique_code = time();

    $backup_file = $course_array['filepath'] . '/' . $course_array['file'];

    $tempdir = $CFG->tempdir. "/backup/" . $backup_unique_code;

    try {
      $fb = get_file_packer();
      $fb->extract_to_pathname($backup_file, $tempdir);
    } catch (Exception $e) {
      return $e->getTrace();
    }

    $newcourseid = restore_dbops::create_new_course(
                    $course_array['coursename'],
                    $course_array['shortname'],
                    $course_array['category']);

    $transaction = $DB->start_delegated_transaction();

    /* -- the restore_controller's parameters:
    * string $tempdir Directory under tempdir/backup awaiting restore
    * int $courseid Course id where restore is going to happen
    * bool $interactive backup::INTERACTIVE_YES[true] or backup::             INTERACTIVE_NO[false]
    * int $mode backup::MODE_[ GENERAL | HUB | IMPORT | SAMESITE ]
    * int $userid
    * int $target backup::TARGET_[ NEW_COURSE | CURRENT_ADDING |
    * CURRENT_DELETING | EXISTING_ADDING | EXISTING_DELETING ]*/
    $rc = new restore_controller(
                $backup_unique_code,
                $newcourseid,
                backup::INTERACTIVE_NO,
                backup::MODE_SAMESITE,
                $USER->id,
                backup::TARGET_NEW_COURSE);

    $rc->execute_precheck();
    $rc->execute_plan();

    $transaction->allow_commit();

    if (empty($CFG->keeptempdirectoriesonbackup)) {
       fulldelete($tempdir);
    }

    $rc->destroy();

    // but restore doesn't keep our name or shortname. We'll just update
    // the record and force the issue
    $course_fixname =  new object();
    $course_fixname->id         = $newcourseid;
    $course_fixname->fullname   = $course_array['coursename'];
    $course_fixname->shortname  = $course_array['shortname'];
    $course_fixname->idnumber   = $course_array['courseid'];
    $course_fixname->startdate  = 0;

    $DB->update_record('course', $course_fixname, $bulk=false);



    return $newcourseid;
  }

  private static function create_user($param_array) {
    global $DB, $CFG;
    $user = new object();
    $user->auth           = 'manual';
    $user->confirmed      = 1;
    $user->policyagreed   = 0;
    $user->deleted        = 0;
    $user->mnethostid     = $CFG->mnet_localhost_id; // always local user
    $user->username       = trim($param['username']);
    $user->password       = $param_array['pass'];
    $user->firstname      = $param_array['firstname'];
    $user->lastname       = $param_array['lastname'];
    $user->email          = $param_array['email'];
    $user->emailstop      = 0;
    $user->city           = $param_array['city'];
    $user->country        = 'US';
    $user->lang           = 'en_utf8';
    $user->timezone       = '99';
    $user->firstaccess    = 0;
    $user->lastlogin      = 0;
    $user->picture        = 0;
    $user->timecreated    = time();
    $user->mailformat     = 1;
    $user->maildigest     = 0;
    $user->maildisplay    = 1;
    $user->htmleditor     = 1;
    $user->ajax           = 1;
    $user->autosubscribe  = 1;
    $user->trackforums    = 0;
    $user->trustbitmask   = 0;
    $user->screenreader   = 0;

    if (!$user->id = $DB->insert_record('user', $user)) {
      return false;
    }

    // make the user a "course creator" in the site context
    $userid = $user->id;
    $roleid = '2';

    $newra = new object;
    $newra->roleid    = $roleid;
    $newra->contextid = '1';
    $newra->userid    = $userid;
    $newra->hidden    = '0';
    $newra->enrol     = 'manual';

    $contextid = '1';
    $timestart = '0';
    $timeend = '0';
    $hidden = '0';
    $success = $DB->insert_record('role_assignments', $newra);
    return $user;
  }

  /**
   * Assign a user a role in a given course
   */
  private static function assign_user($courseid, $user, $roleid) {
    global $DB, $CFG;
    require_once($CFG->libdir.'/enrollib.php');

    //get enrolment instance (manual and student)
    $instances = enrol_get_instances($courseid, false);
    $enrolment = new stdClass();
    foreach ($instances as $instance) {
      if ($instance->enrol === 'manual') {
        $enrolment = $instance;
        break;
      }
    }

    //get enrolment plugin
    $manual = enrol_get_plugin('manual');
    $context = get_context_instance(CONTEXT_COURSE,$courseid);

    //$user = $DB->get_record('user', array('email' => trim($line)));
    if($user && !$user->deleted) {
      if(!is_enrolled($context,$user)) {
        $manual->enrol_user($enrolment,$user->id,$roleid,time());
      }
    } else {
      return false;
    }
    return true;
  }
}
