<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * siteinfo plugin function library
 *
 * @package    local
 * @subpackage orvsd_siteinfo
 * @copyright  2013 OSU Open Source Lab (http://osuosl.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 *
 * Look for a siteadmin token, if it doesn't exist, generate one
 *
 * Returns nothing
 */
function orvsd_siteinfo_generate_token() {
    global $CFG, $DB;

    // Look up the service, if it doesn't exist, create it
    $service = $DB->get_record(
        'external_services',
        array('component'=>'local_orvsd_siteinfo')
    );

    if (!$service) {
        $tmp = $DB->get_records_sql(
            'SHOW TABLE STATUS WHERE name = "mdl_external_services"'
        );
        $service_id = $tmp['mdl_external_services']->auto_increment;

        $service = new stdClass();
        $service->id = $service_id;
    }

    // Check for a token associated to the siteadmin, if none exists, generate
    $admin = $DB->get_record_sql(
        "SELECT value FROM `mdl_config` WHERE `name` LIKE 'siteadmins'",
        null,
        IGNORE_MISSING
    );

    $admin_user = $DB->get_record('user', array('id' => "$admin->value"));
    $existing_tokens = $DB->get_record(
        'external_tokens',
        array(
            'userid' => $admin_user->id,
            'externalserviceid' => $service->id
        )
    );

    if (!$existing_tokens) {
        require('config.php');
        require_once("$CFG->libdir/externallib.php");

        // Generate a new token for the Admin User
        $token = external_generate_token(
            EXTERNAL_TOKEN_PERMANENT,
            $service,
            $admin_user->id,
            context_system::instance(),
            $validuntil=0,
            $IP_RESTRICTION
        );

        $DB->set_field(
            'external_tokens',
            'creatorid',
            "$admin_user->id",
            array("token"=>"$token")
        );
    }
}

/**
 * Get the comma-delimited array of users on the admin list.
 * The list includes first name, last name, and email-address.
 *
 * Returns: json encoded string for the array of objects with the fields:
 *     string firstname
 *     string lastname
 *     string email
 *
 * You can find and modify the actual list through the moodle website
 * by going to site administration -> users -> permissions -> site administrators
 */

function orvsd_siteinfo_get_admin_list() {
    global $DB;
    $sql = "SELECT firstname, lastname, email
            FROM mdl_user, mdl_config
            WHERE mdl_config.name = ?
            AND FIND_IN_SET(mdl_user.id, mdl_config.value) > ?";
    $result = $DB->get_records_sql($sql, array('siteadmins', 0));

    if (gettype($result) != "array") {
        $result = [$result];
    }

    return $result;
}


/**
 * Count users
 * @return int
 */
function orvsd_siteinfo_usercount($role="none", $timeframe=null) {
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


/**
 * generate list of courses installed here
 * @return array
 */
function orvsd_siteinfo_courselist() {
  global $CFG, $DB;
  // get all course idnumbers
  $table = 'coursemeta';
  $conditions = null;
  $params = null;
  $sort = 'courseid';
  $fields = 'courseid,shortname,serial';
  $courses = $DB->get_records($table,$conditions,$sort,$fields);

  $course_list = array();
  foreach($courses as $course) {
      $shortname = preg_replace('/"/', '', $course->shortname);
      $shortname = preg_replace("/'/", " ", $shortname);
      $enrolled = orvsd_siteinfo_get_enrolments($course->courseid);
      $course_list[] = '{"serial":"' . $course->serial .
                        '","shortname":"' . htmlentities($shortname) .
                        '","enrolled":' . $enrolled . '}';
  }

    $courselist_string = '';

    if (count($course_list) > 0) {
     $courselist_string = "[" . implode(',', $course_list) . "]";
    }

    return $courselist_string;
}


/**
 * Get student enrollments for this course
 * @return array
 */
function orvsd_siteinfo_get_enrolments($courseid) {
  global $CFG, $DB;

  $sql = "select count(userid)
          from mdl_enrol
          left join mdl_user_enrolments
            on mdl_user_enrolments.enrolid=mdl_enrol.id
          where mdl_enrol.roleid=5
          and mdl_enrol.courseid=$courseid";

  $params = null;
  return $DB->get_field_sql($sql,$params, IGNORE_MISSING);
}
