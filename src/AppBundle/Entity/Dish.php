<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Dish
 *
 * @ORM\Table(name="dish")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DishRepository")
 */
class Dish
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
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="dish")
     * @ORM\JoinColumn(name="category", referencedColumnName="id", nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean", unique=false)
     */
    private $isActive;
    
    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isDishWeek", type="boolean", unique=false)
     */
    private $isDishWeek;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity="DishLanguage", mappedBy="dish")
     */
    private $languages;
    
    /**
     * @ORM\OneToMany(targetEntity="DishPortion", mappedBy="dish")
     */
    private $portions;
    
    /**
     * @ORM\OneToMany(targetEntity="DishIcon", mappedBy="dish")
     */
    private $icons;

    public function __construct() {
        $this->languages = new ArrayCollection();
        $this->portions = new ArrayCollection();
        $this->icons = new ArrayCollection();
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
     * Set category
     *
     * @param integer $category
     *
     * @return Dish
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Dish
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
     * Set photo
     *
     * @param string $photo
     *
     * @return Dish
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Dish
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     *
     * @return Dish
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set isDishWeek
     *
     * @param boolean $isDishWeek
     *
     * @return Dish
     */
    public function setIsDishWeek($isDishWeek)
    {
        $this->isDishWeek = $isDishWeek;

        return $this;
    }

    /**
     * Get isDishWeek
     *
     * @return boolean
     */
    public function getIsDishWeek()
    {
        return $this->isDishWeek;
    }

    /**
     * Add language
     *
     * @param \AppBundle\Entity\DishLanguage $language
     *
     * @return Dish
     */
    public function addLanguage(\AppBundle\Entity\DishLanguage $language)
    {
        $this->languages[] = $language;

        return $this;
    }

    /**
     * Remove language
     *
     * @param \AppBundle\Entity\DishLanguage $language
     */
    public function removeLanguage(\AppBundle\Entity\DishLanguage $language)
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
     * Add portion
     *
     * @param \AppBundle\Entity\DishPortion $portion
     *
     * @return Dish
     */
    public function addPortion(\AppBundle\Entity\DishPortion $portion)
    {
        $this->portions[] = $portion;

        return $this;
    }

    /**
     * Remove portion
     *
     * @param \AppBundle\Entity\DishPortion $portion
     */
    public function removePortion(\AppBundle\Entity\DishPortion $portion)
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

    /**
     * Add icon
     *
     * @param \AppBundle\Entity\DishIcon $icon
     *
     * @return Dish
     */
    public function addIcon(\AppBundle\Entity\DishIcon $icon)
    {
        $this->icons[] = $icon;

        return $this;
    }

    /**
     * Remove icon
     *
     * @param \AppBundle\Entity\DishIcon $icon
     */
    public function removeIcon(\AppBundle\Entity\DishIcon $icon)
    {
        $this->icons->removeElement($icon);
    }

    /**
     * Get icons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIcons()
    {
        return $this->icons;
    }
}
