<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures 
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2010 OrangeHRM Inc., http://www.orangehrm.com
 *
 * Please refer the file license/LICENSE.TXT for the license which includes terms and conditions on using this software.
 *
 * */

/**
 * Description of KpiDao
 *
 * @author samantha
 */
class KpiDao extends BaseDao {

    /**
     *
     * @param sfDoctrineRecord $kpi
     * @return \sfDoctrineRecord
     * @throws DaoException 
     */
    public function saveKpi(sfDoctrineRecord $kpi) {
        try {

            if ($kpi->getDefaultKpi() > 0) {
                $query = Doctrine_Query :: create()
                        ->update('Kpi k')
                        ->set('default_kpi', 'null');
                $query->execute();
            }

            $kpi->save();
            $kpi->refresh();
            return $kpi;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     *
     * @param array $parameters
     * @return Doctrine_Collection
     * @throws DaoException 
     */
    public function searchKpi($parameters = null) {
        try {
            $query = Doctrine_Query:: create()->from('Kpi');

            if (!empty($parameters)) {
                if (isset($parameters['id']) && $parameters['id'] > 0) {
                    $query->andWhere('id = ?', $parameters['id']);
                    return $query->fetchOne();
                } else {
                    foreach ($parameters as $key => $parameter) {
                        if (strlen(trim($parameter)) > 0) {
                            switch ($key) {
                                case 'jobCode':
                                    $query->andWhere('jobTitleCode = ?', $parameter);
                                    break;
                                case 'department':
                                    $query->andWhere('department_code = ?', $parameter);
                                    break;
                                case 'isDefault':
                                    $query->andWhere('default_kpi = ?', $parameter);
                                    break;
                                default:
                                    break;
                            }
                        }
                    }
                }
            }
            $query->orderBy('kpi_indicators');
            return $query->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     *
     * @param array $ids
     * @throws DaoException 
     */
    public function deleteKpi($ids) {
        try {
            if (sizeof($ids)) {
                $q = Doctrine_Query::create()
                        ->delete('Kpi')
                        ->whereIn('id', $ids);
                $q->execute();
            }
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Search KPI by Jobtitle and Department
     *
     * @param array $parameters
     * @return Doctrine_Collection
     * @throws DaoException 
     */
    public function searchKpiByJobtitleAndDepartment($parameters = null) {
        try {

            $query = Doctrine_Query:: create()->from('Kpi');
            $query->where('((jobTitleCode = ? OR department_code = ?) AND (deleted_at IS NULL))', array($parameters['jobCode'], $parameters['department']));

            $query->orderBy('kpi_indicators');
            return $query->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
    }

}