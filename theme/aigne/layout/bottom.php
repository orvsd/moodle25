<?php
/**
 * bottom-of-the-page section _ Moodle adaptation
 * 
 * @package    theme_aigne
 * @copyright  1997 Franc Pombal (www.aigne.com)
 * @license    http: *www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$hasfooter = (empty($PAGE->layout_options['nofooter']));

$navhelpurl = $PAGE->theme->settings->navhelp;

$haswebmap = (!empty($PAGE->theme->settings->webmap));
$hashelp = (!empty($PAGE->theme->settings->help));
$hasfootsearch = (!empty($PAGE->theme->settings->footsearch));
$hasstats = (!empty($PAGE->theme->settings->stats));
$hasdisclaimer = (!empty($PAGE->theme->settings->disclaimer));
$haspolicies = (!empty($PAGE->theme->settings->policies));
$hasprivacy = (!empty($PAGE->theme->settings->privacy));
$hassecurity = (!empty($PAGE->theme->settings->security));
$hasaccessibility = (!empty($PAGE->theme->settings->accessibility));

$hasemailimg = (!empty($PAGE->theme->settings->emailimg));
$hascontactnote = (!empty($PAGE->theme->settings->contactnote));

$hasfacebook = (!empty($PAGE->theme->settings->facebook));
$hastwitter = (!empty($PAGE->theme->settings->twitter));
$hasgoogleplus = (!empty($PAGE->theme->settings->googleplus));
$hasflickr = (!empty($PAGE->theme->settings->flickr));
$haspicasa = (!empty($PAGE->theme->settings->picasa));
$hasinstagram = (!empty($PAGE->theme->settings->instagram));
$haslinkedin = (!empty($PAGE->theme->settings->linkedin));
$hasyoutube = (!empty($PAGE->theme->settings->youtube));
$hasvimeo = (!empty($PAGE->theme->settings->vimeo));

$hasmoodlecredit = (!empty($PAGE->theme->settings->moodlecredit));
$hascompatcredit = (!empty($PAGE->theme->settings->compatcredit));
$hasfootnote = (!empty($PAGE->theme->settings->footnote));

$hascopyrightstg = (!empty($PAGE->theme->settings->copyrightstg));
$hassitelicensemsg = (!empty($PAGE->theme->settings->sitelicensemsg));
$haslastmodifiedmsg = (!empty($PAGE->theme->settings->lastmodifiedmsg));
$hasthanksvisitmsg = (!empty($PAGE->theme->settings->thanksvisitmsg));

?>
<!-- 01 bottom section _ course footer -->
<div id="bottom_1">
    <?php if (!empty($coursefooter)) { ?>
        <div id="course-footer"><?php echo $coursefooter; ?></div>
    <?php } ?>
</div>
<!-- 02 bottom section _ leave this empty -->
<div id="bottom_2">
    
</div>
<!-- 03 bottom section _ 'HASFOOTER' variable sensitive -->
<div id="standardfooter">
        <!-- Navigation help _ Show NavHelp only if is logged in, whatever show login info link -->
        <div class="navhelp">
            <?php if (!isloggedin() or isguestuser()) { 
                echo $OUTPUT->login_info(); 
            } else {?>
                |
                <?php if ($haswebmap) {?><a href="<?php echo $CFG->wwwroot.$navhelpurl.'?';?>type=1" title="<?php echo get_string('webmap','theme_aigne');?> ... ">
                <?php echo get_string('webmap','theme_aigne');?></a>
                |<?php } ?>
                <?php if ($hashelp) {?><a href="<?php echo $CFG->wwwroot.$navhelpurl.'?';?>type=2" title="<?php echo get_string('help','theme_aigne');?> ... ">
                <?php echo get_string('help','theme_aigne');?></a>
                |<?php } ?>
                <?php if ($hasfootsearch) {?><a href="<?php echo $CFG->wwwroot.$navhelpurl.'?';?>type=3" title="<?php echo get_string('footsearch','theme_aigne');?> ... ">
                <?php echo get_string('footsearch','theme_aigne');?></a>
                |<?php } ?>
                <?php if ($hasstats) {?><a href="<?php echo $CFG->wwwroot.$navhelpurl.'?';?>type=4" title="<?php echo get_string('stats','theme_aigne');?> ... ">
                <?php echo get_string('stats','theme_aigne');?></a>
                |<?php } ?>
                <?php if ($hasdisclaimer) {?><a href="<?php echo $CFG->wwwroot.$navhelpurl.'?';?>type=5" title="<?php echo get_string('disclaimer','theme_aigne');?> ... ">
                <?php echo get_string('disclaimer','theme_aigne');?></a>
                |<?php } ?>
                <?php if ($haspolicies) {?><a href="<?php echo $CFG->wwwroot.$navhelpurl.'?';?>type=6" title="<?php echo get_string('policies','theme_aigne');?> ... ">
                <?php echo get_string('policies','theme_aigne');?></a>
                |<?php } ?>           
                <?php if ($hasprivacy) {?><a href="<?php echo $CFG->wwwroot.$navhelpurl.'?';?>type=7" title="<?php echo get_string('privacy','theme_aigne');?> ... ">
                <?php echo get_string('privacy','theme_aigne');?></a>
                |<?php } ?>
                <?php if ($hassecurity) {?><a href="<?php echo $CFG->wwwroot.$navhelpurl.'?';?>type=8" title="<?php echo get_string('security','theme_aigne');?> ... ">
                <?php echo get_string('security','theme_aigne');?></a>
                |<?php } ?>
                <?php if ($hasaccessibility) {?><a href="<?php echo $CFG->wwwroot.$navhelpurl.'?';?>type=9" title="<?php echo get_string('accessibility','theme_aigne');?> ... ">
                <?php echo get_string('accessibility','theme_aigne');?></a>
                |<?php } ?>
                <a href="<?php echo $CFG->wwwroot ?>/login/logout.php?sesskey=<?php echo sesskey(); ?>" title="<?php echo get_string('logout');?>">
                <?php echo strtolower(get_string('logout'));?></a>
                |
            <?php } ?>
        </div>
    <?php if ($hasfooter) { ?>
        <!-- Contact information and links _ LEFT(contact) + CENTER(contact note _site adm-> appearance -> themes -> aigne) + RIGHT(social links) -->
        <div class="contact">
            <div class="contact" id="left">
                <?php echo get_string('contact','theme_aigne');?><br>
                <a  href="mailto:<?php echo get_config('moodle','supportemail');?>?subject=Información <?php echo $SITE->fullname;?>" title="<?php echo get_string('sendadminemail','theme_aigne');?>" target="_blank">
            <?php if ($hasemailimg) { ?>
                <img src="<?php echo $PAGE->theme->setting_file_url('emailimg', 'emailimg')?>" alt="email">
            <?php } else { ?>
                <img src="<?php echo $OUTPUT->pix_url('footer/email_img', 'theme')?>" alt="email">
                <img src="<?php echo $OUTPUT->pix_url('footer/email_txt', 'theme')?>" alt="email">                
            <?php } ?>
                </a>
            </div>
            <div class="contact" id="center">
            <?php if ($hascontactnote) { 
                echo $PAGE->theme->settings->contactnote; 
            } ?>
            </div>
            <div class="contact" id="right">
            <?php echo get_string('sociallinks','theme_aigne');?><br>
                <?php if ($hasfacebook) {?><a href="<?php echo $PAGE->theme->settings->facebook;?>" title="::: facebook :::" target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('social/facebook', 'theme')?>" alt="facebook"></a> <?php } ?>
                <?php if ($hastwitter) {?><a href="<?php echo $PAGE->theme->settings->twitter;?>" title="::: twitter :::" target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('social/twitter', 'theme')?>" alt="twitter"></a> <?php } ?>
                <?php if ($hasgoogleplus) {?><a href="<?php echo $PAGE->theme->settings->googleplus;?>" title="::: google + :::" target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('social/googleplus', 'theme')?>" alt="google +"> </a><?php }?>
                <?php if ($hasflickr) {?><a href="<?php echo $PAGE->theme->settings->flickr;?>" title="::: flickr :::" target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('social/flickr', 'theme')?>" alt="flickr"></a> <?php } ?>
                <?php if ($haspicasa) {?><a href="<?php echo $PAGE->theme->settings->picasa;?>" title="::: picasa :::" target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('social/picasa', 'theme')?>" alt="picasa"></a> <?php } ?>
                <?php if ($hasinstagram) {?><a href="<?php echo $PAGE->theme->settings->instagram;?>" title="::: instagram :::" target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('social/instagram', 'theme')?>" alt="instagram"></a> <?php } ?>
                <?php if ($haslinkedin) {?><a href="<?php echo $PAGE->theme->settings->linkedin;?>" title="::: linked in :::" target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('social/linkedin', 'theme')?>" alt="linked in"></a> <?php } ?>
                <?php if ($hasyoutube) {?><a href="<?php echo $PAGE->theme->settings->youtube;?>" title="::: youtube :::" target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('social/youtube', 'theme')?>" alt="youtube"></a> <?php } ?>
                <?php if ($hasvimeo) {?><a href="<?php echo $PAGE->theme->settings->vimeo;?>" title="::: vimeo :::" target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('social/vimeo', 'theme')?>" alt="vimeo"></a> <?php } ?>
            </div>
        </div>
        <!-- Credits information and links _ TOP(moodle link) + MIDDLE(compatibility links) + BOTTOM(foot note _site adm-> appearence -> theme -> aigne) -->
        <div class="credits">
            <?php if ($hasmoodlecredit) { 
                echo get_string('powered','theme_aigne');?>
                <a href="http://moodle.org" title="   Moodle   " target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('footer/moodle-logo','theme')?>" alt="Moodle logo" width="80" height="20"></a>
                   :::   
                <a href="http://moodle.org/plugins/view.php?plugin=theme_afterburner" title="   moodle theme afterburner   "  target="_blank">
                <?php echo get_string('original_theme','theme_aigne');?></a>
            <?php } ?>
            <?php if ($hascompatcredit) {?>
                <br>
                <!-- WIA CSS Validator -->
                <a href="http://jigsaw.w3.org/css-validator/#validate_by_upload" title="   WIA CSS Validator   " target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('footer/vcss-blue','theme')?>" alt="CSS válido _ WIA CSS Validator" width="57" height="20"></a>
                <!-- WIA WAI Validator -->
                <a href="http://www.w3.org/WAI/WCAG1AAA-Conformance" title="   WIA WAI Validator   " target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('footer/wcag1AAA-blue','theme')?>" alt="triple AAA Compliance _ WIA WAI Validator" width="57" height="20"></a>
                <!-- WIA HTML 4.0 Validator -->
                <a href="http://validator.w3.org/check?uri=referer" title="   WIA HTML 4.0 Validator   " target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('footer/w3chtml40','theme')?>" alt="WIA HTML 4.0 Validator" width="57" height="20"></a>
                <!-- Cynthia Validator -->
                <a href="http://www.cynthiasays.com/" title="   Cynthia Validator   " target="_blank">
                <img src="<?php echo $OUTPUT->pix_url('footer/CynthiaTest','theme')?>" alt="Cynthia Validator" width="57" height="20"></a>
            <?php } ?>
            <?php if ($hasfootnote) {?>
                <br>
                <?php echo $PAGE->theme->settings->footnote;?>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<!-- 04 bottom section _ LEGACY _ leave this empty -->
<div id="bottom_4">
    
</div>
<!-- 05 bottom section _ copyright -->
<div id="copyright">
    <?php if ($hascopyrightstg) {
        echo $PAGE->theme->settings->copyrightstg;
    } Else { 
        echo $SITE->shortname;?> © <?php echo gmdate("Y");
    } ?>
    <?php if ($hassitelicensemsg) {?>    :::   <?php echo get_string($CFG->sitedefaultlicense,'license');} ?>
    <?php if ($haslastmodifiedmsg) {?>    :::   <?php echo get_string('lastpageupdate','theme_aigne'). gmdate('d.m.Y');} ?>
    <?php if ($hasthanksvisitmsg) {?>    :::   <?php echo get_string('thanksvisit','theme_aigne');} ?>
</div>
