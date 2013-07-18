<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Newsletter
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
		
		$employee_id = required_param('id', PARAM_INT);
		$select = 'id = '. $employee_id;
		$employee_record = $DB->get_records_select('block_skills_employees', $select);

		$employee_name                = $employee_record[$employee_id]->name;
		$employee_surname             = $employee_record[$employee_id]->surname;
		$employee_age                 = $employee_record[$employee_id]->age;
		$employee_jobid               = $employee_record[$employee_id]->jobid;
		$employee_sectorid            = $employee_record[$employee_id]->sectorid;
		$employee_relationshipstatus  = $employee_record[$employee_id]->relationship_status;
		$employee_workstatus          = $employee_record[$employee_id]->work_status;
		
        $mform->addElement('header', '', get_string('editemployee','block_skills_gap_analysis'), '');
        
		$mform->addElement('hidden', 'id', $employee_id);
		
        $mform->addElement('text', 'employee_surname', get_string('employee_surname','block_skills_gap_analysis'), 'size="40"');
        $mform->addRule('employee_surname', get_string('missingemployee_surname','block_skills_gap_analysis'), 'required', null, 'server');
        $mform->setDefault('employee_surname', $employee_surname);
		
		$mform->addElement('text', 'employee_name', get_string('employee_name','block_skills_gap_analysis'), 'size="40"');
        $mform->addRule('employee_name', get_string('missingemployee_name','block_skills_gap_analysis'), 'required', null, 'server');
        $mform->setDefault('employee_name', $employee_name);
		
		$mform->addElement('text', 'employee_name', get_string('employee_name','block_skills_gap_analysis'), 'size="40"');
        $mform->addRule('employee_name', get_string('missingemployee_name','block_skills_gap_analysis'), 'required', null, 'server');
		
		$mform->addElement('select', 'employee_gender', get_string('employee_gender','block_skills_gap_analysis'), array(-1 => get_string('choose', 'block_skills_gap_analysis'), 0 => get_string('male', 'block_skills_gap_analysis'), 1 => get_string('female', 'block_skills_gap_analysis'))); 
		$mform->addElement('text', 'employee_age', get_string('employee_age','block_skills_gap_analysis'), 'size="5"');
		$mform->setDefault('employee_age', $employee_age);
		
		$relationship_status = array(get_string('choose','block_skills_gap_analysis') => get_string('choose','block_skills_gap_analysis'), 'Άγαμος' => 'Άγαμος', 'Έγγαμος' => 'Έγγαμός');
		$mform->addElement('select', 'employee_relationshipstatus', get_string('employee_relationshipstatus','block_skills_gap_analysis'), $relationship_status);
		$mform->setDefault('employee_relationshipstatus', $employee_relationshipstatus);
		
		$work_status = array(get_string('choose','block_skills_gap_analysis') => get_string('choose','block_skills_gap_analysis'), 'Πλήρης Απασχόληση' => 'Πλήρης Απασχόληση', 'Μερική Απασχόληση' => 'Μερική Απασχόληση', 'Σύμβαση Έργου' => 'Σύμβαση Έργου');
		$mform->addElement('select', 'employee_workstatus', get_string('employee_workstatus','block_skills_gap_analysis'), $work_status);
		$mform->setDefault('employee_workstatus', $employee_workstatus);
		
		$jobs_records = $DB->get_records_select('block_skills_jobs' , 'id > 0');
		
		$jobs_options = array("-" => get_string('choose','block_skills_gap_analysis'));
		foreach ($jobs_records as $jobs_record) {
				 $jobs_options[$jobs_record->id] = $jobs_record->title;
		}
		
		$mform->addElement('select', 'employee_jobid', get_string('employee_jobid','block_skills_gap_analysis'), $jobs_options);
		$mform->addRule('employee_jobid', get_string('missingemployee_sectorid','block_skills_gap_analysis'), 'required', null, 'server');
        $mform->setDefault('employee_jobid', $employee_jobid);
		
		$sectors_records = $DB->get_records_select('block_skills_sectors' , 'id > 0');
		
		$sectors_options = array("-" => get_string('choose','block_skills_gap_analysis'));
		foreach ($sectors_records as $sectors_record) {
				 $sectors_options[$sectors_record->id] = $sectors_record->title;
		}
		
		$mform->addElement('select', 'employee_sectorid', get_string('employee_sectorid','block_skills_gap_analysis'), $sectors_options);
        $mform->addRule('employee_sectorid', get_string('missingemployee_sectorid','block_skills_gap_analysis'), 'required', null, 'server');
		$mform->setDefault('employee_sectorid', $employee_sectorid);
        
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        $buttonarray[] = &$mform->createElement('cancel');
    
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
    }
}
?>