<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Balance_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('balance');
        $this->tableName = 'balance';
    }
    
    protected $field = array('id', 'type', 'account_id', 'category_id', 'dppa_id', 'priority', 'source', 'amount', 'year', 'created', 'updated', 'deleted');
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
        $this->db->order_by('priority', 'desc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function search($dppa,$cat,$type,$year)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('priority', 'desc'); 
        $this->cek_null_string($dppa, 'dppa_id');
        $this->cek_null_string($cat, 'category_id');
        $this->cek_null_string($type, 'priority');
        $this->cek_null_string($year, 'year');
        return $this->db->get(); 
    }
    
    function get_last_dppa($dppa)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->where('dppa_id', $dppa);
        $this->db->order_by('priority', 'desc'); 
        return $this->db->get(); 
    }
    
    function total_child($year)
    {
        $this->db->select_sum('amount');
        $this->db->where('year', $year);
        $this->db->where('priority', 0);
        $val = $this->db->get($this->tableName)->row_array();
        return $val['amount'];
    }
    
    function total_priority($year)
    {
        $this->db->select_sum('amount');
        $this->db->where('year', $year);
        $this->db->where('priority', 1);
        $val = $this->db->get($this->tableName)->row_array();
        return $val['amount'];
    }
    
    function valid_balance($account,$year)
    {
        $this->db->where('account_id', $account);
        $this->db->where('year', $year);
        $query = $this->db->get($this->tableName)->num_rows();

        if($query > 0){ return FALSE; }
        else{ return TRUE; }
    }
    
}

?>