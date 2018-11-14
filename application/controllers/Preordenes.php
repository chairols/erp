<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Preordenes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'preordenes_model',
            'listas_de_precios_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar_modificar_item_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|integer');
        $this->form_validation->set_rules('idlista_de_precios_comparacion_item', 'ID del Item', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idlista_de_precios_comparacion_item' => $this->input->post('idlista_de_precios_comparacion_item')
            );
            $item = $this->preordenes_model->get_where($where);

            if ($item) {
                /*
                 *  Desarrollar
                 */
                $datos = array(
                    'cantidad' => $this->input->post('cantidad'),
                    'estado' => 'A',
                    'modificado_por' => $session['SID']
                );
                $where = array(
                    'idpre_orden' => $item['idpre_orden']
                );
                
                if($this->input->post('cantidad') == 0) {
                    $datos['estado'] = 'I';
                }
                
                $resultado = $this->preordenes_model->update($datos, $where);
                
                if($resultado) {
                    $json = array(
                        'status' => 'ok',
                        'data' => 'Se actualizó correctamente el item '.$item['articulo']
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'No se pudo actualizar el item '.$item['articulo']
                    );
                    echo json_encode($json);
                }
            } else {
                $where = array(
                    'idlista_de_precios_comparacion_item' => $this->input->post('idlista_de_precios_comparacion_item')
                );
                $item_comparacion = $this->listas_de_precios_model->get_where_comparacion_item($where);

                $where = array(
                    'idlista_de_precios_item' => $item_comparacion['idlista_de_precios_item']
                );
                $item_lista = $this->listas_de_precios_model->get_where_item($where);

                $where = array(
                    'idlista_de_precios' => $item_lista['idlista_de_precios']
                );
                $lista = $this->listas_de_precios_model->get_where($where);

                $set = array(
                    'idproveedor' => $lista['idproveedor'],
                    'proveedor' => $lista['proveedor'],
                    'cantidad' => $this->input->post('cantidad'),
                    'articulo' => $item_lista['articulo'],
                    'precio' => $item_lista['precio'],
                    'idmarca' => $item_lista['idmarca'],
                    'marca' => $item_lista['marca'],
                    'idlista_de_precios_comparacion_item' => $item_comparacion['idlista_de_precios_comparacion_item'],
                    'idlista_de_precios_comparacion' => $item_comparacion['idlista_de_precios_comparacion'],
                    'idlista_de_precios_item' => $item_lista['idlista_de_precios_item'],
                    'idarticulo_generico' => $item_lista['idarticulo_generico'],
                    'idcreador' => $session['SID'],
                    'fecha_creacion' => date("Y-m-d H:i:s"),
                    'modificado_por' => $session['SID']
                );

                $id = $this->preordenes_model->set($set);

                if ($id) {  // Si se creó
                    $json = array(
                        'status' => 'ok',
                        'data' => 'Se agregó el item '.$item_lista['articulo']
                    );
                    echo json_encode($json);
                } else {  // Si no se pudo crear
                    $json = array(
                        'status' => 'error',
                        'data' => 'Ocurrió un error inesperado, no se pudo agregar'
                    );
                    echo json_encode($json);
                }
            }
            
        }
    }

}

?>