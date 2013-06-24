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

class editcourse_lang_form extends moodleform {
    function definition() {
    
        global $USER, $CFG, $DB, $PAGE, $OUTPUT;
        $mform = $this->_form;
		
		$option_id   = required_param('id', PARAM_INT);
		$lang        = required_param('lang', PARAM_TEXT);
		$select_text = 'id = '. $option_id . ' AND lang =\'' . $lang . '\'';
			
		$optiontext_record = $DB->get_record_select('block_thelmsapp_coursetext', $select_text);
		
		$optiontext_lang              = $optiontext_record->lang;
		$optiontext_name              = $optiontext_record->name;
		$optiontext_description       = $optiontext_record->description;
		$optiontext_icon              = $optiontext_record->icon;
		
		
        $mform->addElement('header', '', get_string('editoption','block_thelmsapp'), '');
        
		$mform->addElement('hidden', 'id', $option_id);
		$mform->addElement('hidden', 'optiontext_lang', $optiontext_lang);
        
		//$mform->addElement('text', 'optiontext_lang', get_string('optiontext_lang','block_thelmsapp'), 'size="40"');
        //$mform->addRule('optiontext_lang', get_string('missingoptiontext_lang','block_thelmsapp'), 'required', null, 'server');
        //$mform->setDefault('optiontext_lang', $optiontext_lang);
		
		$mform->addElement('text', 'optiontext_name', get_string('optiontext_name','block_thelmsapp'), 'size="40"');
        $mform->addRule('optiontext_name', get_string('missingoptiontext_name','block_thelmsapp'), 'required', null, 'server');
        $mform->setDefault('optiontext_name', $optiontext_name);
        
		//$mform->addElement('textarea', 'optiontext_description', get_string('optiontext_description','block_thelmsapp'), '');
		//$mform->setDefault('optiontext_description', $optiontext_description);
        $attributes_optiontext_description = array('rows' => '25', 'cols' => '60');
        $mform->addElement('editor', 'optiontext_description', get_string('course_description','block_thelmsapp') , $attributes_optiontext_description)->setValue( array('text' => $optiontext_description));
        
		$mform->addElement('hidden', 'optiontext_icon', get_string('optiontext_icon','block_thelmsapp'), 'size="5"');
		$mform->setDefault('optiontext_icon', $optiontext_icon);
		
		$mform->addElement('hidden', 'lang', $lang);	
        
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        $buttonarray[] = &$mform->createElement('cancel');
    
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
    }
}
?>