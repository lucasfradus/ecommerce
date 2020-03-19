<?php
class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('envio_model', 'envio');
        $this->load->model('pedido_model', 'pedido');
        $this->load->model('producto_model', 'producto');
        $this->load->model('producto_stock_model', 'producto_stock');
        $this->load->model('customer_model', 'customer');
        $this->load->model('shipping_model', 'shipping');
        $this->load->model('pedido_model', 'order');
    }

    public function profile()
    {
        $user_id = $this->session->userdata('customer_id');

        if ($this->input->post('enviar_form'))
        {
            $data_update = [
                'name' => $this->input->post('name'),
                'surname' => $this->input->post('surname'),
                'provincia_id' => $this->input->post('province'),
                'localidad_id' => $this->input->post('location'),
                'phone' => $this->input->post('telephone'),
                'address' => $this->input->post('address'),
                'email' => $this->input->post('email'),
            ];

            $data_where = [
                'id_users' => $user_id,
            ];

            $this->customer->edit($data_update, $data_where);

            redirect(base_url('dashboard'), 'refresh');

        }

        $data_where = [
            'id_users' => $user_id,
        ];

        $user = $this->customer->find($data_where);

        $vista_interna = array(
            'user' => $user,
            'provinces' => $this->codegen_model->get('geo_provincias', '*', 'id != "0" ORDER BY provincia'),
            'locations' => $this->codegen_model->get('localidades', '*', 'id_provincia = "' . $user->provincia_id . '" ORDER BY localidad'),
        );

        $vista_config  = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/private/dashboard', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
        );

        $this->load->view('template/frontend', $vista_externa);

    }

    public function order()
    {
        if (!$this->session->userdata('customer_id'))
        {
            redirect(base_url('login'), 'refresh');
        }

        $vista_interna = array(
            'orders' => $this->order->findByUserId($this->session->userdata('customer_id')),
        );

        $vista_config  = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/private/order', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config)
        );

        $this->load->view('template/frontend', $vista_externa);

    }

}
