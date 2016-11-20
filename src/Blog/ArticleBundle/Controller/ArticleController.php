<?php
/**
 * Created by PhpStorm.
 * User: AnCat
 * Date: 17/11/2016
 * Time: 19:34
 */

namespace Blog\ArticleBundle\Controller;

use Blog\ArticleBundle\Entity\Article;
use Blog\ArticleBundle\Form\ArticleType;
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

//        $repository = $this->getDoctrine()
//            ->getManager()
//            ->getRepository('BlogArticleBundle:Article');
//
//        $count = $repository->countArticle();
//        $showArticle = $repository->showArticles();

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
            return $this->redirectToRoute('home-page');
        }
        return array('form' => $form->createView());

    }


}