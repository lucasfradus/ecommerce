<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Discount_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_DISCOUNTS;
        $this->id = 'id_discount_code';
    }

    public function get()
    {
        $this->db->where('active', ACTIVE);
        $this->db->order_by('discount', 'asc');
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

    public function first($where)
    {
        $this->db->where($where);
        $this->db->where('active', ACTIVE);
        $this->db->order_by($this->id, 'DESC');
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function getDiscountPercent($total)
    {
        $this->db->where('min <= "'.$total.'" AND max >= '.$total);
        $this->db->where('active', ACTIVE);
        $query = $this->db->get($this->table);
        return $query->row();
    }

}
