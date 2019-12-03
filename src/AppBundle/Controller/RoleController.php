<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Role controller.
 *
 * @Route("role")
 */
class RoleController extends Controller
{
    /**
     * Lists all role entities.
     *
     * @Route("/", name="role_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if(isset ($_SESSION["role"])){
            $user = $_SESSION["user"];
            $userRole = $_SESSION["role"];

            if ($userRole == "Admin" ){
                $em = $this->getDoctrine()->getManager();

                $roles = $em->getRepository('AppBundle:Role')->findAll();

                return $this->render('role/index.html.twig', array(
                    'roles' => $roles,
                    'role' => $userRole,
                ));
            }else{
                return $this->redirectToRoute('home');
            }


        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * Creates a new role entity.
     *
     * @Route("/new", name="role_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if(isset ($_SESSION["role"])){
            $user = $_SESSION["user"];
            $userRole = $_SESSION["role"];

            if ($userRole == "Admin"){
                $role = new Role();
                $form = $this->createForm('AppBundle\Form\RoleType', $role);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($role);
                    $em->flush();

                    return $this->redirectToRoute('role_show', array('id' => $role->getId()));
                }

                return $this->render('role/new.html.twig', array(
                    'roleN' => $role,
                    'role' => $userRole,
                    'form' => $form->createView(),
                ));
            }else{
                return $this->redirectToRoute('home');
            }


        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * Finds and displays a role entity.
     *
     * @Route("/{id}", name="role_show")
     * @Method("GET")
     */
    public function showAction(Role $role)
    {
        if(isset ($_SESSION["role"])){
            $user = $_SESSION["user"];
            $userRole = $_SESSION["role"];

            if ($userRole == "Admin" ){
                $deleteForm = $this->createDeleteForm($role);

                return $this->render('role/show.html.twig', array(
                    'roleN' => $role,
                    'role' => $userRole,
                    'delete_form' => $deleteForm->createView(),
                ));
            }else{
                return $this->redirectToRoute('home');
            }


        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * Displays a form to edit an existing role entity.
     *
     * @Route("/{id}/edit", name="role_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Role $role)
    {
        if(isset ($_SESSION["role"])){
            $user = $_SESSION["user"];
            $userRole = $_SESSION["role"];

            if ($userRole == "Admin" ){
                $deleteForm = $this->createDeleteForm($role);
                $editForm = $this->createForm('AppBundle\Form\RoleType', $role);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $this->getDoctrine()->getManager()->flush();

                    return $this->redirectToRoute('role_edit', array('id' => $role->getId()));
                }

                return $this->render('role/edit.html.twig', array(
                    'roleN' => $role,
                    'role' => $userRole,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
            }else{
                return $this->redirectToRoute('home');
            }


        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * Deletes a role entity.
     *
     * @Route("/{id}/delete", name="role_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Role $role)
    {
        if(isset ($_SESSION["role"])){
            $user = $_SESSION["user"];
            $userRole = $_SESSION["role"];

            if ($userRole == "Admin" ){

                $form = $this->createDeleteForm($role);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($role);
                    $em->flush();
                }
                return $this->redirectToRoute('role_index');
            }else{
                return $this->redirectToRoute('home');
            }


        }else{
            return $this->redirectToRoute('login');
        }

        
    }

    /**
     * Creates a form to delete a role entity.
     *
     * @param Role $role The role entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Role $role)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('role_delete', array('id' => $role->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
