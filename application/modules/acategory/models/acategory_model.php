<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Acategory_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('acategory');
        $this->tableName = 'account_category';
    }
    
    protected $field = array('id', 'parent_id', 'type', 'code', 'name', 'dppa_id', 'description', 'orders', 'created', 'updated', 'deleted');
    protected $com;
            
    function count_all_num_rows()
    {
        //method untuk mengembalikan nilai jumlah baris dari database.
        return $this->db->count_all($this->table);
    }
    
    function get_last($limit, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        if ($this->session->userdata('dppa')){ $this->db->where('dppa_id', $this->session->userdata('dppa')); }
        $this->db->order_by('code', 'asc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function report($dppa='null')
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($dppa, 'dppa_id');
        $this->db->order_by('code', 'asc'); 
        return $this->db->get(); 
    }
    
    function search($dppa)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        if ($this->session->userdata('dppa')){ $this->db->where('dppa_id', $this->session->userdata('dppa')); }
        else { $this->cek_null_string($dppa, 'dppa_id'); }
        $this->db->order_by('code', 'asc'); 
        return $this->db->get(); 
    }
    
    function get_last_dppa($dppa)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->where('dppa_id', $dppa);
        $this->db->order_by('code', 'asc'); 
        return $this->db->get(); 
    }
    
}

?>