<?php
use Doctrine\ORM\EntityRepository;

class Application_Model_Repositories_UserRepository extends EntityRepository
{
    public function findAllUsersWithName($name)
    {
        return $this->findByName($name);
    }
    
    public function createUser($username, $password) {
        $user = new Application_Model_Entities_User;
        $user->setUsername($username);
        $user->setPassword($password);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush(); 
        
        return $user;
    }
    
    public function test()
    {
        
    }
}