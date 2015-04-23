<?php

namespace Medicine\Entity\Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Medicine\Entity\Bundle\Entity\Supplier;

class LoadSuppliers extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $hospital_supplier = new Supplier();
        $hospital_supplier
            ->setName('Hospital')
        ;

        $private_supplier = new Supplier();
        $private_supplier
            ->setName('Private')
        ;

        $manager->persist($hospital_supplier);
        $manager->persist($private_supplier);
        $manager->flush();

        $this->addReference('supplier-hospital', $hospital_supplier);
        $this->addReference('supplier-private', $private_supplier);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}
