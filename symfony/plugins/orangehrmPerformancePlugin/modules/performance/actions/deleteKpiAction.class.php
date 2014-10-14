<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of deleteKpiAction
 *
 * @author nadeera
 */
class deleteKpiAction extends basePeformanceAction {

    public $kpiSearchForm;

    public function preExecute() {
        $this->_checkAuthentication();
    }

    /**
     *
     * @return KpiSearchForm
     */
    public function getKpiSearchForm() {
        if ($this->kpiSearchForm == null) {
            return new KpiSearchForm();
        } else {
            return $this->kpiSearchForm;
        }
    }

    /**
     *
     * @param KpiSearchForm $kpiSearchForm 
     */
    public function setKpiSearchForm($kpiSearchForm) {
        $this->kpiSearchForm = $kpiSearchForm;
    }

    public function execute($request) {

        $form = $this->getKpiSearchForm();

        if ($request->isMethod('post')) {
            $rowsToBeDeleted = $request->getParameter('chkSelectRow');

            if (sizeof($rowsToBeDeleted) > 0) {
                $this->getKpiService()->softDeleteKpi($rowsToBeDeleted);
                $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
            } else {
                $this->getUser()->setFlash('error', __(TopLevelMessages::SELECT_RECORDS));
            }
        }

        $this->form = $form;
        $this->redirect('performance/searchKpi');
    }

}