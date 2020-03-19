<?php

class Producto_stock_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_STOCK;
        $this->id = 'id_stock';
    }

    public function getProductStock($id_product)
    {
        $this->db->select('product_stock.*, size.name as size, color.color');
        $this->db->join('sizes size', 'size.id_size = product_stock.id_size AND size.active = "'.ACTIVE.'"');
        $this->db->join('colors color', 'color.id_color = product_stock.id_color AND color.active = "'.ACTIVE.'"');
        $this->db->where('product_stock.active', ACTIVE);
        $this->db->where('product_stock.id_product', $id_product);
        $query = $this->db->get($this->table.' product_stock');
        return $query->result();
    }

    public function addProductStock($post_data)
    {
        $this->db->insert($this->table, $post_data);
        return $this->db->insert_id();
    }

    public function update($idStock, $data)
    {
        $this->db->where('id_stock', $idStock);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function deleteStockProduct($id_product, $post_data)
    {
        $this->db->where('id_product', $id_product);
        $this->db->update($this->table, $post_data);
        return $this->db->affected_rows();
    }

    public function getStockTalleColor($id_product, $id_size, $id_color)
    {
        $this->db->select('stock');
        $this->db->where('id_color', $id_color);
        $this->db->where('id_size', $id_size);
        $this->db->where('id_product', $id_product);
        $this->db->where('active', ACTIVE);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function getSizesProductStock($id_producto)
    {
        $this->db->select('size.*');
        $this->db->join('sizes size', 'size.id_size = product_stock.id_size AND size.active = "'.ACTIVE.'"');
        $this->db->where('product_stock.stock > "0"');
        $this->db->where('product_stock.id_product', $id_producto);
        $this->db->where('product_stock.active', ACTIVE);
        $this->db->group_by('product_stock.id_size');
        $query = $this->db->get($this->table.' product_stock');
        return $query->result();
    }

    public function getColorsProductStock($id_producto)
    {
        $this->db->select('color.*');
        $this->db->join('colors color', 'color.id_color = product_stock.id_color AND color.active = "'.ACTIVE.'"');
        $this->db->where('product_stock.stock > "0"');
        $this->db->where('product_stock.id_product', $id_producto);
        $this->db->where('product_stock.active', ACTIVE);
        $this->db->group_by('product_stock.id_color');
        $query = $this->db->get($this->table.' product_stock');
        return $query->result();
    }

    public function updateStockProduct($where_product, $stock)
    {
        $this->db->where($where_product);
        $this->db->set('stock', 'stock-'.$stock, false);
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }
}
