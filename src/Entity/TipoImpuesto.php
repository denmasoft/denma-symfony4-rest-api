<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoImpuesto
 *
 * @ORM\Table(name="tipo_impuesto")
 * @ORM\Entity(repositoryClass="App\Repository\TipoImpuestoRepository")
 */
class TipoImpuesto
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
     * @ORM\Column(name="impuesto", type="string", length=255, nullable=true)
     */
    private $impuesto;

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
