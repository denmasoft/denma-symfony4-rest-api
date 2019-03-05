<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fraccion
 *
 * @ORM\Table(name="Fraccion")
 * @ORM\Entity(repositoryClass="App\Repository\FraccionRepository")
 */
class Fraccion
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
     * @var int|null
     *
     * @ORM\Column(name="nombre", nullable=true)
     */
    private $fraccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;


    /**
     * @var int|null
     *
     * @ORM\Column(name="prohibida",type="integer", nullable=true)
     */
    private $prohibida;


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
