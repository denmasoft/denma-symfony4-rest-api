<?php

namespace App\Controller;
use App\Entity\Tipodocumento;
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
use App\Entity\Tipoarribo;

/**
 * Class TipoArriboController

 * @Route("/api/v1/tipo-arribo")
 */
class TipoArriboController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="tipo_arribo_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todos los tipos de arribo."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de tipos de arribo."
     * )
     *
     * @SWG\Tag(name="TipoArribo")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getTipoArriboAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $tipo_arribos  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $tipo_arribos = $em->getRepository("App:Tipoarribo")->findAll();

            if (is_null($tipo_arribos))
                $tipo_arribos = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los tipos de arribo: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los tipos de arribo: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $tipo_arribos : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_tipo_arribo", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea un nuevo tipo de arribo."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un tipo de arribo."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del tipo de arribo.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="TipoArribo")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postTipoArriboAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $tipo_arribo = new Tipoarribo();
            $tipo_arribo->setNombre($request->get('nombre'));
            $tipo_arribo->setDescripcion($request->get('descripcion'));
            $em->persist($tipo_arribo);
            $em->flush();
            $data = $tipo_arribo;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un tipo de arribo: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear un tipo de arribo: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_tipo_arribo", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un tipo de arribo"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un tipo de arribo."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del tipo de arribo.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="TipoArribo")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putTipoArriboAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $tipo_arribo = $em->getRepository('App:Tipoarribo')->find($id);

            if (!$tipo_arribo)
                throw new Exception("Tipo actualizacion no existe.");
            if ($request->get('nombre'))
                $tipo_arribo->setNombre($request->get('nombre'));
            if ($request->get('descripcion'))
                $tipo_arribo->setNombre($request->get('descripcion'));
            $em->persist($tipo_arribo);
            $em->flush();

            $data = $tipo_arribo;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el tipo de arribo: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el tipo de arribo: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}