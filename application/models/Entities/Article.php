<?php
/**
 * @Entity @Table(name="article") 
 */
class Application_Model_Entities_Article
{
    /** @Id @Column(type="integer") @GeneratedValue */
    protected $id;

    /** @Column(type="string") */
    protected $headline;
    
    /** @Column(type="string") */
    protected $content;
    
    /**
     * @ManyToOne(targetEntity="Application_Model_Entities_User", inversedBy="articles")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    public function getId() {
        
        return $this->id;
    }

    public function getHeadline() {
        return $this->headline;
    }

    public function setHeadline($headline) {
        $this->headline = $headline;
        
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }
    
    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }


}