<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Utility
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

global $DB, $USER;

$PAGE->set_url('/thelmsapp/upc.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$id     = required_param('id', PARAM_INT);
$prev   = required_param('prev', PARAM_INT);

$course = $DB->get_records_select('block_thelmsapp_course','id = ' .$id);

//INCREMENT POSITION AND SAVE ELEMENT
  $course_class = new stdClass();
  $course_class->id = $id;
  $course_class->position = $course[$id]->position + 1;

  $lastinsertid = $DB->update_record('block_thelmsapp_course', $course_class, false);
//INCREMENT POSITION AND SAVE ELEMENT

//DECREASE POSITION OF PREVIOUSLY POSITIONED ELEMENT AND SAVE
  if ($prev >= 0){
	  $course = $DB->get_records_select('block_thelmsapp_course','id = ' .$prev);

  	  $course_class = new stdClass();
  	  $course_class->id = $prev;
  	  $course_class->position = $course[$prev]->position - 1;
  	  $lastinsertid = $DB->update_record('block_thelmsapp_course', $course_class, false);
	}
//DECREASE POSITION OF PREVIOUSLY POSITIONED ELEMENT AND SAVE
	
//$lastinsertid = $DB->update_record('block_thelmsapp_course', $course_class, false);
redirect($CFG->wwwroot . '/blocks/thelmsapp/courses.php');      

?>