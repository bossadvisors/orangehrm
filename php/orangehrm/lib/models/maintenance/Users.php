<?
/*
// OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures 
// all the essential functionalities required for any enterprise. 
// Copyright (C) 2006 hSenid Software International Pvt. Ltd, http://www.hsenid.com

// OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
// the GNU General Public License as published by the Free Software Foundation; either
// version 2 of the License, or (at your option) any later version.

// OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
// without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// See the GNU General Public License for more details.

// You should have received a copy of the GNU General Public License along with this program;
// if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
// Boston, MA  02110-1301, USA
*/

require_once ROOT_PATH . '/lib/confs/Conf.php';
require_once ROOT_PATH . '/lib/dao/DMLFunctions.php';
require_once ROOT_PATH . '/lib/dao/SQLQBuilder.php';
require_once ROOT_PATH . '/lib/common/CommonFunctions.php';

class Users {
	var $tableName = 'hs_hr_users';
	
	var $userID;
	var $userName;
	var $userPassword;
	var $userFirstName;
	var $userLastName;
	var $userEmpID;
	var $userIsAdmin;	
	var $userDateEntered;
	var $userDateModified;
	var $userModifiedBy;
	var $userCreatedBy;
	var $userStatus;	
	var $userGroupID;	
	var $arrayDispList;
	
	
	function Users() {
		$this->sql_builder = new SQLQBuilder();
		$this->dbConnection = new DMLFunctions();		
	}
	
	function setUserID($userID){
		$this->userID = $userID;
	}
	
	function setUserName($userName){
		$this->userName = $userName;
	}
	
	function setUserPassword($userPassword) {
		$this->userPassword=$userPassword;
	}
	
	function setUserFirstName($userFirstName) {
		$this->userFirstName=$userFirstName;
	}
	
	function setUserLastName($userLastName) {
		$this->userLastName=$userLastName;
	}
	
	function setUserEmpID($userEmpID) {
		$this->userEmpID=$userEmpID;
	}
	
	function setUserIsAdmin($userIsAdmin) {
		$this->userIsAdmin=$userIsAdmin;
	}
		
	function setUserDateEntered($userDateEntered) {
		$this->userDateEntered=$userDateEntered;
	}
	
	function setUserDateModified($userDateModified) {
		$this->userDateModified=$userDateModified;
	}
	
	function setUserModifiedBy($userModifiedBy) {
		$this->userModifiedBy=$userModifiedBy;
	}
	
	function setUserCreatedBy($userCreatedBy) {
		$this->userCreatedBy=$userCreatedBy;
	}
	
	function setUserStatus($userStatus){
		$this->userStatus=$userStatus;
	}
	
	function setUserAddress($userAddress) {
		$this->userAddress=$userAddress;
	}
		
	function setUserGroupID($userGroupID) {
		$this->userGroupID=$userGroupID;
	}
///	
	function getUserID(){
		return $this->userID;
	}
	
	function getUserName(){
		return $this->userName;
	}
	
	function getUserPassword() {
		return $this->userPassword;
	}
	
	function getUserFirstName() {
		return $this->userFirstName;
	}

	function getUserEmpID() {
		return $this->userEmpID;
	}
	
	function getUserIsAdmin() {
		return $this->userIsAdmin;
	}
	
	function getUserDesc() {
		return $this->userDesc;
	}
	
	function getUserDateEntered() {
		return $this->userDateEntered;
	}
	
	function getUserDateModified() {
		return $this->userDateModified;
	}
	
	function getUserModifiedBy() {
		return $this->userModifiedBy;
	}
	
	function getUserCreatedBy() {
		return $this->userCreatedBy;
	}
	
	function getUserDepartment() {
		return $this->userDepartment;
	}
	
	function getUserPhoneHome() {
		return $this->userPhoneHome;
	}
	
	function getUserPhoneMobile() {
		return $this->userPhoneMobile;
	}

	function getUserPhoneWork() {
		return $this->userPhoneWork;
	}

	function getUserEmail1() {
		return $this->userEmail1;
	}
	
	function getUserEmail2() {
		return $this->userEmail2;
	}
	
	function getUserStatus(){
		return $this->userStatus;
	}
	
	function getUserAddress() {
		return $this->userAddress;
	}
	
	function getUserDeleted() {
		return $this->userDeleted;
	}
	
	function getUserGroupID() {
		return $this->userGroupID;
	}
	
		
	function getListOfUsers($pageNO,$schStr,$mode, $sortField, $sortOrder, $isAdmin){
		
		$arrFieldList[0] = 'id';
		$arrFieldList[1] = 'user_name';
		$arrFieldList[2] = 'is_admin';
	
		
		$this->sql_builder->table_name = $this->tableName;
		$this->sql_builder->flg_select = 'true';
		$this->sql_builder->arr_select = $arrFieldList;
		
		if ($isAdmin) {
			$isAdmin = 'Yes';
		} else {
			$isAdmin = 'No';
		}
		
		$schStr = array($schStr, $isAdmin);
		$mode = array($mode, 2);
		
		$sqlQString =$this->sql_builder->passResultSetMessage($pageNO,$schStr,$mode, $sortField, $sortOrder, true);
				
		$message2 = $this->dbConnection -> executeQuery($sqlQString);
		
		$i=0;
		
		 while ($line = mysql_fetch_array($message2, MYSQL_NUM)) {
		 	
	    	$arrayDispList[$i][0] = $line[0];
	    	$arrayDispList[$i][1] = $line[1];
	    	$i++;
	    	
	     }
	     
	     if (isset($arrayDispList)) {
	     
			return $arrayDispList;
			
		} else {
		
			$arrayDispList = '';
			return $arrayDispList;
			
		}
	}
	
	function countUsers($schStr,$mode) {
		
		$arrFieldList[0] = 'id';
		$arrFieldList[1] = 'user_name';
	
		$sql_builder = new SQLQBuilder();
		$sql_builder->table_name = $this->tableName;
		
		$sql_builder->flg_select = 'true';
		$sql_builder->arr_select = $arrFieldList;		
			
		$sqlQString = $sql_builder->countResultset($schStr,$mode);
		
		//echo $sqlQString;		
		$dbConnection = new DMLFunctions();
		$message2 = $dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		$line = mysql_fetch_array($message2, MYSQL_NUM);
		 	
	    	return $line[0];
	}

	function addUsers(){
		 $arrFieldList[0] = "'" . $this->getUserID() . "'";
		 $arrFieldList[1] = "'" . $this->getUserName() . "'";
		 $arrFieldList[2] = "'" . $this->getUserPassword() . "'"; 
		 $arrFieldList[3] = "'" . $this->getUserFirstName() . "'"; 
		 $arrFieldList[4] = ($this->getUserEmpID()=='0') ? 'null' :"'". $this->getUserEmpID() . "'";
		 $arrFieldList[5] = "'" . $this->getUserIsAdmin() . "'"; 		 
		 $arrFieldList[6] = "'" . $this->getUserDateEntered() . "'"; 
		 $arrFieldList[7] = "'" . $this->getUserCreatedBy() . "'"; 		 
		 $arrFieldList[8] = "'" . $this->getUserStatus() . "'";			 
		 $arrFieldList[9] = ($this->getUserGroupID()=='0') ? 'null' :"'". $this->getUserGroupID() . "'";
/////						
	    $arrRecordsList[0] = 'id';
		$arrRecordsList[1] = 'user_name';
		$arrRecordsList[2] = 'user_password';
		$arrRecordsList[3] = 'first_name';
		$arrRecordsList[4] = 'emp_number';
		$arrRecordsList[5] = 'is_admin';		
		$arrRecordsList[6] = 'date_entered';
		$arrRecordsList[7] = 'created_by';		
		$arrRecordsList[8] = 'status';		
		$arrRecordsList[9] = 'userg_id';
								
		$this->sql_builder->table_name = $this->tableName;
		$this->sql_builder->flg_insert = 'true';
		$this->sql_builder->arr_insertfield = $arrRecordsList;
		$this->sql_builder->arr_insert = $arrFieldList;		
	
		$sqlQString = $this->sql_builder->addNewRecordFeature2();
		//echo $sqlQString;
		$message2 = $this->dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		 return $message2;
		 echo $message2;
	}
	
	function updateUsers() {

		if($this->getUserID() == $_SESSION['user'] && ($this->getUserStatus() != 'Enabled')) {
			return false;
		}

		 $arrFieldList[0] = "'" . $this->getUserID() . "'";
		 $arrFieldList[1] = "'" . $this->getUserName() . "'";
		 $arrFieldList[2] = "'" . $this->getUserFirstName() . "'"; 
		 $arrFieldList[3] = ($this->getUserEmpID()=='0') ? 'null' :"'". $this->getUserEmpID() . "'";
		 $arrFieldList[4] = "'" . $this->getUserIsAdmin() . "'"; 		 
		 $arrFieldList[5] = "'" . $this->getUserDateModified() . "'"; 
		 $arrFieldList[6] = "'" . $this->getUserModifiedBy() . "'"; 		
		 $arrFieldList[7] = "'" . $this->getUserStatus() . "'";		
		 $arrFieldList[8] = ($this->getUserGroupID()=='0') ? 'null' :"'". $this->getUserGroupID() . "'";
/////						
	    $arrRecordsList[0] = 'id';
		$arrRecordsList[1] = 'user_name';	
		$arrRecordsList[2] = 'first_name';
		$arrRecordsList[3] = 'emp_number';
		$arrRecordsList[4] = 'is_admin';
		$arrRecordsList[5] = 'date_modified';
		$arrRecordsList[6] = 'modified_user_id';		
		$arrRecordsList[7] = 'status';		
		$arrRecordsList[8] = 'userg_id';

		$this->sql_builder->table_name = $this->tableName;
		$this->sql_builder->flg_update = 'true';
		$this->sql_builder->arr_update = $arrRecordsList;	
		$this->sql_builder->arr_updateRecList = $arrFieldList;	
	
		$sqlQString = $this->sql_builder->addUpdateRecord1();
		
		$message2 = $this->dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		return $message2;
	}
	
	function updateChangeUsers() {
		//echo $this->getUserID(). $_SESSION['user'];
		 if($this->getUserID() !== $_SESSION['user']) {
			return false;
		} 
		 //echo 'hi';
		 $arrFieldList[0] = "'" . $this->getUserID() . "'";
		 $arrFieldList[1] = "'" . $this->getUserName() . "'";
		 $arrFieldList[2] = "'" . $this->getUserFirstName() . "'"; 
		if($this->getUserPassword() != '')
		 $arrFieldList[3] = "'" . md5($this->getUserPassword()) . "'"; 
/////						
	   
		$arrRecordsList[0] = 'id';
		$arrRecordsList[1] = 'user_name';
		$arrRecordsList[2] = 'first_name';
		if($this->getUserPassword() != '')
			$arrRecordsList[3] = 'user_password';

		$this->sql_builder->table_name = $this->tableName;
		$this->sql_builder->flg_update = 'true';
		$this->sql_builder->arr_update = $arrRecordsList;	
		$this->sql_builder->arr_updateRecList = $arrFieldList;	
		
		$this->sql_builder->flg_update = true;
		
		$sqlQString = $this->sql_builder->addUpdateRecord1();
		//echo $sqlQString;
		$message2 = $this->dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		return $message2;
	}
	
	function getLastRecord(){
		$arrFieldList[0] = 'id';
		
		$this->sql_builder->table_name = $this->tableName;
		$this->sql_builder->flg_select = 'true';
		$this->sql_builder->arr_select = $arrFieldList;		
	
		$sqlQString = $this->sql_builder->selectOneRecordOnly();
		
		$message2 = $this->dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		$common_func = new CommonFunctions();
		
		if (isset($message2)) {
			
			$i=0;
		
		while ($line = mysql_fetch_array($message2, MYSQL_ASSOC)) {		
			foreach ($line as $col_value) {
			$this->singleField = $col_value;
			}		
		}
			
		return $common_func->explodeString($this->singleField,"USR");
				
		}		
	}
	
	function filterUsers($getID) {
		
		$this->ID = $getID;
	    $arrFieldList[0] = 'id';
		$arrFieldList[1] = 'user_name';		
		$arrFieldList[2] = 'first_name';
		$arrFieldList[3] = 'emp_number';
		$arrFieldList[4] = 'is_admin';		
		$arrFieldList[5] = 'date_entered';
		$arrFieldList[6] = 'date_modified';
		$arrFieldList[7] = 'modified_user_id';
		$arrFieldList[8] = 'created_by';		
		$arrFieldList[9] = 'status';		
		$arrFieldList[10] = 'userg_id';

						
		$this->sql_builder->table_name = $this->tableName;
		$this->sql_builder->flg_select = 'true';
		$this->sql_builder->arr_select = $arrFieldList;		
			
		$sqlQString = $this->sql_builder->selectOneRecordFiltered($this->ID);
		
		$message2 = $this->dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		$i=0;
		
		 while ($line = mysql_fetch_array($message2, MYSQL_NUM)) {
		 	
	    	$arrayDispList[$i][0] = $line[0];
	    	$arrayDispList[$i][1] = $line[1];	    	
	    	$arrayDispList[$i][2] = $line[2];
	    	$arrayDispList[$i][3] = $line[3];
	    	$arrayDispList[$i][4] = $line[4];
	    	$arrayDispList[$i][5] = $line[5];
	    	$arrayDispList[$i][6] = $line[6];
	    	$arrayDispList[$i][7] = $line[7];
	    	$arrayDispList[$i][8] = $line[8];
	    	$arrayDispList[$i][9] = $line[9];	    	
	    	$arrayDispList[$i][10] = $line[10];	    
				    	
	    	$i++;
	    	
	     }
	     
	     if (isset($arrayDispList)) {
	     
			return $arrayDispList;
			
		} else {
		
			$arrayDispList = '';
			return $arrayDispList;
			
		}
				
	}
	
	function filterChangeUsers($getID) {
		
		$this->ID = $getID;
	    $arrFieldList[0] = 'id';
		$arrFieldList[1] = 'user_name';
		$arrFieldList[2] = 'first_name';
		$arrFieldList[3] = 'user_password';

						
		$this->sql_builder->table_name = $this->tableName;
		$this->sql_builder->flg_select = 'true';
		$this->sql_builder->arr_select = $arrFieldList;		
			
		$sqlQString = $this->sql_builder->selectOneRecordFiltered($this->ID);
		
		$message2 = $this->dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		$i=0;
		
		 while ($line = mysql_fetch_array($message2, MYSQL_NUM)) {
		 	
	    	$arrayDispList[$i][0] = $line[0];
	    	$arrayDispList[$i][1] = $line[1];
	    	$arrayDispList[$i][2] = $line[2];
	    	$arrayDispList[$i][3] = $line[3];
	    	
	    	
	    	$i++;
	    	
	     }
	     
	     if (isset($arrayDispList)) {
	     
			return $arrayDispList;
			
		} else {
		
			$arrayDispList = '';
			return $arrayDispList;
			
		}
				
	}
	
	function delUsers($arrList) {

		$arrFieldList[0] = 'id';

		$this->sql_builder->table_name = $this->tableName;
		$this->sql_builder->flg_delete = 'true';
		$this->sql_builder->arr_delete = $arrFieldList;

		$delFlag = false;
		for($c=0;count($arrList[0])>$c;$c++) 
			if($_SESSION['user'] == $arrList[0][$c])
				$delFlag = true;
		
		if($delFlag) {
			return false;
		}
		
		$sqlQString = $this->sql_builder->deleteRecord($arrList);

		$message2 = $this->dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		return $message2;
	}

	function getUserGroupCodes(){
		
		$arrFieldList[0] = 'userg_id';
		$arrFieldList[1] = 'userg_name';
	
		
		$this->sql_builder->table_name = 'hs_hr_user_group';
		$this->sql_builder->flg_select = 'true';
		$this->sql_builder->arr_select = $arrFieldList;
		
		$sqlQString =$this->sql_builder->passResultSetMessage();
		
		$message2 = $this->dbConnection -> executeQuery($sqlQString);
		
		$i=0;
		
		 while ($line = mysql_fetch_array($message2, MYSQL_NUM)) {
		 	
	    	$arrayDispList[$i][0] = $line[0];
	    	$arrayDispList[$i][1] = $line[1];
	    	$i++;
	    	
	     }
	     
	     if (isset($arrayDispList)) {
	     
			return $arrayDispList;
			
		} else {
		
			$arrayDispList = '';
			return $arrayDispList;
			
		}
	}

	function getEmployeeCodes() {
		
		$tableName = 'HS_HR_EMPLOYEE';
		$arrFieldList[0] = 'EMP_NUMBER';
		$arrFieldList[1] = 'EMP_FIRSTNAME';

		$sql_builder = new SQLQBuilder();
		
		$sql_builder->table_name = $tableName;
		$sql_builder->flg_select = 'true';
		$sql_builder->arr_select = $arrFieldList;		
			
		$sqlQString = $sql_builder->passResultSetMessage();
		
		//echo $sqlQString;		
		$dbConnection = new DMLFunctions();
		$message2 = $dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		echo mysql_error();
		$i=0;
		
		 while ($line = mysql_fetch_array($message2, MYSQL_NUM)) {
		 	
	    	$arrayDispList[$i][0] = $line[0];
	    	$arrayDispList[$i][1] = $line[1];
	    	$i++;
	    	
	     }
	     
	     if (isset($arrayDispList)) {
	     
			return $arrayDispList;
			
		} else {
		
			$arrayDispList = '';
			return $arrayDispList;
			
		}
	}
}
?>