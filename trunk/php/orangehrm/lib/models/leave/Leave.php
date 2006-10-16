<?php

/*
 *
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures 
 * all the essential functionalities required for any enterprise. 
 * Copyright (C) 2006 hSenid Software International Pvt. Ltd, http://www.hsenid.com
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

require_once ROOT_PATH . '/lib/dao/DMLFunctions.php';
require_once ROOT_PATH . '/lib/dao/SQLQBuilder.php';

class Leave {
	
	/*
	 *	Leave Status Constants
	 *
	 **/
	
	public  $statusLeaveCancelled = 0;
	public $statusLeavePendingApproval = 1;
	public $statusLeaveApproved = 2;
	public $statusLeaveTaken = 3;
	
	/*
	 *	Class Attributes
	 *
	 **/

	private $leaveId;
	private $employeeId;
	private $leaveTypeId;
	private $leaveTypeNameTypeId;
	private $leaveTypeName;
	private $dateApplied;
	private $leaveDate;
	private $leaveLength;
	private $leaveStatus;
	private $leaveComments;
	
	/*
	 *
	 *	Class Constructor
	 *
	 **/

	public function __construct() {
		// nothing to do		
	}
	
	/*
	 *	Setter method followed by getter method for each
	 *	attribute
	 *
	 **/

	public function setLeaveId($leaveId) {
		$this->leaveId = $leaveId;
	}
	
	public function getLeaveId() {
		return $this->leaveId;
	}
	
	public function setEmployeeId($employeeId) {
		$this->employeeId = $employeeId;
	}
	
	public function getEmployeeId() {
		return $this->employeeId;
	}
	
	public function setLeaveTypeId($leaveTypeId) {
		$this->leaveTypeId = $leaveTypeId;
	}
	
	public function getLeaveTypeId() {
		return $this->leaveTypeId;
	}
	
	public function setLeaveTypeNameId($leaveTypeNameId) {
		$this->leaveTypeNameId = $leaveTypeNameId;
	}
	
	public function getLeaveTypeNameId() {
		return $this->leaveTypeNameId;
	}
	
	public function setLeaveTypeName($leaveTypeName) {
		$this->leaveTypeName = $leaveTypeName;
	}
	
	public function getLeaveTypeName() {
		return $this->leaveTypeName;
	}	
	
	public function setDateApplied($dateApplied) {		
		$this->dateApplied = $dateApplied;
	}	
	
	public function getDateApplied() {		
		return $this->dateApplied;
	}
	
	public function setLeaveDate($leaveDate) {
		$this->leaveDate = $leaveDate;
	}
		
	public function getLeaveDate() {
		return $this->leaveDate;
	}
	
	public function setLeaveLength($leaveLength) {
		$this->leaveLength = $leaveLength;
	}
	
	public function getLeaveLength() {
		return $this->leaveLength;
	}
	
	public function setLeaveStatus($leaveStatus) {
		$this->leaveStatus = $leaveStatus;
	}
	
	public function getLeaveStatus() {
		return $this->leaveStatus;
	}
	
	public function setLeaveComments($leaveComments) {
		$this->leaveComments = $leaveComments;
	}
	
	public function getLeaveComments() {
		return $this->leaveComments;
	}	

	/*
	 *	Retrieves Leave Details of all leave that have been applied for but
	 *	not yet taken.
	 *
	 *	Returns
	 *	-------
	 *
	 *	A 2D array of the leaves
	 *
	 **/
	
	public function retriveLeaveEmployee($employeeId) {
		
		$sqlBuilder = new SQLQBuilder();		
		
		$arrFields[0] = 'a.`Leave_Date`';
		$arrFields[1] = 'b.`Leave_Type_Name`';
		$arrFields[2] = 'a.`Leave_Status`';
		$arrFields[3] = 'a.`Leave_Length`';
		$arrFields[4] = 'a.`Leave_Comments`';
		$arrFields[5] = 'a.`Leave_ID`';
		
		$arrTables[0] = "`hs_hr_leave` a";
		$arrTables[1] = "`hs_hr_leavetype` b";		
		
		$joinConditions[1] = "a.`Leave_Type_ID` = b.`Leave_Type_ID`";
		
		$selectConditions[0] = "b.`Available_Flag` = 1";

		$selectConditions[1] = "a.`Employee_Id` = '".$employeeId."'";
		$selectConditions[2] = "a.`Leave_Status` != ".$this->statusLeaveCancelled;
		$selectConditions[3] = "a.`Leave_Status` != ".$this->statusLeaveTaken;

		
		$query = $sqlBuilder->selectFromMultipleTable($arrFields, $arrTables, $joinConditions, $selectConditions);
		
		//echo $query;
				
		$dbConnection = new DMLFunctions();	

		$result = $dbConnection -> executeQuery($query);
		
		$leaveArr = null;
		
		while ($row = mysql_fetch_row($result)) {
			
			$tmpLeaveArr = new Leave();
						
			$tmpLeaveArr->setLeaveDate($row[0]);
			$tmpLeaveArr->setLeaveTypeName($row[1]);
			$tmpLeaveArr->setLeaveStatus($row[2]);
			$tmpLeaveArr->setLeaveLength($row[3]);
			$tmpLeaveArr->setLeaveComments($row[4]);
			$tmpLeaveArr->setLeaveId($row[5]);
			
			$leaveArr[] = $tmpLeaveArr;
		}
		
		return $leaveArr; 
	}	
	
	/*
	 *	Add Leave record to for a employee.
	 *
	 *	Returns
	 *	-------
	 *
	 *	A 2D array of the leaves
	 *
	 **/
	

	public function applyLeave ()
	{
		$this->_addLeave();
	}

	public function cancelLeave($id) {
		$this->setLeaveId($id);
		$this->setLeaveStatus($this->statusLeaveCancelled);
		return $this->_changeLeaveStatus();
	}	

	

	private function _addLeave() {
		
		$this->_getNewLeaveId();
		$this->setDateApplied(date('Y-m-d'));
		
		$arrRecordsList[0] = $this->getLeaveId($this->_getNewLeaveId());
		$arrRecordsList[1] = "'". $this->getEmployeeId() . "'";
		$arrRecordsList[2] = "'".$this->getLeaveTypeId()."'";
		$arrRecordsList[3] = $this->getLeaveTypeNameId();
		$arrRecordsList[4] = "'". $this->getDateApplied()."'";
		$arrRecordsList[5] = "'". $this->getLeaveDate()."'";
		$arrRecordsList[6] = "'". $this->getLeaveLength()."'";
		$arrRecordsList[7] = $this->statusLeavePendingApproval;
		$arrRecordsList[8] = "'". $this->getLeaveComments()."'";
		
		
		$sqlBuilder = new SQLQBuilder();
					
		$arrTable = "`hs_hr_leave`";
		
		//print_r($arrRecordsList);	
		
		$query = $sqlBuilder->simpleInsert($arrTable, $arrRecordsList);
		
		//echo  $query;
		
		$dbConnection = new DMLFunctions();	

		$result = $dbConnection -> executeQuery($query);
		
	}
	
	private function _getNewLeaveId() {		
		
		$sql_builder = new SQLQBuilder();
		
		$selectTable = "`hs_hr_leave`";		
		$selectFields[0] = '`Leave_ID`';
		$selectOrder = "DESC";
		$selectLimit = 1;
		$sortingField = '`Leave_ID`';
		
		$query = $sql_builder->simpleSelect($selectTable, $selectFields, null, $sortingField, $selectOrder, $selectLimit);
		//echo $query;
		$dbConnection = new DMLFunctions();	

		$result = $dbConnection -> executeQuery($query);
		
		$row = mysql_fetch_row($result);
		
		$this->setLeaveId($row[0]+1);
	}

	private function _changeLeaveStatus() {

		$sqlBuilder = new SQLQBuilder();

		$table = "`hs_hr_leave`";

		$changeFields[0] = "`Leave_Status`";

		$changeValues[0] = $this->getLeaveStatus();

		$updateConditions[0] = "`Leave_ID` = ".$this->getLeaveId();

		$query = $sqlBuilder->simpleUpdate($table, $changeFields, $changeValues, $updateConditions);

		//echo $query."\n";

		$dbConnection = new DMLFunctions(); 

		$result = $dbConnection->executeQuery($query);

		if (isset($result) && (mysql_affected_rows() > 0)) {
			return true;
		};

		return false; 
	}
}

?>