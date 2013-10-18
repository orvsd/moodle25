<?php
/**
 * Theme version info
 *
 * @package    theme_aigne
 * @copyright  2013 Franc Pombal (www.aigne.com) after @copyright 2011 Mary Evans
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

// Plugin version (update when tables change)
$plugin->version   = 2013050100;

// Required Moodle version  // 2.5 -> Build: 2013050100
$plugin->requires  = 2013050100;

// Full name of the plugin (used for diagnostics)
$plugin->component = 'theme_aigne';

$plugin->dependencies = array(
    'theme_base'  => 2013050100,
);

// Software maturity level
$plugin->maturity = MATURITY_STABLE;

// User-friendly version number
$plugin->release = '1.2.0';

//END OF FILE
