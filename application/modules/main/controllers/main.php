<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('property');
        $this->load->library('user_agent');
        $this->properti = $this->property->get();

        $this->acl->otentikasi();
        $this->period = new Period_lib();
        $this->balance = new Balance_lib();
        $this->dppa = new Dppa_lib();
        $this->transaction = new Transaction_lib();
        $this->procurement = new Procurement_lib();
    }

    var $title = 'main';
    var $limit = null;
    private $properti;
    private $period;
    private $balance, $dppa, $transaction, $procurement;

    function index()
    {       
	$this->main_panel();   
    }

    private function user_agent()
    {
        $agent=null;
        if ($this->agent->is_browser()){  $agent = $this->agent->browser().' '.$this->agent->version();}
        elseif ($this->agent->is_robot()){ $agent = $this->agent->robot(); }
        elseif ($this->agent->is_mobile()){ $agent = $this->agent->mobile(); }
        else{ $agent = 'Unidentified User Agent'; }
        return $agent." - ".$this->agent->platform();
    }
    
    function main_panel()
    {
       $data['name'] = $this->properti['name'];
       $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Main Panel');
       $data['h2title'] = "Main Panel";

       $data['waktu'] = tgleng(date('Y-m-d')).' - '.waktuindo().' WIB';
       $data['user_agent'] = $this->user_agent();
       $data['main_view'] = 'main/main_view';
       $data['month'] = $this->period->get('month');
       $data['year'] = $this->period->get('year');
       $data['combo_dppa'] = $this->dppa->combo_child();
       $data['combo_month'] = combo_month();
       
       if ($this->session->userdata('dppa')){ $data['dppa'] = '  :  '.ucfirst($this->dppa->get_name($this->session->userdata('dppa')));}
       else { $data['dppa'] = ''; }
       
       $data['graph'] = site_url()."/main/chart/".$this->input->post('cdppa').'/'.$this->input->post('cmonth').'/'.$this->input->post('tyear');
       $data['graph2'] = site_url()."/main/chart_trans/".$this->input->post('cdppa2').'/'.$this->input->post('tyear2');
       
       
       $this->load->view('template', $data);
    }
    
    function chart($dppa='null',$month=null,$year=null)
    {
        
        if ($dppa == 'null'){ $dppa = $this->session->userdata('dppa'); }
        if ($month == null){ $month = $this->period->get('month'); }
        if ($year == null){ $year = $this->period->get('year'); }
        
        $pagu = $this->balance->get_total_priority($dppa,$this->period->get('year'));
        $trans = $this->transaction->get_total_monthly($dppa, 'null', 'null', $month, $year, 1);
        $sp2d = $this->transaction->get_total_monthly($dppa, 'null', 'null', $month, $year, 0);
        $rest = $this->transaction->get_total_monthly($dppa, 'null', 'null', $month, $year, 3);
        
        $data = array(
                    array("label" => "Sisa Pagu", "y" => $pagu-$sp2d+$rest),
                    array("label" => "Sisa Progress", "y" => $rest),
                    array("label" => "Progress", "y" => $trans),
                    array("label" => "SP2D", "y" => $sp2d),
                    array("label" => "Pagu", "y" => $pagu)
                ); 

       echo json_encode($data, JSON_NUMERIC_CHECK);
    }
    
    function chart_trans($dppa='null',$year=null)
    {
        
        if ($dppa == 'null'){ $dppa = $this->session->userdata('dppa'); }
        if ($year == null){ $year = $this->period->get('year'); }
        
        $trans1 = $this->transaction->get_total_monthly($dppa, 'null', 'null', 1, $year, 1);
        $trans2 = $this->transaction->get_total_monthly($dppa, 'null', 'null', 2, $year, 1);
        $trans3 = $this->transaction->get_total_monthly($dppa, 'null', 'null', 3, $year, 1);
        $trans4 = $this->transaction->get_total_monthly($dppa, 'null', 'null', 4, $year, 1);
        $trans5 = $this->transaction->get_total_monthly($dppa, 'null', 'null', 5, $year, 1);
        $trans6 = $this->transaction->get_total_monthly($dppa, 'null', 'null', 6, $year, 1);
        $trans7 = $this->transaction->get_total_monthly($dppa, 'null', 'null', 7, $year, 1);
        $trans8 = $this->transaction->get_total_monthly($dppa, 'null', 'null', 8, $year, 1);
        $trans9 = $this->transaction->get_total_monthly($dppa, 'null', 'null', 9, $year, 1);
        $trans10 = $this->transaction->get_total_monthly($dppa, 'null', 'null', 10, $year, 1);
        $trans11 = $this->transaction->get_total_monthly($dppa, 'null', 'null', 11, $year, 1);
        $trans12 = $this->transaction->get_total_monthly($dppa, 'null', 'null', 12, $year, 1);
        
        
        $data = array(
                    array("label" => "Jan", "y" => $trans1),
                    array("label" => "Feb", "y" => $trans2),
                    array("label" => "Mar", "y" => $trans3),
                    array("label" => "Apr", "y" => $trans4),
                    array("label" => "Mei", "y" => $trans5),
                    array("label" => "Jun", "y" => $trans6),
                    array("label" => "Jul", "y" => $trans7),
                    array("label" => "Aug", "y" => $trans8),
                    array("label" => "Sep", "y" => $trans9),
                    array("label" => "Oct", "y" => $trans10),
                    array("label" => "Nov", "y" => $trans11),
                    array("label" => "Dec", "y" => $trans12)
                ); 

       echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    function article()
    {
       otentikasi1($this->title);
       $property = $this->Property_model->get_last_propery()->row();
       $data['name'] = $property->name;
       $data['title'] = propertyname('Article');
       $data['h2title'] = "Article Panel";

       $data['waktu'] = tgleng(date('Y-m-d')).' - '.waktuindo().' WIB';
       $data['main_view'] = 'main/article';
       $this->load->view('template', $data);
    }
    
}

?>