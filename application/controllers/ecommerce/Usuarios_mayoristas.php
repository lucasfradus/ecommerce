<?php

class Usuarios_mayoristas extends CI_Controller
{

    private $permisos;

    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
        $this->load->model('sudaca_ecommerce_md');
    }

    function index()
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'results' => $this->sudaca_ecommerce_md->getUsuario()
        );

        $vista_externa = array(
            'title' => ucwords("Usuarios Mayoristas"),
            'contenido_main' => $this->load->view('components/ecommerce/usuarios_mayoristas/usuarios_mayoristas_list', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function add()
    {
        if ($this->input->post('enviar_form'))
        {
            $data = array(
                'email'             =>  $this->input->post('email'),
                'password'          =>  md5($this->input->post('password')),
                'name'              =>  $this->input->post('nombre'),
                'surname'           =>  $this->input->post('apellido'),
                'phone'             =>  $this->input->post('telefono'),
                'status_code_confirmation'  =>  $this->input->post('status'),
                'dni'               =>  $this->input->post('dni'),
                'id_condition_iva'  =>  $this->input->post('condicion_iva'),
                'id_list_price'     =>  $this->input->post('precios_id'),
                'provincia_id'      =>  $this->input->post('provincia_id'),
                'localidad_id'      =>  $this->input->post('localidad_id'),
                'address'           =>  $this->input->post('direccion'),
                'country'           =>  $this->input->post('pais'),
                'create_by'         =>  $this->session->userdata('user_id')
            );

            $usuario_id = $this->codegen_model->addNoAudit('ecommerce_users', $data);

            redirect(base_url('ecommerce/usuarios_mayoristas'), 'refresh');

        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'provincias' => $this->codegen_model->get('geo_provincias', '*', ''),
            'IVA' => $this->codegen_model->get('condition_iva', '*', ''),
            'pricelist' => $this->codegen_model->get('list_price', '*', ''),
        );

        $vista_externa = array(
            'title' => ucwords("Usuarios Mayoristas"),
            'contenido_main' => $this->load->view('components/ecommerce/usuarios_mayoristas/usuarios_mayoristas_add', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);

    }

    function edit($id)
    {
        if ($this->input->post('enviar_form'))
        {
            $usuario_id = $id;

            $data = array(
                'name'              =>  $this->input->post('nombre'),
                'surname'           =>  $this->input->post('apellido'),
                'phone'             =>  $this->input->post('telefono'),
                'status_code_confirmation' =>   $this->input->post('status'),
                'id_condition_iva'  =>  $this->input->post('condicion_iva'),
                'id_list_price'     =>  $this->input->post('precios_id'),
                'provincia_id'      =>  $this->input->post('provincia_id'),
                'localidad_id'      =>  $this->input->post('localidad_id'),
                'address'           =>  $this->input->post('direccion'),
                'country'           =>  $this->input->post('pais'),
                'update_by'         =>  $this->session->userdata('user_id'),
                'dni'               =>  $this->input->post('dni'),
            );

            $this->codegen_model->edit('ecommerce_users', $data, 'id_users', $usuario_id);

            redirect(base_url('ecommerce/usuarios_mayoristas'));

        }

        $usuario = $this->codegen_model->row('ecommerce_users', '*', 'id_users = '.$id);
    

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'usuario'       =>  $usuario,
            'provincias'    =>  $this->codegen_model->get('geo_provincias', '*', ''),
            'pricelist' => $this->codegen_model->get('list_price', '*', ''),
            'IVA'   => $this->codegen_model->get('condition_iva', '*', ''),
            'localidades'   => $this->codegen_model->get('localidades', '*', 'id_provincia = "'.$usuario->provincia_id.'"'),
            'users_provincias'  =>  $this->codegen_model->get('users_provincias', '*', 'id_users = "'.$id.'"'),
            'users_localidades' =>  $this->codegen_model->get('users_localidades', '*', 'id_users = "'.$id.'"'),
            
        );

        $vista_externa = array(
            'title' => ucwords("Usuarios Mayoristas"),
            'contenido_main' => $this->load->view('components/ecommerce/usuarios_mayoristas/usuarios_mayoristas_edit', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function view($id)
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->sudaca_ecommerce_md->rowUsuario($id)
        );

        $vista_externa = array(
            'title' => ucwords("Usuarios Mayoristas"),
            'contenido_main' => $this->load->view('components/ecommerce/usuarios_mayoristas/usuarios_mayoristas_view', $vista_interna, true)
        );

        $this->load->view('template/view', $vista_externa);
    }

    function json($id)
    {
        $json = $this->codegen_model->row('ecommerce_users', '*', 'id = '.$id);
        if ($json) {
            echo json_encode($json);
        } else {
            echo json_encode(array('status' => 'none'));
        }
    }

    function json_all()
    {
        $json = $this->codegen_model->get('ecommerce_users', '*', '');
        if ($json) {
            echo json_encode($json);
        } else {
            echo json_encode(array('status' => 'none'));
        }
    }

    function deletelogic($id)
    {
        $usuario_id=$id;
        $datos = array(
            'active' => DELETE,
            'status_code_confirmation' => DELETE,
            'delete_at'     =>  date('Y-m-d H:i:s'),
            'delete_by'=>  $this->session->userdata('user_id')

        );
        $this->codegen_model->edit('ecommerce_users', $datos, 'id_users', $usuario_id);
    }

    function delete($id)
    {
        $this->codegen_model->delete('ecommerce_users', 'id_users', $id);
    }

    function cambiarValor()
    {
        $id = $this->input->post('id');
        $usuario = $this->codegen_model->row('ecommerce_usuarios', '*', 'id = '.$id);
        if ($usuario->estado_codigo_confirmacion == 0)
        {
            $valor = 1;
            $mensaje = 'activada';
        }
        if ($usuario->estado_codigo_confirmacion == 1) {
            $valor = 3;
            $mensaje = 'desactivada';
        }
        if ($usuario->estado_codigo_confirmacion == 3) {
            $valor = 1;
            $mensaje = 'activada';
        }

        $data = array('estado_codigo_confirmacion' => $valor);
        $this->codegen_model->edit('ecommerce_usuarios', $data, 'id', $id);

        $datos = array(
            'mensaje' => $mensaje,
        );

        $configuracion = $this->codegen_model->row('configurations', '*', 'id = 3');
        $this->frontend_lib->enviarEmail($datos, 'frontend/email/activar', 'Activacion de cuenta', $usuario->email, $configuracion->valor, 'tails');

        $data = array(
            'id' => $valor,
        );
        print_r(json_encode($data, JSON_FORCE_OBJECT));
    }

    function ventas($id)
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'results' => $this->codegen_model->get('planos_ventas', '*', 'afiliado_id = "'.$id.'"'),
        );

        $vista_externa = array(
            'title' => ucwords("ventas afiliado"),
            'contenido_main' => $this->load->view('components/ecommerce/usuarios_mayoristas/usuarios_mayoristas_ventas', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function pagos($id)
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'results' => $this->codegen_model->get('pagos_afiliado', '*', 'usuario_id = '.$id),
            'result' => $this->codegen_model->row('ecommerce_usuarios', '*', 'id = '.$id),
        );

        $vista_externa = array(
            'title' => ucwords("Pagos Afiliado"),
            'contenido_main' => $this->load->view('components/ecommerce/usuarios_mayoristas/usuarios_mayoristas_pagos', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function agregarPago()
    {
        $data = array(
            'usuario_id' => $this->input->post('id'),
            'importe' => $this->input->post('importe'),
            'plataforma_id' => $this->input->post('plataforma'),
            'fecha' => $this->input->post('fecha'),
        );
        $id = $this->codegen_model->add("pagos_afiliado", $data);
        echo json_encode(array('id' => $id));
    }

    function mensaje()
    {
        $this->load->view("frontend/email/registro_afiliado");
    }

    function compras($user_id)
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'results'   => $this->sudaca_frontend_md->getComprasUsers($user_id, 0),
            'user' => $this->sudaca_frontend_md->getUser($user_id)
        );

        $vista_externa = array(
           'title' => ucwords("Compras"),
           'contenido_main' => $this->load->view('components/ecommerce/usuarios_mayoristas/usuarios_mayoristas_pagos', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);

    }

    function view_compra($id)
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
        );

        $vista_externa = array(
            'title' => ucwords("usuarios Mayoristas"),
            'contenido_main' => $this->load->view('components/ecommerce/usuarios_mayoristas/productos', $vista_interna, true)
        );

        $this->load->view('template/view', $vista_externa);
    }
}

/* End of file usuarios.php */
/* Location: ./system/application/controllers/usuarios.php */
