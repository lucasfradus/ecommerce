<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Factura_model extends CI_Model
{
    private $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_INVOICE;
    }

    public function get($filtros)
    {
        $this->db->select('invoice.*, order.*, user.name, user.surname, user.type_id, business.name as business');
        $this->db->join($this->table.' AS invoice', 'invoice.id_order = order.id_order AND invoice.active = "' . ACTIVE . '"', 'LEFT');
        $this->db->join('business_configurations AS business', 'business.id_business = order.id_business');
        $this->db->join('ecommerce_users AS user', 'order.id_users = user.id_users');
        $this->db->where('order.active', ACTIVE);

        if (!empty($filtros['desde'])) {
            $this->db->where('DATE_FORMAT(order.date, "%Y-%m-%d") >=', '"' . $filtros['desde'] . '"', false);
        }

        if (!empty($filtros['hasta'])) {
            $this->db->where('DATE_FORMAT(order.date, "%Y-%m-%d") <=', '"' . $filtros['hasta'] . '"', false);
        }

        if (!empty($filtros['documento'])) {
            $this->db->where('user.dni', $filtros['documento']);
        }

        if (!empty($filtros['estado'])) {
            $this->db->where('order.id_status', $filtros['estado']);
        }

        if (!empty($filtros['empresa'])) {
            $this->db->where('order.id_business', $filtros['empresa']);
        }

        $this->db->order_by('order.id_order', 'DESC');
        $query = $this->db->get('orders AS order');
        return $query->result();
    }

    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function find($where)
    {
        $this->db->where($where);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function edit($data_where, $data_edit)
    {
        $this->db->where($data_where);
        $this->db->update($this->table, $data_edit);
        return $this->db->affected_rows();
    }
}

/* End of file Factura_model.php */
/* Location: ./application/models/Factura_model.php */
