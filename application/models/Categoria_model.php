<?php

class Categoria_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_CATEGORIES;
        $this->id = 'id_category';
    }

    public function get()
    {
        $this->db->where('active', ACTIVE);
        $this->db->order_by('order', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }
    public function findBread($id)
    {
        $this->db->select('*, name as category');
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

    public function update($field, $value, $data)
    {
        $this->db->where($field, $value);
        $this->db->update($this->table, $data);
        return $this->db->insert_id();
    }

    public function getCategorySubcategory($id_subcategory)
    {
        $this->db->select('category.*');
        $this->db->where('subcategory.id_subcategory', $id_subcategory);
        $this->db->join($this->table.' category', 'category.id_category = subcategory.id_category');
        $this->db->where('category.active', ACTIVE);
        $query = $this->db->get('subcategories subcategory');
        return $query->row();
    }

    public function getProductsFeatured()
    {
        $this->db->select('category.*');
        $this->db->join('subcategories subcategory', 'subcategory.id_category = category.id_category AND subcategory.active = "'.ACTIVE.'"');
        $this->db->join('products_subcategories product_subcategory', 'product_subcategory.id_subcategory = subcategory.id_subcategory AND product_subcategory.active = "'.ACTIVE.'"');
        $this->db->join('products product', 'product.id_product = product_subcategory.id_product AND product.active = "'.ACTIVE.'"');
        $this->db->where('category.active', ACTIVE);
        $this->db->where('category.featured', ACTIVE);
        $this->db->where('product.featured', ACTIVE);
        $this->db->group_by('category.id_category');
        $this->db->order_by('category.name');
        $query = $this->db->get('categories category');
        return $query->result();
    }

    public function getFeatured()
    {
        $this->db->where('active', ACTIVE);
        $this->db->where('featured', ACTIVE);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function getResults($limit, $page, $params = [])
    {
        $this->db->select('category.*');
        $this->db->where('category.active', ACTIVE);
        $this->db->order_by('category.id_category');
        $this->db->limit($limit, $page);
        $query = $this->db->get('categories category');
        return $query->result();
    }
}
