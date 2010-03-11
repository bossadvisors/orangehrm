<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCompanyGeninfo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_geninfo');
        $this->hasColumn('code', 'string', 13, array(
             'type' => 'string',
             'primary' => true,
             'length' => '13',
             ));
        $this->hasColumn('geninfo_keys', 'string', 200, array(
             'type' => 'string',
             'length' => '200',
             ));
        $this->hasColumn('geninfo_values', 'string', 800, array(
             'type' => 'string',
             'length' => '800',
             ));
    }

}