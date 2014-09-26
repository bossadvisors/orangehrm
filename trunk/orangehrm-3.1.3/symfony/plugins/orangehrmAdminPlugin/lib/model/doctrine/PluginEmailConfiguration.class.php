<?php

/**
 * PluginEmailConfiguration class file
 */

/**
 * PluginEmailConfiguration
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    orangehrm
 * @subpackage model\admin\plugin
 */
abstract class PluginEmailConfiguration extends BaseEmailConfiguration
{
    public function setUp() {
        parent::setup();
        if (KeyHandler::keyExists()) {
            $key = KeyHandler::readKey();
            $this->addListener(new EncryptionListener('smtpPassword', $key));
        }
    }
    
}