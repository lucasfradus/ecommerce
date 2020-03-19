<?php

class Pedido_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_ORDERS;
        $this->id = 'id_order';
    }

    public function get()
    {
        $query = $this->db
            ->select('order.*, eu.name, eu.surname, eu.type_id, order_status.name AS status, payment.name AS payment, invoice.id_invoice')
            ->join('ecommerce_users eu', 'order.id_users = eu.id_users')
            ->join('orders_statuses order_status', 'order_status.id_order_status = order.id_status')
            ->join('payment_methods payment', 'payment.id_payment_method = order.id_payment_method', 'LEFT')
            ->join('order_invoices AS invoice', 'order.id_order = invoice.id_order AND invoice.active = "1"', 'LEFT')
            ->where('order.active', ACTIVE)
            ->get('orders AS order');

        return $query->result();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function find($id)
    {
        $this->db->select('order.*, eu.name, payment.name as payment_method, shipping.name as shipping_method, eu.surname, eu.phone, eu.email, eu.address, localidad.localidad as location, provincia.provincia as province');
        $this->db->join('ecommerce_users eu', 'order.id_users = eu.id_users');
        $this->db->join('geo_provincias AS provincia', 'provincia.id = eu.provincia_id', 'left');
        $this->db->join('localidades AS localidad', 'localidad.id = eu.localidad_id', 'left');
        $this->db->join('payment_methods payment', 'payment.id_payment_method = order.id_payment_method', 'left');
        $this->db->join('shipping_methods shipping', 'shipping.id_shipping_methods = order.id_shipping', 'left');
        $this->db->where('order.active', ACTIVE);
        $this->db->where('order.'.$this->id, $id);
        $query = $this->db->get($this->table.' order');
        return $query->row();
    }

    public function findPedido($id)
    {
        $this->db->select('order.*, eu.name, payment.name as payment_method, shipping.name as shipping_method, eu.surname, eu.phone, eu.email, eu.address, localidad.localidad as location, provincia.provincia as province');
        $this->db->join('ecommerce_users eu', 'order.id_users = eu.id_users');
        $this->db->join('geo_provincias AS provincia', 'provincia.id = eu.provincia_id');
        $this->db->join('localidades AS localidad', 'localidad.id = eu.localidad_id');
        $this->db->join('payment_methods payment', 'payment.id_payment_method = order.id_payment_method', 'left');
        $this->db->join('shipping_methods shipping', 'shipping.id_shipping_methods = order.id_shipping', 'left');
        $this->db->where('order.active', ACTIVE);
        $this->db->where('order.'.$this->id, $id);
        $query = $this->db->get($this->table.' order');
        return $query->row();
    }

    public function edit($data, $id)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        return $this->db->insert_id();
    }

    public function getPedido($id)
    {
        $query = $this->db
            ->select('eu.*, order.*,locality.localidad AS Localidad, provincies.provincia AS Provincia')
            ->join('ecommerce_users eu', 'order.id_users = eu.id_users')
            ->join('geo_provincias provincies', 'provincies.id = eu.provincia_id', 'left')
            ->join('localidades locality', 'locality.id = eu.localidad_id', 'left')
            ->where('order.id_order', $id)
            ->get('orders order');
        return $query->row();
    }

    public function getPedidoProductos($id)
    {
        $this->db->select('pro.id_product AS product_id,
        pro.name AS product_name,
        ord_pro.qty AS order_qty,pri_pro.price AS product_price, (
        ord_pro.qty * pri_pro.price) AS order_total', false);
        $this->db->join('products pro', 'ord_pro.id_product = pro.id_product');
        $this->db->join('price_products pri_pro', 'ord_pro.price = pri_pro.id_list_price AND ord_pro.id_product = pri_pro.id_product');
        $this->db->where('ord_pro.id_order', $id);
        $this->db->group_by('ord_pro.id_order_product');
        $query= $this->db->get('ordered_products ord_pro');
        return $query->result();
    }

    public function findByUserId($id)
    {
        $this->db->select("order.*, eu.name, eu.surname, eu.phone, eu.email, eu.address");
        $this->db->join('ecommerce_users eu', 'order.id_users = eu.id_users');
        $this->db->where('order.active', ACTIVE);
        $this->db->where('eu.id_users', $id);
        $this->db->group_by('order.id_order');
        $query = $this->db->get('orders order');
        return $query->result();
    }

    public function getOrderProducts($id)
    {
        $query = $this->db
            ->select('order_product.*, product.name AS producto, order.can_unity AS unity, order.can_bulto AS package, order.cost_shipping as shipping_price,order.discount as discount')
            ->join('products product', 'product.id_product = order_product.id_product')
            ->join('orders order', 'order.id_order = order_product.id_order')
            ->where('order_product.id_order', $id)
            ->where('order_product.active', ACTIVE)
            ->get('ordered_products order_product');
        return $query->result();
    }

}
