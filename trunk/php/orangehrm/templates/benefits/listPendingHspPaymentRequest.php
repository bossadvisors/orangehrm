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

$requests = $records[0];

?>
<div class="outerbox">
    <div class="mainHeading"><h2><?php echo $lang_Benefits_HealthSavingsPlanPaymentsDue; ?></h2></div>

<?php if (isset($_GET['message'])) {

		$expString  = $_GET['message'];
		$messageType = CommonFunctions::getCssClassForMessage($expString);
		$expString = 'lang_Benefits_Errors_' . $expString;
?>
    <div class="messagebar">
        <span class="<?php echo $messageType; ?>"><?php echo $$expString; ?></span>
    </div>    
<?php }	?>

    <div class="actionbar">
        <div class="actionbuttons">
<?php
if ($_SESSION['printBenefits'] == "enabled" && $_SESSION['isAdmin']=='Yes' && count($requests) > 0) {
?>
<a href="?benefitcode=Benefits&action=List_Hsp_Due&printPdf=1&pdfName=HSP-Payments-Due"><img title="Save As PDF" onMouseOut="this.src='../../themes/beyondT/pictures/btn_save_as_pdf_01.gif';" onMouseOver="this.src='../../themes/beyondT/pictures/btn_save_as_pdf_02.gif';" src="../../themes/beyondT/pictures/btn_save_as_pdf_01.gif" border="0"></a>
<?php } ?>
        </div>              
        <div class="noresultsbar"></div>
        <div class="pagingbar"><?php echo (count($requests) == 0) ? $lang_empview_norecorddisplay : ''; ?></div>
    <br class="clear" />
    </div>
    <br class="clear" />    

<?php if (count($requests) > 0) { ?>

	<table border="0" cellpadding="5" cellspacing="0" class="data-table">
		<thead>
			<tr>
				<td><?php echo $lang_Benefits_Paid; ?></td>
		    	<td><?php echo $lang_Benefits_DateIncurred; ?></td>
		    	<td><?php echo $lang_Benefits_NameOfProvider; ?></td>
		    	<td><?php echo $lang_Benefits_ExpenseDescription; ?></td>
		    	<td><?php echo $lang_Benefits_IncurredFor; ?></td>
		    	<td><?php echo $lang_Benefits_Cost . " " . $lang_Benefits_US_Dollars; ?></td>
			</tr>
		</thead>
		<tbody>
		<?php if (count($requests) > 0) { ?>
			<?php
				$i=0;
				foreach ($requests as $request) {
					$rowStyle = 'odd';
					if (($i%2) == 0) {
						$rowStyle = 'even';
					}
					$i++;
			?>
				<tr>
					<td class="<?php echo $rowStyle; ?>">
						<a href="?benefitcode=Benefits&action=View_Edit_Hsp_Request&id=<?php echo $request->getId(); ?>"><?php echo $lang_Benefits_No; ?></a>
					</td>
					<td class="<?php echo $rowStyle; ?>"><?php echo LocaleUtil::getInstance()->formatDate($request->getDateIncurred()); ?></td>
					<td class="<?php echo $rowStyle; ?>"><?php echo $request->getProviderName(); ?></td>
					<td class="<?php echo $rowStyle; ?>"><?php echo $request->getExpenseDescription(); ?></td>
					<td class="<?php echo $rowStyle; ?>"><?php echo $request->getPersonIncurringExpense(); ?></td>
					<td class="<?php echo $rowStyle; ?>"><?php echo $request->getExpenseAmount(); ?></td>
				</tr>
			<?php } ?>
		<?php }?>
		</tbody>
	</table>
<?php } ?>
</div>
<script type="text/javascript">
    <!--
        if (document.getElementById && document.createElement) {
            roundBorder('outerbox');                
        }
    -->
</script>