<?php

namespace contactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use contactBoxBundle\Entity\Person;
use contactBoxBundle\Entity\Address;
use contactBoxBundle\Entity\Phone;
use contactBoxBundle\Entity\Email;

class PersonController extends Controller {

    private function generateSimpleForm(Person $person) {
        return $this->createFormBuilder($person)
                        ->add("name", "text")
                        ->add("surname", "text")
                        ->add("description", "text")
                        ->add("send", "submit")
                        ->getForm();
    }

    /**
     * Wczytuje formularz getem
     * @Route("/newPerson")
     * @Template("contactBoxBundle:Person:createNew.html.twig")
     * @Method({"GET"})
     */
    public function createNewAction() {
        $newPerson = new Person();
        $form = $this->generateSimpleForm($newPerson);
        return array("form" => $form->createView());
    }

    /**
     * Przesylam dane postem
     * @Route("/newPerson")
     * @Template("contactBoxBundle:Person:showOnePerson.html.twig")
     * @Method({"POST"})
     */
    public function postCustomerFormAction(Request $req) {
        $newPerson = new Person();
        $form = $this->generateSimpleForm($newPerson);
        $form->handleRequest($req);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newPerson);
        $em->flush();

        return ['person' => $newPerson];
    }

    /**
     * @Route("/deletePerson/{id}")
     * @Method({"GET"})
     * 
     */
    public function deletePersonAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Person");
        $personToDel = $repo->find($id);
        $em->remove($personToDel);
        $em->flush();

        return $this->redirectToRoute("contactbox_person_showallcontacts");
    }

    /**
     * @Route("/showOnePerson/{id}")
     * @Template()
     */
    public function showOnePersonAction($id) {
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Person");
        $person = $repo->find($id); //
        $phones = $person->getPhones();
        $addresses = $person->getAddresses();
        $emails = $person->getEmails();
        return array("person" => $person, "phones" => $phones, "emails" => $emails, "addresses" => $addresses);
    }

    /**
     * @Route("/")
     * @Template()
     */
    public function showAllContactsAction() {
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Person");
        $allPersons = $repo->findAll();
        return array("allPersons" => $allPersons);
    }

    /**
     * @Route("/editPerson/{id}")
     * @Method({"GET"})
     * @Template("contactBoxBundle:Person:createNew.html.twig")
     */
    public function editPersonAction($id) {
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Person");
        $person = $repo->find($id);
        $phones = $person->getPhones();
        $addresses = $person->getAddresses();
        $emails = $person->getEmails();
        $form = $this->generateSimpleForm($person);

        return["form" => $form->createView(), "person" => $person];
    }

    /**
     * @Route("/editPerson/{id}")
     * @Method({"POST"})
     * @Template("contactBoxBundle:Person:showOnePerson.html.twig")
     */
    public function postEditPersonAction(Request $req, $id) {
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Person");
        $person = $repo->find($id);
        $form = $this->generateSimpleForm($person);
        $phones = $person->getPhones();
        $addresses = $person->getAddresses();
        $emails = $person->getEmails();
        $form = $this->generateSimpleForm($person);
        $form->handleRequest($req);

        $this->getDoctrine()->getManager()->flush();

        return["person" => $person, "phones" => $phones, "emails" => $emails, "addresses" => $addresses];
    }

}
