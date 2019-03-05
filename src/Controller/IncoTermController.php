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
use App\Entity\Incoterm;

/**
 * Class IncoTermController

 * @Route("/api/v1/incoterm")
 */
class IncoTermController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="incoterm_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los incoterms."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de incoterms."
     * )
     *
     * @SWG\Tag(name="Incoterm")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getIncotermAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $incoterms  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $incoterms = $em->getRepository("App:Incoterm")->findAll();

            if (is_null($incoterms))
                $incoterms = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los incoterms: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los incoterms: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $incoterms : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_incoterm", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea un nuevo incoterm."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un incoterm."
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
     * @SWG\Tag(name="Incoterm")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postIncotermAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $incoterm = new Incoterm();
            $incoterm->setDescripcion($request->get('nombre'));
            $em->persist($incoterm);
            $em->flush();
            $data = $incoterm;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un incoterm: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear un incoterm: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_incoterm", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un incoterm"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un incoterm."
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
     * @SWG\Tag(name="Incoterm")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putIncotermAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $incoterm = $em->getRepository('App:Incoterm')->find($id);

            if (!$incoterm)
                throw new Exception("Incoterm no existe.");
            if ($request->get('nombre'))
                $incoterm->setFecha($request->get('nombre'));
            $em->persist($incoterm);
            $em->flush();

            $data = $incoterm;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el incoterm: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el incoterm: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}