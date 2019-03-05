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
use App\Entity\Factura;

/**
 * Class FacturaController

 * @Route("/api/v1/factura")
 */
class FacturaController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="factura_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas las facturas."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de facturas."
     * )
     *
     * @SWG\Tag(name="Factura")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getFacturaAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $facturas  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $facturas = $em->getRepository("App:Factura")->findAll();

            if (is_null($facturas))
                $facturas = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener las facturas: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos las facturas: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $facturas : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_factura", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea una nueva factura."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear una factura."
     * )
     *
     * @SWG\Parameter(
     *     name="ref",
     *     in="body",
     *     type="string",
     *     description="Factura.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="cove",
     *     in="body",
     *     type="string",
     *     description="COVE.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fecha",
     *     in="body",
     *     type="string",
     *     description="Fecha de la factura",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="valorMe",
     *     in="body",
     *     type="string",
     *     description="Valor ME de la factura",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="factorMe",
     *     in="body",
     *     type="string",
     *     description="Factor ME de la factura",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="valorUSD",
     *     in="body",
     *     type="string",
     *     description="Valor USD de la factura",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="moneda",
     *     in="body",
     *     type="string",
     *     description="Moneda de la factura",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="proveedor",
     *     in="body",
     *     type="string",
     *     description="Proveedor de la factura",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="incoterm",
     *     in="body",
     *     type="string",
     *     description="Incoterm de la factura",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Factura")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postFacturaAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $factura = new Factura();
            $factura->setRef($request->get('ref'));
            $factura->setCove($request->get('cove'));
            $factura->setfecha($request->get('fecha'));
            $factura->setValorMe($request->get('valorMe'));
            $factura->setFactorMe($request->get('factorMe'));
            $factura->setValorUsd($request->get('valorUsd'));
            $factura->setMonedaId($request->get('moneda'));
            $factura->setProveedorId($request->get('proveedor'));
            $factura->setIncotermId($request->get('incoterm'));
            $em->persist($factura);
            $em->flush();
            $data = $factura;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar una factura: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear una factura: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_factura", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar una factura"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar una factura."
     * )
     *
     * @SWG\Parameter(
     *     name="ref",
     *     in="body",
     *     type="string",
     *     description="Factura.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="cove",
     *     in="body",
     *     type="string",
     *     description="Cove.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fecha",
     *     in="body",
     *     type="string",
     *     description="Fecha de la factura",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="valorMe",
     *     in="body",
     *     type="string",
     *     description="Valor ME de la factura",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="factorMe",
     *     in="body",
     *     type="string",
     *     description="Factor ME de la factura",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="valorUSD",
     *     in="body",
     *     type="string",
     *     description="Valor USD de la factura",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="moneda",
     *     in="body",
     *     type="string",
     *     description="Moneda de la factura",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="proveedor",
     *     in="body",
     *     type="string",
     *     description="Proveedor de la factura",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="incoterm",
     *     in="body",
     *     type="string",
     *     description="Incoterm de la factura",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Factura")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putFacturaAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $factura = $em->getRepository('App:Factura')->find($id);

            if (!$factura)
                throw new Exception("La factura no existe.");
            if ($request->get('ref'))
                $factura->setRef($request->get('ref'));
            if ($request->get('cove'))
                $factura->setCove($request->get('cove'));
            if ($request->get('fecha'))
                $factura->setfecha($request->get('fecha'));
            if ($request->get('valorMe'))
                $factura->setValorMe($request->get('valorMe'));
            if ($request->get('factorMe'))
                $factura->setFactorMe($request->get('factorMe'));
            if ($request->get('valorUsd'))
                $factura->setValorUsd($request->get('valorUsd'));
            if ($request->get('moneda'))
                $factura->setMonedaId($request->get('moneda'));
            if ($request->get('proveedor'))
                $factura->setProveedorId($request->get('proveedor'));
            if ($request->get('incoterm'))
                $factura->setIncotermId($request->get('incoterm'));
            $em->persist($factura);
            $em->flush();

            $data = $factura;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar una factura: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear una factura: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}