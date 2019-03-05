<?php

namespace App\ExtraccionBundle\Controller;
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
use App\Entity\SalidaNacional;

/**
 * Class TrasladoController

 * @Route("/api/v1/extraccion/traslado")
 */
class TrasladoController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="salida_nacional_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas las salidas nacionales."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de salidas nacionales."
     * )
     *
     * @SWG\Tag(name="Traslado")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getTrasladoAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $salidasNacionales  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $salidasNacionales = $em->getRepository("App:SalidaNacional")->findAll();

            if (is_null($salidasNacionales))
                $salidasNacionales = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener las salidas nacionales: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos las salidas nacionales: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $salidasNacionales : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nueva_salida_nacional", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea una nueva salida nacional."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear una salida nacional."
     * )
     *
     * @SWG\Parameter(
     *     name="recibo",
     *     in="body",
     *     type="string",
     *     description="Recibo.",
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
     *     name="razonSocial",
     *     in="body",
     *     type="string",
     *     description="Razon Social.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="observacion",
     *     in="body",
     *     type="string",
     *     description="Observacion.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="modelo",
     *     in="body",
     *     type="string",
     *     description="Modelo.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="complemento",
     *     in="body",
     *     type="string",
     *     description="Complemento.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="cantidad",
     *     in="body",
     *     type="integer",
     *     description="cantidad.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="valor_mercancia",
     *     in="body",
     *     type="string",
     *     description="Valor Mercancia.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="peso",
     *     in="body",
     *     type="string",
     *     description="Peso.",
     *     schema={}
     * )
     *
     *
     * @SWG\Tag(name="Traslado")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postTrasladoAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $salidaNacional = new SalidaNacional();
            $salidaNacional->setRecibo($request->get('recibo'));
            $salidaNacional->setSidefi($request->get('sidefi'));
            $salidaNacional->setRazonSocial($request->get('razonSocial'));
            $salidaNacional->setObservacion($request->get('observacion'));

            $salidaNacional->setModelo($request->get('modelo'));
            $salidaNacional->setComplemento($request->get('complemento'));
            $salidaNacional->setCantidad($request->get('cantidad'));
            $salidaNacional->setValorMercancia($request->get('valor_mercancia'));

            $salidaNacional->setPeso($request->get('peso'));
            $em->persist($salidaNacional);
            $em->flush();
            $data = $salidaNacional;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar una salida nacional: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear una salida nacional: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_certificado", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un certificado"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un certificado."
     * )
     *
     * @SWG\Parameter(
     *     name="recibo",
     *     in="body",
     *     type="string",
     *     description="Recibo.",
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
     *     name="razonSocial",
     *     in="body",
     *     type="string",
     *     description="Razon Social.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="observacion",
     *     in="body",
     *     type="string",
     *     description="Observacion.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="modelo",
     *     in="body",
     *     type="string",
     *     description="Modelo.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="complemento",
     *     in="body",
     *     type="string",
     *     description="Complemento.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="cantidad",
     *     in="body",
     *     type="integer",
     *     description="cantidad.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="valor_mercancia",
     *     in="body",
     *     type="string",
     *     description="Valor Mercancia.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="peso",
     *     in="body",
     *     type="string",
     *     description="Peso.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Traslado")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putTrasladoAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $salidaNacional = $em->getRepository('App:SalidaNacional')->find($id);
            if (!$salidaNacional)
                throw new Exception("SalidaNacional no existe.");
            if ($request->get('recibo'))
                $salidaNacional->setRecibo($request->get('recibo'));
            if ($request->get('sidefi'))
                $salidaNacional->setSidefi($request->get('sidefi'));
            if ($request->get('razonSocial'))
                $salidaNacional->setRazonSocial($request->get('razonSocial'));
            if ($request->get('observacion'))
                $salidaNacional->setObservacion($request->get('observacion'));
            if ($request->get('modelo'))
                $salidaNacional->setModelo($request->get('modelo'));
            if ($request->get('complemento'))
                $salidaNacional->setComplemento($request->get('complemento'));
            if ($request->get('cantidad'))
                $salidaNacional->setCantidad($request->get('cantidad'));
            if ($request->get('valor_mercancia'))
                $salidaNacional->setValorMercancia($request->get('valor_mercancia'));
            if ($request->get('peso'))
                $salidaNacional->setPeso($request->get('peso'));
            $em->persist($salidaNacional);
            $em->flush();
            $data = $salidaNacional;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar la salida nacional: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear la salida nacional: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}