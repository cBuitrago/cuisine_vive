<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DishIcon
 *
 * @ORM\Table(name="dish_icon")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DishIconRepository")
 */
class DishIcon
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
     * @ORM\ManyToOne(targetEntity="Dish", inversedBy="icons", cascade={"persist"})
     * @ORM\JoinColumn(name="dish", referencedColumnName="id", nullable=false)
     */
    private $dish;
    
    /**
     * @ORM\ManyToOne(targetEntity="Icon", inversedBy="dishes", cascade={"persist"})
     * @ORM\JoinColumn(name="icon", referencedColumnName="id", nullable=false)
     */
    private $icon;


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
     * @return DishIcon
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
     * Set icon
     *
     * @param integer $icon
     *
     * @return DishIcon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return int
     */
    public function getIcon()
    {
        return $this->icon;
    }
}
