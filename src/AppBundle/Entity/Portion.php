<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Portion
 *
 * @ORM\Table(name="portion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PortionRepository")
 */
class Portion
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
     * @ORM\OneToMany(targetEntity="PortionLanguage", mappedBy="portion")
     */
    private $languages;
    
    /**
     * @ORM\OneToMany(targetEntity="DishPortion", mappedBy="portion")
     */
    private $dishes;

    public function __construct() {
        $this->languages = new ArrayCollection();
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
     * @return Portion
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
     * Add language
     *
     * @param \AppBundle\Entity\PortionLanguage $language
     *
     * @return Portion
     */
    public function addLanguage(\AppBundle\Entity\PortionLanguage $language)
    {
        $this->languages[] = $language;

        return $this;
    }

    /**
     * Remove language
     *
     * @param \AppBundle\Entity\PortionLanguage $language
     */
    public function removeLanguage(\AppBundle\Entity\PortionLanguage $language)
    {
        $this->languages->removeElement($language);
    }

    /**
     * Get languages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Add dish
     *
     * @param \AppBundle\Entity\DishPortion $dish
     *
     * @return Portion
     */
    public function addDish(\AppBundle\Entity\DishPortion $dish)
    {
        $this->dishes[] = $dish;

        return $this;
    }

    /**
     * Remove dish
     *
     * @param \AppBundle\Entity\DishPortion $dish
     */
    public function removeDish(\AppBundle\Entity\DishPortion $dish)
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
