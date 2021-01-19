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
use AppBundle\Entity\Likes;
use AppBundle\Manager\LikeManager;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;

class LikeController extends FOSRestController
{
    /**
     * @Get("/like")
     */
    public function getAllLikeAction()
    {
        $LikeManager = $this->get('my_api.manager.like');
        $data = $LikeManager->findAll();

        $view = $this->view(array("status" => 200, "message" => "OK", "body" => $data), 200);
        return $this->handleView($view);
    }

    /**
     * @Get("/like/{id}")
     */
    public function getLikeAction($id)
    {
        $LikeManager = $this->get('my_api.manager.like');
        $data = $LikeManager->find($id);

        $view = $this->view(array("status" => 200, "message" => "OK", "body" => $data), 200);
        return $this->handleView($view);
    }

    /**
     * @Post("/like")
     */
    public function postLikeAction()
    {
        $formFactory = $this->get('my_api.like.form.factory');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $data = json_decode($request->getContent(), true);
        $LikeManager = $this->get('my_api.manager.like');
        $like = $LikeManager->createLike();

        if (null !== $data) {
            $request->request->replace($data);
        }
        $form = $formFactory->createForm();
        $form->setData($like);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $LikeManager->save($like);

            $view = $this->view(array("status" => 201, "message" => "OK", "body" => $like), 200);
            return $this->handleView($view);
        }
        $view = $this->view(array("status" => 500, "message" => "Requête invalide", "body" => $serializer->serialize($form, 'json')), 200);
        return $this->handleView($view);
    }

    /**
     * @Patch("/like/{id}")
     */
    public function patchLikeAction($id)
    {
        $formFactory = $this->get('my_api.like.form.factory');
        $LikeManager = $this->get('my_api.manager.like');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $data = json_decode($request->getContent(), true);

        $like = $LikeManager->find($id);

        if (!$like) {
            $view = $this->view(array("status" => 404, "message" => "Like not found", "body" => null), 200);
            return $this->handleView($view);
        }

        if (null !== $data) {
            $request->request->replace($data);
        }
        $form = $formFactory->createForm(array('method' => 'PATCH'));
        $form->setData($like);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $LikeManager->save($like);

            $view = $this->view(array("status" => 200, "message" => "OK", "body" => $like), 200);
            return $this->handleView($view);
        }
        $view = $this->view(array("status" => 404, "message" => "Contenu introuvable", "body" => $serializer->serialize($form, 'json')), 200);
        return $this->handleView($view);
    }

    /**
     * @Delete("/like/{id}")
     */
    public function deleteLikeAction($id)
    {
        $formFactory = $this->get('my_api.like.form.factory');
        $LikeManager = $this->get('my_api.manager.like');
        $serializer = $this->get('jms_serializer');
        $request = $this->get('request_stack')->getCurrentRequest();
        $data = json_decode($request->getContent(), true);

        $like = $LikeManager->find($id);

        if (!$like) {
            $view = $this->view(array("status" => 404, "message" => "Like not found", "body" => null), 200);
            return $this->handleView($view);
        }

        $LikeManager->remove($like);

        $view = $this->view(array("status" => 204, "message" => "Deleted", "body" => $like), 200);
        return $this->handleView($view);
    }
}