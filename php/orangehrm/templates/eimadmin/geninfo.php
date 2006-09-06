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

require_once ROOT_PATH . '/lib/confs/sysConf.php';

	$sysConst = new sysConf(); 
	$locRights=$_SESSION['localRights'];

function populateStates($value) {
	
	$view_controller = new ViewController();
	$provlist = $view_controller->xajaxObjCall($value,'LOC','province');
	
	$objResponse = new xajaxResponse();
	$xajaxFiller = new xajaxElementFiller();
	if ($provlist) {
		$objResponse->addAssign('lrState','innerHTML','<select name="txtState" id="txtState"><option value="0">--- Select ---</option></select>');
		$objResponse = $xajaxFiller->cmbFillerById($objResponse,$provlist,1,'frmGenInfo.lrState','txtState');
		
	} else {
		$objResponse->addAssign('lrState','innerHTML','<input type="text" name="txtState" id="txtState" value="">');
	}
	$objResponse->addAssign('status','innerHTML','');
	
return $objResponse->getXML();
}


function populateDistricts($value) {
	
	$view_controller = new ViewController();
	$dislist = $view_controller->xajaxObjCall($value,'LOC','district');
	
	$objResponse = new xajaxResponse();
	$xajaxFiller = new xajaxElementFiller();
	$response = $xajaxFiller->cmbFiller($objResponse,$dislist,1,'frmGenInfo','cmbCity');
	$response->addAssign('status','innerHTML','');
	
return $response->getXML();
}

$objAjax = new xajax();
$objAjax->registerFunction('populateStates');
$objAjax->registerFunction('populateDistricts');
$objAjax->processRequests();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<? $objAjax->printJavascript(); ?>
<? include(ROOT_PATH.'/scripts/archive.js'); ?>
<script>

function mout() {
	var Edit = document.getElementById("btnEdit");
	
	if(Edit.title=='Save') 
		Edit.src='../../themes/beyondT/pictures/btn_save.jpg'; 
	else
		Edit.src='../../themes/beyondT/pictures/btn_edit.jpg'; 
}

function mover() {
	var Edit = document.getElementById("btnEdit");
	
	if(Edit.title=='Save') 
		Edit.src='../../themes/beyondT/pictures/btn_save_02.jpg'; 
	else
		Edit.src='../../themes/beyondT/pictures/btn_edit_02.jpg'; 
}
	
function edit()
{
	var Edit = document.getElementById("btnEdit");
	
	if(Edit.title=='Save') {
		addUpdate();
		return;
	}
	
	var frm=document.frmGenInfo;
	for (var i=0; i < frm.elements.length; i++) {		
		frm.elements[i].disabled = false;
	}
	document.getElementById("btnClear").disabled = false;
	Edit.src="../../themes/beyondT/pictures/btn_save.jpg";
	Edit.title="Save";
}

	function addUpdate() {

		if (document.frmGenInfo.txtCompanyName.value == '') {
			alert ("<?=$err_CompanyName?>");
			document.frmGenInfo.txtCompanyName.focus();
			return;
		} 

		var cntrl = document.frmGenInfo.txtPhone;
		if(cntrl.value != '' && !numeric(cntrl)) {
			alert('<?=$err_Phone?>');
			cntrl.focus();
			return;
		}
		
		var cntrl = document.frmGenInfo.txtFax;
		if(cntrl.value != '' && !numeric(cntrl)) {
			alert('<?=$err_Phone?>');
			cntrl.focus();
			return;
		}
		
		document.getElementById("cmbState").value=document.getElementById("txtState").value;
		document.frmGenInfo.STAT.value = "EDIT";
		document.frmGenInfo.submit();		
	}
	
	function clearAll() {
		//need to work
		document.forms[0].reset('');
	}
	
	function validate() {
		
	return 'return false;';
	}
	
	function MM_preloadImages() { //v3.0
  		var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    	var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    		if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
	}	
		
</script>
<link href="../../themes/beyondT/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
@import url("../../themes/beyondT/css/style.css"); .style1 {color: #FF0000}
</style>
</head>
<body>
<table width='100%' cellpadding='0' cellspacing='0' border='0' class='moduleTitle'>
  <tr>
    <td valign='top'></td>
    <td width='100%'><h2><?=$heading?></h2></td>
    <td valign='top' align='right' nowrap style='padding-top:3px; padding-left: 5px;'><div id="status"></div></td>
  </tr>
</table>
<p>
<p> 
<? $editArr = $this->popArr['editArr']; ?>
<table width="431" border="0" cellspacing="0" cellpadding="0" ><td width="177">
<form name="frmGenInfo" id="frmGenInfo" method="post" action="<?=$_SERVER['PHP_SELF']?>?uniqcode=<?=$this->getArr['uniqcode']?>">

  <tr> 
    <td height="27" valign='top'> <p> 
       <input type="hidden" name="STAT" value="">
      </p></td>
    <td width="254" align='left' valign='bottom'> <font color="red" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
      <?
		if (isset($this->getArr['msg'])) {
			$expString  = $this->getArr['msg'];
			$expString = explode ("%",$expString);
			$length = sizeof($expString);
			for ($x=0; $x < $length; $x++) {		
				echo " " . $expString[$x];		
			}
		}		
		?>
      </font> </td>
  </tr><td width="177">
</table>

<? $editArr = $this->popArr['editArr']; ?>

              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="13"><img name="table_r1_c1" src="../../themes/beyondT/pictures/table_r1_c1.gif" width="13" height="12" border="0" alt=""></td>
                  <td width="339" background="../../themes/beyondT/pictures/table_r1_c2.gif"><img name="table_r1_c2" src="../../themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td width="13"><img name="table_r1_c3" src="../../themes/beyondT/pictures/table_r1_c3.gif" width="13" height="12" border="0" alt=""></td>
                  <td width="11"><img src="../../themes/beyondT/pictures/spacer.gif" width="1" height="12" border="0" alt=""></td>
                </tr>
                <tr>
                  <td background="../../themes/beyondT/pictures/table_r2_c1.gif"><img name="table_r2_c1" src="../../themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="">
                  			<tr>
							    <td><span class="error">*</span> <?=$compname?></td>
							    <td><input type="text" disabled name="txtCompanyName" value="<?=isset($editArr['COMPANY']) ? $editArr['COMPANY'] : ''?>"></td>
							    <td><?=$taxID?></td>
							    <td><input type="text" disabled name='txtTaxID'value="<?=isset($editArr['TAX']) ? $editArr['TAX'] : ''?>"></td>
				    </tr>
							  <tr> 
							    <td><?=$country?></td>
							    <td><select name='cmbCountry' disabled onChange="document.getElementById('status').innerHTML = 'Please Wait....'; xajax_populateStates(this.value);">
							    		<option value="0">--- Select ---</option>
							    <?		$cntlist = $this->popArr['cntlist'];
							    		for($c=0; $cntlist && count($cntlist)>$c ;$c++) 
							    			if(isset($editArr['COUNTRY']) && ($editArr['COUNTRY'] == $cntlist[$c][0]))
							    				echo "<option selected value='" . $cntlist[$c][0] . "'>" . $cntlist[$c][1] . "</option>";
							    			else
							    				echo "<option value='" . $cntlist[$c][0] . "'>" . $cntlist[$c][1] . "</option>";
							    ?>
							    </select></td>
							    <td><?=$naics?></td>
							    <td><input type="text" disabled name='txtNAICS' value="<?=isset($editArr['NAICS']) ? $editArr['NAICS'] : ''?>"></td>
							  </tr>
							  <tr> 
							    <td><?=$street1?></td>
							    <td><input type="text" disabled name='txtStreet1' value="<?=isset($editArr['STREET1']) ? $editArr['STREET1'] : ''?>"></td>
							    <td><?=$zip?></td>
							    <td><input type="text" disabled name='txtZIP' value="<?=isset($editArr['ZIP']) ? $editArr['ZIP'] : ''?>"></td>
							  </tr>
							  <tr> 
							    <td><?=$street2?></td>
							    <td><input type="text" disabled name='txtStreet2' value="<?=isset($editArr['STREET2']) ? $editArr['STREET2'] : ''?>"></td>
							    <td><?=$phone?></td>
							    <td><input type="text" disabled name='txtPhone' value="<?=isset($editArr['PHONE']) ? $editArr['PHONE'] : ''?>"></td>
							  </tr>
                  			  <tr valign="top"> 
							    <td><?=$state?></td>
							    <td><div id="lrState" name="lrState">
							    <? if (isset($editArr['COUNTRY']) && ($editArr['COUNTRY'] == 'US')) { ?>
							    	<select name="txtState" id="txtState" disabled>
							    		<option value="0">--- Select ---</option>
							     	<?	$statlist = $this->popArr['provlist'];
							    		for($c=0; $statlist && count($statlist)>$c ;$c++) 
							    			if($editArr['STATE'] == $statlist[$c][1])
							    				echo "<option selected value='" . $statlist[$c][1] . "'>" . $statlist[$c][2] . "</option>";
							    			else
							    				echo "<option value='" . $statlist[$c][1] . "'>" . $statlist[$c][2] . "</option>";
							    	?>
							    	</select>
							    	<? } else { ?>
							    	<input type="text" disabled name="txtState" id="txtState" value="<?=isset($editArr['STATE']) ? $editArr['STATE'] : ''?>">
							    	<? } ?>
							    	</div>
							    	<input type="hidden" name="cmbState" id="cmbState" value="<?=isset($editArr['STATE']) ? $editArr['STATE'] : ''?>">
						    	</td>
							    <td><?=$fax?></td>
							    <td><input type="text" disabled name="txtFax" value="<?=isset($editArr['FAX']) ? $editArr['FAX'] : ''?>"></td>
							  </tr>
							  <tr valign="top"> 
							    <td><?=$city?></td>
							    <td><input type="text" disabled name="cmbCity" value="<?=isset($editArr['CITY']) ? $editArr['CITY'] : ''?>"></td>
							    <td><?=$comments?></td>
							    <td><textarea disabled name='txtComments'><?=isset($editArr['COMMENTS']) ? $editArr['COMMENTS'] : ''?></textarea></td>
							  </tr>
							  <tr><td></td><td></td><td></td><td align="right">
<?			if($locRights['edit']) { ?>
			        <input type="image" class="button1" id="btnEdit" src="../../themes/beyondT/pictures/btn_edit.jpg" title="Edit" onMouseOut="mout();" onMouseOver="mover();" name="Edit" onClick="edit(); return false;">
<?			} else { ?>
			        <input type="image" class="button1" id="btnEdit" src="../../themes/beyondT/pictures/btn_edit.jpg" onClick="alert('<?=$sysConst->accessDenied?>'); return false;">
<?			}  ?>
					  <input type="image" class="button1" id="btnClear" disabled src="../../themes/beyondT/pictures/btn_clear.jpg" onMouseOut="this.src='../../themes/beyondT/pictures/btn_clear.jpg';" onMouseOver="this.src='../../themes/beyondT/pictures/btn_clear_02.jpg';" onClick="clearAll(); return false;" />
							</td> </tr>
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
<span id="notice">Fields marked with an asterisk <span class="error">*</span> are required.</span>
</form>
</body>
</html>
