<?php

class Web extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('slider_model', 'slider');
        $this->load->model('producto_model', 'product');
        $this->load->model('categoria_model', 'category');
        $this->load->model('subcategoria_model', 'subcategory');
        $this->load->model('Producto_relacionado_model', 'related_product');
        $this->load->model('slidermarcas_model','slider_marcas');
    }

    public function index()
    {
        
        $categories = $this->category->get();
        $subcategories = $this->subcategory->get();
        $product_list = [];
        $products= $this->product->getFeaturedCategory();
        $user = $this->codegen_model->row('ecommerce_users', 'id_users,id_list_price', 'id_users = "'.$this->session->userdata('customer_id').'" AND ACTIVE = "'.ACTIVE.'"');

        foreach ($products as $k => $v)
        {
            $product_list = [];
            $ids = explode(',', $v->lista_id);
            $prices = explode(',', $v->prices);
            foreach ($ids as $l => $lp)
            {
                $product_list[$lp] = $prices[$l];
            }
            $v->prices = $product_list;
        }

        $vista_interna = array(
            'sliders' => $this->slider->get(),
            'load_Products' => $products,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),
            'category' => '',
            'marcas' => $this->slider_marcas->get(),
            'user' => $user,

        );

        $vista_config  = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/public/index', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config)
        );

        $this->load->view('template/frontend', $vista_externa);
    }

    public function products($id_category = 0, $type = 0, $page = 0)
    {
        $perpage = 9;
        $parameters = array(
            'category'  =>  $id_category,
            'type'      =>  $type,
            'page'      =>  $page,
            'perpage'   =>  $perpage,
            'search'    =>  $this->input->get('search'),
        );

        $product_list = [];
        $products = $this->product->getProductsFiltered($parameters);
        $user = $this->codegen_model->row('ecommerce_users', 'id_users,id_list_price', 'id_users = "'.$this->session->userdata('customer_id').'" AND ACTIVE = "'.ACTIVE.'"');

        foreach ($products as $k => $v)
        {
            $product_list = [];
            $ids = explode(',', $v->lista_id);
            $prices = explode(',', $v->prices);
            foreach ($ids as $l => $lp)
            {
                $product_list[$lp] = $prices[$l];
            }
            $v->prices = $product_list;
        }

        $parameters['count'] = 1;

        $this->load->library('pagination');

        $config['base_url']    = base_url('/productos'.'/'.$id_category.'/'.$type.'/');
        $config['total_rows']  = $this->product->getProductsFiltered($parameters);
        $config['per_page']    = $perpage;
        $config['uri_segment'] = $this->uri->total_segments();
        $config['full_tag_open']    = "<ul class='my-pagination float-right'>";
        $config['full_tag_close']   = "</ul>";
        $config['num_tag_open']     = '<li class="my-page-item">';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = "<li class='my-page-item active'><span class='my-page-link' href='#'>";
        $config['cur_tag_close']    = "</span></li>";
        $config['next_tag_open']    = "<li class=''>";
        $config['next_tagl_close']  = "</li>";
        $config['prev_tag_open']    = "<li class=''>";
        $config['prev_tagl_close']  = "</li>";
        $config['first_tag_open']   = "<li class='my-page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']    = "<li class='my-page-item'>";
        $config['prev_link'] = "<i class='fas fa-angle-left'></i>";
        $config['next_link'] ="<i class='fas fa-angle-right'></i>";
        $config['last_tagl_close']  = "</li>";
        $config['first_link']  = "Primero";
        $config['last_link']  = "Último";

        $this->pagination->initialize($config);

        $links = $this->pagination->create_links();
        $categories = $this->category->get();
        $subcategories = $this->subcategory->get();
        $category = '';

        switch ($type)
        {
            case '1':
                $category = $this->category->findBread($id_category);
                $category->id_subcategory = 0;
                break;
            case '2':
                $category = $this->subcategory->findDetail($id_category);
                break;
        }

        $vista_interna = array(
            'load_Products' => $products,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'links' => $links,
            'category' => $category,
            'user' => $user,

        );

        $vista_config  = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/public/products', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
            'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),

        );

        $this->load->view('template/frontend', $vista_externa);
    }

    public function product($id_product)
    {
        $result = $this->product->detail($id_product);
        $user = $this->codegen_model->row('ecommerce_users', 'id_users,id_list_price', 'id_users = "'.$this->session->userdata('customer_id').'" AND ACTIVE = "'.ACTIVE.'"');
        $product_list = [];
        $ids = explode(',', $result->lista_id);
        $prices = explode(',', $result->prices);

        foreach ($ids as $l => $lp)
        {
            $product_list[$lp] = $prices[$l];
        }

        $result->prices = $product_list;

        if (!$result)
        {
            redirect(base_url('productos'));
        }

        if ($this->input->post())
        {
            $filename = '';
            if ($_FILES['document']['tmp_name']!='')
            {
                $tmp_name = $_FILES['document']['tmp_name'];
                $name = $_FILES['document']['name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $filename = './uploads/files/'.uniqid().'.'.$ext;
                move_uploaded_file($tmp_name, $filename);
            }

            $data = array(
                'name' => $this->input->post('last_name').', '.$this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'description' => $this->input->post('description'),
                'product'   =>  $result->name,
                'document'  =>  $filename
            );

            $configuracion = $this->codegen_model->row('configurations', '*', 'id_configuration = 3');
            $this->frontend_lib->enviarEmail($data, 'frontend/email/consult', 'Consulta de Producto', $configuracion->value, $this->input->post('email'), '+ Limpieza');
            $this->session->set_flashdata('consult', 'La consulta ha sido enviada exitosamente.');
            redirect(base_url('producto').'/'.$id_product);

        }

        $categories = $this->category->get();
        $subcategories = $this->subcategory->get();
        $whatsapp = $this->codegen_model->row('configurations', '*', 'key_id="whatsapp"');

        $product_list = [];
        $related_products = $this->related_product->getRelatedProducts($id_product);
        $user = $this->codegen_model->row('ecommerce_users', 'id_users,id_list_price', 'id_users = "'.$this->session->userdata('customer_id').'" AND ACTIVE = "'.ACTIVE.'"');

        foreach ($related_products as $k => $v)
        {
            $product_list = [];
            $ids = explode(',', $v->lista_id);
            $prices = explode(',', $v->prices);
            foreach ($ids as $l => $lp)
            {
                $product_list[$lp] = $prices[$l];
            }
            $v->prices = $product_list;
        }
        
        $vista_interna = array(
            'result' => $result,
            'whatsapp' => $whatsapp,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'load_Products' => $related_products,
            'category' => '',
            'user' => $user,
        );

        $vista_config  = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/public/product', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
            'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),

        );

        $this->load->view('template/frontend', $vista_externa);

    }

    public function contact()
    {
        if ($this->input->post())
        {
            $data = array(
                'name' => $this->input->post('last_name').', '.$this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'message' => $this->input->post('message'),
            );
            $configuration = $this->codegen_model->row('configurations', '*', 'id_configuration = 3');
            $this->frontend_lib->enviarEmail($data, 'frontend/email/contact', 'Contacto', $configuration->value, $this->input->post('email'), '+ LIMPIEZA');
            $this->session->set_flashdata('contact', 'El mensaje ha sido enviada exitosamente.');
            redirect(base_url('contacto'));
        }

        $vista_interna = array(
            'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),
        );
        $vista_config  = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/public/contact', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config)
        );

        $this->load->view('template/frontend', $vista_externa);

    }

    public function offers($id_category = 0, $type = 0, $page = 0)
    {
        $perpage = 9;
        $parameters = array(
            'category'  =>  $id_category,
            'type'      =>  $type,
            'page'      =>  $page,
            'perpage'   =>  $perpage,
            'offer'     =>  1,
        );
        $product_list=[];
        $products = $this->product->getProductsFiltered($parameters);
        $user = $this->codegen_model->row('ecommerce_users', 'id_users,id_list_price', 'id_users = "'.$this->session->userdata('customer_id').'" AND ACTIVE = "'.ACTIVE.'"');
        foreach ($products as $k => $v)
        {
            $product_list = [];
            $ids = explode(',', $v->lista_id);
            $prices = explode(',', $v->prices);
            foreach ($ids as $l => $lp)
            {
                $product_list[$lp] = $prices[$l];
            }
            $v->prices = $product_list;
        }
        $parameters['count'] = 1;
        $count = $this->product->getProductsFiltered($parameters);
        $total_rows = $count;
        $this->load->library('pagination');
        $config['base_url']    = base_url('productos'.'/'.$id_category.'/'.$type.'/');
        $config['total_rows']  = $total_rows;
        $config['per_page']    = $perpage;
        $config['uri_segment'] = $this->uri->total_segments();
        $config['full_tag_open']    = "<ul class='my-pagination float-right'>";
        $config['full_tag_close']   = "</ul>";
        $config['num_tag_open']     = '<li class="my-page-item">';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = "<li class='my-page-item active'><span class='my-page-link' href='#'>";
        $config['cur_tag_close']    = "</span></li>";
        $config['next_tag_open']    = "<li class=''>";
        $config['next_tagl_close']  = "</li>";
        $config['prev_tag_open']    = "<li class=''>";
        $config['prev_tagl_close']  = "</li>";
        $config['first_tag_open']   = "<li class='my-page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']    = "<li class='my-page-item'>";
        $config['prev_link'] = "<i class='fas fa-angle-left'></i>";
        $config['next_link'] ="<i class='fas fa-angle-right'></i>";
        $config['last_tagl_close']  = "</li>";
        $config['first_link']  = "Primero";
        $config['last_link']  = "Último";
        $this->pagination->initialize($config);
        $links = $this->pagination->create_links();
        $categories = $this->category->get();
        $subcategories = $this->subcategory->get();
        $category='';

        switch ($type)
        {
            case '1':
                $category = $this->category->findBread($id_category);
                $category->id_subcategory = 0;
                break;
            case '2':
                $category = $this->subcategory->findDetail($id_category);
                break;
        }

        $vista_interna = array(
            'load_Products' => $products,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'links' => $links,
            'category' => $category,
            'offer' => 1,
            'user' => $user,

        );
        $vista_config  = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/public/products', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
            'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),

        );

        $this->load->view('template/frontend', $vista_externa);
    }

    public function how_to_buy()
    {
        $vista_interna = array(
            'section'   =>  $this->codegen_model->row('sections', '*', 'id_section = 2'),
        );
        $vista_config  = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/public/how_to_buy', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
            'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),

        );

        $this->load->view('template/frontend', $vista_externa);
    }

    public function enterprise()
    {
        $vista_interna = array(
            'section'   =>  $this->codegen_model->row('sections', '*', 'id_section = 1'),
        );
        $vista_config  = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/public/enterprise', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
            'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),

        );

        $this->load->view('template/frontend', $vista_externa);
    }
}
