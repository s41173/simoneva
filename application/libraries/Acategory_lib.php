<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acategory_lib extends Main_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'account_category';
    }
    
    protected $field = array('id', 'parent_id', 'type', 'code', 'name', 'dppa_id', 'description', 'orders', 'created', 'updated', 'deleted');

    function combo()
    {
        $this->db->select('id, code, name');
        $this->db->where('deleted', NULL);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        $data['options'][0] = 'Top';
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }
    
    function combo_child()
    {
        $data = null;
        $this->db->select('id, code, name');
        $this->db->where('deleted', NULL);
        $this->db->where('parent_id >', 0);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        if ($val){ foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->code.' : '.$row->name); } }
        else { $data['options'][''] = '-- Select Category --'; }
        return $data;
    }
    
    function combo_child_based_dppa($dppa,$type=null)
    {
        $this->db->select('id, code, name');
        $this->db->where('deleted', NULL);
        $this->db->where('parent_id >', 0);
        $this->db->where('dppa_id', $dppa);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        if ($type){ $data['options'][''] = '-- Select Category --'; }
        if ($val)
        {
           foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->code.' : '.$row->name); }
           return $data;
        }
        else { $data['options'][''] = '-- Select Category --'; return $data; }
    }
    
    function combo_child_procurement()
    {
        $data=null;
        $this->db->select('account_category.id, account_category.code, account_category.name');
        $this->db->from('balance, account, account_category');
        $this->db->where('account.id = balance.account_id');
        $this->db->where('account_category.id = balance.category_id');
        $this->db->where('account_category.deleted', NULL);
        $this->db->where('account_category.parent_id >', 0);
        
        $value = array('522', '523');
        $this->db->where_in('account.category', $value);
        $this->db->order_by('account_category.name', 'asc');
        $val = $this->db->get()->result();
        
        if ($val){ foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->code.' : '.$row->name); } }
        else { $data['options'][''] = '-- Select Category --'; }
        return $data;
    }
    
    function combo_child_procurement_dppa($dppa)
    {
        $data=null;
        $this->db->select('account_category.id, account_category.code, account_category.name');
        $this->db->from('balance, account, account_category');
        $this->db->where('account.id = balance.account_id');
        $this->db->where('account_category.id = balance.category_id');
        $this->db->where('account_category.deleted', NULL);
        $this->db->where('account_category.parent_id >', 0);
        $this->db->where('account_category.dppa_id', $dppa);
        
        $value = array('522', '523');
        $this->db->where_in('account.category', $value);
        $this->db->order_by('account_category.name', 'asc');
        $val = $this->db->get()->result();
        
        if ($val){ foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->code.' : '.$row->name); } }
        else { $data['options'][''] = '-- Select Category --'; }
        return $data;
    }
    
    function list_procurement_dppa($dppa,$type=null)
    {
        $this->db->select('account_category.id, account_category.code, account_category.name');
        $this->db->from('balance, account, account_category');
        $this->db->where('account.id = balance.account_id');
        $this->db->where('account_category.id = balance.category_id');
        $this->db->where('account_category.deleted', NULL);
        $this->db->where('account_category.parent_id >', 0);
        $this->db->where('account_category.dppa_id', $dppa);
        
        $value = array('522', '523');
        $this->db->where_in('account.category', $value);
        $this->db->order_by('account_category.name', 'asc');
        return $this->db->get();
    }

    function combo_all()
    {
        $this->db->select('id, code, name');
        $this->db->where('deleted', NULL);
        $this->db->order_by('name', 'asc');
        $data['options'][''] = '-- All --';
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }
    
    function combo_dppa($id)
    {
        $this->db->select('id, code, name');
        $this->db->where('deleted', NULL);
        $this->db->where('dppa_id', $id);
        $this->db->where('parent_id', 0);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        if ($val){ foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); } }
        else { $data['options']['0'] = 'Top'; }
        return $data;
    }

    function combo_update($id)
    {
        $this->db->select('id, code, name');
        $this->db->where('deleted', NULL);
        $this->db->order_by('name', 'asc');
//        $this->db->where_not_in('id', $id);
        $this->db->where('dppa_id', $id);
        $val = $this->db->get($this->tableName)->result();
        $data['options'][0] = 'Top';
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }

    function get_name($id=null)
    {
        if ($id)
        {
            $this->db->select('id, code, name');
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
            $this->db->select('id, code, name, type');
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return $val->type; }
        }
        else { return ''; }
    }
    
    function get_top_category($dppa,$type=2)
    {
       $this->db->select($this->field);
       $this->db->where('deleted', NULL);
       $this->db->where('parent_id', 0);
       $this->db->where('type', $type);
       $this->db->where('dppa_id', $dppa);
       $this->db->order_by('orders', 'asc');
       return $this->db->get($this->tableName);
    }
    
    function get_child_category($dppa,$parent)
    {
       $this->db->select($this->field);
       $this->db->where('deleted', NULL);
       $this->db->where('parent_id', $parent);
       $this->db->where('dppa_id', $dppa);
       $this->db->order_by('orders', 'asc');
       return $this->db->get($this->tableName);
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
