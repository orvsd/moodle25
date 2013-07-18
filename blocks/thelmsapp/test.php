<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Tests
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//1. TEST OPTIONS-BUTTONS FUNCTIONALITY
  echo '//--------------------------------------OPTIONS TEST--------------------------------------//<br/>';

  $x=json_decode(file_get_contents('http://localhost/blocks/thelmsapp/options_json.php?lang=en'));
    
  foreach ($x as $y) {
    	   $button = json_decode($y);
     	   echo '<strong>Name:</strong> '   .$button->name   . '<br/>';
    	   echo '<strong>Help:</strong> '   .$button->help   . '<br/>';
    	   echo '<strong>Descr:</strong> '  .$button->desc   . '<br/>';
    	   echo '<strong>Icon:</strong> '   .$button->icon   . '<br/>';
      	   echo '<strong>Pos:</strong> '    .$button->pos    . '<br/>';
      	   echo '<strong>Hidden:</strong> ' .$button->hidden . '<br/>';
      	   echo '<br/>';
  }
  
  echo '//--------------------------------------OPTIONS TEST-------------------------------------//<br/><br/>';
  
//1. TEST OPTIONS-BUTTONS FUNCTIONALITY    

//2. TEST COURSES FUNCTIONALITY
  echo '//-------------------------------------COURSES TEST---------------------------------------//<br/>';
  
  $courses = json_decode(file_get_contents('http://localhost/blocks/thelmsapp/courses_json.php?lang=en'));
  
  foreach ($courses as $course_) {
  
  	$course = json_decode($course_);
  	
  	echo '<strong>Category:</strong> ' .$course->category   . '<br/>';
  	echo '<strong>Name:</strong> '     .$course->name       . '<br/>';
  	echo '<strong>Help:</strong> '     .$course->help       . '<br/>';
  	echo '<strong>Descr:</strong> '    .$course->desc       . '<br/>';
  	echo '<strong>Icon:</strong> '     .$course->icon       . '<br/>';
  	echo '<strong>Pos:</strong> '      .$course->pos        . '<br/>';
  	echo '<strong>Hidden:</strong> '   .$course->hidden     . '<br/>';
  	echo '<br/>';
  	
  }
  
  echo '//-------------------------------------COURSES TEST--------------------------------------//<br/><br/>';
  
//2. TEST COURSES FUNCTIONALITY

//3. TEST COURSE CATEGORIES FUNCTIONALITY
  echo '//-------------------------------------COURSE CATEGORIES TEST--------------------------------//<br/>';
  
  $tree = json_decode(file_get_contents('http://localhost/blocks/thelmsapp/coursetree_json.php?lang=en'));

    function read_node($node) {
    
    }
  
  	foreach ($tree as $node) {
  	
  		print $node->name;
  		echo '<a href="#coursecategoryname'.$node->id.'" onclick="javascript: document.getElementById(\'course'.$node->id.'\').style.display=\'block\';">Show</a><br/>'; 
  		echo '<a name="coursecategoryname'.$node->id.'"><div style="display:none;" id="course'.$node->id.'">'. $node->descr . '</div></a>';		
  	
  		if (property_exists($node, 'childs')) {
  			$childs = $node->childs;
  	
  			foreach ($childs as $child) {
  				
  				if ($child->type == 1) {
  					if ($child->parent_id == 0) {
  						//NODE IS COURSE WITHOUT PARENT
  						echo $child->name;
  						echo '<a href="#coursename'.$child->id.'" onclick="javascript: document.getElementById(\'course'.$child->id.'\').style.display=\'block\';">Show</a><br/>';
  						echo '<a name="coursename'.$child->id.'"><div style="display:none;" id="course'.$child->id.'">'. $child->descr . '</div></a>';
  						//NODE IS COURSE WITHOUT PARENT
  					}else {
  					//NODE IS COURSE
  					  echo '-'. $child->name; 
  					  echo '<a href="#coursename'.$child->id.'" onclick="javascript: document.getElementById(\'course'.$child->id.'\').style.display=\'block\';">Show</a><br/>'; 
  					  echo '<a name="coursename'.$child->id.'"><div style="display:none;" id="course'.$child->id.'">'. $child->descr . '</div></a>';
  				    //NODE IS COURSE
  					}
  				}else { 
  					//NODE IS SUBCATEGORY
  					  echo  '-'. $child->name;
  				 	  echo '<a href="#coursecategoryname'.$child->id.'" onclick="javascript: document.getElementById(\'course'.$child->id.'\').style.display=\'block\';">Show</a><br/>';
  					  echo '<a name="coursecategoryname'.$child->id.'"><div style="display:none;" id="course'.$child->id.'">'. $child->descr . '</div></a>';
  					//NODE IS SUBCATEGORY
  				}
  			}
  		}
  	

  	}
  	 
  echo '//-------------------------------------COURSE CATEGORIES TEST---------------------------------//<br/><br/>';
  
//3. TEST COURSE CATEGORIES FUNCTIONALITY

//4. TEST COURSE FLAT TREE FUNCTIONALITY
  echo '//-------------------------------------COURSE FLAT TREE TEST---------------------------------//<br/>';
  
  $tree = json_decode(file_get_contents('http://localhost/blocks/thelmsapp/courseflattree_json.php?lang=el'));
  
  $tree_array = array();
  
  foreach ($tree as $node){ 	
  	if ($node->parent_id == 4)
  		echo $node->name . '<br/>';
  }
  
  echo '//-------------------------------------COURSE FLAT TREE TEST--------------------------------//<br/><br/>';
  
//4. TEST COURSE FLAT TREE FUNCTIONALITY 

//4. TEST CONFIG FUNCTIONALITY
  echo '//--------------------------------------CONFIG TEST---------------------------------------//<br/>';
  
  $configs = json_decode(file_get_contents('http://localhost/blocks/thelmsapp/config_json.php'));
  
  foreach ($configs as $key => $value) {
  
  			if ($key == 'ipad.language') {
  				echo '<strong>' . $key .'</strong> ' .implode(",", $value) . '<br/>';
  				echo '<br/>';
  		
  			}
  			else {
  				echo '<strong>' . $key .'</strong> ' .$value . '<br/>';
  				echo '<br/>';
  			}
  }
  
  echo '//--------------------------------------CONFIG TEST--------------------------------------//<br/><br/>';
  
//4. TEST CONFIG FUNCTIONALITY

//5. TEST NEWSLETTER FUNCTIONALITY
  echo '//-------------------------------------NEWSLETTER TEST----------------------------------//<br/>';
  
  echo '<form method="POST" action="http://localhost/blocks/thelmsapp/newsletter_subscribe.php" >';
  echo '<label for="name" style="display: block; width: 50px;">Name</label>';
  echo '<input type="text" name="name" id="name" value="" /><br/>';
  echo '<label for="surname" style="display: block; width: 50px;">Surname</label>';
  echo '<input type="text" name="surname" id="surname" value="" /><br/>';
  echo '<label for="email" style="display: block; width: 50px;">Email</label>';
  echo '<input type="text" name="email" id="email" value="" /><br/>';
  echo '<input type="submit" name="submit" value="submit" />';
  echo '</form>';
  
  echo '//------------------------------------NEWSLETTER TEST-----------------------------------//<br/><br/>';
  
//5. TEST NEWSLETTER FUNCTIONALITY

//6. TEST LEADS FUNCTIONALITY
  echo '//-------------------------------------LEADS TEST----------------------------------//<br/>';
  
  echo '<form method="POST" action="http://localhost/blocks/thelmsapp/leads_subscribe.php" >';
  echo '<label for="name" style="display: block; width: 50px;">Name</label>';
  echo '<input type="text" name="name" id="name" value="" /><br/>';
  echo '<label for="surname" style="display: block; width: 50px;">Surname</label>';
  echo '<input type="text" name="surname" id="surname" value="" /><br/>';
  echo '<label for="email" style="display: block; width: 50px;">Email</label>';
  echo '<input type="text" name="email" id="email" value="" /><br/>';
  echo '<input type="submit" name="submit" value="submit" />';
  echo '</form>';
  
  echo '//------------------------------------LEADS TEST-----------------------------------//<br/><br/>';
  
//6. TEST LEADS FUNCTIONALITY

//7. TEST USER INFO FUNCTIONALITY
  echo '//----------------------------------USER INFO TEST----------------------------------//<br/>';
  
  echo '<form method="POST" action="http://localhost/blocks/thelmsapp/userinfo_json.php" >';
  echo '<label for="username" style="display: block; width: 50px;">UserName</label>';
  echo '<input type="text" name="username" id="username" value="" /><br/>';
  echo '<label for="email" style="display: block; width: 50px;">Email</label>';
  echo '<input type="text" name="email" id="email" value="" /><br/>';
  echo '<label for="userid" style="display: block; width: 50px;">UserId</label>';
  echo '<input type="text" name="userid" id="userid" value="" /><br/>';
  echo '<input type="submit" name="submit" value="submit" />';
  echo '</form>';
  
  echo '//----------------------------------USER INFO TEST-----------------------------------//<br/><br/>';
  
//7. TEST USER INFO FUNCTIONALITY
  
?>