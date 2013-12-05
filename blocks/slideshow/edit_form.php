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

	class block_slideshow_edit_form extends block_edit_form {
		protected function specific_definition($mform) {
		
			$maximages = get_config('slideshow', 'Max_Slides');
			$maxsize = get_config('slideshow', 'Max_Size');

			$mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
			
			$mform->addElement('text', 'config_title', get_string('blocktitle', 'block_slideshow'));
			$mform->setDefault('config_title', '');
			$mform->addHelpButton('config_title', 'blocktitle', 'block_slideshow');
			$mform->setType('config_title', PARAM_MULTILANG);

			$mform->addElement('text', 'config_height', get_string('blockheight', 'block_slideshow'));
			$mform->setDefault('config_height', '200');
			$mform->addRule('config_height', get_string('blockheighterror', 'block_slideshow'), 'numeric', '/^[1-9][0-9]*$/', 'server', false, false);
			$mform->addHelpButton('config_height', 'blockheight', 'block_slideshow');
			$mform->setType('config_height', PARAM_RAW);
			
			$blindX = format_string(get_string('blindX', 'block_slideshow')); 
			$blindY = format_string(get_string('blindY', 'block_slideshow')); 
			$blindZ = format_string(get_string('blindZ', 'block_slideshow')); 
			$cover = format_string(get_string('cover', 'block_slideshow')); 
			$curtainX = format_string(get_string('curtainX', 'block_slideshow')); 
			$curtainY = format_string(get_string('curtainY', 'block_slideshow')); 
			$fade = format_string(get_string('fade', 'block_slideshow')); 
			$fadeZoom = format_string(get_string('fadeZoom', 'block_slideshow')); 
			$growX = format_string(get_string('growX', 'block_slideshow')); 
			$growY = format_string(get_string('growY', 'block_slideshow')); 
			$none = format_string(get_string('none', 'block_slideshow')); 
			$scrollUp = format_string(get_string('scrollUp', 'block_slideshow')); 
			$scrollDown = format_string(get_string('scrollDown', 'block_slideshow')); 
			$scrollLeft = format_string(get_string('scrollLeft', 'block_slideshow')); 
			$scrollRight = format_string(get_string('scrollRight', 'block_slideshow')); 
			$scrollHorz = format_string(get_string('scrollHorz', 'block_slideshow')); 
			$scrollVert = format_string(get_string('scrollVert', 'block_slideshow')); 
			$shuffle = format_string(get_string('shuffle', 'block_slideshow')); 
			$slideX = format_string(get_string('slideX', 'block_slideshow')); 
			$slideY = format_string(get_string('slideY', 'block_slideshow')); 
			$toss = format_string(get_string('toss', 'block_slideshow')); 
			$turnUp = format_string(get_string('turnUp', 'block_slideshow')); 
			$turnDown = format_string(get_string('turnDown', 'block_slideshow')); 
			$turnLeft = format_string(get_string('turnLeft', 'block_slideshow')); 
			$turnRight = format_string(get_string('turnRight', 'block_slideshow')); 
			$uncover = format_string(get_string('uncover', 'block_slideshow')); 
			$wipe = format_string(get_string('wipe', 'block_slideshow')); 
			$zoom = format_string(get_string('zoom', 'block_slideshow')); 
			
			$transitions = array(	
				'blindX'=>$blindX, 
				'blindY'=>$blindY, 
				'blindZ'=>$blindZ, 
				'cover'=>$cover, 
				'curtainX'=>$curtainX, 
				'curtainY'=>$curtainY, 
				'fade'=>$fade, 
				'fadeZoom'=>$fadeZoom, 
				'growX'=>$growX, 
				'growY'=>$growY, 
				'none'=>$none, 
				'scrollUp'=>$scrollUp, 
				'scrollDown'=>$scrollDown, 
				'scrollLeft'=>$scrollLeft, 
				'scrollRight'=>$scrollRight, 
				'scrollHorz'=>$scrollHorz, 
				'scrollVert'=>$scrollVert, 
				'shuffle'=>$shuffle, 
				'slideX'=>$slideX, 
				'slideY'=>$slideY, 
				'toss'=>$toss, 
				'turnUp'=>$turnUp, 
				'turnDown'=>$turnDown, 
				'turnLeft'=>$turnLeft, 
				'turnRight'=>$turnRight, 
				'uncover'=>$uncover, 
				'wipe'=>$wipe, 
				'zoom'=>$zoom
			);
			$mform->addElement('select', 'config_transition', get_string('transition', 'block_slideshow'), $transitions);
			$mform->setDefault('config_transition', 'fade');
			$mform->addHelpButton('config_transition', 'transition', 'block_slideshow');
			$mform->setType('config_transition', PARAM_RAW);
			
			$second = format_string(get_string('second', 'block_slideshow'));
			$seconds = format_string(get_string('seconds', 'block_slideshow'));
			$quarter = format_string(get_string('quarter', 'block_slideshow'));
			$tenth = format_string(get_string('tenth', 'block_slideshow'));
			$half = format_string(get_string('half', 'block_slideshow'));
			
			$delay = array(	1000=>'1 ' . $second, 
							2000=>'2 ' . $seconds, 
							3000=>'3 ' . $seconds, 
							4000=>'4 ' . $seconds, 
							5000=>'5 ' . $seconds, 
							6000=>'6 ' . $seconds, 
							7000=>'7 ' . $seconds, 
							8000=>'8 ' . $seconds, 
							9000=>'9 ' . $seconds, 
							10000=>'10 ' . $seconds, 
							11000=>'11 ' . $seconds, 
							12000=>'12 ' . $seconds
			);
			$mform->addElement('select', 'config_slidedelay', get_string('slidedelay', 'block_slideshow'), $delay);
			$mform->setDefault('config_slidedelay', '4000');
			$mform->addHelpButton('config_slidedelay', 'slidedelay', 'block_slideshow');
			$mform->setType('config_slidedelay', PARAM_RAW);

			$tdelay = array(	100=>$tenth,
							250=>$quarter,
							500=>$half,
							1000=>'1 ' . $second, 
							2000=>'2 ' . $seconds, 
							3000=>'3 ' . $seconds, 
							4000=>'4 ' . $seconds, 
							5000=>'5 ' . $seconds
			);

			$mform->addElement('select', 'config_slidespeed', get_string('slidespeed', 'block_slideshow'), $tdelay);
			$mform->setDefault('config_slidespeed', '2000');
			$mform->addHelpButton('config_slidespeed', 'slidespeed', 'block_slideshow');
			$mform->setType('config_slidespeed', PARAM_RAW);

			$mform->addElement('text', 'config_background', get_string('background', 'block_slideshow'),array('ONCLICK'=> '$("#id_config_background").spectrum({change: function(color) {$("#id_config_background").text(color.toHexString());}});'));
			$mform->setDefault('config_background', '#000000');
			$mform->addHelpButton('config_background', 'background', 'block_slideshow');
			$mform->setType('config_background', PARAM_RAW);
			
			$mform->addElement('advcheckbox', 'config_transparent', get_string('transparent', 'block_slideshow'), get_string('transparentlabel', 'block_slideshow'), array('group' => 1), array(0, 1));
			$mform->addHelpButton('config_transparent', 'transparent', 'block_slideshow');

			$mform->addElement('advcheckbox', 'config_normalblock', get_string('normalblock', 'block_slideshow'), get_string('normalblocklabel', 'block_slideshow'), array('group' => 1), array(0, 1));
			$mform->addHelpButton('config_normalblock', 'normalblock', 'block_slideshow');
			
			$mform->addElement('filemanager', 'config_image', get_string('imagefile', 'block_slideshow'), null,
							array('subdirs' => 0, 'maxbytes' => $maxsize, 'maxfiles' => $maximages,
							'accepted_types' => array('.png', '.jpg', '.gif') ));
			$mform->addHelpButton('config_image', 'imagefile', 'block_slideshow');

    		
		}
		
		function set_data($defaults) {
	    
			if (empty($entry->id)) {
			    $entry = new stdClass;
			    $entry->id = null;
			}
 
			$draftitemid = file_get_submitted_draft_itemid('config_image');
 
			file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_slideshow', 'content', 0,
                        array('subdirs'=>true));
 
			$entry->attachments = $draftitemid;
 
			parent::set_data($defaults);	    

			if ($data = parent::get_data()) {
    
				file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_slideshow', 'content', 0, 
					array('subdirs' => true));
			}

		}
		

	
}