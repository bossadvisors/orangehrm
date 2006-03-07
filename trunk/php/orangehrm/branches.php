<?
/*
OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures 
all the essential functionalities required for any enterprise. 
Copyright (C) 2006 hSenid Software, http://www.hsenid.com

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

	header("Location: ./relogin.htm");
	exit();
}

define('OpenSourceEIM', dirname(__FILE__) );
require_once OpenSourceEIM . '/lib/Models/eimadmin/Branches.php';
require_once OpenSourceEIM . '/lib/Confs/sysConf.php';

	$parent_branch = new Branches();
	$sysConst = new sysConf(); 
	$locRights=$_SESSION['localRights'];

	
if ((isset($_POST['sqlState'])) && ($_POST['sqlState'] == 'NewRecord')) {
	
		$parent_branch -> setBrchId($parent_branch ->getLastRecord());
		$parent_branch -> setBrchBankId(trim($_POST['cmbBankID']));
		$parent_branch -> setBrchDesc(trim($_POST['txtBranchesDesc']));
		$parent_branch -> setBrchAddr(trim($_POST['txtBranchesAddr']));
		$parent_branch -> setBrchSlipTrf(isset($_POST['chkBrchSlipTrf'])?'1':'0');
		$parent_branch -> setBrchClrHos(trim($_POST['txtBranchesClrHos']));
        $message = $parent_branch ->addBranches();
	
	// Checking whether the $message Value returned is 1 or 0
	if ($message) { 
		
		$showMsg = "Addition%Successful!"; //If $message is 1 setting up the 
		
		$uniqcode = $_GET['uniqcode'];
		$pageID = $_POST['pageID'];
		header("Location: ./view.php?message=$showMsg&uniqcode=$uniqcode&pageID=$pageID");
		
	} else {
		
		$showMsg = "Addition Unsuccessful!";
		
		$uniqcode = $_GET['uniqcode'];
		$pageID = $_GET['pageid'];
		header("Location: ./branches.php?msg=$showMsg&capturemode=addmode&uniqcode=$uniqcode&pageID=$pageID");
	}
	
} else if ((isset($_POST['sqlState'])) && ($_POST['sqlState'] == 'UpdateRecord')) {

		$parent_branch -> setBrchId(trim($_POST['txtBranchesID']));
		$parent_branch -> setBrchBankId(trim($_POST['cmbBankID']));
		$parent_branch -> setBrchDesc(trim($_POST['txtBranchesDesc']));
		$parent_branch -> setBrchAddr(trim($_POST['txtBranchesAddr']));
		$parent_branch -> setBrchSlipTrf(isset($_POST['chkBrchSlipTrf'])?'1':'0');
		$parent_branch -> setBrchClrHos(trim($_POST['txtBranchesClrHos']));
        $message = $parent_branch ->updateBranches();
	
	// Checking whether the $message Value returned is 1 or 0
	if ($message) { 
		
		$showMsg = "Updation%Successful!"; //If $message is 1 setting up the 
		
		$uniqcode = $_GET['uniqcode'];
		$pageID = $_POST['pageID'];
		header("Location: ./view.php?message=$showMsg&uniqcode=$uniqcode&pageID=$pageID");
		
	} else {
		
		$showMsg = "Updation%Unsuccessful!";
		
		$uniqcode = $_GET['uniqcode'];
		$pageID = $_GET['pageid'];
		$id = $_GET['id'];
		header("Location: ./branches.php?msg=$showMsg&id=$id&capturemode=updatemode&uniqcode=$uniqcode&pageID=$pageID");
	}

}
?>
<?
	if ((isset($_GET['capturemode'])) && ($_GET['capturemode'] == 'addmode')) {
	$lastRecord = $parent_branch ->getLastRecord();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script>			
function alpha(txt)
{
var flag=true;
var i,code;

if(txt.value=="")
   return false;

for(i=0;txt.value.length>i;i++)
	{
	code=txt.value.charCodeAt(i);
    if((code>=65 && code<=122) || code==32 || code==46)
	   flag=true;
	else
	   {
	   flag=false;
	   break;
	   }
	}
return flag;
}

function numeric(txt)
{
var flag=true;
var i,code;

if(txt.value=="")
   return false;

for(i=0;txt.value.length>i;i++)
	{
	code=txt.value.charCodeAt(i);
    if(code>=48 && code<=57)
	   flag=true;
	else
	   {
	   flag=false;
	   break;
	   }
	}
return flag;
}

	function goBack() {
		location.href = "view.php?uniqcode=<?=$_GET['uniqcode']?>";
	}

	function addSave() {
		
		if (document.frmBranches.txtBranchesDesc.value == '') {
			alert ("Description Cannot be a Blank Value!");
			return false;
		}
		
		if(document.frmBranches.cmbBankID.value=="0") {
			alert ("Field should be selected!");
			document.frmBranches.cmbBankID.focus();
			return;
		}
		
		document.frmBranches.sqlState.value = "NewRecord";
		document.frmBranches.pageID.value = "<?=$_GET['pageID']?>";
		document.frmBranches.submit();
	}			

	function clearAll() {
		document.frmBranches.cmbBankID.options[0].selected=true;
		document.frmBranches.txtBranchesDesc.value='';
		document.frmBranches.txtBranchesAddr.value='';
		document.frmBranches.chkBrchSlipTrf.checked=false;
		document.frmBranches.txtBranchesClrHos.value='';
	}
</script>
<link href="./themes/beyondT/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">@import url("./themes/beyondT/css/style.css"); </style>
</head>
<body>
<table width='100%' cellpadding='0' cellspacing='0' border='0' class='moduleTitle'>
  <tr>
    <td valign='top'></td>
    <td width='100%'><h2>Branches Information : Bank Info</h2></td>
    <td valign='top' align='right' nowrap style='padding-top:3px; padding-left: 5px;'><A href='index.php?module=Contacts&action=index&return_module=Contacts&return_action=DetailView&&print=true' class='utilsLink'></td>
  </tr>
</table>
<p>
<p> 
<table width="431" border="0" cellspacing="0" cellpadding="0" ><td width="177">
<form name="frmBranches" method="post" action="./branches.php?pageid=<?=$_GET['pageID']?>&uniqcode=<?=$_GET['uniqcode']?>">
<input type="hidden" name="pageID" value="">
  <tr> 
    <td height="27" valign='top'> <p> <img title="Back" onmouseout="this.src='./themes/beyondT/pictures/btn_back.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_back_02.jpg';"  src="./themes/beyondT/pictures/btn_back.jpg" onclick="goBack();">
        <input type="hidden" name="sqlState" value="">
      </p></td>
    <td width="254" align='left' valign='bottom'> <font color="red" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
      <?
		if (isset($_GET['msg'])) {
			$expString  = $_GET['msg'];
			$expString = explode ("%",$expString);
			$length = sizeof($expString);
			for ($x=0; $x < $length; $x++) {		
				echo " " . $expString[$x];		
			}
		}		
		?>
      </font> </td>
  </tr><td width="177"><form name="frmBranches" method="post" action="./branches.php">
</table>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="13"><img name="table_r1_c1" src="themes/beyondT/pictures/table_r1_c1.gif" width="13" height="12" border="0" alt=""></td>
                  <td width="339" background="themes/beyondT/pictures/table_r1_c2.gif"><img name="table_r1_c2" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td width="13"><img name="table_r1_c3" src="themes/beyondT/pictures/table_r1_c3.gif" width="13" height="12" border="0" alt=""></td>
                  <td width="11"><img src="themes/beyondT/pictures/spacer.gif" width="1" height="12" border="0" alt=""></td>
                </tr>
                <tr>
                  <td background="themes/beyondT/pictures/table_r2_c1.gif"><img name="table_r2_c1" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="">
						  <tr> 
						    <td><strong>Code</strong></td>
						    <td><input type="text" readonly="true" name="txtBranchesID" value=<?=$lastRecord; ?> ></td>
						  </tr>
						    <tr>
						    <td><strong>Bank</strong></td>
						    <td> <select name="cmbBankID">
						    		<option value="0">----Select Bank----</option>
						    <?  $bankcode = $parent_branch->getBankCodes();
						    
						        for($c=0;$bankcode && $c < count($bankcode);$c++)
						            echo '<option value=' . $bankcode[$c][0] . '>' . $bankcode[$c][1] .'</option>';
						    ?>
						    </select></td>
						  </tr>
						  <tr>
						    <td><strong>Description</strong></td>
						    <td> <textarea name='txtBranchesDesc' rows="3" tabindex='3' cols="30"></textarea></td>
						  </tr>
						  <tr>
						    <td><strong>Address</strong></td>
						    <td> <textarea name='txtBranchesAddr' rows="3" tabindex='3' cols="30"></textarea></td>
						  </tr>
						  <tr>
						    <td><strong>Slip Transfer</strong></td>
						    <td> <input type="checkbox" name="chkBrchSlipTrf" value="1"></td>
						  </tr>
						  <tr>
						 <td><strong>Clear House Code</strong></td>
						    <td><input type="text" name="txtBranchesClrHos" ></td>
						  </tr>
					  <tr><td></td><td align="right" width="100%"><img onClick="addSave();" onmouseout="this.src='./themes/beyondT/pictures/btn_save.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_save_02.jpg';" src="./themes/beyondT/pictures/btn_save.jpg">
        <img onClick="clearAll();" onmouseout="this.src='./themes/beyondT/pictures/btn_clear.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_clear_02.jpg';" src="./themes/beyondT/pictures/btn_clear.jpg"></td></tr>

                  </table></td>
                  <td background="themes/beyondT/pictures/table_r2_c3.gif"><img name="table_r2_c3" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><img src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                </tr>
                <tr>
                  <td><img name="table_r3_c1" src="themes/beyondT/pictures/table_r3_c1.gif" width="13" height="16" border="0" alt=""></td>
                  <td background="themes/beyondT/pictures/table_r3_c2.gif"><img name="table_r3_c2" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><img name="table_r3_c3" src="themes/beyondT/pictures/table_r3_c3.gif" width="13" height="16" border="0" alt=""></td>
                  <td><img src="themes/beyondT/pictures/spacer.gif" width="1" height="16" border="0" alt=""></td>
                </tr>
              </table>
</form> 
</form>
</body>
</html>
<? } else if ((isset($_GET['capturemode'])) && ($_GET['capturemode'] == 'updatemode')) {
	 $message = $parent_branch ->filterBranches($_GET['id']);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script>			
function alpha(txt)
{
var flag=true;
var i,code;

if(txt.value=="")
   return false;

for(i=0;txt.value.length>i;i++)
	{
	code=txt.value.charCodeAt(i);
    if((code>=65 && code<=122) || code==32 || code==46)
	   flag=true;
	else
	   {
	   flag=false;
	   break;
	   }
	}
return flag;
}

function numeric(txt)
{
var flag=true;
var i,code;

if(txt.value=="")
   return false;

for(i=0;txt.value.length>i;i++)
	{
	code=txt.value.charCodeAt(i);
    if(code>=48 && code<=57)
	   flag=true;
	else
	   {
	   flag=false;
	   break;
	   }
	}
return flag;
}

	function goBack() {
		location.href = "view.php?uniqcode=<?=$_GET['uniqcode']?>";
	}

function mout() {
	if(document.Edit.title=='Save') 
		document.Edit.src='./themes/beyondT/pictures/btn_save.jpg'; 
	else
		document.Edit.src='./themes/beyondT/pictures/btn_edit.jpg'; 
}

function mover() {
	if(document.Edit.title=='Save') 
		document.Edit.src='./themes/beyondT/pictures/btn_save_02.jpg'; 
	else
		document.Edit.src='./themes/beyondT/pictures/btn_edit_02.jpg'; 
}
	
function edit()
{
	if(document.Edit.title=='Save') {
		addUpdate();
		return;
	}
	
	var frm=document.frmBranches;
//  alert(frm.elements.length);
	for (var i=0; i < frm.elements.length; i++)
		frm.elements[i].disabled = false;
	document.Edit.src="./themes/beyondT/pictures/btn_save.jpg";
	document.Edit.title="Save";
}

	function addUpdate() {
		
		if (document.frmBranches.txtBranchesDesc.value == '') {
			alert ("Description Cannot be a Blank Value!");
			return false;
		}
		
		document.frmBranches.sqlState.value = "UpdateRecord";
		document.frmBranches.pageID.value = "<?=$_GET['pageID']?>";
		document.frmBranches.submit();
	}			

	function clearAll() {
		if(document.Edit.title!='Save') 
			return;

		document.frmBranches.cmbBankID.options[0].selected=true;
		document.frmBranches.txtBranchesDesc.value='';
		document.frmBranches.txtBranchesAddr.value='';
		document.frmBranches.chkBrchSlipTrf.checked=false;
		document.frmBranches.txtBranchesClrHos.value='';
	}
</script>
<link href="./themes/beyondT/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">@import url("./themes/beyondT/css/style.css"); </style>
</head>
<body>
<table width='100%' cellpadding='0' cellspacing='0' border='0' class='moduleTitle'>
  <tr>
    <td valign='top'> </td>
    <td width='100%'><h2>Branches Information : Bank Info</h2></td>
    <td valign='top' align='right' nowrap style='padding-top:3px; padding-left: 5px;'><A href='index.php?module=Contacts&action=index&return_module=Contacts&return_action=DetailView&&print=true' class='utilsLink'></td>
  </tr>
</table>
<p>
<p> 
<table width="431" border="0" cellspacing="0" cellpadding="0" ><td width="177">
<form name="frmBranches" method="post" action="./branches.php?pageid=<?=$_GET['pageID']?>&uniqcode=<?=$_GET['uniqcode']?>">
<input type="hidden" name="pageID" value="">
  <tr> 
    <td height="27" valign='top'> <p>  <img title="Back" onmouseout="this.src='./themes/beyondT/pictures/btn_back.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_back_02.jpg';" src="./themes/beyondT/pictures/btn_back.jpg" onclick="goBack();">
        <input type="hidden" name="sqlState" value="">
      </p></td>
    <td width="254" align='left' valign='bottom'> <font color="red" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
      <?
		if (isset($_GET['msg'])) {
			$expString  = $_GET['msg'];
			$expString = explode ("%",$expString);
			$length = sizeof($expString);
			for ($x=0; $x < $length; $x++) {		
				echo " " . $expString[$x];		
			}
		}		
		?>
      </font> </td>
  </tr><td width="177"><form name="frmBranches" method="post" action="./branches.php">
</table>
           <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="13"><img name="table_r1_c1" src="themes/beyondT/pictures/table_r1_c1.gif" width="13" height="12" border="0" alt=""></td>
                  <td width="339" background="themes/beyondT/pictures/table_r1_c2.gif"><img name="table_r1_c2" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td width="13"><img name="table_r1_c3" src="themes/beyondT/pictures/table_r1_c3.gif" width="13" height="12" border="0" alt=""></td>
                  <td width="11"><img src="themes/beyondT/pictures/spacer.gif" width="1" height="12" border="0" alt=""></td>
                </tr>
                <tr>
                  <td background="themes/beyondT/pictures/table_r2_c1.gif"><img name="table_r2_c1" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="">
							  <tr> 
							    <td><strong>Code</strong></td>
							    <td> <input type="text" readonly="true" name="txtBranchesID" value=<?=$_GET['id'] ?> ></td>
							  </tr>
						    <tr>
							    <td><strong>Bank</strong></td>
							    <td> <select disabled name="cmbBankID">
							    <?  $bankcode = $parent_branch->getBankCodes();
							
							        for($c=0;$c < count($bankcode);$c++)
							            if($bankcode[$c][0]==$message[0][1])
							                echo '<option selected value=' . $bankcode[$c][0] . '>' . $bankcode[$c][1] .'</option>';
							            else
							                echo '<option value=' . $bankcode[$c][0] . '>' . $bankcode[$c][1] .'</option>';
							
							    ?>
							    </select></td>
							  </tr>
							  <tr>
							    <td><strong>Description</strong></td>
							    <td><textarea name='txtBranchesDesc' disabled rows="3" tabindex='3' cols="30"><?=$message[0][2]?></textarea></td>
							  </tr>
							  <tr>
							    <td><strong>Address</strong></td>
							    <td><textarea name='txtBranchesAddr' rows="3" disabled tabindex='3' cols="30"><?=$message[0][3]?></textarea></td>
							  </tr>
							  <tr>
							    <td><strong>Slip Transfer</strong></td>
							    <td><input type="checkbox" disabled name="chkBrchSlipTrf" <?=($message[0][4]=='1'?'checked':'')?> value="1"></td>
							  </tr>
							  <tr>
							    <td><strong>Clear House Code</strong></td>
							    <td> <input type="text" disabled name="txtBranchesClrHos" value=<?=$message[0][5]?> ></td>
							  </tr>
					  <tr><td></td><td align="right" width="100%">
<?			if($locRights['edit']) { ?>
			        <img src="./themes/beyondT/pictures/btn_edit.jpg" title="Edit" onmouseout="mout();" onmouseover="mover();" name="Edit" onClick="edit();">
<?			} else { ?>
			        <img src="./themes/beyondT/pictures/btn_edit.jpg" onClick="alert('<?=$sysConst->accessDenied?>');">
<?			}  ?>
					  <img disabled src="./themes/beyondT/pictures/btn_clear.jpg" onmouseout="this.src='./themes/beyondT/pictures/btn_clear.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_clear_02.jpg';" onClick="clearAll();" >
</td>
					  </tr>				  
                  </table></td>
                  <td background="themes/beyondT/pictures/table_r2_c3.gif"><img name="table_r2_c3" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><img src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                </tr>
                <tr>
                  <td><img name="table_r3_c1" src="themes/beyondT/pictures/table_r3_c1.gif" width="13" height="16" border="0" alt=""></td>
                  <td background="themes/beyondT/pictures/table_r3_c2.gif"><img name="table_r3_c2" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><img name="table_r3_c3" src="themes/beyondT/pictures/table_r3_c3.gif" width="13" height="16" border="0" alt=""></td>
                  <td><img src="themes/beyondT/pictures/spacer.gif" width="1" height="16" border="0" alt=""></td>
                </tr>
              </table>
</form> 
</form>
</body>
</html>
<? } ?>
