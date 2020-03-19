<?php 
	if ($this->ion_auth->logged_in()){
		$this->view('backend/dashboard/dashboard_estructura');
		$this->view('backend/dashboard/dashboard_js');
	}
	else redirect(site_url('backend/auth/login'), 'refresh');
?>