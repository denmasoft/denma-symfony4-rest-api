<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Traspaso
 *
 * @ORM\Table(name="Traspaso", indexes={@ORM\Index(name="FKTraspaso377370", columns={"MovimientoId"})})
 * @ORM\Entity(repositoryClass="App\Repository\TraspasoRepository")
 */
class Traspaso
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bodega", type="string", length=255, nullable=true)
     */
    private $bodega;

    /**
     * @var string|null
     *
     * @ORM\Column(name="denominacion_social", type="string", length=255, nullable=true)
     */
    private $denominacionSocial;

    /**
     * @var int|null
     *
     * @ORM\Column(name="agente_aduanal", type="integer", nullable=true)
     */
    private $agenteAduanal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aduana_despacho", type="integer", nullable=true)
     */
    private $aduanaDespacho;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apoderado", type="string", length=255, nullable=true)
     */
    private $apoderado;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor", type="float", precision=10, scale=0, nullable=true)
     */
    private $valor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bodega_original", type="string", length=255, nullable=true)
     */
    private $bodegaOriginal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="patente", type="string", length=255, nullable=true)
     */
    private $patente;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firma_tl", type="string", length=255, nullable=true)
     */
    private $firmaTl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bodega_tl", type="string", length=255, nullable=true)
     */
    private $bodegaTl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="carta_cupo_original", type="string", length=255, nullable=true)
     */
    private $cartaCupoOriginal;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="updatedAt", type="integer", nullable=true)
     */
    private $updatedat;

    /**
     * @var \Movimiento
     *
     * @ORM\ManyToOne(targetEntity="Movimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="MovimientoId", referencedColumnName="Id")
     * })
     */
    private $movimientoid;


}
