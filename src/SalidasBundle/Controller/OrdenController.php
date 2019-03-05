<?php

namespace App\SalidasBundle\Controller;
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
use App\Entity\OrdenSalida;

/**
 * Class OrdenController

 * @Route("/api/v1/salidas/orden")
 */
class OrdenController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="orden_salidas_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas las ordenes de salidas."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de ordenes de salida."
     * )
     *
     * @SWG\Tag(name="OrdenSalida")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getOrdenSalidaAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $ordenes  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $ordenes = $em->getRepository("App:OrdenSalida")->findAll();

            if (is_null($ordenes))
                $ordenes = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener ordenes de salida: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos las ordenes de salida: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $ordenes : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nueva_orden_salida", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea una nueva orden salida."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear una orden salida."
     * )
     *
     * @SWG\Parameter(
     *     name="reciboDeposito",
     *     in="body",
     *     type="string",
     *     description="Recibo Deposito.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="salida",
     *     in="body",
     *     type="string",
     *     description="Salida.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="sidefi",
     *     in="body",
     *     type="string",
     *     description="Sidefi.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fecha",
     *     in="body",
     *     type="string",
     *     description="Fecha",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="pedimentoExtraccion",
     *     in="body",
     *     type="string",
     *     description="Pedimento Extraccion.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="pedimentoOriginal",
     *     in="body",
     *     type="string",
     *     description="Pedimento Original.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="certificado",
     *     in="body",
     *     type="integer",
     *     description="Certificado.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="importador",
     *     in="body",
     *     type="string",
     *     description="Importador.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="obs",
     *     in="body",
     *     type="string",
     *     description="Observaciones.",
     *     schema={}
     * )
     *
     *
     * @SWG\Tag(name="OrdenSalida")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postOrdenSalidaAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $ordenSalida = new OrdenSalida();
            $ordenSalida->setReciboDeposito($request->get('reciboDeposito'));
            $ordenSalida->setSidefi($request->get('sidefi'));
            $ordenSalida->setSalida($request->get('salida'));
            $ordenSalida->setObs($request->get('obs'));

            $ordenSalida->setFecha($request->get('fecha'));
            $ordenSalida->setPedimentoExtraccion($request->get('pedimentoExtraccion'));
            $ordenSalida->setPedimentoOriginal($request->get('pedimentoOriginal'));
            $ordenSalida->setCertificado($request->get('certificado'));

            $ordenSalida->setImportador($request->get('importador'));
            $em->persist($ordenSalida);
            $em->flush();
            $data = $ordenSalida;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar una orden de salida: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear una orden de salida: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_orden_salida", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar una orden de salida"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar una orden de salida."
     * )
     *
     * @SWG\Parameter(
     *     name="reciboDeposito",
     *     in="body",
     *     type="string",
     *     description="Recibo Deposito.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="salida",
     *     in="body",
     *     type="string",
     *     description="Salida.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="sidefi",
     *     in="body",
     *     type="string",
     *     description="Sidefi.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fecha",
     *     in="body",
     *     type="string",
     *     description="Fecha",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="pedimentoExtraccion",
     *     in="body",
     *     type="string",
     *     description="Pedimento Extraccion.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="pedimentoOriginal",
     *     in="body",
     *     type="string",
     *     description="Pedimento Original.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="certificado",
     *     in="body",
     *     type="integer",
     *     description="Certificado.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="importador",
     *     in="body",
     *     type="string",
     *     description="Importador.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="obs",
     *     in="body",
     *     type="string",
     *     description="Observaciones.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="OrdenSalida")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putOrdenSalidaAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $ordenSalida = $em->getRepository('App:OrdenSalida')->find($id);
            if (!$ordenSalida)
                throw new Exception("Orden no existe.");
            if ($request->get('reciboDeposito'))
                $ordenSalida->setReciboDeposito($request->get('reciboDeposito'));
            if ($request->get('sidefi'))
                $ordenSalida->setSidefi($request->get('sidefi'));
            if ($request->get('salida'))
                $ordenSalida->setSalida($request->get('salida'));
            if ($request->get('obs'))
                $ordenSalida->setObs($request->get('obs'));
            if ($request->get('fecha'))
                $ordenSalida->setFecha($request->get('fecha'));
            if ($request->get('pedimentoExtraccion'))
                $ordenSalida->setPedimentoExtraccion($request->get('pedimentoExtraccion'));
            if ($request->get('pedimentoOriginal'))
                $ordenSalida->setPedimentoOriginal($request->get('pedimentoOriginal'));
            if ($request->get('certificado'))
                $ordenSalida->setCertificado($request->get('certificado'));
            if ($request->get('importador'))
                $ordenSalida->setImportador($request->get('importador'));
            $em->persist($ordenSalida);
            $em->flush();
            $data = $ordenSalida;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar la orden de salida: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear la orden de salida: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}