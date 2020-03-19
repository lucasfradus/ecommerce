<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	private $permisos;
	private $issa;

	function __construct() {
		parent::__construct();
		$this->permisos = $this->permisos_lib->control();
		$this->issa = $this->permisos_lib->isSuperAdmin();
	}

	public function index(){
		
		$user = $this->ion_auth->user()->row();

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'issa' => $this->issa
		);

		$vista_externa = array(			
			'title' => ucwords("bienvenido ".$user->surname.', '.$user->name),
			'contenido_main' => $this->load->view('backend/dashboard/dashboard', $vista_interna, true)
		);		
		
		$this->load->view('template/backend', $vista_externa);
	}

	public function micuenta(){

		$user = $this->ion_auth->user()->row();

		if ($this->input->post('enviar_form')) {

			if (!empty($_FILES['foto']['tmp_name'])) {
				$img = $this->backend_lib->imagen_upload('foto', 'users');
			}
			else{
				$foto = $this->codegen_model->row('users', 'id_user, image','id_user = '.$user->id);
				$img = $foto->image;
			}

			$data = array(
				'nombre' => ucwords(strtolower($this->input->post('nombre'))),
				'apellido' => ucwords(strtolower($this->input->post('apellido'))),
				'telefono'	=> $this->input->post('telefono'),
				'celular' => $this->input->post('celular'),
				'foto' => $img,
				'template' => $this->input->post('template')
			);

			$this->ion_auth->update($user->id, $data);

			redirect(base_url("backend/dashboard"), 'refresh');

		}

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'issa' => $this->issa,
			'grupos' => $this->sudaca_backend_md->groups_getAll(),
			'grupo' => $this->codegen_model->row('users_groups','*','id_user_group = '.$user->id),
			'result' => $this->codegen_model->row('users','*','id_user = '.$user->id)
		);

		$vista_externa = array(			
			'title' => ucwords("Mi Cuenta"),
			'contenido_main' => $this->load->view('backend/users/users_account', $vista_interna, true)
		);		
		
		$this->load->view('template/backend', $vista_externa);
	}

	public function accesos_directos(){
		$this->data['padres'] = $this->sudaca_md->getAccesosDirectosPadres($this->session->userdata('user_id'));
		$this->data['hijos'] = $this->sudaca_md->getAccesosDirectosHijos($this->session->userdata('user_id'));
		$this->load->view('backend/dashboard/dashboard_acccesos_directos', $this->data);
	}

	public function ultimos_accesos(){
		$this->data['acessos'] = $this->sudaca_md->getUltimosAccesos($this->session->userdata('user_id'));
		$this->load->view('backend/dashboard/dashboard_ultimos_acccesos', $this->data);
	}
}