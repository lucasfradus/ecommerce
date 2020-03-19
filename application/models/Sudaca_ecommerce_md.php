<?php

class Sudaca_ecommerce_md extends CI_Model
{

    function __construct()
    {

        parent::__construct();
    }

    function login($usuario, $password, $campo)
    {
        $query = $this->db
            ->select('*')
            ->where($campo, $usuario)
            ->where('password', $password)
            ->where('tipo_usuario_id', 2)
            ->get('ecommerce_usuarios');

        if ($query->num_rows() > 0)
        {
            return $query->row();

        } else {
            return null;

        }

    }

    function countProductosFiltro($id)
    {
        $query = $this->db
                        ->where('ep.active = 1')
                        ->where('ep.subcategoria_id', $id)
                        ->get('ecommerce_productos ep');
        return $query->num_rows();
    }

    function getProductosFiltro($id, $page)
    {
        $query = $this->db
            ->where('ep.active = 1')
            ->where('ep.subcategoria_id', $id)
            ->order_by('ep.id DESC')
            ->limit(15, $page)
            ->get('ecommerce_productos ep');

        return $query->result();

    }

    function countProductos()
    {
        $query = $this->db
            ->where('ep.active = 1')
            ->get('ecommerce_productos ep');
        return $query->num_rows();

    }

    function getCategoriasSubcategorias()
    {
        $query = $this->db
            ->select('subcategory.*, category.name AS category, subcategory.name AS subcategory')
            ->join('subcategories subcategory', 'subcategory.id_category = category.id_category')
            ->where('category.active', ACTIVE)
            ->where('subcategory.active', ACTIVE)
            ->get('categories category');
        return $query->result();

    }

    function getSubcategoriasSegundaSubcategorias()
    {
        $query = $this->db
            ->select('ess.*, es.nombre AS subcategoria, ess.nombre AS segundaSubcategoria')
            ->join('ecommerce_segunda_subcategorias ess', 'ess.subcategoria_id = es.id')
            ->get('ecommerce_subcategorias es');
        return $query->result();
    }

    function getProducto($id)
    {
        $query = $this->db
                        ->select('ep.*, ec.nombre as categoria, es.nombre as subcategoria')
                        ->join('ecommerce_categorias ec', 'ep.categoria_id = ec.id')
                        ->join('ecommerce_subcategorias es', 'ep.subcategoria_id = es.id', 'left')
                        ->where('ep.id', $id)
                        ->where('ep.active', 1)
                        ->get('ecommerce_productos ep');
        return $query->row();
    }

    function getProductos($page = 0)
    {
        $query = $this->db
                        ->select('ep.*, ec.nombre AS categoria, es.nombre AS subcategoria')
                        ->join('ecommerce_categorias ec', 'ec.id = ep.categoria_id')
                        ->join('ecommerce_subcategorias es', 'es.id = ep.subcategoria_id')
                        ->where('ep.active', 1)
                        ->limit(15, $page)
                        ->get('ecommerce_productos ep');
        return $query->result();
    }

    function getProductosMedidas($id)
    {
        $query = $this->db
                        ->select('epm.*, em.medida')
                        ->join('ecommerce_medidas em', 'epm.medida_id = em.id')
                        ->where('epm.producto_id', $id)
                        ->get('ecommerce_productos_medidas epm');
        return $query->result();
    }

    function rowProducto($id)
    {
        $query = $this->db
                        ->select('ep.*, ec.nombre AS categoria, es.nombre AS subcategoria')
                        ->join('ecommerce_categorias ec', 'ec.id = ep.categoria_id')
                        ->join('ecommerce_subcategorias es', 'es.id = ep.subcategoria_id')
                        ->where('ep.id', $id)
                        ->get('ecommerce_productos ep');
        return $query->row();
    }

    function getProductosFronend($categoria_id = null, $subcategoria_id = null, $segundaSubcategoria_id = null)
    {
        if ($categoria_id)
        {
            $query = $this->db->where('ec.id', $categoria_id);
        }

        if ($subcategoria_id)
        {
            $query = $this->db->where('es.id', $subcategoria_id);
        }

        $query = $this->db
                        ->select('ep.*, ec.nombre AS categoria, es.nombre AS subcategoria')
                        ->join('ecommerce_categorias ec', 'ec.id = ep.categoria_id')
                        ->join('ecommerce_subcategorias es', 'es.id = ep.subcategoria_id')
                        ->order_by("ep.id", "desc")
                        ->get('ecommerce_productos ep');

        return $query->result();

    }

    function rowProductoFrontend($id)
    {
        $query = $this->db
                        ->select('ep.*, ec.nombre AS categoria, es.nombre AS subcategoria')
                        ->join('ecommerce_categorias ec', 'ec.id = ep.categoria_id')
                        ->join('ecommerce_subcategorias es', 'es.id = ep.subcategoria_id')
                        ->where('ep.id', $id)
                        ->where('ep.active', 1)
                        ->get('ecommerce_productos ep');

        return $query->row();
    }

    function getMedidasProductos($id)
    {
        $query = $this->db
            ->select('epm.*, em.medida')
            ->join('ecommerce_medidas em', 'em.id = epm.medida_id')
            ->where('epm.producto_id', $id)
            ->get('ecommerce_productos_medidas epm');
        return $query->result();
    }

    function getColoresProductos($id)
    {
        $query = $this->db
                        ->select('epm.*, em.nombre, em.color')
                        ->join('ecommerce_colores em', 'em.id = epm.color_id')
                        ->where('epm.producto_id', $id)
                        ->get('ecommerce_productos_colores epm');
        return $query->result();
    }

    function getProductosDestacados()
    {
        $query = $this->db
                        ->select('ep.*')
                        ->where('ep.destacado', 1)
                        ->where('ep.active', 1)
                        ->order_by("ep.id", "random")
                        ->limit(15)
                        ->get('ecommerce_productos ep');
        return $query->result();
    }

    function getProductosoferta()
    {
        $query = $this->db
                        ->select('ep.*')
                        ->where('ep.oferta', 1)
                        ->where('ep.active', 1)
                        ->get('ecommerce_productos ep');
        return $query->result();
    }

    function getTipoUsuario()
    {
        $query = $this->db
                        ->select('*')
                        ->where('ov.opcion_id', 1)
                        ->get('opciones_variables ov');
        return $query->result();
    }

    function getPedidos()
    {
        $query = $this->db
            ->select('order.*, customer.name, customer.surname, order_status.name AS status, payment.name AS payment')
            ->join('customers customer', 'order.id_customer = customer.id_customer')
            ->join('orders_statuses order_status', 'order_status.id_order_status = order.id_status')
            ->join('payment_methods payment', 'payment.id_payment_method = order.id_payment_method', 'left')
            ->where('order.active', ACTIVE)
            ->get('orders order');
        return $query->result();
    }

    function getPedidosUsuarios($id, $page)
    {
        $query = $this->db
                        ->select('ep.*, e.nombre AS estado,eu.persona_contacto')
                        ->join('ecommerce_usuarios eu', 'ep.usuario_id = eu.id')
                        ->join('ecommerce_pedidos_estados e', 'e.id = ep.estado_id')
                        ->join('ecommerce_medios_pagos m', 'm.id = ep.metodo_pago_id', 'left')
                        ->where('eu.id', $id)
                        ->limit(10, $page)
                        ->order_by('ep.id', 'desc')
                        ->get('ecommerce_pedidos ep');
        return $query->result();
    }

    public function countPedidosUsuario($id = '')
    {
        $query = $this->db
                        ->select('ep.*, e.nombre AS estado,eu.persona_contacto')
                        ->join('ecommerce_usuarios eu', 'ep.usuario_id = eu.id')
                        ->join('ecommerce_pedidos_estados e', 'e.id = ep.estado_id')
                        ->where('eu.id', $id)
                        ->get('ecommerce_pedidos ep');
        return $query->num_rows();
    }

    function getPedidosProctos($id)
    {
        $query = $this->db
                        ->select('order_product.*, product.name AS producto')
                        ->join('products product', 'product.id_product = order_product.id_product')
                        ->where('order_product.id_order', $id)
                        ->where('order_product.active', ACTIVE)
                        ->get('ordered_products order_product');
        return $query->result();
    }

    function rowUsuarioPedido($id)
    {
        $query = $this->db
                    ->select('customer.*, order.*, payment.name as payment')
                    ->join('customers customer', 'order.id_customer = customer.id_customer')
                    ->join('payment_methods payment', 'payment.id_payment_method = order.id_payment_method')
                    ->where('order.id_order', $id)
                    ->get('orders order');
        return $query->row();
    }

    function rowUsuario($id)
    {
        $query = $this->db
                        ->select('eu.*')
                        ->where('eu.id_users', $id)
                        ->get('ecommerce_users eu');
        return $query->row();
    }

    function getUsuario()
    {
        $query = $this->db
                        ->select('eu.*')
                        ->where('eu.active', 1)
                        ->get('ecommerce_users eu');
        return $query->result();
    }

    function getMenu($filtro)
    {
        $query = $this->db
                        ->select('c.nombre AS categoria, c.id AS categoria_id, s.nombre AS subcategoria, s.id AS subcategoria_id, sc.nombre AS subcategoria_dos, sc.id AS subcategoria_dos_id')
                        ->join('ecommerce_subcategorias s', 's.categoria_id = c.id')
                        ->join('ecommerce_segunda_subcategorias sc', 'sc.subcategoria_id = s.id')
                        ->group_by($filtro)
                        ->order_by('categoria_id')
                        ->order_by('subcategoria')
                        ->order_by('subcategoria_dos')
                        ->get('ecommerce_categorias c');

        return $query->result();
    }

    public function getCpWebServiceOcaCliente()
    {
        $query = $this->db
                        ->select('*')
                        ->where('c.id_configuration', 16)
                        ->get('configurations c');
        return $query->row();
    }

    function countProductosBusqueda($data_busqueda = '')
    {
        $query = $this->db
                    ->where('ep.active = 1')
                    ->where($data_busqueda)
                    ->get('ecommerce_productos ep');
        return $query->num_rows();
    }

    function getProductosBusqueda($page = 0, $data_busqueda = '')
    {
        $query = $this->db
                        ->select('ep.*, ec.nombre AS categoria, es.nombre AS subcategoria')
                        ->join('ecommerce_categorias ec', 'ec.id = ep.categoria_id')
                        ->join('ecommerce_subcategorias es', 'es.id = ep.subcategoria_id')
                        ->where('ep.active', 1)
                        ->where($data_busqueda)
                        ->limit(15, $page)
                        ->get('ecommerce_productos ep');
        return $query->result();
    }

    function countProductosCategoria($id)
    {
        $query = $this->db
                        ->where('ep.active = 1')
                        ->where('ep.categoria_id', $id)
                        ->get('ecommerce_productos ep');
        return $query->num_rows();
    }

    function getProductosCategoria($id, $page)
    {
        $query = $this->db
                        ->where('ep.active = 1')
                        ->where('ep.categoria_id', $id)
                        ->order_by('ep.id DESC')
                        ->limit(15, $page)
                        ->get('ecommerce_productos ep');
        return $query->result();
    }

    function countProductosFiltroBusqueda($id, $data_busqueda = '')
    {
        $query = $this->db
                        ->where('ep.active = 1')
                        ->where('ep.subcategoria_id', $id)
                        ->where($data_busqueda)
                        ->get('ecommerce_productos ep');
        return $query->num_rows();

    }

    function getProductosFiltroBusqueda($id, $page, $data_busqueda = '')
    {
        $query = $this->db
                        ->where('ep.active = 1')
                        ->where('ep.subcategoria_id', $id)
                        ->where($data_busqueda)
                        ->order_by('ep.id DESC')
                        ->limit(15, $page)
                        ->get('ecommerce_productos ep');
        return $query->result();

    }

    function actualizarProductosCategoria($porcentaje, $categoria_id, $subcategoria_id = null)
    {
        $this->db->where('categoria_id', $categoria_id);

        if (is_numeric($subcategoria_id))
        {
            $this->db->where('subcategoria_id', $subcategoria_id);
        }
        
        $this->db->set('precio', 'precio * '.$porcentaje, false);
        $this->db->update('ecommerce_productos');
        return true;

    }

    function getColoresProducto($producto_id)
    {
        $this->db->select('eco_col.*');
        $this->db->join('ecommerce_colores eco_col', 'eco_col.id = ecol_prod.color_id');
        $this->db->where('ecol_prod.producto_id', $producto_id);
        $this->db->order_by('eco_col.nombre', 'desc');
        $query = $this->db->get('ecommerce_colores_productos ecol_prod');
        return $query->result();

    }

    public function getDatosPedido($id)
    {
        $this->db->select('pedido.*, medio_pago.nombre as medio_pago, medio_envio.nombre as medio_envio');
        $this->db->where('pedido.id', $id);
        $this->db->join('ecommerce_medios_pagos medio_pago', 'pedido.metodo_pago_id = medio_pago.id');
        $this->db->join('ecommerce_medios_envio medio_envio', 'pedido.modo_envio = medio_envio.id');
        $query = $this->db->get('ecommerce_pedidos pedido');
        return $query->result();

    }
}
