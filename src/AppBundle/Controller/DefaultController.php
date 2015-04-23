<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Medicine\Entity\Bundle\Entity\Item;
use Medicine\Entity\Bundle\Entity\SupplierItem;

class DefaultController extends Controller
{
    /**
     * @var Symfony\Component\Form\Form
     */
    protected $form;

    /**
     * @Route("/", name="overview")
     */
    public function overviewAction(Request $request)
    {
        $this->setupItemForm();
        $this->form->handleRequest($request);

        if ($this->form->isValid()) {
            $this->save($request);
        }

        // Find all SupplierItems
        $supplier_items = $this
            ->getDoctrine()
            ->getRepository('MedicineEntityBundle:SupplierItem')
            ->findAll()
        ;

        return $this->render(
            'default/overview.html.twig',
            [
                'supplier_items' => $supplier_items,
                'form'           => $this->form->createView(),
            ]
        );
    }

    /**
     * Setup $this->form object to its initial configuration.
     */
    public function setupItemForm()
    {
        $this->form = $this->createFormBuilder([])
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('stock_hospital', 'text', ['label' => 'Stock hospital'])
            ->add('stock_private', 'text', ['label' => 'Stock private'])
            ->add('send', 'submit', ['label' => 'Save'])
            ->getForm()
        ;
    }

    /**
     * Save the data found in the request.
     *
     * @param Request $request
     *
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

        // persist
        $em->persist($item);
        $em->flush();

        // Find supplier based on name (Private, Hospital)
        $supplier_private = $this
            ->getDoctrine()
            ->getRepository('MedicineEntityBundle:Supplier')
            ->findByName('Private')
        ;

        $supplier_hospital = $this
            ->getDoctrine()
            ->getRepository('MedicineEntityBundle:Supplier')
            ->findByName('Hospital')
        ;

        // Set Supplier Item Availability
        $supplier_hospital_item = new SupplierItem();
        $supplier_hospital_item
            ->setSupplierId($supplier_hospital[0])
            ->setItemId($item)
            ->setQuantityAvailable($data['stock_hospital'])
        ;

        $supplier_private_item = new SupplierItem();
        $supplier_private_item
            ->setSupplierId($supplier_private[0])
            ->setItemId($item)
            ->setQuantityAvailable($data['stock_private'])
        ;

        // persist
        $em->persist($supplier_hospital_item);
        $em->persist($supplier_private_item);
        $em->flush();

        $this->setupItemForm();
    }
}
