<?php
/**
 * ORVSD External Web Service
 * provides a facility to provide OSL managed moodle site's information
 *
 * @package      orvsd
 * @copyright    2012 OSU Open Soruce lab
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir . "/externallib.php");
require_once("$CFG->dirroot/local/orvsd_siteinfo/lib.php");

class local_orvsd_siteinfo_external extends external_api {

  /**
   * Returns description of method parameters
   * @return external_function_parameters
   */
  public static function siteinfo_parameters() {
    return new external_function_parameters(
      array('datetime'  => new external_value(PARAM_TEXT, 'Count users within the last `n` days', VALUE_DEFAULT, 7))
    );
  }

  /**
   * Returns REST formatted site-info for a given time-period
   * @return string : siteinfo in json format.
   */
  public static function siteinfo($datetime) {
    global $CFG, $USER, $DB;
    $datetime *= 86400; // 86400 seconds per day

    $sinfo = null;

    $param_array = array(
          'datetime' => $datetime
    );
    $params = self::validate_parameters(self::siteinfo_parameters(), $param_array);

    //Context validation
    $context = get_context_instance(CONTEXT_USER, $USER->id);
    self::validate_context($context);

    // timeframe - default is within the last month,
    // i.e time() - 2592000 seconds (within the last 30 days)
    // other options:
    // in the last week = time() - 604800
    $sinfo = local_orvsd_siteinfo_external::get_site_info(time() - $datetime);

    return $sinfo;
  }

  public static function siteinfo_returns() {
    return new external_single_structure (
       array (
        'baseurl' => new external_value(PARAM_RAW, "baseurl"),
        'basepath' => new external_value(PARAM_RAW, "baseurl"),
        'sitename' => new external_value(PARAM_RAW, "sitename"),
        'sitetype' => new external_value(PARAM_RAW, "sitetype", VALUE_DEFAULT, "moodle"),
        'siteversion' => new external_value(PARAM_RAW, "siteversion"),
        'location' => new external_value(PARAM_RAW, "location"),
        'adminemail' => new external_value(PARAM_RAW, "adminemail"),
        'totalusers' => new external_value(PARAM_INT, "totalusers"),
        'adminusers' => new external_value(PARAM_INT, "adminusers"),
        'adminlist' => new external_multiple_structure(
            new external_single_structure(
                array(
                    "firstname" => new external_value(PARAM_RAW, "firstname"),
                    "lastname" => new external_value(PARAM_RAW, "lastname"),
                    "email" => new external_value(PARAM_RAW, "email")
                )
            )
        ),
        'teachers' => new external_value(PARAM_RAW, "teachers"),
        'activeusers' => new external_value(PARAM_INT, "activeusers"),
        'totalcourses' => new external_value(PARAM_INT, "totalcourses"),
        'courses' => new external_value(PARAM_RAW, "courses"),
        'timemodified' => new external_value(PARAM_RAW, "timemodified")
      )
    );
  }

  /**
   * Get the site's info and return as json string
   * @param timeframe : user count within the last `timeframe` seconds
   * @return string
   */
  private static function get_site_info($timeframe) {
      global $CFG, $SITE;

      // teachers = regular and non-editing teachers
      $teachers = local_orvsd_siteinfo_external::user_count("teacher",null);

      $courselist_string = orvsd_siteinfo_courselist();

      $sinfo = array();
      $sinfo['baseurl']      = $CFG->wwwroot;
      $sinfo['basepath']     = $CFG->dirroot;
      $sinfo['sitename']     = $SITE->fullname;
      $sinfo['sitetype']     = "moodle";
      $sinfo['siteversion']  = $CFG->version;
      $sinfo['siterelease']  = $CFG->release;
      $sinfo['location']     = php_uname('n');
      $sinfo['adminemail']   = $CFG->supportemail;
      $sinfo['totalusers']   = local_orvsd_siteinfo_external::user_count(null, null);
      $sinfo['adminusers']   = intval($CFG->siteadmins);
      $sinfo['adminlist']    = orvsd_siteinfo_get_admin_list();
      $sinfo['teachers']     = $teachers;
      $sinfo['activeusers']  = local_orvsd_siteinfo_external::user_count(null, $timeframe);
      $sinfo['totalcourses'] = count($courselist_string);
      $sinfo['courses']      = $courselist_string;
      $sinfo['timemodified'] = time();

      return $sinfo;
    }

    /**
     * Count users
     * @return int
     */
    private static function user_count($role="none", $timeframe=null) {
        global $CFG, $DB;

        switch ($role) {
        case "teacher":
          $role_condition = "IN (3,4)";
          break;
        case "manager":
          $role_condition = "= 1";
          break;
        case "course_creator":
          $role_condition = "= 2";
          break;
        case "student":
          $role_condition = "= 5";
          break;
        case "guest":
          $role_condition = "= 6";
          break;
        case "authed":
          $role_condition = "= 7";
          break;
        case "frontpage":
          $role_condition = "= 8";
          break;
        default:
          $role = false;
        }

      if ($timeframe) {
        //sql += (append WHERE clause to sql to limit by activity date)
        $where = "AND mdl_user.lastaccess > $timeframe";
      } else {
        $where = '';
      }

      if($role) {
        $sql = "SELECT COUNT(DISTINCT userid)
                FROM mdl_role_assignments
                LEFT JOIN mdl_user
                ON mdl_user.id = mdl_role_assignments.userid
                WHERE mdl_role_assignments.roleid $role_condition
                $where";

      } else {
        $sql = "SELECT COUNT(*)
                  FROM mdl_user
                 WHERE mdl_user.deleted = 0
                 AND mdl_user.confirmed = 1
                 $where";
      }

      $count = $DB->count_records_sql($sql, null);

      return intval($count);
  }
}
