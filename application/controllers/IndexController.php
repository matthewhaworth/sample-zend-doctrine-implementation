<?php
class IndexController extends Zend_Controller_Action
{
    public function searchAction()
    {
        $repo = $this->_getEntityManager()->getRepository('Application_Model_Entities_User');
        /* @var $repo Application_Model_Repositories_UserRepository */
        $name = $this->getRequest()->getParam('username');
        $userList = $repo->findBy(array('username' => $name));
        
        $this->view->users = $userList;
    }
    
    public function addArticleToUserAction()
    {
        $userId = $this->getRequest()->getParam('user_id');
        $user = $this->_getEntityManager()->find('Application_Model_Entities_User', $userId);
        
        $article = new Application_Model_Entities_Article;
        $article->setHeadline('test');
        $article->setContent('testsss');
        
        $user->addArticle($article);
        
        $this->_getEntityManager()->persist($article);
        $this->_getEntityManager()->flush();
        
    }
    
    public function testAction()
    {
        $user = $this->_getEntityManager()->find('Application_Model_Entities_User', 7);
        
        
        $articles = $user->getArticles();
        foreach ($articles as $_article) {
            echo $_article->getHeadline()  . '<br />';
            echo $_article->getContent() . '<br />';
        }
        
        die;
    }
    
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function _getEntityManager()
    {
        return Zend_Registry::get('doctrine_em');
    }

    protected function _getUserRepository()
    {
        return $this->_getEntityManager()->getRepository('Application_Model_Entities_User');
    }
    
    public function createUserAction()
    {
        $user = $this->_getUserRepository()->createUser(
            $this->getRequest()->getParam('username'),
            $this->getRequest()->getParam('password')
        );
       
       $this->view->username = $user->getUsername();
       
       // can't be arsed creating view lolz
       die;
    }
    
    public function deleteTestUserAction()
    {
        $userId = $this->getRequest()->getParam('user_id'); 
       
        try {
            $user = 
                $this->_getEntityManager()->find('Application_Model_Entities_User', $userId);
            $this->_getEntityManager()->remove($user);
            $this->_getEntityManager()->flush();
            $this->view->response = "User deleted";
        } catch (Exception $e) {
            $this->view->response = "User doesn't exist";
        }
    }
}