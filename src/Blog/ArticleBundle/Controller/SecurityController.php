<?php
/**
 * Created by PhpStorm.
 * User: AnCat
 * Date: 22/11/2016
 * Time: 08:23
 */

namespace Blog\ArticleBundle\Controller;
use Blog\ArticleBundle\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template("default/login.html.twig")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginType::class, [
            '_username' => $lastUsername,
        ]);

        return array(
                'form' => $form->createView(),
                'error' => $error,
            );
    }

    /**
     * @Route("/register", name="register")
     * @Template("default/register.html.twig")
     */
    public function registerAction()
    {

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }
}