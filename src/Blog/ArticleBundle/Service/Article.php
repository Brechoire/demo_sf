<?php
/**
 * Created by PhpStorm.
 * User: Jeranders
 * Date: 18/11/2016
 * Time: 14:55
 */

namespace Blog\ArticleBundle\Service;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;

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
    public function __construct($doctrine, $form)
    {
        $this->doctrine = $doctrine;
        $this->$form = $form;
    }

    public function showArticle()
    {
        
    }
}