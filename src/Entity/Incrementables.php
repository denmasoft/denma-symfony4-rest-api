<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Incrementables
 *
 * @ORM\Table(name="Incrementables")
 * @ORM\Entity(repositoryClass="App\Repository\IncrementablesRepository")
 */
class Incrementables
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
     * @ORM\Column(name="v_seguro", type="integer", nullable=true)
     */
    private $vSeguro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="seguros", type="integer", nullable=true)
     */
    private $seguros;

    /**
     * @var int|null
     *
     * @ORM\Column(name="fletes", type="integer", nullable=true)
     */
    private $fletes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="embalajes", type="integer", nullable=true)
     */
    private $embalajes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="otros", type="integer", nullable=true)
     */
    private $otros;

    /**
     * @var int|null
     *
     * @ORM\Column(name="factor", type="integer", nullable=true)
     */
    private $factor;

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
     * @ORM\ManyToMany(targetEntity="Pedimento", mappedBy="incrementablesid")
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
