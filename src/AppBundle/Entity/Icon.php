<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Icon
 *
 * @ORM\Table(name="icon")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IconRepository")
 */
class Icon
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="DishIcon", mappedBy="icon")
     */
    private $dishes;

    public function __construct() {
        $this->dishes = new ArrayCollection();
    }
    
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
     * Set name
     *
     * @param string $name
     *
     * @return Icon
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add dish
     *
     * @param \AppBundle\Entity\DishIcon $dish
     *
     * @return Icon
     */
    public function addDish(\AppBundle\Entity\DishIcon $dish)
    {
        $this->dishes[] = $dish;

        return $this;
    }

    /**
     * Remove dish
     *
     * @param \AppBundle\Entity\DishIcon $dish
     */
    public function removeDish(\AppBundle\Entity\DishIcon $dish)
    {
        $this->dishes->removeElement($dish);
    }

    /**
     * Get dishes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDishes()
    {
        return $this->dishes;
    }
}
