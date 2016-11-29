<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Transaction_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
//        $this->transaction = new Transaction_lib();
        $this->dppa = new Dppa_lib();
        $this->account = new Account_lib();
        $this->category = new Acategory_lib();
    }

    private $properti, $modul, $title, $transaction, $dppa, $account, $category;

    function index()
    {
       $this->get_last(); 
    }
    
    public function getdatatable($search=null,$cat='null',$type='null',$year='null')
    {
        if(!$search){ $result = $this->Transaction_model->get_last($this->modul['limit'])->result(); }
        else { $result = $this->Transaction_model->search($cat,$type,$year)->result(); }
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ($res->id, $this->category->type($res->type), 
                              $this->account->get_name($res->account_id),
                              $this->category->get_name($res->category_id), 
                              strtoupper($this->dppa->get_name($res->dppa_id)),
                              idr_format($res->amount), $res->month, $res->year,
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
        $result = $this->Transaction_model->get_last_dppa($dppa)->result(); 
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ($res->id, $this->category->type($res->type), 
                              $this->account->get_name($res->account_id),
                              $this->category->get_name($res->category_id), 
                              strtoupper($this->dppa->get_name($res->dppa_id)),
                              idr_format($res->amount), $res->month, $res->year,
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
        $data['main_view'] = 'transaction_dppa_view';
	$data['form_action'] = site_url($this->title.'/add_process/'.$dppa);
        $data['form_action_update'] = site_url($this->title.'/update_process/'.$dppa);
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('dppa/','Back', array('class' => 'btn btn-danger')));
        $this->session->set_userdata('dppa',$dppa);
	// ---------------------------------------- //
        
        $data['account'] = $this->account->combo_child();
        $data['category'] = $this->category->combo_child_based_dppa($this->session->userdata('dppa'));
 
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'DPPA', 'Jenis', 'Rekening', 'Sumber', 'Nilai', 'Periode', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('transaction/getdatatable_dppa/'.$dppa);
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'transaction_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));
	// ---------------------------------------- //
        
        $data['account'] = $this->account->combo_child();
        $data['category'] = $this->category->combo_child();
 
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'DPPA', 'Jenis', 'Parent', 'Urutan', 'Code', 'Nama');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('transaction/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Transaction_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Transaction_model->update($uid,$lng);
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
              $this->Transaction_model->force_delete($cek[$i]); 
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
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
        if ($type == 'soft'){
           $this->Transaction_model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully removed..!";
       }
       else
       {
        if ( $this->cek_relation($uid) == TRUE )
        {
           $this->Transaction_model->force_delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully removed..!";
        }
        else { $this->session->set_flashdata('message', "$this->title related to another component..!"); 
        echo  "invalid|$this->title related to another component..!";} 
       }
       }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

    private function cek_relation($id){ return TRUE; }

    function add_process($dppa=null)
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('transaction/','<span>back</span>', array('class' => 'back')));

	// Form validation 
        
        if ($this->input->post('type')=='priority')
        {
           $this->form_validation->set_rules('csource', 'Sumber Anggaran', 'required'); 
           $this->form_validation->set_rules('tamount', 'Nilai Anggaran', 'required|numeric|callback_valid_child_transaction'); 
           $this->form_validation->set_rules('tyear', 'Tahun Anggaran', 'required|numeric|callback_valid_priority'); 
           
           if ($this->form_validation->run($this) == TRUE)
           {
                $transaction = array('source' => $this->input->post('csource'),
                                 'dppa_id' => $dppa,
                                 'priority' => 1,
                                 'amount' => $this->input->post('tamount'),
                                 'year' => $this->input->post('tyear'),
                                 'created' => date('Y-m-d H:i:s'));
                $this->Transaction_model->add($transaction);
                echo 'true|Data successfully saved..!';
           }
           else { echo 'error|'.validation_errors();  }
        }
        else
        {
            $this->form_validation->set_rules('caccount', 'Rekening', 'required|callback_valid_transaction['.$this->input->post('tyear').']'); 
            $this->form_validation->set_rules('ccategory', 'Jenis Program', 'required'); 
            $this->form_validation->set_rules('tamount', 'Nilai Anggaran', 'required|numeric|callback_valid_amount_transaction'); 
            $this->form_validation->set_rules('tyear', 'Tahun Anggaran', 'required|numeric'); 

            if ($this->form_validation->run($this) == TRUE)
            {
                 $transaction = array('account_id' => $this->input->post('caccount'),
                                  'category_id' => $this->input->post('ccategory'),
                                  'type' => $this->account->get_type($this->input->post('caccount')),
                                  'amount' => $this->input->post('tamount'),
                                  'year' => $this->input->post('tyear'),
                                  'dppa_id' => $dppa,
                                  'priority' => 0,
                                  'created' => date('Y-m-d H:i:s'));
                 $this->Transaction_model->add($transaction);
                 echo 'true|Data successfully saved..!';
            }
            else { echo 'error|'.validation_errors();  }
        }
        
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null,$type='get')
    {        
        $transaction = $this->Transaction_model->get_by_id($uid)->row();
        if ($type=='update'){
            $this->session->unset_userdata('langid');
	    $this->session->set_userdata('langid', $transaction->id);    
        }
        
        $field = array($transaction->id, $transaction->type, $transaction->account_id, $transaction->category_id, $transaction->dppa_id, 
                       $transaction->priority, $transaction->source, $transaction->amount, $transaction->month, $transaction->year);
        
        echo implode('|', $field);
    }
    
    
    public function valid_code($code)
    {
        if ($this->Transaction_model->valid('code',$code) == FALSE)
        {
            $this->form_validation->set_message('valid_code', "This $this->title code is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    function validation_code($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Transaction_model->validating('code',$name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_code', 'This '.$this->title.' code is already registered!');
            return FALSE;
        }
        else { return TRUE; }
    }
    
    public function valid_type($type,$parent)
    {
        if ($parent == 0){
            if (!$type){ $this->form_validation->set_message('valid_type', "Type required..!"); }else{ return TRUE; }
        }
        else { return TRUE; }
    }
    
    public function valid_priority($year)
    {
        if ($this->Transaction_model->valid('year',$year) == FALSE)
        {
            $this->form_validation->set_message('valid_priority', "This $this->title priority transaction is already registered.!");
            return FALSE;
        }
        else{ return TRUE; } 
    }
    
    public function valid_amount_transaction($amount)
    {
        $priority_transaction = $this->Transaction_model->total_priority($this->input->post('tyear'));
        $child_transaction = $this->Transaction_model->total_child($this->input->post('tyear'));
        
        if ($amount+$child_transaction > $priority_transaction){ 
           $this->form_validation->set_message('valid_amount_transaction', "Invalid Child Transaction..!");
           return FALSE; 
        }
        else{ return TRUE; }
    }
    
    // validasi add priority transaction tidak boleh < child transaction
    public function valid_child_transaction($amount)
    {
        $p_transaction = $this->Transaction_model->total_child($this->input->post('tyear'));
        if ($p_transaction > $amount){ 
           $this->form_validation->set_message('valid_child_transaction', "Invalid Transaction..!");
           return FALSE; 
        }
        else{ return TRUE; }
    }
    

    public function valid_transaction($account,$year)
    {
        if ($this->Transaction_model->valid_transaction($account,$year) == FALSE)
        {
            $this->form_validation->set_message('valid_transaction', "This account $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validation_transaction($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Transaction_model->validating('name',$name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_transaction', 'This transaction is already registered!');
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
        $data['main_view'] = 'transaction_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('transaction/','<span>back</span>', array('class' => 'back')));

        
        if ($this->input->post('type')=='priority')
        {
           $this->form_validation->set_rules('csource', 'Sumber Anggaran', 'required'); 
           $this->form_validation->set_rules('tamount', 'Nilai Anggaran', 'required|numeric|callback_valid_child_transaction'); 
           $this->form_validation->set_rules('tyear', 'Tahun Anggaran', 'required|numeric'); 
           
           if ($this->form_validation->run($this) == TRUE)
           {
                $transaction = array('source' => $this->input->post('csource'),
                                 'dppa_id' => $dppa,
                                 'priority' => 1,
                                 'amount' => $this->input->post('tamount'),
                                 'year' => $this->input->post('tyear'),
                                 'created' => date('Y-m-d H:i:s'));
                
                $this->Transaction_model->update($this->session->userdata('langid'), $transaction);
                echo 'true|Data successfully saved..!';
           }
           else { echo 'error|'.validation_errors();  }
        }
        
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function remove_image($uid)
    {
       $img = $this->Transaction_model->get_transaction_by_id($uid)->row();
       $img = $img->image;
       if ($img){ $img = "./images/transaction/".$img; unlink("$img"); } 
    }

}

?>