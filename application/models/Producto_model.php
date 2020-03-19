<?php

class Producto_model extends CI_Model
{
    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_PRODUCTS;
        $this->id = 'id_product';
    }

    public function getExport()
    {
        $this->db->select('product.*, subcategory.id_subcategory, category.id_category, group_concat(list_price.price) as prices');
        $this->db->join('products_subcategories product_subcategory', 'product_subcategory.id_product = product.id_product AND product_subcategory.active = "' . ACTIVE . '"', 'left');
        $this->db->join('subcategories subcategory', 'subcategory.id_subcategory = product_subcategory.id_subcategory AND subcategory.active = "' . ACTIVE . '"', 'left');
        $this->db->join('price_products list_price', 'list_price.id_product = product.id_product AND list_price.active = "' . ACTIVE . '"', 'left');
        $this->db->join('categories category', 'category.id_category = subcategory.id_category AND category.active = "' . ACTIVE . '"', 'left');
        $this->db->where('product.active', ACTIVE);
        $this->db->order_by('product.name', 'ASC');
        $this->db->group_by('product.id_product');
        $query = $this->db->get($this->table . ' AS product');
        return $query->result();
    }

    public function related_products()
    {
        $this->db->select('product.id_product, group_concat(related.id_secondary_product) as products_relateds', false);
        $this->db->join('related_products related', 'related.id_product = product.id_product AND related.active = "' . ACTIVE . '"', 'left');
        $this->db->where('product.active', ACTIVE);
        $this->db->group_by('product.id_product');
        $query = $this->db->get($this->table . ' AS product');
        return $query->result();
    }

    public function get()
    {
        $this->db->select('product.*, subcategory.id_subcategory, category.id_category');
        $this->db->join('products_subcategories product_subcategory', 'product_subcategory.id_product = product.id_product AND product_subcategory.active = "' . ACTIVE . '"', 'left');
        $this->db->join('subcategories subcategory', 'subcategory.id_subcategory = product_subcategory.id_subcategory AND subcategory.active = "' . ACTIVE . '"', 'left');
        $this->db->join('categories category', 'category.id_category = subcategory.id_category AND category.active = "' . ACTIVE . '"', 'left');
        $this->db->where('product.active', ACTIVE);
        $this->db->order_by('product.name', 'ASC');
        $this->db->group_by('product.id_product');
        $query = $this->db->get($this->table . ' AS product');
        return $query->result();
    }

    public function getResults($page, $perPage, $params, $numRows = false)
    {
        $this->db->select('producto.*');
        $this->db->join('products_subcategories AS producto_subcategoria', 'producto_subcategoria.id_product = producto.id_product AND producto_subcategoria.active = "'.ACTIVE.'"');
        $this->db->join('subcategories AS subcategoria', 'subcategoria.id_subcategory = producto_subcategoria.id_subcategory AND subcategoria.active = "'.ACTIVE.'"');
        $this->db->join('products_second_subcategories AS producto_segunda_subcategoria', 'producto_segunda_subcategoria.id_product = producto.id_product AND producto_segunda_subcategoria.active = "'.ACTIVE.'"');
        $this->db->where('producto.active', ACTIVE);

        if (!empty($params['categoria'])) {
            $this->db->where('subcategoria.id_category', $params['categoria']);
        }

        if (!empty($params['subcategoria'])) {
            $this->db->where('producto_subcategoria.id_subcategory', $params['subcategoria']);
        }
        if (!empty($params['producto'])) {
            $this->db->like('producto.name', $params['producto']);
        }

        if (!empty($params['icono'])) {
            $this->db->like('producto.icon', $params['icono']);
        }

        if ($numRows) {
            $this->db->group_by('producto.id_product');
            $query = $this->db->get($this->table.' AS producto');
            return $query->num_rows();
        }

        $this->db->order_by('producto.id_product', 'asc');
        $this->db->limit($perPage, $page);
        $this->db->group_by('producto.id_product');

        $query = $this->db->get($this->table.' AS producto');
        return $query->result();
    }

    public function getProductsFiltered($parameters)
    {
        $this->db->select('product.*, group_concat( `list_product_price`.`price`) as `prices`, group_concat(`list_product_price`.`id_list_price`) as lista_id', false);
        $this->db->where('product.active', ACTIVE);
        $this->db->join('products_categories categories', 'categories.id_product = product.id_product AND categories.active = "'.ACTIVE.'"');
        $this->db->join('products_subcategories Subcategories', 'Subcategories.id_product = product.id_product AND Subcategories.active = "'.ACTIVE.'" ');
        $this->db->join('price_products list_product_price', 'list_product_price.id_product = product.id_product AND list_product_price.active ="'.ACTIVE.'"');
        if ($parameters['category']>0) {
            if ($parameters['type']==1) {
                $this->db->where('categories.id_category', $parameters['category']);
            } elseif ($parameters['type']==2) {
                $this->db->where('Subcategories.id_subcategory', $parameters['category']);
            }
        }

        if (array_key_exists('offer', $parameters)) {
            $this->db->where('product.offer', $parameters['offer']);
        }
        if (array_key_exists('search', $parameters)) {
            $this->db->group_start();
            $this->db->like('product.name', $parameters['search']);
            $this->db->or_like('product.description', $parameters['search']);
            $this->db->group_end();
        }
        $this->db->group_by('product.id_product');
        $this->db->order_by('product.name', 'asc');

        if (empty($parameters['count'])) {
            $this->db->limit($parameters['perpage'], $parameters['page']);
        }

        $query = $this->db->get($this->table.' product');
        
        if (array_key_exists('count', $parameters)) {
            if (!($parameters['count']==1)) {
                return $query->result();
            } else {
                return $query->num_rows();
            }
        } else {
            return $query->result();
        }
    }
    
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function find($id)
    {
        $this->db->select('product.*, iva.percent as iva');
        $this->db->join('afip_ivas as iva', 'product.id_iva = iva.id_iva', 'LEFT');
        $this->db->where('product.active', ACTIVE);
        $this->db->where('product.' . $this->id, $id);
        $query = $this->db->get($this->table.' AS product');
        return $query->row();
    }

    public function edit($data, $id)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        return $this->db->insert_id();
    }

    public function search($param, $id)
    {
        $this->db->select('id_product as id, CONCAT(code," ",name) as text', false);
        $this->db->where('active', ACTIVE);
        $this->db->where('id_product !=', $id);
        $this->db->having('text LIKE "%'.$param.'%"');
        $this->db->order_by('name', 'asc');
        $this->db->limit(15);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function findDetalle($id)
    {
        $this->db->select('product.*, subcategory.name as subcategoria, category.id_category, category.name as categoria, product_category.name as super_category, product_category.id_category_product as id_super_category');
        $this->db->join(TABLE_CATEGORIES_PRODUCTS.' product_category', 'product.id_category_product = product_category.id_category_product AND product_category.active = "'.ACTIVE.'"', 'left');
        $this->db->join(TABLE_PRODUCTS_SUBCATEGORIES.' product_subcategory', 'product_subcategory.id_product = product.id_product AND product_subcategory.active = "'.ACTIVE.'"', 'left');
        $this->db->join(TABLE_SUBCATEGORIES.' subcategory', 'subcategory.id_subcategory = product_subcategory.id_subcategory AND subcategory.active = "'.ACTIVE.'"', 'left');
        $this->db->join(TABLE_CATEGORIES.' category', 'category.id_category = subcategory.id_category AND category.active = "'.ACTIVE.'"', 'left');
        $this->db->where('product.active', ACTIVE);
        $this->db->where('product.'.$this->id, $id);
        $query = $this->db->get($this->table.' product');
        return $query->row();
    }

    public function findDetail($id)
    {
        $this->db->select('product.*, category.name as category, subcategory.name AS subcategory');
        $this->db->join('products_categories categories', 'categories.id_product = product.id_product AND categories.active = "'.ACTIVE.'"');
        $this->db->join('products_subcategories Subcategories', 'Subcategories.id_product = product.id_product AND Subcategories.active = "'.ACTIVE.'" ');
        $this->db->join(TABLE_SUBCATEGORIES.' subcategory', 'subcategory.id_subcategory = Subcategories.id_product AND subcategory.active = "'.ACTIVE.'"', 'left');
        $this->db->join(TABLE_CATEGORIES.' category', 'category.id_category = categories.id_product  AND category.active = "'.ACTIVE.'"', 'left');
        $this->db->where('product.active', ACTIVE);
        $this->db->where('product.'.$this->id, $id);
        $this->db->group_by('product.id_product');
        $query = $this->db->get($this->table.' product');
        return $query->row();
    }

    public function getFeaturedCategory()
    {
        $this->db->select('product.*, subcategory.id_category, group_concat( `list_product_price`.`price`) as `prices`, group_concat(`list_product_price`.`id_list_price`) as lista_id', false);
        $this->db->join('subcategories subcategory', 'subcategory.id_category = category.id_category AND subcategory.active = "'.ACTIVE.'"');
        $this->db->join('products_subcategories product_subcategory', 'product_subcategory.id_subcategory = subcategory.id_subcategory AND product_subcategory.active = "'.ACTIVE.'"');
        $this->db->join('products product', 'product.id_product = product_subcategory.id_product AND product.active = "'.ACTIVE.'"');
        $this->db->join('price_products list_product_price', 'list_product_price.id_product = product.id_product AND list_product_price.active ="'.ACTIVE.'"');
        $this->db->where('category.active', ACTIVE);
        $this->db->where('product.featured', ACTIVE);
        $this->db->order_by('category.id_category');
        $this->db->order_by('product.name');
        $this->db->group_by('product.id_product');
        $query = $this->db->get('categories category');
        return $query->result();
    }

    public function getCategory($parameters)
    {
        $where_brand = isset($parameters['where']['filters_brand']) ? ' AND brand.id_brand IN ('.implode(',', $parameters['where']['filters_brand']).')' : '';
        $this->db->select('product.*, brand.image as icono_marca');
        $this->db->join('products_subcategories product_subcategory', 'product_subcategory.id_product = product.id_product AND product_subcategory.active = "'.ACTIVE.'"');
        if ($parameters['where']['id_subcategory'] > 0 && $parameters['where']['id_subcategory']) {
            $this->db->join('subcategories subcategory', 'product_subcategory.id_subcategory = subcategory.id_subcategory AND subcategory.id_subcategory = "'.$parameters['where']['id_subcategory'].'" AND subcategory.active = "'.ACTIVE.'"');
        }

        if ($parameters['where']['id_category'] > 0 && $parameters['where']['id_category']) {
            if ($parameters['where']['id_subcategory'] > 0 && !empty($parameters['where']['id_subcategory'])) {
                $this->db->join('categories category', 'category.id_category = subcategory.id_category AND category.id_category = "'.$parameters['where']['id_category'].'" AND category.active = "'.ACTIVE.'"');
            } else {
                $this->db->join('categories category', 'category.id_category = "'.$parameters['where']['id_category'].'" AND category.active = "'.ACTIVE.'"');
            }
        }

        $this->db->join(TABLE_BRANDS.' brand', 'brand.id_brand = product.id_brand AND brand.active = "'.ACTIVE.'"'.$where_brand);

        if (isset($parameters['where']['filters_sport']) && !empty($parameters['where']['filters_sport'])) {
            $this->db->join(TABLE_PRODUCTOS_SPORTS.' product_sport', 'product_sport.id_product = product.id_product AND product_sport.active = "'.ACTIVE.'" AND product_sport.id_sport IN ('.implode(',', $parameters['where']['filters_sport']).')');
        }

        if (isset($parameters['where']['filters_color']) && !empty($parameters['where']['filters_color'])) {
            $this->db->join(TABLE_PRODUCTS_COLOR.' product_color', 'product_color.id_product = product.id_product AND product_color.active = "'.ACTIVE.'" AND product_color.id_color IN ('.implode(',', $parameters['where']['filters_color']).')', 'left');
        }

        if (isset($parameters['where']['filters_size']) && !empty($parameters['where']['filters_size'])) {
            if (!empty(implode(',', $parameters['where']['filters_size']) && !empty(implode(',', array_filter($parameters['where']['filters_size']))))) {
                var_dump($parameters['where']['filters_size']);
                $this->db->join(TABLE_PRODUCTS_SIZES.' product_size', 'product_size.id_product = product.id_product AND product_size.active = "'.ACTIVE.'" AND product_size.id_size IN ('.implode(',', array_filter($parameters['where']['filters_size'])).')');
            }
        }

        $this->db->where('product.active', ACTIVE);
        if ($parameters['where']['id_category_product'] > 0 && $parameters['where']['id_category_product']) {
            $this->db->where('product.id_category_product', $parameters['where']['id_category_product']);
        }

        if ((isset($parameters['where']['filters_price']['minimo']) || !empty($parameters['where']['filters_price']['minimo'])) && (isset($parameters['where']['filters_price']['maximo']) && !empty($parameters['where']['filters_price']['maximo']))) {
            $this->db->where('(product.price >= '.$parameters['where']['filters_price']['minimo'].' AND product.price <= '.$parameters['where']['filters_price']['maximo'].')');
        }

        $this->db->group_by('product.id_product');
        $this->db->order_by('product.name');

        if (empty($parameters['num_rows'])) {
            $this->db->limit(PER_PAGE, $parameters['page']);
        }

        $query = $this->db->get('products product');

        if (!empty($parameters['num_rows'])) {
            return $query->num_rows();
        } else {
            return $query->result();
        }
    }

    function heel($productoId)
    {
        $this->db->select('heel.*');
        $this->db->join('heels AS heel', 'heel.id_heel = producto.id_heel');
        $this->db->where('producto.id_product', $productoId);
        $query = $this->db->get('products AS producto');
        return $query->result();
    }

    function select($filter)
    {
        $this->db->select('product.id_product as id, CONCAT(IFNULL(product.code, ""), " ", IFNULL(product.name, " ")) as text', false);
        $this->db->where('product.active', ACTIVE);
        $this->db->like('product.name', $filter);
        $query = $this->db->get('products AS product');
        return $query->result();
    }

    function truncate()
    {
        $dataStatus = [
            'active' => 0,
        ];
        $this->db->update($this->table, $dataStatus);
        return $this->db->affected_rows();
    }

    function truncatelistprices()
    {
        $dataStatus = [
            'active' => 0,
        ];
        $this->db->update('price_products', $dataStatus);
        return $this->db->affected_rows();
    }

    function detail($product_id)
    {
        $this->db->select('product.*, category.name as category, category.id_category AS category_id, subcategory.name as subcategory,group_concat(DISTINCT galeria.image) as galeri,group_concat(list_product_price.price) as prices, group_concat(list_product_price.id_list_price) as lista_id', false);
        $this->db->join('products_categories prod_cat', 'prod_cat.id_product = product.id_product AND prod_cat.active = "' . ACTIVE . '"');
        $this->db->join('categories AS category', 'category.id_category = prod_cat.id_category');
        $this->db->join('product_images galeria', 'galeria.id_product = product.id_product AND galeria.active ="'. ACTIVE .'"', 'left');
        $this->db->join('products_subcategories AS prod_sub', 'prod_sub.id_product = product.id_product AND prod_sub.active = "' . ACTIVE . '"');
        $this->db->join('price_products list_product_price', 'list_product_price.id_product = product.id_product AND list_product_price.active ="'.ACTIVE.'"');
        $this->db->join('subcategories AS subcategory', 'subcategory.id_subcategory = prod_sub.id_subcategory');
        $this->db->where('product.active', ACTIVE);
        $this->db->where('product.' . $this->id, $product_id);
        $query = $this->db->get($this->table . ' AS product');
        return $query->row();
    }

    public function getGallery($id)
    {
        $this->db->select('gallery.*');
        $this->db->where('gallery.active', ACTIVE);
        $this->db->where('gallery.id_product', $id);
        $this->db->order_by('gallery.create_at', 'DESC');
        $query = $this->db->get('product_images gallery');
        return $query->result();
    }

    public function deleteGallery($id)
    {
        $data = array(
            'active' => 0,
            'deleted_at' => date('Y-m-d h:i:s'),
            'delete_by' => $this->session->userdata('user_id'),
        );
        $this->db->where('id_product_image', $id);
        $this->db->update('product_images', $data);
        return $this->db->insert_id();
    }

    public function findCode($code)
    {
        $this->db->select('product.id_product');
        $this->db->where('product.active', ACTIVE);
        $this->db->where('product.code', $code);
        $query = $this->db->get($this->table.' AS product');
        return $query->row();
    }

}
