<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Please, upload the photo as a jpg, jpeg or png file.")
     * @Assert\File(mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *      })
     */
    private $image;

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

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Icon
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
