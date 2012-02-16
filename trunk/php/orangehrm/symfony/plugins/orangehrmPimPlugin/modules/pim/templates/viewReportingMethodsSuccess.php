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
?>

<?php use_stylesheet('../orangehrmPimPlugin/css/viewReportingMethodsSuccess'); ?>

<?php echo isset($templateMessage) ? templateMessage($templateMessage) : ''; ?>

<div id="saveFormDiv">
    <div class="outerbox">

    <div class="mainHeading"><h2 id="saveFormHeading">Add Reporting Method</h2></div>

        <form name="frmSave" id="frmSave" method="post" action="<?php echo url_for('pim/viewReportingMethods'); ?>">
            
            <?php echo $form['_csrf_token']; ?>
            
            <?php echo $form['id']->render(); ?>
            
            <?php echo $form['name']->renderLabel(__('Name'). ' <span class="required">*</span>'); ?>
            <?php echo $form['name']->render(array("class" => "formInputText", "maxlength" => 100)); ?>
            <div class="errorHolder"></div>
            <br class="clear"/>
            
            <div class="formbuttons">
                <input type="button" class="savebutton" name="btnSave" id="btnSave"
                       value="<?php echo __('Save'); ?>"
                       title="<?php echo __('Save'); ?>"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                <input type="button" id="btnCancel" class="cancelbutton" value="<?php echo __('Cancel'); ?>"/>
            </div>

        </form>
    
    </div>
    
<div class="paddingLeftRequired"><span class="required">*</span> <?php echo __(CommonMessages::REQUIRED_FIELD); ?></div>    
    
</div> <!-- saveFormDiv -->

<!-- Listi view -->

<div id="recordsListDiv">
    <div class="outerbox">
        <form name="frmList" id="frmList" method="post" action="<?php echo url_for('pim/deleteReportingMethods'); ?>">
            <div class="mainHeading"><h2><?php echo __('Reporting Methods'); ?></h2></div>

            <div class="actionbar" id="listActions">
                <div class="actionbuttons">
                    <input type="button" class="addbutton" id="btnAdd" 
                           onmouseover="moverButton(this);" onmouseout="moutButton(this);" value="<?php echo __('Add'); ?>" title="<?php echo __('Add'); ?>"/>
                    <input type="button" class="delbutton" id="btnDel" 
                           onmouseover="moverButton(this);" onmouseout="moutButton(this);" value="<?php echo __('Delete'); ?>" title="<?php echo __('Delete'); ?>"/>
                </div>
            </div>

            <table width="550" cellspacing="0" cellpadding="0" class="data-table" id="recordsListTable">
                <thead>
                    <tr>
                        <td class="check"><input type="checkbox" id="checkAll" class="checkbox" /></td>
                        <td><?php echo __('Name'); ?></td>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach($records as $record): ?>
                    
                    <tr>
                        <td class="check">
                            <input type="checkbox" class="checkbox" name="chkListRecord[]" value="<?php echo $record->getId(); ?>" />
                        </td>
                        <td class="tdName tdValue">
                            <a href="#"><?php echo __($record->getName()); ?></a>
                        </td>
                    </tr>
                    
                    <?php endforeach; ?>
                    
                    <?php if (count($records) == 0) : ?>
                    <tr>
                        <td>
                            <?php echo __('No records to display'); ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    
                </tbody>
            </table>
        </form>
    </div>
</div> <!-- recordsListDiv -->    


<?php use_javascript('../orangehrmPimPlugin/js/viewReportingMethodsSuccess'); ?>

<script type="text/javascript">
//<![CDATA[	    
 
    var recordsCount = <?php echo count($records);?>;
   
    var recordKeyId = "reportingMethod_id";
   
    var saveFormFieldIds = new Array();
    saveFormFieldIds[0] = "reportingMethod_name";
    
    var urlForExistingNameCheck = '<?php echo url_for('pim/checkReportingMethodNameExistence'); ?>';
    
    var lang_addFormHeading = "<?php echo __('Add Reporting Method'); ?>";
    var lang_editFormHeading = "<?php echo __('Edit Reporting Method'); ?>";
    
    var lang_nameIsRequired = '<?php echo __(ValidationMessages::REQUIRED); ?>';
    var lang_nameExists = "<?php echo __('Name exists'); ?>";
    
//]]>	
</script> 