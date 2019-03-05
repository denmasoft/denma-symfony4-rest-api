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
use App\Entity\Fraccion;

/**
 * Class FraccionController

 * @Route("/api/v1/fracciones")
 */
class FraccionController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="fracciones_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas las fracciones."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de fracciones."
     * )
     *
     * @SWG\Tag(name="Fraccion")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getFraccionesAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $fracciones  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $fracciones = $em->getRepository("App:Fraccion")->findAll();

            if (is_null($fracciones))
                $fracciones = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener las fracciones: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos las fracciones: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $fracciones : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nueva_fraccion", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea una nueva fraccion."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear una fraccion."
     * )
     *
     * @SWG\Parameter(
     *     name="fraccion",
     *     in="body",
     *     type="string",
     *     description="Codigo fraccion .",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="Descripcion de la fraccion",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="prohibida",
     *     in="body",
     *     type="string",
     *     description="Esta prohibida?",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Fraccion")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postFraccionAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $fraccion = new Fraccion();
            $fraccion->setFraccion($request->get('fraccion'));
            $fraccion->setDescripcion($request->get('descripcion'));
            $fraccion->setProhibida($request->get('prohibida'));
            $em->persist($fraccion);
            $em->flush();
            $data = $fraccion;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar una fraccion: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear una fraccion: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_fraccion", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar una fraccion"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar una fraccion."
     * )
     *
     * @SWG\Parameter(
     *     name="fraccion",
     *     in="body",
     *     type="string",
     *     description="Codigo fraccion .",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="Descripcion de la fraccion",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="prohibida",
     *     in="body",
     *     type="string",
     *     description="Esta prohibida?",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Fraccion")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putFraccionAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $fraccion = $em->getRepository('App:Fraccion')->find($id);

            if (!$fraccion)
                throw new Exception("Fraccion no existe.");
            if ($request->get('fraccion'))
                $fraccion->setFraccion($request->get('fraccion'));
            if ($request->get('descripcion'))
                $fraccion->setRfc($request->get('descripcion'));
            $em->persist($fraccion);
            $em->flush();
            $data = $fraccion;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar la fraccion: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear la fraccion: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}