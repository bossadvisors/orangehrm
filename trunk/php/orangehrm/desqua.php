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


define('OpenSourceEIM', dirname(__FILE__));
require_once OpenSourceEIM . '/lib/Models/eimadmin/Designations.php';
require_once OpenSourceEIM . '/lib/Models/eimadmin/DesQual.php';
require_once OpenSourceEIM . '/lib/Confs/sysConf.php';

	$parent_designation = new Designations();
	$sysConst = new sysConf(); 
	$locRights=$_SESSION['localRights'];

	$message = $parent_designation ->filterDesignations($_GET['id']);

$parent_desqual = new DesQualification();
$statlist = array('First Class','Second Class Upr.','Second Class Lwr.');

if(isset($_POST['STAT']) && $_POST['STAT']=="ADD")
    {
      $parent_desqual->setDesId($_GET['id']);
      $parent_desqual->setJDQualId($_POST['cmbQual']);
      $parent_desqual->setJDQualInst($_POST['txtInst']);
      $parent_desqual->setJDQualStat($_POST['cmbStat']);
      $parent_desqual->addJDQual();
    }

if(isset($_POST['STAT']) && $_POST['STAT']=="EDIT")
    {
      $parent_desqual->setDesId($_GET['id']);
      $parent_desqual->setJDQualId($_POST['cmbQual']);
      $parent_desqual->setJDQualInst($_POST['txtInst']);
      $parent_desqual->setJDQualStat($_POST['cmbStat']);
      $parent_desqual->updateJDQual();
    }

if(isset($_POST['STAT'])&&($_POST['STAT']=="DEL"))
    {
      $arr[1]=$_POST['chkdel'];
      $size = count($arr[1]);
      for($c=0 ; $size > $c ; $c++)
          if($arr[1][$c]!=NULL)
             $arr[0][$c]=$_GET['id'];

      $parent_desqual -> delJDQual($arr);
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<script language="JavaScript">

function addQUA()
{
	if(document.frmDesignations.cmbQual.value=='0') {
		alert("Field should be selected");
		document.frmDesignations.cmbQual.focus();
		return;
	}

	if(document.frmDesignations.cmbStat.value=='0') {
		alert("Field should be selected");
		document.frmDesignations.cmbStat.focus();
		return;
	}
	
  document.frmDesignations.STAT.value="ADD";
  document.frmDesignations.submit();
}

function editQUA()
{
  document.frmDesignations.STAT.value="EDIT";
  document.frmDesignations.submit();
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
		editQUA();
		return;
	}
	
	var frm=document.frmDesignations;
//  alert(frm.elements.length);
	for (var i=0; i < frm.elements.length; i++)
		frm.elements[i].disabled = false;
	document.Edit.src="./themes/beyondT/pictures/btn_save.jpg";
	document.Edit.title="Save";
}
	
function delQUA()
{
      var check = 0;
		with (document.frmDesignations) {
			for (var i=0; i < elements.length; i++) {
				if ((elements[i].type == 'checkbox') && (elements[i].checked == true)){
					check = 1;
				}
			}
        }

        if(check==0)
            {
              alert("Select atleast one check box");
              return;
            }


    //alert(cntrl.value);
    document.frmDesignations.STAT.value="DEL";
    document.frmDesignations.submit();
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="./themes/beyondT/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">@import url("./themes/beyondT/css/style.css"); </style>
</head>
<body>
<table width='100%' cellpadding='0' cellspacing='0' border='0' class='moduleTitle'>
  <tr>
    <td valign='top'> &nbsp;</td>
    <td width='100%'><h2>Designation Qualification: Designation Profile</h2></td>
    <td valign='top' align='right' nowrap style='padding-top:3px; padding-left: 5px;'><A href='index.php?module=Contacts&action=index&return_module=Contacts&return_action=DetailView&&print=true' class='utilsLink'></td>
  </tr>
</table>
<p>
<p>
<table width="431" border="0" cellspacing="0" cellpadding="0" ><td width="177">
<form name="frmDesignations" method="post" action="./desqua.php?pageID=<?=$_GET['pageID']?>&uniqcode=<?=$_GET['uniqcode']?>&id=<?=$_GET['id']?>">
<input type="hidden" name="pageID" value="">
  <tr>
    <td height="27" valign='top'> <p> <img title="Back" onmouseout="this.src='./themes/beyondT/pictures/btn_back.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_back_02.jpg';"  src="./themes/beyondT/pictures/btn_back.jpg" onclick="goBack();">
        <input type="hidden" name="STAT" value="">
      </p></td>
    <td width="254" align='left' valign='bottom'> <font color="red" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;
      </font> </td>
  </tr><td width="177">
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
						    <td>Designation</td>
						  	  <td> <strong><?=$message[0][1]?></strong></td>
						  </tr>
						  <tr>
						    <td>Review Date</td>
						    <?
						    $field = explode(" ",$message[0][4]);
						    ?>
						    <td><strong><?=$field[0]?></strong></td>
						  </tr>
						  <tr>
						    <td>Next Upgrade Level</td>
						    <td><strong><?=$message[0][5]?></strong></td>
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

<?
if(isset($_GET['QUA']))
{
    $arr[0]=$_GET['id'];
    $arr[1]=$_GET['QUA'];
    $edit=$parent_desqual->filterJDQual($arr);
?>
<br>
<br>
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
						             <td><strong>Qualification</strong></td>
						             <td><input type="hidden" name="cmbQual" value="<?=$edit[0][1]?>">
						             <?=$edit[0][1]?></td>
						    </tr>
						    <tr>
						             <td><strong>Institute</strong></td>
						             <td><input type="text" disabled name="txtInst" value="<?=$edit[0][2]?>">
						    </tr>
						    <tr>
						             <td><strong>Status</strong></td>
						             <td><select disabled name="cmbStat">
						             <?
						             for($c=0;count($statlist)> $c; $c++)
						                 if($edit[0][3]==$statlist[$c])
						                    echo '<option selected value=' . $statlist[$c] . '>' .$statlist[$c]. '</option>';
						                 else
						                    echo '<option value=' . $statlist[$c] . '>' .$statlist[$c]. '</option>';
						             ?>
						    </tr>
					  <tr><td></td><td align="right" width="100%">
<?				if($locRights['edit']) { ?>
			        <img src="./themes/beyondT/pictures/btn_edit.jpg" title="Edit" onmouseout="mout();" onmouseover="mover();" name="Edit" onClick="edit();">
<?				} else { ?>
			        <img src="./themes/beyondT/pictures/btn_edit.jpg" onClick="alert('<?=$sysConst->accessDenied?>');">
<?				} ?>
						</td></tr>

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
<?
} else {
?>
<br>
<br>
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
							
							         <td><strong>Qualification</strong></td>
							         <td><select <?=$locRights['add'] ? '':'disabled'?> name="cmbQual">
							         		<option value="0">-Select Qualification-</option>
							            <?
							            $quallist=$parent_desqual->getQual($_GET['id']);
							            for($c=0;$quallist && count($quallist)>$c;$c++)
							                echo '<option value=' . $quallist[$c][0] . '>' . $quallist[$c][1] . '</option>';
							            ?>
							         </td>
							</tr>
							<tr>
							         <td><strong>Institute</strong></td>
							         <td><input <?=$locRights['add'] ? '':'disabled'?> type="text" name="txtInst">
							</tr>
							<tr>
							         <td><strong>Status</strong></td>
							         <td><select <?=$locRights['add'] ? '':'disabled'?> name="cmbStat">
							         		<option value="0">-Select-</option>
							             <?
							             for($c=0;count($statlist)> $c; $c++)
							                    echo '<option value=' . $statlist[$c] . '>' .$statlist[$c]. '</option>';
							             ?>
							</tr>
					  <tr><td></td><td align="right" width="100%">
<?				if($locRights['add']) { ?>
					  <img onClick="addQUA();" onmouseout="this.src='./themes/beyondT/pictures/btn_save.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_save_02.jpg';" src="./themes/beyondT/pictures/btn_save.jpg">
<?				} else { ?>
					  <img onClick="alert('<?=$sysConst->accessDenied?>');" src="./themes/beyondT/pictures/btn_save.jpg">
<?				} ?>
						</td></tr>
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
<? } ?>

<table width='100%' cellpadding='0' cellspacing='0' border='0'>
  <tr>
    <td valign='top'> &nbsp;</td>
    <td valign='top' align='right' nowrap style='padding-top:3px; padding-left: 5px;'></td>
  </tr>

  <tr>

    <td width='100%'><h3>Assigned Qualifications </h3></td>
    <td valign='top' align='right' nowrap style='padding-top:3px; padding-left: 5px;'><A href='index.php?module=Contacts&action=index&return_module=Contacts&return_action=DetailView&&print=true' class='utilsLink'></td>
  </tr>
  <tr>
  <td>
<?	if($locRights['delete']) { ?>
		<img onClick="delQUA();" onmouseout="this.src='./themes/beyondT/pictures/btn_delete.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_delete_02.jpg';" src="./themes/beyondT/pictures/btn_delete.jpg">
  <? 	} else { ?>
        <img onClick="alert('<?=$sysConst->accessDenied?>');" src="./themes/beyondT/pictures/btn_delete.jpg">
<? 	} ?>
  </td>
  </tr>
<tr><td>&nbsp;</td></tr>
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
								         <td></td>
								         <td><strong>Qualifications</strong></td>
								         <td><strong>Institute</strong></td>
								         <td><strong>Status</strong></td>
								</tr>
								<?
								$rset = $parent_desqual ->getAssJDQual($_GET['id']);
								
								    for($c=0;$rset && $c < count($rset); $c++)
								        {
								        echo '<tr>';
								            echo "<td><input type='checkbox' class='checkbox' name='chkdel[]' value='" . $rset[$c][1] ."'></td>";
								            echo "<td><a href='./desqua.php?pageID=" . $_GET['pageID'] . "&uniqcode=" . $_GET['uniqcode'] . "&id=" . $_GET['id']. "&QUA=" . $rset[$c][1] . "'>" . $rset[$c][1] . "</a></td>";
								            echo '<td>' . $rset[$c][2] .'</td>';
								            echo '<td>' . $rset[$c][3] .'</td>';
								            echo '<td><a href="./desquasub.php?pageID=' . $_GET['pageID'] . '&uniqcode=' . $_GET['uniqcode'] . '&id=' . $_GET['id'].'&QUA='. $rset[$c][1] .'">Subjects</a></td>';
								        echo '</tr>';
								        }
								
								?>
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
</body>
</html>
