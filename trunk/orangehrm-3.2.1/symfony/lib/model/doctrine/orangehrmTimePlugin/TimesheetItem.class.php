<?php

/**
 * TimesheetItem
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class TimesheetItem extends PluginTimesheetItem
{
    	public function getConvertTime() {
		$timesheetService = new TimesheetService();
		$timeInSecs = $this->getDuration();
		if ($timeInSecs == null) {
			return null;
		} else {
			return $timesheetService->convertDurationToHours($this->getDuration());
		}
	}

	function addConvertedTime($oldPlayTime, $PlayTimeToAdd) {

		$old = explode(":", $oldPlayTime);
		$play = explode(":", $PlayTimeToAdd);
		$hours = $old[0] + $play[0];
		$minutes = $old[1] + $play[1];
		if ($minutes > 59) {

			$minutes = $minutes - 60;
			$hours++;
		}
		if ($minutes < 10) {
			$minutes = "0" . $minutes;
		}
		if ($minutes == 0) {
			$minutes = "00";
		}
		$sum = $hours . ":" . $minutes;
		return $sum;
	}
    
    
}
