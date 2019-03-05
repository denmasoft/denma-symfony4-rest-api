<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActaRecepcion
 *
 * @ORM\Table(name="acta_recepcion")
 * @ORM\Entity
 */
class ActaRecepcion
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
     * @ORM\Column(name="conductor", type="string", length=255, nullable=true)
     */
    private $conductor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="identificacion", type="string", length=255, nullable=true)
     */
    private $identificacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="testigo1", type="string", length=255, nullable=true)
     */
    private $testigo1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="testigo2", type="string", length=255, nullable=true)
     */
    private $testigo2;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="candados_fiscales", type="boolean", nullable=true)
     */
    private $candadosFiscales;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="sellos", type="boolean", nullable=true)
     */
    private $sellos;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="mercancia", type="boolean", nullable=true)
     */
    private $mercancia;

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


}
