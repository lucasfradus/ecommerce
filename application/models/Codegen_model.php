<?php
class Codegen_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sudaca_cms_md');
        $this->load->model('sudaca_ecommerce_md');
    }

    function get($table,$fields,$where='')
    {
        $this->db->select($fields);
        $this->db->from($table);
        if($where)
        {
            $this->db->where($where);
        }
        $query = $this->db->get();        
        return $query->result();
    }

    function row($table,$fields,$where='')
    {
        $query = $this->db
                ->select($fields)
                ->where($where)
                ->get($table);
        return $query->row();
    }
    
    function add($table,$data)
    {
        $this->db->insert($table, $data);
        $consulta = $this->db->last_query();
        $insert = $this->db->insert_id();
        if ($this->db->affected_rows() == '1')
        {
            $this->backend_lib->log_consultas($consulta);
            return $insert;
        }
        return FALSE;       
    }

    function addNoAudit($table,$data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function edit($table,$data,$fieldID,$ID)
    {
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);
        $consulta = $this->db->last_query();

        if ($this->db->affected_rows() >= 0)
        {
           $this->backend_lib->log_consultas($consulta);
           return TRUE;
        }

        return FALSE;

    }

    function delete($table,$fieldID,$ID)
    {
        $this->db->where($fieldID,$ID);
        $this->db->delete($table);
        $consulta = $this->db->last_query();

        if ($this->db->affected_rows() == '1') {
            $this->backend_lib->log_consultas($consulta);
            return TRUE;
        }

        return FALSE;        
    }   

    function count($table)
    {
        return $this->db->count_all($table);
    }


    function permisos_efectivos($menu,$id_usuario){
        $query = $this->db
        ->select('u.id_user, up.id_group, p.*')
        ->join('users_groups up', 'up.id_user = u.id_user')
        ->join('permissions p', 'p.id_group = up.id_group')
        ->where('u.id_user =', $id_usuario)
        ->where('p.id_menu =', $menu)
        ->limit('1')
        ->get('users u');
        return $query->row();
    }

    function getWhereJoin($id, $select, $where, $tabla, $join, $on)
    {
        if ($id == "" || $where == ""){
            $query = $this->db
            ->select($select)
            ->join($join, $on, 'inner')
            ->get($tabla);    
        }
        else{
            $query = $this->db
            ->select($select)
            ->where($where, $id)
            ->join($join, $on, 'inner')
            ->get($tabla);    
        }
        return $query->result();
    }

    function insertBloques($db, $data)
    {
        $this->db->insert_batch($db, $data); 
    }

}