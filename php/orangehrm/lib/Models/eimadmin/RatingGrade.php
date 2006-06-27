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

class RatingGrade {

	var $tableName = 'HS_HR_RATING_METHOD_GRADE';
	
	var $ratGrdId;
	var $ratId;
	var $ratDesc;
	var $ratMin;
	var $ratMax;
	var $ratAvg;
	var $arrayDispList;
	var $singleField;
	
	
	function RatingGrade() {
		
	}
	
	function setRatGrdId($ratGrdId) {
	
		$this->ratGrdId = $ratGrdId;
	
	}

	function setRatId($ratId) {

		$this->ratId = $ratId;

	}
	function setRatDesc($ratDesc) {

		$this->ratDesc = $ratDesc;

	}

	function setRatMin($ratMin) {
	
		$this->ratMin = $ratMin;
	}
		
	function setRatMax($ratMax) {

		$this->ratMax = $ratMax;
	}

	function setRatAvg($ratAvg) {

		$this->ratAvg = $ratAvg;
	}

	function getRatGrdId() {

		return $this->ratGrdId;

	}

	function getRatId() {

		return $this->ratId;

	}
	function getRatDesc() {

		return $this->ratDesc;

	}

	function getRatMin() {

		return $this->ratMin;
	}

	function getRatMax() {

		return $this->ratMax;
	}

	function getRatAvg() {

		return $this->ratAvg;
	}


	function getListofRatGrd($schStr,$mode) {
		
		$tableName = 'HS_HR_RATING_METHOD_GRADE';
		$arrFieldList[0] = 'RATING_GRADE_CODE';
		$arrFieldList[1] = 'RATING_CODE';
		$arrFieldList[2] = 'RATING_GRADE';
		$arrFieldList[3] = 'RATING_GRADE_MIN_MARK';
		$arrFieldList[4] = 'RATING_GRADE_MAX_MARK';
		$arrFieldList[5] = 'RATING_GRADE_AVG_MARK';

		$sql_builder = new SQLQBuilder();
		
		$sql_builder->table_name = $tableName;
		$sql_builder->flg_select = 'true';
		$sql_builder->arr_select = $arrFieldList;		
			
		$sqlQString = $sql_builder->passResultSetMessage($schStr,$mode);
		
		//echo $sqlQString;		
		$dbConnection = new DMLFunctions();
		$message2 = $dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		$i=0;
		
		 while ($line = mysql_fetch_array($message2, MYSQL_NUM)) {
		 	
	    	$arrayDispList[$i][0] = $line[0];
	    	$arrayDispList[$i][1] = $line[1];
	    	$arrayDispList[$i][2] = $line[2];
	    	$arrayDispList[$i][3] = $line[3];
	    	$arrayDispList[$i][4] = $line[4];
	    	$arrayDispList[$i][5] = $line[5];
	    	$i++;
	    	
	     }
	     
	     if (isset($arrayDispList)) {
	     
			return $arrayDispList;
			
		} else {
		
			$arrayDispList = '';
			return $arrayDispList;
			
		}
	}

	function delRatGrd($arrList) {

		$tableName = 'HS_HR_RATING_METHOD_GRADE';
		$arrFieldList[0] = 'RATING_GRADE_CODE';
		$arrFieldList[1] = 'RATING_CODE';

		$sql_builder = new SQLQBuilder();

		$sql_builder->table_name = $tableName;
		$sql_builder->flg_delete = 'true';
		$sql_builder->arr_delete = $arrFieldList;

		$sqlQString = $sql_builder->deleteRecord($arrList);

		//echo $sqlQString;
		$dbConnection = new DMLFunctions();
		$message2 = $dbConnection -> executeQuery($sqlQString); //Calling the addData() function

	}

	
	function addRatGrd() {
		
		$arrFieldList[0] = "'". $this->getRatGrdId() . "'";
		$arrFieldList[1] = "'". $this->getRatId() . "'";
		$arrFieldList[2] = "'". $this->getRatDesc() . "'";
		$arrFieldList[3] = "'". $this->getRatMin() . "'";
		$arrFieldList[4] = "'". $this->getRatMax() . "'";
		$arrFieldList[5] = "'". $this->getRatAvg() . "'";

		//$arrFieldList[0] = 'RATING_CODE';
		//$arrFieldList[1] = 'RATING_NAME';
		
		$tableName = 'HS_HR_RATING_METHOD_GRADE';
	
		$sql_builder = new SQLQBuilder();
		
		$sql_builder->table_name = $tableName;
		$sql_builder->flg_insert = 'true';
		$sql_builder->arr_insert = $arrFieldList;		
			
	
		$sqlQString = $sql_builder->addNewRecordFeature1();
	
		$dbConnection = new DMLFunctions();
		$message2 = $dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		 return $message2;
		 echo $message2;
				
	}
	
	function updateRatGrd() {
		
		$arrRecordsList[0] = "'". $this->getRatGrdId() . "'";
		$arrRecordsList[1] = "'". $this->getRatId() . "'";
		$arrRecordsList[2] = "'". $this->getRatDesc() . "'";
		$arrRecordsList[3] = "'". $this->getRatMin() . "'";
		$arrRecordsList[4] = "'". $this->getRatMax() . "'";
		$arrRecordsList[5] = "'". $this->getRatAvg() . "'";

		$tableName = 'HS_HR_RATING_METHOD_GRADE';
		$arrFieldList[0] = 'RATING_GRADE_CODE';
		$arrFieldList[1] = 'RATING_CODE';
		$arrFieldList[2] = 'RATING_GRADE';
		$arrFieldList[3] = 'RATING_GRADE_MIN_MARK';
		$arrFieldList[4] = 'RATING_GRADE_MAX_MARK';
		$arrFieldList[5] = 'RATING_GRADE_AVG_MARK';

		$sql_builder = new SQLQBuilder();
		
		$sql_builder->table_name = $tableName;
		$sql_builder->flg_update = 'true';
		$sql_builder->arr_update = $arrFieldList;	
		$sql_builder->arr_updateRecList = $arrRecordsList;	
	
		$sqlQString = $sql_builder->addUpdateRecord1();
	
		$dbConnection = new DMLFunctions();
		$message2 = $dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		return $message2;
		 
				
	}

	function getAssRatGrd($getID) {

		$this->getID = $getID;
		$tableName = 'HS_HR_RATING_METHOD_GRADE';
		$arrFieldList[0] = 'RATING_CODE';
		$arrFieldList[1] = 'RATING_GRADE_CODE';
		$arrFieldList[2] = 'RATING_GRADE';
		$arrFieldList[3] = 'RATING_GRADE_MIN_MARK';
		$arrFieldList[4] = 'RATING_GRADE_MAX_MARK';
		$arrFieldList[5] = 'RATING_GRADE_AVG_MARK';

		$sql_builder = new SQLQBuilder();

		$sql_builder->table_name = $tableName;
		$sql_builder->flg_select = 'true';
		$sql_builder->arr_select = $arrFieldList;

		$sqlQString = $sql_builder->selectOneRecordFiltered($this->getID);

		//echo $sqlQString;
		$dbConnection = new DMLFunctions();
		$message2 = $dbConnection -> executeQuery($sqlQString); //Calling the addData() function

		$i=0;

		 while ($line = mysql_fetch_array($message2, MYSQL_NUM)) {

	    	$arrayDispList[$i][0] = $line[0];
	    	$arrayDispList[$i][1] = $line[1];
	    	$arrayDispList[$i][2] = $line[2];
	    	$arrayDispList[$i][3] = $line[3];
	    	$arrayDispList[$i][4] = $line[4];
	    	$arrayDispList[$i][5] = $line[5];
	    	$i++;

	     }

	     if (isset($arrayDispList)) {

			return $arrayDispList;

		} else {

			$arrayDispList = '';
			return $arrayDispList;

		}

	}

	
	function filterRatGrd($getID) {
		
		$this->getID = $getID;
		$tableName = 'HS_HR_RATING_METHOD_GRADE';
		$arrFieldList[0] = 'RATING_GRADE_CODE';
		$arrFieldList[1] = 'RATING_CODE';
		$arrFieldList[2] = 'RATING_GRADE';
		$arrFieldList[3] = 'RATING_GRADE_MIN_MARK';
		$arrFieldList[4] = 'RATING_GRADE_MAX_MARK';
		$arrFieldList[5] = 'RATING_GRADE_AVG_MARK';

		$sql_builder = new SQLQBuilder();
		
		$sql_builder->table_name = $tableName;
		$sql_builder->flg_select = 'true';
		$sql_builder->arr_select = $arrFieldList;		
			
		$sqlQString = $sql_builder->selectOneRecordFiltered($this->getID,1);
		
		//echo $sqlQString;		
		$dbConnection = new DMLFunctions();
		$message2 = $dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		$i=0;
		
		 while ($line = mysql_fetch_array($message2, MYSQL_NUM)) {
		 	
	    	$arrayDispList[$i][0] = $line[0];
	    	$arrayDispList[$i][1] = $line[1];
	    	$arrayDispList[$i][2] = $line[2];
	    	$arrayDispList[$i][3] = $line[3];
	    	$arrayDispList[$i][4] = $line[4];
	    	$arrayDispList[$i][5] = $line[5];
	    	$i++;
	    	
	     }
	     
	     if (isset($arrayDispList)) {
	     
			return $arrayDispList;
			
		} else {
		
			$arrayDispList = '';
			return $arrayDispList;
			
		}
				
	}
	
	
	function getLastRecord() {
		
		$sql_builder = new SQLQBuilder();
		$tableName = 'HS_HR_RATING_METHOD_GRADE';
		$arrFieldList[0] = 'RATING_GRADE_CODE';

		$sql_builder->table_name = $tableName;
		$sql_builder->flg_select = 'true';
		$sql_builder->arr_select = $arrFieldList;		
	
		$sqlQString = $sql_builder->selectOneRecordOnly();
	
		$dbConnection = new DMLFunctions();
		$message2 = $dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
		$common_func = new CommonFunctions();
		
		if (isset($message2)) {
			
			$i=0;
		
		while ($line = mysql_fetch_array($message2, MYSQL_ASSOC)) {		
			foreach ($line as $col_value) {
			$this->singleField = $col_value;
			}		
		}
			
		return $common_func->explodeString($this->singleField,"RTG");
				
		}
		
	}

	function getRatingGrade($getID) {

		$this->getID = $getID;
		$tableName = 'HS_HR_RATING_METHOD_GRADE';
		$arrFieldList[0] = 'RATING_CODE';
		$arrFieldList[1] = 'RATING_GRADE_CODE';
		$arrFieldList[2] = 'RATING_GRADE';

		$sql_builder = new SQLQBuilder();

		$sql_builder->table_name = $tableName;
		$sql_builder->flg_select = 'true';
		$sql_builder->arr_select = $arrFieldList;

		$sqlQString = $sql_builder->selectOneRecordFiltered($this->getID);

		$dbConnection = new DMLFunctions();
		$message2 = $dbConnection -> executeQuery($sqlQString); //Calling the addData() function

		$i=0;

		 while ($line = mysql_fetch_array($message2, MYSQL_NUM)) {
	    		for($c=0; count($arrFieldList) > $c ; $c++)
					$arrayDispList[$i][$c] = $line[$c];

	    		$i++;
	     }

	     if (isset($arrayDispList)) {

			return $arrayDispList;

		} else {

			$arrayDispList = '';
			return $arrayDispList;

		}
	}

	function getAllRatingGrades() {
		
		$tableName = 'HS_HR_RATING_METHOD_GRADE';
		$arrFieldList[0] = 'RATING_GRADE_CODE';
		$arrFieldList[1] = 'RATING_GRADE';
		
		$sql_builder = new SQLQBuilder();
		
		$sql_builder->table_name = $tableName;
		$sql_builder->flg_select = 'true';
		$sql_builder->arr_select = $arrFieldList;		
			
		$sqlQString = $sql_builder->passResultSetMessage();
		
		//echo $sqlQString;		
		$dbConnection = new DMLFunctions();
		$message2 = $dbConnection -> executeQuery($sqlQString); //Calling the addData() function
		
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
