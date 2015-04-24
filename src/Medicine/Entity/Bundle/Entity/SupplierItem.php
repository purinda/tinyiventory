<?php

namespace Medicine\Entity\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupplierItem.
 *
 * @ORM\Table(name="supplier_item")
 * @ORM\Entity(repositoryClass="Medicine\Entity\Bundle\Entity\SupplierItemRepository")
 */
class SupplierItem
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Supplier", inversedBy="supplierItems")
     */
    protected $supplier;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    protected $item;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity_available", type="integer")
     */
    protected $quantityAvailable;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set supplier.
     *
     * @param int $supplier
     *
     * @return SupplierItem
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier.
     *
     * @return int
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set item.
     *
     * @param int $item
     *
     * @return SupplierItem
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item.
     *
     * @return int
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set quantityAvailable.
     *
     * @param int $quantityAvailable
     *
     * @return SupplierItem
     */
    public function setQuantityAvailable($quantityAvailable)
    {
        $this->quantityAvailable = $quantityAvailable;

        return $this;
    }

    /**
     * Get quantityAvailable.
     *
     * @return int
     */
    public function getQuantityAvailable()
    {
        return $this->quantityAvailable;
    }
}
