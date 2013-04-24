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
 * World Clock Block page.
 *
 * @package    block
 * @subpackage bath_worldclock
 * @copyright  2013 University of Bath
 * @author     2013 Hittesh Ahuja
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

/**
 * The World Clock block class
 */
 class block_bath_worldclock extends block_base {
 	
	public function init(){
		$this->title = get_string('pluginname','block_bath_worldclock');
	}
	public function get_content(){
		  if ($this->content !== null) {
      	return $this->content;
    	}
		$this->content         =  new stdClass;
    	$this->content->text   = 'The content of our SimpleHTML block!';
    	$this->content->footer = 'Footer here...';  
		return $this->content;
	}
 }