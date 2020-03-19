<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Descuentos extends CI_Controller
{
    private $permisos;

    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
        $this->load->model('discount_model', 'discount');
    }

    function render($vista, $data = array(), $title = null)
    {
        $data['permisos_efectivos'] = $this->permisos;

        $vista_externa = array(
            'title' => ucwords('descuentos'),
            'contenido_main' => $this->load->view($vista['view'], $data, true),
        );

        if (empty($vista['template'])) {
            $vista['template'] = 'template/backend';
        }

        $this->load->view($vista['template'], $vista_externa);
    }

    function index()
    {
        $datos = array(
            'results' => $this->discount->get(),
        );

        $vista = array(
            'view' => 'components/ecommerce/discounts/discounts_list',
        );

        $this->render($vista, $datos);
    }

    function add()
    {
        if ($this->input->post('enviar_form')) {
            $discount = array(
                'discount' => $this->input->post('discount'),
                'max'   =>  $this->input->post('maximo'),
                'min'   =>  $this->input->post('minimo'),
                'create_by' =>  $this->session->userdata('user_id')
            );

            $id_discount_code = $this->discount->insert($discount);

            redirect(base_url('ecommerce/descuentos'), 'refresh');
        }

        $datos = array(
            'results' => $this->discount->get(),
        );

        $vista = array(
            'view' => 'components/ecommerce/discounts/discounts_add',
        );

        $this->render($vista, $datos);
    }

    function edit($id)
    {
        if ($this->input->post('enviar_form')) {
            $data = array(
                'discount' => $this->input->post('discount'),
                'max'   =>  $this->input->post('maximo'),
                'min'   =>  $this->input->post('minimo'),
                'update_by' =>  $this->session->userdata('user_id')
            );

            $this->discount->edit($data, $id);

            redirect(base_url('ecommerce/descuentos'), 'refresh');
        }

        $datos = array(
            'result' => $this->discount->find($id),
        );

        $vista = array(
            'view' => 'components/ecommerce/discounts/discounts_edit',
        );

        $this->render($vista, $datos);
    }

    function view($id)
    {
        $datos = array(
            'result' => $this->discount->find($id),
        );

        $vista = array(
            'view' => 'components/ecommerce/discounts/discounts_view',
            'template' => 'template/view',
        );

        $this->render($vista, $datos);
    }

    function delete($id)
    {
        $discount = array(
            'active' => DELETE,
            'delete_by' => $this->session->userdata('user_id'),
            'deleted_at' => date('Y-m-d H:i:s')
        );

        $this->discount->edit($discount, $id);
    }
}
