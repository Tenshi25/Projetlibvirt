<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Vm;
use AppBundle\Entity\Pool;
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
                dump($vms);
                
                dump($user);
                dump($userRole);
                $repository = $this->getDoctrine()->getRepository(Pool::class);
                $pools = $repository->findBy(
                    ['user' => $user],
                    ['name' => 'ASC']
                );
                $repository = $this->getDoctrine()->getRepository(Vm::class);
                //$vms = $repository->findByUser($user);
                //$vms2 = $repository->findAll();
                //array('user' => $user,'pool' => null ),
                dump($vms);
                //dump($vms2);
                dump($pools);
                
                return $this->render('gestionVm/homePage.html.twig', [
                    'user' => $user,
                    'role' => $userRole,
                    'vms' => $vms,
                    'pools'=>$pools,
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
