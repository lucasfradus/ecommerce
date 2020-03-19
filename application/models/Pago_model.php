<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pago_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_PAYMENT_METHODS;
        $this->id = 'id_payment_method';
    }

    public function get($where = null)
    {
        if ($where)
        {
            $this->db->where($where);
        } else {
            $this->db->where('active', ACTIVE);
        }
        $this->db->order_by('name', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }
}
