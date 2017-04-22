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
     * @var boolean
     *
     * @ORM\Column(name="inCash", type="boolean", unique=false)
     */
    private $inCash;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="inSitu", type="boolean", unique=false)
     */
    private $inSitu;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255 , nullable=false)
     */
    private $tel;
    
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255 , nullable=true)
     */
    private $address;
    
    /**
     * @var string
     *
     * @ORM\Column(name="zipCode", type="string", length=10 , nullable=true)
     */
    private $zipCode;
    
    /**
     * @var float
     *
     * @ORM\Column(name="deliPrice", type="decimal", precision=8, scale=2)
     */
    private $deliPrice;
    
    /**
     * @var float
     *
     * @ORM\Column(name="totalUser", type="decimal", precision=8, scale=2)
     */
    private $userPrice;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="totalCalculate", type="decimal", precision=8, scale=2)
     */
    private $calculatePrice;
    
    /**
     * @var text
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;
    
    
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

    /**
     * Set inCash
     *
     * @param boolean $inCash
     *
     * @return Orden
     */
    public function setInCash($inCash)
    {
        $this->inCash = $inCash;

        return $this;
    }

    /**
     * Get inCash
     *
     * @return boolean
     */
    public function getInCash()
    {
        return $this->inCash;
    }

    /**
     * Set inSitu
     *
     * @param boolean $inSitu
     *
     * @return Orden
     */
    public function setInSitu($inSitu)
    {
        $this->inSitu = $inSitu;

        return $this;
    }

    /**
     * Get inSitu
     *
     * @return boolean
     */
    public function getInSitu()
    {
        return $this->inSitu;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Orden
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
     * Set address
     *
     * @param string $address
     *
     * @return Orden
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return Orden
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set deliPrice
     *
     * @param integer $deliPrice
     *
     * @return Orden
     */
    public function setDeliPrice($deliPrice)
    {
        $this->deliPrice = $deliPrice;

        return $this;
    }

    /**
     * Get deliPrice
     *
     * @return integer
     */
    public function getDeliPrice()
    {
        return $this->deliPrice;
    }

    /**
     * Set userPrice
     *
     * @param string $userPrice
     *
     * @return Orden
     */
    public function setUserPrice($userPrice)
    {
        $this->userPrice = $userPrice;

        return $this;
    }

    /**
     * Get userPrice
     *
     * @return string
     */
    public function getUserPrice()
    {
        return $this->userPrice;
    }

    /**
     * Set calculatePrice
     *
     * @param string $calculatePrice
     *
     * @return Orden
     */
    public function setCalculatePrice($calculatePrice)
    {
        $this->calculatePrice = $calculatePrice;

        return $this;
    }

    /**
     * Get calculatePrice
     *
     * @return string
     */
    public function getCalculatePrice()
    {
        return $this->calculatePrice;
    }

    /**
     * Set comments
     *
     * @return Orden
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return text
     */
    public function getComments()
    {
        return $this->comments;
    }
}
