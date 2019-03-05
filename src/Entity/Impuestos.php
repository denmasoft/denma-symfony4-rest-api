<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Impuestos
 *
 * @ORM\Table(name="Impuestos")
 * @ORM\Entity(repositoryClass="App\Repository\ImpuestosRepository")
 */
class Impuestos
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="dta", type="integer", nullable=true)
     */
    private $dta;

    /**
     * @var int|null
     *
     * @ORM\Column(name="igi", type="integer", nullable=true)
     */
    private $igi;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ieps", type="integer", nullable=true)
     */
    private $ieps;

    /**
     * @var int|null
     *
     * @ORM\Column(name="azucar", type="integer", nullable=true)
     */
    private $azucar;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cuota_c", type="integer", nullable=true)
     */
    private $cuotaC;

    /**
     * @var int|null
     *
     * @ORM\Column(name="mt", type="integer", nullable=true)
     */
    private $mt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="iva", type="integer", nullable=true)
     */
    private $iva;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdat;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedat;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Pedimento", mappedBy="impuestosid")
     */
    private $pedimentoid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pedimentoid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
