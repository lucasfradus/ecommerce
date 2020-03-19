<?php

class Slider_marcas extends CI_Controller {

	private $permisos;
	
	function __construct() {
		parent::__construct();
		$this->permisos = $this->permisos_lib->control();
		$this->load->model('slidermarcas_model','slider_marcas');
	}	
	
	function index(){
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'results' => $this->slider_marcas->get()
		);

		$vista_externa = array(			
			'title' => ucwords("Slider Marcas"),
			'contenido_main' => $this->load->view('components/cms/slider_marcas/slider_marcas_list', $vista_interna, true)
		);		
		
		$this->load->view('template/backend', $vista_externa);
	}

	function add(){
		if ($this->input->post('enviar_form')) {
			
            $imagen = $this->backend_lib->imagen_upload_simple('imagen', 'slider_marcas');

            $data = array(
				'nombre_slider_marcas' => $this->input->post('nombre'),
				'active' => ACTIVE,
				'image' => $imagen,
				'created_by' => $this->session->userdata('user_id')
            );

            $this->slider_marcas->insert($data);

            redirect(base_url('cms/slider_marcas'),'refresh');

        }	  
   
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos
		);

		$vista_externa = array(			
			'title' => ucwords("slider_marcas"),
			'contenido_main' => $this->load->view('components/cms/slider_marcas/slider_marcas_add', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}	

	function edit($id){
		if ($this->input->post('enviar_form')){
			$data = array(
					'nombre_slider_marcas' => $this->input->post('nombre'),
					'updated_at' => date('Y-m-d H:i:s'),
					'updated_by' => $this->session->userdata('user_id')
				);
				if (!empty($_FILES['imagen']['tmp_name'])) {
					$data['image'] = $this->backend_lib->imagen_upload_simple('imagen', 'slider_marcas');
				}    
				$this->slider_marcas->edit($data,$id);     
				redirect(base_url('cms/slider_marcas'),'refresh');
		}

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->codegen_model->row('slider_marcas','*','id_slider_marcas = '.$id)
		);

		$vista_externa = array(			
			'title' => ucwords("slider_marcas"),
			'contenido_main' => $this->load->view('components/cms/slider_marcas/slider_marcas_edit', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}

	function view($id){
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->codegen_model->row('slider_marcas','*','id_slider_marcas = '.$id)
		);

		$vista_externa = array(			
			'title' => ucwords("slider_marcas"),
			'contenido_main' => $this->load->view('components/cms/slider_marcas/slider_marcas_view', $vista_interna, true)
		);		  
   
		$this->load->view('template/view', $vista_externa);
	}

	function json($id){
		$json = $this->codegen_model->row('slider_marcas','*','id_slider_marcas = '.$id);
		if($json) echo json_encode($json);
		else echo json_encode(array('status' => 'none'));
	}

	function json_all(){
		$json = $this->codegen_model->get('slider_marcas','*','');
		if($json) echo json_encode($json);
		else echo json_encode(array('status' => 'none'));
	}
	
	function delete($id){

		$data = array(
			'active' => DELETE,
			'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => $this->session->userdata('user_id')
		);

		$this->slider_marcas->edit($data,$id);             
	}
}

/* End of file slider_marcas.php */
/* Location: ./system/application/controllers/slider_marcas.php */