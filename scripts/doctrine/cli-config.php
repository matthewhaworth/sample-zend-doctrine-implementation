<?php
// cli-config.php
require_once 'classpath_loader.php';

$application = new Zend_Application(
    'development',
    APPLICATION_PATH . '/configs/application.ini'
);

$entityManager = $application
    ->bootstrap('doctrine2')
    ->getBootstrap()
    ->getPluginResource('doctrine2')
    ->init();

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager)
));
