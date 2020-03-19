<?php

class Usuarios extends CI_Controller
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
            'title' => ucwords("usuarios"),
            'contenido_main' => $this->load->view('components/cms/usuarios/usuarios_list', $vista_interna, true)
        );
        
        $this->load->view('template/backend', $vista_externa);
    }

    function add()
    {
        if ($this->input->post('enviar_form')) {
            $data = array(
                    'tipo_usuario_id' => $this->input->post('tipo_usuario_id'),
                    'usuario' => $this->input->post('usuario'),
                    'password' => $this->input->post('password'),
                    'telefono_contacto' => $this->input->post('telefono_contacto'),
                    'persona_contacto' => $this->input->post('persona_contacto'),
                    'direccion' => $this->input->post('direccion'),
                    'localidad' => $this->input->post('localidad'),
                    'provincia' => $this->input->post('provincia'),
                    'pais' => $this->input->post('pais'),
                    'cuil' => $this->input->post('cuil')
                );
            $this->codegen_model->add('ecommerce_usuarios', $data);
            redirect(base_url().'ecommerce/usuarios');
        }
   
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos
        );

        $vista_externa = array(
            'title' => ucwords("usuarios"),
            'contenido_main' => $this->load->view('components/cms/usuarios/usuarios_add', $vista_interna, true)
        );
   
        $this->load->view('template/backend', $vista_externa);
    }

    function edit($id)
    {
        if ($this->input->post('enviar_form')) {
            $data = array(
                    'tipo_usuario_id' => $this->input->post('tipo_usuario_id'),
                    'usuario' => $this->input->post('usuario'),
                    'password' => $this->input->post('password'),
                    'telefono_contacto' => $this->input->post('telefono_contacto'),
                    'persona_contacto' => $this->input->post('persona_contacto'),
                    'direccion' => $this->input->post('direccion'),
                    'localidad' => $this->input->post('localidad'),
                    'provincia' => $this->input->post('provincia'),
                    'pais' => $this->input->post('pais'),
                    'cuil' => $this->input->post('cuil')
                );
            $this->codegen_model->edit('ecommerce_usuarios', $data, 'id', $this->input->post('id'));
            redirect(base_url().'cecommerce/usuarios');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->codegen_model->row('ecommerce_usuarios', '*', 'id = '.$id)
        );

        $vista_externa = array(
            'title' => ucwords("usuarios"),
            'contenido_main' => $this->load->view('components/cms/usuarios/usuarios_edit', $vista_interna, true)
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
            'title' => ucwords("usuarios"),
            'contenido_main' => $this->load->view('components/cms/usuarios/usuarios_view', $vista_interna, true)
        );
   
        $this->load->view('template/view', $vista_externa);
    }

    function json($id)
    {
        $json = $this->codegen_model->row('ecommerce_usuarios', '*', 'id = '.$id);
        if ($json) {
            echo json_encode($json);
        } else {
            echo json_encode(array('status' => 'none'));
        }
    }

    function json_all()
    {
        $json = $this->codegen_model->get('ecommerce_usuarios', '*', '');
        if ($json) {
            echo json_encode($json);
        } else {
            echo json_encode(array('status' => 'none'));
        }
    }
    
    function delete($id)
    {
        $this->codegen_model->delete('ecommerce_usuarios', 'id', $id);
    }

    function cambiarValor()
    {
        
        $id = $this->input->post('id');
        
        $usuario = $this->codegen_model->row('ecommerce_usuarios', '*', 'id = '.$id);

        if ($usuario->estado_codigo_confirmacion == 0)
        {
            $valor = 1;
        } else {
            $valor = 0;
        }

        $data = array('estado_codigo_confirmacion' => $valor);
        $this->codegen_model->edit('ecommerce_usuarios', $data, 'id', $id);

        $data = array(
            'id' => $valor,
        );

        echo json_encode($data);
    }
}

/* End of file usuarios.php */
/* Location: ./system/application/controllers/usuarios.php */
