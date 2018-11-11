<?php

namespace Fos\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * sas
 *
 * @ORM\Table(name="sas")
 * @ORM\Entity(repositoryClass="Fos\MainBundle\Repository\sasRepository")
 */
class sas
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
     * @var int
     *
     * @ORM\Column(name="siret", type="integer", unique=true)
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="denomination", type="string", length=255)
     */
    private $denomination;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255)
     */
    private $adress;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set siret.
     *
     * @param int $siret
     *
     * @return sas
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret.
     *
     * @return int
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set denomination.
     *
     * @param string $denomination
     *
     * @return sas
     */
    public function setDenomination($denomination)
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * Get denomination.
     *
     * @return string
     */
    public function getDenomination()
    {
        return $this->denomination;
    }

    /**
     * Set adress.
     *
     * @param string $adress
     *
     * @return sas
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress.
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }
}
