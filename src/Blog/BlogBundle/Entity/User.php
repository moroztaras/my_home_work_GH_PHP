<?php

namespace Blog\BlogBundle\Entity;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(groups={"registration", "login"})
     * @Assert\Regex("/^[a-zA-Z0-9]{4,25}$/", groups={"registration", "login"})
     */
    private $login;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Regex("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", groups={"registration"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $pass;

    /**
     * @Assert\Regex("/^[a-zA-Z0-9]{4,30}$/", groups={"registration", "login"})
     * @Assert\NotBlank(groups={"registration", "login"})
     */
    private $openPass;

    /**
     * @ORM\ManyToMany(targetEntity="Post")
     * @ORM\JoinTable(name="user_post",
     *  joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id", unique=true)})
     * @ORM\OrderBy({"postedDate" = "DESC"})
     */
    private $posts;

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
     * Set login
     *
     * @param string $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
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
     * Set pass
     *
     * @param string $pass
     * @return User
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string 
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set openPass
     *
     * @param string $openPass
     * @return User
     */
    public function setOpenPass($openPass)
    {
        $this->openPass = $openPass;
        $this->setPass(md5($openPass));

        return $this;
    }

    /**
     * Get openPass
     *
     * @return string 
     */
    public function getOpenPass()
    {
        return $this->openPass;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add posts
     *
     * @param \Blog\BlogBundle\Entity\Post $posts
     * @return User
     */
    public function addPost(\Blog\BlogBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Blog\BlogBundle\Entity\Post $posts
     */
    public function removePost(\Blog\BlogBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    public function getPostById($id)
    {
        $res = $this->getPosts()->filter(function($post) use($id){return $post->getId() == $id;})->getValues();
        return count($res) == 1 ? $res[0] : null;
    }

    /**
     * Set posts
     *
     * @param string $posts
     * @return User
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;

        return $this;
    }
}
