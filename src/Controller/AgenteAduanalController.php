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
use App\Entity\Agenteaduanal;

/**
 * Class AgenteAduanalController

 * @Route("/api/v1/agente-aduanal")
 */
class AgenteAduanalController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="agente_aduanal_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los agentes aduanales."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de agentes aduanales."
     * )
     *
     * @SWG\Tag(name="AgenteAduanal")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getAgenteAduanalAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $agentes_aduanales  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $agentes_aduanales = $em->getRepository("App:Agenteaduanal")->findAll();

            if (is_null($agentes_aduanales))
                $agentes_aduanales = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los agentes aduanales: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los agentes aduanales: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $agentes_aduanales : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_agente_aduanal", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea un nuevo agente aduanal."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un agente aduanal."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del agente aduanal.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="rfc",
     *     in="body",
     *     type="string",
     *     description="RFC del agente aduanal",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="curp",
     *     in="body",
     *     type="string",
     *     description="CURP del proveedor",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="patente",
     *     in="body",
     *     type="string",
     *     description="Patente del Agente Aduanal",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="AgenteAduanal")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postProveedorAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $agenteAduanal = new Agenteaduanal();
            $agenteAduanal->setNombre($request->get('nombre'));
            $agenteAduanal->setRfc($request->get('rcf'));
            $agenteAduanal->setCurp($request->get('curp'));
            $agenteAduanal->setPatente($request->get('patente'));
            $em->persist($agenteAduanal);
            $em->flush();
            $data = $agenteAduanal;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un agente aduanal: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el agente aduanal: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_agente_aduanal", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un agente aduanal"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un agente aduanal."
     * )
     *
     * @SWG\Parameter(
     *     name="nombre",
     *     in="body",
     *     type="string",
     *     description="Nombre del agente aduanal.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="rfc",
     *     in="body",
     *     type="string",
     *     description="RFC del agente aduanal",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="curp",
     *     in="body",
     *     type="string",
     *     description="CURP del proveedor",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="patente",
     *     in="body",
     *     type="string",
     *     description="Patente del Agente Aduanal",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="AgenteAduanal")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putAgenteAduanalAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $agenteAduanal = $em->getRepository('App:Agenteaduanal')->find($id);

            if (!$agenteAduanal)
                throw new Exception("Agente Aduanal no existe.");
            if ($request->get('nombre'))
                $agenteAduanal->setNombre($request->get('nombre'));
            if ($request->get('rfc'))
                $agenteAduanal->setRfc($request->get('rfc'));
            if ($request->get('curp'))
                $agenteAduanal->setCurp($request->get('curp'));
            if ($request->get('patente'))
                $agenteAduanal->setPatente($request->get('patente'));
            $em->persist($agenteAduanal);
            $em->flush();
            $data = $agenteAduanal;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el agente aduanal: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el agente aduanal: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}