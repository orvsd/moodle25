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

class addcoursecategory_form extends moodleform {
    function definition() {

        global $USER, $CFG, $DB, $PAGE, $OUTPUT;
        $mform = $this->_form;

        $mform->addElement('header', '', get_string('addcoursecategory','block_thelmsapp'), '');

        //GET LIST OF AVAILABLE COURSE CATEGORIES
          $available_parents_array = array( 0 => get_string('noparent','block_thelmsapp'));
          $available_parents  = $DB->get_records_select('block_thelmsapp_coursecattxt','id>0 ORDER BY id DESC',array('DISTINCT optionid'));
               
          foreach ($available_parents as $available_parent) {
          	      
          	       $available_parents_array[$available_parent->optionid] = $available_parent->name;
          }
          asort($available_parents_array);
          
        //GET LIST OF AVAILABLE COURSE CATEGORIES
        $mform->addElement('select', 'coursecategory_parent', get_string('coursecategoryparent','block_thelmsapp'), $available_parents_array );
        //IF PARENT GET PARAMETER IS PRESENT SET DEFAULT
        $GET_parent = optional_param('parent', 0, PARAM_INT);
        if ($GET_parent > 0) {
        	$mform->setDefault('coursecategory_parent', $GET_parent);
        }
        //IF PARENT GET PARAMETER IS PRESENT SET DEFAULT
        
        $mform->addElement('text', 'coursecategory_name', get_string('Help','block_thelmsapp'), 'size="40"');
        $mform->addRule('coursecategory_name', get_string('missingcoursecategoryname','block_thelmsapp'), 'required', null, 'server');
        
        $mform->addElement('text', 'coursecategorytext_name', get_string('Name','block_thelmsapp'), 'size="40"');
        $mform->addRule('coursecategorytext_name', get_string('missingcoursecategorytextname','block_thelmsapp'), 'required', null, 'server');
        
        $mform->addElement('select', 'coursecategorytext_lang', get_string('preferredlanguage','block_thelmsapp'), get_string_manager()->get_list_of_languages(true));
        $mform->setDefault('coursecategorytext_lang', $CFG->lang);

        $attributes_optiontext_description = array('rows' => '25', 'cols' => '60');
        $mform->addElement('editor', 'coursecategorytext_description', get_string('coursecategorytext_description','block_thelmsapp') , $attributes_optiontext_description);       
        
		//NOT CURRENTLY USED, BUT IN THE FUTURE WE COULD ASSOCIATE AN ICON WITH A CATEGORY
          $mform->addElement('hidden', 'coursecategorytext_icon', get_string('Icon','block_thelmsapp'), 'size="10"');
		  $mform->setDefault('coursecategorytext_icon', 1);
          $mform->addRule('coursecategorytext_icon', get_string('missingcoursecategorytexticon','block_thelmsapp'), 'required', null, 'server');
        //NOT CURRENTLY USED, BUT IN THE FUTURE WE COULD ASSOCIATE AN ICON WITH A CATEGORY
		
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