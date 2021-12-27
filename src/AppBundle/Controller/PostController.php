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
use AppBundle\Entity\Posts;
use AppBundle\Manager\PostManager;
use AppBundle\Manager\UserManager;
use AppBundle\Form\PostsFormType;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;

class PostController extends FOSRestController
{
    /**
     * @Get("/post")
     */
    public function getAllPostAction()
    {
        $PostManager = $this->get('my_api.manager.posts');
        $data = $PostManager->findAll();

        $view = $this->view(array("status" => 200, "message" => "OK", "body" => $data), 200);
        return $this->handleView($view);
    }

    /**
     * @Get("/post/{id}")
     */
    public function getPostAction($id)
    {
        $PostManager = $this->get('my_api.manager.posts');
        $data = $PostManager->find($id);

        $view = $this->view(array("status" => 200, "message" => "OK", "body" => $data), 200);
        return $this->handleView($view);
    }

    /**
     * @Post("/post")
     */
    public function postPostsAction()
    {
        $formFactory = $this->get('my_api.posts.form.factory');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $data = json_decode($request->getContent(), true);
        $PostManager = $this->get('my_api.manager.posts');
        $post = $PostManager->createPost();

        if (null !== $data) {
            $request->request->replace($data);
        }
        $form = $formFactory->createForm();
        $form->setData($post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $PostManager->save($post);

            $view = $this->view(array("status" => 201, "message" => "OK", "body" => $post), 200);
            return $this->handleView($view);
        }
        $view = $this->view(array("status" => 500, "message" => "Requête invalide", "body" => $serializer->serialize($form, 'json')), 200);
        return $this->handleView($view);
    }

    /**
     * @Patch("/post/{id}")
     */
    public function patchPostsAction($id)
    {
        $formFactory = $this->get('my_api.posts.form.factory');
        $PostManager = $this->get('my_api.manager.posts');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $data = json_decode($request->getContent(), true);

        $post = $PostManager->find($id);

        if (!$post) {
            $view = $this->view(array("status" => 404, "message" => "Post not found", "body" => null), 200);
            return $this->handleView($view);
        }

        if (null !== $data) {
            $request->request->replace($data);
        }
        $form = $formFactory->createForm(array('method' => 'PATCH'));
        $form->setData($post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $PostManager->save($post);

            $view = $this->view(array("status" => 200, "message" => "OK", "body" => $post), 200);
            return $this->handleView($view);
        }
        $view = $this->view(array("status" => 404, "message" => "Contenu introuvable", "body" => $serializer->serialize($form, 'json')), 200);
        return $this->handleView($view);
    }

    /**
     * @Delete("/post/{id}")
     */
    public function deletePostsAction($id)
    {
        $formFactory = $this->get('my_api.posts.form.factory');
        $PostManager = $this->get('my_api.manager.posts');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $data = json_decode($request->getContent(), true);

        $post = $PostManager->find($id);

        if (!$post) {
            $view = $this->view(array("status" => 404, "message" => "Post not found", "body" => null), 200);
            return $this->handleView($view);
        }

        $PostManager->remove($post);

        $view = $this->view(array("status" => 204, "message" => "Deleted", "body" => $post), 200);
        return $this->handleView($view);
    }
}