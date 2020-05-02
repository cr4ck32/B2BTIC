<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors", 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class B2btic extends CI_Controller {

   // opciones para el soap
   var $options = array(
      'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
      'style'=>SOAP_RPC,
      'use'=>SOAP_ENCODED,
      'soap_version'=>SOAP_1_1,
      'cache_wsdl'=>WSDL_CACHE_NONE,
      'connection_timeout'=>15,
      'trace'=>true,
      'encoding'=>'UTF-8',
      'exceptions'=>true,
  );
  
  	public function __construct(){
        parent::__construct();
        //$this->lang->load('b2btic');
        // cargo modelo base de datos
        $this->load->model('b2btic_model');
        //carglo helper para hacer el xml con los resultados de las consultas
        $this->load->helper('xml');  
    }


	public function index(){
// conexion soap con el endpoint y el schema
      $client = new SoapClient("http://test.analitica.com.co/AZDigital_Pruebas/WebServices/ServiciosAZDigital.wsdl",$this->options);
      $client->__setLocation('http://test.analitica.com.co/AZDigital_Pruebas/WebServices/SOAP/index.php');
      
// parametros de la consulta
      $params = [
              'Condiciones'   =>  
                  [
                      'Condicion'  => [
                              'Tipo'    => 'FechaInicial',
                              'Expresion'    => '2019-07-01 00:00:00',
                      ]
                  ]
      ];
      
            
      try {  // funcion del soap para la consulta ( segun la prueba enviada )
          $response = $client->__soapCall('BuscarArchivo', array($params));

          //krumo($response->Archivo);

          // funcion que agrega los datos a la tabla de Archivos ( si sale ok en pantalla ya fue lleno las tablas SQL )
          if ($this->b2btic_model->addAll($response->Archivo)) {
            echo "ok";
          }

          else {
            echo "Error";
          }
      }
      catch(Exception $e) {
          print_r($e);
          echo "Exception: " . $e->getMessage();
      }
      
   
      
}

// controlador de mostrar los archivos resultados ( extension, tipo )
public function showxml () {
   // consulto los campos, con el idArchivo que es para el Join
   $data=$this->b2btic_model->getAll('Id,Nombre,Extension,Tipo,fec_Registro','idArchivo');
   
   //con los resultados genero el XML
   makeXml($data,'Archivos','Archivo');

   // cargo el xml generado
   $xml = new DOMDocument;
   $xml->load(APPPATH.'tmp/Archivos.xml');

   // cargo el xsl como plantilla para el cargar los resultados
   $xsl = new DOMDocument;
   $xsl->load(APPPATH.'xlst/Archivos.xsl');

   // proceso los archivos xml y xsl
   $proc = new XSLTProcessor;
   $proc->importStyleSheet($xsl); 
   echo $proc->transformToXML($xml);


}


public function countxml () {
      //consulto con un count todos los resultados, agrupados por extension para saber su cantidad por extension
      $dataCount=$this->b2btic_model->CountByExt();
      // Genero el XML
      makeXml($dataCount,'Count','Archivo');
      //krumo($data);
      // cargo el xsl como plantilla para el cargar los resultados
      $xml = new DOMDocument;
      $xml->load(APPPATH.'tmp/Count.xml');
      $xsl = new DOMDocument;
      $xsl->load(APPPATH.'xlst/Count.xsl');
      $proc = new XSLTProcessor;
      $proc->importStyleSheet($xsl); 
      echo $proc->transformToXML($xml);
}


}