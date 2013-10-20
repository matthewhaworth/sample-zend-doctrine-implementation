<?php
class EventController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $em = Zend_Registry::get('doctrine_em');
	$repository = $em->getRepository('Application_Model_Entities_Event');
	$events = $repository->findBy(array(), array('date'=>'ASC'));
	$this->view->events = $events;
    }
}
