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
use App\Entity\TipoActualizacion;

/**
 * Class TipoActualizacionController

 * @Route("/api/v1/tipo-actualizacion")
 */
class TipoActualizacionController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="tipo_actualizacion_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todos los tipos de actualizacion."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de tipos de actualizaciones."
     * )
     *
     * @SWG\Tag(name="TipoActualizacion")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getTipoActualizacionAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $tipo_actualizaciones  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $tipo_actualizaciones = $em->getRepository("App:TipoActualizacion")->findAll();

            if (is_null($tipo_actualizaciones))
                $tipo_actualizaciones = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los tipos de actualizacion: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los tipos de actualizacion: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $tipo_actualizaciones : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_tipo_actualizacion", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea un nuevo tipo de actualizacion."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un tipo de actualizacion."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del tipo de actualizacion.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="TipoActualizacion")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postTipoActualizacionAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $tipo_actualizacion = new TipoActualizacion();
            $tipo_actualizacion->setNombre($request->get('nombre'));
            $em->persist($tipo_actualizacion);
            $em->flush();
            $data = $tipo_actualizacion;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un tipo de actualizacion: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear un tipo de actuaizacion: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_tipo_actualizacion", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un tipo de actualizacion"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un tipo de actualizacion."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del tipo de actualizacion.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="TipoActualizacion")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putTipoActualizacionAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $tipo_actualizacion = $em->getRepository('App:TipoActualizacion')->find($id);

            if (!$tipo_actualizacion)
                throw new Exception("Tipo actualizacion no existe.");
            if ($request->get('nombre'))
                $tipo_actualizacion->setNombre($request->get('nombre'));
            $em->persist($tipo_actualizacion);
            $em->flush();

            $data = $tipo_actualizacion;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el tipo de actualizacion: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el tipo de actualizacion: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}