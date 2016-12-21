<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procurement_lib extends Main_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'procurement';
        $this->account = new Account_lib();
    }

    protected $account;
    protected $field = array('id', 'type', 'account_id', 'category_id', 'dppa_id', 'top', 'title', 'budget', 'amount', 'month',
                             'year', 'vendor', 'contact', 'contract_no', 'contract_date',
                             'created', 'updated', 'deleted');

    function get_title($id=null)
    {
        if ($id)
        {
            $this->db->select($this->field);
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return ucfirst($val->title); }
        }
        else if($id == 0){ return 'Top'; }
        else { return ''; }
    }

    function get_type($id=null)
    {
        if ($id)
        {
            $this->db->select($this->field);
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return $val->type; }
        }
        else { return ''; }
    }
    
    // mendapatkan jumlah transaksi per tahun
    function get_total($dppa,$month,$year,$type=0)
    {
        $this->db->select_sum('amount');
        $this->db->where('year', $year);
        $this->db->where('dppa_id', $dppa);
        $val = $this->db->get($this->tableName)->row_array();
        if ($type == 0){ return $val['amount']; }else { return $val['progress_amount']; }
    }
    
    // fungsi untuk mendapatkan summary periode bulan
    function get_total_monthly($dppa,$cat='null',$acc='null',$month,$year,$type=0)
    {        
        $this->db->select_sum('procurement.amount');
        
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $this->db->where('dppa_id', $dppa);
        $this->cek_null_string($cat, 'category_id');
        $this->cek_null_string($acc, 'account_id');
        $val = $this->db->get($this->tableName)->row_array();
        
        if ($type == 0){ return $val['amount']; }
    }
    
    // mendapatkan balance berdasarkan category account : 522
    function get_total_based_program_category_acc($category,$acategory,$dppa,$month,$year,$type=0)
    {
        $this->db->select_sum('procurement.amount');
        
        $this->db->from('procurement, account, account_category');
        $this->db->where('account.id = procurement.account_id');
        $this->db->where('account_category.id = procurement.category_id');
        
        $this->db->where('procurement.month', $month);
        $this->db->where('procurement.year', $year);
        $this->db->where('procurement.dppa_id', $dppa);
        $this->db->where('procurement.category_id', $acategory);
        $this->db->where('account.category', $category);
        $this->db->where('account_category.deleted', NULL);
        $val = $this->db->get()->row_array();
        
        if ($type == 0){ return $val['amount']; }
        
    }
    
    function get_account_based_category_belanja($acategory,$category,$dppa,$month,$year)
    {
        $this->db->select('account.id, account.code, account.name');
        $this->db->from('procurement, account, account_category');
        $this->db->where('account.id = procurement.account_id');
        $this->db->where('account_category.id = procurement.category_id');
        $this->db->where('procurement.month', $month);
        $this->db->where('procurement.year', $year);
        $this->db->where('procurement.dppa_id', $dppa);
        $this->db->where('procurement.top', 1);
        $this->db->where('procurement.category_id', $category);
        $this->db->where('account.category', $acategory);
        $this->db->where('account_category.deleted', NULL);
        $this->db->distinct();
        return $this->db->get();
    }
    
    function get_procurement_list($acategory,$category,$dppa,$month,$year)
    {
        $this->db->select('procurement.account_id, procurement.title, procurement.amount, procurement.budget, procurement.vendor, procurement.contact, procurement.contract_no, procurement.contract_date');
        $this->db->from('procurement, account, account_category');
        $this->db->where('account.id = procurement.account_id');
        $this->db->where('account_category.id = procurement.category_id');
        $this->db->where('procurement.month', $month);
        $this->db->where('procurement.year', $year);
        $this->db->where('procurement.dppa_id', $dppa);
        $this->db->where('procurement.category_id', $category);
        $this->db->where('account.category', $acategory);
        $this->db->where('account_category.deleted', NULL);
        return $this->db->get();
    }
    
    
    // mendapatkan balance berdasarkan category account : 522 rincian rekening


}

/* End of file Property.php */
