<?php

/**
 * PluginWorkflowStateMachine
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginWorkflowStateMachine extends BaseWorkflowStateMachine {
    const TIMESHEET_ACTION_VIEW = 0;
    const TIMESHEET_ACTION_SUBMIT = 1;
    const TIMESHEET_ACTION_APPROVE = 2;
    const TIMESHEET_ACTION_REJECT = 3;
    const TIMESHEET_ACTION_RESET = 4;
    const TIMESHEET_ACTION_MODIFY = 5;
    const TIMESHEET_ACTION_SAVE = 6;
    const TIMESHEET_ACTION_CREATE = 7;
    const ATTENDANCE_ACTION_PUNCH_IN=0;
    const ATTENDANCE_ACTION_PUNCH_OUT=1;
    const ATTENDANCE_ACTION_EDIT_PUNCH_IN_TIME=2;
    const ATTENDANCE_ACTION_EDIT_PUNCH_OUT_TIME=3;
    const ATTENDANCE_ACTION_CREATE = 4;
    const ATTENDANCE_ACTION_PROXY_PUNCH_IN=5;
    const ATTENDANCE_ACTION_PROXY_PUNCH_OUT=6;
    const ATTENDANCE_ACTION_DELETE=7;
     const ATTENDANCE_ACTION_EDIT_PUNCH_TIME=8;


    const RECRUITMENT_APPLICATION_ACTION_ATTACH_VACANCY = 1;
    const RECRUITMENT_APPLICATION_ACTION_SHORTLIST = 2;
    const RECRUITMENT_APPLICATION_ACTION_REJECT = 3;
    const RECRUITMENT_APPLICATION_ACTION_SHEDULE_INTERVIEW = 4;
    const RECRUITMENT_APPLICATION_ACTION_MARK_INTERVIEW_PASSED = 5;
    const RECRUITMENT_APPLICATION_ACTION_MARK_INTERVIEW_FAILED = 6;
    const RECRUITMENT_APPLICATION_ACTION_OFFER_JOB = 7;
    const RECRUITMENT_APPLICATION_ACTION_DECLINE_OFFER = 8;
    const RECRUITMENT_APPLICATION_ACTION_HIRE = 9;
    const RECRUITMENT_APPLICATION_ACTION_SHEDULE_2ND_INTERVIEW = 10;

    const FLOW_TIME_TIMESHEET = 0;
    const FLOW_ATTENDANCE = 1;
    const FLOW_RECRUITMENT = 2;

    public function getRecruitmentActionName($action) {
        $actionName = "";
        switch ($action) {
            case PluginWorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_ATTACH_VACANCY:
                $actionName = "Assigned a Vacancy";
                break;
            case PluginWorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_SHORTLIST:
                $actionName = "Shortlist";
                break;
            case PluginWorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_REJECT:
                $actionName = "Reject";
                break;
            case PluginWorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_SHEDULE_INTERVIEW:
                $actionName = "Schedule Interview";
                break;
            case PluginWorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_MARK_INTERVIEW_PASSED:
                $actionName = "Mark Interview Passed";
                break;
            case PluginWorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_MARK_INTERVIEW_FAILED:
                $actionName = "Mark Interview Failed";
                break;
            case PluginWorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_OFFER_JOB:
                $actionName = "Offer Job";
                break;
            case PluginWorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_DECLINE_OFFER:
                $actionName = "Decline Offer";
                break;
            case PluginWorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_HIRE:
                $actionName = "Hire";
                break;
            case PluginWorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_SHEDULE_2ND_INTERVIEW:
                $actionName = "Schedule Interview";
                break;
        }
        return $actionName;
    }

}