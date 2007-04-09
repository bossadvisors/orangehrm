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
 *
 */

require_once ROOT_PATH . '/lib/models/hrfunct/EmpRepTo.php';

/**
 * Assigns roles at login tells the rest
 * of the world if authorized.
 *
 */
class authorize {

	/**
	 * Class constants
	 *
	 */

	public $roleAdmin = "Admin";
	public $roleSupervisor = "Supervisor";
	public $roleESS = "ESS";

	const AUTHORIZE_ROLE_ADMIN = 'Admin';
	const AUTHORIZE_ROLE_SUPERVISOR = 'Supervisor';
	const AUTHORIZE_ROLE_ESS = 'ESS';

	/**
	 * class atributes
	 *
	 */

	private $employeeID;
	private $isAdmin;
	private $roles;

	public function setEmployeeId($employeeId) {
		$this->employeeID = $employeeId;
	}

	public function getEmployeeId() {
		return $this->employeeID;
	}

	public function setIsAdmin($isAdmin) {
		$this->isAdmin = $isAdmin;
	}

	public  function getIsAdmin() {
		return $this->isAdmin;
	}

	public function setRoles($roles) {
		$this->roles = $roles;
	}

	public  function getRoles() {
		return $this->roles;
	}

	/**
	 * Class contructor
	 *
	 * @param String $employeeId
	 * @param String $isAdmin
	 */
	public function __construct($employeeId, $isAdmin) {
		$this->setEmployeeId($employeeId);
		$this->setIsAdmin($isAdmin);

		$this->setRoles($this->_roles());
	}

	/**
	 * Constructs roles
	 *
	 * @return boolean[]
	 */
	private function _roles() {
		$roles = null;
		$isAdmin = $this->getIsAdmin();
		$empId = $this->getEmployeeId();

		if ($isAdmin === "Yes") {
			$roles[$this->roleAdmin] = true;
		} else {
			$roles[$this->roleAdmin] = false;
		}

		$roles[$this->roleSupervisor] = $this->_checkIsSupervisor();

		if (!empty($empId)) {
			$roles[$this->roleESS] = true;
		} else {
			$roles[$this->roleESS] = false;
		}

		return $roles;
	}

	/**
	 * Check whether there are any subordinates
	 *
	 * @return boolean
	 */
	private function _checkIsSupervisor() {

		$id = $this->getEmployeeId();

		$objReportTo = new EmpRepTo();

		$subordinates = $objReportTo->getEmpSub($id);

		if (isset($subordinates[0]) && is_array($subordinates[0])) {
			return true;
		}

		return false;
	}

	/**
	 * Checks whether an admin
	 *
	 * @return boolean
	 */
	public function isAdmin() {
		return $this->_chkRole($this->roleAdmin);
	}

	/**
	 * Checks whether an supervisor
	 *
	 * @return boolean
	 */
	public function isSupervisor() {
		return $this->_chkRole($this->roleSupervisor);
	}

	/**
	 * Checks whether an admin
	 *
	 * @return boolean
	 */
	public function isESS() {
		return $this->_chkRole($this->roleESS);
	}

	/**
	 * Checks whether the particular employee is
	 * the supervisor of the subordinate concerned
	 *
	 * @param unknown_type $subordinateId
	 * @return boolean
	 */
	public function isTheSupervisor($subordinateId) {
		$id = $this->getEmployeeId();

		$objReportTo = new EmpRepTo();

		$subordinates = $objReportTo->getEmpSub($id);
		if (isset($subordinates[0]) && is_array($subordinates[0]) && $this->searchArray($subordinates[0], $subordinateId, 1)) {
			return true;
		}

		return false;
	}

	/**
	 * Test whether element at pos of the array is equal to match
	 *
	 * @param Array array
	 * @param String match
	 * @param int pos
	 */
	private function searchArray($array, $match, $pos) {
		if ($array[$pos] == $match) {
				return true;
		}
		return false;
	}

	/**
	 * Delegates all checks for all is<Role>
	 * functions
	 *
	 * @param String $role
	 * @return boolean
	 */
	private function _chkRole($role) {
		$roles = $this->getRoles();

		if (isset($roles[$role]) && $roles[$role]) {
			return true;
		}

		return false;
	}

	/**
	 * Returns the first role out of the array of
	 * roles sent
	 *
	 * @param String[] $roleArr
	 * @return String/boolean
	 */
	public function firstRole($roleArr) {
		for ($i=0; $i<count($roleArr); $i++) {
			if ($this->_chkRole($roleArr[$i])){
				return $roleArr[$i];
			}
		}

		return false;
	}
}
?>