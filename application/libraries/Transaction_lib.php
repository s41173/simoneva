<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_lib extends Main_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'transaction';
        $this->account = new Account_lib();
    }

    protected $account;
    protected $field = array('id', 'type', 'account_id', 'category_id', 'dppa_id', 'amount',    'month', 'year', 'created', 'updated', 'deleted');

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
    
    function get_realisasi($cat,$acc,$year)
    {
        $this->db->select_sum('amount');
        $this->db->where('year', $year);
        $this->db->where('category_id', $cat);
        $this->db->where('account_id', $acc);
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

}

/* End of file Property.php */
