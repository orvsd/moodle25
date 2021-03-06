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
 * Header element.
 *
 * @package   theme_oauth2easy
 * @copyright 2013 Frédéric Massart
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die(); ?>

<header id="page-header" class="clearfix">
    <?php echo $OUTPUT->page_heading(); ?>
    <div id="page-navbar" class="clearfix">
        <div class="breadcrumb-nav"><?php echo $OUTPUT->navbar(); ?></div>
        <nav class="breadcrumb-button"><?php echo $OUTPUT->page_heading_button(); ?></nav>
    </div>
    <div id="course-header">
        <?php echo $OUTPUT->course_header(); ?>
    </div>
</header>

<?php
if (exists_auth_plugin('googleoauth2')) {
    $loginpage = ((string)$this->page->url === get_login_url());
    if (!empty($loginpage)) {
        require_once($CFG->dirroot . '/auth/googleoauth2/lib.php');
        auth_googleoauth2_display_buttons();
    }
}
?>