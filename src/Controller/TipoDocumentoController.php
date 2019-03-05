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
use App\Entity\TipoActualizacion;

/**
 * Class TipoActualizacionController

 * @Route("/api/v1/tipo-documento")
 */
class TipoDocumentoController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="tipo_documento_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todos los tipos de documento."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de tipos de documento."
     * )
     *
     * @SWG\Tag(name="TipoDocumento")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getTipoDocumentoAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $tipo_documentos  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $tipo_documentos = $em->getRepository("App:Tipodocumento")->findAll();

            if (is_null($tipo_documentos))
                $tipo_documentos = [];

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
        $response = new Response($serializer->serialize($code == 200 ? $tipo_documentos : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_tipo_documento", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea un nuevo tipo de documento."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un tipo de documento."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del tipo de documento.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="TipoDocumento")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postTipoDocumentoAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $tipo_documento = new Tipodocumento();
            $tipo_documento->setNombre($request->get('nombre'));
            $tipo_documento->setDescripcion($request->get('descripcion'));
            $em->persist($tipo_documento);
            $em->flush();
            $data = $tipo_documento;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un tipo de documento: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear un tipo de documento: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_tipo_documento", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un tipo de documento"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un tipo de documento."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del tipo de documento.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="TipoDocumento")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putTipoDocumentoAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $tipo_documento = $em->getRepository('App:Tipodocumento')->find($id);

            if (!$tipo_documento)
                throw new Exception("Tipo actualizacion no existe.");
            if ($request->get('nombre'))
                $tipo_documento->setNombre($request->get('nombre'));
            if ($request->get('descripcion'))
                $tipo_documento->setNombre($request->get('descripcion'));
            $em->persist($tipo_documento);
            $em->flush();

            $data = $tipo_documento;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el tipo de documento: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el tipo de documento: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}