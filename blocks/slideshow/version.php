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


$plugin->version = 2013091800; // YYYYMMDDHH (year, month, day, 24-hr time) 
$plugin->requires = 2013040500 ; // YYYYMMDDHH (This is the release version for Moodle 2.0)
$plugin->maturity = MATURITY_BETA;
$plugin->release = "0.5.0";