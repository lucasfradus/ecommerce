<?php

class Categorias extends CI_Controller
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
            'results' => $this->categoria->get()
        );

        $vista_externa = array(
            'title' => ucwords("categorías"),
            'contenido_main' => $this->load->view('components/ecommerce/categorias/categorias_list', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function add()
    {

        if ($this->input->post('enviar_form')) {
            $data = array(
                'name' => $this->input->post('nombre'),
                'create_by' =>  $this->session->userdata('user_id')
            );

            $this->categoria->insert($data);

            redirect(base_url('ecommerce/categorias'), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
        );

        $vista_externa = array(
            'title' => ucwords("categorías"),
            'contenido_main' => $this->load->view('components/ecommerce/categorias/categorias_add', $vista_interna, true)
        );
   
        $this->load->view('template/backend', $vista_externa);
    }

    function edit($id)
    {
        if ($this->input->post('enviar_form'))
        {
            $data = array(
                'name' => $this->input->post('nombre'),
                'update_by' =>  $this->session->userdata('user_id')
            );

            $this->categoria->edit($data, $id);

            redirect(base_url('ecommerce/categorias'), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->categoria->find($id)
        );

        $vista_externa = array(
            'title' => ucwords("categorías"),
            'contenido_main' => $this->load->view('components/ecommerce/categorias/categorias_edit', $vista_interna, true)
        );
   
        $this->load->view('template/backend', $vista_externa);
    }

    function view($id)
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->categoria->find($id),
        );

        $vista_externa = array(
            'title' => ucwords("categorías"),
            'contenido_main' => $this->load->view('components/ecommerce/categorias/categorias_view', $vista_interna, true)
        );
   
        $this->load->view('template/view', $vista_externa);
    }

    function delete($id)
    {
        $data = array(
            'active' => 0,
            'deleted_at'    =>  date('Y-m-d H:i:s'),
            'delete_by' =>  $this->session->userdata('user_id')

        );

        $this->categoria->edit($data, $id);

        $this->subcategoria->editCategory($data, $id);
    }

    function json($id)
    {
        $categories = $this->categoria->getCategorias($id);
        echo json_encode(array('data' => $categories));
    }
}
