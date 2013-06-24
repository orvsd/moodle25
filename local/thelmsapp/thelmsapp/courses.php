<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Courses
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

// Check for valid admin user - no guest autologin
require_login(0, false);
$context = get_context_instance(CONTEXT_SYSTEM);
require_capability('moodle/site:config', $context);

$PAGE->set_url('/blocks/thelmsapp/courses.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$courses_page = get_string('courses','block_thelmsapp');

$PAGE->navbar->add($courses_page);

$PAGE->set_title($courses_page);
$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();


echo '<table width="100%"><tr><td width="140px">';

//PRINT COURSE CATEGORIES FILTER

	//GET LIST OF AVAILABLE COURSE CATEGORIES
		$available_parents_array = array();
		$available_parents  = $DB->get_records_select('block_thelmsapp_coursecattxt','id>0 ORDER BY id DESC',array('DISTINCT optionid'));

		foreach ($available_parents as $available_parent) {

	     		 $available_parents_array[$available_parent->optionid] = $available_parent->name;
		}

		asort($available_parents_array);
		
		//FOR EACH PARENT FIND CORRECT ID
		  $correctid_array = array();
		  foreach ($available_parents_array as $key => $available_parents_arr) {
		  	       
		  	       $correctid = $DB->get_record_select('block_thelmsapp_coursecattxt', 'optionid = '. $key . ' ORDER BY id ASC LIMIT 1');
		  		   
		  		   if (count($correctid) == 1 && $correctid == TRUE)
		  	       	   $correctid_array[$key] = $correctid->id;
		  
		  }
		  
		//FOR EACH PARENT FIND CORRECT ID
		
		$available_parents_correct_array = array(0 => get_string('noparent','block_thelmsapp'));
		foreach ($available_parents_array as $key => $available_parents_arr) {
			     if (array_key_exists($key, $correctid_array))
			         $available_parents_correct_array[$correctid_array[$key]] = $available_parents_arr;
		}  
		  
		$available_parents_correct_array[-1] = get_string('all','block_thelmsapp');
	//GET LIST OF AVAILABLE COURSE CATEGORIES

		
//FIRST CHECK IF COURSE CATEGORY FILTER IS SELECTED AND SAVE IN SESSION
//WE SAVE IN SESSION BECAUSE WE WANT THE POSITIONING TO FUNCTION WITH THE FILTER SELECTED. DEFAULT VALUE IS -5 BECAUSE
//WE ALREADY HAVE -1 AS 'All; OPTION
  $course_category_filter = optional_param('course_category_select', -5, PARAM_INT);
  
  if ($course_category_filter >= -1)
  	  	$_SESSION['course_category_filter'] = $course_category_filter;
  
  if (!isset($_SESSION['course_category_filter']))
  	  $_SESSION['course_category_filter'] = -5;
  
//WE SAVE IN SESSION BECAUSE WE WANT THE POSITIONING TO FUNCTION WITH THE FILTER SELECTED
//WE ALREADY HAVE -1 AS 'All; OPTION
//FIRST CHECK IF COURSE CATEGORY FILTER IS SELECTED AND SAVE IN SESSION
		
		
echo '<fieldset>';
echo '<legend>Course Category</legend>';
echo '<form method="post" action="courses.php" name="form_course_category">';
echo '<select name="course_category_select" id="course_category_select" onChange="document.forms[\'form_course_category\'].submit();">';

foreach ($available_parents_correct_array as $key => $value) {
	        if ($_SESSION['course_category_filter'] == $key)
	        	echo '<option value="'.$key.'" selected>' . $value . '</option>';
	        else	
				echo '<option value="'.$key.'">' . $value . '</option>';
	
}

echo '</select>';
echo '</form>';
echo '</fieldset>';

//PRINT COURSE CATEGORIES FILTER
echo '</td><td width="100%">';

//PRINT ADD LINK
$content = '<fieldset><div align="center">'.html_writer::link(new moodle_url('/blocks/thelmsapp/addcourse.php', array()), get_string('addcourse','block_thelmsapp')) . '</div></fieldset><br/>';
echo $content;
//PRINT ADD LINK

echo '</td><td>';

//PRINT LOGO
echo '<a href="http://www.thelmsapp.com/"><img src="assets/thelmsapp_logo.png" width="140" align="right" valign="middle" /></a>';
//PRINT LOGO

echo '</td></tr></table>';

//LIST ALL AVAILABLE OPTIONS (BUTTONS)
if ($_SESSION['course_category_filter'] >= 0)
	$courses      = $DB->get_records_select('block_thelmsapp_course','id > 0 AND categoryparent = ' .$_SESSION['course_category_filter']. ' ORDER BY position');
else
	$courses      = $DB->get_records_select('block_thelmsapp_course','id > 0 ORDER BY categoryparent,position');
	
if (count($courses) == 0) {
    echo html_writer::tag('div', '<font color="red">' . get_string('coursesnull', 'block_thelmsapp'). '</font>', array('align' => 'center'));
}else {
 
    $table = new html_table();
    $table->attributes['border'] = '1';
    $table->width = '100%';
    $table->headspan = array(-2,1);
    $table->align = array('center', 'center', 'center', 'center', 'center', 'center', 'center', 'center', 'center', 'left', 'left');
    $table->head = array(get_string('optionid','block_thelmsapp'), get_string('categoryparent','block_thelmsapp'), get_string('Name','block_thelmsapp'), get_string('code','block_thelmsapp'), get_string('price','block_thelmsapp'), get_string('Lang','block_thelmsapp'), get_string('Position','block_thelmsapp'), get_string('visibility','block_thelmsapp'), get_string('languages','block_thelmsapp'), get_string('Actions','block_thelmsapp'));
    
    foreach ($courses as $course) {

        $row = array();
        $row[] = $course->id;
        
        $courses_text = $DB->get_records_select('block_thelmsapp_coursetext','optionid = ' .$course->id . ' LIMIT 1' );
        
        //FIND PREVIOUS/NEXT POSITION VALUES
        	$next_pos = $DB->get_record_select('block_thelmsapp_course','position = ' . (int)($course->position-1) . ' AND categoryparent='. $course->categoryparent .' LIMIT 1');
        	if (!is_object($next_pos)) {
        		$next_pos = new stdclass(); $next_pos->id = -1;
        	}
        	$previous_pos = $DB->get_record_select('block_thelmsapp_course','position = ' . (int)($course->position+1) . ' AND categoryparent=' . $course->categoryparent. ' LIMIT 1');
        	if (!is_object($previous_pos)) { 
        		$previous_pos = new stdclass(); $previous_pos->id = -1; 
        	}
        //FIND PREVIOUS/NEXT POSITION VALUES
        
        foreach ($courses_text as $course_text) {
        	       		        	
        	     $course_category  = $DB->get_records_select('block_thelmsapp_coursecattxt','id=' . $course->categoryparent );
        	     if (count($course_category) ==1)
        	     	 $row[] = html_writer::link(new moodle_url('/blocks/thelmsapp/coursecategories.php', array('id' => $course_category[$course->categoryparent]->optionid)), $course_category[$course->categoryparent]->name);
        	     else
        	     	 $row[] = '';
        	     	
        	     $row[] = $course_text->name;
        	     $row[] = $course_text->code;
        	     $row[] = $course_text->price;
        		 //$row[] = $course->name;
        		 $row[] = $course_text->lang;
        		 //$row[] = $course_text->icon;
        		 
        		 //IF POSITION = 0 DONT SHOW DOWN ARROW BUTTON. IN ALL OTHER POSITIONS SHOW UP/DOWN ARROWS
        		 if ($course->position == 0)
        		 	$row[] = $course->position . html_writer::link(new moodle_url('/blocks/thelmsapp/upc.php', array('id' =>$course->id, 'prev' => $previous_pos->id)), '<img src="assets/down_arrow.gif"/>');
        		 else	
        		 	$row[] = $course->position . html_writer::link(new moodle_url('/blocks/thelmsapp/upc.php', array('id' =>$course->id, 'prev' => $previous_pos->id)), '<img src="assets/down_arrow.gif"/>') . html_writer::link(new moodle_url('/blocks/thelmsapp/downc.php', array('id' =>$course->id, 'next' => $next_pos->id)), '<img src="assets/up_arrow.png"/>');
        		 
        		 //IF HIDDEN = 1 CHANGE  VISIBILITY ICON
        		 if ($course->hidden == 1)       		 	
        		 	 $row[] = html_writer::link(new moodle_url('/blocks/thelmsapp/hidecourse.php', array('id' => $course->id)), '<img src="assets/show.gif" alt="Hide this option" />');
        		 else
        		 	 $row[] = html_writer::link(new moodle_url('/blocks/thelmsapp/hidecourse.php', array('id' => $course->id)), '<img src="assets/hide.gif" alt="Show this option" />');
        
        $languages    = $DB->get_records_select('block_thelmsapp_coursetext', 'optionid = ' . $course->id . ' AND lang != \'' . $course_text->lang . '\'');
        if (count($languages) > 0) {
        
        	$row_string = '<ul>';
        	foreach ($languages as $language) {
        	
        			 $lang = $language->lang;
        			 $row_string .= '<li>' . html_writer::link(new moodle_url('/blocks/thelmsapp/editcourse_lang.php', array('id' => $language->id, 'lang' => $lang)), $lang) . '</li>';
        			 //$row_string .= $lang . '<br/>';
        			 
        	}
        	$row[] = $row_string . '</ul>';
        	
        }
        else
        	$row[] = '&nbsp;';
        
        }
        
        $row[] = html_writer::link(new moodle_url('/blocks/thelmsapp/addcourse.php', array('optionid' => $course->id)), '<img src="assets/addtr.png"/></a>&nbsp;<a href="#" id="" target="_parent">') . html_writer::link(new moodle_url('/blocks/thelmsapp/editcourse.php', array('id' => $course->id, 'lang' => $course_text->lang)), '<img src="assets/edit.gif"/></a>&nbsp;<a href="#" id="" target="_parent">');
        
        $table->data[] = $row;
           
    }

    echo html_writer::table($table);
    echo '<br/>';
    
    //----------------------------------------------------------------------------------------------------------------//
    
    //GET ALL AVAILABLE LANGUAGES AND STORE IN ARRAY
      $languages_str = 'Currently Available Languages: ';
      $available_languages_array = array();
    
      $available_languages   = $DB->get_records_select('block_thelmsapp_coursetext','id >0', array(),'','DISTINCT lang');
      foreach ($available_languages as $available_language) {
    	       $available_languages_array[] = $available_language->lang;
      }
    //GET ALL AVAILABLE LANGUAGES AND STORE IN ARRAY
    
    $courses      = $DB->get_records_select('block_thelmsapp_course','id > 0');
    
    if (count($courses) == 0) {
    	$languages_str .= 'No languages found';
    }else {
    
    	$row_array = array();
    	$missing_lang_array = array();
    
    	foreach ($courses as $course) {
    
    		foreach ($available_languages as $available_language) {
    
    			$courses_text = $DB->get_records_select('block_thelmsapp_coursetext','optionid = ' .$course->id . ' AND lang = \'' . $available_language->lang . '\'' );
    
    			//CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
    			if (count($courses_text) == 0) {
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
    			   $languages_str .= ' ' .'<strong>' . $post_str . '</strong>';
    	
    	  $row_lang= array();
    	  $row_lang[] = $languages_str . '<br/><small>Only languages with all the translation strings defined will be available!</small>'; 
    	  $table_lang->data[] = $row_lang;
    	  
    	  echo html_writer::table($table_lang);
    	//DIFF AVAILABLE LANGUAGES ARRAY WITH MISSING KANGUAGES ARRAY AND RETURN RESULT
    	  
    	echo '<br/>';  
    }
    //----------------------------------------------------------------------------------------------------------------//

}
//LIST ALL AVAILABLE OPTIONS (BUTTONS)

echo $OUTPUT->footer();

?>
