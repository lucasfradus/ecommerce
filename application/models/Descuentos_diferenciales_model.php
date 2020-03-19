<?php

class Descuentos_diferenciales_model extends CI_Model
{

    private $table;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->table = TABLE_BULK_DISCOUNTS;
        $this->join_table = TABLE_BULK_DISCOUNTS_DETAILS;
        $this->id = 'id_differentias_discounts';
        $this->join_id = 'id_differential_discounts_fk';


    
    }


    public function get_descuento($id, $qty){
        $this->db->join($this->table, 'differential_discounts_details.id_differential_discounts_fk = differential_discounts.id_differentias_discounts');

        $this->db->where('active', ACTIVE);
        $this->db->where($this->join_id, $id);
        $this->db->where('min_qty <= "'.$qty.'" AND max_qty >= '.$qty);
        $query = $this->db->get( $this->join_table);
        return $query->row();
    }

    

    public function get()
    {
        $this->db->where('active', ACTIVE);
        $this->db->order_by($this->id, 'desc');
        
        $query = $this->db->get($this->table);
        $query = $query->result();
        //le agreggo al objeto los detalles de la tabla pivot
        foreach($query as &$record){
            $record->detalles = $this->get_pivot($record->id_differentias_discounts);
        }
        return $query;
       
    }

    public function get_pivot($id){
        $this->db->where($this->join_id, $id);
        $query = $this->db->get($this->join_table);
        return $query->result();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function insert_details($data)
    {
        $this->db->insert($this->join_table, $data);
        return $this->db->insert_id();
    }

    public function find($id)
    {
        $this->db->where('active', ACTIVE);
        $this->db->where($this->id, $id);
        $query = $this->db->get($this->table);
        $query = $query->row();
        $query->detalles = $this->get_pivot($id);
        return  $query;
    }

    public function edit($data, $id)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        return $this->db->insert_id();
    }
}
