<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;




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
     * @Method({"GET", "POST"})
     */
    public function loginAction(Request $request)
    {
        if(isset ($_SESSION["role"])){
            session_destroy();
        }
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->setAction($this->generateUrl('login'))
            ->setMethod('POST')
            ->add('login', TextType::class)
            ->add('password', TextType::class)
            ->add('Se connecter', SubmitType::class, ['label' => 'Create Connexion'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();
            //echo "task : ".$task;
            
            var_dump($task->getLogin());
            var_dump($task->getPassword());

            $em = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(User::class);
            $task->setPassword(hash('md5', $task->getPassword()));
            var_dump($task->getPassword());
            $dbuser = $repository->findOneBy([
                'login' => $task->getLogin(),
                'password' =>$task->getPassword(), 
            ]);
            if(isset ($dbuser)){
                $_SESSION["user"]=$dbuser;
                $_SESSION["role"]=$dbuser->getRole()->getName();
                var_dump($dbuser->getLogin());
                var_dump($dbuser->getRole()->getName());
                
                return $this->redirectToRoute('home');
            }
        
        }
        return $this->render('connexion/login.html.twig', [
            'form' => $form->createView(),
        ]);

    }
    /**
     * deconnexion
     *
     * @Route("/logout", name="logout")
     * @Method({"GET", "POST"})
     */
    public function logoutAction(Request $request)
    {
        session_destroy();
        return $this->redirectToRoute('login');

    }
}

