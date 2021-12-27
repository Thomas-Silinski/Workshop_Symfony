<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="post")
 */
class Posts
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
     * @var int
     */
    protected $user;

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
     * @var string
     *
     * @ORM\Column(name="edition_date", type="datetime")
     */
    protected $editionDate;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="posts", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $comments;

    /**
     * @ORM\OneToMany(targetEntity="Likes", mappedBy="posts", cascade={"persist", "remove"}, orphanRemoval=true)
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

    public function getContent()
    {
        return $this->content;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getEditionDate()
    {
        return $this->editionDate;
    }

    public function getComments()
    {
        return $this->comments;
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

    public function setEditionDate($editionDate)
    {
        $this->editionDate = $editionDate;
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
        $this->editionDate = new \DateTime('now');
    }

    public function addComments(Comment $comment)
    {
        $this->comments[] = $comment;
        return $this;
    }
}