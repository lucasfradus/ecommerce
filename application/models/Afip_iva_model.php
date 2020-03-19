<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Afip_iva_model extends CI_Model
{
    function get()
    {
        $this->db->where('active', ACTIVE);
        $this->db->order_by('id_iva');
        $query = $this->db->get('afip_ivas');
        return $query->result();
    }
}

/* End of file Afip_iva_model.php */
/* Location: ./application/models/Afip_iva_model.php */
