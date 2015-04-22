<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Medicine\Entity\Bundle\Entity\Item;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="overview")
     */
    public function overviewAction()
    {
        $form_data = [];

        $form = $this->createFormBuilder($form_data)
            ->add('name', 'text')
            ->add('stock_hospital', 'text', ['label' => 'Stock hospital'])
            ->add('stock_private', 'text', ['label' => 'Stock private'])
            ->add('send', 'submit', ['label' => 'Save'])
            ->getForm();

        return $this->render(
            'default/overview.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
