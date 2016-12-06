<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_lib extends Main_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'account';
    }
    
    protected $field = array('id', 'parent_id', 'category', 'code', 'name', 'description', 'publish', 'created', 'updated', 'deleted');

    function combo($vals=null)
    {
        $data = null;
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->where('publish',1);
        $this->db->where('parent_id',0);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        if ($vals=null){ $data['options'][0] = 'Top'; }
        if ($val){ foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); } }
        else { $data['options'][''] = ' -- '; }
        
        return $data;
    }
    
    function combo_child()
    {
        $data = null;
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->where('publish',1);
        $this->db->where('parent_id >',0);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        if ($val){ foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->code.' : '.$row->name); } }
        else { $data['options']['null'] = ' -- Select --'; }
        return $data;
    }

    function combo_all()
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->where('publish',1);
        $this->db->order_by('name', 'asc');
        $data['options'][''] = '-- All --';
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }

    function combo_update($id)
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->where('publish',1);
        $this->db->where('parent_id',0);
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
            $this->db->select('name');
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return ucfirst($val->name); }
        }
        return '';
    }
    
    function get_category($id=null)
    {
        if ($id)
        {
            $this->db->select($this->field);
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return $val->category; }
        }
        else if($id == 0){ return 'Top'; }
        else { return ''; }
    }
    
    function get_code($id=null,$type=0)
    {
        if ($id)
        {
            $this->db->select($this->field);
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){
                $arr = str_split($val->code,3);
                if ($type==0){ return $arr[0].'-'.$arr[1].@$arr[2]; }
                elseif ($type==1){ return $arr[0]; }
                elseif ($type==2){ return $arr[1].$arr[2]; }
            }
        }
        else if($id == 0){ return 'Top'; }
        else { return ''; }
    }
    
    function top_category($val,$type=0)
    {
        switch ($val) {
        case 511:$res = '1|Belanja Tidak Langsung';break;
        case 512:$res = '1|Belanja Tidak Langsung';break;
        case 513:$res = '1|Belanja Tidak Langsung';break;
        case 514:$res = '1|Belanja Tidak Langsung';break;
        case 515:$res = '1|Belanja Tidak Langsung';break;
        case 516:$res = '1|Belanja Tidak Langsung';break;
        case 517:$res = '1|Belanja Tidak Langsung';break;
        case 518:$res = '1|Belanja Tidak Langsung';break;
        case 521:$res = '2|Belanja Langsung';break;
        case 522:$res = '2|Belanja Langsung';break;
        case 523:$res = '2|Belanja Langsung';break;
       }
       
       $val = explode('|', $res);
       if ($type == 0){ return $res; } elseif ($type==1){ return $val[0]; } elseif ($type==2){ return $val[1]; }
    }
    
    function get_belanja_type($val)
    {
       switch ($val) {
        case 511:$res = strtoupper('Belanja Pegawai');break;
        case 512:$res = strtoupper('Belanja Bunga');break;
        case 513:$res = strtoupper('Belanja Subsidi');break;
        case 514:$res = strtoupper('Belanja Hibah');break;
        case 515:$res = strtoupper('Belanja Bantuan Sosial');break;
        case 516:$res = strtoupper('BELANJA BAGI HASIL KEPADA PROVINSI/KABUPATEN/KOTA DAN PEMERINTAHAN DESA');break;
        case 517:$res = strtoupper('BELANJA BANTUAN KEUANGAN KEPADA PROVINSI/KABUPATEN/KOTA , PEMERINTAHAN DESA DAN PARTAI POLITIK');break;
        case 518:$res = strtoupper('Belanja Tidak Terduga');break;
        case 521:$res = strtoupper('Belanja Pegawai');break;
        case 522:$res = strtoupper('Belanja Barang Dan Jasa');break;
        case 523:$res = strtoupper('Belanja Modal');break;
       } 
       return $res;
    }
    
    function get_type($id)
    {
        if ($id)
        {
            $this->db->select($this->field);
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){
                return $this->top_category($val->category, 1);
            }
        }
        else { return '0'; } 
    }
    
    function combo_belanja($type=0)
    {   
        $data = null;
        if ($type == 0)
        {
           $data['options'][511] = strtoupper('Belanja Pegawai');
           $data['options'][512] = strtoupper('Belanja Bunga');
           $data['options'][513] = strtoupper('Belanja Subsidi');
           $data['options'][514] = strtoupper('Belanja Hibah');
           $data['options'][515] = strtoupper('Belanja Bantuan Sosial');
           $data['options'][516] = strtoupper('BELANJA BAGI HASIL KEPADA PROVINSI/KABUPATEN/KOTA DAN PEMERINTAHAN DESA');
           $data['options'][517] = strtoupper('BELANJA BANTUAN KEUANGAN KEPADA PROVINSI/KABUPATEN/KOTA , PEMERINTAHAN DESA DAN PARTAI POLITIK');
           $data['options'][518] = strtoupper('Belanja Tidak Terduga');
           $data['options'][521] = strtoupper('Belanja Pegawai');
           $data['options'][522] = strtoupper('Belanja Barang Dan Jasa');
           $data['options'][523] = strtoupper('Belanja Modal');
        }
        elseif ($type == 1)
        {
           $data['options'][511] = strtoupper('Belanja Pegawai');
           $data['options'][512] = strtoupper('Belanja Bunga');
           $data['options'][513] = strtoupper('Belanja Subsidi');
           $data['options'][514] = strtoupper('Belanja Hibah');
           $data['options'][515] = strtoupper('Belanja Bantuan Sosial');
           $data['options'][516] = strtoupper('BELANJA BAGI HASIL KEPADA PROVINSI/KABUPATEN/KOTA DAN PEMERINTAHAN DESA');
           $data['options'][517] = strtoupper('BELANJA BANTUAN KEUANGAN KEPADA PROVINSI/KABUPATEN/KOTA , PEMERINTAHAN DESA DAN PARTAI POLITIK');
           $data['options'][518] = strtoupper('Belanja Tidak Terduga');
        }
        elseif ($type == 2)
        {
           $data['options'][521] = strtoupper('Belanja Pegawai');
           $data['options'][522] = strtoupper('Belanja Barang Dan Jasa');
           $data['options'][523] = strtoupper('Belanja Modal');
        }
        return $data;
    }
    
    // balance integrasi account
    function get_account_category($dppa,$year,$belanja=1)
    {
        $this->db->select('account.category');
        $this->db->from('balance, account');
        $this->db->where('account.id = balance.account_id');
        $this->db->where('account.publish', 1);
        $this->db->where('balance.priority', 0);
        $this->db->where('balance.type', $belanja);
        $this->db->where('balance.year', $year);
        $this->db->where('balance.dppa_id', $dppa);
        $this->db->order_by('account.category', 'asc');
        $this->db->distinct();
        
        return $this->db->get(); 
    }
    
    // balance integrasi account parent ex:5110101
    function get_account_parent($category)
    {
        $this->db->select('account.code,account.id,account.name');
        $this->db->from('account');
        $this->db->where('account.publish', 1);
        $this->db->where('account.parent_id', 0);
        $this->db->where('account.category', $category);
        $this->db->order_by('account.code', 'asc');
        $this->db->distinct();
        
        return $this->db->get(); 
    }
    
    // get account based parent
    function get_account_based_parent($parent)
    {
        $this->db->select('account.code,account.id,account.name');
        $this->db->from('account');
        $this->db->where('account.publish', 1);
        $this->db->where('account.parent_id', $parent);
        $this->db->order_by('account.code', 'asc');
        $this->db->distinct();
        
        return $this->db->get(); 
    }

}

/* End of file Property.php */
