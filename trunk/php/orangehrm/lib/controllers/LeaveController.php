<?
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


//the model objects are included here

require_once ROOT_PATH . '/lib/models/leave/Leave.php';

require_once ROOT_PATH . '/lib/common/TemplateMerger.php';

class LeaveController {
	
	private $indexCode;
	private $id;
	private $objLeave;
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setObjLeave($obj) {
		$this->objLeave = $obj;
	}
	
	public function getObjLeave() {
		return $this->objLeave;
	}


	public function __construct() {
		//nothing to do
	}
	
	//public function

	public function viewLeaves($id, $modifier="employee") {
		$this->setObjLeave(new Leave());
		$this->setId($id);	
			
		switch ($modifier) {
			case "employee": $this->_viewLeavesEmployee();
		}
	}
	
	private function _viewLeavesEmployee() {
		$tmpObj = $this->getObjLeave();
		$tmpObj->retriveLeaveEmployee($this->getId());
		
		$path = "/templates/leave/leaveList.php";
		
		$template = new TemplateMerger($tmpObj, $path);
		
		$template->display();
		
	}
	
	
}
?>