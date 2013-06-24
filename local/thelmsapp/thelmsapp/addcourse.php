<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Courses
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once('addcourse_form.php');

global $DB, $USER;

// Check for valid admin user - no guest autologin
require_login(0, false);
$context = get_context_instance(CONTEXT_SYSTEM);
require_capability('moodle/site:config', $context);

$PAGE->set_url('/blocks/thelmsapps/addcourse.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$addcourse_page = get_string('addcourse','block_thelmsapp');

$PAGE->navbar->add($addcourse_page);

$PAGE->set_title($addcourse_page);
$PAGE->set_heading($SITE->fullname);

$mform = new addcourse_form('', null, 'post', '', array('autocomplete'=>'on'));

if ($mform->is_cancelled()){
	
    //DO NOTHING. REDIRECT
    redirect($CFG->wwwroot . '/blocks/thelmsapp/courses.php');

} else if ($fromform=$mform->get_data()){
    //this branch is where you process validated data.

	//GET MAX POSITION IN CURRENT LEVEL
	$maxpos = $DB->get_record_select('block_thelmsapp_course', 'id > 0 AND categoryparent = '. $fromform->option_categoryparent . ' ORDER BY position DESC LIMIT 1');
	if (count($maxpos) == 1)
		$maxpos_val = $maxpos->position + 1;
	else
		$maxpos_val = 0;
	//GET MAX POSITION IN CURRENT LEVEL
	
	//INSERT RECORD IN OPTION TABLE
	  if (!property_exists($fromform, 'optionid')) {
    		
		  $course                 = new stdClass();
    	  $course->name           = $fromform->option_name;
    	  $course->position       = $maxpos_val;
    	  $course->categoryparent = $fromform->option_categoryparent;
    	  $course->hidden         = 0;
    
    	  $added = $DB->insert_record('block_thelmsapp_course', $course, true);
	  }
    //INSERT RECORD IN OPTION TABLE
    
    //FIRST CHECK IF LANG ALREADY EXISTS. IF YES THEN DONT INSERT TWICE
	  if (property_exists($fromform, 'optionid')) {
		
		  $lang_exists = $DB->get_records_select('block_thelmsapp_coursetext', 'optionid = '. $fromform->optionid .' AND lang=\'' . $fromform->optiontext_lang . '\' LIMIT 1');
		
		  if (count($lang_exists) == 1) {
			
			  echo $OUTPUT->header();
			  echo $OUTPUT->box_start();
			  echo html_writer::tag('div', '<font color="red">' . get_string('addcourse_failure', 'block_thelmsapp'). '</font>', array('align' => 'center'));
			  echo '<br/><div align="center">'.html_writer::link('/blocks/thelmsapp/courses.php', get_string('continue','block_thelmsapp')) . '</div>';
			  echo $OUTPUT->box_end();
			  echo $OUTPUT->footer();
			  exit;
		  }
	  }
	//FIRST CHECK IF LANG ALREADY EXISTS. IF YES THEN DONT INSERT TWICE
	
      //INSERT RECORD IN OPTIONTEXT TABLE
        $coursetext              = new stdClass();
    
        if (property_exists($fromform, 'optionid'))
    	    $coursetext->optionid    = $fromform->optionid;
        else
    	    $coursetext->optionid    = $added;
    
		$coursetext->code        = $fromform->optiontext_code;
        $coursetext->name        = $fromform->optiontext_name;
        $coursetext->lang        = $fromform->optiontext_lang;
        $coursetext->description = $fromform->optiontext_description['text'];
		$coursetext->price       = $fromform->optiontext_price;
        $coursetext->icon        = $fromform->optiontext_icon;
    
        $lastinsertid2 = $DB->insert_record('block_thelmsapp_coursetext', $coursetext, false);
      //INSERT RECORD IN OPTIONTEXT TABLE
    
    echo $OUTPUT->header();
    echo $OUTPUT->box_start();
    echo html_writer::tag('div', '<font color="green">' . get_string('addcourse_success', 'block_thelmsapp'). '</font>', array('align' => 'center'));
    echo '<br/><div align="center">'.html_writer::link('/blocks/thelmsapp/courses.php', get_string('continue','block_thelmsapp')) . '</div>';
    echo $OUTPUT->box_end();
    echo $OUTPUT->footer();
    
} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.
    echo $OUTPUT->header();
    $mform->display();
    echo $OUTPUT->footer();
}

?>