<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * FirstUser
 *
 * @ORM\Table(name="first_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FirstUserRepository")
 */
class FirstUser
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
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255 , nullable=true)
     */
    private $tel;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="newsletter", type="boolean", unique=false, nullable=true)
     */
    private $newsletter;
    
    /**
     * @ORM\OneToMany(targetEntity="Orden", mappedBy="firstUser", cascade={"persist", "remove"})
     */
    private $ordenes;

    public function __construct() {
        $this->ordenes = new ArrayCollection();
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
     * Set email
     *
     * @param string $email
     *
     * @return FirstUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return FirstUser
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
     * Set tel
     *
     * @param string $tel
     *
     * @return FirstUser
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Add ordene
     *
     * @param \AppBundle\Entity\Orden $ordene
     *
     * @return FirstUser
     */
    public function addOrdene(\AppBundle\Entity\Orden $ordene)
    {
        $this->ordenes[] = $ordene;

        return $this;
    }

    /**
     * Remove ordene
     *
     * @param \AppBundle\Entity\Orden $ordene
     */
    public function removeOrdene(\AppBundle\Entity\Orden $ordene)
    {
        $this->ordenes->removeElement($ordene);
    }

    /**
     * Get ordenes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrdenes()
    {
        return $this->ordenes;
    }

    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     *
     * @return FirstUser
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return boolean
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
}
