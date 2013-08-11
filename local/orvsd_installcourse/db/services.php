<?php

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
 * Web service local plugin template external functions and service definitions.
 *
 * @package    local
 * @subpackage orvsd_installcourse
 * @copyright  2013 OSU Open Source Lab (http://osuosl.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// We defined the web service functions to install.
$functions = array(
        'local_orvsd_installcourse_install_course' => array(
                'classname'   => 'local_orvsd_installcourse_external',
                'methodname'  => 'install_course',
                'classpath'   => 'local/orvsd_installcourse/externallib.php',
                'description' => 'Given a course filename and user info, creates a course via file restore and assigns the given user to it.',
                'type'        => 'write',
        )
);

// We define the services to install as pre-build services. A pre-build service is not  editable by administrator.
$services = array(
        'Install Course' => array(
                'functions' => array ('local_orvsd_installcourse_install_course'),
                'restrictedusers' => 0,
                'enabled'=>1,
        )
);

