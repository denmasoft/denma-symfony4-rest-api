<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Factura
 *
 * @ORM\Table(name="Factura", indexes={@ORM\Index(name="FKFactura270209", columns={"ProveedorId"}), @ORM\Index(name="FKFactura197590", columns={"MonedaId"}), @ORM\Index(name="FKFactura299704", columns={"IncotermId"})})
 * @ORM\Entity(repositoryClass="App\Repository\FacturaRepository")
 */
class Factura
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_me", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorMe;

    /**
     * @var int|null
     *
     * @ORM\Column(name="factor_me", type="integer", nullable=true)
     */
    private $factorMe;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_usd", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorUsd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cove", type="string", length=255, nullable=true)
     */
    private $cove;

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
     * @var \Moneda
     *
     * @ORM\ManyToOne(targetEntity="Moneda")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="MonedaId", referencedColumnName="Id")
     * })
     */
    private $monedaid;

    /**
     * @var \Proveedor
     *
     * @ORM\ManyToOne(targetEntity="Proveedor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ProveedorId", referencedColumnName="Id")
     * })
     */
    private $proveedorid;

    /**
     * @var \Incoterm
     *
     * @ORM\ManyToOne(targetEntity="Incoterm")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IncotermId", referencedColumnName="Id")
     * })
     */
    private $incotermid;


}
