<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Provincias_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function gets() {
        $query = $this->db->query("SELECT *
                                    FROM
                                        provincias
                                    ORDER BY
                                        provincia");
        return $query->result_array();
    }
}

?>
