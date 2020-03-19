<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pedido_producto_model extends CI_Model
{
    public function add($data)
    {
        $this->db->insert('ordered_products', $data);
        return $this->db->insert_id();
    }

    public function get($where)
    {
        $this->db->select('product.name, order_product.iva_amount, product.code, order_product.*, iva.percent');
        $this->db->join('products AS product', 'product.id_product = order_product.id_product');
        $this->db->join('afip_ivas AS iva', 'order_product.id_iva = iva.id_iva');
        $this->db->where($where);
        $query = $this->db->get('ordered_products AS order_product');
        return $query->result();
    }
}

/* End of file Pedido_producto_model.php */
/* Location: ./application/models/Pedido_producto_model.php */
