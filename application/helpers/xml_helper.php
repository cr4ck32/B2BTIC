<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('makeXml')){
    function makeXml($data,$table,$item){
        $ci =& get_instance();
        //$ci->output->set_content_type('text/xml');
        $dom = new DOMDocument("1.0");
        $root = $dom->createElement($table);
        $keyss=(array_keys($data[0]));
        $dom->appendChild($root);
        //ciclo de consulta para el formato xml
        foreach ($data as $key => $value) {
            $marker = $dom->createElement($item);
            $root->appendChild($marker);
            // keys son los campos de las tablas ( se realizo de esta forma para que sea dinamico )
            foreach ($keyss as $k => $v) {
                ${$v} = $dom->createAttribute($v);
                $marker->appendChild(${$v});
                $val = $dom->createTextNode($value[$v]);
                ${$v}->appendChild($val);
            }
    }
        //Guardo el archivo en la carpeta temporal
        $dom->save(APPPATH.'tmp/'.$table.'.xml');

      } 

}
