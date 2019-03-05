<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedimento
 *
 * @ORM\Table(name="Pedimento")
 * @ORM\Entity(repositoryClass="App\Repository\PedimentoRepository")
 */
class Pedimento
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
     * @ORM\Column(name="recibo_deposito", type="string", length=255, nullable=true)
     */
    private $reciboDeposito;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tipo_cambio", type="string", length=255, nullable=true)
     */
    private $tipoCambio;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sidefi", type="string", length=255, nullable=true)
     */
    private $sidefi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="carta_cupo", type="string", length=255, nullable=true)
     */
    private $cartaCupo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pedimento", type="string", length=255, nullable=true)
     */
    private $pedimento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="denominacion_social", type="string", length=255, nullable=true)
     */
    private $denominacionSocial;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aduana_despacho", type="string", length=255, nullable=true)
     */
    private $aduanaDespacho;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aduana_entrada_salida", type="string", length=255, nullable=true)
     */
    private $aduanaEntradaSalida;

    /**
     * @var float|null
     *
     * @ORM\Column(name="peso_bruto", type="float", precision=10, scale=0, nullable=true)
     */
    private $pesoBruto;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_entrada", type="date", nullable=true)
     */
    private $fechaEntrada;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_pago", type="date", nullable=true)
     */
    private $fechaPago;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bultos", type="string", length=255, nullable=true)
     */
    private $bultos;

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
     * @var string|null
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var string|null
     *
     * @ORM\Column(name="referencias", type="string", length=255, nullable=true)
     */
    private $referencias;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tipo", type="string", length=3, nullable=true)
     */
    private $tipo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Impuestos", inversedBy="pedimentoid")
     * @ORM\JoinTable(name="pedimento_impuestos",
     *   joinColumns={
     *     @ORM\JoinColumn(name="PedimentoId", referencedColumnName="Id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ImpuestosId", referencedColumnName="Id")
     *   }
     * )
     */
    private $impuestosid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Incrementables", inversedBy="pedimentoid")
     * @ORM\JoinTable(name="pedimento_incrementables",
     *   joinColumns={
     *     @ORM\JoinColumn(name="PedimentoId", referencedColumnName="Id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="IncrementablesId", referencedColumnName="Id")
     *   }
     * )
     */
    private $incrementablesid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TipoActualizacion", inversedBy="pedimentoid")
     * @ORM\JoinTable(name="pedimento_tipo_actualizacion",
     *   joinColumns={
     *     @ORM\JoinColumn(name="PedimentoId", referencedColumnName="Id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Tipo_actualizacionId", referencedColumnName="Id")
     *   }
     * )
     */
    private $tipoActualizacionid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Valores", inversedBy="pedimentoid")
     * @ORM\JoinTable(name="pedimento_valores",
     *   joinColumns={
     *     @ORM\JoinColumn(name="PedimentoId", referencedColumnName="Id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ValoresId", referencedColumnName="Id")
     *   }
     * )
     */
    private $valoresid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->impuestosid = new \Doctrine\Common\Collections\ArrayCollection();
        $this->incrementablesid = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tipoActualizacionid = new \Doctrine\Common\Collections\ArrayCollection();
        $this->valoresid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
