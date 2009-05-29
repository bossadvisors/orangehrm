<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
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
 */
 
require_once ROOT_PATH.'/lib/common/calendar.php';
require_once ROOT_PATH . '/lib/extractor/time/EXTRACTOR_AttendanceRecord.php';

if (isset($records['recordsArr'])) {
	$recordsArr = $records['recordsArr'];
	
}

if ($records['reportView'] == 'detailed' && isset($records['recordsArr'])) {
	$extractor = new EXTRACTOR_AttendanceRecord($records['userTimeZoneOffset'], $records['serverTimeZoneOffset']);
}

if (isset($records['message'])) {
	
	if ($records['message'] == 'update-success') {
		$records['message'] = $lang_Time_Attendance_ReportSavingSuccess;
	} elseif ($records['message'] == 'update-failure') {
		$records['message'] = $lang_Time_Attendance_ReportSavingFailure;
	} elseif($records['message'] == 'overlapping-failure') {
		$records['message'] = $lang_Time_Attendance_Overlapping;
	} elseif($records['message'] == 'nochange-failure') {
		$records['message'] = $lang_Time_Attendance_ReportNoChange;
	}
	
}

?>

<script type="text/javascript">
//<![CDATA[

<?php if (isset($records['recordsArr'])) { 

$count = count($recordsArr);	
	
?>

	dateTimeFormat = YAHOO.OrangeHRM.calendar.format+" "+YAHOO.OrangeHRM.time.format;

	function validate() {

		errFlag = false;		
		var i=0;
		count = <?php echo $count; ?>;
		
		for (i=0;i<count;i++) {
		
			var inTime = strToTime($("txtNewInDate-"+i).value+" "+$("txtNewInTime-"+i).value, dateTimeFormat);
			var outTime = strToTime($("txtNewOutDate-"+i).value+" "+$("txtNewOutTime-"+i).value, dateTimeFormat);

			if (!inTime || !outTime) {
				alert("<?php echo $lang_Time_Errors_InvalidDateOrTime; ?>");
				errFlag = true;
			}
			
			if (inTime >= outTime) {
				alert("<?php echo $lang_Time_Attendance_InvalidOutTime; ?>");
				errFlag = true;
			}
			
			var inTimeValue = trim($("txtNewInTime-"+i).value);
			var outTimeValue = trim($("txtNewOutTime-"+i).value);
			
			if (inTimeValue == '24:00' || outTimeValue == '24:00') {
				alert("<?php echo $lang_Time_Errors_InvalidMaxTime; ?>");
				errFlag = true;
			}
		
		}

		return !errFlag;
		
	}
	
	function submitForm() {
		if (validate()) {
			$("frmSaveAttendanceReport").submit();
		}
	}
	
<?php } ?>


<?php if ($records['reportType'] == 'Emp') { // Emp report data: Begins ?>	

	function markEmpNumber(empName) {
		empNoField = document.getElementById("hdnEmpNo");
		empFullName = document.getElementById("hdnEmpName");
		for(i in employees) {
			if (employees[i].toLowerCase() == empName.toLowerCase()) {
				empNoField.value = ids[i];
				empFullName.value = employees[i];
				return;
			} else {
				empNoField.value = '';
			}
		}
	}

    var employees = new Array();
    var ids = new Array();

	<?php
	$employees = $records['empList'];
	for ($i=0;$i<count($employees);$i++) {
		echo "employees[" . $i . "] = '" . addslashes($employees[$i][1] . " " . $employees[$i][2]) . "';\n";
		echo "ids[" . $i . "] = \"" . $employees[$i][0] . "\";\n";
	}
	?>
	
	function showAutoSuggestTip(obj) {
			obj.value = '';
			obj.style.color = '#000000';
	}
	
<?php }  ?>

<?php if ($records['reportView'] == 'summary') { ?>
	function showDetailedReport(dateVal) {
		document.frmShowDetailedReport.txtFromDate.value = dateVal;
		document.frmShowDetailedReport.txtToDate.value = dateVal;
		document.frmShowDetailedReport.submit();
	}
<?php } ?>

<?php if (isset($records['hdnFromSummary'])) { ?>

	function backToSummary() {
		var frm = document.frmGenerateAttendanceReport;
		frm.optReportView.value = 'summary';
		frm.txtFromDate.value = '<?php echo $records['orgFromDate']; ?>';
		frm.txtToDate.value = '<?php echo $records['orgToDate']; ?>';
		frm.submit();
	}

<?php } ?>

//]]>
</script> 

<style type="text/css">
#detailed-table td {
	width: 135px;
}
#detailed-table input {
	width: 110px;
	text-align: center;
}

.note-td {
	text-align: left;
}

</style>

<div class="outerbox" style="width:945px;">

<!-- Message box: Begins -->
<?php if (isset($records['noReports']) && $records['noReports']) { ?>
    <div class="messagebar">
        <span class="<?php echo 'FAILURE'; ?>"><?php echo $lang_Time_Attendance_NoReports; ?></span>
    </div>
<?php } ?>
<!-- Message box: Ends -->

<form id="frmGenerateAttendanceReport" name="frmGenerateAttendanceReport" method="post" 
    action="?timecode=Time&amp;action=Generate_Attendance_Report" <?php if ($records['reportType'] == 'Emp') { ?>onsubmit="markEmpNumber(this.txtEmployeeSearch.value);"<?php } ?>>

    <div class="mainHeading"><h2><?php echo $lang_Time_Heading_Attendance_Report.($records['empName'] != ''?': '.$records['empName']:''); ?></h2></div>
    <input type="hidden" name="hdnReportType" value="<?php echo $records['reportType']; ?>" />
    <input type="hidden" name="hdnEmpNo" id="hdnEmpNo" value="<?php echo $records['empId']; ?>" />
    <input type="hidden" name="hdnEmpName" id="hdnEmpName" value="<?php echo $records['empName']; ?>" />

    <div class="searchbox">
    
        <?php if ($records['reportType'] == 'Emp') {  ?>

       <label for="txtEmployeeSearchName"><?php echo $lang_Leave_Common_EmployeeName; ?></label>
        <div class="yui-skin-sam" style="float:left;margin-right:10px">
            <div id="employeeSearchAC" style="width:135px">    
                  <input  id="txtEmployeeSearch" type="text" name="txtEmployeeSearchName"  
                    type="text" value="<?php echo ($records['empName'] != '' ?$records['empName']:$lang_Common_TypeHereForHints); ?>" style="color:#999999;width:135px" 
                        onfocus="showAutoSuggestTip(this)"/>
                  <div id="employeeSearchACContainer"></div>      
            </div>
        </div>
          
          
        <?php } ?>
    
        <label for="txtFromDate"><?php echo $lang_Leave_Common_FromDate;?></label>
        <input type="text" name="txtFromDate" id="txtFromDate" size="10" value="<?php echo $records['fromDate']; ?>" />
        <input type="button" value="  " class="calendarBtn" />

        <label for="txtToDate"><?php echo $lang_Leave_Common_ToDate;?></label>
        <input type="text" name="txtToDate" id="txtToDate" size="10" value="<?php echo $records['toDate']; ?>" />
        <input type="button" value="  " class="calendarBtn" />

        
        <label for="loc_name"><?php echo $lang_Time_ReportType?></label>
        <select name="optReportView">
            <option value="summary"><?php echo $lang_Time_Option_Summary; ?></option>
            <option value="detailed" <?php echo (isset($records['reportView']) && $records['reportView'] == 'detailed')?'selected':''; ?>>
            <?php echo $lang_time_Option_Detailed; ?></option>
        </select>

        <input type="submit" class="punchbutton"
            class="punchbutton" onmouseover="moverButton(this);" onmouseout="moutButton(this);"                           
            value="<?php echo $lang_Time_Button_Generate;?>" />
        <br class="clear"/>
    </div>

</form>

</div> <!-- End of outerbox -->
    
<br class="clear" />





<?php if ($records['reportView'] == 'summary' && !empty($recordsArr)) { // Summary Table Begins ?>

<div class="outerbox" style="width:300px;text-align:center;">

<table border="0" cellpadding="0" cellspacing="0" class="data-table" id="summary-table">

  <thead>
	<tr>
    	<th><?php echo $lang_Common_Date; ?></th>
        <th><?php echo $lang_Time_Timesheet_Duration; ?></th>
    </tr>
  </thead>
  
  <tbody>
  
<?php for ($i=0; $i<$count; $i++) { ?>
	  
    <tr>
        <td><?php echo $recordsArr[$i][0]; ?></td>
        <td style="text-align:right;padding-right:80px">
        <?php 
        
        if ($recordsArr[$i][1] > 0) {
        	echo "<a href=\"javascript:showDetailedReport('{$recordsArr[$i][0]}')\" style=\"text-decoration:underline\">{$recordsArr[$i][1]}</a>";
        } else {
        	echo $recordsArr[$i][1];	
        }
        
        ?>
        </td>
    </tr>
    
<?php } ?>

 </tbody>
</table>

<form action="?timecode=Time&action=Summary_Attendance_Report" method="post" name="frmShowDetailedReport" id="frmShowDetailedReport" />
<input type="hidden" name="hdnEmployeeId" value="<?php echo $records['empId']; ?>" />
<input type="hidden" name="txtFromDate" value="" />
<input type="hidden" name="txtToDate" value="" />
<input type="hidden" name="orgFromDate" value="<?php echo $records['fromDate']; ?>" />
<input type="hidden" name="orgToDate" value="<?php echo $records['toDate']; ?>" />
<input type="hidden" name="hdnReportType" value="<?php echo $records['reportType']; ?>" />
<input type="hidden" name="optReportView" value="detailed" />
<input type="hidden" name="hdnEmpName" id="hdnEmpName" value="<?php echo $records['empName']; ?>" />
<input type="hidden" name="hdnFromSummary" value="yes" />
</form> 

</div> <!-- End of outerbox -->

<?php } // Summary Table Ends ?>





<?php if ($records['reportView'] == 'detailed' && isset($recordsArr)) { // Detailed Table Begins ?>

<div class="outerbox" style="width:945px;text-align:center;">

<!-- Message box: Begins -->
<?php if (isset($records['message'])) { ?>
    <div class="messagebar">
        <span class="<?php echo $records['messageType']; ?>"><?php echo $records['message']; ?></span>
    </div>
<?php } ?>
<!-- Message box: Ends -->

<?php if(isset($records['editMode'])) { ?>
<form id="frmSaveAttendanceReport" name="frmSaveAttendanceReport" method="post" action="?timecode=Time&action=Save_Attendance_Report">
<?php } ?>
    
<table border="0" cellpadding="0" cellspacing="0" class="data-table" id="detailed-table">
  <thead>
	<tr>
    	<th><?php echo $lang_Time_In.' '.$lang_Common_Date; ?></th>
        <th><?php echo $lang_Time_In.' '.$lang_Common_Time; ?></th>
    	<th><?php echo $lang_Time_In.' '.$lang_Common_Note; ?></th>
    	<th><?php echo $lang_Time_Out.' '.$lang_Common_Date; ?></th>
    	<th><?php echo $lang_Time_Out.' '.$lang_Common_Time; ?></th>
    	<th><?php echo $lang_Time_Out.' '.$lang_Common_Note; ?></th>
    	<?php if ($records['editMode']) { ?>
    	<th><?php echo $lang_Common_Delete; ?></th>
    	<?php } ?>
	</tr>
  </thead>
  <tbody>

	<?php 
	
	for ($i=0; $i<$count; $i++) { // Records array: Begins

	$inDate = $extractor->adjustToServerTime('date', 'add', $recordsArr[$i]->getInDate().' '.$recordsArr[$i]->getInTime());
	$inTime = $extractor->adjustToServerTime('time', 'add', $recordsArr[$i]->getInDate().' '.$recordsArr[$i]->getInTime());
	$outDate = $extractor->adjustToServerTime('date', 'add', $recordsArr[$i]->getOutDate().' '.$recordsArr[$i]->getOutTime());
	$outTime = $extractor->adjustToServerTime('time', 'add', $recordsArr[$i]->getOutDate().' '.$recordsArr[$i]->getOutTime());
	
	if ($records['editMode']) { 
	
	?>
  
    <tr>
        <td>
        <input type="hidden" name="hdnAttendanceId-<?php echo $i; ?>" value="<?php echo $recordsArr[$i]->getAttendanceId(); ?>" />
        <input type="text" name="txtNewInDate-<?php echo $i; ?>" id="txtNewInDate-<?php echo $i; ?>" size="10" value="<?php echo $inDate; ?>" />
        <input type="hidden" name="hdnOldInDate-<?php echo $i; ?>" value="<?php echo $inDate;?>" />
        </td>
        <td>
        <input type="text" name="txtNewInTime-<?php echo $i; ?>" id="txtNewInTime-<?php echo $i; ?>" value="<?php echo $inTime; ?>" />
        <input type="hidden" name="hdnOldInTime-<?php echo $i; ?>" value="<?php echo $inTime; ?>" />
        </td>
        <td class="note-td">
        <input type="text" name="txtNewInNote-<?php echo $i; ?>" id="txtNewInNote-<?php echo $i; ?>" value="<?php echo $recordsArr[$i]->getInNote(); ?>" />
        <input type="hidden" name="hdnOldInNote-<?php echo $i; ?>" value="<?php echo $recordsArr[$i]->getInNote(); ?>" />
        </td>
        <td>
        <input type="text" name="txtNewOutDate-<?php echo $i; ?>" id="txtNewOutDate-<?php echo $i; ?>" value="<?php echo $outDate; ?>" />
        <input type="hidden" name="hdnOldOutDate-<?php echo $i; ?>" value="<?php echo $outDate; ?>" />
        </td>
        <td>
        <input type="text" name="txtNewOutTime-<?php echo $i; ?>" id="txtNewOutTime-<?php echo $i; ?>" value="<?php echo $outTime; ?>" />
        <input type="hidden" name="hdnOldOutTime-<?php echo $i; ?>" value="<?php echo $outTime; ?>" />
        </td>
        <td class="note-td">
        <input type="text" name="txtNewOutNote-<?php echo $i; ?>" id="txtNewOutNote-<?php echo $i; ?>" value="<?php echo $recordsArr[$i]->getOutNote(); ?>" />
        <input type="hidden" name="hdnOldOutNote-<?php echo $i; ?>" value="<?php echo $recordsArr[$i]->getOutNote(); ?>" />
        </td>
        <td>
        <input type="checkbox" name="chkDeleteStatus-<?php echo $i; ?>" id="chkDeleteStatus-<?php echo $i; ?>" />
        </td>
    </tr>
    
    <?php } else { // If editing is not allowed ?>
    	
    <tr>
        <td>
        <?php echo $inDate ;?>
        </td>
        <td>
        <?php echo $inTime ;?>
        </td>
        <td class="note-td">
        <?php echo $recordsArr[$i]->getInNote() ;?>
        </td>
        <td>
        <?php echo $outDate ;?>
        </td>
        <td>
        <?php echo $outTime ;?>
        </td>
        <td class="note-td">
        <?php echo $recordsArr[$i]->getOutNote() ;?>
        </td>
    </tr>
    
	<?php } } // Records array: Ends ?>
	
  </tbody>
</table>

<br class="clear" /> 

<?php if($records['editMode']) { ?>
<input type="hidden" name="hdnEmployeeId" value="<?php echo $recordsArr[0]->getEmployeeId(); ?>" />
<input type="hidden" name="txtFromDate" value="<?php echo $records['fromDate']; ?>" />
<input type="hidden" name="txtToDate" value="<?php echo $records['toDate']; ?>" />
<input type="hidden" name="hdnReportType" value="<?php echo $records['reportType']; ?>" />
<input type="hidden" name="optReportView" value="<?php echo $records['reportView']; ?>" />
<input type="hidden" name="recordsCount" value="<?php echo $count; ?>" />
<input type="hidden" name="hdnEmpName" id="hdnEmpName" value="<?php echo $records['empName']; ?>" />
<?php if (isset($records['hdnFromSummary'])) { ?>
<input type="hidden" name="orgFromDate" value="<?php echo $records['orgFromDate']; ?>" />
<input type="hidden" name="orgToDate" value="<?php echo $records['orgToDate']; ?>" />
<input type="hidden" name="hdnFromSummary" value="yes" />
<input type="button" value="Back" onclick="backToSummary()" class="punchbutton" />
<?php } ?>
<input type="button" name="btnSave" value="<?php echo $lang_Common_Save; ?>" onclick="submitForm()" 
class="punchbutton" onmouseover="moverButton(this);" onmouseout="moutButton(this);" />    
</form>
<?php } ?>

<br class="clear" /> 
    

</div> <!-- End of outerbox -->

<?php } // Detailed Table Ends ?>

<div id="cal1Container" style="position:absolute;" ></div>
<script type="text/javascript">
//<![CDATA[

    if (document.getElementById && document.createElement) {
        roundBorder('outerbox');                
    }
    
<?php if ($records['reportType'] == 'Emp') { // Emp report data: Begins ?>
    
	YAHOO.OrangeHRM.autocomplete.ACJSArray = new function() {
	   	// Instantiate first JS Array DataSource
	   	this.oACDS = new YAHOO.widget.DS_JSArray(employees);
	
	   	// Instantiate AutoComplete for txtEmployeeSearch
	   	this.oAutoComp = new YAHOO.widget.AutoComplete('txtEmployeeSearch','employeeSearchACContainer', this.oACDS);
	   	this.oAutoComp.prehighlightClassName = "yui-ac-prehighlight";
	   	this.oAutoComp.typeAhead = false;
	   	this.oAutoComp.useShadow = true;
	   	this.oAutoComp.minQueryLength = 1;
	   	this.oAutoComp.textboxFocusEvent.subscribe(function(){
	   	    var sInputValue = YAHOO.util.Dom.get('txtEmployeeSearch').value;
	   	    if(sInputValue.length === 0) {
	   	        var oSelf = this;
	   	        setTimeout(function(){oSelf.sendQuery(sInputValue);},0);
	   	    }
	   	});
	};
	
<?php } // Emp report data: Ends ?>
    
//]]>
</script>
