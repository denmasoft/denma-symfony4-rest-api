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
use App\Entity\Tipomercancia;

/**
 * Class TipoMercanciaController

 * @Route("/api/v1/tipo-mercancia")
 */
class TipoMercanciaController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="tipo_mercancia_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todos los tipos de mercancias."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de tipos de mercancias."
     * )
     *
     * @SWG\Tag(name="TipoMercancia")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getTipoMercanciaAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $tipo_mercancias  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $tipo_mercancias = $em->getRepository("App:Tipomercancia")->findAll();

            if (is_null($tipo_mercancias))
                $tipo_mercancias = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los tipos de mercancia: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los tipos de mercancia: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $tipo_mercancias : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_tipo_mercancia", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea un nuevo tipo de mercancia."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un tipo de mercancia."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del tipo de mercancia.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="TipoMercancia")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postTipoMercanciaAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $tipoMercancia = new Tipomercancia();
            $tipoMercancia->setDescripcion($request->get('nombre'));
            $em->persist($tipoMercancia);
            $em->flush();
            $data = $tipoMercancia;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un tipo de mercancia: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear una mercancia: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_tipo_mercancia", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un tipo de mercancia"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un tipo de mercancia."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del incoterm.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="TipoMercancia")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putTipoMercanciaAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $tipoMercancia = $em->getRepository('App:Tipomercancia')->find($id);

            if (!$tipoMercancia)
                throw new Exception("Incoterm no existe.");
            if ($request->get('nombre'))
                $tipoMercancia->setFecha($request->get('nombre'));
            $em->persist($tipoMercancia);
            $em->flush();

            $data = $tipoMercancia;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el tipo de mercancia: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el tipo de mercancia: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}