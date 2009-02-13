<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 *
 */

require_once ROOT_PATH . '/lib/models/time/AttendanceRecord.php';

class EXTRACTOR_AttendanceRecord {

	public function parsePunchData($postArr) {

		$attendanceObj = new AttendanceRecord();

		if (isset($postArr['hdnAttendanceId'])) {
			$attendanceObj->setAttendanceId($postArr['hdnAttendanceId']);
		}

		$attendanceObj->setEmployeeId($postArr['hdnEmployeeId']);

		if (isset($postArr['txtInDate'])) {
			$attendanceObj->setInDate($postArr['txtInDate']);
		}

		if (isset($postArr['txtInTime'])) {
			$attendanceObj->setInTime($postArr['txtInTime']);
		}

		if (isset($postArr['txtInNote'])) {
			$attendanceObj->setInNote($postArr['txtInNote']);
		}

		if (isset($postArr['txtOutDate'])) {
			$attendanceObj->setOutDate($postArr['txtOutDate']);
		}
		if (isset($postArr['txtOutTime'])) {
			$attendanceObj->setOutTime($postArr['txtOutTime']);
		}

		if (isset($postArr['txtOutNote'])) {
			$attendanceObj->setOutNote($postArr['txtOutNote']);
		}

		return $attendanceObj;

	}

	public function parseReportData($postArr) {

		$parsedObjs = array();

		for ($i=0; $i<$postArr['recordsCount']; $i++)	{

			$attendanceRecordObj = new AttendanceRecord();
			$changed = false;
			
			if (trim($postArr['txtNewInDate-'.$i]) != $postArr['hdnOldInDate-'.$i]) {
				$changed = true;
			}

			if (trim($postArr['txtNewInTime-'.$i]) != $postArr['hdnOldInTime-'.$i]) {
				$changed = true;
			}

			if (trim($postArr['txtNewInNote-'.$i]) != $postArr['hdnOldInNote-'.$i]) {
				$changed = true;
			}

			if (trim($postArr['txtNewOutDate-'.$i]) != $postArr['hdnOldOutDate-'.$i]) {
				$changed = true;
			}

			if (trim($postArr['txtNewOutTime-'.$i]) != $postArr['hdnOldOutTime-'.$i]) {
				$changed = true;
			}

			if (trim($postArr['txtNewOutNote-'.$i]) != $postArr['hdnOldOutNote-'.$i]) {
				$changed = true;
			}
			
			if (isset($postArr['chkDeleteStatus-'.$i])) {
				$attendanceRecordObj->setStatus(AttendanceRecord::STATUS_DELETED);
				$changed = true;
			}

			if ($changed) {
				/* Even if only one value is changed, setting other properties 
				 * is required to carry out functions like checking overlapping
				 */
				$attendanceRecordObj->setAttendanceId($postArr['hdnAttendanceId-'.$i]);
				$attendanceRecordObj->setEmployeeId($postArr['hdnEmployeeId']);
				$attendanceRecordObj->setInDate(trim($postArr['txtNewInDate-'.$i]));
				$attendanceRecordObj->setInTime(trim($postArr['txtNewInTime-'.$i]));
				$attendanceRecordObj->setInNote(trim($postArr['txtNewInNote-'.$i]));
				$attendanceRecordObj->setOutDate(trim($postArr['txtNewOutDate-'.$i]));
				$attendanceRecordObj->setOutTime(trim($postArr['txtNewOutTime-'.$i]));
				$attendanceRecordObj->setOutNote(trim($postArr['txtNewOutNote-'.$i]));
			    $parsedObjs[] = $attendanceRecordObj;
			}

		}

		return $parsedObjs;

	}

}

?>
