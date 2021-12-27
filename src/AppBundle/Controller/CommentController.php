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
use AppBundle\Entity\Comment;
use AppBundle\Manager\CommentManager;
use AppBundle\Form\CommentFormType;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;

class CommentController extends FOSRestController
{
     /**
     * @Get("/comment")
     */
    public function getAllCommenttAction()
    {
        $CommentManager = $this->get('my_api.manager.comment');
        $data = $CommentManager->findAll();

        $view = $this->view(array("status" => 200, "message" => "OK", "body" => $data), 200);
        return $this->handleView($view);
    }

    /**
     * @Get("/comment/{id}")
     */
    public function getCommentAction($id)
    {
        $CommentManager = $this->get('my_api.manager.comment');
        $data = $CommentManager->find($id);

        $view = $this->view(array("status" => 200, "message" => "OK", "body" => $data), 200);
        return $this->handleView($view);
    }

    /**
     * @Post("/comment")
     */
    public function postCommentAction()
    {
        $formFactory = $this->get('my_api.comment.form.factory');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $data = json_decode($request->getContent(), true);
        $CommentManager = $this->get('my_api.manager.comment');
        $comment = $CommentManager->createComment();

        if (null !== $data) {
            $request->request->replace($data);
        }
        $form = $formFactory->createForm();
        $form->setData($comment);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $CommentManager->save($comment);

            $view = $this->view(array("status" => 201, "message" => "OK", "body" => $comment), 200);
            return $this->handleView($view);
        }
        $view = $this->view(array("status" => 500, "message" => "Requête invalide", "body" => $serializer->serialize($form, 'json')), 200);
        return $this->handleView($view);
    }

    /**
     * @Patch("/comment/{id}")
     */
    public function patchCommentAction($id)
    {
        $formFactory = $this->get('my_api.comment.form.factory');
        $CommentManager = $this->get('my_api.manager.comment');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $data = json_decode($request->getContent(), true);

        $comment = $CommentManager->find($id);

        if (!$comment) {
            $view = $this->view(array("status" => 404, "message" => "Comment not found", "body" => null), 200);
            return $this->handleView($view);
        }

        if (null !== $data) {
            $request->request->replace($data);
        }
        $form = $formFactory->createForm(array('method' => 'PATCH'));
        $form->setData($comment);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $CommentManager->save($comment);

            $view = $this->view(array("status" => 200, "message" => "OK", "body" => $comment), 200);
            return $this->handleView($view);
        }
        $view = $this->view(array("status" => 404, "message" => "Contenu introuvable", "body" => $serializer->serialize($form, 'json')), 200);
        return $this->handleView($view);
    }

    /**
     * @Delete("/comment/{id}")
     */
    public function deleteCommentAction($id)
    {
        $formFactory = $this->get('my_api.comment.form.factory');
        $CommentManager = $this->get('my_api.manager.comment');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $data = json_decode($request->getContent(), true);

        $comment = $CommentManager->find($id);

        if (!$comment) {
            $view = $this->view(array("status" => 404, "message" => "Comment not found", "body" => null), 200);
            return $this->handleView($view);
        }

        $CommentManager->remove($comment);

        $view = $this->view(array("status" => 204, "message" => "Deleted", "body" => $comment), 200);
        return $this->handleView($view);
    }
}