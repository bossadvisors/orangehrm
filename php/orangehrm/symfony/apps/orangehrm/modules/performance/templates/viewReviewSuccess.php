<?php
/* For formatting date */
$formatData['currentFormat'] = 'yyyy-mm-dd';
$formatData['newFormat'] = 'dd/mm/yyyy';
$formatData['currentSeparater'] = '-';
$formatData['newSeparater'] = '/';
?>

<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery.autocomplete.css')?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo public_path('../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css')?>" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js')?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.core.js')?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.datepicker.js')?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js')?>"></script>

<div id="content">
	
	<div id="contentContainer">
	
		<?php echo isset($templateMessage)?templateMessage($templateMessage):''; ?>
	
		<div class="outerbox">

            <div id="formHeading"><h2>Search Performance Reviews</h2></div>
			
			<form method="post" action="#" id="frmSearch" name="frmSearch" class="content_inner">
			
			<div id="formWrapper">
            
            	<label for="txtPeriodFromDate">From </label>
                <input id="txtPeriodFromDate" name="txtPeriodFromDate" type="text" class="date-pick formInputText" 
                value="<?php echo isset($clues['from'])?$clues['from']:''; ?>" tabindex="1" />
                <input id="fromButton" name="fromButton" class="calendarBtn" type="button" value="   " />
                <div class="errorDiv"></div>
                <br class="clear"/>
                
                <label for="txtPeriodToDate">To </label>
                <input id="txtPeriodToDate" name="txtPeriodToDate" type="text" class="date-pick formInputText" 
                value="<?php echo isset($clues['to'])?$clues['to']:''; ?>" tabindex="2" />
                <input id="toButton" name="toButton" class="calendarBtn" type="button" value="   " />
                <div class="errorDiv"></div>
                <br class="clear"/>
                
                <label for="txtJobTitleCode">Job Title</label>
                <select name="txtJobTitleCode" class="formSelect" tabindex="3">
                	<option value="0">All</option>
                	<?php
                	foreach ($jobList as $job) {
                	
                		if ($job->getId() == $clues['jobCode']) {
                		    $selected = ' selected';
                		} else {
                		    $selected = '';
                		}
                		
                		$jobName = $job->getName();
                		
                		if ($job->getIsActive() == JobTitle::JOB_STATUS_DELETED) {
                		    $jobName = $jobName.' ('.__('Deleted').')';
                		}
                		
                		echo "<option value=\"".$job->getId()."\"".$selected.">".htmlspecialchars_decode($jobName)."</option>\n";
                	}
                	?>
                </select>
                <br class="clear"/>

				<label for="txtSubDivisionId">Sub Unit</label>
                <select name="txtSubDivisionId" class="formSelect" tabindex="4">
                	<option value="0">All</option>
                	<?php
                	foreach ($subDivisionList as $subDivisionb) {

                		if ($subDivisionb->getId() == $clues['divisionId']) {
                		    $selected = ' selected';
                		} else {
                		    $selected = '';
                		}
						echo "<option value=\"".$subDivisionb->getId()."\"".$selected.">".$subDivisionb->getTitle()."</option>\n";
                	}
                	?>
				</select>
                <br class="clear"/>
                
                <?php if ($loggedAdmin || $loggedReviewer) { ?>
                <label for="txtEmpName">Employee</label>
                <input id="txtEmpName" name="txtEmpName" type="text" class="formInputText" 
                value="<?php echo isset($clues['empName'])?$clues['empName']:'Type for hints...'?>" tabindex="5" />
                <input type="hidden" name="hdnEmpId" id="hdnEmpId" 
                value="<?php echo isset($clues['empId'])?$clues['empId']:'0'?>">
                <div class="errorDiv"></div>
                <br class="clear"/>
				<?php } // $loggedAdmin || $loggedReviewer:Ends ?>

				<?php if ($loggedAdmin) { ?>
                <label for="txtReviewerName">Reviewer</label>
                <input id="txtReviewerName"  name="txtReviewerName" type="text" class="formInputText" 
                value="<?php echo isset($clues['reviewerName'])?$clues['reviewerName']:'Type for hints...'?>" tabindex="6" />
                <input type="hidden" name="hdnReviewerId" id="hdnReviewerId" 
                value="<?php echo isset($clues['reviewerId'])?$clues['reviewerId']:'0'?>">
                <div class="errorDiv"></div>
                <br class="clear"/>
                <?php } // $loggedAdmin:Ends ?>
                
			</div> <!-- formWrapper:Ends -->
				
			<div id="buttonWrapper">
                <input type="button" class="savebutton" id="searchButton" value="Search" tabindex="7" />
            </div>  
            
            </form>
            
		</div> <!-- outerbox:Ends -->

	</div> <!-- contentContainer:Ends -->
	<br class="clear"/>
   
	<div id="errorContainer" class="hide">
	 
	</div>
	
	<?php
	if (count($reviews) > 0) {
	?>
   
	<div class="outerbox">
	
		<form method="post" action="#" id="frmList" name="frmList" class="content_inner">
	   		
		<div class="navigationHearder">

            <?php if ($loggedAdmin) { ?>
	    	<input type="button" class="savebutton" id="addReview" value="Add" tabindex="8" />
            <input type="submit" class="savebutton" name="editReview" id="editReview" value="Edit" tabindex="9" disabled />
	        <input type="button" class="clearbutton" id="deleteReview" value="Delete" tabindex="10" disabled />
            <?php } ?>

			<?php if ($pager->haveToPaginate()) { ?>
			<div class="pagingbar">
			<?php include_partial('global/paging_links', array('pager' => $pager, 'url'=>'@performance_reviews'));?>
			</div>
			<?php } ?>

		</div>
		
		<div id="tableWrapper">
		
			<table cellpadding="0" cellspacing="0" class="data-table" align="center">
			
				<thead>
            		<tr>
            			<td width="50" class="tdcheckbox">
							<input type="checkbox" name="allCheck" value="" id="allCheck" <?php echo ($loggedAdmin)?'':'disabled'; ?> />
						</td>
            			
						<td scope="col">
							Employee
						</td>
						
						<td scope="col">
							Job Title
						</td>
						 
						<td scope="col">
							Reviewer
						</td>
						
						<td scope="col">
							Review Period
						</td>

						<td scope="col">
							Due Date
						</td>
						
						<td scope="col">
							Status
						</td>
						
					</tr>
				</thead>

            	<tbody>

        		<?php
					$i = 0;
	        		foreach ($reviews as $review) {
	        			
	        			$rowClass = ($i%2)?'even':'odd';
        		?>
            		
            		<tr class="<?php echo $rowClass; ?>">

		       			<td class="tdcheckbox">
							<input type="checkbox" class="innercheckbox" name="chkReview[]" 
							id="chkReview-<?php echo $i; ?>" value="<?php echo $review->getId(); ?>"
							<?php echo (($review->getState() == PerformanceReview::PERFORMANCE_REVIEW_STATUS_SCHDULED) && $loggedAdmin)?'':'disabled'; ?> />
						</td>
						
						<td class="">
				 			<?php echo $review->getEmployee()->getFullName(); ?>
				 		</td>
				 		
				 		<td class="">
				 			<?php echo htmlspecialchars_decode($review->getJobTitle()->getName()); ?>
				 		</td>
				 		
				 		<td class="">
							<?php echo $review->getReviewer()->getFullName(); ?>
				 		</td>
				 		
				 		<td class="">
				 			<?php
				 				$link = false;
				 				if ($loggedEmpId == $review->getEmployeeId()) {
				 					if ($review->getState() == PerformanceReview::PERFORMANCE_REVIEW_STATUS_APPROVED) {
				 					    $link = true;
				 					} else {
				 						$link = false; 
				 					}
				 				} elseif ($loggedReviewer && $review->getState() != PerformanceReview::PERFORMANCE_REVIEW_STATUS_SUBMITTED) {
				 				    $link = true;
				 				} elseif ($loggedAdmin) {
				 				    $link = true;
				 				}
				 			?>
				 			<?php if ($link) { ?>
				 			<a href="<?php echo url_for('performance/performanceReview?id='.$review->getId()) ?>"><?php echo formatDate($review->getperiodFrom(), $formatData).' - '.formatDate($review->getperiodTo(), $formatData); ?></a>
							<?php } else { 
				 						echo formatDate($review->getperiodFrom(), $formatData).' - '.formatDate($review->getperiodTo(), $formatData);
							} ?>							
				 		</td>
				 		
				 		<td class="">
				 			<?php echo formatDate($review->getDueDate(), $formatData); ?>
				 		</td>	
				 		
				 		<td class="">
				 			<?php echo $review->getTextStatus(); ?>
				 		</td>

					</tr>
					
					<?php
							$i++;						
	            		} // End of foreach
					?>
				
				</tbody>
 			
			</table>
		
		</div> <!-- tableWrapper:Ends -->
		
		<!-- Preserving search clues -->
		
		<input name="txtPeriodFromDate" type="hidden" value="<?php echo isset($clues['from'])?$clues['from']:''; ?>" />
        <input name="txtPeriodToDate" type="hidden" value="<?php echo isset($clues['to'])?$clues['to']:''; ?>" />
		<input name="txtJobTitleCode" type="hidden" value="<?php echo isset($clues['jobCode'])?$clues['jobCode']:''; ?>" />		
		<input name="txtSubDivisionId" type="hidden" value="<?php echo isset($clues['divisionId'])?$clues['divisionId']:''; ?>" />		
        <input name="txtEmpName" type="hidden" value="<?php echo isset($clues['empName'])?$clues['empName']:''?>" />
        <input name="hdnEmpId" type="hidden" value="<?php echo isset($clues['empId'])?$clues['empId']:''?>">
        <input name="txtReviewerName" type="hidden" value="<?php echo isset($clues['reviewerName'])?$clues['reviewerName']:''?>" />
        <input name="hdnReviewerId" type="hidden" value="<?php echo isset($clues['reviewerId'])?$clues['reviewerId']:''?>">
        <input name="hdnPageNo" type="hidden" value="<?php echo isset($clues['pageNo'])?$clues['pageNo']:''?>">
		
		</form> <!-- #frmList:Ends -->

	</div> <!-- outerbox:Ends -->
	
	<?php
	} // End of checking $reviews count
	?>

</div> <!-- content: Ends -->

<script type="text/javascript">

	$(document).ready(function() {

		<?php if ($loggedAdmin || $loggedReviewer) { ?>

		var empdata = <?php echo str_replace('&#039;',"'",$empJson)?>;
		
		/* Auto completion of employees */
		$("#txtEmpName").autocomplete(empdata, {
			formatItem: function(item) {
		    	return item.name;
			}, matchContains:"word"
		}).result(function(event, item) {
		  	$('#hdnEmpId').val(item.id);
		});
		
		/* Auto completion of reviewers */
		$("#txtReviewerName").autocomplete(empdata, {
			formatItem: function(item) {
		    	return item.name;
			}, matchContains:"word"
		}).result(function(event, item) {
		  	$('#hdnReviewerId').val(item.id);
		});
		
		<?php } // $loggedAdmin || $loggedReviewer:Ends ?>
		
		/* Clearing auto-fill fields */
		$("#txtEmpName").click(function(){ $(this).attr({ value: '' }); $("#hdnEmpId").attr({ value: '0' }); });
		$("#txtReviewerName").click(function(){ $(this).attr({ value: '' }); $("#hdnReviewerId").attr({ value: '0' }); });
		
		/* Date picker */
        $.datepicker.setDefaults({showOn: 'click'});

		$("#txtPeriodFromDate").datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});
		$('#fromButton').click(function(){
			$("#txtPeriodFromDate").datepicker('show');
		});
		
		$("#txtPeriodToDate").datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});
		$('#toButton').click(function(){
			$("#txtPeriodToDate").datepicker('show');
		});
		
		/* Search button */
		$('#searchButton').click(function(){

            <?php if ($loggedAdmin || $loggedReviewer) { ?>
            if ($('#txtEmpName').val() == 'Type for hints...') {
                $('#txtEmpName').val('');
            }
            <?php } // $loggedAdmin || $loggedReviewer:Ends ?>

            <?php if ($loggedAdmin) { ?>
            if ($('#txtReviewerName').val() == 'Type for hints...') {
                $('#txtReviewerName').val('');
            }
            <?php } // $loggedAdmin:Ends ?>

			$('#frmSearch').submit();
            
		});
		
		/* Add button */
		$('#addReview').click(function(){
			window.location.href = '<?php echo url_for('performance/saveReview'); ?>';
		});

		/* Edit button */
		$('#editReview').click(function(){
			$('#frmList').attr('action', '<?php echo url_for('performance/saveReview'); ?>');
			$('#frmList').submit();
		});
		
		/* Delete button */
		$('#deleteReview').click(function(){
			$('#frmList').attr('action', '<?php echo url_for('performance/deleteReview'); ?>');
			$('#frmList').submit();
		});

		/* Checkbox behavior */
		$("#allCheck").click(function() {
			if ($('#allCheck').attr('checked')) {
				$('.innercheckbox').attr('checked', true);
                $('#deleteReview').attr('disabled', false);
			} else {
				$('.innercheckbox').attr('checked', false);
			}
		});

		$(".innercheckbox").click(function() {
			if(!($(this).attr('checked'))) {
				$('#allCheck').attr('checked', false);
			}
            $('#editReview').attr('disabled', false);
            $('#deleteReview').attr('disabled', false);
		});
		
	}); // ready():Ends

	/* Applying rounding box style */ 
	if (document.getElementById && document.createElement) {
 		roundBorder('outerbox');
	}

</script>

