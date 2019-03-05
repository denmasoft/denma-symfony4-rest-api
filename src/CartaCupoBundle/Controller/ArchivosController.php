<?php

namespace App\CartaCupoBundle\Controller;
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
 * Class ArchivosController

 * @Route("/api/v1/carta-cupo")
 */
class ArchivosController extends FOSRestController
{
    /**
     * @Rest\Get("/archivos.{_format}", name="archivos", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todos los archivos."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de archivos."
     * )
     *
     * @SWG\Tag(name="Archivos")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getArchivosAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $archivos=array();
        foreach (glob($_SERVER['DOCUMENT_ROOT'].'/uploads/D.files/[dQ]*') as $filename) {
            $ext = pathinfo($filename,PATHINFO_EXTENSION);
            $file = pathinfo($filename,PATHINFO_FILENAME);
            $fileType = substr($file,0,1);
            if($ext!='err'){
                $archivo = file_get_contents($filename);
                $archivo = preg_split("/\r\n|\n|\r/",$archivo);
                $archivo = $this->processArchivoD($archivo);
                $file_name = pathinfo($filename,PATHINFO_BASENAME);
                if($fileType=='d'){
                    $archivos[] = array('dfile'=>$file_name,'data'=>$archivo);
                }
                else if($fileType=='Q'){
                    $archivos[] = array('qfile'=>$file_name,'data'=>$archivo);
                }
            }
        }

        $response = new Response($serializer->serialize($archivos, "json"), 200);

        return $response;
    }


    /**
     * @Rest\Post("/generar-pdf.{_format}", name="generarPdf", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Genera archivo Pdf."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al generar archivo Pdf."
     * )
     *
     *
     * @SWG\Tag(name="Archivo Pdf")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postGenerarPdfAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {


        $files = $request->request->get ( 'files' );
        if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/archivospdf/carta-cupo/')){
            mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/archivospdf/carta-cupo/',0777);
        }
        $archivosPdf=array();
        foreach ($files as $file){
            $archivoD = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/uploads/D.files/'.$file);
            $archivoD = preg_split("/\r\n|\n|\r/",$archivoD);
            $archivoD = $this->processArchivoD($archivoD);
            $archivoPdf='';
            $archivosPdf[] = array('filename'=>'','url'=> '/uploads/archivospdf/carta-cupo/'.$archivoPdf);
        }
        return new Response($serializer->serialize($archivosPdf, "json"), 200);
    }
}