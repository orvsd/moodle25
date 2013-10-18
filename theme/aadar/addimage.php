<?php

/* Imports */
require_once('../../config.php');
require_once($CFG->dirroot . '/repository/lib.php');
require_once($CFG->dirroot . '/theme/aadar/addimage_form.php');
require_once($CFG->libdir . '/gdlib.php');

/* Script settings */
define('IMAGE_WIDTH', 210);
define('IMAGE_HEIGHT', 140);

/* Page parameters */
$contextid = required_param('contextid', PARAM_INT);
$sectionid = required_param('sectionid', PARAM_INT);
$id = optional_param('id', null, PARAM_INT);

global $DB,$USER;
/* No idea, copied this from an example. Sets form data options but I don't know what they all do exactly */
$formdata = new stdClass();
$formdata->userid = required_param('userid', PARAM_INT);
$formdata->offset = optional_param('offset', null, PARAM_INT);
$formdata->forcerefresh = optional_param('forcerefresh', null, PARAM_INT);
$formdata->mode = optional_param('mode', null, PARAM_ALPHA);

$url = new moodle_url('/theme/aadar/addimage.php', array(
            'contextid' => $contextid,
            'id' => $id,
            'userid' => $formdata->userid,
            'mode' => $formdata->mode));

list($context, $course, $cm) = get_context_info_array($contextid);

require_login($course, true, $cm);
if (isguestuser()) {
    die();
}

$PAGE->set_url($url);
$PAGE->set_context($context);

/* Functional part. Create the form and display it, handle results, etc */
$options = array(
    'subdirs' => 0,
    'maxfiles' => 1,
    'accepted_types' => array('web_image'),
    'return_types' => FILE_INTERNAL);

$mform = new dashboard_image_form(null, array(
            'contextid' => $contextid,
            'userid' => $formdata->userid,
            'sectionid' => $sectionid,
            'options' => $options));

if ($mform->is_cancelled()) {
    //Someone has hit the 'cancel' button
    redirect(new moodle_url($CFG->wwwroot . '/index.php'));
} else if ($formdata = $mform->get_data()) { //Form has been submitted    
    $fs = get_file_storage();

    if ($newfilename = $mform->get_new_filename('dashboard_img')) {
        // We have a new file so can delete the old....
        $fs->delete_area_files($context->id, 'user', 'draft', $sectionid);
        // Resize the new image and save it...
        $created = time();
        $storedfile_record = array(
             'contextid' => $contextid,
            'component' => 'user',
            'filearea' => 'draft',
            'itemid' => $sectionid,
            'filepath' => '/',
            'filename' => $newfilename,
            'timecreated' => $created,
            'timemodified' => $created);

      
        $temp_file = $mform->save_stored_file('dashboard_img', $storedfile_record['contextid'], $storedfile_record['component'], $storedfile_record['filearea'], $storedfile_record['itemid'], $storedfile_record['filepath'], 'temp.' . $storedfile_record['filename'], true);

        try {
            $convert_success = true;
            // Ensure the right quality setting...
            $mime = $temp_file->get_mimetype();

            $storedfile_record['mimetype'] = $mime;

            if ($mime != 'image/gif') {
                 
               
                $tmproot = make_temp_directory('themeimage');
                $tmpfilepath = $tmproot . '/' . $temp_file->get_contenthash();
                $temp_file->copy_content_to($tmpfilepath);
    
                $data = generate_image_thumbnail($tmpfilepath,IMAGE_WIDTH, IMAGE_HEIGHT);
                
                if (!empty($data)) {
                    
                    $fs->create_file_from_string($storedfile_record, $data);
              
                          } else {
                            
                    $convert_success = false;
                    
                }
                unlink($tmpfilepath);
            } else {
                      

                $fr = $fs->convert_image($storedfile_record, $temp_file,IMAGE_WIDTH, IMAGE_HEIGHT, true, null);
                // Debugging...
              
            }
             $draftitemid = file_get_submitted_draft_itemid('dashboard_img');
            $temp_file->delete();
            unset($temp_file);

            if ($convert_success == true) {
                $getimg="SELECT * FROM {theme_aadar} where imgid ={$sectionid} AND userid={$USER->id}";
                  
                $getimg=$DB->get_records_sql($getimg);
              if($getimg){
                   foreach($getimg as $aadarimg){ 
                        $actool=new object();
                        $actool->id=$aadarimg->id;
                        $actool->imagename=$newfilename;
                        $actool->url=$formdata->url;
                        $actool->label=$formdata->label;
                        $actool->itemid=$draftitemid;
                        $actool->userid=$USER->id;
                      
                      $DB->update_record('theme_aadar', $actool);
               }
            } 
            else {
                 $actool=new object();
                 $actool->imagename=$newfilename;
                 $actool->url=$formdata->url;
                 $actool->label=$formdata->label;
                 $actool->imgid=$sectionid;
                 $actool->itemid=$draftitemid;
                 $actool->userid=$USER->id;
               $val=  $DB->insert_record('theme_aadar', $actool);
             
            } 

              
            } else {
                print_error('imagecannot', 'theme_aadar', $CFG->wwwroot . "/index.php");
            }
        } catch (Exception $e) {
            if (isset($temp_file)) {
                $temp_file->delete();
                unset($temp_file);
            }
            print('Image edit  Exception:...');
            debugging($e->getMessage());
        }
        redirect($CFG->wwwroot . "/index.php");
    }
}

 


/* Draw the form */
echo $OUTPUT->header();
echo $OUTPUT->box_start('generalbox');
$mform->display();
echo $OUTPUT->box_end();
echo $OUTPUT->footer();