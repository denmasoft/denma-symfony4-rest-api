<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bonoprenda
 *
 * @ORM\Table(name="BonoPrenda", indexes={@ORM\Index(name="FKBonoPrenda297527", columns={"CertificadoId"})})
 * @ORM\Entity(repositoryClass="App\Repository\BonoPrendaRepository")
 */
class Bonoprenda
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
     * @ORM\Column(name="entidad", type="string", length=255, nullable=true)
     */
    private $entidad;

    /**
     * @var float|null
     *
     * @ORM\Column(name="importe", type="float", precision=10, scale=0, nullable=true)
     */
    private $importe;

    /**
     * @var int|null
     *
     * @ORM\Column(name="factor_moneda", type="integer", nullable=true)
     */
    private $factorMoneda;

    /**
     * @var int|null
     *
     * @ORM\Column(name="interes", type="integer", nullable=true)
     */
    private $interes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="vencimiento", type="integer", nullable=true)
     */
    private $vencimiento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adeudos", type="string", length=255, nullable=true)
     */
    private $adeudos;

    /**
     * @var string|null
     *
     * @ORM\Column(name="anticipos", type="string", length=255, nullable=true)
     */
    private $anticipos;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lugar_expedicion1", type="string", length=255, nullable=true)
     */
    private $lugarExpedicion1;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_expedicion1", type="date", nullable=true)
     */
    private $fechaExpedicion1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lugar_expedicion2", type="string", length=255, nullable=true)
     */
    private $lugarExpedicion2;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_expedicion2", type="date", nullable=true)
     */
    private $fechaExpedicion2;

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
     * @var \Certificado
     *
     * @ORM\ManyToOne(targetEntity="Certificado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CertificadoId", referencedColumnName="Id")
     * })
     */
    private $certificadoid;


}
