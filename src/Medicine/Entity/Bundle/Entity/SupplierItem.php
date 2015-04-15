<?php

namespace Medicine\Entity\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupplierItem
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Medicine\Entity\Bundle\Entity\SupplierItemRepository")
 */
class SupplierItem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="supplier_id", type="integer")
     */
    private $supplierId;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_id", type="integer")
     */
    private $itemId;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity_available", type="integer")
     */
    private $quantityAvailable;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set supplierId
     *
     * @param integer $supplierId
     * @return SupplierItem
     */
    public function setSupplierId($supplierId)
    {
        $this->supplierId = $supplierId;

        return $this;
    }

    /**
     * Get supplierId
     *
     * @return integer 
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }

    /**
     * Set itemId
     *
     * @param integer $itemId
     * @return SupplierItem
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return integer 
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set quantityAvailable
     *
     * @param integer $quantityAvailable
     * @return SupplierItem
     */
    public function setQuantityAvailable($quantityAvailable)
    {
        $this->quantityAvailable = $quantityAvailable;

        return $this;
    }

    /**
     * Get quantityAvailable
     *
     * @return integer 
     */
    public function getQuantityAvailable()
    {
        return $this->quantityAvailable;
    }
}
