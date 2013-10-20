<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctrine2()
    {
        if ($entityManager = $this->getPluginResource('doctrine2')->init()) {
            Zend_Registry::set('doctrine_em', $entityManager);
        }
    }
}