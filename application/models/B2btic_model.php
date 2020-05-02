<?php
class b2btic_model extends CI_Model{	

    // las dos tablas que necesito para almacenar
    var $table1 = "Archivo";
    var $table2 = "ArchivoDetalle";

    public function __construct ()
    {
        parent::__construct ();
    }

    public function getAllArchivos ($fields,$id_relacion)
    {
        $this->db->select($fields);
        $q = $this->db->get ( $this->table1 );
        if ( $q->num_rows () > 0 ) {
            return $q->result_array ();

        }
        return array ();
    }



    public function getAll ($fields,$id_relacion)
    {
        $this->db->select($fields);
        $this->db->join($this->table2, $this->table2. '.'.$id_relacion.' = '.$this->table1.'.'.$id_relacion);
        $q = $this->db->get ( $this->table1 );
        if ( $q->num_rows () > 0 ) {
            return $q->result_array ();
        }
        return array ();
    }


    public function CountByExt ()
    {
        $q=$this->db->select('Extension,COUNT(idArchivo) as Cantidad')->group_by('Extension')
        ->order_by('Cantidad', 'desc')
        ->get($this->table2);
        //echo $this->db->last_query();
        if ( $q->num_rows () > 0 ) {
            return $q->result_array ();
        }
        return array ();
    }


    public function addAll ($data = array ())
    {
        //vacio las tablas para no duplicar info
        $this->db->empty_table($this->table2);
        $this->db->empty_table($this->table1);

        // inserto de forma masiva
        if ( $this->db->insert_batch($this->table1, $data) ) {
            // si el insert fue exitoso... realizo la consulta para la tabla detalle
            $data2=$this->getAllArchivos ("Nombre,idArchivo","idArchivo");

            //krumo($data2); exit;
       
       foreach ($data2 as $key => $value) {
        
        switch (substr($value['Nombre'], -4)) {
            case '.pdf':
                $data2[$key]['Tipo']="Archivo PDF";
            break;

            case '.docx':
                $data2[$key]['Tipo']="Archivo Word";
            break;

            case '.xlsx':
                $data2[$key]['Tipo']="Archivo Excel ";
            break;

            case '.txt':
                $data2[$key]['Tipo']="Archivo de texto";
            break;

            case '.html':
                $data2[$key]['Tipo']="Archivo HTML";
            break;
            
            case '.xml':
                $data2[$key]['Tipo']="Archivo XML";
            break;
            

            default:
                $data2[$key]['Tipo']="No conocido";
            break;
        }
        unset($data2[$key]['Nombre']);  // elimino el campo nombre del array
        //obtengo extension
        $data2[$key]['Extension']=substr($value['Nombre'], -4);
        
       }

       // krumo($data2); exit;
       // inserto de forma masiva a la tabla2
            if ( $this->db->insert_batch($this->table2, $data2) ) {
                return true;
            }
        }

        return false;
    }

}
?>