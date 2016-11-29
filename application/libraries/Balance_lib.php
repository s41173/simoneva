<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Balance_lib extends Main_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'balance';
    }

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

    function type($val)
    {
	switch ($val) {
            case "1":return 'BIAYA LANGSUNG'; break;
            case "2":return 'BIAYA TIDAK LANGSUNG'; break;
            case "3":return 'PEMBIAYAAN DAERAH';
        }
    }

}

/* End of file Property.php */
