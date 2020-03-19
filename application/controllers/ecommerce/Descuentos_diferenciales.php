<?php

class Descuentos_diferenciales extends CI_Controller {

	private $permisos;
	
	function __construct() {
		parent::__construct();
		$this->permisos = $this->permisos_lib->control();
		$this->load->model('Descuentos_diferenciales_model');
	}	
	
	function index(){
		
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'results' => $this->Descuentos_diferenciales_model->get()
		);

		$vista_externa = array(			
			'title' => ucwords("Descuentos Diferenciales"),
			'contenido_main' => $this->load->view('components/ecommerce/differential_discounts/differential_discounts_list', $vista_interna, true)
		);		
		
		$this->load->view('template/backend', $vista_externa);
		
	}

	function is_valid_range($value, $min = 0){

	}

	function title_validate($array){

		
		$min = $this->input->post('min');

		$this->form_validation->set_message('title_validate', 'errror');
		return FALSE;   
	}

	function add(){
	
		$this->form_validation->set_rules('name_differentias_discounts','Nombre','required');
		

		if ($this->input->post('enviar_form')&&$this->form_validation->run()){
			$data = array(
					'name_differentias_discounts' => $this->input->post('name_differentias_discounts'),
					'active' => ACTIVE,
					'created_by' => $this->session->userdata('user_id')
				);
			//Inserto en la tabla y guardo el id que recibo para los detalles	
			$created_id = $this->Descuentos_diferenciales_model->insert($data);
			$min = 	$this->input->post('min');
			$max = $this->input->post('max');
			$desc = $this->input->post('desc');
				
			$length = count($min);
		
			for ($i =0; $i < $length; $i++) {
				//itero x los diferentes campos del array que recibi 
				$data = array(
					'id_differential_discounts_fk' => $created_id,
					'min_qty' =>  $min[$i],
					'max_qty' =>  $max[$i],
					'discount' => $desc[$i]
				);
				
				$this->Descuentos_diferenciales_model->insert_details($data);
			}


			redirect(base_url('ecommerce/Descuentos_diferenciales'));
		}		  
   
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos
		);

		$vista_externa = array(			
			'title' => ucwords("Descuentos Diferenciales"),
			'contenido_main' => $this->load->view('components/ecommerce/differential_discounts/differential_discounts_add', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}	

	function edit($id){
		if ($this->input->post('enviar_form')){
			$data = array(
					'name_differentias_discounts' => $this->input->post('name_differentias_discounts')
				);
			$this->codegen_model->edit('differential_discounts',$data,'id_differentias_discounts',$this->input->post('id_differentias_discounts'));
			redirect(base_url('ecommerce/Descuentos_diferenciales'));
		}

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->Descuentos_diferenciales_model->find($id)
		);

		$vista_externa = array(			
			'title' => ucwords("Descuentos diferenciales"),
			'contenido_main' => $this->load->view('components/ecommerce/differential_discounts/differential_discounts_edit', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}

	function view($id){
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->Descuentos_diferenciales_model->find($id)
		);

		$vista_externa = array(			
			'title' => ucwords("Descuentos_diferenciales"),
			'contenido_main' => $this->load->view('components/ecommerce/differential_discounts/differential_discounts_view', $vista_interna, true)
		);		  
   
		$this->load->view('template/view', $vista_externa);
	}

	function json($id){
		$json = $this->codegen_model->row('differential_discounts','*','id_differentias_discounts = '.$id);
		if($json) echo json_encode($json);
		else echo json_encode(array('status' => 'none'));
	}

	function json_all(){
		$json = $this->codegen_model->get('differential_discounts','*','');
		if($json) echo json_encode($json);
		else echo json_encode(array('status' => 'none'));
	}
	
	function delete($id){
		$data = array(
			'active' => DELETE,
			'deleted_by' => $this->session->userdata('user_id'),
			'deleted_at' => date('Y-m-d H:i:s')
		); 
		$this->Descuentos_diferenciales_model->edit($data, $id);
	}
}

/* End of file Descuentos_diferenciales.php */
/* Location: ./system/application/controllers/Descuentos_diferenciales.php */