<?php
/**
 * @Entity(repositoryClass="Application_Model_Repositories_UserRepository") @Table(name="user") 
 */
class Application_Model_Entities_User
{
    /** @Id @Column(type="integer") @GeneratedValue */
    protected $id;

    /** @Column(type="string") */
    protected $username;
    
    /** @Column(type="string") */
    protected $password;
    
    /**
     * @OneToMany(targetEntity="Application_Model_Entities_Article", mappedBy="user")
     */
    protected $articles;
    
    public function getId() {
        
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function getArticles() {
        return $this->articles;
    }
    
    public function addArticle($article)
    {
        $this->articles[] = $article;
        $article->setUser($this);
    }
}