<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartidaPermiso
 *
 * @ORM\Table(name="partida_permiso", indexes={@ORM\Index(name="FKpartida_pe157997", columns={"partidaid"}), @ORM\Index(name="FKpartida_pe946417", columns={"tipoPermisoid"})})
 * @ORM\Entity(repositoryClass="App\Repository\PartidaPermisoRepository")
 */
class PartidaPermiso
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero", type="string", length=255, nullable=true)
     */
    private $numero;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firma", type="string", length=255, nullable=true)
     */
    private $firma;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor", type="float", precision=10, scale=0, nullable=true)
     */
    private $valor;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="aplica", type="boolean", nullable=true)
     */
    private $aplica;

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
     * @var \Partida
     *
     * @ORM\ManyToOne(targetEntity="Partida")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="partidaid", referencedColumnName="id")
     * })
     */
    private $partidaid;

    /**
     * @var \Tipopermiso
     *
     * @ORM\ManyToOne(targetEntity="Tipopermiso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoPermisoid", referencedColumnName="id")
     * })
     */
    private $tipopermisoid;


}
