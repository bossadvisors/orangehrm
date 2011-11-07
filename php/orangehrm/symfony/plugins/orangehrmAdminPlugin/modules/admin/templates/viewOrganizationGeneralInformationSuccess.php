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

<link href="<?php echo public_path('../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.core.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.datepicker.js') ?>"></script>

<?php echo javascript_include_tag('../orangehrmAdminPlugin/js/viewOrganizationGeneralInformationSuccess'); ?>
<?php echo stylesheet_tag('../orangehrmAdminPlugin/css/viewOrganizationGeneralInformationSuccess'); ?>

<div id="messagebar"  class="<?php echo isset($messageType) ? "messageBalloon_{$messageType}" : ''; ?>" >
    <span><?php echo isset($message) ? $message : ''; ?></span>
</div>

<div id="genInfo">
<div class="outerbox">
    <div class="mainHeading"><h2 id="genInfoHeading"><?php echo __('General Information'); ?></h2></div>
    <form name="frmGenInfo" id="frmGenInfo" method="post" action="<?php echo url_for('admin/viewOrganizationGeneralInformation'); ?>">

        <?php echo $form['_csrf_token']; ?>
        <?php echo $form['name']->renderLabel(__('Organization Name') . ' <span class="required">*</span>'); ?>
        <?php echo $form['name']->render(array("class" => "txtBox", "maxlength" => 100)); ?>
        <br class="clear"/>

        <label><?php echo __("Number of Employees")?></label>
        <div id="numOfEmployees"><?php echo $employeeCount;?></div>
        <br/>

        <?php echo $form['taxId']->renderLabel(__('Tax ID')); ?>
        <?php echo $form['taxId']->render(array("class" => "txtBox", "maxlength" => 30)); ?>
        <br class="clear"/>

        <?php echo $form['registraionNumber']->renderLabel(__('Registration Number')); ?>
        <?php echo $form['registraionNumber']->render(array("class" => "txtBox", "maxlength" => 30)); ?>
        <br class="clear"/>
        <br />
        <div class="hrLine"></div>

        <?php echo $form['phone']->renderLabel(__('Phone')); ?>
        <?php echo $form['phone']->render(array("class" => "txtBox", "maxlength" => 30)); ?>
        <br class="clear"/>

        <?php echo $form['fax']->renderLabel(__('Fax')); ?>
        <?php echo $form['fax']->render(array("class" => "txtBox", "maxlength" => 30)); ?>
        <br class="clear"/>

        <?php echo $form['email']->renderLabel(__('Email')); ?>
        <?php echo $form['email']->render(array("class" => "txtBox", "maxlength" => 30)); ?>
        <br class="clear"/>
        <br />
        <div class="hrLine" ></div>

        <?php echo $form['street1']->renderLabel(__('Address Street 1')); ?>
        <?php echo $form['street1']->render(array("class" => "txtBox", "maxlength" => 100)); ?>
        <br class="clear"/>

        <?php echo $form['street2']->renderLabel(__('Address Street 2')); ?>
        <?php echo $form['street2']->render(array("class" => "txtBox", "maxlength" => 100)); ?>
        <br class="clear"/>

        <?php echo $form['city']->renderLabel(__('City')); ?>
        <?php echo $form['city']->render(array("class" => "txtBox", "maxlength" => 30)); ?>
        <br class="clear"/>

        <?php echo $form['province']->renderLabel(__('State/Province')); ?>
        <?php echo $form['province']->render(array("class" => "txtBox", "maxlength" => 30)); ?>
        <br class="clear"/>

        <?php echo $form['zipCode']->renderLabel(__('Zip/Postal Code')); ?>
        <?php echo $form['zipCode']->render(array("class" => "txtBox", "maxlength" => 30)); ?>
        <br class="clear"/>

        <?php echo $form['country']->renderLabel(__('Country')); ?>
        <?php echo $form['country']->render(array("class" => "drpDown", "maxlength" => 30)); ?>
        <br class="clear"/>

        <?php echo $form['note']->renderLabel(__('Note')); ?>
        <?php echo $form['note']->render(array("class" => "txtArea", "maxlength" => 255)); ?>
        <br class="clear"/>
        
        <div class="formbuttons">
            <input type="button" class="savebutton" name="btnSaveGenInfo" id="btnSaveGenInfo"
                   value="<?php echo __("Edit"); ?>"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
        </div>
    </form>
</div>
</div>

<div class="paddingLeftRequired"><?php echo __('Fields marked with an asterisk')?> <span class="required">*</span> <?php echo __('are required.')?></div>

<script type="text/javascript">

    //<![CDATA[
    var edit = "<?php echo __("Edit"); ?>";
    var save = "<?php echo __("Save"); ?>";
    var nameRequired = '<?php echo __('Organization name required'); ?>';
    var invalidPhoneNumber = '<?php echo __('Phone number can contain only space, numbers, "+", and "-"'); ?>';
    var invalidFaxNumber = '<?php echo __('Fax can contain only space, numbers, "+", and "-"'); ?>';
    var incorrectEmail = "<?php echo __('Email address should contain at least one \".\" and one \"@\" Example:user@example.com');?>";
    //]]>
</script>