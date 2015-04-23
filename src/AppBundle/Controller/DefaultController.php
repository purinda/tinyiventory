<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Medicine\Entity\Bundle\Entity\Item;

class DefaultController extends Controller
{
    /**
     *
     * @var Symfony\Component\Form\Form
     */
    protected $form;

    /**
     * @Route("/", name="overview")
     */
    public function overviewAction(Request $request)
    {
        $form_data = [];

        $this->form = $this->createFormBuilder($form_data)
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('stock_hospital', 'text', ['label' => 'Stock hospital'])
            ->add('stock_private', 'text', ['label' => 'Stock private'])
            ->add('send', 'submit', ['label' => 'Save'])
            ->getForm();

        $this->form->handleRequest($request);

        if ($this->form->isValid()) {
            $this->save($request);
        }

        return $this->render(
            'default/overview.html.twig',
            [
                'form' => $this->form->createView()
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
        $em = $this->getDoctrine()->getManager();
        $data = $this->form->getData();

        $item = new Item();
        $item
            ->setName($data['name'])
            ->setDescription($data['description'])
        ;

        $em->persist($item);
        $em->flush();
    }
}
