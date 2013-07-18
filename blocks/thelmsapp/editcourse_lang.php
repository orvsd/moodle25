<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Courses
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once('editcourse_lang_form.php');

global $DB, $USER;

$PAGE->set_url('/thelmsapp/editcourse_lang.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$mform = new editcourse_lang_form('', null, 'post', '', array('autocomplete'=>'on'));

if ($mform->is_cancelled()){
    //you need this section if you have a cancel button on your form
    //here you tell php what to do if your user presses cancel
    //probably a redirect is called for!
    // PLEASE NOTE: is_cancelled() should be called before get_data(), as this may return true
	
	//DO NOTHING. REDIRECT
	redirect($CFG->wwwroot . '/blocks/thelmsapp/courses.php');
	
} else if ($fromform=$mform->get_data()){
    //this branch is where you process validated data.
	
    $coursetext = new stdClass();
    $coursetext->id = $fromform->id;
    $coursetext->name = $fromform->optiontext_name;
    $coursetext->lang = $fromform->optiontext_lang;
    $coursetext->description = $fromform->optiontext_description['text'];
    $coursetext->icon = $fromform->optiontext_icon;
    
    $lastinsertid = $DB->update_record('block_thelmsapp_coursetext', $coursetext, false);
	
    echo $OUTPUT->header();
	echo $OUTPUT->box_start();
	echo html_writer::tag('div', '<font color="green">' . get_string('editcourse_success', 'block_thelmsapp'). '</font>', array('align' => 'center'));
	echo '<br/><div align="center">'.html_writer::link('/blocks/thelmsapp/courses.php', get_string('continue','block_thelmsapp')) . '</div>';
	echo $OUTPUT->box_end();
	echo $OUTPUT->footer();
	
} else {
    echo $OUTPUT->header();
    $mform->display();
    echo $OUTPUT->footer();

}

?>