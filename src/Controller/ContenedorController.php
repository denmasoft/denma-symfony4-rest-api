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
use App\Entity\Contenedor;

/**
 * Class ContenedorController

 * @Route("/api/v1/contenedor")
 */
class ContenedorController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="contenedor_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los contenedores."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de contenedores."
     * )
     *
     * @SWG\Tag(name="Contenedor")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getContenedorAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $contenedores  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $contenedores = $em->getRepository("App:Contenedor")->findAll();

            if (is_null($contenedores))
                $contenedores = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener las monedas: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos las monedas: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $contenedores : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_contenedor", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea una nuevo contenedor."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un contenedor."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del contenedor.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Contenedor")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postContenedorAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $contenedor = new Contenedor();
            $contenedor->setNombre($request->get('nombre'));
            $em->persist($contenedor);
            $em->flush();
            $data = $contenedor;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un contenedor: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear un contenedor: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_contenedor", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un contenedor"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un contenedor."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del contenedor.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Contenedor")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putContenedorAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $contenedor = $em->getRepository('App:Contenedor')->find($id);

            if (!$contenedor)
                throw new Exception("Moneda no existe.");
            if ($request->get('nombre'))
                $contenedor->setFecha($request->get('nombre'));
            $em->persist($contenedor);
            $em->flush();

            $data = $contenedor;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar la moneda: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear la moneda: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}