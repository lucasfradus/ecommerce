<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class frontend_lib {

	public function __construct()
	{
		$this->load->model('categoria_model','categoria');
		$this->load->model('subcategoria_model','subcategoria');
		$this->load->model('marca_model','marca');
		$this->load->model('deporte_model','deporte');
		$this->load->model('categoria_producto_model','categoria_producto');
	}

	public function __get($var)
	{
		return get_instance()->$var;
	}	

	public function configuraciones($array)
	{
		$configuraciones = array();

		$configuraciones['title'] = $array['title'];
		$configuraciones['autor'] = 'Innovahora';
		$configuraciones['copyright'] = date('Y');

		if (!empty($array['og_title'])) {
			$configuraciones['og_title'] = $array['og_title'];
		}
		if (!empty($array['og_description'])) {
			$configuraciones['og_description'] = $array['og_description'];
		}
		if (!empty($array['og_image'])) {
			$configuraciones['og_image'] = $array['og_image'];
		}

		$configuraciones['categorias'] = $this->categoria->getResults(5, 0);

		$query = $this->codegen_model->get('configurations', '*', '');

		foreach ($query as $f)
		{
			switch ($f->key_id)
			{
				case 'keywords':
					$configuraciones[$f->key_id] = $f->value.' '.$array['metadata'];
					break;

				case 'descripcion':
					$configuraciones[$f->key_id] = $f->value.' '.$array['description'];
					break;
				
				default:
					$configuraciones[$f->key_id] = $f->value;
					break;
			}
		}

		return $configuraciones;

	}

	public function loadIdioma()
	{
		if ($this->session->userdata('idioma'))
		{
			return $this->session->userdata('idioma');
		}else{
			$sesion_data = array('idioma' => 'spanish');
            $this->session->set_userdata($sesion_data);
            return $this->session->userdata('idioma');
		}
	}

	public function validarSession()
	{
		if (!$this->session->userdata('cliente_id'))
		{
			redirect(base_url().'registrarse');
		}else{
			$this->log('read', '');
		}
	}

	public function log()
	{
		$level = 'INFO';
		$msj = $this->uri->uri_string().": fue accedida por el usuario ".$this->session->userdata('cliente_usuario');
  
  		$filepath = 'application/logs/frontend/log-'.date('Y-m-d').'.php';
  		$message  = '';

  		if ( ! file_exists($filepath)){
   			$message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
  		}

  		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE) ){
   			return FALSE;
  		}

		$message .= $level.' '.(($level == 'INFO') ? ' -' : '-').' '.date('Y-m-d H:i:s'). ' --> '.$msj."\n";

  		flock($fp, LOCK_EX);
  		fwrite($fp, $message);
  		flock($fp, LOCK_UN);
  		fclose($fp);

  		@chmod($filepath, FILE_WRITE_MODE);
	}

	public function enviarEmail($data, $vista, $titulo, $email_destino, $email_origen, $remitente)
	{
		$datos['dato'] = $data;

		$mensaje = $this->load->view($vista, $datos, true);
		$this->load->library('email');
		$config['mailtype'] = 'html';

		$this->email->initialize($config);
		$this->email->from($email_origen, $remitente);
		$this->email->to($email_destino);
		$this->email->subject($titulo);
		$this->email->message($mensaje);

		if (!empty($data['filename']))
		{
			$this->email->attach($data['filename']);
		}

		if ($this->email->send())
		{
			return TRUE;
		}

		return FALSE;
	}

    public function enviarEmailPedido($mensaje, $titulo, $email_destino, $email_origen, $remitente)
    {
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);		
		$this->email->from($email_origen, $remitente);
		$this->email->to($email_destino);
		$this->email->subject($titulo);
		$this->email->message($mensaje);
		$this->email->send();	
	}

}