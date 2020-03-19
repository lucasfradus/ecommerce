<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Configuracion_model extends CI_Model
{
    private $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'configurations';
    }

    public function find($condition)
    {
        if (is_array($condition))
        {
            $this->db->where($condition);
        } else {
            $this->db->where('id_configuration', $condition);
        }
        $query = $this->db->get($this->table);
        return $query->row();
    }
}

/* End of file Configuracion_model.php */
/* Location: ./application/models/Configuracion_model.php */
