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
 * @subpackage orvsd_siteinfo
 * @copyright  2013 OSU Open Source Lab (http://osuosl.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// we defined the webservice functions to install
$functions = array(
	'local_orvsd_siteinfo_siteinfo' => array(
		'classname'   => 'local_orvsd_siteinfo_external',
		'methodname'  => 'siteinfo',
		'classpath'   => 'local/orvsd_siteinfo/externallib.php',
		'description' => 'Given a number of days (e.g., 7) gives the site info from that far back until the present',
		'type'	      => 'write',
	),
);

// We define the services to install as pre-build services. A pre-build service is not editable by administrator.
$services = array(
	'Site Info' => array(
		'shortname' => 'orvsd_siteinfo',
		'functions' => array ('local_orvsd_siteinfo_siteinfo'),
		'restrictedusers' => 0,
		'enabled'=>1,
	),
);
