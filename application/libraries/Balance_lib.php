<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Balance_lib extends Main_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'balance';
        $this->account = new Account_lib();
        $this->transaction = new Transaction_lib();
    }

    protected $account,$transaction;
    protected $field = array('id', 'type', 'account_id', 'category_id', 'dppa_id', 'priority', 'source', 'amount', 'year', 'created', 'updated', 'deleted');

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
    
    function combo_child()
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->where('parent_id >', 0);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->code.' : '.$row->name); }
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
    
    function get_budet($dppa,$cat='null',$acc,$year)
    {
        $this->db->select_sum('amount');
        $this->db->where('year', $year);
        $this->db->where('account_id', $acc);
        $this->db->where('dppa_id', $dppa);
        $this->cek_null_string($cat, 'category_id');
        $val = $this->db->get($this->tableName)->row_array();
        return $val['amount'];
    }
    
    function get_belanja($dppa,$year,$type=1)
    {
        $this->db->select_sum('amount');
        $this->db->where('year', $year);
        $this->db->where('type', $type);
        $this->db->where('dppa_id', $dppa);
        $this->db->where('priority', 0);
        $val = $this->db->get($this->tableName)->row_array();
        return $val['amount'];
    }
    
    function get_priority($dppa,$year,$type=0)
    {
        $this->db->select('source, amount');
        $this->db->where('year', $year);
        $this->db->where('dppa_id', $dppa);
        $this->db->where('priority', 1);
        $val = $this->db->get($this->tableName)->row();
        if ($val){
          if ($type == 0){ return $val->source; }
          elseif ($type == 1){ return $val->amount; }
        }else { return 0; }
    }
    
    function get_total_priority($dppa='null',$year)
    {
        $this->db->select_sum('amount');
        $this->db->where('year', $year);
        $this->db->where('priority', 1);
        $this->db->where('deleted', NULL);
        $this->cek_null_string($dppa, 'dppa_id');
        $val = $this->db->get($this->tableName)->row_array();
        return $val['amount'];
    }
    
    // get jenis balance belanja langsung / tidak langsung
    function get_child_balance($dppa,$year,$type=1)
    {
        $this->db->select('amount');
        $this->db->where('year', $year);
        $this->db->where('dppa_id', $dppa);
        $this->db->where('priority', 0);
        $this->db->where('type', $type);
        $val = $this->db->get($this->tableName)->row();
        if ($val){ return $val->amount;  }else { return 0; }
        
    }
    
    // get jenis balance berdasarkan jenis category parent ex:511
    function get_account_category_balance($dppa,$year,$category)
    {
        $this->db->select_sum('balance.amount');
        $this->db->from('balance, account');
        $this->db->where('account.id = balance.account_id');
        $this->db->where('balance.year', $year);
        $this->db->where('balance.dppa_id', $dppa);
        $this->db->where('balance.priority', 0);
        $this->db->where('balance.type', $this->account->top_category($category,1));
        $this->db->where('account.category', $category);
        $val = $this->db->get()->row_array();
        return $val['amount']; 
    }
    
    // get jenis balance berdasarkan jenis category parent ex:511
    function get_account_parent_balance($dppa,$year,$parent)
    {
        $this->db->select_sum('balance.amount');
        $this->db->from('balance, account');
        $this->db->where('account.id = balance.account_id');
        $this->db->where('balance.year', $year);
        $this->db->where('balance.dppa_id', $dppa);
        $this->db->where('balance.priority', 0);
        $this->db->where('account.parent_id', $parent);
        $val = $this->db->get()->row_array();
        return $val['amount']; 
    }
    
    function get_balance($dppa,$cat='null',$acc='null',$month,$year)
    {
        $res1 = $this->get_priority($dppa, $year,1);
        $res2 = $this->transaction->get_interval_balance($dppa, $cat, $acc, $month, $year);
//        return $res1-$res2;
        return $res1;
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
    
    // tarik data balance berdasarkan program kegiatan
    function get_balance_based_top_program($dppa,$year,$parent)
    {
        $this->db->select_sum('balance.amount');
        $this->db->from('balance, account, account_category');
        $this->db->where('account.id = balance.account_id');
        $this->db->where('account_category.id = balance.category_id');
        $this->db->where('balance.year', $year);
        $this->db->where('balance.dppa_id', $dppa);
        $this->db->where('balance.priority', 0);
        $this->db->where('account_category.parent_id', $parent);
        $this->db->where('account_category.deleted', NULL);
        $val = $this->db->get()->row_array();
        return $val['amount']; 
    }
    
    function get_balance_based_child_program($dppa,$year,$acategory)
    {
        $this->db->select_sum('balance.amount');
        $this->db->from('balance, account, account_category');
        $this->db->where('account.id = balance.account_id');
        $this->db->where('account_category.id = balance.category_id');
        $this->db->where('balance.year', $year);
        $this->db->where('balance.dppa_id', $dppa);
        $this->db->where('balance.priority', 0);
        $this->db->where('account_category.id', $acategory);
        $this->db->where('account_category.deleted', NULL);
        $val = $this->db->get()->row_array();
        return $val['amount']; 
    }
    
    function get_category_account_based_acategory($acategory_id,$dppa,$year)
    {
        $this->db->select('account.category');
        $this->db->from('balance, account, account_category');
        $this->db->where('account.id = balance.account_id');
        $this->db->where('account_category.id = balance.category_id');
        $this->db->where('balance.category_id', $acategory_id);
        $this->db->where('balance.dppa_id', $dppa);
        $this->db->where('balance.year', $year);
        $this->db->where('account_category.deleted', NULL);
        $this->db->distinct();
        return $this->db->get();
    }
    
    // mendapatkan balance berdasarkan category account : 522
    function get_balance_based_program_category_account($category,$acategory,$dppa,$year)
    {
        $this->db->select_sum('balance.amount');
        $this->db->from('balance, account, account_category');
        $this->db->where('account.id = balance.account_id');
        $this->db->where('account_category.id = balance.category_id');
        $this->db->where('balance.year', $year);
        $this->db->where('balance.dppa_id', $dppa);
        $this->db->where('balance.priority', 0);
        $this->db->where('balance.category_id', $acategory);
        $this->db->where('account.category', $category);
        $this->db->where('account_category.deleted', NULL);
        $val = $this->db->get()->row_array();
        return $val['amount']; 
    }
    
    // mendapatkan balance berdasarkan category account : 522 rincian rekening
    function get_balance_based_parent_acc($acategory,$parent,$dppa,$year)
    {
        $this->db->select_sum('amount');
        $this->db->from('balance,account');
        $this->db->where('account.id = balance.account_id');
        $this->db->where('balance.year', $year);
        $this->db->where('balance.dppa_id', $dppa);
        $this->db->where('balance.priority', 0);
        $this->db->where('balance.category_id', $acategory);
        $this->db->where('account.parent_id', $parent);
        $val = $this->db->get()->row_array();
        return $val['amount']; 
    }
    
    // mendapatkan balance berdasarkan category account : 522 rincian rekening
    function get_balance_based_program_account($acategory,$acc,$dppa,$year)
    {
        $this->db->select('amount');
        $this->db->from('balance');
        $this->db->where('balance.year', $year);
        $this->db->where('balance.dppa_id', $dppa);
        $this->db->where('balance.priority', 0);
        $this->db->where('balance.category_id', $acategory);
        $this->db->where('balance.account_id', $acc);
        $val = $this->db->get()->row_array();
        return $val['amount']; 
    }

    function type($val)
    {
	switch ($val) {
            case "1":return 'BIAYA TIDAK LANGSUNG'; break;
            case "2":return 'BIAYA LANGSUNG'; break;
            case "3":return 'PEMBIAYAAN DAERAH';
        }
    }

}

/* End of file Property.php */
