<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Type\PlaceType;
use AppBundle\Entity\Place;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\User;
use AppBundle\Manager\UserManager;
use AppBundle\Form\RegistrationFormType;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use Symfony\Component\VarDumper\VarDumper;

class DefaultController extends FOSRestController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/hello-world", name="hello-world")
     */
    public function tuto()
    {
        return $this->render('tuto/hello.html.twig', [
            'tuto_name' => 'DefaultController'
        ]);
    }

    /**
     * @Get("/user")
     */
    public function getUserAction()
    {
        $UserManager = $this->get('my_api.manager.user');
        $data = $UserManager->findAll();

        $view = $this->view(array("status" => 200, "message" => "OK", "body" => $data), 200);
        return $this->handleView($view);
    }

    /**
     * @Get("/user/my")
     */
    public function getMySingleUserAction()
    {
        $UserManager = $this->get('my_api.manager.user');
        $id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $data = $UserManager->find($id);

        $view = $this->view(array("status" => 200, "message" => "OK", "body" => $data), 200);
        return $this->handleView($view);
    }

    /**
     * @Get("/user/{id}")
     */
    public function getSingleUserAction($id)
    {
        $UserManager = $this->get('my_api.manager.user');
        $data = $UserManager->find($id);

        $view = $this->view(array("status" => 200, "message" => "OK", "body" => $data), 200);
        return $this->handleView($view);
    }

    /**
     * @Patch("/user/my")
     */
    public function patchMyUserAction()
    {
        $formFactory = $this->get('my_api.registration.form.factory');
        $UserManager = $this->get('my_api.manager.user');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $data = json_decode($request->getContent(), true);

        $user = $UserManager->find($id);

        if (!$user) {
            $view = $this->view(array("status" => 404, "message" => "User not found", "body" => null), 200);
            return $this->handleView($view);
        }

        if (null !== $data) {
            $request->request->replace($data);
        }
        $form = $formFactory->createForm(array('method' => 'PATCH'));
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $UserManager->save($user);

            $view = $this->view(array("status" => 200, "message" => "OK", "body" => $user), 200);
            return $this->handleView($view);
        }
        $view = $this->view(array("status" => 404, "message" => "Contenu introuvable", "body" => $serializer->serialize($form, 'json')), 200);
        return $this->handleView($view);
    }

    /**
     * @Post("/register")
     */
    public function postRegisterAction()
    {
        $formFactory = $this->get('my_api.registration.form.factory');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $data = json_decode($request->getContent(), true);
        $UserManager = $this->get('my_api.manager.user');
        $user = $UserManager->createUser();

        if (null !== $data) {
            $request->request->replace($data);
        }
        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $user->setEnabled(1);
            $UserManager->save($user);

            $view = $this->view(array("status" => 201, "message" => "OK", "body" => $user), 200);
            return $this->handleView($view);
        }
        $view = $this->view(array("status" => 404, "message" => "Contenu introuvable", "body" => $serializer->serialize($form, 'json')), 200);
        return $this->handleView($view);
    }

    /**
     * @Patch("/user/{id}")
     */
    public function patchUserAction($id)
    {
        $formFactory = $this->get('my_api.registration.form.factory');
        $UserManager = $this->get('my_api.manager.user');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $data = json_decode($request->getContent(), true);

        $user = $UserManager->find($id);

        if (!$user) {
            $view = $this->view(array("status" => 404, "message" => "User not found", "body" => null), 200);
            return $this->handleView($view);
        }

        if (null !== $data) {
            $request->request->replace($data);
        }
        $form = $formFactory->createForm(array('method' => 'PATCH'));
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $UserManager->save($user);

            $view = $this->view(array("status" => 200, "message" => "OK", "body" => $user), 200);
            return $this->handleView($view);
        }
        $view = $this->view(array("status" => 404, "message" => "Contenu introuvable", "body" => $serializer->serialize($form, 'json')), 200);
        return $this->handleView($view);
    }

    /**
     * @Delete("/user/{id}")
     */
    public function deleteUserAction($id)
    {
        $formFactory = $this->get('my_api.registration.form.factory');
        $UserManager = $this->get('my_api.manager.user');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $data = json_decode($request->getContent(), true);

        $user = $UserManager->find($id);

        if (!$user) {
            $view = $this->view(array("status" => 404, "message" => "User not found", "body" => null), 200);
            return $this->handleView($view);
        }

        $UserManager->remove($user);

        $view = $this->view(array("status" => 204, "message" => "Deleted", "body" => $user), 200);
        return $this->handleView($view);
    }
}
