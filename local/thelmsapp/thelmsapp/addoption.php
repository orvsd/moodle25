<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Buttons
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once('addoption_form.php');

global $DB, $USER;

// Check for valid admin user - no guest autologin
require_login(0, false);
$context = get_context_instance(CONTEXT_SYSTEM);
require_capability('moodle/site:config', $context);

$PAGE->set_url('/blocks/thelmsapps/addoption.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$addoption_page = get_string('addoption','block_thelmsapp');

$PAGE->navbar->add($addoption_page);

$PAGE->set_title($addoption_page);
$PAGE->set_heading($SITE->fullname);


//GET CURRENT MAX POSITION
  $maxpos = $DB->get_record_select('block_thelmsapp_option', 'id> 0 ORDER BY position DESC LIMIT 1');
 
  if ($maxpos) 
	  $maxpos_val = $maxpos->position + 1;
  else
	  $maxpos_val = 0;
//GET CURRENT MAX POSITION


$mform = new addoption_form('', null, 'post', '', array('autocomplete'=>'on'));

if ($mform->is_cancelled()){
    
	//DO NOTHING. REDIRECT
    redirect($CFG->wwwroot . '/blocks/thelmsapp/options.php');
    
} else if ($fromform=$mform->get_data()){
    //this branch is where you process validated data.

	//INSERT RECORD IN OPTION TABLE
	  if (!property_exists($fromform, 'optionid')) {
    	
		  $option               = new stdClass();
    	  $option->name         = $fromform->option_name;
    	  $option->position     = $maxpos_val;
    	  $option->hidden       = 0;
		  if (!property_exists($fromform, 'is_coursebtn')) 
			  $option->is_coursebtn = 0;
		  else
			  $option->is_coursebtn = $fromform->is_coursebtn;
    
    	  $added = $DB->insert_record('block_thelmsapp_option', $option, true);
	  }
    //INSERT RECORD IN OPTION TABLE
    
	//FIRST CHECK IF LANG ALREADY EXISTS. IF YES THEN DONT INSERT TWICE
	  if (property_exists($fromform, 'optionid')) {
	
		  $option_exists = $DB->get_records_select('block_thelmsapp_optiontext', 'optionid = '. $fromform->optionid .' AND lang=\'' . $fromform->optiontext_lang . '\' LIMIT 1');
	
		  if (count($option_exists) == 1) {
	
			  echo $OUTPUT->header();
			  echo $OUTPUT->box_start();
			  echo html_writer::tag('div', '<font color="red">' . get_string('addoption_failure', 'block_thelmsapp'). '</font>', array('align' => 'center'));
			  echo '<br/><div align="center">'.html_writer::link('/blocks/thelmsapp/options.php', get_string('continue','block_thelmsapp')) . '</div>';
			  echo $OUTPUT->box_end();
			  echo $OUTPUT->footer();
			  exit;
		  }
	  }
	//FIRST CHECK IF LANG ALREADY EXISTS. IF YES THEN DONT INSERT TWICE
    
    //INSERT RECORD IN OPTIONTEXT TABLE
      $optiontext              = new stdClass();
    
      if (property_exists($fromform, 'optionid'))
    	  $optiontext->optionid    = $fromform->optionid;
      else
    	  $optiontext->optionid    = $added;
    
      $optiontext->name        = $fromform->optiontext_name;
      $optiontext->lang        = $fromform->optiontext_lang;
      $optiontext->description = $fromform->optiontext_description['text'];
      $optiontext->icon        = $fromform->optiontext_icon;
    
      $lastinsertid2 = $DB->insert_record('block_thelmsapp_optiontext', $optiontext, false);
    //INSERT RECORD IN OPTIONTEXT TABLE
    
    echo $OUTPUT->header();
    echo $OUTPUT->box_start();
    echo html_writer::tag('div', '<font color="green">' . get_string('addoption_success', 'block_thelmsapp'). '</font>', array('align' => 'center'));
    echo '<br/><div align="center">'.html_writer::link('/blocks/thelmsapp/options.php', get_string('continue','block_thelmsapp')) . '</div>';
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