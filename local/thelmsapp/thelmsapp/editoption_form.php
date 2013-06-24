<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Buttons
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/lib/formslib.php');

class editoption_form extends moodleform {
    function definition() {
    
        global $USER, $CFG, $DB, $PAGE, $OUTPUT;
        $mform = $this->_form;
		
		$option_id   = required_param('id', PARAM_INT);
		$lang        = required_param('lang', PARAM_TEXT);
		$select      = 'id = '. $option_id;
		$select_text = 'optionid = '. $option_id . ' AND lang =\'' . $lang . '\'';
		
		$option_record     = $DB->get_records_select('block_thelmsapp_option', $select);	
		$optiontext_record = $DB->get_record_select('block_thelmsapp_optiontext', $select_text);
		
		
		$option_name                  = $option_record[$option_id]->name;
		$option_iscoursebtn           = $option_record[$option_id]->is_coursebtn;
		$optiontext_lang              = $optiontext_record->lang;
		$optiontext_name              = $optiontext_record->name;
		$optiontext_description       = $optiontext_record->description;
		$optiontext_icon              = $optiontext_record->icon;
		
		
        $mform->addElement('header', '', get_string('editoption','block_thelmsapp'), '');
        
		$mform->addElement('hidden', 'id', $option_id);
		
		
        $mform->addElement('text', 'option_name', get_string('Help','block_thelmsapp'), 'size="40"');
        $mform->addRule('option_name', get_string('missingoption_name','block_thelmsapp'), 'required', null, 'server'); 
        $mform->setDefault('option_name', $option_name);
        
		$mform->addElement('text', 'optiontext_lang', get_string('optiontext_lang','block_thelmsapp'), 'size="40"');
        $mform->addRule('optiontext_lang', get_string('missingoptiontext_lang','block_thelmsapp'), 'required', null, 'server');
        $mform->setDefault('optiontext_lang', $optiontext_lang);
		
		$mform->addElement('text', 'optiontext_name', get_string('optiontext_name','block_thelmsapp'), 'size="10", maxlength="10"');
        $mform->addRule('optiontext_name', get_string('missingoptiontext_name','block_thelmsapp'), 'required', null, 'server');
		$mform->addHelpButton('optiontext_name', 'optiontextname', 'block_thelmsapp');
        $mform->setDefault('optiontext_name', $optiontext_name);
        
		//$mform->addElement('textarea', 'optiontext_description', get_string('optiontext_description','block_thelmsapp'), '');
		//$mform->setDefault('optiontext_description', $optiontext_description);
		
		$attributes_optiontext_description = array('rows' => '25', 'cols' => '60');
		$mform->addElement('editor', 'optiontext_description', get_string('optiontext_description','block_thelmsapp'), null, $attributes_optiontext_description)->setValue( array('text' => $optiontext_description));
		
		$mform->addElement('text', 'optiontext_icon', get_string('optiontext_icon','block_thelmsapp'), 'size="5"');
		$mform->setDefault('optiontext_icon', $optiontext_icon);
		
		$mform->addElement('checkbox', 'is_coursebtn', null, '&nbsp;'.get_string('is_coursebtn', 'block_thelmsapp'),'onClick=""');
		$mform->setDefault('is_coursebtn', $option_iscoursebtn);
		
		
        $mform->addElement('html', '<div id="fitem_id_optiontext_icon" class="fitem required fitem_ftext"><div class="felement ftext"><table><tr><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'0\';"><img src="assets/0_0.png"/></a><br/>0</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'1\';"><img src="assets/1_0.png"/></a><br/>1</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'2\';"><img src="assets/2_0.png"/></a><br/>2</td>');
        $mform->addElement('html', '<td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'3\';"><img src="assets/3_0.png"/></a><br/>3</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'4\';"><img src="assets/4_0.png"/></a><br/>4</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'5\';"><img src="assets/5_0.png"/></a><br/>5</td></tr>');
        $mform->addElement('html', '<tr><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'6\';"><img src="assets/6_0.png"/></a><br/>6</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'7\';"><img src="assets/7_0.png"/></a><br/>7</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'8\';"><img src="assets/8_0.png"/></a><br/>8</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'9\';"><img src="assets/9_0.png"/></a><br/>9</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'10\';"><img src="assets/10_0.png"/></a><br/>10</td><td align="center"><a href="#" onClick="javascript: document.getElementById(\'id_optiontext_icon\').value=\'11\';"><img src="assets/11_0.png"/></a><br/>11</td></tr></table></div></div>');
        
		
		$mform->addElement('hidden', 'optiontext_optionid', $optiontext_record->optionid);
		$mform->addElement('hidden', 'lang', $lang);
		$mform->addElement('hidden', 'optiontext_id', $optiontext_record->id);
	
        
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        $buttonarray[] = &$mform->createElement('cancel');
    
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
    }
}
?>