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
use App\Entity\Clientes;

/**
 * Class ProveedorController

 * @Route("/api/v1/cliente")
 */
class ClienteController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="clientes_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todos los clientes."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de clientes."
     * )
     *
     * @SWG\Tag(name="Cliente")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getClientesAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $clientes  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $clientes = $em->getRepository("App:Clientes")->findAll();

            if (is_null($clientes))
                $clientes = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los clientes: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los clientes: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $clientes : $response, "json"), $code);

        return $response;
    }
}