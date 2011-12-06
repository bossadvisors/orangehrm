<?php

/**
 * JobVacancy
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class JobVacancy extends PluginJobVacancy {
    const ACTIVE = 1;
    const CLOSED = 2;
    const PUBLISHED = 1;
    const NOT_PUBLISHED = 0;
    const NUMBER_OF_RECORDS_PER_PAGE = 50;
    const TYPE = "VACANCY";

    public function getHiringManagerName() {
        $employee = $this->getEmployee();
        $firstAndLastName = $employee->getFirstAndLastNames();
        $terminationId = $employee->getTerminationId();
        $name = (!empty($terminationId)) ? $firstAndLastName." (Past Employee)" : $firstAndLastName;
        $hmName = ($this->getHiringManagerId() != "") ? $name : "";
        return $hmName;
    }

    public function getHiringManagerFullName() {
        $employee = $this->getEmployee();
        $firstAndLastName = $employee->getFirstAndLastNames();
        $terminationId = $employee->getTerminationId();
        $name = (!empty($terminationId)) ? $firstAndLastName." (Past Employee)" : $firstAndLastName;
        $hmName = ($this->getHiringManagerId() != "") ? $name : "";
        return $hmName;
    }

    public function getStateLabel() {
        $stateName = "";
        if ($this->status == JobVacancy::ACTIVE) {
            $stateName = __("Active");
        } elseif ($this->status == JobVacancy::CLOSED) {
            $stateName = __("Closed");
        }
        return $stateName;
    }

    public function getVacancyName() {
        return (($this->status == JobVacancy::CLOSED) ? $this->getName() . " (Closed)" : $this->getName());
    }

    public function getJobTitleName(){
        return $this->getJobTitle()->getJobTitleName();
    }

}
