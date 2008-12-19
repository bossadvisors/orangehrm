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

$oldLeaveType = $records[0];
$leaveTypes = $records[1];
?>
<script type="text/javascript">
//<![CDATA[
    delNames = new Array();
    leaveNames = new Array();
<?php
    if($leaveTypes) {
        foreach($leaveTypes as $leaveType) {
            if ($leaveType->getLeaveTypeAvailable() == $leaveType->availableStatusFlag) {
                print "\tleaveNames.push(\"{$leaveType->getLeaveTypeName()}\");\n";
            } else {
                print "\tdelNames.push(\"{$leaveType->getLeaveTypeName()}\");\n";
            }
        }
    }
?>

    function addSave() {

        name = document.DefineLeaveType.txtLeaveTypeName.value;
        if (name == '') {
            alert ("<?php echo $lang_Error_LeaveDateCannotBeABlankValue; ?>");
            return false;
        }

        if (isTypeName(name)) {
            alert("<?php echo $lang_Leave_NAME_IN_USE_ERROR; ?>");
            return false;
        }

        <?php if ($_REQUEST['action'] == "Leave_Type_Edit_View") {?>

            document.DefineLeaveType.action = '?leavecode=Leave&action=Leave_Type_Edit';
        <?php } else {?>
        document.DefineLeaveType.action = '?leavecode=Leave&action=Leave_Type_Define';
        <?php }?>
        document.DefineLeaveType.submit();
    }

    function undeleteLeaveType() {
        document.DefineLeaveType.action = '?leavecode=Leave&action=Leave_Type_Undelete';
        document.DefineLeaveType.submit();
    }

    function isTypeName(name) {
        n = leaveNames.length;
        for (var i=0; i<n; i++) {
            if (leaveNames[i] == name) {
                return true;
            }
        }
        return false;
    }

    function isDeletedName(name) {
        n = delNames.length;
        for (var i=0; i<n; i++) {
            if (delNames[i] == name) {
                return true;
            }
        }
        return false;
    }

    function checkName() {
        name = document.DefineLeaveType.txtLeaveTypeName.value;
        oLink = document.getElementById("messageCell");

        if (isTypeName(name)) {
            oLink.innerHTML = "<?php echo $lang_Leave_NAME_IN_USE_ERROR; ?>";
            oLink.className = "error";
        } else if (isDeletedName(name)) {
            oLink.innerHTML = "<?php echo $lang_Leave_Define_IsDeletedName . ' ' .  $lang_Leave_Define_UndeleteLeaveType .
                "<br /><a href='javascript:undeleteLeaveType();'>$lang_Leave_Undelete</a>"; ?>";
            oLink.className = "warning";
        } else {
            oLink.innerHTML = "&nbsp;";
        }

    }
//]]>   
</script>
    <div class="formpage">
        <div class="outerbox">
            <div class="mainHeading"><h2><?php echo $lang_Leave_Define_leave_Type_Title;?></h2></div>
        
        <?php $message =  isset($_GET['message']) ? $_GET['message'] : null;
            if (isset($message)) {
                $messageType = CommonFunctions::getCssClassForMessage($message);
                $messageStr = "lang_Leave_" . $message;
        ?>
            <div class="messagebar">
                <span class="<?php echo $messageType; ?>"><?php echo (isset($$messageStr)) ? $$messageStr: CommonFunctions::escapeHtml($message); ?></span>
            </div>  
        <?php } ?>

        <form method="post" name="DefineLeaveType" id="DefineLeaveType" action="<?php echo $_SERVER['PHP_SELF']; ?>?leavecode=Leave&action=Leave_Type_Define">
          <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td>&nbsp;</td>
                </tr>
                <?php if($_REQUEST['action'] == "Leave_Type_Edit_View") {?>
                <tr>
                  <td><?php echo $lang_oldLeaveTypeName; ?></td>
                  <td><?php echo $oldLeaveType->getLeaveTypeName(); ?></td>
                  <td>&nbsp;</td>
                </tr>
                <?php } ?>
                <tr style="vertical-align: top; height: 50px; padding-top:50px;">
                  <td width="162"><?php if($_REQUEST['action'] == "Leave_Type_Edit_View") { echo $lang_newLeaveTypeName; } else { echo $lang_Leave_Common_LeaveTypeName;}?></td>
                  <td width="231"><input name="txtLeaveTypeName" type="text" id="txtLeaveTypeName" onkeyup="checkName();"></td>
                  <td width="180" id="messageCell" class="error">&nbsp;</td>
                </tr>
            </tbody>
          </table>
            <div class="formbuttons">               
                <input type="button" class="savebutton" id="saveBtn" 
                    onclick="addSave();" onmouseover="moverButton(this);" onmouseout="moutButton(this);"                          
                    value="<?php echo $lang_Common_Save;?>" />
            </div>          
        </form>
        </div>
        <script type="text/javascript">
        //<![CDATA[
            if (document.getElementById && document.createElement) {
                roundBorder('outerbox');                
            }
        //]]>
        </script>
        <div class="requirednotice"><?php echo preg_replace('/#star/', '<span class="required">*</span>', $lang_Commn_RequiredFieldMark); ?>.</div>
    </div>