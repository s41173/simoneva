<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Procurement extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Procurement_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->dppa = new Dppa_lib();
        $this->account = new Account_lib();
        $this->category = new Acategory_lib();
        $this->balance = new Balance_lib();
        $this->procurement = new Procurement_lib();
        $this->transaction = new Transaction_lib();
        $this->period = new Period_lib();
    }

    private $properti, $modul, $title, $procurement, $transaction, $dppa, $account, $category, $balance, $period;

    function index()
    {
       $this->get_last(); 
    }
    
    public function getdatatable($search=null,$dppa='null',$cat='null',$month='null',$year='null')
    {
        if(!$search){ $result = $this->Procurement_model->get_last($this->modul['limit'])->result(); }
        else { $result = $this->Procurement_model->search($dppa,$cat,$month,$year)->result(); }
        
        if ($result){
	foreach($result as $res)
	{
            $output[] = array ($res->id, $this->category->type($res->type), 
                       $this->account->get_code($res->account_id).' : '.$this->account->get_name($res->account_id),
                       $this->category->get_name($res->category_id), 
                       strtoupper($this->dppa->get_name($res->dppa_id)),
                       idr_format($res->amount), $res->month, $res->year, $res->vendor,
                       $res->created, $res->updated, $res->deleted);
	}
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($output, 128))
            ->_display();
            exit; 
        }
    }
    
    public function getdatatable_dppa($dppa)
    {
        $result = $this->Procurement_model->get_last_dppa($dppa)->result(); 
        
        if ($result){
	foreach($result as $res)
	{   
	   $output[] = array ($res->id, $this->category->type($res->type), 
                              $this->account->get_code($res->account_id).' : '.$this->account->get_name($res->account_id),
                              $this->category->get_name($res->category_id), 
                              strtoupper($this->dppa->get_name($res->dppa_id)),
                              idr_format($res->amount), $res->month, $res->year, $res->vendor,
                              $res->created, $res->updated, $res->deleted);
	}
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($output, 128))
            ->_display();
            exit; 
        }
    }
    
    function get_dppa($dppa=null)
    {
        $this->acl->otentikasi1($this->title);
        if ($this->dppa->cek_dppa($dppa) == FALSE){$this->session->set_flashdata('message', "Invalid DPPA..!"); redirect('dppa'); }

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'].' : '.ucfirst($this->dppa->get_name($dppa));
        $data['main_view'] = 'procurement_dppa_view';
	$data['form_action'] = site_url($this->title.'/add_process/'.$dppa);
        $data['form_action_update'] = site_url($this->title.'/update_process/'.$dppa);
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        
        $data['link'] = array('link_back' => anchor('dppa/','Back', array('class' => 'btn btn-danger')));
        $this->session->set_userdata('dppa',$dppa);
	// ---------------------------------------- //
        
        $data['account'] = $this->account->combo_child();
        $data['category'] = $this->category->combo_child_procurement_dppa($this->session->userdata('dppa'),'null');
        $data['month'] = combo_month();
        $data['default']['month'] = $this->period->get('month');
        $data['dppa'] = $this->dppa->combo_child();
 
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'SKPD', 'Program', 'Rekening', 'Nilai', 'Vendor', 'Periode', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('procurement/getdatatable_dppa/'.$dppa);
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'procurement_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));
	// ---------------------------------------- //
        
        $data['account'] = $this->account->combo_child();
        $data['category'] = $this->category->combo_child_procurement();
        $data['month'] = combo_month();
        $data['dppa'] = $this->dppa->combo_child();
 
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('No', 'SKPD', 'Program', 'Rekening', 'Nilai', 'Vendor', 'Periode');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('procurement/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Procurement_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Procurement_model->update($uid,$lng);
       echo 'true|Status Changed...!';
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    function delete_all()
    {
      if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
      
      $cek = $this->input->post('cek');
      $jumlah = count($cek);

      if($cek)
      {
        $jumlah = count($cek);
        $x = 0;
        for ($i=0; $i<$jumlah; $i++)
        {
           if ( $this->cek_relation($cek[$i]) == TRUE ) 
           {
              $this->Procurement_model->force_delete($cek[$i]); 
           }
           else { $x=$x+1; }
           
        }
        $res = intval($jumlah-$x);
        //$this->session->set_flashdata('message', "$res $this->title successfully removed &nbsp; - &nbsp; $x related to another component..!!");
        $mess = "$res $this->title successfully removed &nbsp; - &nbsp; $x related to another component..!!";
        echo 'true|'.$mess;
      }
      else
      { //$this->session->set_flashdata('message', "No $this->title Selected..!!"); 
        $mess = "No $this->title Selected..!!";
        echo 'false|'.$mess;
      }
      }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

    function delete($uid,$type='hard')
    {
        $procurement = $this->Procurement_model->get_by_id($uid)->row();
        
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE && $this->valid_period($procurement->month, $procurement->year) == TRUE){
        if ($type == 'soft'){
           $this->Procurement_model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully removed..!";
       }
       else
       {
        if ( $this->cek_relation($uid) == TRUE )
        {
           $this->Procurement_model->force_delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully removed..!";
        }
        else { $this->session->set_flashdata('message', "$this->title related to another component..!"); 
        echo  "invalid|$this->title related to another component..!";} 
       }
       }else { 
           echo "error|Sorry, you do not have the right to edit $this->title component..!"; 
       }
    }

    private function cek_relation($id){ return TRUE; }
    
    function add_process($dppa=null)
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('procurement/','<span>back</span>', array('class' => 'back')));

	// Form validation 
        
        $this->form_validation->set_rules('ccategory', 'Program Anggaran', 'required|callback_valid_procurement'); 
        $this->form_validation->set_rules('caccount', 'Rekening Anggaran', 'required'); 
        $this->form_validation->set_rules('tnilai', 'Nilai Anggaran', 'required|numeric|callback_valid_amount_procurement['.$this->input->post('tprogress').']'); 
        $this->form_validation->set_rules('cmonth', 'Bulan Anggaran', 'required|numeric|callback_valid_period['.$this->input->post('tyear').']'); 
        $this->form_validation->set_rules('tyear', 'Tahun Anggaran', 'required|numeric'); 
        $this->form_validation->set_rules('tprogress', 'Progress Keuangan', 'required|numeric'); 
        $this->form_validation->set_rules('ttitle', 'Nama Kegiatan', 'required'); 
        $this->form_validation->set_rules('tbudget', 'Budget SPK', 'required|numeric|callback_valid_budget_procurement['.$this->input->post('tamount').']'); 

        if ($this->form_validation->run($this) == TRUE)
        {
            $top = 0;
            if ( $this->Procurement_model->valid_procurement($this->input->post('ccategory'),
                                                             $this->input->post('caccount'),
                                                             $this->input->post('cmonth'),
                                                             $this->input->post('tyear')) == TRUE) 
            { $top = 1; }
            
            $procurement = array('category_id' => $this->input->post('ccategory'),
                              'dppa_id' => $dppa,
                              'type' => $this->account->get_type($this->input->post('caccount')),
                              'account_id' => $this->input->post('caccount'),
                              'title' => $this->input->post('ttitle'),
                              'amount' => $this->input->post('tnilai'),
                              'budget' => $this->input->post('tamount'),
                              'month' => $this->input->post('cmonth'),             
                              'year' => $this->input->post('tyear'),
                              'vendor' => $this->input->post('tvendor'),
                              'contact' => $this->input->post('tcontact'),
                              'contract_no' => $this->input->post('tcontract'),
                              'contract_date' => $this->input->post('tcontract_date'),
                              'top' => $top,
                              'created' => date('Y-m-d H:i:s'));
             
             $this->Procurement_model->add($procurement);
             echo 'true|Data successfully saved..!';
        }
        else { echo 'error|'.validation_errors();  }

        
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null,$type='get')
    {        
        $procurement = $this->Procurement_model->get_by_id($uid)->row();
        if ($type=='update'){
            $this->session->unset_userdata('langid');
	    $this->session->set_userdata('langid', $procurement->id);    
            
            $field = array($procurement->id, $procurement->type, $this->account->get_code($procurement->account_id).' : '.$this->account->get_name($procurement->account_id),
                           $this->category->get_name($procurement->category_id), $procurement->dppa_id, 
                           $procurement->amount, get_month($procurement->month), $procurement->opening, $procurement->progress_amount,
                           $procurement->rest, $procurement->year,
                           $this->get_budget($procurement->category_id, $procurement->account_id, $procurement->year, 'non'),
                           $procurement->month);
        }
        else{
        
        $field = array($procurement->id, $procurement->type, $procurement->account_id, $procurement->category_id, $procurement->dppa_id, 
                       $procurement->amount, $procurement->month, $procurement->opening, $procurement->progress_amount,
                       $procurement->rest, $procurement->year);
        }
        
        echo implode('|', $field);
    }
    
    // menampilkan kode rekening berdasarkan category
    function ajaxcombo($category=null,$year=null)
    {
        if ($category != null && $year != null){
            $category_account = $this->balance->combo_sp2d($this->session->userdata('dppa'), $category, $year);
            $js = "class='select2_single form-control' id='caccount_balance' tabindex='-1' style='width:100%;' "; 
            echo form_dropdown('caccount', $category_account, isset($default['category']) ? $default['category'] : '', $js);
        }
    }
    
    //menampilkan budget masing2 category
    function get_sp2d($cat=null,$acc=null,$month=null,$year=null,$type='ajax')
    {
        $res = 0;
        if ($cat != null && $acc != null){ 
            $sp2d = $this->transaction->get_total_monthly($this->session->userdata('dppa'), $cat, $acc, $month, $year,0);
            $progress = $this->transaction->get_total_monthly($this->session->userdata('dppa'), $cat, $acc, $month, $year,1);
 
        }
        else {$res = 0;}
        if ($type=='ajax'){ echo $sp2d.'|'.$progress; }else{ return $sp2d.'|'.$progress; }
    }
    
    function get_opening($cat=null,$acc=null,$month=null,$year=null)
    {
        if ($cat != null && $acc != null){ 
            $res = $this->Procurement_model->get_by_criteria($this->session->userdata('dppa'),$cat,$acc,$month,$year)->row();
            if ($res){ echo @$res->opening; }else { echo 0; }
        }
        else { echo 0; }
    }
    
    public function valid_progress($progress,$amount)
    {
        if ($progress > $amount)
        {
           $this->form_validation->set_message('valid_progress', "Invalid Progress Amount Procurement..!");
           return FALSE; 
        }
        else { return TRUE; }
    }
    
    public function valid_period($month,$year)
    {
        if ($this->Procurement_model->valid_period($month,$year) == FALSE)
        {
           $this->form_validation->set_message('valid_period', "Invalid Period Procurement..!");
           return FALSE; 
        }
        else { return TRUE; }
    }
    
    public function valid_amount_procurement($amount,$budget)
    {   
        $category = $this->input->post('ccategory');
        $account = $this->input->post('caccount');
        $month = $this->input->post('cmonth');
        $year = $this->input->post('tyear');
        
        $tot = $this->Procurement_model->total_periode_filter($this->session->userdata('dppa'),$account,$category,$month,$year);
        $amounts = $amount+$tot;
        
        if ($amounts > $budget){ 
           $this->form_validation->set_message('valid_amount_procurement', "Invalid Amount Procurement..!");
           return FALSE; 
        }
        else{ return TRUE; }
    }
    
    public function valid_budget_procurement($amount,$budget)
    {   
        $category = $this->input->post('ccategory');
        $account = $this->input->post('caccount');
        $month = $this->input->post('cmonth');
        $year = $this->input->post('tyear');
        
        $tot = $this->Procurement_model->total_periode_filter($this->session->userdata('dppa'),$account,$category,$month,$year,1);
        $amounts = $amount+$tot;
        
        if ($amounts > $budget){ 
           $this->form_validation->set_message('valid_budget_procurement', "Invalid Budget Amount Procurement..!");
           return FALSE; 
        }
        else{ return TRUE; }
    }

    public function valid_procurement($category)
    {
        $account = $this->input->post('caccount');
        $month = $this->input->post('cmonth');
        $year = $this->input->post('tyear');
        
//        if ($this->Procurement_model->valid_procurement($category,$account,$month,$year) == FALSE)
//        {
//            $this->form_validation->set_message('valid_procurement', "This account $this->title is already registered.!");
//            return FALSE;
//        }
//        else{ return TRUE; }
        return TRUE;
    }
    

    function validation_procurement($category)
    {
        
	$id = $this->session->userdata('langid');
	if ($this->Procurement_model->validating('name',$name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_procurement', 'This procurement is already registered!');
            return FALSE;
        }
        else { return TRUE; }
    }

    // Fungsi update untuk mengupdate db
    function update_process($dppa)
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'procurement_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('procurement/','<span>back</span>', array('class' => 'back')));

        
        $this->form_validation->set_rules('tamount', 'Nilai Anggaran', 'required|numeric|callback_valid_amount_procurement['.$this->input->post('tbudget').']'); 
        $this->form_validation->set_rules('cmonth', 'Bulan Anggaran', 'required|numeric|callback_valid_period['.$this->input->post('tyear').']'); 
        $this->form_validation->set_rules('tyear', 'Tahun Anggaran', 'required|numeric'); 
        $this->form_validation->set_rules('tprogress', 'Nilai Progress', 'required|numeric|callback_valid_progress['.$this->input->post('tamount').']'); 
        $this->form_validation->set_rules('topening', 'Saldo Awal', 'required|numeric'); 
        $this->form_validation->set_rules('trest', 'Sisa Saldo', 'required|numeric');            

        if ($this->form_validation->run($this) == TRUE)
        {
             $procurement = array(
                           'amount' => $this->input->post('tamount'),
                           'progress_amount' => $this->input->post('tprogress'),
                           'rest' => $this->input->post('trest'),
                           );

             $this->Procurement_model->update($this->session->userdata('langid'), $procurement);
             echo 'true|Data successfully saved..!';
        }
        else { echo 'error|'.validation_errors();  }
        
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function remove_image($uid)
    {
       $img = $this->Procurement_model->get_procurement_by_id($uid)->row();
       $img = $img->image;
       if ($img){ $img = "./images/procurement/".$img; unlink("$img"); } 
    }
    
    function report_process()
    {
        $this->acl->otentikasi2($this->title);
        $data['title'] = $this->properti['name'].' | Report '.ucwords($this->modul['title']);

        $data['rundate'] = tglin(date('Y-m-d'));
        $data['log'] = $this->session->userdata('log');
        $data['dppa'] = $this->dppa->get_name($this->input->post('cdppa'));
        $data['year'] = $this->input->post('tyear');
        $data['month'] = $this->input->post('cmonth');

//        Property Details
        $data['company'] = $this->properti['name'];
        $data['reports'] = $this->Procurement_model->report($this->input->post('cdppa'), $this->input->post('cmonth'),$this->input->post('tyear'))->result();
        
        if ($this->input->post('ctype') == 0){ $this->load->view('procurement_report', $data); }
        else { $this->load->view('procurement_pivot', $data); }
    }
    
    function closing()
    {
        $dppa = $this->session->userdata('dppa');
        $month = $this->period->get('month');
        $year = $this->period->get('year');
        
        $prev = $month-1;
        if ($prev != 0)
        {
            $previous = $this->Procurement_model->search($dppa,'null',$prev,$year)->result();
            $this->db->trans_start();
            $this->Procurement_model->cleaning($dppa,$month,$year);
            foreach ($previous as $res)
            {
               $trans = array('category_id' => $res->category_id, 'dppa_id' => $dppa,
                              'type' => $this->account->get_type($res->account_id),'account_id' => $res->account_id,
                              'opening' => $res->rest, 'amount' => $res->amount, 'month' => $month, 'year' => $year,
                              'created' => date('Y-m-d H:i:s')); 
               $this->Procurement_model->add($trans);
            }
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE){ $this->db->trans_rollback(); $this->session->set_flashdata('message', "Procurement Error..!!");    }
            else { $this->db->trans_commit(); $this->session->set_flashdata('message', "Procurement Successfull..!!");    }
        }
        else{ $this->session->set_flashdata('message', "Generate Data Can't Realize..!!");   }        
        redirect($this->title.'/get_dppa/'.$dppa); 
    }

}

?>