<?php

class Producto_imagen_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_PRODUCT_IMAGES;
        $this->id = 'id_product_image';
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

    public function search($param)
    {

        $this->db->select('id_product as id, CONCAT(code," ",name) as text', false);
        $this->db->where('active', ACTIVE);
        $this->db->having('text LIKE "%'.$param.'%"');
        $this->db->order_by('name', 'asc');
        $this->db->limit(15);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function deleteGaleriaProducto($data, $id)
    {
        $this->db->where('id_product', $id);
        $this->db->update($this->table, $data);
    }

    public function getColoresImagenProducto($productoId)
    {
        $this->db->select('color.id_color, color.name, GROUP_CONCAT(imagen.image SEPARATOR ", ") AS imagenes');
        $this->db->join('colors color', 'color.id_color = imagen.id_color');
        $this->db->where('imagen.id_product', $productoId);
        $this->db->where('imagen.active', ACTIVE);
        $this->db->order_by('imagen.'.$this->id);
        $this->db->group_by('imagen.id_color');
        $query = $this->db->get($this->table.' imagen');
        return $query->result();
    }

    public function getGaleriaProducto($id_product)
    {
        $this->db->where('id_product', $id_product);
        $this->db->where('active', ACTIVE);
        $this->db->order_by($this->id);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function deleteProduct($id_product)
    {
        $this->db->set('active', 0);
        $this->db->where('id_product', $id_product);
        $this->db->update($this->table);
    }
}
