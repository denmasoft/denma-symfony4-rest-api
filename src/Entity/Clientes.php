<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Clientes
 *
 * @ORM\Table(name="Clientes")
 * @ORM\Entity(repositoryClass="App\Repository\ClientesRepository")
 */
class Clientes
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
     * @var string|null
     *
     * @ORM\Column(name="calle", type="string", length=255, nullable=true)
     */
    private $calle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="num_interior", type="string", length=255, nullable=true)
     */
    private $num_interior;

    /**
     * @var string|null
     *
     * @ORM\Column(name="num_exterior", type="string", length=255, nullable=true)
     */
    private $num_exterior;

    /**
     * @var string|null
     *
     * @ORM\Column(name="colonia", type="string", length=255, nullable=true)
     */
    private $colonia;

    /**
     * @var int
     *
     * @ORM\Column(name="cp", type="integer", nullable=true)
     */
    private $cp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="municipio", type="string", length=255, nullable=true)
     */
    private $municipio;

    /**
     * @var string|null
     *
     * @ORM\Column(name="entidad", type="string", length=255, nullable=true)
     */
    private $entidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pais", type="string", length=255, nullable=true)
     */
    private $pais;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rfc", type="string", length=255, nullable=true)
     */
    private $rfc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="curp", type="string", length=255, nullable=true)
     */
    private $curp;

    /**
     * @var int
     *
     * @ORM\Column(name="tel1", type="integer", nullable=true)
     */
    private $tel1;

    /**
     * @var int
     *
     * @ORM\Column(name="tel2", type="integer", nullable=true)
     */
    private $tel2;

    /**
     * @var int
     *
     * @ORM\Column(name="fax", type="integer", nullable=true)
     */
    private $fax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fecha", type="string", length=255, nullable=true)
     */
    private $fecha;

    /**
     * @var string|null
     *
     * @ORM\Column(name="estatus", type="string", length=255, nullable=true)
     */
    private $estatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="id_promotor", type="string", length=255, nullable=true)
     */
    private $id_promotor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="id_logistico", type="string", length=255, nullable=true)
     */
    private $id_logistico;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_tesoreria", type="string", length=255, nullable=true)
     */
    private $email_tesoreria;


    /**
     * @var string|null
     *
     * @ORM\Column(name="fecha_constitucion", type="string", length=255, nullable=true)
     */
    private $fecha_constitucion;


    /**
     * @var string|null
     *
     * @ORM\Column(name="domicilio_correspondencia", type="string", length=255, nullable=true)
     */
    private $domicilio_correspondencia;


    /**
     * @var string|null
     *
     * @ORM\Column(name="propietario", type="string", length=255, nullable=true)
     */
    private $propietario;


    /**
     * @var string|null
     *
     * @ORM\Column(name="razon", type="string", length=255, nullable=true)
     */
    private $razon;

    /**
     * @var string|null
     *
     * @ORM\Column(name="escritura", type="string", length=255, nullable=true)
     */
    private $escritura;

    /**
     * @var string|null
     *
     * @ORM\Column(name="notaria", type="string", length=255, nullable=true)
     */
    private $notaria;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lugar", type="string", length=255, nullable=true)
     */
    private $lugar;

    /**
     * @var int
     *
     * @ORM\Column(name="id_banco", type="integer",nullable=true)
     */
    private $id_banco;

    /**
     * @var int
     *
     * @ORM\Column(name="id_pago", type="integer",nullable=true)
     */
    private $id_pago;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cuenta", type="string", length=255, nullable=true)
     */
    private $cuenta;

    /**
     * @var float|null
     *
     * @ORM\Column(name="impuesto", type="float", nullable=true)
     */
    private $impuesto;

    /**
     * @var float|null
     *
     * @ORM\Column(name="certificacion", type="float", nullable=true)
     */
    private $certificacion;


    /**
     * @var float|null
     *
     * @ORM\Column(name="servicio", type="float", nullable=true)
     */
    private $servicio;

    /**
     * @var int|null
     *
     * @ORM\Column(name="rap", type="integer", nullable=true)
     */
    private $rap;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proveedor", mappedBy="id_cliente")
     * @Serializer\Exclude()
     */
    protected $proveedores;




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

    public function __construct()
    {
        $this->proveedores = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getProveedores()
    {
        return $this->proveedores;
    }

    /**
     * @param mixed $proveedores
     */
    public function setProveedores($proveedores)
    {
        $this->proveedores = $proveedores;
    }


}
