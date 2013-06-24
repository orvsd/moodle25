<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Courses
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/lib/formslib.php');

class addcourse_form extends moodleform {
    function definition() {

        global $USER, $CFG, $DB, $PAGE, $OUTPUT;
        $mform = $this->_form;

        $mform->addElement('header', '', get_string('addcourse','block_thelmsapp'), '');

        //GET LIST OF AVAILABLE COURSE CATEGORIES
        $available_parents_array = array( 0 => get_string('noparent','block_thelmsapp'));
        $available_parents  = $DB->get_records_select('block_thelmsapp_coursecattxt','id>0 ORDER BY id DESC',array('DISTINCT optionid'));
        
        foreach ($available_parents as $available_parent) {
        
        	$available_parents_array[$available_parent->optionid] = $available_parent->name;
        }
        asort($available_parents_array);
        //GET LIST OF AVAILABLE COURSE CATEGORIES
        
        //FOR EACH PARENT FIND CORRECT ID
        $correctid_array = array();
        foreach ($available_parents_array as $key => $available_parents_arr) {
        
        	$correctid = $DB->get_record_select('block_thelmsapp_coursecattxt', 'optionid = '. $key . ' ORDER BY id ASC LIMIT 1');
        
        	if (count($correctid) == 1 && $correctid == TRUE)
        		$correctid_array[$key] = $correctid->id;
        
        }
        
        //FOR EACH PARENT FIND CORRECT ID
        
        $available_parents_correct_array = array(0 => get_string('noparent','block_thelmsapp'));
        foreach ($available_parents_array as $key => $available_parents_arr) {
        	if (array_key_exists($key, $correctid_array))
        		$available_parents_correct_array[$correctid_array[$key]] = $available_parents_arr;
        }
        
        //$available_parents_correct_array[-1] = get_string('all','block_thelmsapp');
        
        //FIND CATEGORY PARENT
          $GET_optionid = optional_param('optionid',0, PARAM_INT);
          if ($GET_optionid >0){
          	
          	  $courserecord = $DB->get_record_select('block_thelmsapp_course', ' id= '.$GET_optionid . ' LIMIT 1');        	  
          	  $correctid = $DB->get_record_select('block_thelmsapp_coursecattxt', 'id = '. $courserecord->categoryparent . ' ORDER BY id ASC LIMIT 1');
          	   	  
          	  $mform->addElement('select', 'option_categoryparent', get_string('categoryparent','block_thelmsapp'), $available_parents_correct_array);
          	  $mform->setDefault('option_categoryparent' , $correctid->id);
          	          	  
          }
          else
          	  $mform->addElement('select', 'option_categoryparent', get_string('categoryparent','block_thelmsapp'), $available_parents_correct_array);
        //FIND CATEGORY PARENT
        
        $mform->addElement('text', 'option_name', get_string('Help','block_thelmsapp'), 'size="40"');
        $mform->addRule('option_name', get_string('missingoptionname','block_thelmsapp'), 'required', null, 'server');
        
        $mform->addElement('text', 'optiontext_name', get_string('Name','block_thelmsapp'), 'size="40"');
        $mform->addRule('optiontext_name', get_string('missingoptiontextname','block_thelmsapp'), 'required', null, 'server');
        
        $mform->addElement('text', 'optiontext_code', get_string('code','block_thelmsapp'), 'size="10"');
        
        $mform->addElement('select', 'optiontext_lang', get_string('preferredlanguage','block_thelmsapp'), get_string_manager()->get_list_of_languages(true));
        $mform->setDefault('optiontext_lang', $CFG->lang);

        $attributes_optiontext_description = array('rows' => '25', 'cols' => '60');
        $mform->addElement('editor', 'optiontext_description', get_string('course_description','block_thelmsapp') , $attributes_optiontext_description);       
        
        $mform->addElement('text', 'optiontext_price', get_string('price','block_thelmsapp'), 'size="10"');
        
        $mform->addElement('hidden', 'optiontext_icon', get_string('Icon','block_thelmsapp'), 'size="10"');
		$mform->setDefault('optiontext_icon', 0);
        $mform->addRule('optiontext_icon', get_string('missingoptiontexticon','block_thelmsapp'), 'required', null, 'server');
		
        //IF OPTIONID PARAM IS PRESENT PASS HIDDEN VARIABLE
        	$optionid = optional_param('optionid', 0, PARAM_INT);
        	if ($optionid > 0)
        		$mform->addElement('hidden', 'optionid', $optionid);
        //END IF OPTIONID PARAM IS PRESENT PASS HIDDEN VARIABLE
        
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('submit_label','block_thelmsapp'));
        $buttonarray[] = &$mform->createElement('cancel');

        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
    }
}
?>