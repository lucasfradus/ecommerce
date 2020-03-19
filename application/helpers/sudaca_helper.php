<?php 

function sudaca_url_segmentos(){
	$segmentos = array( 
	      'web' => '',
	      'cart' => '',
	      '_' => ' ',
	      'add' => 'nuevo',
	      'edit' => 'editar',
	      'groups' => 'grupos',
	      'auth' => 'usuarios',
	      'user' => 'usuario',
	      'change password' => 'Cambiar Password',
	      'codegen' => 'CRUD',
	      'auth' => 'Usuario'                            
  	);
  	return $segmentos;
}

function configPagination() {
	$config['full_tag_open']    = "<ul id='paginacion-libreria' class='paginador pagination justify-content-end'>";
	$config['full_tag_close']   = "</ul>";
	$config['num_tag_open']     = '<li>';
	$config['num_tag_close']    = '</li>';
	$config['cur_tag_open']     = "<li class='disabled'><li class='active'><a class='link-pagina2'>";
	$config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
	$config['next_tag_open']    = "<li class='icono'>";
	$config['next_tagl_close']  = "</li>";
	$config['prev_tag_open']    = "<li class='icono'>";
	$config['prev_tagl_close']  = "</li>";
	$config['first_tag_open']   = "<li>";
	$config['first_tagl_close'] = "</li>";
	$config['last_tag_open']    = "<li>";
	$config['last_tagl_close']  = "</li>";
	$config['first_link'] = '&laquo; Primero';
	$config['last_link'] = 'Último &raquo;';
	$config['next_link'] = '<i class="fa fa-angle-right" style="font-size:16px;"></i>';
	$config['prev_link'] = '<i class="fa fa-angle-left" style="font-size:16px;"></i>';
	$config['attributes'] = array('class' => 'link-pagina2');
	return $config;
}