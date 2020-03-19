<?php

class Product_listprice_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_PRICE_PRODUCTS;
        $this->id = 'id_price_products';
    }

    public function get()
    {
        $this->db->where('active', ACTIVE);
        $this->db->order_by($this->id, 'desc');
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

    function getLisProcducPrice($id)
    {
        $this->db->join('list_price list', 'list.id_list_price = price.id_list_price');
        $this->db->where('id_product', $id);
        $this->db->where('price.active', ACTIVE);
        $query = $this->db->get('price_products price');
        return $query->result();
    }

    function deletePriceList($data, $id)
    {
        $this->db->where('id_product', $id);
        $this->db->update($this->table, $data);
        return $this->db->insert_id();
    }
}
