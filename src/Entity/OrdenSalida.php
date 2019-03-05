<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrdenSalida
 *
 * @ORM\Table(name="OrdenSalida")
 * @ORM\Entity(repositoryClass="App\Repository\OrdenSalidaRepository")
 */
class OrdenSalida
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
    private $recibo_deposito;

    /**
     * @var string|null
     *
     * @ORM\Column(name="salida", type="string", length=255, nullable=true)
     */
    private $salida;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sidefi", type="string", length=255, nullable=true)
     */
    private $sidefi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fecha", type="string", length=255, nullable=true)
     */
    private $fecha;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pedimento_extraccion", type="string", length=255, nullable=true)
     */
    private $pedimento_extraccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pedimento_original", type="string", length=255, nullable=true)
     */
    private $pedimento_original;

    /**
     * @var string|null
     *
     * @ORM\Column(name="certificado", type="string",length=255, nullable=true)
     */
    private $certificado;

    /**
     * @var string|null
     *
     * @ORM\Column(name="importador", type="string",length=255, nullable=true)
     */
    private $importador;

    /**
     * @var string|null
     *
     * @ORM\Column(name="obs", type="string",length=255, nullable=true)
     */
    private $obs;
}
