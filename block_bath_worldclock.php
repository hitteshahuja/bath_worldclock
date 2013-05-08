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
 	
	public $server_timezone = '';
 	
	public function init(){
		$this->title = get_string('pluginname','block_bath_worldclock');
		if(date_default_timezone_get()){
			$this->server_timezone = date_default_timezone_get();
		}
	}
	public function get_content(){
		  if ($this->content !== null) {
      	return $this->content;
    	}
    	$block_instance =  $this->instance->id;
		  $module              = array(
            'name' => 'bath_worldclock',
            'fullpath' => '/blocks/bath_worldclock/module.js'
        );
		 $this->page->requires->js_init_call('M.WorldClock.init', array(
            array()
        ), false, $module);
		$this->content         =  new stdClass;
    	$this->content->text   = "<div id=\"block_worldclock\">";
    	$this->content->text .= "<ul id=\"clocklist\">";
		$this->content->text .= "<li>".$this->university_time_box()."</li>";
    	$this->content->text .= "<li><div class=\"university_box\">Dublin /Ireland</div></li>";
		$this->content->text .= "<li><div class=\"university_box\">Kolkata /India</div></li>";
		$this->content->text .= $this->get_boxes($block_instance);
    	$this->content->text .= "</ul>";
		$this->content->text .= "<div id=\"add_clock\" ><a href = \"#\" onClick = \"\">Add New Clock</a></div>";
    	$this->content->text .= $this->get_timezones();
    	$this->content->text .= "</div>";
		return $this->content;
	}
	protected function university_time_box()
	{
		global $OUTPUT;
		if($this->server_timezone)
		{
			$container =  $OUTPUT->container_start('university_box');
			$container .= $this->server_timezone;
			$container .= $OUTPUT->container_end();
			
		}
		return $container;
	}
	protected function get_boxes($block_instance){
		global $DB;
		$sql = " SELECT tz.name,tz.tzrule FROM {block_bath_worldclock} wc 
		JOIN {timezone} tz ON tz.id = wc.timezoneid WHERE wc.blockinstanceid = ?";
		$result = $DB->get_records_sql($sql,array($block_instance));
		$html_box = "";
		foreach($result as $objTZ)
		{
			$html_box .= "";
			echo $this->timezone_time($objTZ);
			$html_box .= "<li><div class=\"university_box\">$objTZ->name </div></li>";
		}
		return $html_box;
	}
	protected function timezone_time($objTZ){
		if(is_object($objTZ)){
			date_default_timezone_set($objTZ->name);
			echo date('h:m:s')."<br/>";
		}
	}
	protected function get_timezones(){
		global $OUTPUT,$DB;
		$sql = "SELECT DISTINCT(name) FROM {timezone} ORDER BY name ";
		$timezones = $DB->get_records_sql($sql);
		$select = "<span>Select Timezone:</span>";
		$select .= "<select name=\"timezone\" id='timezoneselect'>";
		foreach($timezones as $tz)
		{
			$select .="<option>$tz->name</option>";
		}
		$select .= "</select>";
		$container =  $OUTPUT->container_start('timezone_selector');
		$container .= $select;
		$container .= $OUTPUT->container_end();
		return $container;
	}
	 
 }
