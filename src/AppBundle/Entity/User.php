<?php

 namespace AppBundle\Entity;

 use Doctrine\Common\Collections\ArrayCollection;
 use Doctrine\ORM\Mapping as ORM;
 use \DateTime;
 use Symfony\Component\Security\Core\Role\Role;
 use Symfony\Component\Security\Core\User\UserInterface;

 /**
  * User
  *
  * @ORM\Table()
  * @ORM\Entity
  */
 class User implements UserInterface {

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
    protected $createdTasks;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="assignee")
     */
    protected $assignedTasks;


    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="createdBy")
     */
    protected $createdCategories;

    public function __construct() {
       $this->createdAt = new DateTime();
        $this->createdTasks = new ArrayCollection();
    }

     /**
      * @return name
      */
    public function __toString() {
      return $this->name;
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

    /**
     * Add createdTasks
     *
     * @param \AppBundle\Entity\Task $createdTasks
     * @return User
     */
    public function addCreatedTask(\AppBundle\Entity\Task $createdTasks)
    {
        $this->createdTasks[] = $createdTasks;
    }
    /**
     * Add createdCategories
     *
     * @param \AppBundle\Entity\Category $createdCategories
     * @return User
     */
    public function addCreatedCategory(\AppBundle\Entity\Category $createdCategories)
    {
        $this->createdCategories[] = $createdCategories;

        return $this;
    }

    /**
     * Remove createdTasks
     *
     * @param \AppBundle\Entity\Task $createdTasks
     */

    public function removeCreatedTask(\AppBundle\Entity\Task $createdTasks)
    {
        $this->createdTasks->removeElement($createdTasks);
    }

    /**
     * Get createdTasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCreatedTasks()
    {
        return $this->createdTasks;
      }
      /**
     * Remove createdCategories
     *
     * @param \AppBundle\Entity\Category $createdCategories
     */
    public function removeCreatedCategory(\AppBundle\Entity\Category $createdCategories)
    {
        $this->createdCategories->removeElement($createdCategories);
    }

    /**
     * Get createdCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCreatedCategories()
    {
        return $this->createdCategories;
    }

    /**
     * Add assignedTasks
     *
     * @param \AppBundle\Entity\Task $assignedTasks
     * @return User
     */
    public function addAssignedTask(\AppBundle\Entity\Task $assignedTasks)
    {
        $this->assignedTasks[] = $assignedTasks;

        return $this;
    }

    /**
     * Remove assignedTasks
     *
     * @param \AppBundle\Entity\Task $assignedTasks
     */
    public function removeAssignedTask(\AppBundle\Entity\Task $assignedTasks)
    {
        $this->assignedTasks->removeElement($assignedTasks);
    }

    /**
     * Get assignedTasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssignedTasks()
    {
        return $this->assignedTasks;
    }

     /**
      * Returns the roles granted to the user.
      *
      * <code>
      * public function getRoles()
      * {
      *     return array('ROLE_USER');
      * }
      * </code>
      *
      * Alternatively, the roles might be stored on a ``roles`` property,
      * and populated in any number of different ways when the user object
      * is created.
      *
      * @return Role[] The user roles
      */
     public function getRoles()
     {
         return ['ROLE_ADMIN'];
     }

     /**
      * Returns the salt that was originally used to encode the password.
      *
      * This can return null if the password was not encoded using a salt.
      *
      * @return string|null The salt
      */
     public function getSalt()
     {
         return null;
     }

     /**
      * Returns the username used to authenticate the user.
      *
      * @return string The username
      */
     public function getUsername()
     {
         return $this->getName();
     }

     /**
      * Removes sensitive data from the user.
      *
      * This is important if, at any given point, sensitive information like
      * the plain-text password is stored on this object.
      */
     public function eraseCredentials()
     {
         // TODO: Implement eraseCredentials() method.
     }
 }
