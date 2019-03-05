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
use App\Entity\Identificador;

/**
 * Class IdentificadorController

 * @Route("/api/v1/identificador")
 */
class IdentificadorController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="identificador_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los identificadores disponibles."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de identificadores."
     * )
     *
     * @SWG\Tag(name="Identificador")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getIdentificadorAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $identificadores  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $identificadores = $em->getRepository("App:Identificador")->findAll();

            if (is_null($identificadores))
                $identificadores = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los identificadores: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los identificadores: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $identificadores : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_identificador", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea un nuevo identificador."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un identificador."
     * )
     *
     * @SWG\Parameter(
     *     name="clave",
     *     in="body",
     *     type="string",
     *     description="Clave del identificador.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="c1",
     *     in="body",
     *     type="string",
     *     description="Complemento 1 del identificador",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="c2",
     *     in="body",
     *     type="string",
     *     description="Complemento 2 del identificador",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="c3",
     *     in="body",
     *     type="string",
     *     description="Complemento 3 del identificador",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Identificador")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postIdentificadorAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $identificador = new Identificador();
            $identificador->setclave($request->get('clave'));
            $identificador->setC1($request->get('c1'));
            $identificador->setC2($request->get('c2'));
            $identificador->setC3($request->get('c3'));
            $em->persist($identificador);
            $em->flush();
            $data = $identificador;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un identificador: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear un identificador: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_identificador", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un identificador"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un identificador."
     * )
     *
     * @SWG\Parameter(
     *     name="clave",
     *     in="body",
     *     type="string",
     *     description="Clave del identificador.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="c1",
     *     in="body",
     *     type="string",
     *     description="Complemento 1 del identificador",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="c2",
     *     in="body",
     *     type="string",
     *     description="Complemento 2 del identificador",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="c3",
     *     in="body",
     *     type="string",
     *     description="Complemento 3 del identificador",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Identificador")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putIdentificadorAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $identificador = $em->getRepository('App:Identificador')->find($id);

            if (!$identificador)
                throw new Exception("Identificador no existe.");
            if ($request->get('clave'))
                $identificador->setFecha($request->get('clave'));
            if ($request->get('c1'))
                $identificador->setC1($request->get('c1'));
            if ($request->get('c2'))
                $identificador->setC2($request->get('c2'));
            if ($request->get('c3'))
                $identificador->setC2($request->get('c3'));
            $em->persist($identificador);
            $em->flush();

            $data = $identificador;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el identificador: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el identificador: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}