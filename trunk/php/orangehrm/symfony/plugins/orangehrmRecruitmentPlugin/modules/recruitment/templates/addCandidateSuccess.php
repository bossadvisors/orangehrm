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
<?php echo stylesheet_tag('orangehrm.datepicker.css') ?>
<?php echo javascript_include_tag('orangehrm.datepicker.js') ?>
<?php use_stylesheet('../../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css'); ?>
<?php use_javascript('../../../scripts/jquery/ui/ui.core.js'); ?>
<?php use_javascript('../../../scripts/jquery/ui/ui.dialog.js'); ?>
<?php use_stylesheet('../orangehrmRecruitmentPlugin/css/addCandidateSuccess'); ?>
<?php use_javascript('../orangehrmRecruitmentPlugin/js/addCandidateSuccess'); ?>
<?php $browser = $_SERVER['HTTP_USER_AGENT']; ?>
<?php if (strstr($browser, "MSIE 8.0")): ?>
    <?php $keyWrdWidth = 'width: 276px' ?>
    <?php $resumeWidth = 37 ?>
<?php else: ?>
    <?php $keyWrdWidth = 'width: 271px' ?>
    <?php $resumeWidth = 38; ?>
<?php endif; ?>
<?php $title = ($candidateId > 0) ? __('Candidate') : __('Add Candidate'); ?>
<?php
$list[] = array("id" => "", "name" => __('-- Select --'));
foreach ($jobVacancyList as $vacancy) {
    $list[] = array("id" => $vacancy->getId(), "name" => $vacancy->getVacancyName());
}
?>
    <?php echo isset($templateMessage)?templateMessage($templateMessage):''; ?>

<div id="messagebar" class="<?php echo isset($messageType) ? "messageBalloon_{$messageType}" : ''; ?>" >
    <span style="font-weight: bold;"><?php echo isset($message) ? $message : ''; ?></span>
</div>

<div id="addCandidate">
    <div class="outerbox" style="width:700px">

        <div class="mainHeading"><h2 id="addCandidateHeading"><?php echo $title; ?></h2></div>
        <form name="frmAddCandidate" id="frmAddCandidate" method="post" action="<?php echo url_for('recruitment/addCandidate?id=' . $candidateId); ?>" enctype="multipart/form-data">

            <?php echo $form['_csrf_token']; ?>
            <?php echo $form["vacancyList"]->render(); ?>
            <br class="clear"/>

            <div class="nameColumn" id="firstNameDiv">
                <label><?php echo __('Full Name'); ?></label>
            </div>
            <div class="column">
                <?php echo $form['firstName']->render(array("class" => "formInputText", "maxlength" => 35)); ?>
                <div class="errorHolder"></div>
                <br class="clear"/>
                <label id="frmDate" class="helpText"><?php echo __('First Name'); ?><span class="required">*</span></label>
            </div>
            <div class="column" id="middleNameDiv">
                <?php echo $form['middleName']->render(array("class" => "formInputText", "maxlength" => 35)); ?>
                <div class="errorHolder"></div>
                <br class="clear"/>
                <label id="toDate" class="helpText"><?php echo __('Middle Name'); ?></label>
            </div>
            <div class="column" id="middleNameDiv">
                <?php echo $form['lastName']->render(array("class" => "formInputText", "maxlength" => 35)); ?>
                <div class="errorHolder"></div>
                <br class="clear"/>
                <label id="toDate" class="helpText"><?php echo __('Last Name'); ?><span class="required">*</span></label>
            </div>
            <br class="clear"/>
            <br class="clear"/>
            <div class="newColumn">
                <?php echo $form['email']->renderLabel(__('E-Mail') . ' <span class="required">*</span>'); ?>
                <?php echo $form['email']->render(array("class" => "formInputText")); ?>
                <div class="errorHolder below"></div>
            </div>
            <div class="newColumn">
                <?php echo $form['contactNo']->renderLabel(__('Contact No'), array("class " => "contactNoLable")); ?>
                <?php echo $form['contactNo']->render(array("class" => "contactNo")); ?>
                <div class="errorHolder cntact"></div>
            </div>
            <br class="clear" />

            <div class="hrLine" >&nbsp;</div>
            <label id="jobLable"><?php echo __('Job Vacancy') ?></label>

            <div id="textBoxesGroup">
                <select id="jobDropDown0" class="vacancyDrop" onchange="validate()"><option></option></select>
            </div>
	    
            <?php if ($candidateId > 0) : ?>
                <?php $existingVacancyList = $actionForm->candidate->getJobCandidateVacancy(); ?>
                <?php if ($existingVacancyList[0]->getVacancyId() > 0) :
                    ?>
                    <div id="actionPane" style="float:left; width:200px; padding-top:0px">
                        <?php foreach ($existingVacancyList as $candidateVacancy) {
                            ?>
                            <div style="height: 15px">
                                <?php
                                if($candidateVacancy->getJobVacancy()->getStatus() == JobVacancy::ACTIVE) {
                                    $widgetName = $candidateVacancy->getId();
                                    echo $actionForm[$widgetName]->render(array("class" => "actionDrpDown"));
                                }
                                ?></div>
                            <br class="clear" />
                        <?php } ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>


            <br class="clear" />
            <span class="addText" id='addButton'><?php echo __('Add another'); ?></span>
            <div id="vacancyError"></div>
            <br class="clear" />

            <!-- Resume block : Begins -->
            <div>

                <?php
                if ($form->attachment == "") {
                    echo $form['resume']->renderLabel(__('Resume'), array("class " => "resume"));
                    echo $form['resume']->render(array("class " => "duplexBox", "size" => $resumeWidth));
                    echo "<br class=\"clear\"/>";
                    echo "<span id=\"cvHelp\" class=\"helpText\">[" . __(".docx, .doc, .odt, .pdf, .rtf, or .txt with maximum file size of 1MB") . "]</span>";
                } else {
                    $attachment = $form->attachment;
                    $linkHtml = "<a target=\"_blank\" class=\"fileLink\" href=\"";
                    $linkHtml .= url_for('recruitment/viewCandidateAttachment?attachId=' . $attachment->getId());
                    $linkHtml .= "\">{$attachment->getFileName()}</a>";
		    
                    echo $form['resumeUpdate']->renderLabel(__('Resume'));
                    echo $linkHtml;
                    echo "<br class=\"clear\"/>";
		    echo "<div id=\"radio\">";
                    echo $form['resumeUpdate']->render(array("class" => ""));
                    echo "<br class=\"clear\"/>";
		    echo "</div>";
                    echo "<div id=\"fileUploadSection\">";
                    echo $form['resume']->renderLabel(' ');
                    echo $form['resume']->render(array("class " => "duplexBox", "size" => $resumeWidth));
                    echo "<br class=\"clear\"/>";
                    echo "<span id=\"cvHelp\" class=\"helpText\">[" . __(".docx, .doc, .odt, .pdf, .rtf, or .txt with maximum file size of 1MB") . "]</span>";
                    echo "</div>";
                }
                ?>
            </div>

            <!-- Resume block : Ends -->

            <div>
                <?php echo $form['keyWords']->renderLabel(__('Keywords'), array("class " => "keywrd")); ?>
                <?php echo $form['keyWords']->render(array("class" => "keyWords", "style" => $keyWrdWidth)); ?>
                <div class="errorHolder below"></div>
            </div>
            <br class="clear" />
            <div>
                <?php echo $form['comment']->renderLabel(__('Comment'), array("class " => "comment")); ?>
                <?php echo $form['comment']->render(array("class" => "formInputText", "cols" => 35, "rows" => 4)); ?>
                <div class="errorHolder below"></div>
            </div>
            <br class="clear" />
            <div>
                <?php echo $form['appliedDate']->renderLabel(__('Date of Application'), array("class " => "appDate")); ?>
                <?php echo $form['appliedDate']->render(array("class" => "formDateInput")); ?>
                <input id="frmDateBtn" type="button" name="" value="  " class="calendarBtn" />
                <div class="errorHolder below"></div>
            </div>
            <br class="clear" />
            <div class="formbuttons">
                <?php if ($edit): ?>
                <input type="button" class="savebutton" name="btnSave" id="btnSave"
                       value="<?php echo __("Save"); ?>"onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                <?php endif; ?>
                       <?php if ($candidateId > 0): ?>
                    <input type="button" class="backbutton" name="btnBack" id="btnBack"
                           value="<?php echo __("Back"); ?>"onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                       <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<div class="paddingLeftRequired"><?php echo __('Fields marked with an asterisk') ?> <span class="required">*</span> <?php echo __('are required.') ?></div>
<br class="clear" />
<br class="clear" />

<?php if ($candidateId > 0) : ?>
    <?php $existingVacancyList = $actionForm->candidate->getJobCandidateVacancy(); ?>
    <?php if ($existingVacancyList[0]->getVacancyId() > 0) : ?>
        <div id="candidateHistoryResults">
            <?php include_component('core', 'ohrmList', $parmetersForListCompoment); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- confirmation box for removing vacancies-->
<div id="deleteConfirmation" title="<?php echo __('OrangeHRM - Confirmation Required'); ?>" style="display: none;">
    <?php echo __("Are you sure you want to remove job vacancy of the candidate") . "?"; ?>
    <div class="dialogButtons">
        <input type="button" id="dialogDeleteBtn" class="savebutton" value="<?php echo __('Remove'); ?>" />
        <input type="button" id="dialogCancelBtn" class="savebutton" value="<?php echo __('Cancel'); ?>" />
    </div>
</div>

<!-- confirmation box for remove vacancies & save -->
<div id="deleteConfirmationForSave" title="<?php echo __('OrangeHRM - Confirmation Required'); ?>" style="display: none;">
    <?php echo __("This action will remove the vacancy from the candidate") . "?"; ?>
    <div class="dialogButtons">
        <input type="button" id="dialogSaveButton" class="savebutton" value="<?php echo __('Continue'); ?>" />
        <input type="button" id="dialogCancelButton" class="savebutton" value="<?php echo __('Cancel'); ?>" />
    </div>
</div>

<script type="text/javascript">
    //<![CDATA[
    var dateFormat	= '<?php echo $sf_user->getDateFormat(); ?>';
    var jsDateFormat = '<?php echo get_js_date_format($sf_user->getDateFormat()); ?>';
    var dateDisplayFormat = dateFormat.toUpperCase();
    var lang_firstNameRequired = "<?php echo __("First name is required"); ?>";
    var lang_lastNameRequired = "<?php echo __("Last name is required"); ?>";
    var lang_emailRequired = "<?php echo __("E-mail is required"); ?>";
    var lang_validDateMsg = '<?php echo __("Please enter a valid date in %format% format", array('%format%' => strtoupper($sf_user->getDateFormat()))); ?>'
    var lang_validEmail = "<?php echo __("Email address should contain at least one '.' and one '@' Example:user@example.com"); ?>";
    var list = <?php echo json_encode($list); ?>;
    var lang_identical_rows = "<?php echo __("Cannot assign same vacancy twice"); ?>";
    var lang_tooLargeInput = "<?php echo __("Please enter no more than 30 characters"); ?>";
    var lang_commaSeparated = "<?php echo __("Enter comma separated words..."); ?>";
    var currentDate = '<?php echo date("Y-m-d"); ?>';
    var lang_dateValidation = "<?php echo __("Date of Application should be less than current date"); ?>";
    var lang_validPhoneNo = "<?php echo __("Enter a valid contact number"); ?>";
    var lang_noMoreThan255 = "<?php echo __("Please enter no more than 255 characters"); ?>";
    var lang_edit = "<?php echo __("Edit"); ?>";
    var lang_save = "<?php echo __("Save"); ?>";
    var candidateId = "<?php echo $candidateId; ?>";
    var attachment = "<?php echo $form->attachment; ?>"
    var changeStatusUrl = '<?php echo url_for('recruitment/changeCandidateVacancyStatus?'); ?>';
    var backBtnUrl = '<?php echo url_for('recruitment/viewCandidates?'); ?>';
    var interviewUrl = '<?php echo url_for('recruitment/jobInterview?'); ?>';
    var interviewAction = '<?php echo WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_SHEDULE_INTERVIEW; ?>';
    var lang_remove =  '<?php echo __("Remove"); ?>';
    var lang_editCandidateTitle = "<?php echo __('Edit Candidate'); ?>";
</script>
