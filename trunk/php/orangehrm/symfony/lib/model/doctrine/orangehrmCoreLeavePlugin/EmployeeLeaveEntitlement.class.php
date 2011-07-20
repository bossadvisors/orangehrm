<?php

/**
 * EmployeeLeaveEntitlement
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class EmployeeLeaveEntitlement extends PluginEmployeeLeaveEntitlement {

    private static $leaveRequestDao;
    private $leaveScheduled;
    private $leaveTaken;

    public function __construct($table = null, $isNewEntry = false) {
        parent::__construct($table, $isNewEntry);
        self::init();
    }

    public function getLeaveScheduled() {
        if (!isset($this->leaveScheduled)) {
            $this->leaveScheduled = self::$leaveRequestDao->getScheduledLeavesSum($this->getEmployeeId(), $this->getLeaveTypeId(), $this->getLeavePeriodId());
            $this->leaveScheduled = empty($this->leaveScheduled) ? '0.00' : number_format($this->leaveScheduled, 2);
        }
        return $this->leaveScheduled;
    }

    public function getLeaveTaken() {
        if (!isset($this->leaveTaken)) {
            $this->leaveTaken = self::$leaveRequestDao->getTakenLeaveSum($this->getEmployeeId(), $this->getLeaveTypeId(), $this->getLeavePeriodId());
            $this->leaveTaken = empty($this->leaveTaken) ? '0.00' : number_format($this->leaveTaken, 2);
        }
        return $this->leaveTaken;
    }

    public function  setLeaveTakenForSummary($x) {
        $this->leaveTaken = $x;
    }

    public function isThereLeaveScheduled() {
        if (!isset($this->leaveScheduled)) {
            $this->leaveScheduled = self::$leaveRequestDao->getScheduledLeavesSum($this->getEmployeeId(), $this->getLeaveTypeId(), $this->getLeavePeriodId());
            
            if (empty($this->leaveScheduled)) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function isThereLeaveTaken() {
        if (!isset($this->leaveTaken)) {
            $this->leaveTaken = self::$leaveRequestDao->getTakenLeaveSum($this->getEmployeeId(), $this->getLeaveTypeId(), $this->getLeavePeriodId());
            
            if (empty($this->leaveTaken)) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function getLeaveBalance() {
        $leaveEntitled = (float) $this->getNoOfDaysAllotted();
        $leaveBroughtForward = (float) $this->getLeaveBroughtForward();
        $leaveTaken = (float) $this->getLeaveTaken();
        $leaveScheduled = (float) $this->getLeaveScheduled();
        $leaveCarryForward = (float) $this->getLeaveCarriedForward();

        $leaveRemaining = ($leaveEntitled + $leaveBroughtForward) - ($leaveTaken + $leaveScheduled + $leaveCarryForward);
        $leaveRemaining = number_format($leaveRemaining, 2);
        
        return $leaveRemaining;
    }
    
    /**
     *
     * @param type $supervisorId
     * @param type $userType
     * @return bool
     * @todo Move this logic to service classes
     */
    public function isEmployeeDetailsAccessibleTo($supervisorId, $userType) {
        if ($userType == Users::USER_TYPE_ADMIN) {
            return true;
        } elseif ($userType == Users::USER_TYPE_SUPERVISOR) {
            return $this->getEmployee()->isSubordinateOf($supervisorId);
        } else {
            return false;
        }
    }

    protected static function init() {
        if (!(self::$leaveRequestDao instanceof LeaveRequestDao)) {
            self::$leaveRequestDao = new LeaveRequestDao();
        }
    }

}
