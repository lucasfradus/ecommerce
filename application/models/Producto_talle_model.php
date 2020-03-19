<?php

class Producto_talle_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_PRODUCTS_SIZES;
        $this->id = 'id_size';
    }

    public function get()
    {
        $this->db->where('active', ACTIVE);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function find($id)
    {
        $this->db->where('active', ACTIVE);
        $this->db->where($this->id, $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function edit($data, $id)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        return $this->db->insert_id();
    }

    public function getTallesProducto($id_producto)
    {
        $this->db->where('id_product', $id_producto);
        $this->db->where('active', ACTIVE);
        $this->db->order_by('id_size', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function deleteTallesProducto($data, $id)
    {
        $this->db->where('id_product', $id);
        $this->db->update($this->table, $data);
    }

    public function getProduct($id_product)
    {
        $this->db->select('size.*');
        $this->db->join('sizes size', 'size.id_size = product_size.id_size AND size.active = "'.ACTIVE.'"');
        $this->db->where('product_size.id_product', $id_product);
        $this->db->where('product_size.active', ACTIVE);
        $this->db->order_by('product_size.id_size', 'asc');
        $query = $this->db->get($this->table.' product_size');
        return $query->result();
    }

    public function getProductSize($id_product)
    {
        $this->db->select('product_size.id_size, size.size AS name_size');
        $this->db->join($this->table.' product_size', 'product_size.id_product = product.id_product AND product_size.active = "'.ACTIVE.'"');
        $this->db->join(TABLE_SIZES.' size', 'size.id_size = product_size.id_size AND size.active = "'.ACTIVE.'"');
        $this->db->where('product.id_product', $id_product);
        $this->db->where('product_size.active', ACTIVE);
        $query = $this->db->get(TABLE_PRODUCTS.' product');
        return $query->result();
    }
}
