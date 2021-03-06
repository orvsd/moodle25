<?php
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

/*
 * @author    Shaun Daubney
 * @package   theme_orvsd
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hasheader = (empty($PAGE->layout_options['noheader']));

$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$isfrontpage = $PAGE->bodyid == "page-site-index";

$haslogo = (!empty($PAGE->theme->settings->logo));
$hastitledate = (!empty($PAGE->theme->settings->titledate));
$hasemailurl = (!empty($PAGE->theme->settings->emailurl));

$hasgeneralalert = (!empty($PAGE->theme->settings->generalalert));
$hassnowalert = (!empty($PAGE->theme->settings->snowalert));

// If there can be a sidepost region on this page and we are editing, always
// show it so blocks can be dragged into it.
if ($PAGE->user_is_editing()) {
    if ($PAGE->blocks->is_known_region('side-pre')) {
        $showsidepre = true;
    }
    if ($PAGE->blocks->is_known_region('side-post')) {
        $showsidepost = true;
    }
}

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));
$hashidemenu = (!empty($PAGE->theme->settings->hidemenu));

$courseheader = $coursecontentheader = $coursecontentfooter = $coursefooter = '';

if (empty($PAGE->layout_options['nocourseheaderfooter'])) {
    $courseheader = $OUTPUT->course_header();
    $coursecontentheader = $OUTPUT->course_content_header();
    if (empty($PAGE->layout_options['nocoursefooter'])) {
        $coursecontentfooter = $OUTPUT->course_content_footer();
        $coursefooter = $OUTPUT->course_footer();
    }
}

$layout = 'pre-and-post';
if ($showsidepre && !$showsidepost) {
    if (!right_to_left()) {
        $layout = 'side-pre-only';
    } else {
        $layout = 'side-post-only';
    }
} else if ($showsidepost && !$showsidepre) {
    if (!right_to_left()) {
        $layout = 'side-post-only';
    } else {
        $layout = 'side-pre-only';
    }
} else if (!$showsidepost && !$showsidepre) {
    $layout = 'content-only';
}
$bodyclasses[] = $layout;

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
 <link rel="apple-touch-icon-precomposed" href="<?php echo $OUTPUT->pix_url('apple-touch-icon', 'theme')?>" />
   <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <!-- Google web fonts -->
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>
    <style type="text/css">
        @font-face {
  		font-family: 'FontAwesome';
  		src: url('<?php echo $CFG->wwwroot ?>/theme/orvsd/fonts/fontawesome-webfont.eot?v=3.2.1');
  		src: url('<?php echo $CFG->wwwroot ?>/theme/orvsd/fonts/fontawesome-webfont.eot?#iefix&v=3.2.1') format('embedded-opentype'), 
  			url('<?php echo $CFG->wwwroot ?>/theme/orvsd/fonts/fontawesome-webfont.woff?v=3.2.1') format('woff'), 
  			url('<?php echo $CFG->wwwroot ?>/theme/orvsd/fonts/fontawesome-webfont.ttf?v=3.2.1') format('truetype'), 
  			url('<?php echo $CFG->wwwroot ?>/theme/orvsd/fonts/fontawesome-webfont.svg#fontawesomeregular?v=3.2.1') format('svg');
  		font-weight: normal;
  		font-style: normal;
		}
    </style>
</head>

<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join($bodyclasses)) ?>">

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<header role="banner" class="navbar navbar-fixed-top">
    <nav role="navigation" class="navbar-inner">
        <div class="container-fluid">
		
            <a href="<?php echo $CFG->wwwroot;?>"><?php if ($haslogo) {
 echo html_writer::empty_tag('img', array('src'=>$PAGE->theme->settings->logo, 'class'=>'logo')); }

 else { ?><a class="brand" href="<?php echo $CFG->wwwroot;?>"><?php echo $SITE->shortname; }?></a>
			
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="nav-collapse collapse">
          <?php  if ((!isloggedin()) && ($hashidemenu)){}

		  else if ($hascustommenu) {
                echo $custommenu;
				
            } ?>
            <ul class="nav pull-right">
            <li><?php echo $PAGE->headingmenu;
			include('profileblock.php');?></li>
            </ul>
            </div>
        </div>
    </nav>
</header>

<div id="page" class="container-fluid">

<?php if ($hasheader) { ?>
<header id="page-header" class="clearfix">
    <?php if ($hasnavbar) { ?>
        <nav class="breadcrumb-button"><?php echo $PAGE->button; ?></nav>
        <?php echo $OUTPUT->navbar(); ?>
    <?php } ?>
    <h1><?php echo $PAGE->heading ?></h1>

    <?php if (!empty($courseheader)) { ?>
        <div id="course-header"><?php echo $courseheader; ?></div>
    <?php } ?>
	
<?php  if (($isfrontpage) && ($hastitledate)) {?>
	<div id="page-header-date"><h1><?php echo date("l d F Y"); ?></h1></div>
	<?php } ?>
	<?php if (($isfrontpage) && $hasgeneralalert) {?>
	<div id="page-header-generalalert">
	<?php echo $PAGE->theme->settings->generalalert; ?>
	</div>
	<?php } ?>
	
		<?php if (($isfrontpage) && $hassnowalert) {?>
	<div id="page-header-snowalert">
	<?php echo $PAGE->theme->settings->snowalert; ?>
	</div>
	<?php } ?>
	
	



</header>
<?php } ?>

<div id="page-content" class="row-fluid">

<?php if ($layout === 'pre-and-post') { ?>
    <div id="region-bs-main-and-pre" class="span9">
    <div class="row-fluid">
    <section id="region-main" class="span8 pull-right">
<?php } else if ($layout === 'side-post-only') { ?>
    <section id="region-main" class="span9">
<?php } else if ($layout === 'side-pre-only') { ?>
    <section id="region-main" class="span9 pull-right">
<?php } else if ($layout === 'content-only') { ?>
    <section id="region-main" class="span12">
<?php } ?>


    <?php echo $coursecontentheader; ?>
    <?php echo $OUTPUT->main_content() ?>
    <?php echo $coursecontentfooter; ?>
    </section>


<?php if ($layout !== 'content-only') {
          if ($layout === 'pre-and-post') { ?>
            <aside class="span4 desktop-first-column">
    <?php } else if ($layout === 'side-pre-only') { ?>
            <aside class="span3 desktop-first-column">
    <?php } ?>
          <div id="region-pre" class="block-region">
          <div class="region-content">
          <?php
                if (!right_to_left()) {
                    echo $OUTPUT->blocks_for_region('side-pre');
                } else if ($hassidepost) {
                    echo $OUTPUT->blocks_for_region('side-post');
                } ?>
          </div>
          </div>
          </aside>
    <?php if ($layout === 'pre-and-post') {
          ?></div></div><?php // Close row-fluid and span9.
   }

    if ($layout === 'side-post-only' OR $layout === 'pre-and-post') { ?>
        <aside class="span3">
        <div id="region-post" class="block-region">
        <div class="region-content">
        <?php if (!right_to_left()) {
                  echo $OUTPUT->blocks_for_region('side-post');
              } else {
                  echo $OUTPUT->blocks_for_region('side-pre');
              } ?>
        </div>
        </div>
        </aside>
    <?php } ?>
<?php } ?>
</div>

<footer id="page-footer" class="container-fluid">
            <?php require('footer.php'); ?>
</footer>

<?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
</body>
</html>
