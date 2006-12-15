<?php
/*
OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures 
all the essential functionalities required for any enterprise. 
Copyright (C) 2006 hSenid Software International Pvt. Ltd, http://www.hsenid.com

OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
the GNU General Public License as published by the Free Software Foundation; either
version 2 of the License, or (at your option) any later version.

OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program;
if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
Boston, MA  02110-1301, USA
*/

session_start();

if(!isset($_SESSION['fname'])) { 

	header("Location: ../../login.htm");
	exit();
}

define("ROOT_PATH",$_SESSION['path']);
require_once ROOT_PATH . '/lib/models/hrfunct/EmpPhoto.php';
require_once ROOT_PATH . '/lib/extractor/hrfunct/EXTRACTOR_EmpPhoto.php';

$photo = new EmpPicture();
$edit = $photo->filterEmpPic($_GET['id']);

if(isset($_GET['action']) && $_GET['action'] == 'VIEW') {
	
	if($edit) {
		header("Content-length: " .$edit[0][4]);
		header("Content-type: " .$edit[0][3]);
		echo $edit[0][1];
		exit();
		
	} else {
		
		$tmpName = ROOT_PATH . '/themes/beyondT/pictures/untitled.PNG';
		$fp = fopen($tmpName,'r');
		$contents = fread($fp,filesize($tmpName));
		fclose($fp);
		
		header("Content-type: image/png");
		echo $contents;
		exit();
	}
}

$object = new EmpPicture();

if(isset($_POST['STAT']) && $_POST['STAT'] == 'ADD') {
	$extractor = new EXTRACTOR_EmpPhoto();
	$object = $extractor->parseData();
	
	if($object != null) {
		$object->setEmpId($_GET['id']);
		$object->addEmpPic();
	}
}

if(isset($_POST['STAT']) && $_POST['STAT'] == 'EDIT') {
	$extractor = new EXTRACTOR_EmpPhoto();
	$object = $extractor->parseData();
	
	if($object != null) {
		$object->setEmpId($_GET['id']);
		$object->updateEmpPic();
	}
}

if(isset($_POST['STAT']) && $_POST['STAT'] == 'DELETE') {	
	$object = new EmpPicture();	
	$object->delEmpPic(array(array($_GET['id'])));	
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link href="../../themes/beyondT/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">@import url("../../themes/beyondT/css/style.css"); </style>
<title>Select a Photo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script>
function addPic() {
	document.frmPhoto.STAT.value = 'ADD';
	document.frmPhoto.submit();
}

function updatePic() {
	document.frmPhoto.STAT.value = 'EDIT';
	document.frmPhoto.submit();
}

function deletePic() {
	
	if (!confirm('Are you sure you want to delete the photograph?')) {
		return false;
	}
	
	document.frmPhoto.STAT.value = 'DELETE';
	document.frmPhoto.submit();
}

function windowClose() {
	opener.document.frmEmp.submit();
	window.close();
}
</script>
</head>
<body onload="<?php echo isset($_POST['STAT']) ? 'windowClose()' : ''?>">
<p> 
<table width='100%' cellpadding='0' cellspacing='0' border='0' class='moduleTitle'>
<tr>
  <td width='100%'><h2>Select a Photo</h2></td>
  <td valign='top' align='right' nowrap style='padding-top:3px; padding-left: 5px;'></td></tr>
</table></p>
</p> 
<p>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td></td><td>
<form name="frmPhoto" method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>">
<input type="hidden" name="STAT">
      <table align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="13"><img name="table_r1_c1" src="../../themes/beyondT/pictures/table_r1_c1.gif" width="13" height="12" border="0" alt=""></td>
                  <td width="339" background="../../themes/beyondT/pictures/table_r1_c2.gif"><img name="table_r1_c2" src="../../themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td width="13"><img name="table_r1_c3" src="../../themes/beyondT/pictures/table_r1_c3.gif" width="13" height="12" border="0" alt=""></td>
                  <td width="11"><img src="../../themes/beyondT/pictures/spacer.gif" width="1" height="12" border="0" alt=""></td>
                </tr>
                <tr>
                  <td background="../../themes/beyondT/pictures/table_r2_c1.gif"><img name="table_r2_c1" src="../../themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><table border="0" cellpadding="5" cellspacing="0" class="">
                    <tr>
                    <td align="center" width="100%"><img width="100" height="120" src="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&action=VIEW"></td>
                    </tr>
                    <tr>
                    <td align="center" width="100%"><input type="file" name="photofile" accept="image/gif,image/jpeg,image/png"></td>
					</tr>
                    <tr>
                    <td align="center" width="100%">
                    <?php if($edit) { ?>
					        <img border="0" title="Save" onClick="updatePic();" onmouseout="this.src='../../themes/beyondT/pictures/btn_save.jpg';" onmouseover="this.src='../../themes/beyondT/pictures/btn_save_02.jpg';" src="../../themes/beyondT/pictures/btn_save.jpg">
					        <img border="0" title="Delete" onClick="deletePic();" onmouseout="this.src='../../themes/beyondT/pictures/btn_delete.jpg';" onmouseover="this.src='../../themes/beyondT/pictures/btn_delete_02.jpg';" src="../../themes/beyondT/pictures/btn_delete.jpg">
                    <?php } else { ?>
					        <img border="0" title="Save" onClick="addPic();" onmouseout="this.src='../../themes/beyondT/pictures/btn_save.jpg';" onmouseover="this.src='../../themes/beyondT/pictures/btn_save_02.jpg';" src="../../themes/beyondT/pictures/btn_save.jpg">
                    <?php } ?>
                    </td>
					</tr>
                  </table></td>
                  <td background="../../themes/beyondT/pictures/table_r2_c3.gif"><img name="table_r2_c3" src="../../themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><img src="../../themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                </tr>
                <tr>
                  <td><img name="table_r3_c1" src="../../themes/beyondT/pictures/table_r3_c1.gif" width="13" height="16" border="0" alt=""></td>
                  <td background="../../themes/beyondT/pictures/table_r3_c2.gif"><img name="table_r3_c2" src="../../themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><img name="table_r3_c3" src="../../themes/beyondT/pictures/table_r3_c3.gif" width="13" height="16" border="0" alt=""></td>
                  <td><img src="../../themes/beyondT/pictures/spacer.gif" width="1" height="16" border="0" alt=""></td>
                </tr>
              </table>
</td><td></td></tr>
</form>
</body>
</html>