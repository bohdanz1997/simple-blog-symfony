<?php

namespace Acme\BlogBundle\Controller;

use Acme\BlogBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Acme\BlogBundle\Entity\Post;
use Symfony\Component\Serializer\Serializer;

class PostController extends Controller
{
    /**
     * @Route("/index", name="acme_index")
     */
    public function indexAction()
    {

        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAll();

        return $this->render('AcmeBlogBundle:Page:index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/create", name="acme_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findBy([], ['id' => 'desc'],
                $this->getParameter('acme_blog.per_page'));

        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($entity);
            $em->flush();

            return $this->redirectToRoute('acme_create');
        }

        return $this->render('AcmeBlogBundle:Page:create.html.twig', [
            'form' => $form->createView(),
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/delete/{id}", name="acme_delete")
     */
    public function deleteAction(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();


        $this->addFlash('post_deleted', 'Post Deleted!');

        return $this->redirectToRoute('acme_create');
    }
}
