<?php

namespace Medicine\Entity\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MedicineEntityBundle:Default:index.html.twig', array('name' => $name));
    }
}
