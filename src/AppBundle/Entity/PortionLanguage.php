<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PortionLanguage
 *
 * @ORM\Table(name="portion_language")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PortionLanguageRepository")
 */
class PortionLanguage
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
     * @ORM\ManyToOne(targetEntity="Portion", inversedBy="languages")
     * @ORM\JoinColumn(name="portion", referencedColumnName="id", nullable=false)
     */
    private $portion;

    /**
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="portions")
     * @ORM\JoinColumn(name="language", referencedColumnName="id", nullable=false)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
     * Set portion
     *
     * @param integer $portion
     *
     * @return PortionLanguage
     */
    public function setPortion($portion)
    {
        $this->portion = $portion;

        return $this;
    }

    /**
     * Get portion
     *
     * @return int
     */
    public function getPortion()
    {
        return $this->portion;
    }

    /**
     * Set language
     *
     * @param integer $language
     *
     * @return PortionLanguage
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
     * Set name
     *
     * @param string $name
     *
     * @return PortionLanguage
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
     * Set description
     *
     * @param string $description
     *
     * @return PortionLanguage
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
}
