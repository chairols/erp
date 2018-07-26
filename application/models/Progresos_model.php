<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Progresos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Importar/actualizar_articulos
     */
    public function get_where($where) {
        $query = $this->db->get_where('progresos', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Importar/actualizar_articulos
     */
    public function set($array) {
        $this->db->insert('progresos', $array);
        return $this->db->insert_id();
    }
    
    /*
     *  Importar/actualizar_articulos
     */
    public function update($datos, $idprogreso) {
        $id = array('idprogreso' => $idprogreso);
        $this->db->update('progresos', $datos, $id);
    }
}

?>
