<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartidaValor
 *
 * @ORM\Table(name="partida_valor", indexes={@ORM\Index(name="FKpartida_va788089", columns={"partidaid"}), @ORM\Index(name="FKpartida_va534495", columns={"MonedaId"})})
 * @ORM\Entity(repositoryClass="App\Repository\PartidaValorRepository")
 */
class PartidaValor
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
     * @var string|null
     *
     * @ORM\Column(name="equivalencia_moneda", type="string", length=255, nullable=true)
     */
    private $equivalenciaMoneda;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_moneda_extranjera", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorMonedaExtranjera;

    /**
     * @var float|null
     *
     * @ORM\Column(name="precio_unitario", type="float", precision=10, scale=0, nullable=true)
     */
    private $precioUnitario;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_dolares", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorDolares;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_aduana", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorAduana;

    /**
     * @var float|null
     *
     * @ORM\Column(name="precio_pagado", type="float", precision=10, scale=0, nullable=true)
     */
    private $precioPagado;

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
     * @var \Partida
     *
     * @ORM\ManyToOne(targetEntity="Partida")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="partidaid", referencedColumnName="id")
     * })
     */
    private $partidaid;


}
