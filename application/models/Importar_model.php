<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importar_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function borrar_tabla($tabla) {
        $query = $this->db->query("DROP TABLE IF EXISTS $tabla");
    }
    
    public function copiar_tabla_y_registros($origen, $destino) {
        $query = $this->db->query("INSERT INTO
                                        $destino
                                    SELECT *
                                    FROM
                                        $origen");
        
        return $query;
    }
    
    public function crear_tabla($origen, $destino) {
        $query = $this->db->query("CREATE TABLE 
                                        $destino
                                    LIKE
                                        $origen");
        return $query;
    }
    
    public function alter_table($destino, $campo_anterior, $campo_nuevo, $adicionales) {
        $query = $this->db->query("ALTER TABLE
                                        $destino
                                    CHANGE
                                        $campo_anterior $campo_nuevo $adicionales");
    }
    
    public function borrar_campo($destino, $campo) {
        $query = $this->db->query("ALTER TABLE
                                        $destino 
                                    DROP
                                        $campo");
    }
    
    public function truncate($tabla) {
        $query = $this->db->query("TRUNCATE TABLE $tabla");
    }
    
    public function set($tabla, $datos) {
        $this->db->insert($tabla, $datos);
        return $this->db->insert_id();
    }
}

?>
