<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalidaNacional
 *
 * @ORM\Table(name="SalidaNacional")
 * @ORM\Entity(repositoryClass="App\Repository\SalidaNacionalRepository")
 */
class SalidaNacional
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
     * @ORM\Column(name="recibo", type="string", length=255, nullable=true)
     */
    private $recibo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sidefi", type="string", length=255, nullable=true)
     */
    private $sidefi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="razonsocial", type="string",length=255, nullable=true)
     */
    private $razon_social;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observacion", type="string",length=255, nullable=true)
     */
    private $observacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modelo", type="string",length=255, nullable=true)
     */
    private $modelo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="complemento", type="string", length=255, nullable=true)
     */
    private $complemento;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="valor_mercancia", type="string", length=255, nullable=true)
     */
    private $valor_mercancia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="peso", type="string", length=255, nullable=true)
     */
    private $peso;

}
