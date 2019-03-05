<?php

namespace App\Controller;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Proveedor;

/**
 * Class ProveedorController

 * @Route("/api/v1/proveedor")
 */
class ProveedorController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="proveedor_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los proveedores."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de proveedores."
     * )
     *
     * @SWG\Tag(name="Proveedor")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getProveedorAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $proveedores  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $proveedores = $em->getRepository("App:Proveedor")->findAll();

            if (is_null($proveedores))
                $proveedores = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los proveedores: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los proveedores: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $proveedores : $response, "json"), $code);

        return $response;//
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_proveedor", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea un nuevo proveedor."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un proveedor."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del proveedor.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="domicilio",
     *     in="body",
     *     type="string",
     *     description="Domicilio del proveedor",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="denominacion_social",
     *     in="body",
     *     type="string",
     *     description="Denominacion Social del proveedor",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="id_fiscal",
     *     in="body",
     *     type="string",
     *     description="Id Fiscal del proveedor",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Proveedor")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postProveedorAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $proveedor = new Proveedor();
            $proveedor->setNombre($request->get('nombre'));
            $proveedor->setDomicilio($request->get('domicilio'));
            $proveedor->setDenominacionSocial($request->get('denominacion_social'));
            $proveedor->setIdFiscal($request->get('id_fiscal'));
            $em->persist($proveedor);
            $em->flush();
            $data = $proveedor;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un proveedor: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el proveedor: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_inpc", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un inpc"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un inpc."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del proveedor.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="domicilio",
     *     in="body",
     *     type="string",
     *     description="Domicilio del proveedor",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="denominacion_social",
     *     in="body",
     *     type="string",
     *     description="Denominacion Social del proveedor",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="id_fiscal",
     *     in="body",
     *     type="string",
     *     description="Id Fiscal del proveedor",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Proveedor")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putProveedorAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";
        try {
            $code = 200;
            $error = false;
            $proveedor = $em->getRepository('App:Proveedor')->find($id);
            if (!$proveedor)
                throw new Exception("Proveedor no existe.");
            if ($request->get('nombre'))
                $proveedor->setNombre($request->get('nombre'));
            if ($request->get('domicilio'))
                $proveedor->setDomicilio($request->get('domicilio'));
            if ($request->get('denominacion_social'))
                $proveedor->setDenominacionSocial($request->get('denominacion_social'));
            if ($request->get('id_fiscal'))
                $proveedor->setIdFiscal($request->get('id_fiscal'));
            $em->persist($proveedor);
            $em->flush();
            $data = $proveedor;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el proveedor: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el proveedor: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}