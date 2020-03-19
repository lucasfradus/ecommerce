<?php

class Widget extends CI_Controller
{

    private $permisos;

    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
        $this->load->model('widget_model', 'widget');
    }

    public function render($vista, $data = array(), $title = null)
    {

        $data['permisos_efectivos'] = $this->permisos;

        $vista_externa = array(
            'title' => ucwords('widgets'),
            'contenido_main' => $this->load->view($vista['view'], $data, true),
        );

        if (empty($vista['template'])) {
            $vista['template'] = 'template/backend';
        }

        $this->load->view($vista['template'], $vista_externa);
    }

    public function index()
    {
        $datos = array(
            'results' => $this->widget->get(),
        );

        $vista = array(
            'view' => 'components/ecommerce/widget/widget_list',
        );

        $this->render($vista, $datos);
    }

    function edit($id)
    {

        if ($this->input->post('enviar_form')) {
            $widget = array(
                'url' => $this->input->post('url')
            );

            if (!empty($_FILES['imagen']['tmp_name'])) {
                $imagen = $this->backend_lib->imagen_upload('imagen', 'widgets');
                $widget['image'] = $imagen;
            }

            $this->widget->edit($widget, $id);

            redirect(base_url('ecommerce/widget'), 'refresh');
        }

        $datos = array(
            'result' => $this->widget->find($id),
        );

        $vista = array(
            'view' => 'components/ecommerce/widget/widget_edit',
        );

        $this->render($vista, $datos);
    }

    function view($id)
    {

        $datos = array(
            'result' => $this->widget->find($id),
        );

        $vista = array(
            'view' => 'components/ecommerce/widget/widget_view',
            'template' => 'template/view',
        );

        $this->render($vista, $datos);
    }

    function delete($id)
    {
        
        $widget = array(
            'active' => DELETE,
        );

        $this->widget->edit($widget, $id);
    }
}
