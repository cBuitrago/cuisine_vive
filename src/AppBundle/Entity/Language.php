<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Language
 *
 * @ORM\Table(name="language")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LanguageRepository")
 */
class Language
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
     * @ORM\OneToMany(targetEntity="CategoryLanguage", mappedBy="language", cascade={"persist", "remove"})
     */
    private $categories;
    
    /**
     * @ORM\OneToMany(targetEntity="DishLanguage", mappedBy="language", cascade={"persist", "remove"})
     */
    private $dishes;
    
    /**
     * @ORM\OneToMany(targetEntity="PortionLanguage", mappedBy="language", cascade={"persist", "remove"})
     */
    private $portions;

    public function __construct() {
        $this->categories = new ArrayCollection();
        $this->dishes = new ArrayCollection();
        $this->portions = new ArrayCollection();
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
     * @return Language
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
     * Add category
     *
     * @param \AppBundle\Entity\CategoryLanguage $category
     *
     * @return Language
     */
    public function addCategory(\AppBundle\Entity\CategoryLanguage $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\CategoryLanguage $category
     */
    public function removeCategory(\AppBundle\Entity\CategoryLanguage $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add dish
     *
     * @param \AppBundle\Entity\DishLanguage $dish
     *
     * @return Language
     */
    public function addDish(\AppBundle\Entity\DishLanguage $dish)
    {
        $this->dishes[] = $dish;

        return $this;
    }

    /**
     * Remove dish
     *
     * @param \AppBundle\Entity\DishLanguage $dish
     */
    public function removeDish(\AppBundle\Entity\DishLanguage $dish)
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

    /**
     * Add portion
     *
     * @param \AppBundle\Entity\PortionLanguage $portion
     *
     * @return Language
     */
    public function addPortion(\AppBundle\Entity\PortionLanguage $portion)
    {
        $this->portions[] = $portion;

        return $this;
    }

    /**
     * Remove portion
     *
     * @param \AppBundle\Entity\PortionLanguage $portion
     */
    public function removePortion(\AppBundle\Entity\PortionLanguage $portion)
    {
        $this->portions->removeElement($portion);
    }

    /**
     * Get portions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPortions()
    {
        return $this->portions;
    }
}
