<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dppa_lib extends Main_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'dppa';
    }

    function combo()
    {
        $this->db->select('id, code, name');
        $this->db->where('deleted', NULL);
        $this->db->where('publish',1);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        $data['options'][0] = 'Top';
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }
    
    function combo_child()
    {
        $this->db->select('id, code, name');
        $this->db->where('deleted', NULL);
        $this->db->where('publish',1);
        $this->db->order_by('name', 'asc');
        if ($this->session->userdata('dppa')){ $this->db->where('id', $this->session->userdata('dppa')); }
        $val = $this->db->get($this->tableName)->result();
        if ($val){ foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); } }
        else { $data['options'][''] = '-- Select Category --'; }
        return $data;
    }
    
    function combo_all()
    {
        $this->db->select('id, code, name');
        $this->db->where('deleted', NULL);
        $this->db->where('publish',1);
        $this->db->order_by('name', 'asc');
        $data['options'][''] = '-- All --';
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }

    function combo_update($id)
    {
        $this->db->select('id, code, name');
        $this->db->where('deleted', NULL);
        $this->db->where('publish',1);
        $this->db->order_by('name', 'asc');
        $this->db->where_not_in('id', $id);
        $val = $this->db->get($this->tableName)->result();
        $data['options'][0] = 'Top';
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }

    function get($id=null)
    {
        if ($id)
        {
            $this->db->select('id, code, name');
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return $val->name; }
        }
        else if($id == 0){ return 'Top'; }
        else { return ''; }
    }
    
    function get_name($id=null)
    {
        if ($id)
        {
            $this->db->select('id, code, name');
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return $val->name; }
        }
        else if($id == 0){ return 'Top'; }
        else { return ''; }
    }
    
    function get_code($id=null)
    {
        if ($id)
        {
            $this->db->select('id, code, name');
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return $val->code; }
        }
        else if($id == 0){ return 'Top'; }
        else { return ''; }
    }
    
    function cek_dppa($id=null)
    {
       if ($id)
       {
            $this->db->select('id, code, name');
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->num_rows();
            if ($val>0){ return TRUE; }else{ return FALSE; }
       } 
       else{ return FALSE; }
    }
    
    function cek_user_dppa($username)
    {
        $admin = new Admin_lib();
        if ($admin->get_dppa($username) == 0){
            $this->session->unset_userdata('dppa');
        }
    }

}

/* End of file Property.php */
