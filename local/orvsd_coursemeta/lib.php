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
 * coursemeta plugin function library 
 *
 * @package    local
 * @subpackage orvsd_coursemeta
 * @copyright  2012 OSU Open Source Lab (http://osuosl.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Initialise the coursemeta table with this site's courses
 * @return bool
 */

function orvsd_coursemeta_update_db($eventdata=null) {
    global $CFG, $DB, $SITE;

    $courselist = orvsd_coursemeta_courselist();
    $courselist_string = '';
    $course_serial = "0";

    $time = time();

    // eventdata will only ever contain one course record, and so
    // only one serial number
    if($eventdata && isset($eventdata->serial)) {
        $course_serial = $eventdata->serial;
    }

    if (count($courselist) > 0) {
        foreach($courselist as $id=>$shortname) {
            $record = $DB->get_record('coursemeta', array('courseid'=>$id));
            $coursemeta = new stdClass();
            $coursemeta->timemodified = $time;

            if($record) {
                $coursemeta->id = $record->id;
                if($record->serial == "0") {
                    $coursemeta->serial = $course_serial;
                }
                $DB->update_record('coursemeta', $coursemeta);
            } else {
                $coursemeta->courseid = $id;
                $coursemeta->shortname = trim($shortname);
                $coursemeta->serial = $course_serial;
                $DB->insert_record('coursemeta', $coursemeta);
            }
        }
    }
    // now remove any course not in our list
    $DB->delete_records_select('coursemeta', 'timemodified < ?', array($time)); 
    return true;
}

/**
 * generate list of courses installed here
 * @return array
 * @TODO: write this function 
 */
function orvsd_coursemeta_courselist() {
  global $CFG, $DB;
  // get all course idnumbers
  $table = 'course';
  //$select = 'format != "site" AND visible = 1';
  $select = 'format != "site"';
  $params = null;
  $sort = 'id';
  $fields = 'id,shortname';
  $courses = $DB->get_records_select_menu($table,$select,$params,$sort,$fields);

  return $courses;
}


/**
 * wipe the table
 * @return array
 * @TODO: write this function 
 */
function orvsd_coursemeta_wipe_table() {
    global $DB;
    $DB->delete_records('coursemeta', array(1=>1)); 
}
