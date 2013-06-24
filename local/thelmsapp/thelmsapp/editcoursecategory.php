<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage CourseCategories
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once('editcoursecategory_form.php');

global $DB, $USER;

$PAGE->set_url('/thelmsapp/editcoursecategory.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$mform = new editcoursecategory_form('', null, 'post', '', array('autocomplete'=>'on'));

if ($mform->is_cancelled()){
	
	//DO NOTHING. REDIRECT
	redirect($CFG->wwwroot . '/blocks/thelmsapp/coursecategories.php');
	
} else if ($fromform=$mform->get_data()){
    //this branch is where you process validated data.

	$coursecategory         = new stdClass();
	$coursecategory->id     = $fromform->id;
    $coursecategory->name   = $fromform->coursecategory_name;
    $coursecategory->cparent= $fromform->coursecategory_parent;
    
    $lastinsertid = $DB->update_record('block_thelmsapp_coursecat', $coursecategory, false);
	
    $coursecategorytext              = new stdClass();
    $coursecategorytext->id          = $fromform->coursecategorytext_id;
    $coursecategorytext->optionid    = $fromform->coursecategorytext_optionid;
    $coursecategorytext->name        = $fromform->coursecategorytext_name;
    $coursecategorytext->lang        = $fromform->lang;
    $coursecategorytext->description = $fromform->coursecategorytext_description['text'];
    $coursecategorytext->icon        = $fromform->coursecategorytext_icon;
    
    $lastinsertid = $DB->update_record('block_thelmsapp_coursecattxt', $coursecategorytext, false);
	
    echo $OUTPUT->header();
	echo $OUTPUT->box_start();
	echo html_writer::tag('div', '<font color="green">' . get_string('editcoursecategory_success', 'block_thelmsapp'). '</font>', array('align' => 'center'));
	echo '<br/><div align="center">'.html_writer::link('/blocks/thelmsapp/coursecategories.php', get_string('continue','block_thelmsapp')) . '</div>';
	echo $OUTPUT->box_end();
	echo $OUTPUT->footer();
	
} else {
    echo $OUTPUT->header();
    $mform->display();
    echo $OUTPUT->footer();

}

?>