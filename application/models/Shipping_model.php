<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shipping_model extends CI_Model
{

    private $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'shipping_methods';
    }

    function get()
    {
        $this->db->order_by('name', 'ASC');
        $this->db->where('active', ACTIVE);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function findByPostalCode($postal_code)
    {
        $this->db->where('active', ACTIVE);
        $this->db->where('postal_code', $postal_code);
        $query = $this->db->get('shippings');
        return $query->row();
    }

    public function findByShippingPrice($id)
    {
        $this->db->where('active', ACTIVE);
        $this->db->where('id_shipping', $id);
        $query = $this->db->get('shippings');
        return $query->row();
    }

}

/* End of file Shipping_model.php */
/* Location: ./application/models/Shipping_model.php */
