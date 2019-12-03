<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Vm;
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
class GestionVmController extends Controller
{
    /**
     * gestionVm
     *
     * @Route("/home", name="home")
     * @Method({"GET", "POST"})
     */
    public function homeAction(Request $request)
    {
        if(isset ($_SESSION["role"])){
            $user = $_SESSION["user"];
            $userRole = $_SESSION["role"];
            if ($userRole == "Admin" or $userRole == "User" ){

                $repository = $this->getDoctrine()->getRepository(Vm::class);
                $vms = $repository->findBy(
                    ['user' => $user],
                    ['name' => 'ASC']
                );
            
            
                return $this->render('gestionVm/homePage.html.twig', [
                    'user' => $user,
                    'role' => $userRole,
                    'vms' => $vms,
                ]);
                
            }else{
                return $this->redirectToRoute('login');
            }


        }else{
            return $this->redirectToRoute('login');
        }
        //return $this->render('connexion/login.html.twig');
    }

}
