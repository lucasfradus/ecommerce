<?php

class Producto_subcategoria_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_PRODUCTS_SUBCATEGORIES;
        $this->id = 'id_product_subcategory';
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

    public function deleteProductoSubcategoria($data, $id)
    {
        $this->db->where('id_product', $id);
        $this->db->update($this->table, $data);
        return $this->db->insert_id();
    }

    public function producto($productoId)
    {
        $this->db->select('subcategory.*');
        $this->db->join(TABLE_SUBCATEGORIES.' subcategory', 'subcategory.id_subcategory = product_subcategory.id_subcategory');
        $this->db->where('product_subcategory.id_product', $productoId);
        $this->db->where('product_subcategory.active', ACTIVE);
        $query = $this->db->get($this->table.' product_subcategory');
        return $query->row();
    }

    public function findCategoriaProducto($productoId)
    {
        $this->db->select('category.id_category, category.name, subcategory.id_subcategory');
        $this->db->join(TABLE_SUBCATEGORIES.' subcategory', 'subcategory.id_subcategory = product_subcategory.id_subcategory');
        $this->db->join(TABLE_CATEGORIES.' category', 'category.id_category = subcategory.id_category');
        $this->db->where('product_subcategory.id_product', $productoId);
        $this->db->where('product_subcategory.active', ACTIVE);
        $query = $this->db->get($this->table.' product_subcategory');
        return $query->row();
    }

    public function getCategoriaColores($categoriaId)
    {

        $this->db->select('color.*');
        $this->db->join(TABLE_SUBCATEGORIES.' subcategory', 'subcategory.id_subcategory = product_subcategory.id_subcategory AND subcategory.active = "' . ACTIVE . '"');
        $this->db->join(TABLE_CATEGORIES.' category', 'category.id_category = subcategory.id_category AND category.active = "' . ACTIVE . '"');
        $this->db->join('variant_products AS producto_variante', 'producto_variante.id_product = product_subcategory.id_product AND producto_variante.active = "'.ACTIVE.'"');
        $this->db->join('products AS product', 'product.id_product = producto_variante.id_product');
        $this->db->join('colors AS color', 'color.id_color = producto_variante.id_color AND color.active = "' . ACTIVE . '"');
        $this->db->where('product.active', ACTIVE);
        $this->db->where('product.type', PRODUCTO_VARIANTE);
        $this->db->where('subcategory.id_category', $categoriaId);
        $this->db->where('product_subcategory.active', ACTIVE);
        $this->db->group_by('color.id_color');
        $this->db->order_by('color.name');
        $query = $this->db->get($this->table.' AS product_subcategory');
        return $query->result();
    }

    function getCategoriaTalles($categoriaId)
    {
        $this->db->select('talle.*');
        $this->db->join(TABLE_SUBCATEGORIES.' subcategory', 'subcategory.id_subcategory = product_subcategory.id_subcategory AND subcategory.active = "' . ACTIVE . '"');
        $this->db->join(TABLE_CATEGORIES.' category', 'category.id_category = subcategory.id_category AND category.active = "' . ACTIVE . '"');
        $this->db->join('variant_products AS producto_variante', 'producto_variante.id_product = product_subcategory.id_product AND producto_variante.active = "'.ACTIVE.'"');
        $this->db->join('products AS product', 'product.id_product = producto_variante.id_product');
        $this->db->join('sizes AS talle', 'talle.id_size = producto_variante.id_size AND talle.active = "' . ACTIVE . '"');
        $this->db->where('subcategory.id_category', $categoriaId);
        $this->db->where('product.active', ACTIVE);
        $this->db->where('product.type', PRODUCTO_VARIANTE);
        $this->db->where('product_subcategory.active', ACTIVE);
        $this->db->group_by('talle.id_size');
        $this->db->order_by('talle.name');
        $query = $this->db->get($this->table.' AS product_subcategory');
        return $query->result();
    }

    function getCategoriaTacos($categoriaId)
    {
        $this->db->select('taco.*');
        $this->db->join(TABLE_SUBCATEGORIES.' subcategory', 'subcategory.id_subcategory = product_subcategory.id_subcategory AND subcategory.active = "' . ACTIVE . '"');
        $this->db->join(TABLE_CATEGORIES.' category', 'category.id_category = subcategory.id_category AND category.active = "' . ACTIVE . '"');
        $this->db->join('variant_products AS producto_variante', 'producto_variante.id_product = product_subcategory.id_product AND producto_variante.active = "'.ACTIVE.'"');
        $this->db->join('products AS product', 'product.id_product = producto_variante.id_product');
        $this->db->join('heels AS taco', 'taco.id_heel = producto_variante.id_heel AND taco.active = "' . ACTIVE . '"');
        $this->db->where('subcategory.id_category', $categoriaId);
        $this->db->where('product_subcategory.active', ACTIVE);
        $this->db->where('product.active', ACTIVE);
        $this->db->where('product.type', PRODUCTO_VARIANTE);
        $this->db->group_by('taco.id_heel');
        $this->db->order_by('taco.name');
        $query = $this->db->get($this->table.' AS product_subcategory');
        return $query->result();
    }

    function getColores($subcategoriaId)
    {
        $this->db->select('color.*');
        $this->db->join(TABLE_SUBCATEGORIES.' subcategory', 'subcategory.id_subcategory = product_subcategory.id_subcategory AND subcategory.active = "' . ACTIVE . '"');
        $this->db->join('variant_products AS producto_variante', 'producto_variante.id_product = product_subcategory.id_product AND producto_variante.active = "'.ACTIVE.'"');
        $this->db->join('colors AS color', 'color.id_color = producto_variante.id_color AND color.active = "' . ACTIVE . '"');
        $this->db->join('products AS product', 'product.id_product = producto_variante.id_product');
        $this->db->where('subcategory.id_subcategory', $subcategoriaId);
        $this->db->where('product_subcategory.active', ACTIVE);
        $this->db->where('product.active', ACTIVE);
        $this->db->where('product.type', PRODUCTO_VARIANTE);
        $this->db->group_by('color.id_color');
        $this->db->order_by('color.name');
        $query = $this->db->get($this->table.' AS product_subcategory');
        return $query->result();
    }

    function getTalles($subcategoriaId)
    {
        $this->db->select('talle.*');
        $this->db->join(TABLE_SUBCATEGORIES.' subcategory', 'subcategory.id_subcategory = product_subcategory.id_subcategory AND subcategory.active = "' . ACTIVE . '"');
        $this->db->join('variant_products AS producto_variante', 'producto_variante.id_product = product_subcategory.id_product AND producto_variante.active = "'.ACTIVE.'"');
        $this->db->join('products AS product', 'product.id_product = producto_variante.id_product');
        $this->db->join('sizes AS talle', 'talle.id_size = producto_variante.id_size AND talle.active = "' . ACTIVE . '"');
        $this->db->where('subcategory.id_subcategory', $subcategoriaId);
        $this->db->where('product_subcategory.active', ACTIVE);
        $this->db->where('product.active', ACTIVE);
        $this->db->where('product.type', PRODUCTO_VARIANTE);
        $this->db->group_by('talle.id_size');
        $this->db->order_by('talle.name');
        $query = $this->db->get($this->table.' AS product_subcategory');
        return $query->result();
    }

    function getTacos($subcategoriaId)
    {
        $this->db->select('taco.*');
        $this->db->join(TABLE_SUBCATEGORIES.' subcategory', 'subcategory.id_subcategory = product_subcategory.id_subcategory AND subcategory.active = "' . ACTIVE . '"');
        $this->db->join('variant_products AS producto_variante', 'producto_variante.id_product = product_subcategory.id_product AND producto_variante.active = "'.ACTIVE.'"');
        $this->db->join('products AS product', 'product.id_product = producto_variante.id_product');
        $this->db->join('heels AS taco', 'taco.id_heel = producto_variante.id_heel AND taco.active = "' . ACTIVE . '"');
        $this->db->where('subcategory.id_subcategory', $subcategoriaId);
        $this->db->where('product_subcategory.active', ACTIVE);
        $this->db->where('product.active', ACTIVE);
        $this->db->where('product.type', PRODUCTO_VARIANTE);
        $this->db->group_by('taco.id_heel');
        $this->db->order_by('taco.name');
        $query = $this->db->get($this->table.' AS product_subcategory');
        return $query->result();
    }
}
