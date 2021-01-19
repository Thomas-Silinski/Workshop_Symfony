<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="likes")
 */
class Likes
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
     * @ORM\ManyToOne(targetEntity="Comment")
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="id")
     * @var int
     */
    protected $comments;

     /**
     * @ORM\ManyToOne(targetEntity="Posts")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * @var int
     */
    protected $posts;

    public function getId()
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function getPosts()
    {
        return $this->posts;
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

    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    public function setPosts($posts)
    {
        $this->posts = $posts;
        return $this;
    }
}