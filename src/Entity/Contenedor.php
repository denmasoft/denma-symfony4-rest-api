<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contenedor
 *
 * @ORM\Table(name="Contenedor")
 * @ORM\Entity(repositoryClass="App\Repository\ContenedorRepository")
 */
class Contenedor
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
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

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
