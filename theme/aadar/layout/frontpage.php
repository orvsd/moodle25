<?php
/// This file contains a few configuration variables that control
/// how Moodle uses this theme.
////////////////////////////////////////////////////////////////////////////////
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version details
 *
 * @package    Theme
 * @subpackage Aadar 
 * @copyright  2013 eabyas <eabyas.in>
 * @author     Niranjan Reddy <niranjan@eabyas.in>  
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));
$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));
global $USER;
$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($showsidepost && !$showsidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}
$context = get_context_instance (CONTEXT_SYSTEM);
echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot;?>/local/datagrid/demo_table.css" />
<script type="text/javascript" src="<?php echo $CFG->wwwroot;?>/local/datagrid/jquery_dataTables.js"></script>
<script type="text/javascript" src="<?php echo $CFG->wwwroot;?>/local/datagrid/test.js"></script>
<script type="text/javascript" src="<?php echo $CFG->wwwroot;?>/local/datagrid/jquery.js"></script>
    <meta name="description" content="<?php p(strip_tags(format_text($SITE->summary, FORMAT_HTML))) ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>

<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">

<!-- START OF HEADER -->
    <div id="page-header">
		<div id="page-header-wrapper" class="wrapper clearfix">
	        <h1 class="headermain"><?php echo $PAGE->heading ?></h1>
    	    <div class="headermenu">
        		<?php
	        	    echo $OUTPUT->login_info();
    	        	echo $OUTPUT->lang_menu();
	        	    echo $PAGE->headingmenu;
		        ?>
	    	</div>
	    </div>
    </div>

<!-- END OF HEADER -->

<?php if ($hascustommenu) { ?>
<div id="custommenuwrap"><div id="custommenu"><?php echo $custommenu; ?></div></div>
<?php } ?>

<!-- START OF CONTENT -->

<div id="page-content-wrapper" class="wrapper clearfix">

                           
    <div id="page-content">
        <div id="region-main-box">
            <div id="region-post-box">

                <div id="region-main-wrap">
                    <div id="region-main">
                        <div class="region-content">
                           
                            
 <?php  if(isloggedin() && has_capability('moodle/site:config', $context, $USER->id, true)) 

 {
    
     function getimgurl($id){                             
     global $DB,$CFG,$USER;
    $getimg="SELECT * FROM {theme_aadar} where imgid={$id} AND userid={$USER->id}";
  
    $getimg=$DB->get_records_sql($getimg);
    
    if($getimg){
       
          foreach($getimg as $aadarimg){ 
                  
                   $fs = get_file_storage();
                 //  $usercontext = context_user::instance($USER->id);
                    $usercontext = context_user::instance($USER->id);
    
                   $files = $fs->get_area_files($usercontext->id, 'user','draft',$aadarimg->itemid);
                 //  print_object($files);
                   foreach ($files as $file) {
                       $out=array();
                         $url = "{$CFG->wwwroot}/draftfile.php/{$file->get_contextid()}/user/draft";
                         $filename = $file->get_filename();
                         
                         $fileurl = $url.$file->get_filepath().$file->get_itemid().'/'.$filename;
                         $out[0] = $fileurl;
                         $out[1]=$aadarimg->url;
                         $out[2]=$aadarimg->label;
                        
                    }
           }
           
            return $out;
    }
 }  
  getimgurl(1);
$output=array();
global $COURSE;
$context = context_course::instance($COURSE->id);

$contextid = $context->id;

?>
                             
 <h1>Admin Dashboard </h1>
         <div class='upper'>
                                     <div style='border:0px solid lightgray; width:33%;height:100%; float:left;text-align:center;'>
				      <div class="imgthree" ><a href="<?php  $output=getimgurl(1);  echo $CFG->wwwroot.'/'.$output[1]; ?>">  <img src="<?php  echo $output[0]; ?>" width="100px" height="100px" alt="Top One" > </a></div>
				      <div class='coursetext' ><?php  echo $output[2]; ?><a href="<?php echo $CFG->wwwroot;?>/theme/aadar/addimage.php?contextid=<?php echo $contextid; ?>&sectionid=1&userid=<?php echo $USER->id?>" ><img src="<?php echo $OUTPUT->pix_url('edit', 'theme'); ?>" ></a></div>
				     </div>
                                    
                                     <div style='border:0px solid lightgray; width:33%;height:100%; float:left;text-align:center;'>
				      <div class="imgthree" ><a href="<?php  $output=getimgurl(2);  echo $CFG->wwwroot.'/'.$output[1]; ?>"><img src="<?php  echo $output[0]; ?>" width="100px" height="100px" alt="Top Two" > </a></div>
				      <div class='coursetext' ><?php  echo $output[2]; ?> <a href="<?php echo $CFG->wwwroot;?>/theme/aadar/addimage.php?contextid=<?php echo $contextid; ?>&sectionid=2&userid=<?php echo $USER->id?>" ><img src="<?php echo $OUTPUT->pix_url('edit', 'theme'); ?>" >  </a> </div>
				    </div>
                                    
                                     <div style='border:0px solid lightgray; width:33%;height:100%; float:left;text-align:center;'>
				     <div class="imgthree" > <a href="<?php  $output=getimgurl(3);  echo $CFG->wwwroot.'/'.$output[1]; ?>"><img src="<?php echo $output[0]; ?>" width="100px" height="100px" alt="Top Three" ></a> </div>
				      <div class='coursetext' ><?php  echo $output[2]; ?> <a href="<?php echo $CFG->wwwroot;?>/theme/aadar/addimage.php?contextid=<?php echo $contextid; ?>&sectionid=3&userid=<?php echo $USER->id?>" ><img src="<?php echo $OUTPUT->pix_url('edit', 'theme'); ?>" >  </a> </div>
				    </div>
                                    
                                    
                                </div>
        
                              <div class='lower'>
				 <div style='border:0px solid lightgray; width:33%;height:100%; float:left;text-align:center;'>
				    <div class='imgthree'  > <a href="<?php  $output=getimgurl(4);  echo $CFG->wwwroot.'/'.$output[1]; ?>"><img src="<?php echo $output[0]; ?>" width="100px" height="100px" alt="Lower One" > </a> </div>
				      <div class='coursetext' ><?php  echo $output[2]; ?> <a href="<?php echo $CFG->wwwroot;?>/theme/aadar/addimage.php?contextid=<?php echo $contextid; ?>&sectionid=4&userid=<?php echo $USER->id?>" ><img src="<?php echo $OUTPUT->pix_url('edit', 'theme'); ?>" >  </a> </div>
				 </div>
                                 <div style='border:0px solid lightgray; width:33%;height:100%; float:left;text-align:center;'>
			              <div class='imgthree' ><a href="<?php  $output=getimgurl(5);  echo $CFG->wwwroot.'/'.$output[1]; ?>"> <img src="<?php echo $output[0]; ?>" width="100px" height="100px" alt="Lower Two" > </a> </div>
				      <div class='coursetext' ><?php  echo $output[2]; ?> <a href="<?php echo $CFG->wwwroot;?>/theme/aadar/addimage.php?contextid=<?php echo $contextid; ?>&sectionid=5&userid=<?php echo $USER->id?>" ><img src="<?php echo $OUTPUT->pix_url('edit', 'theme'); ?>" >  </a> </div>
				 </div>
              		         <div style='border:0px solid lightgray; width:32%;height:100%; float:left;text-align:center;'>
				   <div class='imgthree'><a href="<?php  $output=getimgurl(6);  echo $CFG->wwwroot.'/'.$output[1]; ?>"><img src="<?php echo $output[0]; ?>" width="100px" height="100px" alt="Lower Three" ></a></div>
				      <div class='coursetext' ><?php  echo $output[2]; ?> <a href="<?php echo $CFG->wwwroot;?>/theme/aadar/addimage.php?contextid=<?php echo $contextid; ?>&sectionid=6&userid=<?php echo $USER->id?>" ><img src="<?php echo $OUTPUT->pix_url('edit', 'theme'); ?>" >  </a> </div>
				 </div>
                              </div>
                     <div style="visibility:hidden;">spacer </div>       
                        
	  <?php echo $OUTPUT->main_content(); }   
        else { echo "<div class='landpage'>"; echo $OUTPUT->main_content(); echo '</div>';  }?>
        
           </div>
                    </div>
                </div>

                <?php  if ($hassidepre) { ?>
                <div id="region-pre" class="block-region">
                    <div class="region-content">
                        <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                    </div>
                </div>
                <?php } ?>

                <?php if ($hassidepost) { ?>
                <div id="region-post" class="block-region">
                    <div class="region-content">
                        <?php echo $OUTPUT->blocks_for_region('side-post') ?>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<!-- END OF CONTENT -->

<!-- START OF FOOTER -->

    <div id="page-footer" class="wrapper">
        <p class="helplink">
        <?php echo page_doc_link(get_string('moodledocslink')) ?>
        </p>

        <?php
        echo $OUTPUT->login_info();
        echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>

<!-- END OF FOOTER -->

</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>