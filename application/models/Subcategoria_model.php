<?php

class Subcategoria_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_SUBCATEGORIES;
        $this->id = 'id_subcategory';
    }

    public function get($where = [])
    {
        $this->db->select($this->table . '.*');
        $this->db->join('categories', $this->table . '.id_category = categories.id_category');
        $this->db->where('categories.active', ACTIVE);
        $this->db->where($this->table.'.active', ACTIVE);

        if (!empty($where)) {
            $this->db->where($where);
        }

        $this->db->order_by($this->table.'.name', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }
    public function findDetail($id)
    {
        $this->db->select('subcategory.*, category.name AS category, subcategory.name as subcategory');
        $this->db->where('subcategory.active', ACTIVE);
        $this->db->where('subcategory.id_subcategory', $id);
        $this->db->join(TABLE_SUBCATEGORIES.' category', 'category.id_category = subcategory.id_category');
        $query = $this->db->get($this->table.' subcategory');
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

    function getCategory($id_category)
    {
        $this->db->where('id_category', $id_category);
        $this->db->where('active', ACTIVE);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function getCategoriasSubcategorias()
    {

        $query = $this->db
                        ->select('subcategory.*, category.name AS category, subcategory.name AS subcategory')
                        ->join(TABLE_SUBCATEGORIES.' subcategory', 'subcategory.id_category = category.id_category')
                        ->where('category.active', ACTIVE)
                        ->where('subcategory.active', ACTIVE)
                        ->get(TABLE_CATEGORIES.' category');
        return $query->result();
    }

    function editCategory($data, $idCategory)
    {
        $this->db->where('id_category', $idCategory);
        $this->db->where('active', ACTIVE);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }
}
