<?php

class Subcategorias extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
        $this->load->model('categoria_model', 'categoria');
        $this->load->model('subcategoria_model', 'subcategoria');
    }
    
    function index()
    {

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'results' => $this->subcategoria->getCategoriasSubcategorias()
        );

        $vista_externa = array(
            'title' => ucwords("subcategorías"),
            'contenido_main' => $this->load->view('components/ecommerce/subcategorias/subcategorias_list', $vista_interna, true)
        );
        
        $this->load->view('template/backend', $vista_externa);
    }

    function add()
    {
        if ($this->input->post('enviar_form')) {
            $data = array(
                'id_category' => $this->input->post('categoria_id'),
                'name' => $this->input->post('nombre'),
                'create_by' =>  $this->session->userdata('user_id')
                
            );
            $this->subcategoria->insert($data);
            redirect(base_url('ecommerce/subcategorias'), 'refresh');
        }
   
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'categorias' => $this->categoria->get()
        );

        $vista_externa = array(
            'title' => ucwords("subcategorías"),
            'contenido_main' => $this->load->view('components/ecommerce/subcategorias/subcategorias_add', $vista_interna, true)
        );
   
        $this->load->view('template/backend', $vista_externa);
    }

    function edit($id)
    {
        if ($this->input->post('enviar_form')) {
            $data = array(
                'id_category' => $this->input->post('categoria_id'),
                'name' => $this->input->post('nombre'),
                'update_by' =>  $this->session->userdata('user_id')
            );
            $this->subcategoria->edit($data, $id);
            redirect(base_url('ecommerce/subcategorias'), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->subcategoria->find($id),
            'categorias' => $this->categoria->get(),
        );

        $vista_externa = array(
            'title' => ucwords("subcategorías"),
            'contenido_main' => $this->load->view('components/ecommerce/subcategorias/subcategorias_edit', $vista_interna, true)
        );
   
        $this->load->view('template/backend', $vista_externa);
    }

    function view($id)
    {
        $this->data['result'] = $this->subcategoria->find($id);
        $datos_plantilla["title"] = ucwords("subcategorías");
        $datos_plantilla["contenido_main"] = $this->load->view('components/ecommerce/subcategorias/subcategorias_view', $this->data, true);
        $this->load->view('template/view', $datos_plantilla);
    }

    function delete($id)
    {
        $data = array(
            'active'    => 0,
            'deleted_at'    =>  date('Y-m-d H:i:s'),
            'delete_by' =>  $this->session->userdata('user_id')
        );
        $this->subcategoria->edit($data, $id);
    }

    function json($id)
    {
        $subcategories = $this->subcategoria->getCategory($id);
        echo json_encode(array('data' => $subcategories));
    }
}
