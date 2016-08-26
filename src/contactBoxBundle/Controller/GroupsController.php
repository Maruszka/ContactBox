<?php

namespace contactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GroupsController extends Controller
{
    /**
     * @Route("/addNewGroup")
     * @Template()
     */
    public function addNewGroupAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/editGroup")
     * @Template()
     */
    public function editGroupAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/deleteGroup")
     * @Template()
     */
    public function deleteGroupAction()
    {
        return array(
                // ...
            );    }

}
