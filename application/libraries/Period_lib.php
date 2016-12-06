<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Period_lib extends Main_Model {

    protected $logs;
    
    public function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->tableName = 'period';
        $this->com = new Components();
        $this->com = $this->com->get_id('period');
    }
    protected $com;

    public function get($type=null)
    {
       $this->db->select('month, year');
       $val = $this->db->get($this->tableName)->row();
       if ($type == 'month'){ return $val->month; }
       elseif ($type == 'year') { return $val->year; }
       else { return $val; }
    }
}

/* End of file Property.php */
