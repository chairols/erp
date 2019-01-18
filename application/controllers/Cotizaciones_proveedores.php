<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_proveedores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'pagination'
        ));
        $this->load->model(array(
            'monedas_model',
            'cotizaciones_proveedores_model',
            'proveedores_model',
            'monedas_model',
            'log_model',
            'parametros_model',
            'articulos_model',
            'marcas_model',
            'lineas_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Nueva Cotización de Proveedores';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/cotizaciones_proveedores/js/agregar.js'
        );
        $data['view'] = 'cotizaciones_proveedores/agregar';

        $data['monedas'] = $this->monedas_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idproveedor', 'Proveedor', 'required|integer');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('fecha', 'Fecha', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $set = array(
                'idproveedor' => $this->input->post('idproveedor'),
                'idmoneda' => $this->input->post('idmoneda'),
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'observaciones' => $this->input->post('observaciones'),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $session['SID'],
                'actualizado_por' => $session['SID']
            );

            $id = $this->cotizaciones_proveedores_model->set($set);

            if ($id) {
                $where = array(
                    'idproveedor' => $this->input->post('idproveedor')
                );
                $proveedor = $this->proveedores_model->get_where($where);

                $where = array(
                    'idmoneda' => $this->input->post('idmoneda')
                );
                $moneda = $this->monedas_model->get_where($where);

                $log = array(
                    'tabla' => 'cotizaciones_proveedores',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se creó la cotización de proveedor número: " . $id . "</strong></h2>

<p>
<strong>Proveedor: </strong>" . $proveedor['proveedor'] . "<br />
<strong>Moneda: </strong>" . $moneda['moneda'] . "<br />
<strong>Fecha de Cotización: </strong>" . $this->input->post('fecha') . "<br />
<strong>Observaciones: </strong>" . $this->input->post('observaciones') . "
</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'add'
                );
                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => $id
                );
                echo json_encode($json);
            }
        }
    }

    public function modificar($idcotizacion_proveedor = null) {
        if ($idcotizacion_proveedor == null) {
            redirect('/cotizaciones_proveedores/listar/', 'refresh');
        }

        $data['title'] = 'Modificar Cotización de Proveedores';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/cotizaciones_proveedores/js/modificar.js'
        );
        $data['view'] = 'cotizaciones_proveedores/modificar';

        $where = array(
            'idcotizacion_proveedor' => $idcotizacion_proveedor
        );
        $data['cotizacion_proveedor'] = $this->cotizaciones_proveedores_model->get_where($where);

        $where = array(
            'idproveedor' => $data['cotizacion_proveedor']['idproveedor']
        );
        $data['cotizacion_proveedor']['proveedor'] = $this->proveedores_model->get_where($where);

        $data['monedas'] = $this->monedas_model->gets();

        $data['cotizacion_proveedor']['fecha_formateada'] = $this->formatear_fecha_para_mostrar($data['cotizacion_proveedor']['fecha']);

        $this->load->view('layout/app', $data);
    }

    public function actualizar_cabecera_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idproveedor', 'Proveedor', 'required|integer');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('fecha', 'Fecha', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'idproveedor' => $this->input->post('idproveedor'),
                'idmoneda' => $this->input->post('idmoneda'),
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'observaciones' => $this->input->post('observaciones'),
                'actualizado_por' => $session['SID']
            );
            $where = array(
                'idcotizacion_proveedor' => $this->input->post('idcotizacion_proveedor')
            );

            $resultado = $this->cotizaciones_proveedores_model->update($datos, $where);

            if ($resultado) {
                $where = array(
                    'idproveedor' => $this->input->post('idproveedor')
                );
                $proveedor = $this->proveedores_model->get_where($where);

                $where = array(
                    'idmoneda' => $this->input->post('idmoneda')
                );
                $moneda = $this->monedas_model->get_where($where);

                $log = array(
                    'tabla' => 'retenciones',
                    'idtabla' => $this->input->post('idcotizacion_proveedor'),
                    'texto' => "<h2><strong>Se actualizó la cabecera de la cotización de proveedor N°: " . $this->input->post('idcotizacion_proveedor') . "</strong></h2>

<p><strong>Proveedor: </strong>" . $proveedor['proveedor'] . "<br />
<strong>Moneda: </strong>" . $moneda['moneda'] . "<br />
<strong>Fecha de Cotizació: </strong>" . $this->input->post('fecha') . "<br />
<strong>Observaciones: </strong>" . $this->input->post('observaciones') . "</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'edit'
                );
                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => 'Se actualizó la cabecera de la cotización'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo actualizar la cabecera de la cotización'
                );
                echo json_encode($json);
            }
        }
    }

    public function agregar_archivos_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcotizacion_proveedor', 'ID Cotización', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            show_404();
        } else {
            $where = array(
                'identificador' => 'url_files_cotiz_prov',
                'idparametro_tipo' => 3
            );
            $url = $this->parametros_model->get_where($where);

            $filesCount = count($_FILES['files']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                $f = explode('.', $_FILES['file']['name']);

                $config['upload_path'] = '.' . $url['valor_sistema'];
                $config['allowed_types'] = '*';
                //$config['file_name'] = $_FILES['file']['name'];
                $config['owerwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file')) {
                    $error = array('error' => $this->upload->display_errors());
                    show_404();
                } else {
                    $data = array('upload_data' => $this->upload->data());

                    $datos = array(
                        'idcotizacion_proveedor' => $this->input->post('idcotizacion_proveedor'),
                        'nombre' => $_FILES['file']['name'],
                        'url' => $url['valor_sistema'] . $data['upload_data']['file_name'],
                        'fecha_creacion' => date("Y-m-d H:i:s"),
                        'idcreador' => $session['SID'],
                        'actualizado_por' => $session['SID']
                    );

                    $this->cotizaciones_proveedores_model->set_archivos($datos);
                }
            }
        }
    }

    public function agregar_articulo_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcotizacion_proveedor', 'ID Cotizacion Proveedor', 'required|integer');
        $this->form_validation->set_rules('idarticulo', 'Artículo', 'required|integer');
        $this->form_validation->set_rules('precio', 'Precio', 'required|decimal');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|integer');
        $this->form_validation->set_rules('fecha', 'Fecha', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $set = array(
                'idcotizacion_proveedor' => $this->input->post('idcotizacion_proveedor'),
                'idarticulo' => $this->input->post('idarticulo'),
                'precio' => $this->input->post('precio'),
                'cantidad' => $this->input->post('cantidad'),
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'idcreador' => $session['SID'],
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'actualizado_por' => $session['SID']
            );

            $id = $this->cotizaciones_proveedores_model->set_item($set);

            if ($id) {
                $where = array(
                    'idarticulo' => $this->input->post('idarticulo')
                );
                $articulo = $this->articulos_model->get_where($where);

                $where = array(
                    'idmarca' => $articulo['idmarca']
                );
                $marca = $this->marcas_model->get_where($where);

                $log = array(
                    'tabla' => 'cotizaciones_proveedores',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se agregó item a la cotización de proveedor número: " . $this->input->post('idcotizacion_proveedor') . "</strong></h2>

<p>
<strong>Artículo: </strong>" . $articulo['articulo'] . "<br />
<strong>Marca: </strong>" . $marca['marca'] . "<br />
<strong>Precio: </strong>" . $this->input->post('precio') . "<br />
<strong>Fecha de Entrega: </strong>" . $this->input->post('fecha') . "<br />
</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'add'
                );
                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => 'Se agregó el artículo ' . $articulo['articulo'] . ' - ' . $marca['marca']
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo agregar el artículo'
                );
                echo json_encode($json);
            }
        }
    }

    public function listar_archivos_tabla_ajax() {
        $where = array(
            'idcotizacion_proveedor' => $this->input->post('idcotizacion_proveedor'),
            'estado' => 'A'
        );
        $data['archivos'] = $this->cotizaciones_proveedores_model->gets_archivos_where($where);

        $this->load->view('cotizaciones_proveedores/listar_archivos_tabla_ajax', $data);
    }

    public function listar_articulos_tabla_ajax() {
        $where = array(
            'idcotizacion_proveedor' => $this->input->post('idcotizacion_proveedor'),
            'estado' => 'A'
        );

        $data['articulos'] = $this->cotizaciones_proveedores_model->gets_articulos_where($where);
        foreach ($data['articulos'] as $key => $value) {
            $where = array(
                'idarticulo' => $value['idarticulo']
            );
            $data['articulos'][$key]['articulo'] = $this->articulos_model->get_where($where);

            $where = array(
                'idmarca' => $data['articulos'][$key]['articulo']['idmarca']
            );
            $data['articulos'][$key]['marca'] = $this->marcas_model->get_where($where);

            $data['articulos'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha']);
        }

        $this->load->view('cotizaciones_proveedores/listar_articulos_tabla_ajax', $data);
    }

    public function borrar_archivo_ajax() {
        $datos = array(
            'estado' => 'I'
        );
        $where = array(
            'idcotizacion_proveedor_archivo' => $this->input->post('idcotizacion_proveedor_archivo')
        );

        $resultado = $this->cotizaciones_proveedores_model->update_archivo($datos, $where);

        if ($resultado) {
            $json = array(
                'status' => 'ok',
                'data' => 'Se borró el archivo adjunto'
            );
            echo json_encode($json);
        } else {
            $json = array(
                'status' => 'error',
                'data' => 'No se pudo borrar el archivo'
            );
            echo json_encode($json);
        }
    }

    public function borrar_articulo_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcotizacion_proveedor_item', 'ID Cotización Item', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'estado' => 'I'
            );
            $where = array(
                'idcotizacion_proveedor_item' => $this->input->post('idcotizacion_proveedor_item')
            );

            $resultado = $this->cotizaciones_proveedores_model->update_item($datos, $where);

            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se eliminó correctamente el artículo'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo eliminar el artículo'
                );
                echo json_encode($json);
            }
        }
    }
    
    public function listar($pagina = 0) {
        $data['title'] = 'Listar Cotización de Proveedores';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'cotizaciones_proveedores/listar';
        
        
        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();

        /*
         * inicio paginador
         */
        $total_rows = $this->cotizaciones_proveedores_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/retenciones/listar/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $data['total_rows'] = $total_rows;
        /*
         * fin paginador
         */

        $data['cotizaciones'] = $this->cotizaciones_proveedores_model->gets_where_limit($where, $per_page, $pagina);
        
        foreach($data['cotizaciones'] as $key => $value) {
            $data['cotizaciones'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha']);
            
            $where = array(
                'idproveedor' => $value['idproveedor']
            );
            $data['cotizaciones'][$key]['proveedor'] = $this->proveedores_model->get_where($where);
            
            $where = array(
                'idmoneda' => $value['idmoneda']
            );
            $data['cotizaciones'][$key]['moneda'] = $this->monedas_model->get_where($where);
            
            $where = array(
                'idcotizacion_proveedor' => $value['idcotizacion_proveedor'],
                'estado' => 'A'
            );
            $data['cotizaciones'][$key]['items'] = $this->cotizaciones_proveedores_model->gets_articulos_where($where);
            foreach($data['cotizaciones'][$key]['items'] as $key2 => $value2) {
                $where = array(
                    'idarticulo' => $value2['idarticulo']
                );
                $data['cotizaciones'][$key]['items'][$key2]['articulo'] = $this->articulos_model->get_where($where);
                
                $where = array(
                    'idlinea' => $data['cotizaciones'][$key]['items'][$key2]['articulo']['idlinea']
                );
                $data['cotizaciones'][$key]['items'][$key2]['articulo']['linea'] = $this->lineas_model->get_where($where);
                
                $where = array(
                    'idmarca' => $data['cotizaciones'][$key]['items'][$key2]['articulo']['idmarca']
                );
                $data['cotizaciones'][$key]['items'][$key2]['articulo']['marca'] = $this->marcas_model->get_where($where);
            }
        }

        $this->load->view('layout/app', $data);
    }

    private function formatear_fecha($fecha) {
        $aux = '';
        $aux .= substr($fecha, 6, 4);
        $aux .= '-';
        $aux .= substr($fecha, 3, 2);
        $aux .= '-';
        $aux .= substr($fecha, 0, 2);

        return $aux;
    }

    private function formatear_fecha_para_mostrar($fecha) {
        $aux = '';
        $aux .= substr($fecha, 8, 2);
        $aux .= '/';
        $aux .= substr($fecha, 5, 2);
        $aux .= '/';
        $aux .= substr($fecha, 0, 4);

        return $aux;
    }

}

?>