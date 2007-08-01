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
 *
 */

$page=$records[1];
?>
<div id="page<?php echo $page; ?>">
<?php
if (is_array($records[0])) {
	foreach ($records[0] as $timesheetInfo) {

		$totalTime=$timesheetInfo['totalTime'];
		$activitySum=$timesheetInfo['activitySum'];
		$dailySum=$timesheetInfo['dailySum'];
		$timeExpenses=$timesheetInfo['durationArr'];
		$timesheet=$timesheetInfo['timesheet'];
		$employee=$timesheetInfo['employee'];

		$timesheetSubmissionPeriod=$timesheetInfo['timesheetSubmissionPeriod'];

		$startDate = strtotime($timesheet->getStartDate());
		$endDate = strtotime($timesheet->getEndDate());
?>
<h2>
<?php
	$headingStr = $lang_Time_Timesheet_TimesheetNameForViewTitle;
	echo preg_replace(array('/#periodName/', '/#startDate/', '/#name/'),
						  array($timesheetSubmissionPeriod->getName(), $timesheet->getStartDate(), "{$employee[2]} {$employee[1]}"), $headingStr);
?>
</h2>
<table border="0" cellpadding="5" cellspacing="0">
	<thead>
		<tr>
			<th class="tableTopLeft"></th>
	    	<th class="tableTopMiddle"></th>
	    	<th class="tableTopMiddle"></th>
	    <?php for ($i=$startDate; $i<=$endDate; $i+=3600*24) { ?>
	    	<th class="tableTopMiddle"></th>
	    <?php } ?>
	    	<th class="tableTopMiddle"></th>
			<th class="tableTopRight"></th>
		</tr>
		<tr>
			<th class="tableMiddleLeft"></th>
			<th width="100px" class="tableMiddleMiddle"><?php echo $lang_Time_Timesheet_Project; ?></th>
			<th width="100px" class="tableMiddleMiddle"><?php echo $lang_Time_Timesheet_Activity; ?></th>
		<?php for ($i=$startDate; $i<=$endDate; $i+=3600*24) { ?>
	    	<th width="80px" class="tableMiddleMiddle"><?php echo date('l Y-m-d', $i); ?></th>
	    <?php } ?>
	    	<th width="80px" class="tableMiddleMiddle"><?php echo $lang_Time_Timesheet_Total; ?></th>
			<th class="tableMiddleRight"></th>
		</tr>
	</thead>
	<tbody >
		<?php
		if (isset($timeExpenses) && is_array($timeExpenses)) {
			$customerObj = new Customer();
			$projectObj = new Projects();
			$projectActivityObj = new ProjectActivity();

			foreach ($timeExpenses as $project=>$timeExpense) {
				$projectDet = $projectObj->fetchProject($project);
				$customer = $customerObj->fetchCustomer($projectDet->getCustomerId());
				$projectActivities = $projectActivityObj->getActivityList($project);
			?>
			<tr>
				<td class="tableMiddleLeft"></td>
				<td ><?php echo "{$customer->getCustomerName()} - {$projectDet->getProjectName()}"; ?></td>
				<td ><?php echo $projectActivities[0]->getName(); ?></td>
			<?php for ($i=$startDate; $i<=$endDate; $i+=3600*24) {
					if (!isset($timeExpense[$i])) {
						$timeExpense[$i]=0;
					}
			?>
	    		<td ><?php echo round($timeExpense[$i]/36)/100; ?></td>
	    	<?php } ?>
	    		<th ><?php echo round($activitySum[$project]/36)/100; ?></th>
				<td class="tableMiddleRight"></td>
			</tr>
		<?php } ?>
			<tr>
				<td class="tableMiddleLeft"></td>
				<td colspan="2"><b><?php echo $lang_Time_Timesheet_Total; ?></b></td>
			<?php for ($i=$startDate; $i<=$endDate; $i+=3600*24) {
					if (!isset($dailySum[$i])) {
						$dailySum[$i]=0;
					}
			?>
		    	<td><b><?php echo round($dailySum[$i]/36)/100; ?></b></td>
		    <?php } ?>
		    	<td><b><?php echo round($totalTime/36)/100; ?></b></td>
				<td class="tableMiddleRight"></td>
			</tr>
		<?php } else { ?>
			<tr>
				<td class="tableMiddleLeft"></td>
				<td ><?php echo $lang_Error_NoRecordsFound; ?></td>
				<td ></td>
			<?php for ($i=$startDate; $i<=$endDate; $i+=3600*24) { ?>
	    		<td ></td>
	    	<?php } ?>
	    		<td ></td>
				<td class="tableMiddleRight"></td>
			</tr>
		<?php }?>
	</tbody>
	<tfoot>
	  	<tr>
			<td class="tableBottomLeft"></td>
			<td class="tableBottomMiddle"></td>
			<td class="tableBottomMiddle"></td>
		<?php for ($i=$startDate; $i<=$endDate; $i+=3600*24) { ?>
			<td class="tableBottomMiddle"></td>
		<?php } ?>
			<td class="tableBottomMiddle"></td>
			<td class="tableBottomRight"></td>
		</tr>
  	</tfoot>
</table>
<?php
	}
}
?>
</div>