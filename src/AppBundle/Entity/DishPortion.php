<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DishPortion
 *
 * @ORM\Table(name="dish_portion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DishPortionRepository")
 */
class DishPortion
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
     * @ORM\ManyToOne(targetEntity="Dish", inversedBy="portions", cascade={"persist"})
     * @ORM\JoinColumn(name="dish", referencedColumnName="id", nullable=false)
     */
    private $dish;

    /**
     * @ORM\ManyToOne(targetEntity="Portion", inversedBy="dishes", cascade={"persist"})
     * @ORM\JoinColumn(name="portion", referencedColumnName="id", nullable=false)
     */
    private $portion;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="lastPrice", type="float", nullable=true)
     */
    private $lastPrice;


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
     * Set dish
     *
     * @param integer $dish
     *
     * @return DishPortion
     */
    public function setDish($dish)
    {
        $this->dish = $dish;

        return $this;
    }

    /**
     * Get dish
     *
     * @return int
     */
    public function getDish()
    {
        return $this->dish;
    }

    /**
     * Set portion
     *
     * @param integer $portion
     *
     * @return DishPortion
     */
    public function setPortion($portion)
    {
        $this->portion = $portion;

        return $this;
    }

    /**
     * Get portion
     *
     * @return int
     */
    public function getPortion()
    {
        return $this->portion;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return DishPortion
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set lastPrice
     *
     * @param float $lastPrice
     *
     * @return DishPortion
     */
    public function setLastPrice($lastPrice)
    {
        $this->lastPrice = $lastPrice;

        return $this;
    }

    /**
     * Get lastPrice
     *
     * @return float
     */
    public function getLastPrice()
    {
        return $this->lastPrice;
    }
}
