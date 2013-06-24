<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Buttons
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

// Check for valid admin user - no guest autologin
require_login(0, false);
$context = get_context_instance(CONTEXT_SYSTEM);
require_capability('moodle/site:config', $context);

$PAGE->set_url('/blocks/thelmsapp/options.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$options_page = get_string('options','block_thelmsapp');

$PAGE->navbar->add($options_page);

$PAGE->set_title($options_page);
$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();

echo '<table width="100%"><tr><td><div style="width: 140px;"></div></td><td width="100%">';

//PRINT ADD LINK
$content = '<fieldset><div align="center">'.html_writer::link(new moodle_url('/blocks/thelmsapp/addoption.php', array()), get_string('addoption','block_thelmsapp')) . '</div></fieldset><br/>';
echo $content;
//PRINT ADD LINK

echo '</td><td>';
//PRINT LOGO
echo '<a href="http://www.thelmsapp.com/"><img src="assets/thelmsapp_logo.png" width="140" align="right" valign="middle" /></a>';
//PRINT LOGO
echo '</td></tr></table>';

//LIST ALL AVAILABLE OPTIONS (BUTTONS)
$options      = $DB->get_records_select('block_thelmsapp_option','id > 0 ORDER BY position');

if (count($options) == 0) {
    echo html_writer::tag('div', '<font color="red">' . get_string('optionsnull', 'block_thelmsapp'). '</font>', array('align' => 'center'));
}else {
 
    $table = new html_table();
    $table->attributes['border'] = '1';
    $table->width = '100%';
    $table->headspan = array(-2,1);
    $table->align = array('center', 'center', 'center', 'center', 'center', 'center', 'center', 'left', 'left');
    $table->head = array(get_string('optionid','block_thelmsapp'), get_string('Name','block_thelmsapp'), get_string('Lang','block_thelmsapp'), get_string('Icon','block_thelmsapp'), get_string('Position','block_thelmsapp'), get_string('visibility','block_thelmsapp'), get_string('languages','block_thelmsapp'), get_string('Actions','block_thelmsapp'));
    
    foreach ($options as $option) {

        $row = array();
        $row[] = $option->id;
        
        $options_text = $DB->get_records_select('block_thelmsapp_optiontext','optionid = ' .$option->id . ' LIMIT 1' );
        
        //FIND PREVIOUS/NEXT POSITION VALUES
        	$next_pos = $DB->get_record_select('block_thelmsapp_option','position = ' . (int)($option->position-1) . ' LIMIT 1');
        	if (!is_object($next_pos)) {
        		$next_pos = new stdclass(); $next_pos->id = -1;
        	}
        	$previous_pos = $DB->get_record_select('block_thelmsapp_option','position = ' . (int)($option->position+1) . ' LIMIT 1');
        	if (!is_object($previous_pos)) { 
        		$previous_pos = new stdclass(); $previous_pos->id = -1; 
        	}
        //FIND PREVIOUS/NEXT POSITION VALUES
        
        foreach ($options_text as $option_text) {
        	       		        	
        		 $row[] = $option_text->name;
        		 //$row[] = $option->name;
        		 $row[] = $option_text->lang;
        		 $row[] = '<img src="assets/'.$option_text->icon.'_0.png" />';
        		 
        		 //IF POSITION = 0 DONT SHOW DOWN ARROW BUTTON. IN ALL OTHER POSITIONS SHOW UP/DOWN ARROWS
        		 if ($option->position == 0)
        		 	$row[] = $option->position . html_writer::link(new moodle_url('/blocks/thelmsapp/up.php', array('id' =>$option->id, 'prev' => $previous_pos->id)), '<img src="assets/down_arrow.gif"/>');
        		 else	
        		 	$row[] = $option->position . html_writer::link(new moodle_url('/blocks/thelmsapp/up.php', array('id' =>$option->id, 'prev' => $previous_pos->id)), '<img src="assets/down_arrow.gif"/>') . html_writer::link(new moodle_url('/blocks/thelmsapp/down.php', array('id' =>$option->id, 'next' => $next_pos->id)), '<img src="assets/up_arrow.png"/>');
        		 
        		 //IF HIDDEN = 1 CHANGE  VISIBILITY ICON
        		 if ($option->hidden == 1)       		 	
        		 	 $row[] = html_writer::link(new moodle_url('/blocks/thelmsapp/hideoption.php', array('id' => $option->id)), '<img src="assets/show.gif" alt="Hide this option" />');
        		 else
        		 	 $row[] = html_writer::link(new moodle_url('/blocks/thelmsapp/hideoption.php', array('id' =>$option->id)), '<img src="assets/hide.gif" alt="Show this option" />');
        
        $languages    = $DB->get_records_select('block_thelmsapp_optiontext', 'optionid = ' . $option->id . ' AND lang != \'' . $option_text->lang . '\'');
        if (count($languages) > 0) {
        
        	$row_string = '<ul>';
        	foreach ($languages as $language) {
        	
        			 $lang = $language->lang;
        			 $row_string .= '<li>' . html_writer::link(new moodle_url('/blocks/thelmsapp/editoption_lang.php', array('id' => $language->id, 'lang' => $lang)), $lang) . '</li>';
        			 //$row_string .= $lang . '<br/>';
        			 
        	}
        	$row[] = $row_string . '</ul>';
        	
        }
        else
        	$row[] = '&nbsp;';
        
        }
        
        $row[] = html_writer::link(new moodle_url('/blocks/thelmsapp/addoption.php', array('optionid' => $option->id)), '<img src="assets/addtr.png"/></a>&nbsp;<a href="#" id="" target="_parent">') . html_writer::link(new moodle_url('/blocks/thelmsapp/editoption.php', array('id' => $option->id, 'lang' => $option_text->lang)), '<img src="assets/edit.gif"/></a>&nbsp;<a href="#" id="" target="_parent">');
        
        $table->data[] = $row;
           
    }

    echo html_writer::table($table);
    echo '<br/>';
    
    //----------------------------------------------------------------------------------------------------------------//
    
    //GET ALL AVAILABLE LANGUAGES AND STORE IN ARRAY
      $languages_str = 'Currently Available Languages: ';
      $available_languages_array = array();
    
      $available_languages   = $DB->get_records_select('block_thelmsapp_optiontext','id >0', array(),'','DISTINCT lang');
      foreach ($available_languages as $available_language) {
    	       $available_languages_array[] = $available_language->lang;
      }
    //GET ALL AVAILABLE LANGUAGES AND STORE IN ARRAY
    
    $options      = $DB->get_records_select('block_thelmsapp_option','id > 0');
    
    if (count($options) == 0) {
    	$languages_str .= 'No languages found';
    }else {
    
    	$row_array = array();
    	$missing_lang_array = array();
    
    	foreach ($options as $option) {
    
    		foreach ($available_languages as $available_language) {
    
    			$options_text = $DB->get_records_select('block_thelmsapp_optiontext','optionid = ' .$option->id . ' AND lang = \'' . $available_language->lang . '\'' );
    
    			//CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
    			if (count($options_text) == 0) {
    				$missing_lang_array[] = $available_language->lang; continue;
    			}
    			//CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
    
    		}
    	}
    
    	//DIFF AVAILABLE LANGUAGES ARRAY WITH MISSING KANGUAGES ARRAY AND RETURN RESULT
    	  $table_lang = new html_table();
    	  $table_lang->attributes['border'] = '1';
    	  $table_lang->width = '100%';
    	  $table_lang->align = array('center');
    	  $table_lang->head = array(get_string('ipad_languages','block_thelmsapp'));
    	  $post_string = array_diff($available_languages_array,$missing_lang_array);
    	
    	  foreach ($post_string as $post_str)
    			   $languages_str .= ' ' . '<strong>' . $post_str . '</strong>';
    	
    	  $row_lang= array();
    	  $row_lang[] = $languages_str . '<br/><small>Only languages with all the translation strings defined will be available!</small>'; 
    	  $table_lang->data[] = $row_lang;
    	  
    	  echo html_writer::table($table_lang);
    	//DIFF AVAILABLE LANGUAGES ARRAY WITH MISSING KANGUAGES ARRAY AND RETURN RESULT
    
    }
    //----------------------------------------------------------------------------------------------------------------//
    

}
//LIST ALL AVAILABLE OPTIONS (BUTTONS)

echo $OUTPUT->footer();

?>
