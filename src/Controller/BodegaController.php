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
use App\Entity\Bodega;

/**
 * Class BodegaController

 * @Route("/api/v1/bodega")
 */
class BodegaController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="bodega_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todos las bodegas."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de bodegas."
     * )
     *
     * @SWG\Tag(name="Bodega")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getBodegaAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $bodegas  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $bodegas = $em->getRepository("App:Bodega")->findAll();

            if (is_null($bodegas))
                $bodegas = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener las bodegas: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos las bodegas: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $bodegas : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nueva_bodega", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea una nueva bodega."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear una bodega."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre de la bodega.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="Descripcion de la bodega.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Bodega")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postBodegaAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $bodega = new Bodega();
            $bodega->setNombre($request->get('nombre'));
            $bodega->setDescripcion($request->get('descripcion'));
            $em->persist($bodega);
            $em->flush();
            $data = $bodega;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar una bodega: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear una bodega: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_bodega", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar una bodega"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar una bodega."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre de la bodega.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="Descripcion de la bodega.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Bodega")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putBodegaAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $bodega = $em->getRepository('App:Bodega')->find($id);

            if (!$bodega)
                throw new Exception("Bodega no existe.");
            if ($request->get('nombre'))
                $bodega->setNombre($request->get('nombre'));
            if ($request->get('descripcion'))
                $bodega->setNombre($request->get('descripcion'));
            $em->persist($bodega);
            $em->flush();

            $data = $bodega;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar la bodega: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear la bodega: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}