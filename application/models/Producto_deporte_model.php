<?php

class Producto_deporte_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_PRODUCTOS_SPORTS;
        $this->id = 'id_product_sport';
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

    public function deleteProductoDeporte($data, $id)
    {
        $this->db->where('id_product', $id);
        $this->db->update($this->table, $data);
        return $this->db->insert_id();
    }

    public function findDeporteProducto($id_product)
    {
        $this->db->select('sport.*');
        $this->db->join(TABLE_SPORTS.' sport', 'sport.id_sport = producto_deporte.id_sport');
        $this->db->where('producto_deporte.active', ACTIVE);
        $this->db->where('producto_deporte.id_product', $id_product);
        $this->db->order_by('producto_deporte.'.$this->id, 'desc');
        $query = $this->db->get($this->table.' producto_deporte');
        return $query->row();
    }
}
