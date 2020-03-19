<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Condicion_usuario_model extends CI_Model
{
    public function get($where = [])
    {
        $this->db->select('*');
        $this->db->where('active', ACTIVE);
        $query = $this->db->get('condition_iva');
        return $query->result();
    }
}

/* End of file Condicion_usuario_model.php */
/* Location: ./application/models/Condicion_usuario_model.php */
