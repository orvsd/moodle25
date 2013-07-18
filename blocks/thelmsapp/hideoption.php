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

$PAGE->set_url('/thelmsapp/hideoption.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$id = required_param('id', PARAM_INT);
$option = $DB->get_records_select('block_thelmsapp_option','id = ' .$id);

if ($option[$id]->hidden == 0) {

	$option = new stdClass();
	$option->id = $id;
	$option->hidden = 1;
	
	$lastinsertid = $DB->update_record('block_thelmsapp_option', $option, false);
	redirect($CFG->wwwroot . '/blocks/thelmsapp/options.php', get_string('visibility_changed','block_thelmsapp'));

}
else {

	$option = new stdClass();
	$option->id = $id;
	$option->hidden = 0;
	
	$lastinsertid = $DB->update_record('block_thelmsapp_option', $option, false);
	redirect($CFG->wwwroot . '/blocks/thelmsapp/options.php' , get_string('visibility_changed','block_thelmsapp'));

}        

?>