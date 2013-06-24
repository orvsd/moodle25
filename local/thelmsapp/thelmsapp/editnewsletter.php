<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Newsletter
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once('editemployee_form.php');

global $DB, $USER;

$PAGE->set_url('/thelmsapp/editoption.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$mform = new editoption_form('', null, 'post', '', array('autocomplete'=>'on'));

if ($mform->is_cancelled()){
    //you need this section if you have a cancel button on your form
    //here you tell php what to do if your user presses cancel
    //probably a redirect is called for!
    // PLEASE NOTE: is_cancelled() should be called before get_data(), as this may return true
	
	//DO NOTHING. REDIRECT
	redirect($CFG->wwwroot . '/blocks/skills_gap_analysis/employees.php');
	
} else if ($fromform=$mform->get_data()){
    //this branch is where you process validated data.

	$employee = new stdClass();
	$employee->id = $fromform->id;
    $employee->surname = $fromform->employee_surname;
	$employee->name = $fromform->employee_name;
	$employee->gender = $fromform->employee_gender;
	$employee->age = $fromform->employee_age;
    $employee->relationship_status = $fromform->employee_relationshipstatus;
	$employee->work_status = $fromform->employee_workstatus;
	$employee->jobid = $fromform->employee_jobid;
	$employee->sectorid = $fromform->employee_sectorid;
    
    $lastinsertid = $DB->update_record('block_skills_employees', $employee, false);
	
	echo $OUTPUT->box_start();
	echo html_writer::tag('div', '<font color="green">' . get_string('editemployee_success', 'block_skills_gap_analysis'). '</font>', array('align' => 'center'));
	echo '<br/><div align="center">'.html_writer::link('/blocks/skills_gap_analysis/employees.php', get_string('continue','block_skills_gap_analysis')) . '</div>';
	echo $OUTPUT->box_end();
	
} else {
    echo $OUTPUT->header();
    /*print_header_simple($streditinga, '',
            "<a href=\"$CFG->wwwroot/mod/$module->name/index.php?id=$course->id\">$strmodulenameplural</a> ->
            $strnav $streditinga", $mform->focus(), "", false);*/
    //notice use of $mform->focus() above which puts the cursor
    //in the first form field or the first field with an error.

    //call to print_heading_with_help or print_heading? then :

    //put data you want to fill out in the form into array $toform here then :

    //$mform->set_data($toform);
    $mform->display();
    echo $OUTPUT->footer();

}

?>