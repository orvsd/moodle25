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

class editcoursecategory_form extends moodleform {
    function definition() {
    
        global $USER, $CFG, $DB, $PAGE, $OUTPUT;
        $mform = $this->_form;
		
		$option_id   = required_param('id', PARAM_INT);
		$lang        = required_param('lang', PARAM_TEXT);
		$select      = 'id = '. $option_id;
		$select_text = 'optionid = '. $option_id . ' AND lang =\'' . $lang . '\'';
		
		$coursecategory_record     = $DB->get_records_select('block_thelmsapp_coursecat', $select);	
		$coursecategorytext_record = $DB->get_record_select('block_thelmsapp_coursecattxt', $select_text);
				
		$coursecategory_name                  = $coursecategory_record[$option_id]->name;
		$coursecategorytext_lang              = $coursecategorytext_record->lang;
		$coursecategorytext_name              = $coursecategorytext_record->name;
		$coursecategorytext_description       = $coursecategorytext_record->description;
		$coursecategorytext_icon              = $coursecategorytext_record->icon;
		$coursecategorytext_parent            = $coursecategory_record[$option_id]->cparent;
				
        $mform->addElement('header', '', get_string('editcoursecategory','block_thelmsapp'), '');
        
		$mform->addElement('hidden', 'id', $option_id);

		 //GET LIST OF AVAILABLE COURSE CATEGORIES
          $available_parents_array = array( 0 => get_string('noparent','block_thelmsapp'));
          $available_parents  = $DB->get_records_select('block_thelmsapp_coursecattxt','id>0 ORDER BY id DESC',array('DISTINCT optionid'));
            
          foreach ($available_parents as $available_parent) {
          	      
          	       $available_parents_array[$available_parent->optionid] = $available_parent->name;
          }
          asort($available_parents_array);
        //GET LIST OF AVAILABLE COURSE CATEGORIES
        $mform->addElement('select', 'coursecategory_parent', get_string('coursecategoryparent','block_thelmsapp'), $available_parents_array );
        $mform->setDefault('coursecategory_parent', $coursecategorytext_parent);
        
        $mform->addElement('text', 'coursecategory_name', get_string('coursecategoryhelp','block_thelmsapp'), 'size="40"');
        $mform->addRule('coursecategory_name', get_string('missingcoursecategoryname','block_thelmsapp'), 'required', null, 'server'); 
        $mform->setDefault('coursecategory_name', $coursecategory_name);
		
		$mform->addElement('text', 'coursecategorytext_name', get_string('coursecategorytextname','block_thelmsapp'), 'size="40"');
        $mform->addRule('coursecategorytext_name', get_string('missingcoursecategorytextname','block_thelmsapp'), 'required', null, 'server');
        $mform->setDefault('coursecategorytext_name', $coursecategorytext_name);
        
		$attributes_coursecategorytext_description = array('rows' => '25', 'cols' => '60');
		$mform->addElement('editor', 'coursecategorytext_description', get_string('optiontext_description','block_thelmsapp'), null, $attributes_coursecategorytext_description)->setValue( array('text' => $coursecategorytext_description));
		
		$mform->addElement('hidden', 'coursecategorytext_icon', get_string('coursecategorytext_icon','block_thelmsapp'), 'size="5"');
		$mform->setDefault('coursecategorytext_icon', $coursecategorytext_icon);
		
		$mform->addElement('hidden', 'coursecategorytext_optionid', $coursecategorytext_record->optionid);
		$mform->addElement('hidden', 'lang', $lang);
		$mform->addElement('hidden', 'optiontext_id', $coursecategorytext_record->id);
		$mform->addElement('hidden', 'coursecategorytext_id', $coursecategorytext_record->id);
        
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        $buttonarray[] = &$mform->createElement('cancel');
    
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
    }
}
?>