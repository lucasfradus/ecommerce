<?php

class Users extends CI_Controller
{

    private $permisos;
    private $issa;

    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
        $this->issa = $this->permisos_lib->isSuperAdmin();
    }
    
    function index()
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'issa' => $this->issa,
            'results' => $this->sudaca_backend_md->users_getAll()
        );

        $vista_externa = array(
            'title' => ucwords("users"),
            'contenido_main' => $this->load->view('backend/users/users_list', $vista_interna, true)
        );
        
        $this->load->view('template/backend', $vista_externa);
    }

    function add()
    {
        if ($this->input->post('enviar_form')) {
            $username = $this->input->post('username');
            $email    = $this->input->post('email');
            $password = $this->input->post('password');

            if (!empty($_FILES['foto']['tmp_name'])) {
                $img = $this->backend_lib->imagen_upload('foto', 'users');
            } else {
                $img = '';
            }

            $additional_data = array(
                'name' => ucwords(strtolower($this->input->post('nombre'))),
                'surname' => ucwords(strtolower($this->input->post('apellido'))),
                'telephone' => $this->input->post('telefono'),
                'mobile' => $this->input->post('celular'),
                'foto' => $img,
                'active' => $this->input->post('active'),
                'idioma' => 'spanish',
                'template' => $this->input->post('template'),
                'create_by' => $this->session->userdata('user_id')

            );
            $group_us = $this->input->post('group');
            $group = array($group_us);
            $this->ion_auth->register($username, $password, $email, $additional_data, $group);
            redirect(base_url("backend/users"), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'issa' => $this->issa,
            'grupos' => $this->sudaca_backend_md->groups_getAll()
        );

        $vista_externa = array(
            'title' => ucwords("users"),
            'contenido_main' => $this->load->view('backend/users/users_add', $vista_interna, true)
        );
        
        $this->load->view('template/backend', $vista_externa);
    }

    function edit($id)
    {
        
        if ($this->input->post('enviar_form')) {
            $id = $this->input->post('id');
            $user = $this->ion_auth->user($id)->row();

            if (!empty($_FILES['foto']['tmp_name'])) {
                $img = $this->backend_lib->imagen_upload('foto', 'users');
            } else {
                $foto = $this->codegen_model->row('users', '*', 'id_user = '.$user->id_user);
                $img = $foto->image;
            }

            $data = array(
                'name' => ucwords(strtolower($this->input->post('nombre'))),
                'surname' => ucwords(strtolower($this->input->post('apellido'))),
                'telephone' => $this->input->post('telefono'),
                'mobile' => $this->input->post('celular'),
                'image' => $img,
                'active' => $this->input->post('active'),
                'update_by' => $this->session->userdata('user_id')

            );
            
            $this->ion_auth->update($user->id_user, $data);
            $this->ion_auth->remove_from_group(null, $user->id_user);
            $this->ion_auth->add_to_group($this->input->post('group'), $user->id_user);

            redirect(base_url("backend/users"), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'issa' => $this->issa,
            'grupos' => $this->sudaca_backend_md->groups_getAll(),
            'result' => $this->codegen_model->row('users', '*', 'id_user = '.$id),
            'group_user' => $this->codegen_model->row('users_groups', '*', 'id_user = "'.$id.'" ORDER BY id_user_group DESC'),
        );

        $vista_externa = array(
            'title' => ucwords("users"),
            'contenido_main' => $this->load->view('backend/users/users_edit', $vista_interna, true)
        );
        
        $this->load->view('template/backend', $vista_externa);
    }

    function view($id)
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->codegen_model->row('users', '*', 'id_user = '.$id)
        );

        $vista_externa = array(
            'title' => ucwords("users"),
            'contenido_main' => $this->load->view('backend/users/users_view', $vista_interna, true)
        );
        
        $this->load->view('template/view', $vista_externa);
    }
    
    function delete($ID)
    {

        $data_update = array(
            'active'    =>  0,
            'deleted_at' => date('Y-m-d H:i:s'),
            'delete_by' => $this->session->userdata('user_id')

        );

        $this->codegen_model->edit('users', $data_update, 'id_user', $ID);

        redirect(base_url().'backend/users/');
    }

    function cambiar_password($id)
    {
        if ($this->input->post('enviar_form')) {
            $password = $this->input->post('password');

            $data_update = array(
                'password' => $this->ion_auth->hash_password($password, false),
            );
            $this->codegen_model->edit('users', $data_update, 'id_user', $id);

            redirect(base_url('backend/users'), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'issa' => $this->issa,
            'result' => $this->codegen_model->row('users', '*', 'id_user = '.$id)
        );

        $vista_externa = array(
            'title' => ucwords("users"),
            'contenido_main' => $this->load->view('backend/users/users_password', $vista_interna, true)
        );
        
        $this->load->view('template/backend', $vista_externa);
    }

    function validarUsuario()
    {
        if (!$this->ion_auth->username_check($this->input->post('username'))) {
            echo "0";
        } else {
            echo "1";
        }
    }

    function validarEmail()
    {
        if (!$this->ion_auth->email_check($this->input->post('email'))) {
            echo "0";
        } else {
            echo "1";
        }
    }
}
