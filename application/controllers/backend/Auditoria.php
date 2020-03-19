<?php

class Auditoria extends CI_Controller
{

    private $permisos;

    public function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
    }

    public function index()
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'results' => $this->codegen_model->getWhereJoin('', 'l.*, u.username AS nombre_usuario', '', 'auditoria l', 'users u', 'l.user_id = u.id'),
        );

        $vista_externa = array(
            'title' => ucwords("auditoria"),
            'contenido_main' => $this->load->view('backend/auditoria/auditoria_list', $vista_interna, true),
        );

        $this->load->view('template/backend', $vista_externa);
    }
}

/* End of file auditoria.php */
/* Location: ./system/application/controllers/auditoria.php */
