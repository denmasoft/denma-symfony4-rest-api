<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Identificador
 *
 * @ORM\Table(name="identificador")
 * @ORM\Entity(repositoryClass="App\Repository\IdentificadorRepository")
 */
class Identificador
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
     * @ORM\Column(name="clave", type="string", length=255, nullable=true)
     */
    private $clave;

    /**
     * @var string|null
     *
     * @ORM\Column(name="c1", type="string", length=255, nullable=true)
     */
    private $c1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="c2", type="string", length=255, nullable=true)
     */
    private $c2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="c3", type="string", length=255, nullable=true)
     */
    private $c3;

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
     * @ORM\ManyToMany(targetEntity="Partida", mappedBy="identificadorid")
     */
    private $partidaid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->partidaid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
