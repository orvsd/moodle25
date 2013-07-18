<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Courses
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/lib/formslib.php');

class editcourse_form extends moodleform {
    function definition() {
    
        global $USER, $CFG, $DB, $PAGE, $OUTPUT;
        $mform = $this->_form;
		
        $option_id = $this->_customdata['id'];
        $lang      = $this->_customdata['lang'];
		//$option_id   = required_param('id', PARAM_INT);
		//$lang        = required_param('lang', PARAM_TEXT);
		$select_text = 'optionid = '. $option_id . ' AND lang =\'' . $lang . '\'';

		$option_record     = $DB->get_record_select('block_thelmsapp_course', ' id= '.$option_id . ' LIMIT 1');
		$optiontext_record = $DB->get_record_select('block_thelmsapp_coursetext', $select_text . ' LIMIT 1');
		
		$optiontext_optionid          = $optiontext_record->optionid;
		$optiontext_lang              = $optiontext_record->lang;
		$optiontext_name              = $optiontext_record->name;
		$optiontext_description       = $optiontext_record->description;
		$optiontext_code              = $optiontext_record->code;
		$optiontext_price             = $optiontext_record->price;
		$optiontext_icon              = $optiontext_record->icon;
		$option_categoryparent        = $option_record->categoryparent;
		
        $mform->addElement('header', '', get_string('editoption','block_thelmsapp'), '');
        
        $mform->addElement('hidden', 'id', $option_id);
		$mform->addElement('hidden', 'textid', $optiontext_record->id);
		$mform->addElement('hidden', 'optiontext_lang', $optiontext_lang);
		$mform->addElement('hidden', 'optiontext_optionid', $optiontext_optionid);
		
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
        
        $mform->addElement('select', 'option_categoryparent', get_string('categoryparent','block_thelmsapp'), $available_parents_correct_array);
        $mform->setDefault('option_categoryparent', $option_categoryparent );
        
		$mform->addElement('text', 'optiontext_name', get_string('optiontext_name','block_thelmsapp'), 'size="40"');
        $mform->addRule('optiontext_name', get_string('missingoptiontext_name','block_thelmsapp'), 'required', null, 'server');
        $mform->setDefault('optiontext_name', $optiontext_name);
        
        $mform->addElement('text', 'optiontext_code', get_string('code','block_thelmsapp'), 'size="10"');
        $mform->setDefault('optiontext_code', $optiontext_code);
        
		//$mform->addElement('textarea', 'optiontext_description', get_string('optiontext_description','block_thelmsapp'), '');
		//$mform->setDefault('optiontext_description', $optiontext_description);
		
		$attributes_optiontext_description = array('rows' => '25', 'cols' => '60');
		$mform->addElement('editor', 'optiontext_description', get_string('course_description','block_thelmsapp') , $attributes_optiontext_description)->setValue( array('text' => $optiontext_description));
		
		$mform->addElement('text', 'optiontext_price', get_string('price','block_thelmsapp'), 'size="10"');
		$mform->setDefault('optiontext_price', $optiontext_price);
		
		$mform->addElement('hidden', 'optiontext_icon', get_string('optiontext_icon','block_thelmsapp'), 'size="5"');
		$mform->setDefault('optiontext_icon', $optiontext_icon);
		
		$mform->addElement('hidden', 'lang', $lang);	
        
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        $buttonarray[] = &$mform->createElement('cancel');
    
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
    }
}
?>