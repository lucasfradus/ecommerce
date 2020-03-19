<?php

class Secciones extends CI_Controller
{

    private $permisos;
    
    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
        $this->load->model('seccion_model', 'seccion');
    }
    
    function index()
    {

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'results' => $this->seccion->get()
        );

        $vista_externa = array(
            'title' => ucwords("secciones"),
            'contenido_main' => $this->load->view('components/cms/secciones/secciones_list', $vista_interna, true)
        );
        
        $this->load->view('template/backend', $vista_externa);
    }

    function edit($id)
    {

        if ($this->input->post('enviar_form')) {
            $data = array(
                'name' => $this->input->post('nombre'),
                'description' => $this->input->post("descripcion"),
            );

            $this->seccion->edit($data, $id);
            
            redirect(base_url('cms/secciones'), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->seccion->find($id),
        );

        $vista_externa = array(
            'title' => ucwords("secciones"),
            'contenido_main' => $this->load->view('components/cms/secciones/secciones_edit', $vista_interna, true)
        );
   
        $this->load->view('template/backend', $vista_externa);
    }

    function view($id)
    {

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->seccion->find($id)
        );

        $vista_externa = array(
            'title' => ucwords("secciones"),
            'contenido_main' => $this->load->view('components/cms/secciones/secciones_view', $vista_interna, true)
        );
   
        $this->load->view('template/view', $vista_externa);
    }

    function delete($id)
    {
        $seccion_estado = array(
            'active' => DELETE,
        );
        $this->seccion->edit($seccion_estado, $id);
    }
}
