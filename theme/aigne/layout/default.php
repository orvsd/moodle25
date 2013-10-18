<?php
/**
 * frontpage and standard page.
 *
 * @package    theme_aigne
 * @copyright  2013 Franc Pombal (www.aigne.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$hasheading = ($PAGE->heading);

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());

$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$courseheader = $coursecontentheader = $coursecontentfooter = $coursefooter = '';
    if (empty($PAGE->layout_options['nocourseheaderfooter'])) {
        $courseheader = $OUTPUT->course_header();
        $coursecontentheader = $OUTPUT->course_content_header();
        if (empty($PAGE->layout_options['nocoursefooter'])) {
            $coursecontentfooter = $OUTPUT->course_content_footer();
            $coursefooter = $OUTPUT->course_footer();
        }
    }

$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-pre-only';
    } else {
        $bodyclasses[] = 'side-post-only';
    }
} else if ($showsidepost && !$showsidepre) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-post-only';
    } else {
        $bodyclasses[] = 'side-pre-only';
    }
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}
echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title> 
    <link href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" rel="shortcut icon" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <link href="<?php echo $CFG->wwwroot ?>/theme/aigne/style/aigne_print.css" rel="stylesheet" type="text/css"media="print" />
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">

    <?php echo $OUTPUT->standard_top_of_body_html() ?>
    
<div id="page">

<!-- START OF HEADER -->
    <?php if ($hasheading) { ?>    
    <div id="page-header">
        <?php include('top.php') ?>
    </div>
    <?php } ?>

<!-- START CUSTOMMENU AND NAVBAR -->
    <div id="navcontainer">
        <?php if ($hascustommenu) { ?>
            <div id="custommenu" class="javascript-disabled">
                <?php echo $custommenu; ?>
            </div>
        <?php } 
              if (isloggedin()) {       
              if ($hasnavbar) { ?>
            <div id="navbar">
                <div class="breadcrumb">
                     <?php echo $OUTPUT->navbar(); ?>
                </div>
                <div class="navbutton">
                     <?php echo $PAGE->button; ?>
                </div>
            </div>
        <?php } 
              if (!empty($courseheader)) { ?>
            <div id="course-header">
                <?php echo $courseheader; ?>
            </div>
        <?php } 
              } ?> 
    </div>
    <?php if (!isloggedin() or isguestuser()) { ?>
        <div class="info-banner">
            <?php include('frontinfoup.php') ?>
        </div>
    <?php } ?>

<!-- START OF CONTENT --><!-- onselect + ondragstart: to prevent content copies -->
    <div id="page-content" ondragstart="alert('<?php echo get_string('nocontentdrag','theme_aigne'); ?>'); return false">
<!-- left blocks -->             
        <?php if ($hassidepre OR (right_to_left() AND $hassidepost)) { ?>
        <div id="region-pre" class="block-region">
            <div class="region-content">
               <?php if (!right_to_left()) {
                   echo $OUTPUT->blocks_for_region('side-pre');
                   } elseif ($hassidepost) {
                   echo $OUTPUT->blocks_for_region('side-post');
               } ?>
            </div>
        </div>
        <?php } ?>        
<!-- main center content -->           
        <div id="region-main">
            <?php if (!isloggedin() or isguestuser()) { ?>
            <div class="info-banner">
                <?php include('frontinfo.php') ?>
            </div>
            <?php } ?>         
            <div class="region-content">
                <?php echo $coursecontentheader; ?>
                <?php echo $OUTPUT->main_content() ?>
                <?php echo $coursecontentfooter; ?>
            </div>
        </div>
<!-- Right blocks -->              
        <?php if ($hassidepost OR (right_to_left() AND $hassidepre)) { ?>
        <div id="region-post" class="block-region">
            <div class="region-content">
                <?php if (!right_to_left()) {
                    echo $OUTPUT->blocks_for_region('side-post');
                    } elseif ($hassidepre) {
                    echo $OUTPUT->blocks_for_region('side-pre');
                } ?>
            </div>
        </div>
        <?php } ?>
    </div>
    
<!-- PRINT COPYRIGHT PROTECTION -->
    <div id="print">
        <?php 
            $data = new stdClass;
            $data->sitename = format_string($SITE->fullname);
            $data->disclaimer = get_string('disclaimer','theme_aigne');    
            echo get_string('nocontentprint','theme_aigne', $data); 
        ?>
    </div>
    
<!-- BOTTOM -->
    <div id="page-footer">
        <?php include('bottom.php') ?>
    </div>
    <?php echo $OUTPUT->standard_end_of_body_html() ?>
    <div class="clearfix"></div>
</div>
<!-- LEGACY -->
<div id="page-wrapper" style="display: none;"></div>
<div id="region-main-box" style="display: none;"></div>
</body>
</html>
