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
use App\Entity\Partida;

/**
 * Class PartidaController

 * @Route("/api/v1/partida")
 */
class PartidaController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="partida_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas las partidas."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de partidas."
     * )
     *
     * @SWG\Tag(name="Partida")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getPartidaAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $partidas  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $partidas = $em->getRepository("App:Partida")->findAll();

            if (is_null($partidas))
                $partidas = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener las partidas: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos las partidas: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $partidas : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_partida", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea una nueva partida."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear una partida."
     * )
     *
     * @SWG\Parameter(
     *     name="valor",
     *     in="body",
     *     type="string",
     *     description="Valor de la partida.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fraccion",
     *     in="body",
     *     type="string",
     *     description="Fraccion de la partida.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="Descripcion de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="umc",
     *     in="body",
     *     type="string",
     *     description="UMC de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="clave_umc",
     *     in="body",
     *     type="string",
     *     description="Clave UMC de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="umt",
     *     in="body",
     *     type="string",
     *     description="UMT de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="clave_umt",
     *     in="body",
     *     type="string",
     *     description="Clave UMT de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="pais_vendedor",
     *     in="body",
     *     type="string",
     *     description="Pais Vendedor de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="pais_origen",
     *     in="body",
     *     type="string",
     *     description="Pais de origen de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="vinculacion",
     *     in="body",
     *     type="string",
     *     description="Vinculacion de la partida",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Partida")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postPartidaAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $partida = new Partida();
            $partida->setValor($request->get('valor'));
            $partida->setFraccion($request->get('fraccion'));
            $partida->setDescripcion($request->get('descripcion'));
            $partida->setUmc($request->get('umc'));
            $partida->setClaveUmc($request->get('clave_umc'));
            $partida->setUmt($request->get('umt'));
            $partida->setClaveUmt($request->get('clave_umt'));
            $partida->setPaisVendedor($request->get('pais_vendedor'));
            $partida->setPaisOrigen($request->get('pais_origen'));
            $partida->setVinculacion($request->get('vinculacion'));
            $em->persist($partida);
            $em->flush();
            $data = $partida;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar una partida: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear una partida: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_partida", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar una partida"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar una partida."
     * )
     *
     * @SWG\Parameter(
     *     name="valor",
     *     in="body",
     *     type="string",
     *     description="Valor de la partida.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fraccion",
     *     in="body",
     *     type="string",
     *     description="Fraccion de la partida.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="Descripcion de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="umc",
     *     in="body",
     *     type="string",
     *     description="UMC de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="clave_umc",
     *     in="body",
     *     type="string",
     *     description="Clave UMC de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="umt",
     *     in="body",
     *     type="string",
     *     description="UMT de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="clave_umt",
     *     in="body",
     *     type="string",
     *     description="Clave UMT de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="pais_vendedor",
     *     in="body",
     *     type="string",
     *     description="Pais Vendedor de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="pais_origen",
     *     in="body",
     *     type="string",
     *     description="Pais de origen de la partida",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="vinculacion",
     *     in="body",
     *     type="string",
     *     description="Vinculacion de la partida",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Partida")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putPartidaAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $partida = $em->getRepository('App:Partida')->find($id);

            if (!$partida)
                throw new Exception("La partida no existe.");
            if ($request->get('valor'))
                $partida->setValor($request->get('valor'));
            if ($request->get('fraccion'))
                $partida->setFraccion($request->get('fraccion'));
            if ($request->get('descripcion'))
                $partida->setDescripcion($request->get('descripcion'));
            if ($request->get('umc'))
                $partida->setUmc($request->get('umc'));
            if ($request->get('clave_umc'))
                $partida->setClaveUmc($request->get('clave_umc'));
            if ($request->get('umt'))
                $partida->setUmt($request->get('umt'));
            if ($request->get('clave_umt'))
                $partida->setClaveUmt($request->get('clave_umt'));
            if ($request->get('pais_vendedor'))
                $partida->setPaisVendedor($request->get('pais_vendedor'));
            if ($request->get('pais_origen'))
                $partida->setPaisOrgen($request->get('pais_origen'));
            if ($request->get('vinculacion'))
                $partida->setVinculacion($request->get('vinculacion'));
            $em->persist($partida);
            $em->flush();

            $data = $partida;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar una partida: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear una partida: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}