<?php

class viewDefinedPredefinedReportsAction extends sfAction {

    const SEARCH_PARAM_ATTR_NAME = 'defineReportListParameters';
    
    public function execute($request) {

        $adminMode = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);

        if (!$adminMode) {
            return $this->renderText("You are not allowed to view this page!");
        }

        $pageNumber = 1;
        $sortField = 'name';
        $sortOrder = 'ASC';       
        
        $reportableService = new ReportableService();
        $searchString = null;        
        
        $this->searchForm = new ViewPredefinedReportsSearchForm();
        $reportList = $reportableService->getAllPredefinedReports("PIM_DEFINED");
        $totalRecords = count($reportList);
        $this->reportJsonList = $this->searchForm->getReportListAsJson($reportList);


        if ($request->isMethod('post')) {

            if ($request->hasParameter("chkSelectRow")) {
                $reportIds = $request->getParameter("chkSelectRow");
                $results = $reportableService->deleteReports($reportIds);
                if ($results > 0) {
                    $this->getUser()->setFlash('templateMessage', array('success', __('Selected Report(s) Deleted Successfully')));
                    $this->redirect('core/viewDefinedPredefinedReports');
                    return;
                }
            } else {
                $this->searchForm->bind($request->getParameter($this->searchForm->getName()));
                if ($this->searchForm->isValid()) {
                    $searchString = $this->searchForm->getValue("search");
                }
            }
        } else {
            // Get saved search params if not a new request.
            if ($request->hasParameter('pageNo') || 
                    $request->hasParameter('sortField') || 
                    $request->hasParameter('sortOrder')) {
                
                $this->_getSearchParams($searchString, $pageNumber, $sortField, $sortOrder);
                $pageNumber = $request->getParameter('pageNo', $pageNumber);
                $sortField = $request->getParameter('sortField', $sortField);
                $sortOrder = $request->getParameter('sortOrder', $sortOrder); 

                $this->searchForm->setDefault('search', $searchString);                 
            }           
        }

        $noOfRecords = sfConfig::get('app_items_per_page');
        $offset = ($pageNumber >= 1) ? (($pageNumber - 1)*$noOfRecords) : ($request->getParameter('pageNo', 1) - 1) * $noOfRecords;
        
        if ($searchString != null) {
            $reports = $reportableService->getPredefinedReportsByPartName("PIM_DEFINED", $searchString, $noOfRecords, $offset,  $sortField, $sortOrder);
            $totalRecords = $reportableService->getPredefinedReportCountByPartName("PIM_DEFINED", $searchString);
        } else {
            $reports = $reportableService->getPredefinedReports("PIM_DEFINED", $noOfRecords, $offset, $sortField, $sortOrder);
        }

        $this->_saveSearchParams($searchString, $pageNumber, $sortField, $sortOrder);
        
        $this->_setListComponent($reports,$noOfRecords,$pageNumber,$totalRecords);
        $this->parmetersForListComponent = array();
        
        list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
    }

    private function _setListComponent($reports,$noOfRecords,$pageNumber,$totalRecords){
        $configurationFactory = new ViewDefinedPredefinedReportsConfigurationFactory();
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setPageNumber($pageNumber);
        ohrmListComponent::setItemsPerPage($noOfRecords);
        ohrmListComponent::setNumberOfRecords($totalRecords);
        ohrmListComponent::setListData($reports);  
    }
    
    private function _saveSearchParams($searchString, $pageNumber, $sortField, $sortOrder) {
        $searchParams = array('searchString' => $searchString,
                              'pageNumber' => $pageNumber,
                              'sortField' => $sortField,
                              'sortOrder' => $sortOrder);
        $this->getUser()->setAttribute(self::SEARCH_PARAM_ATTR_NAME, $searchParams);
    }
    
    private function _getSearchParams(&$searchString, &$pageNumber, &$sortField, &$sortOrder) {
        if ($this->getUser()->hasAttribute(self::SEARCH_PARAM_ATTR_NAME)) {
            $searchParams = $this->getUser()->getAttribute(self::SEARCH_PARAM_ATTR_NAME);

            if (isset($searchParams['searchString'])) {
                $searchString = $searchParams['searchString'];
            }
            
            if (isset($searchParams['pageNumber'])) {
                $pageNumber = $searchParams['pageNumber'];
            }
            if (isset($searchParams['sortField'])) {
                $sortField = $searchParams['sortField'];
            }
            if (isset($searchParams['sortOrder'])) {
                $sortOrder = $searchParams['sortOrder'];
            }            
        }       
    }      
}

