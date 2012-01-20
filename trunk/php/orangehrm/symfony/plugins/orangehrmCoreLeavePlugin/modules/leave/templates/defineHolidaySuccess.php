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
?>
<link href="<?php echo public_path('../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css') ?>" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.core.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.datepicker.js') ?>"></script>

<!-- Datepicker Plugin-->
<?php echo stylesheet_tag('orangehrm.datepicker.css') ?>
<?php echo javascript_include_tag('orangehrm.datepicker.js') ?>

<div class="formpageNarrow">

    <?php echo isset($templateMessage) ? templateMessage($templateMessage) : ''; ?>

    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo ($editMode) ? __('Edit') . " " . __('Holiday') : __('Add') . " " . __('Holiday'); ?></h2></div>

        <div id="errorDiv"> </div>

        <form id="frmHoliday" name="frmHoliday" method="post" action="<?php echo url_for('leave/defineHoliday') ?>">
            <?php echo $form->render(); ?>

            <input type="hidden" name="hdnEditMode" id="hdnEditMode" value="<?php echo ($editMode) ? 'yes' : 'no'; ?>" />

            <div class="formbuttons">
                <input type="button" class="savebutton" id="saveBtn" value="<?php echo __('Save'); ?>" />
                <input type="reset" class="resetbutton" value="<?php echo __('Reset'); ?>" id="btnReset" />
                <input type="button" class="savebutton" id="btnBack" value="<?php echo __('Back'); ?>" />
            </div>
        </form>
    </div>
    <div class="requirednotice"><?php echo __('Fields marked with an asterisk %asterisk are required.', array('%asterisk' => '<span class="required">*</span>')) ?></div>
</div>
<style type="text/css">
    label label.error{
        padding-left: 120px;
    }
    
    .maincontent span ul.error_list {
        margin-left: 20px;
        margin-top: 10px;
        font-size: 11px;
    }
    .maincontent ul.error_list {
        margin-left: 140px;
        font-size: 11px;
    }
</style>

<script type="text/javascript">
    //<![CDATA[
    
    $(document).ready(function() {
        
        var datepickerDateFormat = '<?php echo get_datepicker_date_format($sf_user->getDateFormat()); ?>';

        var lang_DateIsRequired = "<?php echo __("Date is required"); ?>";
        var lang_DateFormatIsWrong = '<?php echo __("Please enter a valid date in %format% format", array('%format%' => get_datepicker_date_format($sf_user->getDateFormat()))) ?>'
        var lang_NameIsRequired = "<?php echo __("Name is required"); ?>";
        var lang_NameIsOverLimit = "<?php echo __("Name should be less than %length% characters", array('%length%' => 200)); ?>";

        //Validation
        $("#frmHoliday").validate({
            rules: {
                'holiday[date]': {
                    required: true,
                    valid_date: function(){ return {format:datepickerDateFormat} }
                },
                'holiday[description]': {required: true, maxlength: 200}
            },
            messages: {
                'holiday[date]':{
                    required:  lang_DateIsRequired,
                    valid_date: lang_DateFormatIsWrong
                },
                'holiday[description]':{
                    required: lang_NameIsRequired,
                    maxlength: lang_NameIsOverLimit
                }
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.prev('label'));
                error.appendTo(element.next().next('.errorContainer'));
                error.appendTo(element.next('.errorContainer'));
            },
            invalidHandler: function(form, validator) {
                clearTemplateMessages();
            }
        });

        //clearing error messages after reset
        $("#btnReset").click(function() {
            $("#holiday_txtDescription").attr("class", "formInputText");
            $("#holiday_txtDate").attr("class", "formDateInput hasDatepicker");
            $(".errorContainer").html("");
        });
               
        // Back button
        $('#btnBack').click(function(){
            window.location.href = '<?php echo url_for('leave/viewHolidayList'); ?>';
        });

        $("#saveBtn").click(function(){
            $("#frmHoliday").submit();
        });

    }); 

    //]]>
</script>
