<?php

namespace App\EntradasBundle\Controller;
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
/**
 * Class BodegaController

 * @Route("/api/v1/entradas/carga-recepcion")
 */
class CargaRecepcionController extends FOSRestController
{
    /**
     * @Rest\Get("/buscar.{_format}", name="buscar_archivo_recepcion", defaults={"_format":"json"})
     *
     * @SWG\Parameter(
     *     name="sidefi",
     *     in="path",
     *     type="string",
     *     description="Sidefi",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="cliente",
     *     in="path",
     *     type="string",
     *     description="Cliente",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="pedimento",
     *     in="path",
     *     type="string",
     *     description="Pedimento",
     *     schema={}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los archivos de recepcion"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener todas archivos de recepcion."
     * )
     *
     * @SWG\Tag(name="Archivo de Recepcion")
     * @param Request $request
     * @return Response
     */
    public function searchArchivoRecepcionAction(Request $request) {

        ini_set('memory_limit', '-1');
        $serializer  = $this->get('jms_serializer');
        $em          = $this->getDoctrine()->getManager();
        $archivos   = [];
        $message     = "";

        try {
            $code = 200;
            $error = false;

            $sidefi = $request->get("sidefi");
            $cliente = $request->get("cliente");
            $pedimento = $request->get("pedimento");

            if ($sidefi)
                $archivos = $em->getRepository("App:Pedimento")->findBy(array(
                    "sidefi" => $sidefi
                ));

            if (is_null($archivos))
                $archivos = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los archivos de recepcion - Error: DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los los archivos de recepcion - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $archivos : $message,
        ];

        return new Response($serializer->serialize($code == 200 ? $archivos : $response, "json"), $code);
    }
}
