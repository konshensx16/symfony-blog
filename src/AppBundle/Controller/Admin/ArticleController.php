<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use AppBundle\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{
    /**
     * @Route("admin/article/new", name="article_new")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setAuthor($this->getUser());

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('admin-articles');
        }

        return $this->render('backoffice/article/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/article/{id}/edit", name="article_edit")
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editAction(Request $request, int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin-articles');
        }

        return $this->render('backoffice/article/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/article/{id}/delete", name="article_delete")
     *
     * @param int $id
     * @return Response
     */
    public function deleteAction(int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('admin-articles');
    }
}
