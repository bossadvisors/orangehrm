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
class changeCandidateVacancyStatusAction extends sfAction {

    private $performedAction;

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    /**
     *
     * @return <type>
     */
    public function getCandidateService() {
        if (is_null($this->candidateService)) {
            $this->candidateService = new CandidateService();
            $this->candidateService->setCandidateDao(new CandidateDao());
        }
        return $this->candidateService;
    }

    /**
     *
     * @param <type> $request
     */
    public function execute($request) {

        $usrObj = $this->getUser()->getAttribute('user');
        if (!($usrObj->isAdmin() || $usrObj->isHiringManager() || $usrObj->isInterviewer())) {
            $this->redirect('pim/viewPersonalDetails');
        }
        $allowedCandidateList = $usrObj->getAllowedCandidateList();
        $allowedVacancyList = $usrObj->getAllowedVacancyList();
        $allowedCandidateListToDelete = $usrObj->getAllowedCandidateListToDelete();
        $this->enableEdit = true;
        if ($this->getUser()->hasFlash('templateMessage')) {
            list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
        }

        $id = $request->getParameter('id');
        if (!empty($id)) {
            $history = $this->getCandidateService()->getCandidateHistoryById($id);
            $action = $history->getAction();
            $this->interviewId = $history->getInterviewId();
            if ($action == WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_SHEDULE_INTERVIEW || $action == WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_SHEDULE_2ND_INTERVIEW) {
                if ($this->getUser()->hasFlash('templateMessage')) {
                    list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
                    $this->getUser()->setFlash('templateMessage', array($this->messageType, $this->message));
                }
                $this->redirect('recruitment/jobInterview?historyId=' . $id . '&interviewId=' . $this->interviewId);
            }
            $this->performedAction = $action;
            if ($this->getCandidateService()->isInterviewer($this->getCandidateService()->getCandidateVacancyByCandidateIdAndVacancyId($history->getCandidateId(), $history->getVacancyId()), $usrObj->getEmployeeNumber())) {
                $this->enableEdit = false;
                if ($action == WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_MARK_INTERVIEW_PASSED || $action == WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_MARK_INTERVIEW_FAILED) {
                    $this->enableEdit = true;
                }
            }
        }
        $candidateVacancyId = $request->getParameter('candidateVacancyId');
        $this->selectedAction = $request->getParameter('selectedAction');
        $param = array();
        if ($id > 0) {
            $param = array('id' => $id);
        }
        if ($candidateVacancyId > 0 && $this->selectedAction != "") {
            $candidateVacancy = $this->getCandidateService()->getCandidateVacancyById($candidateVacancyId);
            $nextActionList = $this->getCandidateService()->getNextActionsForCandidateVacancy($candidateVacancy->getStatus(), $usrObj);
            if ($nextActionList[$this->selectedAction] == "" || !in_array($candidateVacancy->getCandidateId(), $allowedCandidateList)) {
                $this->redirect('recruitment/viewCandidates');
            }
            $param = array('candidateVacancyId' => $candidateVacancyId, 'selectedAction' => $this->selectedAction);
            $this->performedAction = $this->selectedAction;
        }

        $this->setForm(new CandidateVacancyStatusForm(array(), $param, true));
//        if (!in_array($this->form->candidateId, $allowedCandidateList) && !in_array($this->form->vacancyId, $allowedVacancyList)) {
//            $this->redirect('recruitment/viewCandidates');
//        }
//        if (!in_array($this->form->candidateId, $allowedCandidateListToDelete)) {
//            $this->enableEdit = false;
//        }
        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $result = $this->form->performAction();
                if (isset($result['messageType'])) {
                    $this->getUser()->setFlash('templateMessage', array($result['messageType'], $result['message']));
                } else {
                    $message = $this->_getSuccessMessage($this->performedAction);
                    $this->getUser()->setFlash('templateMessage', array('success', $message));
                }
                $this->redirect('recruitment/changeCandidateVacancyStatus?id=' . $this->form->historyId);
            }
        }
    }

    private function _getSuccessMessage($action) {

        switch ($action) {

            case WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_SHORTLIST:
                $message = __("Successfully Shortlisted");
                break;
            case WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_REJECT:
                $message = __("Successfully Rejected");
                break;
            case WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_MARK_INTERVIEW_PASSED:
                $message = __(TopLevelMessages::UPDATE_SUCCESS);
                break;
            case WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_MARK_INTERVIEW_FAILED:
                $message = __(TopLevelMessages::UPDATE_SUCCESS);
                break;
            case WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_OFFER_JOB:
                $message = __("Successfully Offered");
                break;
            case WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_DECLINE_OFFER:
                $message = __("Successfully Marked as Declined");
                break;
            case WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_HIRE:
                $message = __("Successfully Hired");
                break;
        }
        return $message;
    }

}

