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
use App\Entity\Inpc;

/**
 * Class InpcController

 * @Route("/api/v1/inpc")
 */
class InpcController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="inpc_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los inpc."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de inpc."
     * )
     *
     * @SWG\Tag(name="Inpc")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getInpcAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $inpcs  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $inpcs = $em->getRepository("App:Inpc")->findAll();

            if (is_null($inpcs))
                $inpcs = [];

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
        $response = new Response($serializer->serialize($code == 200 ? $inpcs : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_inpc", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea un nuevo inpc."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un inpc."
     * )
     *
     * @SWG\Parameter(
     *     name="mes",
     *     in="body",
     *     type="string",
     *     description="Mes del inpc.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="anno",
     *     in="body",
     *     type="string",
     *     description="Anno del inpc",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="valor",
     *     in="body",
     *     type="string",
     *     description="Valor del inpc",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Inpc")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postInpcAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $inpc = new Inpc();
            $inpc->setMes($request->get('mes'));
            $inpc->setAnno($request->get('anno'));
            $inpc->setValor($request->get('valor'));
            $em->persist($inpc);
            $em->flush();
            $data = $inpc;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un inpc: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear un inpc: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_inpc", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un inpc"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un inpc."
     * )
     *
     * @SWG\Parameter(
     *     name="mes",
     *     in="body",
     *     type="string",
     *     description="Mes del inpc",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="anno",
     *     in="body",
     *     type="string",
     *     description="Anno del inpc",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="valor",
     *     in="body",
     *     type="string",
     *     description="Valor del inpc",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Inpc")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putInpcAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $inpc = $em->getRepository('App:Inpc')->find($id);

            if (!$inpc)
                throw new Exception("Inpc no existe.");
            if ($request->get('mes'))
                $inpc->setMes($request->get('mes'));

            if ($request->get('anno'))
                $inpc->setAnno($request->get('anno'));
            if ($request->get('valor'))
                $inpc->setValor($request->get('valor'));
            $em->persist($inpc);
            $em->flush();
            $data = $inpc;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el inpc: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el inpc: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}