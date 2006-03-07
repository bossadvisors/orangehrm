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

require_once OpenSourceEIM . '/lib/Models/eimadmin/BankInfo.php';

class INTERFACE_BankInfo {
	
	function INTERFACE_BankInfo() {

		$this->parent_bankinfo = new BankInfo();
		$this->locRights=$_SESSION['localRights'];
	}

	function parseData($postArr) {	
		if (($postArr['sqlState'] == 'NewRecord') && $this->locRights['add']) {
			
			$this->parent_bankinfo -> setBankInfoId($this->parent_bankinfo ->getLastRecord());
			$this->parent_bankinfo -> setBankInfoDesc(trim($postArr['txtBankInfoDesc']));
			$this->parent_bankinfo -> setBankInfoAddress(trim($postArr['txtBankAddress']));
			$this->parent_bankinfo -> setBankInfoCLRCode(trim($postArr['txtBankCLRCode']));
		
			$message = $this->parent_bankinfo ->addBankInfo();
			
				
			// Checking whether the $message Value returned is 1 or 0
			if ($message) { 
				
				$showMsg = "Addition%Successful!"; //If $message is 1 setting up the 
				
				$uniqcode = $_GET['uniqcode'];
				$pageID = $postArr['pageID'];
				header("Location: ./view.php?message=$showMsg&uniqcode=$uniqcode&pageID=$pageID");
				
			} else {
				
				$showMsg = "Addition%Unsuccessful!";
				
				$uniqcode = $_GET['uniqcode'];
				$pageID = $_GET['pageid'];
				header("Location: ./bankinformation.php?msg=$showMsg&capturemode=addmode&uniqcode=$uniqcode&pageID=$pageID");
			}
			
		} else if (($postArr['sqlState'] == 'UpdateRecord') && $this->locRights['edit']) {
			
			$this->parent_bankinfo -> setBankInfoId(trim($postArr['txtBankInfoId']));
			$this->parent_bankinfo -> setBankInfoDesc(trim($postArr['txtBankInfoDesc']));
			$this->parent_bankinfo -> setBankInfoAddress(trim($postArr['txtBankAddress']));
			$this->parent_bankinfo -> setBankInfoCLRCode(trim($postArr['txtBankCLRCode']));
			$message = $this->parent_bankinfo ->updateBankInfo();
			
			// Checking whether the $message Value returned is 1 or 0
			if ($message) { 
				
				$showMsg = "Updation%Successful!"; //If $message is 1 setting up the 
				
				$uniqcode = $_GET['uniqcode'];
				$pageID = $postArr['pageID'];
				header("Location: ./view.php?message=$showMsg&uniqcode=$uniqcode&pageID=$pageID");
				
			} else {
				
				$showMsg = "Updation%Unsuccessful!";
				
				$uniqcode = $_GET['uniqcode'];
				$pageID = $_GET['pageid'];
				$id = $_GET['id'];
				header("Location: ./bankinformation.php?msg=$showMsg&id=$id&capturemode=updatemode&uniqcode=$uniqcode&pageID=$pageID");
			}
		}
	}
	
	function editData($id) {
		$message = $this->parent_bankinfo ->filterBankInfo($id);
		
		return $message;
	}
}
?>
