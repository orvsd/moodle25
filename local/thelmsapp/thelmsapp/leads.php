<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Leads
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

// Check for valid admin user - no guest autologin
require_login(0, false);
$context = get_context_instance(CONTEXT_SYSTEM);
require_capability('moodle/site:config', $context);

//INCLUDE NECESSARY JAVASCRIPT FOR POPUS
  $PAGE->requires->js('/blocks/thelmsapp/javascript/jquery.min.js',true);
  $PAGE->requires->js('/blocks/thelmsapp/javascript/dialog.js',true);
  $PAGE->requires->css('/blocks/thelmsapp/javascript/dialog.css',true);
//INCLUDE NECESSARY JAVASCRIPT FOR POPUS

$PAGE->set_url('/blocks/thelmsapp/leads.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$leads_page = get_string('leads','block_thelmsapp');

$PAGE->navbar->add($leads_page);

$PAGE->set_title($leads_page);
$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();

echo '<table width="100%"><tr><td><div style="width: 140px;"></div></td><td width="100%">';

//PRINT ADD LINK
$content = '<fieldset><div align="center">'.get_string('leads_currentsubscribers','block_thelmsapp') . '</div></fieldset><br/>';
echo $content;
//PRINT ADD LINK

echo '</td><td>';
//PRINT LOGO
echo '<a href="http://www.thelmsapp.com/"><img src="assets/thelmsapp_logo.png" width="140" align="right" valign="middle" /></a>';
//PRINT LOGO
echo '</td></tr></table>';

//START LIST OF CURRENT SUBSCRIBERS
$leads     = $DB->get_records_select('block_thelmsapp_leads','id > 0');

if (count($leads) == 0) {
    echo html_writer::tag('div', '<font color="red">' . get_string('leadsnull', 'block_thelmsapp'). '</font><br/><br/>', array('align' => 'center'));
}else {
 
    $table = new html_table();
    $table->attributes['border'] = '1';
    $table->width = '100%';
    $table->headspan = array(-2,1);
    $table->align = array('center', 'center', 'center', 'center', 'center', 'left');
    $table->head = array(get_string('id','block_thelmsapp'), get_string('Surname','block_thelmsapp'), get_string('Name','block_thelmsapp'), get_string('Email','block_thelmsapp'), get_string('interestedin','block_thelmsapp'), get_string('Actions','block_thelmsapp'));
    
    foreach ($leads as $lead) {

        $row = array();
        $row[] = $lead->id;
        $row[] = $lead->surname;
        $row[] = $lead->name;
        $row[] = $lead->email;
        
        //FETCH INTERESTED IN COURSE FIELD
        if ($lead->interestedin != NULL) {
        	$interestedin_coursetext = $DB->get_record_select('block_thelmsapp_coursetext', 'optionid =' .substr($lead->interestedin,1) . ' LIMIT 1');
        	$row[] = $interestedin_coursetext->name;
        }
        else 	
        	$row[] = '&nbsp;';
        //FETCH INTERESTED IN COURSE FIELD
        
        $row[] = '<a href="#" id="howdy" target="_parent"><img src="assets/edit.gif"/></a>&nbsp;<a href="#" id="howdy" target="_parent"><img src="assets/delete.gif"/></a>';
        
        $table->data[] = $row;
           
    }

    echo html_writer::table($table);
}
	//END LIST OF CURRENT SUBSCRIBERS

echo $OUTPUT->footer();

?>
