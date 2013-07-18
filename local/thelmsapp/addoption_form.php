<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Options
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/lib/formslib.php');

class addoption_form extends moodleform {
    function definition() {

        global $USER, $CFG, $DB, $PAGE, $OUTPUT;
        $mform = $this->_form;

        $mform->addElement('header', '', get_string('addoption','block_thelmsapp'), '');
		       
		$mform->addElement('text', 'option_name', get_string('Help','block_thelmsapp'), 'size="40"');
        $mform->addRule('option_name', get_string('missingoptionname','block_thelmsapp'), 'required', null, 'server');
        	
        $mform->addElement('text', 'optiontext_name', get_string('Name','block_thelmsapp'), 'size="10", maxlength="10"');
        $mform->addRule('optiontext_name', get_string('missingoptiontextname','block_thelmsapp'), 'required', null, 'server');
		$mform->addRule('optiontext_name', get_string('missingoptiontextname','block_thelmsapp'), 'required', null, 'server');
		$mform->addHelpButton('optiontext_name', 'optiontextname', 'block_thelmsapp');
		
        $mform->addElement('select', 'optiontext_lang', get_string('preferredlanguage','block_thelmsapp'), get_string_manager()->get_list_of_languages(true));
        $mform->setDefault('optiontext_lang', $CFG->lang);

        $attributes_optiontext_description = array('rows' => '25', 'cols' => '60');
        $mform->addElement('editor', 'optiontext_description', get_string('task_description','block_thelmsapp') , $attributes_optiontext_description);
        
        $mform->addElement('text', 'optiontext_icon', get_string('Icon','block_thelmsapp'), 'size="10"');
        $mform->addRule('optiontext_icon', get_string('missingoptiontexticon','block_thelmsapp'), 'required', null, 'server');
        
        $mform->addElement('checkbox', 'is_coursebtn', null, '&nbsp;'.get_string('is_coursebtn', 'block_thelmsapp'),'onClick=""');
        
        $mform->addElement('html', '<div id="fitem_id_optiontext_icon" class="fitem required fitem_ftext"><div class="felement ftext"><table><tr><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'0\'; return false;"><img src="assets/0_0.png"/></a><br/>0</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'1\'; return false;"><img src="assets/1_0.png"/></a><br/>1</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'2\'; return false;"><img src="assets/2_0.png"/></a><br/>2</td>');
        $mform->addElement('html', '<td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'3\'; return false;"><img src="assets/3_0.png" /></a><br/>3</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'4\'; return false;"><img src="assets/4_0.png" /></a><br/>4</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'5\'; return false;"><img src="assets/5_0.png"/></a><br/>5</td></tr>');
        $mform->addElement('html', '<tr><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'6\'; return false;"><img src="assets/6_0.png" /></a><br/>6</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'7\'; return false;"><img src="assets/7_0.png" /></a><br/>7</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'8\'; return false;"><img src="assets/8_0.png" /></a><br/>8</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'9\'; return false;"><img src="assets/9_0.png" /></a><br/>9</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'10\'; return false;"><img src="assets/10_0.png"/></a><br/>10</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'11\'; return false;"><img src="assets/11_0.png"/></a><br/>11</td></tr></table></div></div>');
        
        
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