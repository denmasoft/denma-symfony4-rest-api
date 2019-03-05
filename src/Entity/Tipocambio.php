<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipocambio
 *
 * @ORM\Table(name="TipoCambio")
 * @ORM\Entity(repositoryClass="App\Repository\TipoCambioRepository")
 */
class Tipocambio
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cambio", type="string", length=255, nullable=true)
     */
    private $cambio;

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
