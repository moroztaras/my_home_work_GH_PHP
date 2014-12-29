<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $massage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $postedDate;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set massage
     *
     * @param string $massage
     * @return Post
     */
    public function setMassage($massage)
    {
        $this->massage = $massage;

        return $this;
    }

    /**
     * Get massage
     *
     * @return string 
     */
    public function getMassage()
    {
        return $this->massage;
    }

    /**
     * Set postedDate
     *
     * @param \DateTime $postedDate
     * @return Post
     */
    public function setPostedDate($postedDate)
    {
        $this->postedDate = $postedDate;

        return $this;
    }

    /**
     * Get postedDate
     *
     * @return \DateTime 
     */
    public function getPostedDate()
    {
        return $this->postedDate;
    }

    /**
     * @ORM\PrePersist
     */
    public function setPostedDateToCurrent()
    {
        $this->postedDate = new \DateTime();
    }
}
