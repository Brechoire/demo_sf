<?php
/**
 * Created by PhpStorm.
 * User: Jeranders
 * Date: 18/11/2016
 * Time: 14:55
 */

namespace Blog\ArticleBundle\Service;


use Blog\ArticleBundle\Form\ArticleType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;


class Article
{
    /**
     * @var EntityManager
     */
    protected $doctrine;

    /**
     * @var FormFactory
     */
    protected $form;

    /**
     * Article constructor.
     * @param $doctrine
     * @param $form
     */
    public function __construct(EntityManager $doctrine, FormFactory $form)
    {
        $this->doctrine = $doctrine;
        $this->form = $form;
    }

    public function showArticle()
    {
         $showArticle = $this->doctrine->getRepository('BlogArticleBundle:Article')->showArticles();

        return $showArticle;
    }

    public function countArticle()
    {
        $count = $this->doctrine->getRepository('BlogArticleBundle:Article')->countArticle();

        return $count;
    }


    public function addArticle(Request $request)
    {
        $article = new \Blog\ArticleBundle\Entity\Article();

        $form = $this->form->create(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $this->doctrine->persist($article);
            $this->doctrine->flush();
            // $this->session->getFlashbag()->add('success', 'L'article a bien été ajouté');
           
        }

        return $form;
    }
}