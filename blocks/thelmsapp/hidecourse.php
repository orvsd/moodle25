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
require_once('editoption_form.php');

global $DB, $USER;

$PAGE->set_url('/thelmsapp/hidecourse.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$id     = required_param('id', PARAM_INT);
$course = $DB->get_records_select('block_thelmsapp_course','id = ' .$id);

if ($course[$id]->hidden == 0) {

	$course         = new stdClass();
	$course->id     = $id;
	$course->hidden = 1;
	
	$lastinsertid = $DB->update_record('block_thelmsapp_course', $course, false);
	redirect($CFG->wwwroot . '/blocks/thelmsapp/courses.php', get_string('visibility_changed','block_thelmsapp'));

}
else {

	$course         = new stdClass();
	$course->id     = $id;
	$course->hidden = 0;
	
	$lastinsertid = $DB->update_record('block_thelmsapp_course', $course, false);
	redirect($CFG->wwwroot . '/blocks/thelmsapp/courses.php' , get_string('visibility_changed','block_thelmsapp'));

}        

?>