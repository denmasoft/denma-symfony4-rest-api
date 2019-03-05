<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Certificado
 *
 * @ORM\Table(name="Certificado", indexes={@ORM\Index(name="FKCertificad771649", columns={"TipoMercanciaId"}), @ORM\Index(name="FKCertificad901403", columns={"ContenedorId"})})
 * @ORM\Entity(repositoryClass="App\Repository\CertificadoRepository")
 */
class Certificado
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
     * @var string|null
     *
     * @ORM\Column(name="ref", type="string", length=255, nullable=true)
     */
    private $ref;

    /**
     * @var string|null
     *
     * @ORM\Column(name="recibo_nacional", type="string", length=255, nullable=true)
     */
    private $reciboNacional;

    /**
     * @var string|null
     *
     * @ORM\Column(name="beneficiario", type="string", length=255, nullable=true)
     */
    private $beneficiario;

    /**
     * @var int|null
     *
     * @ORM\Column(name="vencimiento", type="integer", nullable=true)
     */
    private $vencimiento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sidef", type="string", length=255, nullable=true)
     */
    private $sidef;

    /**
     * @var string|null
     *
     * @ORM\Column(name="depositante", type="string", length=255, nullable=true)
     */
    private $depositante;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_entrada", type="date", nullable=true)
     */
    private $fechaEntrada;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bultos", type="string", length=255, nullable=true)
     */
    private $bultos;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor", type="float", precision=10, scale=0, nullable=true)
     */
    private $valor;

    /**
     * @var float|null
     *
     * @ORM\Column(name="peso", type="float", precision=10, scale=0, nullable=true)
     */
    private $peso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

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
     * @var bool|null
     *
     * @ORM\Column(name="negociable", type="boolean", nullable=true)
     */
    private $negociable;

    /**
     * @var int
     *
     * @ORM\Column(name="CertificadoId", type="bigint", nullable=false)
     */
    private $certificadoid;

    /**
     * @var \Tipomercancia
     *
     * @ORM\ManyToOne(targetEntity="Tipomercancia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TipoMercanciaId", referencedColumnName="Id")
     * })
     */
    private $tipomercanciaid;

    /**
     * @var \Contenedor
     *
     * @ORM\ManyToOne(targetEntity="Contenedor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ContenedorId", referencedColumnName="Id")
     * })
     */
    private $contenedorid;


}
