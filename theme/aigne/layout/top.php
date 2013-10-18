<?php 
/**
 * top-of-the-page section _ Moodle adaptation
 * 
 * @package    theme_aigne
 * @copyright  1997 Franc Pombal (www.aigne.com)
 * @license    http: *www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!empty($PAGE->theme->settings->slogan)) {
    $slogan = $PAGE->theme->settings->slogan;
} else {
    $slogan = '';
}

$haslogininfo = (empty($PAGE->layout_options['nologininfo']));
$haslangmenu = (!empty($PAGE->layout_options['langmenu']));
?>

<div id="headerlogo">
    <a href="<?php echo $CFG->wwwroot; ?>" title="<?php print_string('home'); ?>">
        <div class="logo"></div>
        <p class="slogan"><?php echo $slogan ?></p>
    </a>
</div>

<div id="headeroptions">
    <table class="headerop">
         <tr Style="height:25px">
            <td Style="width:20%; background-color:#322C65" colspan=5>&nbsp;</td>
            <td Style="width:20%; background-color:#007EBA" colspan=5>&nbsp;</td>
            <td Style="width:20%; background-color:#CCDDEE" colspan=5>&nbsp;</td>
            <td Style="width:40%; background-color:#F3F7FF; text-align:right" colspan=10>
                <?php if ($haslogininfo) {
                    echo $OUTPUT->login_info();
                } ?>
            </td>
        </tr>
        <tr Style="height:25px">
            <td Style="width:10%;" colspan=3>&nbsp;</td>
            <td Style="width:4%; background-color:#CCDDEE" colspan=1>&nbsp;</td>
            <td Style="width:4%; background-color:#CCDDEE; font-size: 90%" colspan=1>
                <button id="decfontsize" title="<?php echo get_string('decfontsizetxt','theme_aigne'); ?>" onclick="alert('<?php echo get_string('noimplemented','theme_aigne'); ?>')">-A</button>
            </td>
            <td Style="width:4%; background-color:#CCDDEE" colspan=1>
                <button id="defaultfontsize" title="<?php echo get_string('defaultfontsizetxt','theme_aigne'); ?>" onclick="alert('<?php echo get_string('noimplemented','theme_aigne'); ?>')">A</button>
            </td>
            <td Style="width:4%; background-color:#CCDDEE; font-size: 110%" colspan=1>
                <button id="incfontsize" title="<?php echo get_string('incfontsizetxt','theme_aigne'); ?>" onclick="alert('<?php echo get_string('noimplemented','theme_aigne'); ?>')">+A</button>
            </td>
            <td Style="width:4%; background-color:#CCDDEE" colspan=1>&nbsp;</td>
            <td Style="width:20%" colspan=5>&nbsp;</td>
            <td Style="width:4%; background-color:#322C65" colspan=1>
                <button id="style2" title="<?php echo get_string('styletxt','theme_aigne'); ?>" onclick="alert('<?php echo get_string('noimplemented','theme_aigne'); ?>')">   </button>
            </td>
            <td Style="width:4%; background-color:#CCDDEE" colspan=1>
                <button id="defaultstyle" title="<?php echo get_string('defaultstyletxt','theme_aigne'); ?>" onclick="alert('<?php echo get_string('noimplemented','theme_aigne'); ?>')">   </button>
            </td>
            <td Style="width:4%; background-color:#004040" colspan=1>
                <button id="style3" title="<?php echo get_string('styletxt','theme_aigne'); ?>" onclick="alert('<?php echo get_string('noimplemented','theme_aigne'); ?>')">   </button>
            </td>
            <td Style="width:4%; background-color:#EB8324" colspan=1>
                <button id="style4" title="<?php echo get_string('styletxt','theme_aigne'); ?>" onclick="alert('<?php echo get_string('noimplemented','theme_aigne'); ?>')">   </button>
            </td>
            <td Style="width:4%; background-color:#990000" colspan=1>
                <button id="style5" title="<?php echo get_string('styletxt','theme_aigne'); ?>" onclick="alert('<?php echo get_string('noimplemented','theme_aigne'); ?>')">   </button>
            </td>
            <td Style="width:22%; min-width:220px; background-color:#CCDDEE" colspan=5>
                <?php if ($haslangmenu) {
                    echo $OUTPUT->lang_menu();
                } ?>
            </td>
            <td Style="width:8%" colspan=2>&nbsp;</td>
        </tr>
    </table>
<?php echo $PAGE->headingmenu ?>
</div>

