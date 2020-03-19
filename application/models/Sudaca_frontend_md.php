<?php
class Sudaca_frontend_md extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function productosDestacados()
    {
        $this->db->where('p.destacado', 1);
        $this->db->where('p.active', 1);
        $query = $this->db->get('ecommerce_productos p');
        return $query->result();
    }

    function getProductos()
    {
        $this->db->where('p.active', 1);
        $query = $this->db->get('ecommerce_productos p');
        return $query->result();
    }

    function getProducto($id)
    {
        $this->db->where('p.id', $id);
        $this->db->where('p.active', 1);
        $query = $this->db->get('ecommerce_productos p');
        return $query->row();
    }

    public function getComprasUsers($id_users, $page)
    {
        $query = $this->db
                    ->select('o.*, count(o.id_users) as compras, os.name')
                    ->where('o.id_users', $id_users)
                    ->limit(10, $page)
                    ->join('orders_statuses os', 'os.id_order_status=o.id_status')
                    ->group_by('o.id_order')
                    ->order_by('o.id_order DESC')
                    ->get('orders o');
        return $query->result();
    }

    public function getUser($id)
    {
        $this->db->select('*');
        $this->db->where('id_users', $id);
        $query = $this->db->get('ecommerce_users');
        return $query->row();
    }
}
