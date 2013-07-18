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

// Check for valid admin user - no guest autologin
require_login(0, false);
$context = get_context_instance(CONTEXT_SYSTEM);
require_capability('moodle/site:config', $context);

//INCLUDE NECESSARY JAVASCRIPT FOR POPUS
  $PAGE->requires->js('/blocks/thelmsapp/javascript/jquery.min.js',true);
  $PAGE->requires->js('/blocks/thelmsapp/javascript/dialog.js',true);
  $PAGE->requires->css('/blocks/thelmsapp/javascript/dialog.css',true);
//INCLUDE NECESSARY JAVASCRIPT FOR POPUS

$PAGE->set_url('/blocks/thelmsapp/options.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$newsletters_page = get_string('newsletters','block_thelmsapp');

$PAGE->navbar->add($newsletters_page);

$PAGE->set_title($newsletters_page);
$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();

echo '<table width="100%"><tr><td><div style="width: 140px;"></div></td><td width="100%">';

//PRINT ADD LINK
$content = '<fieldset><div align="center">'.get_string('newsletter_currentsubscribers','block_thelmsapp') . '</div></fieldset><br/>';
echo $content;
//PRINT ADD LINK

echo '</td><td>';
//PRINT LOGO
echo '<a href="http://www.thelmsapp.com/"><img src="assets/thelmsapp_logo.png" width="140" align="right" valign="middle" /></a>';
//PRINT LOGO
echo '</td></tr></table>';

//START LIST OF CURRENT SUBSCRIBERS
$newsletters     = $DB->get_records_select('block_thelmsapp_newsletter','id > 0');

if (count($newsletters) == 0) {
    echo html_writer::tag('div', '<font color="red">' . get_string('newslettersnull', 'block_thelmsapp'). '</font>', array('align' => 'center'));
}else {
 
    $table = new html_table();
    $table->attributes['border'] = '1';
    $table->width = '100%';
    $table->headspan = array(-2,1);
    $table->align = array('center', 'center', 'center', 'center', 'left');
    $table->head = array(get_string('id','block_thelmsapp'), get_string('Surname','block_thelmsapp'), get_string('Name','block_thelmsapp'), get_string('Email','block_thelmsapp'),get_string('Actions','block_thelmsapp'));
    
    foreach ($newsletters as $newsletter) {

        $row = array();
        $row[] = $newsletter->id;
        $row[] = $newsletter->surname;
        $row[] = $newsletter->name;
        $row[] = $newsletter->email;
        $row[] = '<a href="#" id="howdy" target="_parent"><img src="assets/edit.gif"/></a>&nbsp;<a href="#" id="howdy" target="_parent"><img src="assets/delete.gif"/></a>' ;
		$table->data[] = $row;
           
    }

    echo html_writer::table($table);
      
}
//END LIST OF CURRENT SUBSCRIBERS

echo $OUTPUT->footer();

?>
