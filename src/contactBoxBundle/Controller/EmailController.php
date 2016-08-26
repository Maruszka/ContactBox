<?php

namespace contactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use contactBoxBundle\Entity\Email;
use contactBoxBundle\Entity\Phone;
use contactBoxBundle\Entity\Person;

class EmailController extends Controller {

    //prywatna funkcja do generowania formularza
    private function generateEmailForm(Email $email) {
        return $this->createFormBuilder($email)
                        ->add("email", "text")
                        ->add("type", "choice", [
                            'choices' => [1 => "home", 2 => "bussines"]])
                        ->add("send", "submit")
                        ->getForm();
    }

    /**
     * Dodaje email osobie o {id} 
     * @Route("/addEmail/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function addEmailAction($id) {
        $newEmail = new Email();
        $form = $this->generateEmailForm($newEmail);
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Person");
        $personToUpdate = $repo->find($id);
        $newEmail->setPerson($personToUpdate);
        return array("formEmail" => $form->createView(), "person" => $personToUpdate);
    }

    /**
     * Dodaje email osobie o id przekazanym getem
     * @Route("/addEmail/{id}")
     * @Template("contactBoxBundle:Person:showOnePerson.html.twig")
     * @Method({"POST"})
     */
    public function addEmailPostAction(Request $req, $id) {
        $newEmail = new Email();
        $form = $this->generateEmailForm($newEmail);
        $form->handleRequest($req);
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Person");
        $personToUpdate = $repo->find($id);
        $newEmail->setPerson($personToUpdate);



        $em = $this->getDoctrine()->getManager();
        $em->persist($newEmail);
        $em->flush();
        return["email" => $newEmail, "person" => $personToUpdate];
    }

    /**
     * Edytuje email o {id} przekazany, getem
     * @Route("/editEmail/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function editEmailAction($id) {
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Email");
        $email = $repo->find($id);
    
        $form = $this->generateEmailForm($email);

        return["formEmail" => $form->createView()];
    }

    /**
     * @Route("/editEmail/{id}")
     * @Method({"POST"})
     */
    public function editEmailPostAction(Request $req, $id) {
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Email");
        $email = $repo->find($id);
        $form = $this->generateEmailForm($email);
        $form->handleRequest($req);

        $this->getDoctrine()->getManager()->flush();

        $personId = $email->getPerson()->getId();

        return $this->redirectToRoute("contactbox_person_showoneperson", ["id" => $personId]);
    }

    /**
     * kasuje email o {id} przkazanym getem
     * @Route("/deleteEmail/{id}")
     * @Method({"GET"})
     * @Template()
     */
    public function deleteEmailAction() {
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Email");
        $emailToDel = $repo->find($id);
        $personId = $emailToDel->getPerson()->getId();

        $em->remove($emailToDel);
        $em->flush();

        return $this->redirectToRoute("contactbox_person_showoneperson", ['id' => $personId]);
    }

    /**
     * @Route("/showEmail/{id}")
     * @Template()
     */
    public function showEmailAction($id) {
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Email");
        $email = $repo->find($id);
        return array("email" => $email);
    }

}
