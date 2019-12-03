<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vm controller.
 *
 * @Route("vm")
 */
class VmController extends Controller
{
    /**
     * Lists all vm entities.
     *
     * @Route("/", name="vm_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if(isset ($_SESSION["role"])){
            $user = $_SESSION["user"];
            $userRole = $_SESSION["role"];

            if ($userRole == "Admin" or $userRole == "User" ){
                $em = $this->getDoctrine()->getManager();

                $vms = $em->getRepository('AppBundle:Vm')->findAll();

                return $this->render('vm/index.html.twig', array(
                    'vms' => $vms,
                    'role' => $userRole,
                ));
            }
        }
    }

    /**
     * Creates a new vm entity.
     *
     * @Route("/new", name="vm_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if(isset ($_SESSION["role"])){
            $user = $_SESSION["user"];
            $userRole = $_SESSION["role"];

            if ($userRole == "Admin" or $userRole == "User" ){
                $vm = new Vm();
                $form = $this->createForm('AppBundle\Form\VmType', $vm);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($vm);
                    $em->flush();

                    return $this->redirectToRoute('vm_show', array('id' => $vm->getId()));
                }

                return $this->render('vm/new.html.twig', array(
                    'vm' => $vm,
                    'role' => $userRole,
                    'form' => $form->createView(),
                ));
            }
        }
    }

    /**
     * Finds and displays a vm entity.
     *
     * @Route("/{id}", name="vm_show")
     * @Method("GET")
     */
    public function showAction(Vm $vm)
    {
        if(isset ($_SESSION["role"])){
            $user = $_SESSION["user"];
            $userRole = $_SESSION["role"];

            if ($userRole == "Admin" or $userRole == "User" ){
                $deleteForm = $this->createDeleteForm($vm);

                return $this->render('vm/show.html.twig', array(
                    'vm' => $vm,
                    'role' => $userRole,
                    'delete_form' => $deleteForm->createView(),
                ));
            }
        }
    }

    /**
     * Displays a form to edit an existing vm entity.
     *
     * @Route("/{id}/edit", name="vm_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Vm $vm)
    {
        if(isset ($_SESSION["role"])){
            $user = $_SESSION["user"];
            $userRole = $_SESSION["role"];

            if ($userRole == "Admin" or $userRole == "User" ){
                $deleteForm = $this->createDeleteForm($vm);
                $editForm = $this->createForm('AppBundle\Form\VmType', $vm);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $this->getDoctrine()->getManager()->flush();

                    return $this->redirectToRoute('vm_edit', array('id' => $vm->getId()));
                }

                return $this->render('vm/edit.html.twig', array(
                    'vm' => $vm,
                    'role' => $userRole,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
            }
        }
    }

    /**
     * Deletes a vm entity.
     *
     * @Route("/{id}/delete", name="vm_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Vm $vm)
    {
        if(isset ($_SESSION["role"])){
            $user = $_SESSION["user"];
            $userRole = $_SESSION["role"];
  
            if ($userRole == "Admin" or $userRole == "User" ){
                $form = $this->createDeleteForm($vm);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($vm);
                    $em->flush();
                }

                return $this->redirectToRoute('vm_index');
            }
        }
    }

    /**
     * Creates a form to delete a vm entity.
     *
     * @param Vm $vm The vm entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Vm $vm)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vm_delete', array('id' => $vm->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
