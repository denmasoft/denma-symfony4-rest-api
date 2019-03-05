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

/**
 * Class ArchivoDController

 * @Route("/api/v1/archivo-d")
 */
class ArchivoDController extends FOSRestController
{
    private function processInicio($inicio){
        $inicio = explode('|', $inicio);
        $tipoRegistro = $inicio[0];
        $tipoMovimiento = $inicio[1];
        $patente = $inicio[2];
        $pedimento = $inicio[3];
        $aduana_seccion = $inicio[4];
        $firma_electronico = $inicio[5];
        return array('tipoRegistro'=>$tipoRegistro,'tipoMovimiento'=>$tipoMovimiento,
            'patente'=>$patente,'pedimento'=>$pedimento,'aduanaSeccion'=>$aduana_seccion,
            'firmaElectronico'=>$firma_electronico);
    }

    private function processFinArchivo($finArchivo){

        $finArchivo = explode('|', $finArchivo);
        $tipoRegistro = $finArchivo[0];
        $nombreArchivo = $finArchivo[1];
        $cantidadMovimientos = $finArchivo[2];
        $cantidadRegistros = $finArchivo[3];
        $claveAsociacion = $finArchivo[4];
        return array('tipoRegistro'=>$tipoRegistro,'nombreArchivo'=>$nombreArchivo,
            'cantidadMovimientos'=>$cantidadMovimientos,'cantidadRegistros'=>$cantidadRegistros,'claveAsociacion'=>$claveAsociacion);
    }

    private function processDatosGenerales($datosGenerales){
        $items=array();
        foreach ($datosGenerales as $value){
            $item = explode('|', $value);
            $tipoRegistro = $item[0];
            $patente = $item[1];
            $pedimento = $item[2];
            $aduanaSeccion = $item[3];
            $claveDocumento = $item[5];
            $curpImpExp = $item[7];
            $rfcImpExp = $item[8];
            $curpAgente = $item[9];
            $destino = $item[20];
            $nombreImpExp = $item[21];
            $items[] = array('tipoRegistro'=>$tipoRegistro,'patente'=>$patente,'pedimento'=>$pedimento,
                'aduanaSeccion'=>$aduanaSeccion,'claveDocumento'=>$claveDocumento,'curpImpExp'=>$curpImpExp,
                'rfcImpExp'=>$rfcImpExp,'curpAgente'=>$curpAgente,'destino'=>$destino,
                'nombreImpExp'=>$nombreImpExp);

        }
        return $items;
    }

    private function processindicadoresNivelPedimento($indicadoresNivelPedimento){
        $items=array();
        foreach ($indicadoresNivelPedimento as $value){
            $item = explode('|', $value);
            $tipoRegistro = $item[0];
            $pedimento = $item[1];
            $tipoCaso = $item[2];
            $complementoIdentificador = $item[3];
            $items[] = array('tipoRegistro'=>$tipoRegistro,'pedimento'=>$pedimento,
                'tipoCaso'=>$tipoCaso,'complementoIdentificador'=>$complementoIdentificador);

        }
        return $items;
    }

    private function processPartidas($datosGenerales){
        $items = array();
        foreach ($datosGenerales as $value){
            $item = explode('|', $value);
            $tipoRegistro = $item[0];
            $pedimento = $item[1];
            $fraccionArancelaria = $item[2];
            $seccionFraccionArancelaria = $item[3];
            $valorDolares = $item[9];
            $cantidad = $item[12];
            $clave = $item[13];
            $items[] = array('tipoRegistro'=>$tipoRegistro,'pedimento'=>$pedimento,
                'fraccionArancelaria'=>$fraccionArancelaria,'seccionFraccionArancelaria'=>$seccionFraccionArancelaria,
                'valorDolares'=>$valorDolares,'cantidad'=>$cantidad,'clave'=>$clave);

        }
        return $items;
    }

    private function processArchivoD($data){
        $archivoD = array();
        $archivoD['inicio'] = $this->processInicio($data[0]);
        $datosGenerales = array();
        $indicadoresNivelPedimento = array();
        $partidas = array();
        for ($i=1;$i<=count($data)-2;$i++){
            $item = explode('|', $data[$i]);
            $tipoRegistro = $item[0];
            switch ($tipoRegistro){
                case 501:
                    $datosGenerales[] = $data[$i];
                    break;
                case 507:
                    $indicadoresNivelPedimento[] = $data[$i];
                    break;
                case 551:
                    $partidas[] = $data[$i];
                    break;
                default:

            }
        }
        $archivoD['DatosGenerales'] = $this->processDatosGenerales($datosGenerales);
        $archivoD['IndicadoresNivelPedimento'] = $this->processindicadoresNivelPedimento($indicadoresNivelPedimento);
        $archivoD['Partidas'] = $this->processPartidas($partidas);
        $archivoD['fin'] = $this->processFinArchivo($data[count($data) - 2]);
        return $archivoD;
    }

    /**
     * @Rest\Get(".{_format}", name="archivoD_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todos los archivos D."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de archivos D."
     * )
     *
     * @SWG\Tag(name="Archivo D")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getArchivosDAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $archivosD=array();
        foreach (glob($_SERVER['DOCUMENT_ROOT'].'/uploads/D.files/d*') as $filename) {
            $ext = pathinfo($filename,PATHINFO_EXTENSION);
            if($ext!='err'){
                $archivoD = file_get_contents($filename);
                $archivoD = preg_split("/\r\n|\n|\r/",$archivoD);
                $archivoD = $this->processArchivoD($archivoD);
                $file_name = pathinfo($filename,PATHINFO_BASENAME);//
                $archivosD[] = array('filename'=>$file_name,'data'=>$archivoD);
            }
        }

        $response = new Response($serializer->serialize($archivosD, "json"), 200);

        return $response;
    }

    /**
     * @Rest\Post(".{_format}", name="nuevo_archivoD", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Carga un archivo D."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al cargar un archivo D."
     * )
     *
     *
     * @SWG\Tag(name="Archivo D")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postArchivosDAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {


        $files = $request->files->get ( 'files' );
        $archivosD=array();
        foreach ($files as $file){
            $original_name = $file->getClientOriginalName ();
            $file->move ( $_SERVER['DOCUMENT_ROOT'].'/uploads/D.files', $original_name );
            $archivoD = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/uploads/D.files/'.$original_name);
            $archivoD = preg_split("/\r\n|\n|\r/",$archivoD);
            $archivoD = $this->processArchivoD($archivoD);
            $archivosD[] = array('filename'=>$original_name,'data'=>$archivoD);
        }
        return new Response($serializer->serialize($archivosD, "json"), 200);
    }

    /**
     * @Rest\Post("/generar-error.{_format}", name="generarArchivoError", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Genera error de archivo D."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al generar error de archivo D."
     * )
     *
     *
     * @SWG\Tag(name="Archivo D")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postGenerarErrorAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {


        $files = $request->request->get ( 'files' );
        $archivosE=array();
        foreach ($files as $file){
            $archivoD = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/uploads/D.files/'.$file);
            $fileerror = pathinfo($file,PATHINFO_FILENAME).'.err';
            $archivoD = preg_split("/\r\n|\n|\r/",$archivoD);
            $archivoD = $this->processArchivoD($archivoD);
            $contentE = 'E';
            $contentE.=$archivoD['DatosGenerales'][0]['pedimento'];
            $contentE.='507';
            $contentE.='0001';
            $contentE.='b';
            $contentE.='00';
            $contentE.='03';
            //$archivosE[] = array('filename'=>$file,'data'=>$archivoD);
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/uploads/D.files/'.$fileerror,$contentE);
            $archivosE[] = array('filename'=>$fileerror,'url'=>'/uploads/D.files/'.$fileerror);
        }
        return new Response($serializer->serialize($archivosE, "json"), 200);
    }

    /**
     * @Rest\Post("/generar-q.{_format}", name="generarQ", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Genera archivo Q de archivo D."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al generar archivo Q de archivo D."
     * )
     *
     *
     * @SWG\Tag(name="Archivo D")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postGenerarQAction (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {


        $files = $request->request->get ( 'files' );//
        $archivosQ=array();
        foreach ($files as $file){
            $archivoD = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/uploads/D.files/'.$file);
            $day = date('z') + 1;
            if($day<=99)$day='0'.$day;
            $fileQ = pathinfo($file,PATHINFO_FILENAME).'.'.$day;
            $fileQ = str_replace('d','Q',$fileQ);
            $archivoD = preg_split("/\r\n|\n|\r/",$archivoD);
            $archivoD = $this->processArchivoD($archivoD);
            $count =1;
            $contentQ = '611|1401|'.$archivoD['DatosGenerales'][0]['patente'].'|'.$archivoD['DatosGenerales'][0]['pedimento'].'|A|'.PHP_EOL;
            $contentQ.='612|1401|'.$archivoD['DatosGenerales'][0]['patente'].'|'.$archivoD['DatosGenerales'][0]['pedimento'].'|'.$archivoD['inicio']['tipoMovimiento'].'|';
            $count++;
            $contentQ.=$archivoD['DatosGenerales'][0]['rfcImpExp'].'||'.$archivoD['DatosGenerales'][0]['nombreImpExp'].'|'.$archivoD['DatosGenerales'][0]['patente'].'|'.$archivoD['DatosGenerales'][0]['curpAgente'].'||69661|'.PHP_EOL;
            $contentQ.='613|1401|'.$archivoD['DatosGenerales'][0]['patente'].'|'.$archivoD['DatosGenerales'][0]['pedimento'].'|'.$archivoD['inicio']['tipoMovimiento'].'|'.$archivoD['inicio']['aduanaSeccion'].'|'.PHP_EOL;
            $count++;
            $contentQ.='614|1401|'.$archivoD['DatosGenerales'][0]['patente'].'|'.$archivoD['DatosGenerales'][0]['pedimento'].'|'.$archivoD['IndicadoresNivelPedimento'][0]['tipoCaso'].'|'.$archivoD['IndicadoresNivelPedimento'][0]['complementoIdentificador'].'|'.PHP_EOL;
            $count++;
            foreach ($archivoD['Partidas'] as $partida){
                $contentQ.='651|1401|'.$archivoD['DatosGenerales'][0]['patente'].'|'.$archivoD['DatosGenerales'][0]['pedimento'].'|'.$archivoD['inicio']['tipoMovimiento'].'|'.$partida['fraccionArancelaria'].'|'.$partida['seccionFraccionArancelaria'].'|'.$partida['clave'].'|'.$partida['cantidad'].'||'.PHP_EOL;
                $count++;
            }
            $contentQ.='199|1|'.$count.'|';
            //$archivosE[] = array('filename'=>$file,'data'=>$archivoD);
            if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/Q.files/')){
                mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/Q.files/',0777);
            }
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/uploads/Q.files/'.$fileQ,$contentQ);
            $archivosQ[] = array('filename'=>$fileQ,'url'=> '/uploads/Q.files/'.$fileQ);
        }
        return new Response($serializer->serialize($archivosQ, "json"), 200);
    }
    /**
     * @Rest\Get("/descargar-error.{_format}", name="descarga_error", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todos los archivos D."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de archivos D."
     * )
     *
     * @SWG\Tag(name="Archivo D")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getDescargaErrorAction(SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {
        $filepath =$_SERVER['DOCUMENT_ROOT'].'/uploads/D.files/'.$request->query->get('file');
        if(file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush();
            readfile($filepath);
            exit;
        }
        return new Response();
    }

    /**
     * @Rest\Get("/descargar-q.{_format}", name="descarga_q", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todos los archivos D."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de archivos D."
     * )
     *
     * @SWG\Tag(name="Archivo D")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getDescargaQAction(SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {
        $filepath =$_SERVER['DOCUMENT_ROOT'].'/uploads/Q.files/'.$request->query->get('file');
        if(file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush();
            readfile($filepath);
            exit;
        }
    }
}