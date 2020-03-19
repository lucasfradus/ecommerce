<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Empresa_model extends CI_Model
{
    public function get()
    {
        $this->db->select('business.*');
        $this->db->where('business.active', ACTIVE);
        $this->db->order_by('business.id_business');
        $query = $this->db->get('business_configurations AS business');
        return $query->result();
    }

    public function find($where)
    {
        $this->db->select('business.*');
        $this->db->where($where);
        $query = $this->db->get('business_configurations AS business');
        return $query->row();
    }
}

/* End of file Empresa_model.php */
/* Location: ./application/models/Empresa_model.php */
