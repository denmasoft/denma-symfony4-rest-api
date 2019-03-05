<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoActualizacion
 *
 * @ORM\Table(name="Tipo_actualizacion")
 * @ORM\Entity(repositoryClass="App\Repository\TipoActualizacionRepository")
 */
class TipoActualizacion
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

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Pedimento", mappedBy="tipoActualizacionid")
     */
    private $pedimentoid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pedimentoid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
