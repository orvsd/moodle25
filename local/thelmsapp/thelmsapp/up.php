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

$PAGE->set_url('/thelmsapp/up.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$id     = required_param('id', PARAM_INT);
$prev   = required_param('prev', PARAM_INT);

$option = $DB->get_records_select('block_thelmsapp_option','id = ' .$id);

//INCREMENT POSITION AND SAVE ELEMENT
  $option_class = new stdClass();
  $option_class->id = $id;
  $option_class->position = $option[$id]->position + 1;

  $lastinsertid = $DB->update_record('block_thelmsapp_option', $option_class, false);
//INCREMENT POSITION AND SAVE ELEMENT

//DECREASE POSITION OF PREVIOUSLY POSITIONED ELEMENT AND SAVE
  if ($prev >= 0){
	  $option = $DB->get_records_select('block_thelmsapp_option','id = ' .$prev);

  	  $option_class = new stdClass();
  	  $option_class->id = $prev;
  	  $option_class->position = $option[$prev]->position - 1;
  	  $lastinsertid = $DB->update_record('block_thelmsapp_option', $option_class, false);
	}
//DECREASE POSITION OF PREVIOUSLY POSITIONED ELEMENT AND SAVE
	
$lastinsertid = $DB->update_record('block_thelmsapp_option', $option_class, false);
redirect($CFG->wwwroot . '/blocks/thelmsapp/options.php');      

?>