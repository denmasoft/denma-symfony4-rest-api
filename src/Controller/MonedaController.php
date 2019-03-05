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
use App\Entity\Moneda;

/**
 * Class MonedaController

 * @Route("/api/v1/moneda")
 */
class MonedaController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="moneda_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas las monedas."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de monedas."
     * )
     *
     * @SWG\Tag(name="Moneda")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getMonedaAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $monedas  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $monedas = $em->getRepository("App:Moneda")->findAll();

            if (is_null($monedas))
                $monedas = [];

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
        $response = new Response($serializer->serialize($code == 200 ? $monedas : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nueva_moneda", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea una nueva moneda."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear una moneda."
     * )
     *
     * @SWG\Parameter(
     *     name="codigo",
     *     in="body",
     *     type="string",
     *     description="Codigo de la monedas.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre de la moneda.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Moneda")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postMonedaAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $moneda = new Moneda();
            $moneda->setCodigo($request->get('codigo'));
            $moneda->setDescripcion($request->get('nombre'));
            $em->persist($moneda);
            $em->flush();
            $data = $moneda;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar una moneda: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear una moneda: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_moneda", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar una moneda"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar una moneda."
     * )
     *
     * @SWG\Parameter(
     *     name="codigo",
     *     in="body",
     *     type="string",
     *     description="Codigo de la monedas.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre de la moneda.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Moneda")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putMonedaAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $moneda = $em->getRepository('App:Moneda')->find($id);

            if (!$moneda)
                throw new Exception("Moneda no existe.");
            if ($request->get('codigo'))
                $moneda->setCodigo($request->get('codigo'));
            if ($request->get('nombre'))
                $moneda->setFecha($request->get('nombre'));
            $em->persist($moneda);
            $em->flush();

            $data = $moneda;

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