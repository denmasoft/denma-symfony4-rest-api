<?php

namespace App\Controller;
use App\Entity\Validador;
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
use FOS\RestBundle\Controller\Annotations as Rest;//

/**
 * Class ValidadorController

 * @Route("/api/v1/validador")
 */
class ValidadorController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="validadores_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los validadores."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de validadores."
     * )
     *
     * @SWG\Tag(name="Validador")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getValidadorAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $validadores  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $validadores = $em->getRepository("App:Validador")->findAll();

            if (is_null($validadores))
                $validadores = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los validadores: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los validadores: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $validadores : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_validador", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea un nuevo validador."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un validador."
     * )
     *
     * @SWG\Parameter(
     *     name="defecto",
     *     in="body",
     *     type="integer",
     *     description="Validador por defecto.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="Descripcion del validador.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Validador")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postValidadorAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $validador = new Validador();
            $validador->setDescripcion($request->get('descripcion'));
            $validador->setDefecto($request->get('defecto'));
            $em->persist($validador);
            $em->flush();
            $data = $validador;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un validador: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear un validador: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_validador", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un validador"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un validador."
     * )
     *
     * @SWG\Parameter(
     *     name="defecto",
     *     in="body",
     *     type="integer",
     *     description="Validador por defecto",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="Descripcion del validador",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Validador")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putValidadorAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $validador = $em->getRepository('App:Validador')->find($id);

            if (!$validador)
                throw new Exception("Validador no existe.");
            if ($request->get('descripcion'))
                $validador->setFecha($request->get('descripcion'));
            if ($request->get('defecto'))
                $validador->setFecha($request->get('defecto'));
            $em->persist($validador);
            $em->flush();

            $data = $validador;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el validador: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el validador: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}