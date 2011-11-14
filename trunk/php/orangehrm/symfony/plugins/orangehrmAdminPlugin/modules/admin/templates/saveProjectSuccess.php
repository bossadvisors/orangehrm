<link href="<?php echo public_path('../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.core.js') ?>"></script>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.draggable.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.resizable.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.dialog.js') ?>"></script>

<?php use_stylesheet('../orangehrmAdminPlugin/css/saveProjectSuccess'); ?>
<?php use_javascript('../orangehrmAdminPlugin/js/saveProjectSuccess'); ?>
<?php use_stylesheet('../../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css'); ?>
<?php use_javascript('../../../scripts/jquery/ui/ui.core.js'); ?>
<?php use_stylesheet('../../../themes/orange/css/jquery/jquery.autocomplete.css'); ?>
<?php use_javascript('../../../scripts/jquery/jquery.autocomplete.js'); ?>
<?php echo isset($templateMessage) ? templateMessage($templateMessage) : ''; ?>
<div id="messagebar" class="<?php echo isset($messageType) ? "messageBalloon_{$messageType}" : ''; ?>" >
    <span><?php echo isset($message) ? $message : ''; ?></span>
</div>

<div id="addProject">
    <div class="outerbox">

        <div class="mainHeading"><h2 id="addProjectHeading"><?php echo __("Add Project"); ?></h2></div>
        <form name="frmAddProject" id="frmAddProject" method="post" action="<?php echo url_for('admin/saveProject'); ?>" >

            <?php echo $form['_csrf_token']; ?>
            <?php echo $form->renderHiddenFields(); ?>
            <br class="clear"/>

            <?php echo $form['customerName']->renderLabel(__('Customer Name') . ' <span class="required">*</span>'); ?>
            <?php echo $form['customerName']->render(array("class" => "formInputCustomer", "maxlength" => 52)); ?>
            <br class="clear"/>
            <span id="addCustomerLink"><?php echo "<a href=\"javascript:openDialogue()\">" . __('Add Customer') . "</a>" ?></span>
            <div class="errorHolder"></div>

            <br class="clear"/>


            <?php echo $form['projectName']->renderLabel(__('Name') . ' <span class="required">*</span>'); ?>
            <?php echo $form['projectName']->render(array("class" => "formInput", "maxlength" => 52)); ?>
            <div class="errorHolder"></div>

            <br class="clear"/>

            <label class="firstLabel"><?php echo __('Project Admin'); ?></label>

            <?php for ($i = 1; $i <= $form->numberOfProjectAdmins; $i++) {
            ?>
                <div class="projectAdmin" id="<?php echo "projectAdmin_" . $i ?>">
                <?php echo $form['projectAdmin_' . $i]->render(array("class" => "formInputProjectAdmin", "maxlength" => 100)); ?>
                <span class="removeText" id=<?php echo "removeButton" . $i ?>><?php echo __('Remove'); ?></span>
                <div class="errorHolder projectAdminError"></div>
                <br class="clear" />

            </div>
            <?php } ?> 
            <a class="addText" id='addButton'><?php echo __('Add Another'); ?></a>
            <div id="projectAdminNameError"></div>
            <br class="clear" />

            <?php echo $form['description']->renderLabel(__('Description')); ?>
            <?php echo $form['description']->render(array("class" => "formInput", "maxlength" => 256)); ?>
            <div class="errorHolder"></div>
            <br class="clear"/>


            <div class="actionbuttons">
                <input type="button" class="savebutton" name="btnSave" id="btnSave"
                       value="<?php echo __("Save"); ?>"onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                <input type="button" class="cancelbutton" name="btnCancel" id="btnCancel"
                       value="<?php echo __("Cancel"); ?>"onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
            </div>
        </form>
    </div>

</div>

<?php echo isset($templateMessageAct) ? templateMessage($templateMessageAct) : ''; ?>
            <div id="messagebar" class="<?php echo isset($messageTypeAct) ? "messageBalloon_{$messageTypeAct}" : ''; ?>" >
                <span><?php echo isset($messageAct) ? $messageAct : ''; ?></span>
            </div>

<?php if (!empty($projectId)) {
?>
                <div id="addActivity">
                    <div class="outerbox">
                        <div class="mainHeading"><h2 id="addActivityHeading"><?php echo __("Add Project Activity"); ?></h2></div>
                        <form name="frmAddActivity" id="frmAddActivity" method="post" action="<?php echo url_for('admin/addProjectActivity'); ?>" >

            <?php echo $activityForm['_csrf_token']; ?>
            <?php echo $activityForm->renderHiddenFields(); ?>
                <br class="clear"/>
            <?php echo $activityForm['activityName']->renderLabel(__('Name') . ' <span class="required">*</span>'); ?>
            <?php echo $activityForm['activityName']->render(array("class" => "formInput", "maxlength" => 102)); ?>
                <div class="errorHolder"></div>
                <br class="clear"/>
                <div class="actionbuttons">
                    <input type="button" class="savebutton" name="btnActSave" id="btnActSave"
                           value="<?php echo __("Save"); ?>"onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                    <input type="button" class="cancelbutton" name="btnActCancel" id="btnActCancel"
                           value="<?php echo __("Cancel"); ?>"onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                </div>
            </form>
        </div>
        <br class="clear"/>
    </div>
    
<?php include_component('core', 'ohrmList', $parmetersForListCompoment); ?>

<?php } ?>
<div class="paddingLeftRequired"><?php echo __('Fields marked with an asterisk') ?> <span class="required">*</span> <?php echo __('are required.') ?></div>
            <div id="customerDialog" title="<?php echo __('Add Customer') ?>"  style="display:none;">

                <div class="dialogButtons">
                    <form name="frmAddCustomer" id="frmAddCustomer" method="post" action="<?php echo url_for('admin/addCustomer'); ?>" >

                        <div class="newColumn">
                <?php echo $customerForm['customerName']->renderLabel(__('Name') . ' <span class="required">*</span>'); ?>
                <?php echo $customerForm['customerName']->render(array("class" => "formInput", "maxlength" => 52)); ?>
                <div id="errorHolderName"></div>
            </div>
            <br class="clear"/>

            <div class="newColumn">
                <?php echo $customerForm['description']->renderLabel(__('Description')); ?>
                <?php echo $customerForm['description']->render(array("class" => "formInput", "maxlength" => 255)); ?>
                <div id="errorHolderDesc"></div>
            </div>
            <br class="clear"/>
        </form>
        <br class="clear"/>
	<div class="actionbuttons">
        <input type="button" id="dialogSave" class="savebutton" value="<?php echo __('Save'); ?>" />
        <input type="button" id="dialogCancel" class="cancelbutton" value="<?php echo __('Cancel'); ?>" />
        <br class="clear"/>
	</div>
        <div class="DigPaddingLeftRequired"><?php echo __('Fields marked with an asterisk') ?> <span class="required">*</span> <?php echo __('are required.') ?></div>
    </div>
</div>

<div id="copyActivity" title="<?php echo __('Copy Activity') ?>"  style="display:none;">
    <br class="clear"/>
    <label for="addProjectActivity_activityName"><? echo __("Project Name"); ?> <span class="required">*</span></label>
    <input type="text" id="projectName" maxlength="52" class="project" name="projectName">
    <div id="errorHolderCopy"></div>
    <br class="clear">
    <br class="clear">
    <form name="frmCopyAct" id="frmCopyAct" method="post" action="<?php echo url_for('admin/copyActivity?projectId=' . $projectId); ?>">
        <?php echo $copyActForm['_csrf_token']; ?>
                <div id="copyActivityList">

                </div>
                <br class="clear">
                <div class="actionbuttons">
                    <input type="button" class="savebutton" name="btnCopyDig" id="btnCopyDig"
                           value="<?php echo __("Copy"); ?>"onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                    <input type="button" class="cancelbutton" name="btnCopyCancel" id="btnCopyCancel"
                           value="<?php echo __("Cancel"); ?>"onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>

                </div>
		<div class="DigPaddingLeftRequired"><?php echo __('Fields marked with an asterisk') ?> <span class="required">*</span> <?php echo __('are required.') ?></div>
            </form>
        </div>

        <script type="text/javascript">
            var employees = <?php echo str_replace('&#039;', "'", $form->getEmployeeListAsJson()) ?> ;
            var employeeList = eval(employees);
            var customers = <?php echo str_replace('&#039;', "'", $form->getCustomerListAsJson()); ?> ;
            var customerList = eval(customers);
            var projects = <?php echo str_replace('&#039;', "'", $form->getProjectListAsJson()); ?> ;
            var projectList = eval(projects);
	    <?php if($projectId > 0) { ?>
	    var activityList = <?php echo str_replace('&#039;', "'", $form->getActivityListAsJson($projectId)); ?>;
	    <?php } ?>
            var numberOfProjectAdmins = <?php echo $form->numberOfProjectAdmins; ?>;
            var lang_typeHint = '<?php echo __("Type for hints") . "..."; ?>';
            var lang_nameRequired = '<?php echo __("Customer name is required"); ?>';
            var lang_activityNameRequired = '<?php echo __("Activity name is required"); ?>';
            var lang_validCustomer = '<?php echo __("Enter a valid customer name"); ?>';
            var lang_projectRequired = '<?php echo __("Project name is required"); ?>';
            var lang_exceed50Chars = '<?php echo __("Cannot exceed 50 charactors"); ?>';
            var lang_exceed255Chars = '<?php echo __("Cannot exceed 255 charactors"); ?>';
            var lang_exceed100Chars = '<?php echo __("Cannot exceed 100 charactors"); ?>';
            var custUrl = '<?php echo url_for("admin/saveCustomerJson"); ?>';
            var projectUrl = '<?php echo url_for("admin/saveProject"); ?>';
            var urlForGetActivity = '<?php echo url_for("admin/getActivityListJason?projectId="); ?>';
            var urlForGetProjectList = '<?php echo url_for("admin/getProjectListJson?customerId="); ?>';
            var deleteActivityUrl = '<?php echo url_for("admin/deleteProjectActivity"); ?>';
            var cancelBtnUrl = '<?php echo url_for("admin/viewProjects"); ?>';
            var lang_enterAValidEmployeeName = "<?php echo __("Enter a valid employee name"); ?>";
            var lang_identical_rows = "<?php echo __("Cannot assign same employee twice"); ?>";
            var lang_noActivities = "<?php echo __("No assigned activities"); ?>";
            var lang_noActivitiesSelected = "<?php echo __("No activities selected"); ?>";
            var projectId = '<?php echo $projectId; ?>';
            var custId = '<?php echo $custId; ?>';
            var lang_edit = '<?php echo __("Edit"); ?>';
            var lang_save = '<?php echo __("Save"); ?>';
            var lang_editProject = '<?php echo __("Edit Project"); ?>';
            var lang_Project = '<?php echo __("Project"); ?>';
	    var lang_uniqueCustomer = '<?php echo __("Name already exist"); ?>';
	    var lang_uniqueName = '<?php echo __("Name already exist"); ?>';
	    var lang_editActivity = '<?php echo __("Edit Project Activity"); ?>';
	    var lang_addActivity = '<?php echo __("Add Project Activity"); ?>';
	    var isProjectAdmin = '<?php echo $isProjectAdmin; ?>';
</script>