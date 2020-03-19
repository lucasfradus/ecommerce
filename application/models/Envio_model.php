<?php

class Envio_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_SHIPPING;
        $this->id = 'id_shipping';
        $this->table1 = 'shipping_days';
    }

    public function get($where = null)
    {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->where('active', ACTIVE);
        $this->db->order_by('postal_code', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getList($where = null)
    {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->select('*, GROUP_CONCAT(days) AS days');
        $this->db->where('active', ACTIVE);
        $this->db->order_by('id_shipping', 'asc');
        $this->db->group_by('id_shipping');
        $query = $this->db->get($this->table1);
        return $query->result();
    }
    
    public function getEnviosDays($id)
    {
        $this->db->select('GROUP_CONCAT(days) AS days');
        $this->db->where('active', ACTIVE);
        $this->db->where('id_shipping', $id);
        $this->db->group_by('id_shipping');
        $query = $this->db->get($this->table1);
        return $query->result();
    }
    public function getEnviosDaysEdit($id)
    {
        $this->db->select('days');
        $this->db->where('active', ACTIVE);
        $this->db->where('id_shipping', $id);
        $query = $this->db->get($this->table1);
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

    public function delete($data, $id)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table1, $data);
        return $this->db->insert_id();
    }

    public function deletezone($data, $id)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        return $this->db->insert_id();
    }
}
