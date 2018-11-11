<?php

namespace Fos\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * companies
 *
 * @ORM\Table(name="companies")
 * @ORM\Entity(repositoryClass="Fos\MainBundle\Repository\companiesRepository")
 */
class companies
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
     * @return companies
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
     * @return companies
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
}
