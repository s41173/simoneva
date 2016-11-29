<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('transaction');
        $this->tableName = 'transaction';
    }
    
    protected $field = array('id', 'type', 'account_id', 'category_id', 'dppa_id', 'amount', 'month', 'year', 'created', 'updated', 'deleted');
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
    
    function search($cat,$type,$year)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('priority', 'desc'); 
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
    
    function total_year($year)
    {
        $this->db->select_sum('amount');
        $this->db->where('year', $year);
        $val = $this->db->get($this->tableName)->row_array();
        return $val['amount'];
    }
    
    function total_periode($month,$year)
    {
        $this->db->select_sum('amount');
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $val = $this->db->get($this->tableName)->row_array();
        return $val['amount'];
    }
    
}

?>