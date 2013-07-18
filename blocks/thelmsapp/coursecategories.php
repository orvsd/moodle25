<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage CourseCategories
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

// Check for valid admin user - no guest autologin
require_login(0, false);
$context = get_context_instance(CONTEXT_SYSTEM);
require_capability('moodle/site:config', $context);

$PAGE->set_url('/blocks/thelmsapp/coursecategories.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$coursecategories_page = get_string('coursecategories','block_thelmsapp');

$PAGE->navbar->add($coursecategories_page);

$PAGE->set_title($coursecategories_page);
$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();

echo '<table width="100%"><tr><td><div style="width: 140px"></div></td><td width="100%">';

//PRINT ADD LINK
$content = '<fieldset><div align="center">'.html_writer::link(new moodle_url('/blocks/thelmsapp/addcoursecategory.php', array()), get_string('addcoursecategory','block_thelmsapp')) . '</div></fieldset><br/>';
echo $content;
//PRINT ADD LINK

echo '</td><td>';

//PRINT LOGO
echo '<a href="http://www.thelmsapp.com/"><img src="assets/thelmsapp_logo.png" width="140" align="right" valign="middle" /></a>';
//PRINT LOGO

echo '</td></tr></table>';


//LIST ALL AVAILABLE COURSE CATEGORIES
$coursecategories      = $DB->get_records_select('block_thelmsapp_coursecat','id > 0');

if (count($coursecategories) == 0) {
    echo html_writer::tag('div', '<font color="red">' . get_string('coursecategoriesnull', 'block_thelmsapp'). '</font>', array('align' => 'center'));
}else {
 
    $table = new html_table();
    $table->attributes['border'] = '1';
    $table->width = '100%';
    $table->headspan = array(-2,1);
    $table->align = array('center', 'center', 'center', 'center', 'center', 'center', 'left', 'left', 'left');
    $table->head = array(get_string('coursecategoryid','block_thelmsapp'), get_string('coursecategoryname','block_thelmsapp'), get_string('coursecategorylang','block_thelmsapp'), get_string('coursecategorydescription','block_thelmsapp'), get_string('coursecategoryparent','block_thelmsapp') , get_string('coursecategorycourses','block_thelmsapp'), get_string('coursecategorytextlangs','block_thelmsapp'), get_string('coursecategoryactions','block_thelmsapp'));
    
    foreach ($coursecategories as $coursecategory) {

        $row = array();
        $row[] = $coursecategory->id;
        
        $coursecategories_text = $DB->get_records_select('block_thelmsapp_coursecattxt','optionid = ' .$coursecategory->id . ' LIMIT 1' );
        
        
        
        foreach ($coursecategories_text as $coursecategory_text) {
        	       		        	
        		 $row[] = $coursecategory_text->name;
        		 //$row[] = $coursecategory->name;
        		 $row[] = $coursecategory_text->lang;
        		 $row[] = '<div style="margin-left: auto; margin-right: auto; clear: both; width: 250px; overflow: auto">'. $coursecategory_text->description . '</div>';

        		 $cparent = $DB->get_record_select('block_thelmsapp_coursecattxt','optionid = ' .$coursecategory->cparent . ' ORDER BY id ASC LIMIT 1' );
        		 if ($coursecategory->cparent == 0)
        		 	 $row[] = '-';
        		 else
        		 	 $row[]   = html_writer::link(new moodle_url('/blocks/thelmsapp/editcoursecategory.php', array('id' => $coursecategory->cparent, 'lang' => $coursecategory_text->lang)), $cparent->name);
        		 
        		 //LIST COURSE UNDER THIS COURSE CATEGORY
        		 
        		 $courses_list_str = '<ul>';
        		 //FIRST FIND CORRECT ROW FROM COURSESTEXT TABLE
        		 $courses_in_category   = $DB->get_records_select('block_thelmsapp_course','categoryparent = '. $coursecategory_text->id);
        		 
        		 foreach ($courses_in_category as $course_in_category) {
        		 		  
        		 	      $course_record   = $DB->get_record_select('block_thelmsapp_coursetext','optionid = '. $course_in_category->id . ' ORDER BY id ASC LIMIT 1');
        		 	      $courses_list_str .= '<li>' . html_writer::link(new moodle_url('/blocks/thelmsapp/courses.php', array()), $course_record->name) . '</li>';
        		 }
        		
        		 $courses_list_str .= '</ul>';
        		 
        		 $row[] = $courses_list_str;
        		 
        		 
        $languages    = $DB->get_records_select('block_thelmsapp_coursecattxt', 'optionid = ' . $coursecategory->id . ' AND lang != \'' . $coursecategory_text->lang . '\'');
        if (count($languages) > 0) {
        
        	$row_string = '<ul>';
        	foreach ($languages as $language) {
        	
        			 $lang = $language->lang;
        			 $row_string .= '<li>' . html_writer::link(new moodle_url('/blocks/thelmsapp/editcoursecategory_lang.php', array('id' => $language->id, 'lang' => $lang)), $lang) . '</li>';
        			 //$row_string .= $lang . '<br/>';
        			 
        	}
        	$row[] = $row_string . '</ul>';
        	
        }
        else
        	$row[] = '&nbsp;';
        
        }
        
        $row[] = html_writer::link(new moodle_url('/blocks/thelmsapp/addcoursecategory.php', array('optionid' => $coursecategory->id, 'parent' => $coursecategory->cparent)), '<img src="assets/addtr.png"/></a>&nbsp;<a href="#" id="" target="_parent">') . html_writer::link(new moodle_url('/blocks/thelmsapp/editcoursecategory.php', array('id' => $coursecategory->id, 'lang' => $coursecategory_text->lang)), '<img src="assets/edit.gif"/></a>&nbsp;<a href="#" id="" target="_parent">');
        
        $table->data[] = $row;
           
    }

    echo html_writer::table($table);
    echo '<br/>';
    
    //----------------------------------------------------------------------------------------------------------------//
    
    //GET ALL AVAILABLE LANGUAGES AND STORE IN ARRAY
      $languages_str = 'Currently Available Languages: ';
      $available_languages_array = array();
    
      $available_languages   = $DB->get_records_select('block_thelmsapp_coursecattxt','id >0', array(),'','DISTINCT lang');
      foreach ($available_languages as $available_language) {
    	       $available_languages_array[] = $available_language->lang;
      }
    //GET ALL AVAILABLE LANGUAGES AND STORE IN ARRAY
    
    $coursecategories      = $DB->get_records_select('block_thelmsapp_coursecat','id > 0');
    
    if (count($coursecategories) == 0) {
    	$languages_str .= 'No languages found';
    }else {
    
    	$row_array = array();
    	$missing_lang_array = array();
    
    	foreach ($coursecategories as $coursecategory) {
    
    		foreach ($available_languages as $available_language) {
    
    			$coursecategories_text = $DB->get_records_select('block_thelmsapp_coursecattxt','optionid = ' .$coursecategory->id . ' AND lang = \'' . $available_language->lang . '\'' );
    
    			//CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
    			if (count($coursecategories_text) == 0) {
    				$missing_lang_array[] = $available_language->lang; continue;
    			}
    			//CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
    
    		}
    	}
    
    	//DIFF AVAILABLE LANGUAGES ARRAY WITH MISSING LANGUAGES ARRAY AND RETURN RESULT
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
//LIST ALL AVAILABLE COURSE CATEGORIES

echo $OUTPUT->footer();

?>
