<?php

 namespace AppBundle\Entity;

 use Doctrine\ORM\Mapping as ORM;

 /**
  * User
  *
  * @ORM\Table()
  * @ORM\Entity
  */
 class User {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var text
     * 
     * @ORM\Column(name="email", type="string")
     */
    protected $email;

    /**
     * @var password
     * 
     * @ORM\Column(name="password", type="string")
     */
    protected $password;
    
    /**
     * @var name
     * 
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    
    /**
     * @var createdAt
     * 
     * @ORM\Column(name="createdAt", type="datetime")
     */
    protected $createdAt;


    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="createdBy")
     */
    protected $assignedTasks;

    
    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="createdBy")
     */
    protected $createdCategories;
    
    public function __construct() {
       $this->createdAt = new DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
       return $this->id;
    }
    
 
    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
