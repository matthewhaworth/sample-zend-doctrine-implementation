<?php
/**
 * Zend validation class to check if a value already exists with doctrine
 * 
 * @author Matthew Haworth
 */
class Zedo_Validate_IsUnique extends Zend_Validate_Abstract
{
    /**
     * Doctrine Entity Manager
     * 
     * @var \Doctrine\ORM\EntityManager 
     */
    protected $_em; 
    
    /** 
     * Entity to check for unique record
     * 
     * @var string
     */
    protected $_entityName;
    
    /**
     * Field to check for unique record
     * 
     * @var string
     */
    protected $_fieldName;
    
    const RECORD_EXISTS = 'recordExists';
    
    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::RECORD_EXISTS  => "%field% already exists.",
    );

    /**
     * @var array
     */
    protected $_messageVariables = array(
        'field' => '_fieldName',
    );
    
    /**
     * @param string $entityName
     * @param string $fieldName 
     */    
    public function __construct($entityName, $fieldName)
    {
        $this->_em = Zedo_Core::getEntityManager();
        $this->_entityName = $entityName;
        $this->_fieldName = $fieldName;
        
        $metaData = $this->_em->getMetadataFactory()->getMetadataFor($entityName);
        
        if (!is_string($this->_fieldName)) {
            throw new Zend_Validate_Exception('Field must be a string');
        }
        
        try {
            $metaData->getFieldMapping($this->_fieldName);
        } catch (Exception $e) {
            throw new Zend_Validate_Exception("Field {$fieldName} does not exist");
        }
    }
    
    public function isValid($value) 
    {
        if (!is_string($value)) {
            throw new Zend_Validate_Exception('Parameter field must be a string');
        }
        
        $this->_setValue($value);
        
        $match = $this->_em
            ->getRepository($this->_entityName)
            ->findOneBy(array($this->_fieldName => $value));
        
        if($match && $match->getId()) {
            $this->_error(self::RECORD_EXISTS);
            return false;
        }
        
        return true;
    }
}