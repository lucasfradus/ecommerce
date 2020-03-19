<?php

class Categoria_producto_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_CATEGORIES_PRODUCTS;
        $this->id = 'id_product_category';
    }

    public function get()
    {
        $this->db->where('active', ACTIVE);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function find($id)
    {
        $this->db->where('active', ACTIVE);
        $this->db->where($this->id, $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function deleteProductoCategoria($data, $id)
    {
        $this->db->where('id_product', $id);
        $this->db->update($this->table, $data);
        return $this->db->insert_id();
    }
}
