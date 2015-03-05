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
            array('datetime'  => new external_value(
                PARAM_TEXT,
                'Count users within the last `n` days',
                VALUE_DEFAULT,
                7
            ))
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
        $context = context_user::instance($USER->id);
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
                'siterelease' => new external_value(PARAM_RAW, "siterelease"),
                'location' => new external_value(PARAM_RAW, "location"),
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
        $teachers = orvsd_siteinfo_user_count("teacher",null);

        $courselist_string = orvsd_siteinfo_courselist();

        $sinfo = array();
        $sinfo['baseurl']      = $CFG->wwwroot;
        $sinfo['basepath']     = $CFG->dirroot;
        $sinfo['sitename']     = $SITE->fullname;
        $sinfo['sitetype']     = "moodle";
        $sinfo['siteversion']  = $CFG->version;
        $sinfo['siterelease']  = $CFG->release;
        $sinfo['location']     = php_uname('n');
        $sinfo['totalusers']   = orvsd_siteinfo_user_count();
        $sinfo['adminusers']   = intval($CFG->siteadmins);
        $sinfo['adminlist']    = orvsd_siteinfo_get_admin_list();
        $sinfo['teachers']     = $teachers;
        $sinfo['activeusers']  = orvsd_siteinfo_user_count(null, $timeframe);
        $sinfo['totalcourses'] = count($courselist_string);
        $sinfo['courses']      = $courselist_string;
        $sinfo['timemodified'] = time();

        return $sinfo;
    }

}
