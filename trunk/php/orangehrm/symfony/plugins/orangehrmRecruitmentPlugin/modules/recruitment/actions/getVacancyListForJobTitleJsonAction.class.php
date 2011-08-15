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
class getVacancyListForJobTitleJsonAction extends sfAction {

    /**
     *
     * @param <type> $request
     * @return <type>
     */
    public function execute($request) {

        $allowedVacancyList = $this->getUser()->getAttribute('user')->getAllowedVacancyList();

        $this->setLayout(false);
        sfConfig::set('sf_web_debug', false);
        sfConfig::set('sf_debug', false);

        $vacancyList = array();

        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->getResponse()->setHttpHeader('Content-Type', 'application/json; charset=utf-8');
        }

        $jobTitle = $request->getParameter('jobTitle');

        $vacancyService = new VacancyService();
        $vacancyList = $vacancyService->getVacancyListForJobTitle($jobTitle, $allowedVacancyList, true);
	$newVacancyList = array();
        foreach ($vacancyList as $vacancy) {
            if ($vacancy['status'] == JobVacancy::CLOSED) {
                $vacancy['name'] = $vacancy['name'] . " (Closed)";
            }
            $newVacancyList[] = $vacancy;
        }     
        return $this->renderText(json_encode($newVacancyList));
    }

}

