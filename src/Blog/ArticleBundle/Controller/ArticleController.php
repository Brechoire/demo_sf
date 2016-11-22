<?php
/**
 * Created by PhpStorm.
 * User: AnCat
 * Date: 17/11/2016
 * Time: 19:34
 */

namespace Blog\ArticleBundle\Controller;

use Blog\ArticleBundle\Entity\Article;
use Blog\ArticleBundle\Entity\User;
use Blog\ArticleBundle\Form\ArticleType;
use Blog\ArticleBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    /**
     * @Route("/", name="home-page")
     * @Template("default/index.html.twig")
     */
    public function indexAction()
    {

        $showArticle = $this->get('app.article')->showArticle();
        $count = $this->get('app.article')->countArticle();

        return array(
            'countarticle' => $count,
            'showarticle' => $showArticle
        );

    }

    /**
     * @Route("article/{id}", name="article", requirements={"page": "\d+"})
     * @Template("default/article.html.twig")
     */
    public function showArticleAction($id)
    {
        $article = $this->getDoctrine()
            ->getManager()
            ->getRepository('BlogArticleBundle:Article')
            ->find($id);

        return array('article' => $article);
    }

    /**
     * @Route("/add", name="add")
     * @Template("default/add.html.twig")
     */
    public function addArticleAction(Request $request)
    {

        $form = $this->get('app.article')->addArticle($request);

        if ($form->isValid()) {
            $this->addFlash('notice','Article envoyé');
            return $this->redirectToRoute('home-page');
        }

        return array('form' => $form->createView());

    }


    /**
     * @Route("/article/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $articleService = $this->get('app.article');

        $article = $articleService->findOneArticle(['id' => $id]);

        $articleService->deleteArticle($article);
        $this->addFlash('danger', 'Article bien supprimé');
        return $this->redirectToRoute('home-page');
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @Route("/article/article-update/{id}", name="article-update")
     * @Template("default/article-update.html.twig")
     */
    public function updateArticleAction(Request $request, $id)
    {
        /**
         * Récupère les informations de l'article pour les afficher
         */
        $article = $this->get('app.article')->findArticle($id);

        if (!$article) {
            $this->addFlash('danger', 'L\'article demandé est inconnu');
            return $this->redirectToRoute('home-page');

//            throw $this->createNotFoundException(
//                'Aucun article trouvé pour cet id : '.$id
//            );
        }

        $form = $this->get('app.article')->updateArticle($request, $id);
        if ($form->isValid()) {
            return $this->redirectToRoute('home-page');
        }

        return array('article' => $article, 'form' => $form->createView());

    }




}