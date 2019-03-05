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
use App\Entity\Tipopedimento;

/**
 * Class TipoPedimentoController

 * @Route("/api/v1/tipo-pedimento")
 */
class TipoPedimentoController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="tipoPedimentos_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los tipos de pedimentos."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de tipos de pedimentos."
     * )
     *
     * @SWG\Tag(name="TipoPedimento")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getTipoPedimentoAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $tipoPedimentos  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $tipoPedimentos = $em->getRepository("App:Tipopedimento")->findAll();

            if (is_null($tipoPedimentos))
                $tipoPedimentos = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los tipos de pedimentos: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los tipos de pedimentos: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $tipoPedimentos : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_tipo_pedimento", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea un nuevo tipo de pedimento."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un tipo de pedimento."
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="Descripcion del tipo de pedimento.",
     *     schema={}
     * )
     *

     *
     * @SWG\Tag(name="TipoPedimento")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postTipoPedimentoAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $tipoPedimento = new Tipopedimento();
            $tipoPedimento->setDescripcion($request->get('descripcion'));
            $em->persist($tipoPedimento);
            $em->flush();
            $data = $tipoPedimento;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un tipo de pedimento: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear un tipo de pedimento: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_tipo_pedimento", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un tipo de pedimento"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un tipo de pedimento."
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="Descripcion del tipo de pedimento",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="TipoPedimento")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putTipoPedimentoAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $tipoPedimento = $em->getRepository('App:Tipopedimento')->find($id);

            if (!$tipoPedimento)
                throw new Exception("Tipo de pedimento no existe.");
            if ($request->get('descripcion'))
                $tipoPedimento->setFecha($request->get('descripcion'));
            $em->persist($tipoPedimento);
            $em->flush();

            $data = $tipoPedimento;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el tipo de pedimento: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el tipo de pedimento: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}