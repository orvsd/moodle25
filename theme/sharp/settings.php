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

/**
 * Theme version info
 *
 * @package    theme
 * @subpackage sharp
 * @copyright � 2012 - 2013 | 3i Logic (Pvt) Ltd.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    global $CFG;
    // Logo file setting
    $name = 'theme_sharp/logo';
    $title = get_string('logo', 'theme_sharp');
    $description = get_string('logodesc', 'theme_sharp');
    $default = $CFG->wwwroot.'/theme/sharp/pix/rubix.png';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $settings->add($setting);

    // Link color setting
    $name = 'theme_sharp/linkcolor';
    $title = get_string('linkcolor', 'theme_sharp');
    $description = get_string('linkcolordesc', 'theme_sharp');
    $default = '#2d83d5';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // Tag line setting
    $name = 'theme_sharp/tagline';
    $title = get_string('tagline', 'theme_sharp');
    $description = get_string('taglinedesc', 'theme_sharp');
    $setting = new admin_setting_configtextarea($name, $title, $description, '');
    $settings->add($setting);

    // Foot note setting
    $name = 'theme_sharp/footertext';
    $title = get_string('footertext', 'theme_sharp');
    $description = get_string('footertextdesc', 'theme_sharp');
    $setting = new admin_setting_confightmleditor($name, $title, $description, '');
    $settings->add($setting);

    // Custom CSS file
    $name = 'theme_sharp/customcss';
    $title = get_string('customcss', 'theme_sharp');
    $description = get_string('customcssdesc', 'theme_sharp');
    $setting = new admin_setting_configtextarea($name, $title, $description, '');
    $settings->add($setting);
}