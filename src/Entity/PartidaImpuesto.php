<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartidaImpuesto
 *
 * @ORM\Table(name="partida_impuesto", indexes={@ORM\Index(name="FKpartida_im358278", columns={"partidaid"}), @ORM\Index(name="FKpartida_im397409", columns={"tipo_impuestoid"})})
 * @ORM\Entity(repositoryClass="App\Repository\PartidaImpuestoRepository")
 */
class PartidaImpuesto
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
     * @ORM\Column(name="tasa", type="integer", nullable=true)
     */
    private $tasa;

    /**
     * @var int|null
     *
     * @ORM\Column(name="fp", type="integer", nullable=true)
     */
    private $fp;

    /**
     * @var float|null
     *
     * @ORM\Column(name="importe", type="float", precision=10, scale=0, nullable=true)
     */
    private $importe;

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
     * @var \TipoImpuesto
     *
     * @ORM\ManyToOne(targetEntity="TipoImpuesto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_impuestoid", referencedColumnName="id")
     * })
     */
    private $tipoImpuestoid;


}
