<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DishLanguage
 *
 * @ORM\Table(name="dish_language")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DishLanguageRepository")
 */
class DishLanguage
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
     * @ORM\ManyToOne(targetEntity="Dish", inversedBy="languages")
     * @ORM\JoinColumn(name="dish", referencedColumnName="id", nullable=false)
     */
    private $dish;

    /**
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="dishes")
     * @ORM\JoinColumn(name="language", referencedColumnName="id", nullable=false)
     */
    private $language;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ingredients", type="text")
     */
    private $ingredients;


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
     * @return DishLanguage
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
     * Set language
     *
     * @param integer $language
     *
     * @return DishLanguage
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return int
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return DishLanguage
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ingredients
     *
     * @param string $ingredients
     *
     * @return DishLanguage
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    /**
     * Get ingredients
     *
     * @return string
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return DishLanguage
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
}
