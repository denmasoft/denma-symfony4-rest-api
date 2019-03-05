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
use App\Entity\Bonoprenda;

/**
 * Class BonoPrendaController

 * @Route("/api/v1/bono-prenda")
 */
class BonoPrendaController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="bonoPrenda_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los bonos de prenda."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de bonos de prenda."
     * )
     *
     * @SWG\Tag(name="BonoPrenda")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getBonoPrendaAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $bonosPrenda  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $bonosPrenda = $em->getRepository("App:Bonoprenda")->findAll();

            if (is_null($bonosPrenda))
                $bonosPrenda = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener todos los bonos de prenda: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los bonos de prenda: {$ex->getMessage()}";
        }
        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];
        $response = new Response($serializer->serialize($code == 200 ? $bonosPrenda : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_bonoPrenda", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea una nuevo bono de prenda."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un bono de prenda."
     * )
     *
     * @SWG\Parameter(
     *     name="entidad",
     *     in="body",
     *     type="string",
     *     description="Nombre de la entidad financiera.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="importe",
     *     in="body",
     *     type="number",
     *     description="Importe del credito.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="factorMoneda",
     *     in="body",
     *     type="string",
     *     description="Factor Moneda.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="interes",
     *     in="body",
     *     type="number",
     *     description="Interes pactado.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="vencimiento",
     *     in="body",
     *     type="string",
     *     description="Vencimiento del credito.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="adeudos",
     *     in="body",
     *     type="string",
     *     description="adeudos.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="anticipos",
     *     in="body",
     *     type="string",
     *     description="anticipos.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="lugarExpedicion1",
     *     in="body",
     *     type="string",
     *     description="Lugar de expedicion 1.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="lugarExpedicion2",
     *     in="body",
     *     type="string",
     *     description="Lugar de expedicion 2.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fechaExpedicion1",
     *     in="body",
     *     type="string",
     *     description="Fecha de expedicion 1.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fechaExpedicion2",
     *     in="body",
     *     type="string",
     *     description="Fecha de expedicion 2.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="descripcion.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="BonoPrenda")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postBonoPrendaAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $bonoPrenda = new Bonoprenda();
            $bonoPrenda->setEntidad($request->get('entidad'));
            $bonoPrenda->setImporte($request->get('importe'));
            $bonoPrenda->setFactorMoneda($request->get('factorMoneda'));
            $bonoPrenda->setInteres($request->get('interes'));

            $bonoPrenda->setVencimiento($request->get('vencimiento'));
            $bonoPrenda->setAdeudos($request->get('adeudos'));
            $bonoPrenda->setAnticipos($request->get('anticipos'));
            $bonoPrenda->setLugarExpedicion1($request->get('lugarExpedicion1'));
            $bonoPrenda->setLugarExpedicion2($request->get('lugarExpedicion2'));
            $bonoPrenda->setFechaExpedicion1($request->get('fechaExpedicion1'));
            $bonoPrenda->setFechaExpedicion2($request->get('fechaExpedicion2'));
            $bonoPrenda->setDescripcion($request->get('descripcion'));
            $em->persist($bonoPrenda);
            $em->flush();
            $data = $bonoPrenda;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un bono de prenda: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear un bono de prenda: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_bonoPrenda", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un bono de prenda"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un bono de prenda."
     * )
     *
     * @SWG\Parameter(
     *     name="entidad",
     *     in="body",
     *     type="string",
     *     description="Nombre de la entidad financiera.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="importe",
     *     in="body",
     *     type="number",
     *     description="Importe del credito.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="factorMoneda",
     *     in="body",
     *     type="string",
     *     description="Factor Moneda.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="interes",
     *     in="body",
     *     type="number",
     *     description="Interes pactado.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="vencimiento",
     *     in="body",
     *     type="string",
     *     description="Vencimiento del credito.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="adeudos",
     *     in="body",
     *     type="string",
     *     description="adeudos.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="anticipos",
     *     in="body",
     *     type="string",
     *     description="anticipos.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="lugarExpedicion1",
     *     in="body",
     *     type="string",
     *     description="Lugar de expedicion 1.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="lugarExpedicion2",
     *     in="body",
     *     type="string",
     *     description="Lugar de expedicion 2.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fechaExpedicion1",
     *     in="body",
     *     type="string",
     *     description="Fecha de expedicion 1.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fechaExpedicion2",
     *     in="body",
     *     type="string",
     *     description="Fecha de expedicion 2.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="descripcion.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="BonoPrenda")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putBonoPrendaAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $bonoPrenda = $em->getRepository('App:Bonoprenda')->find($id);
            if (!$bonoPrenda)
                throw new Exception("Bono de Prenda no existe.");
            if ($request->get('entidad'))
                $bonoPrenda->setEntidad($request->get('entidad'));
            if ($request->get('importe'))
                $bonoPrenda->setImporte($request->get('importe'));
            if ($request->get('factorMoneda'))
                $bonoPrenda->setFactorMoneda($request->get('factorMoneda'));
            if ($request->get('interes'))
                $bonoPrenda->setInteres($request->get('interes'));
            if ($request->get('vencimiento'))
                $bonoPrenda->setVencimiento($request->get('vencimiento'));
            if ($request->get('adeudos'))
                $bonoPrenda->setAdeudos($request->get('adeudos'));
            if ($request->get('anticipos'))
                $bonoPrenda->setAnticipos($request->get('anticipos'));
            if ($request->get('lugarExpedicion1'))
                $bonoPrenda->setLugarExpedicion1($request->get('lugarExpedicion1'));
            if ($request->get('lugarExpedicion2'))
                $bonoPrenda->setLugarExpedicion2($request->get('lugarExpedicion2'));
            if ($request->get('fechaExpedicion1'))
                $bonoPrenda->setFechaExpedicion1($request->get('fechaExpedicion1'));
            if ($request->get('fechaExpedicion2'))
                $bonoPrenda->setFechaExpedicion2($request->get('fechaExpedicion2'));
            if ($request->get('descripcion'))
                $bonoPrenda->setDescripcion($request->get('descripcion'));

            $em->persist($bonoPrenda);
            $em->flush();
            $data = $bonoPrenda;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el bono de prenda: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear el bono de prenda: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}