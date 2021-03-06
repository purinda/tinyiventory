<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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

            return $this->redirectToRoute('overview', [], 302);
        }

        // Find all SupplierItems
        $supplier_items = $this
            ->getDoctrine()
            ->getRepository('MedicineEntityBundle:SupplierItem')
            ->findAll()
        ;

        // format them to be used in list view
        $items = [];
        $suppliers = [];
        $current_id = null;
        foreach ($supplier_items as $supplier_item) {
            $item     = $supplier_item->getItem();
            $current_id = $item->getId();

            $supplier = $supplier_item->getSupplier();
            $suppliers[$supplier->getId()] = $supplier;

            $items[$current_id]['name'] = $item->getName();
            $items[$current_id]['description'] = $item->getDescription();
            $items[$current_id]['suppliers'][$supplier->getId()]['id']   = $supplier_item->getId();
            $items[$current_id]['suppliers'][$supplier->getId()]['name'] = $supplier->getName();
            $items[$current_id]['suppliers'][$supplier->getId()]['qty']  = $supplier_item->getQuantityAvailable();
        }

        return $this->render(
            'default/overview.html.twig',
            [
                'items'     => $items,
                'suppliers' => $suppliers,
                'form'      => $this->form->createView(),
            ]
        );
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        if (empty($id)) {
            return $this->redirectToRoute('overview', [], 302);
        }

        $items = $this
            ->getDoctrine()
            ->getRepository('MedicineEntityBundle:Item')
            ->findById(intval($id))
        ;

        if (count($items) < 1) {
            return $this->redirectToRoute('overview', [], 302);
        }

        $item = reset($items);
        $supplier_items = $this
            ->getDoctrine()
            ->getRepository('MedicineEntityBundle:SupplierItem')
            ->findByItem($item->getId())
        ;

        $em = $this->getDoctrine()->getManager();
        foreach ($supplier_items as $supplier_item) {
            $em->remove($supplier_item);
        }

        $em->remove($item);
        $em->flush();

        return $this->redirectToRoute('overview', [], 302);
    }

    /**
     * @Route("/reduce/{id}/{qty}", name="reduce_qty")
     */
    public function reduceQtyAction($id, $qty)
    {
        $ret = ['result' => false];

        if (empty($id)) {
            return new JsonResponse($ret);
        }

        $supplier_items = $this
            ->getDoctrine()
            ->getRepository('MedicineEntityBundle:SupplierItem')
            ->findById($id)
        ;

        $supplier_item = reset($supplier_items);
        if ($supplier_item->getQuantityAvailable() >= intval($qty)) {
            $supplier_item->setQuantityAvailable(
                $supplier_item->getQuantityAvailable() -
                intval($qty)
            );

            $ret['result'] = true;
            $ret['qty'] = $supplier_item->getQuantityAvailable();
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new JsonResponse($ret);
    }

    /**
     * Setup $this->form object to its initial configuration.
     */
    public function setupItemForm()
    {
        $this->form = $this->createFormBuilder([])
            ->add('id', 'hidden')
            ->add('name', 'text')
            ->add('description', 'text', ['required' => false])
            ->add('stock_hospital', 'integer', ['label' => 'Stock hospital'])
            ->add('stock_private', 'integer', ['label' => 'Stock private'])
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
        try {
            $em   = $this->getDoctrine()->getManager();
            $data = $this->form->getData();

            // If optional parameter is not set
            if (!isset($data['description'])) {
                $data['description'] = '';
            }

            // Decide save | update
            if (isset($data['id']) && !empty($data['id'])) {
                $items = $this
                    ->getDoctrine()
                    ->getRepository('MedicineEntityBundle:Item')
                    ->findById($data['id'])
                ;

                $item = reset($items);
                $item
                    ->setName($data['name'])
                    ->setDescription($data['description'])
                ;
            } else {
                $item = new Item();
                $item
                    ->setName($data['name'])
                    ->setDescription($data['description'])
                ;

                // persist
                $em->persist($item);
            }

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

            // Remove supplier items before insert/update
            $supplier_items = $this
                ->getDoctrine()
                ->getRepository('MedicineEntityBundle:SupplierItem')
                ->findByItem($item->getId())
            ;

            foreach ($supplier_items as $supplier_item) {
                $em->remove($supplier_item);
            }
            $em->flush();

            // Set Supplier Item Availability
            $supplier_hospital_item = new SupplierItem();
            $supplier_hospital_item
                ->setSupplier($supplier_hospital[0])
                ->setItem($item)
                ->setQuantityAvailable($data['stock_hospital'])
            ;

            $supplier_private_item = new SupplierItem();
            $supplier_private_item
                ->setSupplier($supplier_private[0])
                ->setItem($item)
                ->setQuantityAvailable($data['stock_private'])
            ;

            // persist
            $em->persist($supplier_hospital_item);
            $em->persist($supplier_private_item);
            $em->flush();
        } catch (\Exception $e) {
            return false;
        }

        $this->setupItemForm();

        return true;
    }
}
