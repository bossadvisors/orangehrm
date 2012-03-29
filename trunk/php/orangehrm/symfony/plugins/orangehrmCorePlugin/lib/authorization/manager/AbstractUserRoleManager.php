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

/**
 * AbstractUserRoleManager interface
 */
abstract class AbstractUserRoleManager {
    
    protected $user;
    protected $userRoles;
    
    public function setUser(SystemUser $user) {
        $this->user = $user;        
        $this->userRoles = $this->getUserRoles($user);
    }
    
    public function getUser() {
        return $this->user;
    }
    
    public abstract function getAccessibleEntities($entityType, $operation = null, $returnType = null, 
            $rolesToExclude = array(), $rolesToInclude = array());
    
    public abstract function getAccessibleEntityIds($entityType, $operation = null, $returnType = null,
            $rolesToExclude = array(), $rolesToInclude = array());
    
    public abstract function isEntityAccessible($entityType, $entityId, $operation = null, 
            $rolesToExclude = array(), $rolesToInclude = array());
    
    public abstract function areEntitiesAccessible($entityType, $entityIds, $operation = null, 
            $rolesToExclude = array(), $rolesToInclude = array());
    
    public abstract function getAccessibleModules();
    
    public abstract function isModuleAccessible($module);
    
    public abstract function isScreenAccessible($module, $screen, $field);
    
    public abstract function getScreenPermissions($module, $screen);
    
    public abstract function isFieldAccessible($module, $screen, $field);
    
    protected abstract function getUserRoles(SystemUser $user);    
    
}

