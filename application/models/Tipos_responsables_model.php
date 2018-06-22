<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tipos_responsables_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function gets() {
        $query = $this->db->query("SELECT *
                                    FROM
                                        tipos_responsables
                                    WHERE
                                        estado = 'A'
                                    ORDER BY
                                        tipo_responsable");
        return $query->result_array();
    }
}

?>
