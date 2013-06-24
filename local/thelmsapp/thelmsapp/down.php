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

$PAGE->set_url('/thelmsapp/down.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$id     = required_param('id', PARAM_INT);
$next   = required_param('next',PARAM_INT);

$option = $DB->get_records_select('block_thelmsapp_option','id = ' .$id);

//IF ELEMENT POSITION IS ALREADY 0 PREVENT -1 VALUE
  if ($option[$id]->position == 0) 
	  redirect($CFG->wwwroot . '/blocks/thelmsapp/options.php' , get_string('position_changed','block_thelmsapp'));
//IF ELEMENT POSITION IS ALREADY 0 PREVENT -1 VALUE

//DECREASE ELEMENT POSITION VALUE
  $option_class = new stdClass();
  $option_class->id = $id;
  $option_class->position = $option[$id]->position -1;

  $lastinsertid = $DB->update_record('block_thelmsapp_option', $option_class, false);
//DECREASE ELEMENT POSITION VALUE

//AND INCREASE POSITION OF PREVIOUS POSITIONED ELEMENT
	if ($next >= 0) {
		$option = $DB->get_records_select('block_thelmsapp_option','id = ' .$next);

		$option_class = new stdClass();
		$option_class->id = $next;
		$option_class->position = $option[$next]->position + 1;
	
		$lastinsertid = $DB->update_record('block_thelmsapp_option', $option_class, false);
}
//AND INCREASE POSITION OF PREVIOUS POSITIONED ELEMENT
	
$lastinsertid = $DB->update_record('block_thelmsapp_option', $option_class, false);
redirect($CFG->wwwroot . '/blocks/thelmsapp/options.php');     

?>