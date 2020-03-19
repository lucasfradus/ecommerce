<?php

class Envios extends CI_Controller
{

    private $permisos;

    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
        $this->load->model('Envio_model', 'envios');
    }

    public function index()
    {
        
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'results' => $this->envios->get(),
            'res'   =>  $this->envios->getList(),
        );

        $vista_externa = array(
            'title' => ucwords("envios"),
            'contenido_main' => $this->load->view('components/ecommerce/envios/envios_list', $vista_interna, true)
        );
        
        $this->load->view('template/backend', $vista_externa);
    }

    public function view($id)
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->envios->find($id),
            'days'  =>  $this->envios->getEnviosDays($id),
        );

        $vista_externa = array(
            'title' => ucwords("envios"),
            'contenido_main' => $this->load->view('components/ecommerce/envios/envios_view', $vista_interna, true)
        );

        $this->load->view('template/view', $vista_externa);
    }

    public function add()
    {
        if ($this->input->post('enviar_form'))
        {
            $data = array(
            'postal_code' => $this->input->post('postal_code'),
            'price_shipping' => $this->input->post('price_shipping'),
            'create_by' => $this->session->userdata('user_id')
            );
            $shipping_id=$this->codegen_model->addNoAudit('shippings', $data);
            $days = $this->input->post('days');
            if ($days) {
                foreach ($days as $k => $v)
                {
                    $dataShipping = [
                    	'id_shipping' => $shipping_id,
                    	'days' => $v,
                   		'create_by' => $this->session->userdata('user_id')
                    ];
                    $this->codegen_model->addNoAudit('shipping_days', $dataShipping);
                }
            }
            redirect(base_url('ecommerce/envios'), 'refresh');
        }
        
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
        );

        $vista_externa = array(
            'title' => ucwords("envios"),
            'contenido_main' => $this->load->view('components/ecommerce/envios/envios_add', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    public function edit($id)
    {
        $shipping_id = $id;
        if ($this->input->post('enviar_form'))
        {
            $data = array(
            'postal_code' => $this->input->post('postal_code'),
            'price_shipping' => $this->input->post('price_shipping'),
            'update_by' => $this->session->userdata('user_id')
            );

            $this->envios->edit($data, $shipping_id);

            $data = array(
                'active'    => 0,
            );
            $this->envios->delete($data, $shipping_id);

            $days = $this->input->post('days');
            if ($days)
            {
                foreach ($days as $k => $v)
                {
                    $dataShipping = [
                    	'id_shipping' => $shipping_id,
                    	'days' => $v,
                    	'update_by' => $this->session->userdata('user_id')
                    ];
                    $this->codegen_model->addNoAudit('shipping_days', $dataShipping);
                }
            }
            redirect(base_url('ecommerce/envios'), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->envios->find($id),
            'days'  =>  $this->envios->getEnviosDaysEdit($id),
        );

        $vista_externa = array(
            'title' => ucwords("envios"),
            'contenido_main' => $this->load->view('components/ecommerce/envios/envios_edit', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);

    }

    public function delete($id)
    {
        $shipping_id=$id;

        $zonedata = array(
            'active' => 0,
            'deleted_at'        =>  date('Y-m-d H:i:s'),
            'delete_by'=>  $this->session->userdata('user_id')

        );

        $this->envios->deletezone($zonedata, $shipping_id);

        $daysdata= array(
            'active' => 0,
            'deleted_at'        =>  date('Y-m-d H:i:s'),
            'delete_by'=>  $this->session->userdata('user_id')
        );

        $this->envios->delete($daysdata, $shipping_id);

        redirect(base_url('ecommerce/envios'), 'refresh');

    }

    public function ValidarCodePostal()
    {
        $postalcode = $this->codegen_model->row('shippings', '*', 'postal_code = "'.$this->input->post('postal_code').'"');
        if ($postalcode != null) {
            if ($this->session->userdata('postal_code')) {
                if ($this->session->userdata('postal_code') == $postalcode->postal_code) {
                       echo json_encode(array('Value' => 1));
                } else {
                        echo json_encode(array('Value' => 0));
                }
            } else {
                if ($postalcode->active != 0) {
                    echo json_encode(array('Value' => 0));
                } else {
                    echo json_encode(array('Value' => 1));
                }
            }
        } else {
            echo json_encode(array('Value' => 1));
        }

    }

}
