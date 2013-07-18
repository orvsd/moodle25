<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage CourseCategories
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/lib/formslib.php');

class editcoursecategory_lang_form extends moodleform {
    function definition() {
    
        global $USER, $CFG, $DB, $PAGE, $OUTPUT;
        $mform = $this->_form;
		
		$option_id   = required_param('id', PARAM_INT);
		$lang        = required_param('lang', PARAM_TEXT);
		$select_text = 'id = '. $option_id . ' AND lang =\'' . $lang . '\'';
			
		$coursecategorytext_record = $DB->get_record_select('block_thelmsapp_coursecattxt', $select_text);
		
		$coursecategorytext_lang              = $coursecategorytext_record->lang;
		$coursecategorytext_name              = $coursecategorytext_record->name;
		$coursecategorytext_description       = $coursecategorytext_record->description;
		$coursecategorytext_icon              = $coursecategorytext_record->icon;
		
		
        $mform->addElement('header', '', get_string('editcoursecategory','block_thelmsapp'), '');
        
		$mform->addElement('hidden', 'id', $option_id);
		$mform->addElement('hidden', 'coursecategorytext_lang', $coursecategorytext_lang);
        
		
		$mform->addElement('text', 'coursecategorytext_name', get_string('coursecategorytext_name','block_thelmsapp'), 'size="40"');
        $mform->addRule('coursecategorytext_name', get_string('missingcoursecategorytextname','block_thelmsapp'), 'required', null, 'server');
        $mform->setDefault('coursecategorytext_name', $coursecategorytext_name);
        
        $attributes_coursecategorytext_description = array('rows' => '25', 'cols' => '60');
        $mform->addElement('editor', 'coursecategorytext_description', get_string('course_description','block_thelmsapp') , $attributes_coursecategorytext_description)->setValue( array('text' => $coursecategorytext_description));
        
		$mform->addElement('text', 'coursecategorytext_icon', get_string('coursecategorytext_icon','block_thelmsapp'), 'size="5"');
		$mform->setDefault('coursecategorytext_icon', $coursecategorytext_icon);
		
		$mform->addElement('hidden', 'lang', $lang);	
        
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        $buttonarray[] = &$mform->createElement('cancel');
    
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
    }
}
?>