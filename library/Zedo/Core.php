<?php
/**
 * Zedo_Core
 * 
 * This class is used to define common functionality
 */
class Zedo_Core {
    /**
     * Loads doctrine entity for specified entity name
     * 
     * @param string $entityName 
     * @return mixed Model or false
     */
    public static function getEntity($entityName) 
    {        
        return self::_getModel($entityName, '_Entities');
    }
    
    /**
     * Loads doctrine entity as singleton object
     * 
     * @param string $entityName 
     * @return mixed Model or false
     */
    public static function getEntitySingleton($entityName)
    {       
        $registryKey = "singleton_entity[{$entityName}]";
        $registry = self::_getRegistry();
        if (!$registry->isRegistered($registryKey)) {
            $registry->set($registryKey, self::getEntity($entityName));
        }
        return $registry->get($registryKey);
    }
    
    /**
     * Loads model
     * 
     * @param string $modelName 
     * @return mixed Model or false
     */
    public static function getModel($modelName)
    {        
        return self::_getModel($modelName);
    }
    
    /**
     * Loads model singleton
     * 
     * @param string $modelName 
     * @return mixed Model or false
     */
    public static function getModelSingleton($modelName)
    {       
        $registryKey = "singleton[{$modelName}]";
        $registry = self::_getRegistry();
        if (!$registry->isRegistered($registryKey)) {
            $registry->set($registryKey, self::getModel($modelName));
        }
        return $registry->get($registryKey);
    }
    
    /**
     * Loads already instantiated class, or instantiates one if it does not already exist
     * 
     * @param $entityName
     */

    /**
     * Loads doctrine repository for specified model name
     * 
     * @param string $repositoryName 
     * @return EntityRepository
     */
    public static function getRepository($entityName) 
    {
        $classPathParts = explode('/', $entityName);

        $className = "";
        foreach($classPathParts as $_part) {
            $_part = ucwords($_part);
            $className .= "_{$_part}";
        }
        
        $classPrefix = 'Application_Model_Entities';
        $class = $classPrefix . $className;

        if (!class_exists($class)) {
            return false;
        }
        return Zedo_Core::getEntityManager()->getRepository($class);
    }
    
    /**
     * Gets the Doctrine Entity Manager from the registry
     * 
     * @todo Consider moving the entity manager out of the registry
     * @return \Doctrine\ORM\EntityManager
     */
    public static function getEntityManager()
    {
        if (!$entityManager = Zend_Registry::get('doctrine_em')) {
            return false;
        }
        
        return $entityManager;
    }
    
    public static function _getModel($modelName, $postFix = '') {
        $modelClass = trim($modelName);
        $classPathParts = explode('/', $modelClass);

        $className = "";
        foreach($classPathParts as $_part) {
            $_part = ucwords($_part);
            $className .= "_{$_part}";
        }
        
        $classPrefix = 'Application_Model' . $postFix;
        $class = $classPrefix . $className;
        
        if (!class_exists($class)) {
            return false;
        }
        
        return new $class;
    }
    
    protected function _getRegistry() {
        return Zend_Registry::getInstance();
    }
}   