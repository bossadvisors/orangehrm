<?php

class saveLeaveEntitlementsAction extends baseLeaveAction {

    public function execute($request) {
        $formDefaults = array();
        $formOptions = $this->getLoggedInUserDetails();

        $form = new LeaveSummaryForm($formDefaults, $formOptions, true);
        $saveSuccess = true;

        if ($request->isMethod(sfRequest::POST)) {
            $form->bind($request->getParameter($form->getName()));
            if ($form->isValid()) {
                $hdnEmpId = $request->getParameter('hdnEmpId');
                $hdnLeaveTypeId = $request->getParameter('hdnLeaveTypeId');
                $hdnLeavePeriodId = $request->getParameter('hdnLeavePeriodId');
                $txtLeaveEntitled = $request->getParameter('txtLeaveEntitled');
                $count = count($txtLeaveEntitled);

                $leaveEntitlementService = $this->getLeaveEntitlementService();
                $leaveSummaryData = $request->getParameter('leaveSummary');

                for ($i = 0; $i < $count; $i++) {
                    $leavePeriodId = empty($hdnLeavePeriodId[$i]) ? $leaveSummaryData['hdnSubjectedLeavePeriod'] : $hdnLeavePeriodId[$i];
                    try {
                        $leaveEntitlementService->saveEmployeeLeaveEntitlement($hdnEmpId[$i], $hdnLeaveTypeId[$i], $leavePeriodId, $txtLeaveEntitled[$i], true);
                    } catch (Exception $e) {
                        $saveSuccess = false;
                    }
                }

                if ($saveSuccess) {
                    $this->getUser()->setFlash('templateMessage', array('SUCCESS', __('Leave Entitlements Successfully Saved')));
                } else {
                    $this->getUser()->setFlash('templateMessage', array('FAILURE', __('Failed to Save Leave Entitlements')));
                }
            } else {
                $this->getUser()->setFlash('templateMessage', array('WARNING', __('Invalid Data Passed')));
            }

            $this->forward('leave', 'viewLeaveSummary');
        }
    }

}

