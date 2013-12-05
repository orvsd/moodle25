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
 * Slideshow block
 *
 * This is a simple block that allows a user to embed a slideshow just below the 
 * header of either the frontpage of a site or a coursepage.  The slideshow is based
 * on jquery cycle.
 *
 * @package    block_slideshow
 * @category   blocks
 * @copyright  2013 Paul Prenis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


$settings->add(new admin_setting_heading( 'headerconfig',
            get_string('headerconfig', 'block_slideshow'),
            get_string('descconfig', 'block_slideshow')
        ));
$settings->add(new admin_setting_configselect( 'slideshow/Max_Slides',
            get_string('labelmaxslides', 'block_slideshow'),
            get_string('descmaxslides', 'block_slideshow'),
            '5',
            array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12',13=>'13',14=>'14',15=>'15')
		));
$settings->add(new admin_setting_configselect( 'slideshow/Max_Size',
            get_string('labelmaxsize', 'block_slideshow'),
            get_string('descmaxsize', 'block_slideshow'),
            '1048576',
            array(32768=>'32 KB', 65536=>'64 KB', 131072=>'128 KB', 262144=>'256 KB', 524288=>'512 KB', 1048576=>'1 MB', 2097152=>'2 MB', 4194304=>'4 MB', 8388608=>'8 MB', 16777216=>'16 MB', 33554432=>'32 MB')
		));
