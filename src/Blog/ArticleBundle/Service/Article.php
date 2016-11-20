<?php
/**
 * Created by PhpStorm.
 * User: Jeranders
 * Date: 18/11/2016
 * Time: 14:55
 */

namespace Blog\ArticleBundle\Service;


use Blog\ArticleBundle\Form\ArticleType;
use Blog\ArticleBundle\Repository\ArticleRepository;
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
     * @var ArticleRepository
     */
    protected $repo;

    /**
     * Article constructor.
     * @param EntityManager $doctrine
     * @param FormFactory $form
     * @param ArticleRepository $articleRepository
     */
    public function __construct(EntityManager $doctrine, FormFactory $form, ArticleRepository $articleRepository)
    {
        $this->doctrine = $doctrine;
        $this->form = $form;
        $this->repo = $articleRepository;
    }

    /**
     * Show items
     * @return array
     */
    public function showArticle()
    {
        $showArticle = $this->doctrine->getRepository('BlogArticleBundle:Article')->showArticles();

        return $showArticle;
    }

    /**
     * Count the number of items
     * @return mixed
     */
    public function countArticle()
    {
        $count = $this->doctrine->getRepository('BlogArticleBundle:Article')->countArticle();

        return $count;
    }

    /**
     * Add article
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     */
    public function addArticle(Request $request)
    {
        $article = new \Blog\ArticleBundle\Entity\Article();

        $form = $this->form->create(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted())
        {
            $this->doctrine->persist($article);
            $this->doctrine->flush();
            $this->addFlash('notice','Article envoyé');
        }
        return $form;
    }

    /**
     * Find one article by ID
     * @param $id
     * @return null|object
     */
    public function findOneArticle($id)
    {
        $article = $this->repo->findOneBy($id);
        return $article;
    }


    /**
     * Delete Article
     * @param $article
     */
    public function deleteArticle($article)
    {
        $this->doctrine->remove($article);
        $this->doctrine->flush();
    }
}