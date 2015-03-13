<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;

/**
 * @ORM\Table(name="task")
 * Task
 * @ORM\Entity
 */
class Task
{
    /**
    * @var integer
    *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    protected $content;

    /**
     * @var date
     *
     * @ORM\Column(name="dueDate", type="date")
     */
    protected $dueDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="done", type="boolean")
     */
    protected $done;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer")
     */
    protected $priority;

    /**
     * @var date
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="assignedTasks")
     * @ORM\JoinColumn(name="assignee_id", referencedColumnName="id", nullable=false)
     */
    protected $assignee;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="createdTasks")
     * @ORM\JoinColumn(name="createdBy_id", referencedColumnName="id", nullable=false)
     */
    protected $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="tasks")
     *
     */
    protected $category;

    public function __construct() {
      $this->createdAt = new DateTime();
    }

    public function __toString() {
      return $this->content;

    }

    /**
     * Get the value of Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of Content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of Content
     *
     * @param string content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of Due Date
     *
     * @return date
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set the value of Due Date
     *
     * @param date dueDate
     *
     * @return self
     */
    public function setDueDate(DateTime $dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get the value of Done
     *
     * @return bool
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set the value of Done
     *
     * @param bool done
     *
     * @return self
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get the value of Priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set the value of Priority
     *
     * @param integer priority
     *
     * @return self
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get the value of Created At
     *
     * @return date
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of Created At
     *
     * @param date createdAt
     *
     * @return self
     */
    public function setCreatedAt(date $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     * @return Task
     */
    public function setCreatedBy(\AppBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set assignee
     *
     * @param \AppBundle\Entity\User $assignee
     * @return Task
     */
    public function setAssignee(\AppBundle\Entity\User $assignee = null)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * Get assignee
     *
     * @return \AppBundle\Entity\User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Task
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
