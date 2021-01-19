<?php
namespace AppBundle\Manager;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use FOS\UserBundle\Model\UserManager as FOSUserManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;
use Symfony\Component\VarDumper\VarDumper;

class UserManager
{
    /**
     * Doctrine entity manager
     * @var EntityManager
     */
    protected $em;

    /**
     * FOSUserBundle user manager
     * @var FOSUserManager
     */
    protected $um;

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

    public function __construct(EntityManager $em, FOSUserManager $um, RequestStack $rs, $class)
    {
        $this->em = $em;
        $this->um = $um;
        $this->class = $class;
        $this->repo = $em->getRepository($class);
        $this->rs = $rs;
    }

    public function createUser()
    {
        $user = $this->um->createUser();

        return $user;
    }

    public function save($user)
    {
        $this->em->persist($user);
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

    public function remove($user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }
}
