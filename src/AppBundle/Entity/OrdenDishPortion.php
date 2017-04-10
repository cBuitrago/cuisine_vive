<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrdenDishPortion
 *
 * @ORM\Table(name="orden_dish_portion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdenDishPortionRepository")
 */
class OrdenDishPortion
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
     * @ORM\ManyToOne(targetEntity="Orden", inversedBy="items", cascade={"persist"})
     * @ORM\JoinColumn(name="orden", referencedColumnName="id", nullable=false)
     */
    private $orden;

    /**
     * @ORM\ManyToOne(targetEntity="DishPortion", inversedBy="ordenes", cascade={"persist"})
     * @ORM\JoinColumn(name="dishPortion", referencedColumnName="id", nullable=false)
     */
    private $dishPortion;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return OrdenDishPortion
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return int
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set dishPortion
     *
     * @param integer $dishPortion
     *
     * @return OrdenDishPortion
     */
    public function setDishPortion($dishPortion)
    {
        $this->dishPortion = $dishPortion;

        return $this;
    }

    /**
     * Get dishPortion
     *
     * @return int
     */
    public function getDishPortion()
    {
        return $this->dishPortion;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return OrdenDishPortion
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
