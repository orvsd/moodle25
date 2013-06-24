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
require_once('addcoursecategory_form.php');

global $DB, $USER;

// Check for valid admin user - no guest autologin
require_login(0, false);
$context = get_context_instance(CONTEXT_SYSTEM);
require_capability('moodle/site:config', $context);

$PAGE->set_url('/blocks/thelmsapps/addcoursecategory.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$addcoursecategory_page = get_string('addcoursecategory','block_thelmsapp');

$PAGE->navbar->add($addcoursecategory_page);

$PAGE->set_title($addcoursecategory_page);
$PAGE->set_heading($SITE->fullname);

//GET CURRENT MAX POSITION
 // $maxpos = $DB->get_record_select('block_thelmsapp_coursecat', 'id> 0 ORDER BY position DESC LIMIT 1');
 // if (count($maxpos) == 1)
//	  $maxpos_val = $maxpos->position + 1;
 // else 
//	  $maxpos_val = 0;
//GET CURRENT MAX POSITION

$mform = new addcoursecategory_form('', null, 'post', '', array('autocomplete'=>'on'));

if ($mform->is_cancelled()){
	
    //DO NOTHING. REDIRECT
    redirect($CFG->wwwroot . '/blocks/thelmsapp/coursecategories.php');

} else if ($fromform=$mform->get_data()){
    //this branch is where you process validated data.

	//INSERT RECORD IN OPTION TABLE
	  if (!property_exists($fromform, 'optionid')) {
    		
		  $coursecategory           = new stdClass();
    	  $coursecategory ->name    = $fromform->coursecategory_name;
    	  $coursecategory ->cparent = $fromform->coursecategory_parent;
    	  $coursecategory ->hidden  = 0;
    
    	  $added = $DB->insert_record('block_thelmsapp_coursecat', $coursecategory, true);
	  }
    //INSERT RECORD IN OPTION TABLE
    
    //FIRST CHECK IF LANG ALREADY EXISTS. IF YES THEN DONT INSERT TWICE
	  if (property_exists($fromform, 'optionid')) {
		
		  $lang_exists = $DB->get_records_select('block_thelmsapp_coursecattxt', 'optionid = '. $fromform->optionid .' AND lang=\'' . $fromform->coursecategorytext_lang . '\' LIMIT 1');
		
		  if (count($lang_exists) == 1) {
			
			  echo $OUTPUT->header();
			  echo $OUTPUT->box_start();
			  echo html_writer::tag('div', '<font color="red">' . get_string('addcourse_failure', 'block_thelmsapp'). '</font>', array('align' => 'center'));
			  echo '<br/><div align="center">'.html_writer::link('/blocks/thelmsapp/coursecategories.php', get_string('continue','block_thelmsapp')) . '</div>';
			  echo $OUTPUT->box_end();
			  echo $OUTPUT->footer();
			  exit;
		  }
	  }
	//FIRST CHECK IF LANG ALREADY EXISTS. IF YES THEN DONT INSERT TWICE
	
      //INSERT RECORD IN OPTIONTEXT TABLE
        $coursecategory_text         = new stdClass();
    
        if (property_exists($fromform, 'optionid'))
    	    $coursecategory_text->optionid    = $fromform->optionid;
        else
    	    $coursecategory_text->optionid    = $added;
    
        $coursecategory_text->name        = $fromform->coursecategorytext_name;
        $coursecategory_text->lang        = $fromform->coursecategorytext_lang;
        $coursecategory_text->description = $fromform->coursecategorytext_description['text'];
        $coursecategory_text->icon        = $fromform->coursecategorytext_icon;
    
        $lastinsertid2 = $DB->insert_record('block_thelmsapp_coursecattxt', $coursecategory_text, false);
      //INSERT RECORD IN OPTIONTEXT TABLE
    
    echo $OUTPUT->header();
    echo $OUTPUT->box_start();
    echo html_writer::tag('div', '<font color="green">' . get_string('addcoursecategory_success', 'block_thelmsapp'). '</font>', array('align' => 'center'));
    echo '<br/><div align="center">'.html_writer::link('/blocks/thelmsapp/coursecategories.php', get_string('continue','block_thelmsapp')) . '</div>';
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