<?php

class Configuraciones extends CI_Controller
{

    private $permisos;

    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
    }
    
    function index()
    {

        if ($this->input->post('enviar_form')) {
            $confi = $this->codegen_model->get('configurations', '*', 'enabled = "1" ORDER BY ordering');
            
            foreach ($confi as $f) {
                if (empty($this->input->post('configuracion-'.$f->id_configuration))) {
                    $data = array('value' => '');

                    $this->codegen_model->edit('configurations', $data, 'id_configuration', $f->id_configuration);
                } else {
                    $data = array('value' => $this->input->post('configuracion-'.$f->id_configuration));
                    $this->codegen_model->edit('configurations', $data, 'id_configuration', $f->id_configuration);
                }
            }

            redirect(base_url('backend/configuraciones/'), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'configuraciones' => $this->codegen_model->get('configurations', '*', 'enabled = "1" ORDER BY ordering')
        );

        $vista_externa = array(
            'title' => ucwords("configuraciones"),
            'contenido_main' => $this->load->view('backend/configuraciones/configuraciones', $vista_interna, true)
        );
        
        $this->load->view('template/backend', $vista_externa);
    }
}

/* End of file configuraciones.php */
/* Location: ./system/application/controllers/configuraciones.php */
