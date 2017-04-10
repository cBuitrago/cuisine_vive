<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Orden
 *
 * @ORM\Table(name="orden")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdenRepository")
 */
class Orden
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
     * @ORM\ManyToOne(targetEntity="FirstUser", inversedBy="ordenes")
     * @ORM\JoinColumn(name="firstUser", referencedColumnName="id", nullable=false)
     */
    private $firstUser;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOrder", type="datetime")
     */
    private $dateOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDelivery", type="datetime")
     */
    private $dateDelivery;

    /**
     * @var string
     *
     * @ORM\Column(name="payType", type="string", length=255)
     */
    private $payType;
    
    /**
     * @ORM\OneToMany(targetEntity="OrdenDishPortion", mappedBy="orden", cascade={"persist", "remove"})
     */
    private $items;

    public function __construct() {
        $this->items = new ArrayCollection();
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
     * Set dateOrder
     *
     * @param \DateTime $dateOrder
     *
     * @return Orden
     */
    public function setDateOrder($dateOrder)
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    /**
     * Get dateOrder
     *
     * @return \DateTime
     */
    public function getDateOrder()
    {
        return $this->dateOrder;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Orden
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateDelivery
     *
     * @param \DateTime $dateDelivery
     *
     * @return Orden
     */
    public function setDateDelivery($dateDelivery)
    {
        $this->dateDelivery = $dateDelivery;

        return $this;
    }

    /**
     * Get dateDelivery
     *
     * @return \DateTime
     */
    public function getDateDelivery()
    {
        return $this->dateDelivery;
    }

    /**
     * Set payType
     *
     * @param string $payType
     *
     * @return Orden
     */
    public function setPayType($payType)
    {
        $this->payType = $payType;

        return $this;
    }

    /**
     * Get payType
     *
     * @return string
     */
    public function getPayType()
    {
        return $this->payType;
    }

    /**
     * Set firstUser
     *
     * @param \AppBundle\Entity\FirstUser $firstUser
     *
     * @return Orden
     */
    public function setFirstUser(\AppBundle\Entity\FirstUser $firstUser)
    {
        $this->firstUser = $firstUser;

        return $this;
    }

    /**
     * Get firstUser
     *
     * @return \AppBundle\Entity\FirstUser
     */
    public function getFirstUser()
    {
        return $this->firstUser;
    }

    /**
     * Add item
     *
     * @param \AppBundle\Entity\OrdenDishPortion $item
     *
     * @return Orden
     */
    public function addItem(\AppBundle\Entity\OrdenDishPortion $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\OrdenDishPortion $item
     */
    public function removeItem(\AppBundle\Entity\OrdenDishPortion $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
