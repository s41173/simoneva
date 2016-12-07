<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_lib extends Main_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'transaction';
        $this->account = new Account_lib();
    }

    protected $account;
    protected $field = array('id', 'type', 'account_id', 'category_id', 'dppa_id', 'amount', 'month',
                             'opening', 'progress_amount', 'rest', 'year', 'created', 'updated', 'deleted');

    function combo()
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        $data['options'][0] = 'Top';
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }
    
    
    function combo_child_based_dppa($dppa)
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->where('parent_id >', 0);
        $this->db->where('dppa_id', $dppa);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->code.' : '.$row->name); }
        return $data;
    }

    function combo_all()
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->order_by('name', 'asc');
        $data['options'][''] = '-- All --';
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }
    
    function combo_dppa($id)
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->where('dppa_id', $id);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        if ($val){ foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); } }
        else { $data['options']['0'] = 'Top'; }
        return $data;
    }

    function combo_update($id)
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->order_by('name', 'asc');
        $this->db->where_not_in('id', $id);
        $val = $this->db->get($this->tableName)->result();
        $data['options'][0] = 'Top';
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }
    
    function combo_sp2d($dppa,$category,$year)
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->where('dppa_id', $dppa);
        $this->db->where('category_id', $category);
        $this->db->where('year', $year);
        $this->db->where('priority', 0);
        $val = $this->db->get($this->tableName)->result();
        $data['options'][''] = '--';
        if ($val){ foreach($val as $row){ $data['options'][$row->account_id] = $this->account->get_code($row->account_id).' : '.$this->account->get_name($row->account_id); } }
        return $data;
    }
    
    function get_realisasi($dppa,$cat,$acc,$year)
    {
        $this->db->select_sum('amount');
        $this->db->where('year', $year);
        $this->db->where('category_id', $cat);
        $this->db->where('account_id', $acc);
        $this->db->where('dppa_id', $dppa);
        $val = $this->db->get($this->tableName)->row_array();
        return $val['amount'];
    }

    function get_name($id=null)
    {
        if ($id)
        {
            $this->db->select($this->field);
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return ucfirst($val->name); }
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
        $this->db->select_sum('progress_amount');
        $this->db->where('year', $year);
        $this->db->where('dppa_id', $dppa);
        $val = $this->db->get($this->tableName)->row_array();
        if ($type == 0){ return $val['amount']; }else { return $val['progress_amount']; }
    }
    
    function get_interval_balance($dppa,$cat='null',$acc='null',$month,$year)
    {
        $months = generate_interval($month);
        if ($months)
        {
            $this->db->select_sum('amount');
            $this->db->select_sum('progress_amount');
            $this->db->where('year', $year);
            $this->db->where('dppa_id', $dppa);
            if ($months){ $this->db->where_in('month', $months); }
            $this->cek_null_string($cat, 'category_id');
            $this->cek_null_string($acc, 'account_id');
            $val = $this->db->get($this->tableName)->row();
            return $val->amount; 
        }
        else { return 0; }
    }
    
    // fungsi untuk mendapatkan summary periode bulan
    function get_total_monthly($dppa,$cat='null',$acc='null',$month,$year,$type=0)
    {        
        $this->db->select_sum('transaction.amount');
        $this->db->select_sum('transaction.progress_amount');
        $this->db->select_sum('transaction.opening');
        $this->db->select_sum('transaction.rest');
        
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $this->db->where('dppa_id', $dppa);
        $this->cek_null_string($cat, 'category_id');
        $this->cek_null_string($acc, 'account_id');
        $val = $this->db->get($this->tableName)->row_array();
        
        if ($type == 0){ return $val['amount']; }
        elseif ($type == 1) { return $val['progress_amount']; }
        elseif ($type == 2) { return $val['opening']; }
        elseif ($type == 3) { return $val['rest']; }
    }
    
    function get_total_monthly_based_belanja($dppa,$cat='null',$acc='null',$month,$year,$type=0,$belanja=1)
    {
        $this->db->select_sum('amount');
        $this->db->select_sum('progress_amount');
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $this->db->where('dppa_id', $dppa);
        $this->db->where('type', $belanja);
        $val = $this->db->get($this->tableName)->row_array();
        if ($type == 0){ return $val['amount']; }else { return $val['progress_amount']; }
    }
    
    // fungsi untuk mendaptkan total bulan sebelunya
    function get_previous_total($dppa,$cat='null',$acc='null',$month,$year)
    {
        $this->db->select_sum('opening');
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $this->db->where('dppa_id', $dppa);
        $val = $this->db->get($this->tableName)->row_array();
        return $val['opening'];
    }
    
    function get_previous_total_belanja($dppa,$cat='null',$acc='null',$month,$year,$belanja=1)
    {
        $this->db->select_sum('opening');
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $this->db->where('dppa_id', $dppa);
        $this->db->where('type', $belanja);
        $val = $this->db->get($this->tableName)->row_array();
        return $val['opening'];
    }
    
    // fungsi untuk mendaptkan total bulan sebelunya
    function get_rest_total($dppa,$cat='null',$acc='null',$month,$year)
    {
        $this->db->select_sum('rest');
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $this->db->where('dppa_id', $dppa);
        $val = $this->db->get($this->tableName)->row_array();
        return $val['rest'];
    }
    
    // get jenis transaksi berdasarkan jenis category parent ex:511
    function get_total_monthly_category_balance($dppa,$category,$month,$year,$type=0)
    {
        $this->db->select_sum('transaction.amount');
        $this->db->select_sum('transaction.progress_amount');
        $this->db->select_sum('transaction.opening');
        $this->db->select_sum('transaction.rest');
        $this->db->from('transaction, account');
        $this->db->where('account.id = transaction.account_id');
        $this->db->where('transaction.year', $year);
        $this->db->where('transaction.month', $month);
        $this->db->where('transaction.dppa_id', $dppa);
        $this->db->where('account.category', $category);
        $this->db->where('transaction.type', $this->account->top_category($category,1));
        
        $val = $this->db->get()->row_array();
        if ($type == 0){ return $val['amount']; }
        elseif ($type == 1) { return $val['progress_amount']; }
        elseif ($type == 2) { return $val['opening']; }
        elseif ($type == 3) { return $val['rest']; }
    }
    
    // get jenis transaksi berdasarkan jenis parent account id
    function get_total_monthly_parent_balance($dppa,$parent,$month,$year,$type=0)
    {
        $this->db->select_sum('transaction.amount');
        $this->db->select_sum('transaction.progress_amount');
        $this->db->select_sum('transaction.opening');
        $this->db->select_sum('transaction.rest');
        $this->db->from('transaction, account');
        $this->db->where('account.id = transaction.account_id');
        $this->db->where('transaction.year', $year);
        $this->db->where('transaction.month', $month);
        $this->db->where('transaction.dppa_id', $dppa);
        $this->db->where('account.parent_id', $parent);
        
        $val = $this->db->get()->row_array();
        if ($type == 0){ return $val['amount']; }
        elseif ($type == 1) { return $val['progress_amount']; }
        elseif ($type == 2) { return $val['opening']; }
        elseif ($type == 3) { return $val['rest']; }
    }
    
    // fungsi untuk mendapatkan summary berdasarkan program
    function get_total_monthly_based_program($dppa,$cat='null',$acc='null',$month,$year,$type=0)
    {        
        $this->db->select_sum('transaction.amount');
        $this->db->select_sum('transaction.progress_amount');
        $this->db->select_sum('transaction.opening');
        $this->db->select_sum('transaction.rest');
        
        $this->db->from('transaction, account, account_category');
        $this->db->where('account.id = transaction.account_id');
        $this->db->where('account_category.id = transaction.category_id');
        $this->db->where('account_category.parent_id', $cat);
        
        $this->db->where('transaction.year', $year);
        $this->db->where('transaction.month', $month);
        $this->db->where('transaction.dppa_id', $dppa);
        $this->cek_null_string($acc, 'account_id');
        $val = $this->db->get()->row_array();
        
        if ($type == 0){ return $val['amount']; }
        elseif ($type == 1) { return $val['progress_amount']; }
        elseif ($type == 2) { return $val['opening']; }
        elseif ($type == 3) { return $val['rest']; }
    }
    
    // fungsi untuk mendapatkan summary berdasarkan kegiatan
    function get_total_monthly_based_kegiatan($dppa,$cat='null',$acc='null',$month,$year,$type=0)
    {        
        $this->db->select_sum('transaction.amount');
        $this->db->select_sum('transaction.progress_amount');
        $this->db->select_sum('transaction.opening');
        $this->db->select_sum('transaction.rest');
        
        $this->db->from('transaction, account, account_category');
        $this->db->where('account.id = transaction.account_id');
        $this->db->where('account_category.id = transaction.category_id');
        $this->db->where('account_category.id', $cat);
        
        $this->db->where('transaction.year', $year);
        $this->db->where('transaction.month', $month);
        $this->db->where('transaction.dppa_id', $dppa);
        $this->cek_null_string($acc, 'account_id');
        $val = $this->db->get()->row_array();
        
        if ($type == 0){ return $val['amount']; }
        elseif ($type == 1) { return $val['progress_amount']; }
        elseif ($type == 2) { return $val['opening']; }
        elseif ($type == 3) { return $val['rest']; }
    }
    
    // mendapatkan balance berdasarkan category account : 522
    function get_total_based_program_category_acc($category,$acategory,$dppa,$month,$year,$type=0)
    {
        $this->db->select_sum('transaction.amount');
        $this->db->select_sum('transaction.progress_amount');
        $this->db->select_sum('transaction.opening');
        $this->db->select_sum('transaction.rest');
        
        $this->db->from('transaction, account, account_category');
        $this->db->where('account.id = transaction.account_id');
        $this->db->where('account_category.id = transaction.category_id');
        
        $this->db->where('transaction.month', $month);
        $this->db->where('transaction.year', $year);
        $this->db->where('transaction.dppa_id', $dppa);
        $this->db->where('transaction.category_id', $acategory);
        $this->db->where('account.category', $category);
        $val = $this->db->get()->row_array();
        
        if ($type == 0){ return $val['amount']; }
        elseif ($type == 1) { return $val['progress_amount']; }
        elseif ($type == 2) { return $val['opening']; }
        elseif ($type == 3) { return $val['rest']; }
        
    }
    
    // mendapatkan balance berdasarkan top rekening kegiatan
    function get_total_based_program_top_acc($category,$acategory,$parentacc,$dppa,$month,$year,$type=0)
    {
        $this->db->select_sum('transaction.amount');
        $this->db->select_sum('transaction.progress_amount');
        $this->db->select_sum('transaction.opening');
        $this->db->select_sum('transaction.rest');
        
        $this->db->from('transaction, account, account_category');
        $this->db->where('account.id = transaction.account_id');
        $this->db->where('account_category.id = transaction.category_id');
        
        $this->db->where('transaction.month', $month);
        $this->db->where('transaction.year', $year);
        $this->db->where('transaction.dppa_id', $dppa);
        $this->db->where('transaction.category_id', $acategory);
        $this->db->where('account.category', $category); // 522
        $this->db->where('account.parent_id', $parentacc); 
        $val = $this->db->get()->row_array();
        
        if ($type == 0){ return $val['amount']; }
        elseif ($type == 1) { return $val['progress_amount']; }
        elseif ($type == 2) { return $val['opening']; }
        elseif ($type == 3) { return $val['rest']; }
        
    }
    
    // mendapatkan balance berdasarkan category account : 522 rincian rekening


}

/* End of file Property.php */
