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
        $this->period = new Period_lib();
        $this->period = $this->period->get();
    }
    
    protected $field = array('id', 'type', 'account_id', 'category_id', 'dppa_id', 'amount', 'month',
                             'opening', 'progress_amount', 'rest', 'year', 'created', 'updated', 'deleted');
    protected $com,$period;
            
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
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function search($dppa,$cat,$month,$year)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($dppa, 'dppa_id');
        $this->cek_null_string($cat, 'category_id');
        $this->cek_null_string($month, 'month');
        $this->cek_null_string($year, 'year');
        return $this->db->get(); 
    }
    
    function get_by_criteria($dppa,$cat,$acc,$month,$year)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($dppa, 'dppa_id');
        $this->cek_null_string($cat, 'category_id');
        $this->cek_null_string($acc, 'account_id');
        $this->cek_null_string($month, 'month');
        $this->cek_null_string($year, 'year');
        return $this->db->get(); 
    }
    
    function report($dppa,$year)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($dppa, 'dppa_id');
        $this->cek_null_string($year, 'year');
        return $this->db->get(); 
    }
    
    function get_last_dppa($dppa)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->where('dppa_id', $dppa);
        $this->db->where('month', $this->period->month);
        $this->db->where('year', $this->period->year);
        $this->db->order_by('month', 'desc'); 
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
    
    function valid_transaction($category,$account,$month,$year)
    {
        $this->db->where('category_id', $category);
        $this->db->where('account_id', $account);
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $query = $this->db->get($this->tableName)->num_rows();

        if($query > 0){ return FALSE; }
        else{ return TRUE; }
    }
    
    function cleaning($dppa,$month,$year)
    {
        $this->db->where('dppa_id', $dppa);
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $this->db->delete($this->tableName);
    }
    
    function valids_period($months,$year)
    {   
        if ( intval($this->period->month) != intval($months) || intval($this->period->year) != intval($year) )
        {
            return FALSE;
        }
        else {  return TRUE; }
    }
    
}

?>