<?php
/**
 * embeded page.
 *
 * @package    theme_aigne
 * @copyright  2013 Franc Pombal (www.aigne.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title> 
    <link href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" rel="shortcut icon" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <link href="<?php echo $CFG->wwwroot ?>/theme/aigne/style/aigne_print.css" rel="stylesheet" type="text/css"media="print" />
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses) ?>">

    <?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">

    <div id="region-main">
        <div class="region-content">
            <?php echo $coursecontentheader; ?>
            <?php echo $OUTPUT->main_content() ?>
            <?php echo $coursecontentfooter; ?>
        </div>
    </div>

</div>

    <?php echo $OUTPUT->standard_end_of_body_html() ?>
    
</body>
</html>
