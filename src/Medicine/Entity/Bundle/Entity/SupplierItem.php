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
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="supplier_id", type="integer")
     */
    private $supplierId;

    /**
     * @var int
     *
     * @ORM\Column(name="item_id", type="integer")
     */
    private $itemId;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity_available", type="integer")
     */
    private $quantityAvailable;

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
     * Set supplierId.
     *
     * @param int $supplierId
     *
     * @return SupplierItem
     */
    public function setSupplierId($supplierId)
    {
        $this->supplierId = $supplierId;

        return $this;
    }

    /**
     * Get supplierId.
     *
     * @return int
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }

    /**
     * Set itemId.
     *
     * @param int $itemId
     *
     * @return SupplierItem
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId.
     *
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
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
