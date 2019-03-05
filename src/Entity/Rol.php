<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rol
 *
 * @ORM\Table(name="Rol")
 * @ORM\Entity(repositoryClass="App\Repository\RolRepository")
 */
class Rol
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

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
     * @ORM\ManyToMany(targetEntity="Permiso", inversedBy="rolid")
     * @ORM\JoinTable(name="rol_permiso",
     *   joinColumns={
     *     @ORM\JoinColumn(name="RolId", referencedColumnName="Id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="PermisoId", referencedColumnName="Id")
     *   }
     * )
     */
    private $permisoid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->permisoid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
