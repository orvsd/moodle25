This file is part of Moodle - http://moodle.org/

Moodle is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Moodle is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

copyright 2013 OSU Open Source Lab (http://osuosl.org)
license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

====================
ORVSD Install Course
====================

This plugin provides a web service that can be used to install courses
into a Moodle site. It creates a new course with the correct structure
and then restores a backup file of that course into the newly created
course shell.

This plugin should be called witht he following parameters:

'filepath'    Where the backup file is located (absolute path)
'file'        The backup filename
'courseid'    The OSL course id (serial + version + updated)
'coursename'  The course full name
'shortname'   The course shortname (must be unique in the Moodle site)
'category'    The course category (integer, usually '1' for Miscellaneous)
'username'    A username - if not "none", this user will be assigned the 
                role of 'Teacher' in the installed course. The user will
                be created if they do not exist in the site. The following
                properties are used to create the new user, but are 
                required even if username is "none". 
'firstname'   The user first name
'lastname'    The user last name
'city'        The user city
'email'       The user email
'pass'        The user password


This plugin requires the ORVSD Coursemeta plugin

-------
INSTALL
-------

Place the orvsd_installcourse directory in local/ in your Moodle's
webroot.

