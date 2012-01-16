<?php

/**
 * defineLeavePeriod actions.
 *
 * @package    orangehrm
 * @subpackage coreLeave
 * @author     sujith
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class leaveActions extends sfActions {

    private $leaveRequestService;
    private $leavePeriodService;
    private $holidayService;
    private $workWeekService;
    private $workWeekEntity;
    private $employeeService;

    /**
     * Returns Leave Period
     * @return LeavePeriodService
     */
    public function getLeavePeriodService() {

        if (is_null($this->leavePeriodService)) {
            $leavePeriodService = new LeavePeriodService();
            $leavePeriodService->setLeavePeriodDao(new LeavePeriodDao());
            $this->leavePeriodService = $leavePeriodService;
        }

        return $this->leavePeriodService;
    }

    /**
     * get Method for Holiday Service
     *
     * @return HolidayService $holidayService
     */
    public function getHolidayService() {
        if (is_null($this->holidayService)) {
            $this->holidayService = new HolidayService();
        }
        return $this->holidayService;
    }

    /**
     * Set HolidayService
     * @param HolidayService $holidayService
     */
    public function setHolidayService(HolidayService $holidayService) {
        $this->holidayService = $holidayService;
    }

    /**
     * get Method for WorkWeek Service
     *
     * @return WorkWeekService $workWeekService
     */
    public function getWorkWeekService() {
        if (is_null($this->workWeekService)) {
            $this->workWeekService = new WorkWeekService();
            $this->workWeekService->setWorkWeekDao(new WorkWeekDao());
        }
        return $this->workWeekService;
    }

    /**
     * Set WorkWeekService
     * @param WorkWeekService $workWeekService
     */
    public function setWorkWeekService(WorkWeekService $workWeekService) {
        $this->workWeekService = $workWeekService;
    }

    public function getEmployeeService() {
        if (is_null($this->employeeService)) {
            $empService = new EmployeeService();
            $empService->setEmployeeDao(new EmployeeDao());
            $this->employeeService = $empService;
        }
        return $this->employeeService;
    }

    /**
     * Sets EmployeeService
     * @param EmployeeService $service
     */
    public function setEmployeeService(EmployeeService $service) {
        $this->employeeService = $service;
    }

    /**
     *
     * @return LeaveRequestService
     */
    public function getLeaveRequestService() {
        if (is_null($this->leaveRequestService)) {
            $leaveRequestService = new LeaveRequestService();
            $leaveRequestService->setLeaveRequestDao(new LeaveRequestDao());
            $this->leaveRequestService = $leaveRequestService;
        }

        return $this->leaveRequestService;
    }

    /**
     *
     * @param LeaveRequestService $leaveRequestService
     * @return void
     */
    public function setLeaveRequestService(LeaveRequestService $leaveRequestService) {
        $this->leaveRequestService = $leaveRequestService;
    }

    /**
     * Gets the array of dates for a given month
     *
     * @param int $month Month as integer (eg: January = 1, February = 2, ...)
     * @return array Array of days for the given month
     */
    public function executeLoadDatesforMonth(sfWebRequest $request) {

        $month = (int) $request->getParameter('month');
        $isLeapYear = ($request->getParameter('isLeapYear') !== 'false');

        $this->getResponse()->setHttpHeader('Content-Type', 'application/json; charset=utf-8');
        return $this->renderText(json_encode($this->getLeavePeriodService()->getListOfDates($month, $isLeapYear)));

    }

    /**
     * Gets the end date of the leave period given the start month and start date
     */
    public function executeLoadLeavePeriodEndDate(sfWebRequest $request) {

        $month = (int) $request->getParameter('month');
        $date = (int) $request->getParameter('date');
        $format = $request->getParameter('format', 'F d');

        $endDateElements = explode(' ', $this->getLeavePeriodService()->calculateEndDate($month, $date, null, $format));
        $endDate = __($endDateElements[0]) . ' ' . $endDateElements[1];

        return $this->renderText($endDate);

    }

    /**
     * Checks whether the start date of the current leave period will be a past date, given the start month and start date
     */
    public function executeGetCurrentStartDate(sfWebRequest $request) {

        $month = (int) $request->getParameter('month');
        $date = (int) $request->getParameter('date');

        return $this->renderText($this->getLeavePeriodService()->calculateStartDate($month, $date, null));

    }

    /**
     * view Holiday list
     * @param sfWebRequest $request
     */
    public function executeViewHolidayList(sfWebRequest $request) {

        //authentication
        if(!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin']!='Yes') {
            $this->forward('leave', 'viewMyLeaveList');
        }

        $leavePeriodService = $this->getLeavePeriodService();

        //retrieve current leave period id
        $leavePeriodId = (!$leavePeriodService->getCurrentLeavePeriod() instanceof LeavePeriod)?0:$leavePeriodService->getCurrentLeavePeriod()->getLeavePeriodId();

        //generating leave period lists for display in dropdown
        $this->leavePeriods = $leavePeriodService->getLeavePeriodList();

        $startDate = date("Y-m-d");
        $endDate = date("Y-m-d");
        if($leavePeriodService->getCurrentLeavePeriod() instanceof LeavePeriod) {
            $startDate = $leavePeriodService->getCurrentLeavePeriod()->getStartDate();
            $endDate = $leavePeriodService->getCurrentLeavePeriod()->getEndDate();
        }

        if($request->isMethod('post')) {
            $leavePeriodId = $request->getParameter("leavePeriod");
            $leavePeriod = $leavePeriodService->readLeavePeriod($leavePeriodId);
            if($leavePeriod instanceof LeavePeriod) {
                $startDate = $leavePeriod->getStartDate();
                $endDate = $leavePeriod->getEndDate();
            }
        }

        $this->leavePeriodId = $leavePeriodId;
        $this->daysLenthList = $this->getWorkWeekEntity()->getDaysLengthList();
        $this->yesNoList = $this->getWorkWeekEntity()->getYesNoList();
        $this->holidayList = $this->getHolidayService()->searchHolidays($startDate, $endDate);

        if($request->isMethod('post') && count($this->holidayList) == 0) {
            $this->getUser()->setFlash('templateMessage', array('NOTICE', __('No Records Found')));
        }

        if ($this->getUser()->hasFlash('templateMessage')) {
            $this->templateMessage = $this->getUser()->getFlash('templateMessage');
            $this->getUser()->setFlash('templateMessage', array());
        }
    }

    /**
     * Add Holiday
     * @param sfWebRequest $request
     */
    public function executeDefineHoliday(sfWebRequest $request) {

        //authentication
        if(!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin']!='Yes') {
            $this->forward('leave', 'viewMyLeaveList');
        }

        $this->setForm(new HolidayForm());
        $editId = $request->getParameter('hdnEditId');

        $this->editMode = false; // pass edit mode for teh view
        $this->form->editMode = false; // pass edit mode for form

        if ($editId && $editId != "") {
            $this->form->setDefaultValues($editId);
        }

        if (($editId && $editId != "") || $request->getParameter('hdnEditMode') == 'yes') {
            $this->editMode = true;
            $this->form->editMode = true;
        }

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $post = $this->form->getValues();
                // save holiday

                if ($post['hdnHolidayId'] != "") {
                    $this->getUser()->setFlash('templateMessage', array('SUCCESS', __('Holiday Successfully Updated')));
                } else {
                    $this->getUser()->setFlash('templateMessage', array('SUCCESS', __('Holiday Successfully Saved')));
                }

                $date = $post['txtDate'];
                $hid  = $post['hdnHolidayId'];
                // read the holiday by date
                $holidayObjectDate = $this->getHolidayService()->readHolidayByDate($date);

                $allowToAdd = true;

                if($this->editMode) {
                    $holidayObject = $this->getHolidayService()->readHoliday($hid);
                    // if the selected date is already in a holiday not allow to add
                    /*if(($holidayObject->getDate() != $date && $date == $holidayObjectDate->getDate()) || $holidayObjectDate->getRecurring() == 1) {
                      $allowToAdd = false;
                    }*/
                    if($date != $holidayObjectDate->getDate() && $holidayObjectDate->getRecurring()) {
                        $allowToAdd = false;
                    }
                } else {
                    // days already added can not be selected to add
                    if($date == $holidayObjectDate->getDate() || $holidayObjectDate->getRecurring() == 1) {
                        $allowToAdd = false;
                    }

                }

                // Error will not return if the date if not in the correct format
                if(!$allowToAdd && !is_null($date)) {
                    $this->templateMessage = array('WARNING', __('The Date Is Already Assigned to Another Holiday'));
                } else {

                    //first creating the leave period if the date belongs to next leave period
                    if($this->getLeavePeriodService()->isWithinNextLeavePeriod(strtotime($post['txtDate']))) {
                        $this->getLeavePeriodService()->createNextLeavePeriod($post['txtDate']);
                    }

                    $holidayObject = $this->getHolidayService()->readHoliday($post['hdnHolidayId']);
                    $holidayObject->setDescription($post['txtDescription']);
                    $holidayObject->setDate($post['txtDate']);

                    $recurringValue = $post['chkRecurring'] == 'on' ? 1 : 0;
                    $holidayObject->setRecurring($recurringValue);

                    $holidayObject->setLength($post['selLength']);
                    $this->getHolidayService()->saveHoliday($holidayObject);
                    $this->redirect('leave/viewHolidayList');
                }
            }
        }
    }

    /**
     * Delete Holiday
     * @param sfWebRequest $request
     */
    public function executeDeleteHoliday(sfWebRequest $request) {

        $holidayIds = $request->getPostParameter('chkHolidayId[]');

        if (!empty($holidayIds)) {

            foreach ($holidayIds as $key => $id) {
                $this->getHolidayService()->deleteHoliday($id);
            }

            $this->getUser()->setFlash('templateMessage', array('SUCCESS', __('Successfully Deleted')));
        } else {
            $this->getUser()->setFlash('templateMessage', array('NOTICE', __('Please Select at Least One Holiday to Delete')));
        }


        $this->forward('leave', 'viewHolidayList');
    }

    /**
     * Display a list of leaves for HR Admins, supervisors and ESS users
     */
    /*public function executeViewLeaveList(sfWebRequest $request) {

      $this->setTemplate('viewLeaveList');

      $fromDate = $request->getPostParameter('calFromDate', null);
      $toDate = $request->getPostParameter('calToDate', null);
      $subunitId = $request->getPostParameter('cmbSubunit', null);
      $statuses = $request->getParameter('chkSearchFilter', array());

      $leavePeriodId = $request->getParameter('leavePeriodId', null);
      $leaveTypeId = $request->getParameter('leaveTypeId', null);
      $employeeId = $request->getParameter('employeeId', null);
      $employeeId = (empty($employeeId))? $request->getParameter("txtEmpID"):'';

      $statuses = (trim($request->getParameter('status') != ""))?array($request->getParameter('status')):$statuses;

      $page = $request->getParameter('page', 1);
      $message = $this->getUser()->getFlash('message', '');
      $messageType = $this->getUser()->getFlash('messageType', '');

      $leavePeriod = $this->getLeavePeriodService()->getCurrentLeavePeriod();

      if(trim($leavePeriodId) != "") {
      $leavePeriod = $this->getLeavePeriodService()->readLeavePeriod($leavePeriodId);
      } else {
      $leavePeriodId = $leavePeriod->getLeavePeriodId();
      }
      $employee = null;
      $overrideShowBackButton = false;
      $leaveRequest = null;

      $id = (int) $request->getParameter('id');

      if (empty($id)) {

      $mode = LeaveListForm::MODE_DEFAULT_LIST;

      $employeeService = $this->getEmployeeService();
      $employeeFilter = null;

      if (trim($employeeId) == "") {
      $this->_setLoggedInUserDetails();

      if ($this->userType == "Supervisor") {
      $employeeFilter = $employeeService->getSupervisorEmployeeChain(Auth::instance()->getEmployeeNumber());
      }

      $employeeFilter = $employeeService->filterEmployeeListBySubUnit($employeeFilter, $subunitId);

      } else {
      $employeeFilter = $employeeService->getEmployee($employeeId);
      //this is a dirty workaround but witout modyfying searchLeaveRequests of Dao it is difficult
      if(!$employeeFilter instanceof Employee) {
      $employeeFilter = new Employee();
      $employeeFilter->setEmpNumber(0);
      }
      $employee = $employeeFilter;
      if(!empty($subunitId) && $subunitId > 0) {
      $employeeFilter = $employeeService->filterEmployeeListBySubUnit(array(0 => $employee), $subunitId);
      }
      $overrideShowBackButton = true;
      }

      $dateRange = new DateRange($fromDate, $toDate);

      $searchParams = new ParameterObject(array(
      'dateRange' => $dateRange,
      'statuses' => $statuses,
      'employeeFilter' => $employeeFilter,
      'leavePeriod' => $leavePeriodId,
      'leaveType' => $leaveTypeId
      ));

      $result = $this->getLeaveRequestService()->searchLeaveRequests($searchParams, $page);
      $list = $result['list'];
      $recordCount = $result['meta']['record_count'];

      $this->page = $page;
      $this->recordCount = $recordCount;

      if ($recordCount == 0 && $request->isMethod("post")) {
      $message = 'No Records Found';
      $messageType = 'notice';
      }

      } else {

      $mode = LeaveListForm::MODE_HR_ADMIN_DETAILED_LIST;
      $employee = $this->getLeaveRequestService()->fetchLeaveRequest($id)->getEmployee();
      $list = $this->getLeaveRequestService()->searchLeave($id);
      $leaveRequest = $this->getLeaveRequestService()->fetchLeaveRequest($id);
      }

      $this->_setLoggedInUserDetails();

      $leaveListForm = new LeaveListForm($mode, $leavePeriod, $employee, $request, $this->loggedUserId, $leaveRequest);

      $list = (count($list)==0)?null:$list;
      $leaveListForm->setList($list);
      $leaveListForm->setShowBackButton($overrideShowBackButton);
      $leaveListForm->setEmployeeListAsJson($this->getEmployeeListAsJson());

      $this->leaveRequestId = $id;
      $this->form = $leaveListForm;
      $this->quotaArray = $this->form->getQuotaArray($list);
      $this->mode = $mode;
      $this->message = $message;
      $this->messageType = $messageType;
      $this->baseUrl = 'leave/viewLeaveList';
    }*/

    public function executeViewMyLeaveList(sfWebRequest $request) {
        
        sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

        $this->setTemplate('viewLeaveList');

        $id = (int) $request->getParameter('id');
        $mode = empty($id) ? LeaveListForm::MODE_MY_LEAVE_LIST : LeaveListForm::MODE_MY_LEAVE_DETAILED_LIST;

        if ($this->_isRequestFromLeaveSummary($request)) {
            $this->_setFilters($mode, $request->getGetParameters());
        }

        if ($request->isMethod('post')) {
            $this->_setFilters($mode, $request->getPostParameters());
        }

        // Reset filters if requested to
        if ($request->hasParameter('reset')) {
            $this->_setFilters($mode, array());
            $this->isMyLeaveListDefaultView = true;
        } else {
            $this->isMyLeaveListDefaultView = false;
        }

        $filters = $this->_getFilters($mode);

        $isPaging = $request->getParameter('pageNo');

        $pageNumber = $isPaging;
        if (!is_null($this->getUser()->getAttribute('myLeaveListPageNumber')) && !($pageNumber >= 1)) {
            $pageNumber = $this->getUser()->getAttribute('myLeaveListPageNumber');
        }
        $this->getUser()->setAttribute('myLeaveListPageNumber', $pageNumber);

        $noOfRecordsPerPage = sfConfig::get('app_items_per_page');
        
        $leavePeriodId = $this->_getFilterValue($filters, 'leavePeriodId', null);
        $fromDate = $this->_getFilterValue($filters, 'calFromDate', null);
        $toDate = $this->_getFilterValue($filters, 'calToDate', null);
        $statuses = $this->_getFilterValue($filters, 'chkSearchFilter', array());
        
        $message = $this->getUser()->getFlash('message', '');
        $messageType = $this->getUser()->getFlash('messageType', '');

        $leaveTypeId = trim($this->_getFilterValue($filters, 'leaveTypeId'));
        $statuses = (trim($this->_getFilterValue($filters, 'status') != ""))?array($this->_getFilterValue($filters, 'status')):$statuses;

        $leavePeriod = $this->getLeavePeriodService()->getCurrentLeavePeriod();
        if(trim($leavePeriodId) != "") {
            $leavePeriod = $this->getLeavePeriodService()->readLeavePeriod($leavePeriodId);
        } else {
            $leavePeriodId = $leavePeriod->getLeavePeriodId();
        }
        $employeeService = $this->getEmployeeService();
        $empNumber = Auth::instance()->getEmployeeNumber();
        $employee = $employeeService->getEmployee($empNumber);

        $recordCount = 0;

        if ($mode == LeaveListForm::MODE_MY_LEAVE_LIST) {

            $dateRange = new DateRange($fromDate, $toDate);

            $searchParams = new ParameterObject(array(
                        'dateRange' => $dateRange,
                        'statuses' => $statuses,
                        'leavePeriod' => $leavePeriodId,
                        'employeeFilter' => $empNumber,
                        'noOfRecordsPerPage' => $noOfRecordsPerPage
                    ));

            if(!empty($leaveTypeId)) {
                $searchParams->setParameter('leaveType', $leaveTypeId);
            }

            $result = $this->getLeaveRequestService()->searchLeaveRequests($searchParams, $pageNumber, false, true);
            $list = $result['list'];
            $recordCount = $result['meta']['record_count'];

            $this->page = $page;
            $this->recordCount = $recordCount;

            if ($recordCount == 0 && $request->isMethod("post")) {
                $message = 'No Records Found';
                $messageType = 'notice';
            }

        } else {

            $mode = LeaveListForm::MODE_MY_LEAVE_DETAILED_LIST;
            $employee = $this->getLeaveRequestService()->fetchLeaveRequest($id)->getEmployee();
            $list = $this->getLeaveRequestService()->searchLeave($id);
            $this->leaveRequestId = $id;

        }

        $leaveListForm = new LeaveListForm($mode, $leavePeriod, $employee, $filters);

        $leaveListForm->setList($list);
        $this->form = $leaveListForm;
        $this->mode = $mode;
        $this->message = $message;
        $this->messageType = $messageType;
        $this->baseUrl = 'leave/viewMyLeaveList';
        $this->pagingUrl = '@my_leave_request_list';
        
        if ($mode === LeaveListForm::MODE_MY_LEAVE_LIST) {
            LeaveListConfigurationFactory::setListMode(LeaveListForm::MODE_MY_LEAVE_LIST);
            $configurationFactory = new LeaveListConfigurationFactory();

            $configurationFactory->getHeader(0)->setElementProperty(array(
                'labelGetter' => array('getLeaveDateRange'),
                'placeholderGetters' => array('id' => 'getLeaveRequestId'),
                'urlPattern' => public_path('index.php/leave/viewMyLeaveList/id/{id}'),
            ));

            $configurationFactory->getHeader(4)->setElementProperty(array(
                'labelGetter' => array('getStatus'),
                'placeholderGetters' => array('id' => 'getLeaveRequestId'),
                'urlPattern' => public_path('index.php/leave/viewMyLeaveList/id/{id}'),
            ));

            $methodName = 'searchLeaveRequests';
            $params = array($searchParams, $page, 'list');
        } elseif ($mode === LeaveListForm::MODE_MY_LEAVE_DETAILED_LIST) {
            DetailedLeaveListConfigurationFactory::setListMode(LeaveListForm::MODE_MY_LEAVE_DETAILED_LIST);
            $configurationFactory = new DetailedLeaveListConfigurationFactory();
            $methodName = 'searchLeave';
            $params = array($id);
        } else {
            // TODO: Warn
        }

        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setListData($list);

        ohrmListComponent::setPageNumber($pageNumber);
        ohrmListComponent::setItemsPerPage($noOfRecordsPerPage);
        ohrmListComponent::setNumberOfRecords($recordCount);

        $this->initilizeDataRetriever($configurationFactory, $this->getLeaveRequestService(), $methodName, $params, $employee);
    }

    private function getEmployeeListAsJson() {

        $jsonArray	=	array();
        $escapeCharSet = array(38, 39, 34, 60, 61,62, 63, 64, 58, 59, 94, 96);
        $employeeService = new EmployeeService();
        $employeeList = array();

        if (Auth::instance()->hasRole(Auth::ADMIN_ROLE)) {
            $employeeList = $employeeService->getEmployeeList();
        }

        if ($_SESSION['isSupervisor'] && trim(Auth::instance()->getEmployeeNumber()) != "") {
            $employeeList = $employeeService->getSupervisorEmployeeChain(Auth::instance()->getEmployeeNumber());
        }
        $employeeUnique = array();
        foreach($employeeList as $employee) {
            if(!isset($employeeUnique[$employee->getEmpNumber()])) {
                $name = $employee->getFirstName() . " " . $employee->getLastName();

                foreach($escapeCharSet as $char) {
                    $name = str_replace(chr($char), (chr(92) . chr($char)), $name);
                }
                $employeeUnique[$employee->getEmpNumber()] = $name;
                array_push($jsonArray,"{name:\"".$name."\",id:\"".$employee->getEmpNumber()."\"}");
            }
        }

        $jsonString = " [".implode(",",$jsonArray)."]";
        return $jsonString;
    }

    /**
     * Change leave status
     * 
     * @param sfWebRequest $request
     */
    public function executeChangeLeaveStatus(sfWebRequest $request) {

        if ($request->isMethod('post')) {

            $changes = $request->getParameter('leaveRequest');
            $changeType = 'change_leave_request';
            $leaveComments  = $request->getParameter('leaveComments');
            $changeComments = array();

            if (empty($changes)) {
                $changes = $request->getParameter('leave');
                $changeType = 'change_leave';
            }

            //this is to bypass the approval/rejection comment
            foreach($changes as $k => $v) {
                if(trim($v) != "") {
                    $changeComments[$k] = $leaveComments[$k];
                }
            }

            $changedByUserType = SystemUser::USER_TYPE_EMPLOYEE;
            
            $mode = $request->getParameter('hdnMode', null);
            
            if ($mode != LeaveListForm::MODE_MY_LEAVE_LIST && $mode != LeaveListForm::MODE_MY_LEAVE_DETAILED_LIST) {
                
                if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']=='Yes') {
                    $changedByUserType = SystemUser::USER_TYPE_ADMIN;
                }
                if ($_SESSION['isSupervisor']) {                                
                    $changedByUserType = SystemUser::USER_TYPE_SUPERVISOR;
                }
            }

            try {

                $this->getLeaveRequestService()->changeLeaveStatus($changes, $changeType, $changeComments, $changedByUserType, $_SESSION['empNumber']);
                $this->getUser()->setFlash('message', __('Leave Successfully Changed'));
                $this->getUser()->setFlash('messageType', 'success');
            } catch (Exception $e) {
                $this->getUser()->setFlash('message', $e->getMessage());
                $this->getUser()->setFlash('messageType', 'failure');
            }

        }

        if ($changedByUserType == SystemUser::USER_TYPE_EMPLOYEE) {

            $url = "leave/viewMyLeaveList";

            if(trim($request->getParameter("id")) != "") {
                $url = $url . "?id=" . $request->getParameter("id");
            }

            if(trim($request->getParameter("hdnMode")) != "") {
                $url = $url . "?hdnMode=" . $request->getParameter("hdnMode");
            }

        } else {

            $url = "leave/viewLeaveList";

            $page = $request->getParameter("currentPage");

            if(trim($request->getParameter("id")) != "") {
                $url = $url . "?id=" . $request->getParameter("id") . "&pageNo=" . $page;
            }else {
                $url = $url . "?pageNo=" . $page;
            }
        }

        $this->redirect($url);
    }

    /**
     * get Method for WorkWeekEntity
     *
     * @return WorkWeek $workWeekEntity
     */
    public function getWorkWeekEntity() {
        $this->workWeekEntity = new WorkWeek();
        return $this->workWeekEntity;
    }

    private function _setLoggedInUserDetails() {

        $this->userType = 'ESS';

        if (!empty($_SESSION['empNumber'])) {
            $this->loggedUserId = $_SESSION['empNumber'];
        } else {
            $this->loggedUserId = 0; // Means default admin
        }

        if ($_SESSION['isSupervisor']) {
            $this->userType = 'Supervisor';
        }

        if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']=='Yes') {
            $this->userType = 'Admin';
        }

    }

    public function executeUpdateComment(sfWebRequest $request) {

        $leaveRequestService = $this->getLeaveRequestService();
        $leaveRequestId = trim($request->getParameter("leaveRequestId"));
        $leaveId = trim($request->getParameter("leaveId"));
        $comment = trim($request->getParameter("leaveComment"));

        $flag = 0;
        if($leaveRequestId != "") {
            $leaveRequest = $leaveRequestService->fetchLeaveRequest($leaveRequestId);
            $leaveRequest->setLeaveComments($comment);
            $leaves = $leaveRequestService->searchLeave($leaveRequestId);
            $flag = $leaveRequestService->saveLeaveRequest($leaveRequest, $leaves);
        }

        if($leaveId != "") {
            $leave = $leaveRequestService->readLeave($leaveId);
            $leave->setLeaveComments($comment);
            $flag = $leaveRequestService->saveLeave($leave);
        }

        return $this->renderText($flag);

    }

    /**
     *
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    /**
     * Displays a warning for non admin users if Leave Period is not defined
     *
     * @param sfWebRequest $request
     */
    public function executeShowLeavePeriodNotDefinedWarning(sfWebRequest $request) {
        
    }

    public function initilizeDataRetriever(ohrmListConfigurationFactory $configurationFactory, BaseService $dataRetrievalService, $dataRetrievalMethod, array $dataRetrievalParams, $employee) {
        $dataRetriever = new ExportDataRetriever();
        $dataRetriever->setConfigurationFactory($configurationFactory);
        $dataRetriever->setDataRetrievalService($dataRetrievalService);
        $dataRetriever->setDataRetrievalMethod($dataRetrievalMethod);
        $dataRetriever->setDataRetrievalParams($dataRetrievalParams);
        
        $this->getUser()->setAttribute('persistant.exportDataRetriever', $dataRetriever);
        $this->getUser()->setAttribute('persistant.exportFileName', 'my-leave-list');
        $this->getUser()->setAttribute('persistant.exportDocumentTitle', 'Leave List');
        $this->getUser()->setAttribute('persistant.exportDocumentDescription', 'of ' . $employee->getFullName() );
    }

    /**
     *
     * @param array $filters
     * @return unknown_type
     */
    protected function _setFilters($mode, array $filters) {
        return $this->getUser()->setAttribute($mode . '.filters', $filters, 'leave_module');
    }

    /**
     *
     * @return unknown_type
     */
    protected function _getFilters($mode) {
        return $this->getUser()->getAttribute($mode . '.filters', null, 'leave_module');
    }

    protected function _getFilterValue($filters, $parameter, $default = null) {
        $value = $default;
        if (isset($filters[$parameter])) {
            $value = $filters[$parameter];
        }

        return $value;
    }

    protected function _isRequestFromLeaveSummary($request) {

        $txtEmpID = $request->getGetParameter('txtEmpID');

        if (!empty($txtEmpID)) {
            return true;
        }

        return false;

    }

}
