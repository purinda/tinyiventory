<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Medicine\Entity\Bundle\Entity\Item;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="overview")
     */
    public function overviewAction(Request $request)
    {
        $form_data = [];

        $form = $this->createFormBuilder($form_data)
            ->add('name', 'text')
            ->add('stock_hospital', 'text', ['label' => 'Stock hospital'])
            ->add('stock_private', 'text', ['label' => 'Stock private'])
            ->add('send', 'submit', ['label' => 'Save'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->save($request);
        }

        return $this->render(
            'default/overview.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Save the data found in the request
     * @param  Request $request
     * @return bool
     */
    public function save(Request $request)
    {
        dump($request);
    }
}
