<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Valores
 *
 * @ORM\Table(name="Valores")
 * @ORM\Entity(repositoryClass="App\Repository\ValoresRepository")
 */
class Valores
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
     * @var float|null
     *
     * @ORM\Column(name="dolares", type="float", precision=10, scale=0, nullable=true)
     */
    private $dolares;

    /**
     * @var float|null
     *
     * @ORM\Column(name="aduana", type="float", precision=10, scale=0, nullable=true)
     */
    private $aduana;

    /**
     * @var float|null
     *
     * @ORM\Column(name="comercial", type="float", precision=10, scale=0, nullable=true)
     */
    private $comercial;

    /**
     * @var int|null
     *
     * @ORM\Column(name="impuestos", type="integer", nullable=true)
     */
    private $impuestos;

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
     * @ORM\ManyToMany(targetEntity="Pedimento", mappedBy="valoresid")
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
