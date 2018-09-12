<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parametros_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Parametros/agregar
     */
    public function gets_tipos_parametros() {
        $query = $this->db->query("SELECT *
                                    FROM
                                        parametros_tipos
                                    WHERE
                                        estado = 'A'
                                    ORDER BY
                                        parametro_tipo");
        return $query->result_array();
    }
    
    
    /*
     *  Parametros/agregar_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('parametros', $where);
        return $query->row_array();
    }
    
    /*
     *  Parametros/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('parametros', $datos);
        return $this->db->insert_id();
    }
    
    
    /*
     *  Parametros/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('parametros');
        $this->db->like($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Parametros/listar
     */
    public function get_cantidad_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('parametros');
        $this->db->join('parametros_tipos', 'parametros.idparametro_tipo = parametros_tipos.idparametro_tipo');
        $this->db->like($where);
        $this->db->order_by('parametros.parametro');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    /*
     *  Parametros/usuario
     */
    public function gets_parametros_por_usuario($SID) {
        $query = $this->db->query("SELECT p.*, pu.valor
                                    FROM
                                        (parametros p
                                    LEFT JOIN
                                        parametros_usuarios pu
                                    ON
                                        p.idparametro = pu.idparametro AND
                                        pu.idusuario = '$SID')
                                    WHERE
                                        p.idparametro_tipo = 1 AND
                                        p.estado = 'A'");
        
        return $query->result_array();
    }
    
    /*
     *  Parametros/usuarios
     */
    public function get_parametro_por_usuario($idparametro, $idusuario) {
        $query = $this->db->query("SELECT *
                                    FROM
                                        parametros_usuarios
                                    WHERE
                                        idparametro = '$idparametro' AND
                                        idusuario = '$idusuario'");
        return $query->row_array();
    }
    
    /*
     *  Parametros/usuarios
     */
    public function set_parametros_usuarios($datos) {
        $this->db->insert('parametros_usuarios', $datos);
        return $this->db->insert_id();
    }
    
    
    /*
     *  Parametros/usuarios
     */
    public function update_parametros_usuarios($valor, $idparametro, $idusuario) {
        $query = $this->db->query("UPDATE
                                        parametros_usuarios
                                    SET
                                        valor = '$valor'
                                    WHERE
                                        idparametro = '$idparametro' AND
                                        idusuario = '$idusuario'");
        
    }
    
    
    public function get_valor_parametro_por_usuario($identificador, $idusuario) {
        $query = $this->db->query("SELECT *
                                    FROM
                                        parametros_usuarios pu, 
                                        parametros p
                                    WHERE
                                        p.idparametro = pu.idparametro AND
                                        p.identificador = '$identificador' AND
                                        pu.idusuario = '$idusuario'");
        
        return $query->row_array();
    }
    
    /*
     *  Parametros/sistema
     */
    public function get_parametros_empresa() {
        $query = $this->db->query("SELECT *
                                    FROM
                                        parametros_empresa
                                    WHERE
                                        idparametro_empresa = '1'");
        return $query->row_array();
    }
    
    /*
     *  Parametros/sistema_modificar_ajax
     */
    public function update_parametros_empresa($where) {
        $this->db->update('parametros_empresa', $where, array('idparametro_empresa' => 1));
        
        return $this->db->affected_rows();
    }
}

?>
