<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partida
 *
 * @ORM\Table(name="partida")
 * @ORM\Entity(repositoryClass="App\Repository\PartidaRepository")
 */
class Partida
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="valor", type="integer", nullable=true)
     */
    private $valor;

    /**
     * @var int|null
     *
     * @ORM\Column(name="fraccion", type="integer", nullable=true)
     */
    private $fraccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var int|null
     *
     * @ORM\Column(name="umc", type="integer", nullable=true)
     */
    private $umc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="clave_umc", type="integer", nullable=true)
     */
    private $claveUmc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="umt", type="integer", nullable=true)
     */
    private $umt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="clave_umt", type="integer", nullable=true)
     */
    private $claveUmt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pais_vendedor", type="string", length=255, nullable=true)
     */
    private $paisVendedor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pais_origen", type="string", length=255, nullable=true)
     */
    private $paisOrigen;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="vinculacion", type="boolean", nullable=true)
     */
    private $vinculacion;

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
     * @ORM\ManyToMany(targetEntity="Identificador", inversedBy="partidaid")
     * @ORM\JoinTable(name="partida_identificador",
     *   joinColumns={
     *     @ORM\JoinColumn(name="partidaid", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="identificadorid", referencedColumnName="id")
     *   }
     * )
     */
    private $identificadorid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->identificadorid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
