<?php

namespace contactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use contactBoxBundle\Entity\Phone;
use contactBoxBundle\Entity\Person;

class PhoneController extends Controller {

    private function generatePhoneForm(Phone $phone) {
        return $this->createFormBuilder($phone)
                        ->add("number", "text")
                        ->add("type", "choice", [
                            'choices' => ["home" => 1, "bussines" => 2]])
                        ->add("send", "submit")
                        ->getForm();
    }

    /**
     * @Route("/addPhone/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function addPhoneAction($id) {
        $newPhone = new Phone();
        $form = $this->generatePhoneForm($newPhone);
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Person");
        $personToUpdate = $repo->find($id);
        $newPhone->setPerson($personToUpdate);
        return array("formPhone" => $form->createView(), "person" => $personToUpdate);
    }

    /**
     * @Route("/addNewPhone/{id}")
     * @Template("contactBoxBundle:Person:showOnePerson.html.twig")
     * @Method({"POST"})
     */
    public function addPhonePostAction(Request $req, $id) {
        $newPhone = new Phone();
        $form = $this->generatePhoneForm($newPhone);
        $form->handleRequest($req);
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Person");
        $personToUpdate = $repo->find($id);
        $newPhone->setPerson($personToUpdate);



        $em = $this->getDoctrine()->getManager();
        $em->persist($newPhone);
        $em->flush();
        return $this->redirectToRoute("contactbox_person_showoneperson", ['id' => $id]);
    }

    /**
     * @Route("/editPhone/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function editPhoneAction($id) {
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Phone");
        $phone = $repo->find($id);

        $form = $this->generatePhoneForm($phone);

        return["formPhone" => $form->createView()];
    }

    /**
     * @Route("/editPhone/{id}")
     * @Template()
     * @Method({"Post"})
     */
    public function editPhonePostAction(Request $req, $id) {
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Phone");
        $phone = $repo->find($id);
        $personId = $phone->getPerson()->getId();

        $form = $this->generatePhoneForm($phone);
        $form->handleRequest($req);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute("contactbox_person_showoneperson", ['id' => $personId]);
    }

    /**
     * @Route("/deletePhone/{id}")
     * @Method({"GET"})
     * @Template()
     */
    public function deletePhoneAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Phone");
        $phoneToDel = $repo->find($id);
        $personId = $phoneToDel->getPerson()->getId();
        
        $em->remove($phoneToDel);
        $em->flush();

        return $this->redirectToRoute("contactbox_person_showoneperson", ['id' => $personId]);
       
    }

    /**
     * @Route("/showPhone/{id}")
     * @Template()
     */
    public function showPhoneAction($id) {
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Phone");
        $phone = $repo->find($id);
        return array("phone" => $phone);
    }

}
