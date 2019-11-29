<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("")
 */
class ConnexionController extends Controller
{
    /**
     * connexion
     *
     * @Route("/login", name="login")
     * @Method("GET")
     */
    public function loginAction()
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('connexion/login.html.twig');
    }

    /**
     * Quand l'utilisateur tante de se connecter.
     *
     * @Route("/connect", name="login_connect")
     * @Method({"GET", "POST"})
     */
    public function connectAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(User::class);

        $dbuser = $repository->findOneBy([
            'login' => $user.getLogin(),
            'password' =>$user.getPassword() 
        ]);
        if(isset ($dbuser)){
            return $this->redirectToRoute('user_index');
        }else{
            return $this->redirectToRoute('pool_index');
        }
    }
}

