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

$PAGE->set_url('/thelmsapp/downc.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$id     = required_param('id', PARAM_INT);
$next   = required_param('next',PARAM_INT);

$course = $DB->get_records_select('block_thelmsapp_course','id = ' .$id);

//IF ELEMENT POSITION IS ALREADY 0 PREVENT -1 VALUE
  if ($course[$id]->position == 0) 
	  redirect($CFG->wwwroot . '/blocks/thelmsapp/courses.php' , get_string('position_changed','block_thelmsapp'));
//IF ELEMENT POSITION IS ALREADY 0 PREVENT -1 VALUE

//DECREASE ELEMENT POSITION VALUE
  $course_class = new stdClass();
  $course_class->id = $id;
  $course_class->position = $course[$id]->position -1;

  $lastinsertid = $DB->update_record('block_thelmsapp_course', $course_class, false);
//DECREASE ELEMENT POSITION VALUE

//AND INCREASE POSITION OF PREVIOUS POSITIONED ELEMENT
	if ($next >= 0) {
		$course = $DB->get_records_select('block_thelmsapp_course','id = ' .$next);

		$course_class = new stdClass();
		$course_class->id = $next;
		$course_class->position = $course[$next]->position + 1;
	
		$lastinsertid = $DB->update_record('block_thelmsapp_course', $course_class, false);
}
//AND INCREASE POSITION OF PREVIOUS POSITIONED ELEMENT
	
$lastinsertid = $DB->update_record('block_thelmsapp_course', $course_class, false);
redirect($CFG->wwwroot . '/blocks/thelmsapp/courses.php');     

?>