<?php

class Producto_relacionado_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_RELATED_PRODUCTS;
        $this->id = 'id_related_product';
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

    public function getRelatedProducts($id_producto)
    {
        $this->db->select('product.id_product, product.name, product.code, product.*, group_concat( `list_product_price`.`price`) as `prices`, group_concat(`list_product_price`.`id_list_price`) as lista_id', false);
        $this->db->join('products product', 'product.id_product = related.id_secondary_product AND product.active = "'.ACTIVE.'"');
        $this->db->join('price_products list_product_price', 'list_product_price.id_product = product.id_product AND list_product_price.active ="'.ACTIVE.'"');
        $this->db->where('related.active', ACTIVE);
        $this->db->where('related.id_product', $id_producto);
        $this->db->order_by('related.id_related_product');
        $this->db->group_by('product.id_product');
        $query = $this->db->get($this->table.' related');
        return $query->result();
    }

    public function deleteProductosRelacionados($data, $id_product)
    {
        $this->db->where('id_product', $id_product);
        $this->db->update($this->table, $data);
    }

    public function getProducts($id_product)
    {
        $this->db->select('product.*, brand.image as imagen_marca, brand.icon as icono_marca');
        $this->db->join('products product', 'product.id_product = related.id_secondary_product AND product.active = "'.ACTIVE.'"');
        $this->db->join('brands brand', 'brand.id_brand = product.id_brand AND brand.active = "'.ACTIVE.'"');
        $this->db->where('related.id_product', $id_product);
        $this->db->where('related.active', ACTIVE);
        $query = $this->db->get('related_products related');
        return $query->result();
    }
}
