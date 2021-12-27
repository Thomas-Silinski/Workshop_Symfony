<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var int
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Posts", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     *
     * @var int
     */
    protected $posts;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @var string
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    protected $creationDate;

    /**
     * @ORM\OneToMany(targetEntity="Likes", mappedBy="comments", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $likes;

    public function getId()
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPosts()
    {
        return $this->posts;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getLikes()
    {
        return $this->likes;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function setPosts($posts)
    {
        $this->posts = $posts;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function setLikes($likes)
    {
        $this->likes = $likes;
        return $this;
    }

    public function __construct()
    {
        $this->creationDate = new \DateTime('now');
    }
}