<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_model extends CI_Model
{

    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'ecommerce_users';
    }

    function add($register)
    {
        $this->db->insert($this->table, $register);
        return $this->db->insert_id();
    }

    function edit($update, $where)
    {
        $this->db->where($where);
        $this->db->update($this->table, $update);
        return $this->db->affected_rows();
    }

    function find($where)
    {
        $this->db->where($where);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    function detail($where)
    {
        $this->db->select('customer.*, condition.name as condition, province.provincia AS province, location.localidad AS location');
        $this->db->join('condition_iva AS condition', 'customer.id_condition_iva = condition.id_condition_iva', 'LEFT');
        $this->db->join('geo_provincias AS province', 'province.id = customer.provincia_id', 'LEFT');
        $this->db->join('localidades AS location', 'location.id = customer.localidad_id', 'LEFT');
        $this->db->where($where);
        $query = $this->db->get($this->table . ' AS customer');
        return $query->row();
    }

    function select($filter)
    {
        $this->db->select('customer.id_users as id, CONCAT(IFNULL(customer.dni, ""), " - ", IFNULL(customer.name, " "), " ", IFNULL(customer.surname, " ")) as text', false);
        $this->db->where('customer.type_id', 2);
        $this->db->like('CONCAT(customer.dni, " ", customer.name, " ", customer.surname)', $filter, false);
        $this->db->order_by('customer.surname');
        $query = $this->db->get($this->table . ' AS customer');
        return $query->result();
    }
}

/* End of file Customer_model.php */
/* Location: ./application/models/Customer_model.php */
