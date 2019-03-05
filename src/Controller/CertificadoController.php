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
use App\Entity\Certificado;

/**
 * Class CertificadoController

 * @Route("/api/v1/certificado")
 */
class CertificadoController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="certificado_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los certificados."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de certificados."
     * )
     *
     * @SWG\Tag(name="Certificado")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getCertificadoAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $certificados  = [];
        $message     = "";
        try {
            $code = 200;
            $error = false;
            $certificados = $em->getRepository("App:Certificado")->findAll();

            if (is_null($certificados))
                $certificados = [];

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
        $response = new Response($serializer->serialize($code == 200 ? $certificados : $response, "json"), $code);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_certificado", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea una nuevo certificado."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear un certificado."
     * )
     *
     * @SWG\Parameter(
     *     name="noCertificado",
     *     in="body",
     *     type="string",
     *     description="No. del certificado.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="negociable",
     *     in="body",
     *     type="boolean",
     *     description="Es negociable?.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="reciboNacional",
     *     in="body",
     *     type="string",
     *     description="Recibo Nacional.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="denominacionSocial",
     *     in="body",
     *     type="string",
     *     description="Denominacion Social /Beneficiario.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="diasVencimiento",
     *     in="body",
     *     type="string",
     *     description="Dias Vencimiento.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="sidef",
     *     in="body",
     *     type="string",
     *     description="sidef.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="depositante",
     *     in="body",
     *     type="string",
     *     description="depositante.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fechaEntrada",
     *     in="body",
     *     type="string",
     *     description="Fecha Entrada.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="tipoMercancia",
     *     in="body",
     *     type="string",
     *     description="Tipo de Mercancia.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="convenio",
     *     in="body",
     *     type="string",
     *     description="convenio.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="contenedor",
     *     in="body",
     *     type="number",
     *     description="contenedor.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="bulto",
     *     in="body",
     *     type="string",
     *     description="bulto.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="valor",
     *     in="body",
     *     type="number",
     *     description="valor.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="peso",
     *     in="body",
     *     type="number",
     *     description="peso.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="observacion",
     *     in="body",
     *     type="string",
     *     description="observacion.",
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
     * @SWG\Tag(name="Certificado")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postCertificadoAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $certificado = new Certificado();
            $certificado->setRef($request->get('noCertificado'));
            $certificado->setNegociable($request->get('negociable'));
            $certificado->setReciboNacional($request->get('reciboNacional'));
            $certificado->setBeneficiario($request->get('denominacionSocial'));

            $certificado->setVencimiento($request->get('diasVencimiento'));
            $certificado->setSidef($request->get('sidef'));
            $certificado->setDepositante($request->get('depositante'));
            $certificado->setFechaEntrada($request->get('fechaEntrada'));

            $certificado->setTipoMercanciaId($request->get('tipoMercancia'));
            $certificado->setContenedorId($request->get('contenedor'));
            $certificado->setBultos($request->get('bulto'));
            $certificado->setValor($request->get('valor'));
            $certificado->setPeso($request->get('peso'));
            $em->persist($certificado);
            $em->flush();
            $data = $certificado;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar un certificado: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear un certificado: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }


    /**
     * @Rest\Put("/{id}.{_format}", name="editar_certificado", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar un certificado"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar un certificado."
     * )
     *
     * @SWG\Parameter(
     *     name="noCertificado",
     *     in="body",
     *     type="string",
     *     description="No. del certificado.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="negociable",
     *     in="body",
     *     type="boolean",
     *     description="Es negociable?.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="reciboNacional",
     *     in="body",
     *     type="string",
     *     description="Recibo Nacional.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="denominacionSocial",
     *     in="body",
     *     type="string",
     *     description="Denominacion Social /Beneficiario.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="diasVencimiento",
     *     in="body",
     *     type="string",
     *     description="Dias Vencimiento.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="sidef",
     *     in="body",
     *     type="string",
     *     description="sidef.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="depositante",
     *     in="body",
     *     type="string",
     *     description="depositante.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fechaEntrada",
     *     in="body",
     *     type="string",
     *     description="Fecha Entrada.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="tipoMercancia",
     *     in="body",
     *     type="string",
     *     description="Tipo de Mercancia.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="convenio",
     *     in="body",
     *     type="string",
     *     description="convenio.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="contenedor",
     *     in="body",
     *     type="number",
     *     description="contenedor.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="bulto",
     *     in="body",
     *     type="string",
     *     description="bulto.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="valor",
     *     in="body",
     *     type="number",
     *     description="valor.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="peso",
     *     in="body",
     *     type="number",
     *     description="peso.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="observacion",
     *     in="body",
     *     type="string",
     *     description="observacion.",
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
     * @SWG\Tag(name="Certificado")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putCertificadoAction (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $certificado = $em->getRepository('App:Certificado')->find($id);
            if (!$certificado)
                throw new Exception("Certificado no existe.");
            if ($request->get('noCertificado'))
                $certificado->setRef($request->get('noCertificado'));
            if ($request->get('negociable'))
                $certificado->setNegociable($request->get('negociable'));
            if ($request->get('reciboNacional'))
                $certificado->setReciboNacional($request->get('reciboNacional'));
            if ($request->get('denominacionSocial'))
                $certificado->setBeneficiario($request->get('denominacionSocial'));
            if ($request->get('diasVencimiento'))
                $certificado->setVencimiento($request->get('diasVencimiento'));
            if ($request->get('sidef'))
                $certificado->setSidef($request->get('sidef'));
            if ($request->get('depositante'))
                $certificado->setDepositante($request->get('depositante'));
            if ($request->get('fechaEntrada'))
                $certificado->setFechaEntrada($request->get('fechaEntrada'));
            if ($request->get('tipoMercancia'))
                $certificado->setTipoMercanciaId($request->get('tipoMercancia'));
            if ($request->get('contenedor'))
                $certificado->setContenedorId($request->get('contenedor'));
            if ($request->get('bulto'))
                $certificado->setBultos($request->get('bulto'));
            if ($request->get('valor'))
                $certificado->setValor($request->get('valor'));
            if ($request->get('peso'))
                $certificado->setPeso($request->get('peso'));
            $em->persist($certificado);
            $em->flush();
            $data = $certificado;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar el certificado: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear la certificado: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
}