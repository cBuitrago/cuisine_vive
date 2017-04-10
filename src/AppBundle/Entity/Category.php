<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CategoryLanguage;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category {

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
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     * @Assert\NotBlank(message="Please, upload the photo as a jpg, jpeg or png file.")
     * @Assert\File(mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *      })
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity="Dish", mappedBy="category", cascade={"persist", "remove"})
     */
    private $dishes;

    /**
     * @ORM\OneToMany(targetEntity="CategoryLanguage", mappedBy="category", cascade={"persist", "remove"})
     */
    private $languages;

    public function __construct() {
        $this->languages = new ArrayCollection();
        $this->dishes = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Category
     */
    public function setPhoto($photo) {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto() {
        return $this->photo;
    }

    /**
     * Add dish
     *
     * @param \AppBundle\Entity\Dish $dish
     *
     * @return Category
     */
    public function addDish(\AppBundle\Entity\Dish $dish) {
        $this->dishes[] = $dish;

        return $this;
    }

    /**
     * Remove dish
     *
     * @param \AppBundle\Entity\Dish $dish
     */
    public function removeDish(\AppBundle\Entity\Dish $dish) {
        $this->dishes->removeElement($dish);
    }

    /**
     * Get dishes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDishes() {
        return $this->dishes;
    }

    /**
     * Add language
     *
     * @param \AppBundle\Entity\CategoryLanguage $language
     *
     * @return Category
     */
    public function addLanguage(\AppBundle\Entity\CategoryLanguage $language) {
        $language->setCategory($this);
        $this->languages[] = $language;

        return $this;
    }

    /**
     * Remove language
     *
     * @param \AppBundle\Entity\CategoryLanguage $language
     */
    public function removeLanguage(\AppBundle\Entity\CategoryLanguage $language) {
        $this->languages->removeElement($language);
    }

    /**
     * Get languages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLanguages() {
        return $this->languages;
    }

}
