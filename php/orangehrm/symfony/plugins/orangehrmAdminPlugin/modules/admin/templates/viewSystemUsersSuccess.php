<?php
/**
 * OrangeHRM Enterprise is a closed sourced comprehensive Human Resource Management (HRM)
 * System that captures all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM Inc is the owner of the patent, copyright, trade secrets, trademarks and any
 * other intellectual property rights which subsist in the Licensed Materials. OrangeHRM Inc
 * is the owner of the media / downloaded OrangeHRM Enterprise software files on which the
 * Licensed Materials are received. Title to the Licensed Materials and media shall remain
 * vested in OrangeHRM Inc. For the avoidance of doubt title and all intellectual property
 * rights to any design, new software, new protocol, new interface, enhancement, update,
 * derivative works, revised screen text or any other items that OrangeHRM Inc creates for
 * Customer shall remain vested in OrangeHRM Inc. Any rights not expressly granted herein are
 * reserved to OrangeHRM Inc.
 *
 * You should have received a copy of the OrangeHRM Enterprise  proprietary license file along
 * with this program; if not, write to the OrangeHRM Inc. 538 Teal Plaza, Secaucus , NJ 0709
 * to get the file.
 *
 */
?>
<link href="<?php echo public_path('../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css') ?>" rel="stylesheet" type="text/css"/>

<?php use_stylesheet('../../../themes/orange/css/ui-lightness/jquery-ui-1.8.13.custom.css'); ?>
<?php use_javascript('../../../scripts/jquery/ui/ui.core.js'); ?>
<?php use_javascript('../../../scripts/jquery/ui/ui.dialog.js'); ?>
<?php use_stylesheet('../../../themes/orange/css/jquery/jquery.autocomplete.css'); ?>
<?php use_javascript('../../../scripts/jquery/jquery.autocomplete.js'); ?>
<?php use_stylesheet('../orangehrmAdminPlugin/css/viewSystemUserSuccess'); ?>
<?php use_javascript('../orangehrmAdminPlugin/js/viewSystemUserSuccess'); ?>


<?php echo isset($templateMessage) ? templateMessage($templateMessage) : ''; ?>
<div id="messagebar" class="<?php echo isset($messageType) ? "messageBalloon_{$messageType}" : ''; ?>" >
    <span><?php echo isset($message) ? $message : ''; ?></span>
</div>

<div id="searchProject">
    <div class="outerbox">

        <div class="mainHeading">
            <h2><?php echo __("System Users") ?></h2>
        </div>

        <div class="searchbox">
            <form id="search_form" method="post" action="<?php echo url_for('admin/viewSystemUsers'); ?>">
                <div id="formcontent">
                    
                    <?php
                    echo $form['_csrf_token'];
                    echo $form->renderHiddenFields(); 
                    
                    echo $form['employeeName']->renderLabel(__("Employee Name"));
                    echo $form['employeeName']->render();
                   
                    echo $form['userType']->renderLabel(__("User Type"));
                    echo $form['userType']->render();

                    echo $form['userName']->renderLabel(__("Username"));
                    echo $form['userName']->render();
                    
                    ?>
                    <div class="errorHolder"></div>
                    <br class="clear"/>
                    <?php
                    echo $form['status']->renderLabel(__("Status"));
                    echo $form['status']->render();

                    
                    ?>
                    
                </div>
                <div class="actionbar">
                    <div class="actionbuttons">
                        <input
                            type="button" class="plainbtn" id="searchBtn"
                            onmouseover="this.className='plainbtn plainbtnhov'"
                            onmouseout="this.className='plainbtn'" value="<?php echo __("Search") ?>" name="_search" />
                        <input
                            type="button" class="plainbtn"
                            onmouseover="this.className='plainbtn plainbtnhov'" id="resetBtn"
                            onmouseout="this.className='plainbtn'" value="<?php echo __("Reset") ?>" name="_reset" />

                    </div>
                    <br class="clear" />
                </div>
                <br class="clear" />
            </form>
        </div>
    </div>
</div>

<div id="customerList">
    <?php include_component('core', 'ohrmList', $parmetersForListCompoment); ?>
</div>

<form name="frmHiddenParam" id="frmHiddenParam" method="post" action="<?php echo url_for('admin/viewSystemUsers'); ?>">
    <input type="hidden" name="pageNo" id="pageNo" value="" />
    <input type="hidden" name="hdnAction" id="hdnAction" value="search" />
</form>

<!-- confirmation box -->
<div id="deleteConfirmation" title="<?php echo __('OrangeHRM - Confirmation Required'); ?>" style="display: none;">

    <?php echo __("Selected project(s) will be deleted") . "?"; ?>

    <div class="dialogButtons">
        <input type="button" id="dialogDeleteBtn" class="savebutton" value="<?php echo __('Delete'); ?>" />
        <input type="button" id="dialogCancelBtn" class="savebutton" value="<?php echo __('Cancel'); ?>" />
    </div>
</div>

<script type="text/javascript">
    function submitPage(pageNo) {

        document.frmHiddenParam.pageNo.value = pageNo;
        document.frmHiddenParam.hdnAction.value = 'paging';
        document.getElementById('search_form').submit();

    }
                
    var addUserUrl          =   '<?php echo url_for('admin/saveSystemUser'); ?>';
    var lang_typeforhint    =   '<?php echo __("Type for hints") . "..."; ?>';
    var employees           =   <?php echo str_replace('&#039;', "'", $form->getEmployeeListAsJson()) ?> ;
    var employeesArray      =   eval(employees);
    var user_ValidEmployee  =   "<?php echo __("Select valid employee"); ?>";

</script>