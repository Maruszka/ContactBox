<?php

namespace contactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use contactBoxBundle\Entity\Address;


class AddressController extends Controller {

    private function generateAddressForm(Address $address) {
        return $this->createFormBuilder($address)
                        ->add("city", "text")
                        ->add("street", "text")
                        ->add("houseNumber", "text")
                        ->add("flatNumber", "text")
                        ->add("type", "choice", [
                            'choices' => [1 => "home", 2 => "bussines"]])
                        ->add("send", "submit")
                        ->getForm();
    }

    /**
     * Wczytuje nowy adres osobie o id przekazanym Getem - wyswietlanie formularza
     * @Route("/newAdress/{idPerson}")
     * @Template("contactBoxBundle:Address:newAddress.html.twig")
     * @Method({"GET"})
     */
    public function createNewAdressAction($idPerson) {
        $newAddress = new Address();
        $form = $this->generateAddressForm($newAddress);
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Person");
        $personToUpdate = $repo->find($idPerson);
        $newAddress->setPerson($personToUpdate);
        return array("formAddress" => $form->createView(), "person" => $personToUpdate);
    }

    /**
     * Przekazanie danych do bd
     * @Route("/newAdress/{idPerson}")
     * @Method({"POST"})
     */
    public function createNewAdressPostAction(Request $req, $idPerson) {
        $newAddress = new Address();
        $form = $this->generateAddressForm($newAddress);
        
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Person");
        $personToUpdate = $repo->find($idPerson);
        $newAddress->setPerson($personToUpdate);
        $form->handleRequest($req);


        //zapisanie w db
        $em = $this->getDoctrine()->getManager();
        $em->persist($newAddress);
        $em->flush();

        return $this->redirectToRoute("contactbox_person_showoneperson", ['id' => $idPerson]); 
    }

    /**
     * Edytuje adres o id orzekazanym GETEM, Wyswietlenie formularza d Edycji w GEt
     * @Route("/editAddress/{idAddress}")
     * @Method({"GET"})
     * @Template()
     */
    public function editAddressAction($idAddress) {
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Address");
        $address = $repo->find($idAddress);
        $form = $this->generateAddressForm($address);
        $personId = $address->getPerson()->getId();

        return["formAddress" => $form->createView()];
    }
    /**
     * Wczytanie zedytowanych danych do bd
     * @Route("/editAddress/{idAddress}")
     * @Method({"POST"})
     * 
     */
    public function postEditAddressAction(Request $req, $idAddress){
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Address");
        $address = $repo->find($idAddress);
        $form = $this->generateAddressForm($address);
        $form->handleRequest($req);
        $personId = $address->getPerson()->getId();
        
        
        $this->getDoctrine()->getManager()->flush();
        
        return $this->redirectToRoute("contactbox_person_showoneperson", ['id' => $personId]); 

    }

    /**
     * @Route("/deleteAddress/{idAddress}")
     * @Method({"GET"})
     *
     */
    public function deleteAddressAction($idAddress) {
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Address");
        $addressToDel = $repo->find($idAddress);
        $personId = $addressToDel->getPerson()->getId();
        
        $em->remove($addressToDel);
        $em->flush();

        return $this->redirectToRoute("contactbox_person_showoneperson", ['id' => $personId]);
      
    }

    /**
     * @Route("/showAddress/")
     * @Template()
     */
    public function showAddressAction() {
        $repo = $this->getDoctrine()->getRepository("contactBoxBundle:Address"); //wczytujemy nasza encje
        $addresses = $repo->$repo->findAll(); //zwykly find szukapo kluczu glownym 
        return array("addresses" => $addresses);
    }
    



}
