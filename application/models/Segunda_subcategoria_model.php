<?php

class Segunda_subcategoria_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_SECOND_SUBCATEGORIES;
        $this->id = 'id_second_subcategory';
    }

    public function get($where = [])
    {
        $this->db->where('active', ACTIVE);
        if (!empty($where)) {
            $this->db->where($where);
        }
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

    function getSubcategory($id_subcategory)
    {
        $this->db->where('id_subcategory', $id_subcategory);
        $this->db->where('active', ACTIVE);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function getSecondsSubcategory()
    {

        $query = $this->db
                        ->select('second_subcategories.id_second_subcategory, subcategory.*, subcategory.name AS subcategory, second_subcategories.name AS secondsubcategory')
                        ->join(TABLE_SECOND_SUBCATEGORIES.' second_subcategories', 'second_subcategories.id_subcategory = subcategory.id_subcategory')
                        ->where('second_subcategories.active', ACTIVE)
                        ->where('subcategory.active', ACTIVE)
                        ->get(TABLE_SUBCATEGORIES.' subcategory');
        return $query->result();
    }

    function getSubcategorySecondSubcategory($id_subcategory)
    {
        $this->db->where('id_subcategory', $id_subcategory);
        $this->db->where('active', ACTIVE);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function categoria($segundaSubcatId)
    {
        $this->db->select('categoria.*');
        $this->db->join('subcategories AS subcategoria', 'subcategoria.id_subcategory = segunda_subcategoria.id_subcategory AND segunda_subcategoria.active = "' . ACTIVE . '"');
        $this->db->join('categories AS categoria', 'categoria.id_category = subcategoria.id_category AND categoria.active = "'.ACTIVE.'"');
        $this->db->where('segunda_subcategoria.active', ACTIVE);
        $this->db->where('segunda_subcategoria.id_second_subcategory', $segundaSubcatId);
        $query = $this->db->get($this->table.' AS segunda_subcategoria');
        return $query->row();
    }

    function subcategoria($segundaSubcatId)
    {
        $this->db->select('subcategoria.*');
        $this->db->join('subcategories AS subcategoria', 'subcategoria.id_subcategory = segunda_subcategoria.id_subcategory');
        $this->db->where('segunda_subcategoria.active', ACTIVE);
        $this->db->where('segunda_subcategoria.id_second_subcategory', $segundaSubcatId);
        $query = $this->db->get($this->table.' AS segunda_subcategoria');
        return $query->row();
    }
}
