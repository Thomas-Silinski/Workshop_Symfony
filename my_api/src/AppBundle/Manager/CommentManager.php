<?php
namespace AppBundle\Manager;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use FOS\UserBundle\Model\PostManager as FOSUserManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Comment;
use Symfony\Component\VarDumper\VarDumper;

class CommentManager
{
    /**
     * Doctrine entity manager
     * @var EntityManager
     */
    protected $em;

    /**
     * The request stack
     * @var RequestStack
     */
    protected $rs;

    /**
     * Entity-specific repository
     * @var EntityRepository
     */
    protected $repo;

    /**
     * Fully-Qualified class name
     * @var string
     */
    protected $class;

    public function __construct(EntityManager $em, RequestStack $rs, $class)
    {
        $this->em = $em;
        $this->class = $class;
        $this->repo = $em->getRepository($class);
        $this->rs = $rs;
    }

    public function createComment()
    {
        $comment = new $this->class();

        return $comment;
    }

    public function save($id)
    {
        $this->em->persist($id);
        $this->em->flush();
    }

    public function findAll()
    {
        return $this->repo->findAll();
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function remove($id)
    {
        $this->em->remove($id);
        $this->em->flush();
    }
}