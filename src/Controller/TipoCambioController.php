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
use App\Entity\Tipocambio;

/**
 * Class TipoCambioController

 * @Route("/api/v1/tipo-cambio")
 */
class TipoCambioController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="tipoCambios_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los tipos de cambios disponibles."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de tipo de cambios."
     * )
     *
     * @SWG\Tag(name="TipoCambio")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getTipoCambiosAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $tipoCambios  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $tipoCambios = $em->getRepository("App:Tipocambio")->findAll();

            if (is_null($tipoCambios))
                $tipoCambios = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los tipo de cambios: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los tipo de cambios: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $tipoCambios : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_tipo_cambio", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea un nuevo tipo de cambio."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un tipo de cambio."
     * )
     *
     * @SWG\Parameter(
     *     name="fecha",
     *     in="body",
     *     type="string",
     *     description="Fecha del tipo de cambio.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="cambio",
     *     in="body",
     *     type="string",
     *     description="valor del tipo de cambio",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="TipoCambio")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postTipoCambioAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $tipoCambio = new Tipocambio();
            $tipoCambio->setFecha($request->get('fecha'));
            $tipoCambio->setCambio($request->get('cambio'));
            $em->persist($tipoCambio);
            $em->flush();
            $data = $tipoCambio;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un tipo de cambio: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear un tipo de cambio: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_tipo_cambio", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un tipo de cambio"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un tipo de cambio."
     * )
     *
     * @SWG\Parameter(
     *     name="fecha",
     *     in="body",
     *     type="string",
     *     description="Fecha del tipo de cambio",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="cambio",
     *     in="body",
     *     type="string",
     *     description="Valor del tipo de cambio",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="TipoCambio")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putTipoCambioAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $tipoCambio = $em->getRepository('App:Tipocambio')->find($id);

            if (!$tipoCambio)
                throw new Exception("Tipo de cambio no existe.");
            if ($request->get('fecha'))
                $tipoCambio->setFecha(new \DateTime($request->get('fecha')));

            if ($request->get('cambio'))
                $tipoCambio->setCambio($request->get('cambio'));
            $em->persist($tipoCambio);
            $em->flush();

            $data = $tipoCambio;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el tipo de cambio: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el tipo de cambio: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}