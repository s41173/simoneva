<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dppa extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Dppa_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->dppa = new Dppa_lib();
        $this->balance = new Balance_lib();
        $this->transaction = new Transaction_lib();
        $this->account = new Account_lib();
    }

    private $properti, $modul, $title, $dppa, $balance, $transaction, $account;
    function index()
    {
       $this->get_last(); 
    }
    
    function chart()
    {
        $this->db->select('playerid, score');
        $this->db->from('score'); 
        $result = $this->db->get()->result(); 
        
        print json_encode($result); 
    }
    
    public function getdatatable($search=null)
    {
        if(!$search){ $result = $this->Dppa_model->get_last($this->modul['limit'])->result(); }
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ($res->id, $this->dppa->get_name($res->parent_id), $res->code, $res->name,
                       base_url().'images/dppa/'.$res->image, $res->bendahara, $res->kadis, $res->publish);
	}
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($output, 128))
            ->_display();
            exit; 
        }
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Dppa_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Dppa_model->update($uid,$lng);
       echo 'true|Status Changed...!';
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'dppa_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['parent'] = $this->dppa->combo();
        $data['parent_update'] = $this->dppa->combo_update($this->session->userdata('langid'));
        $data['month'] = combo_month();
        $data['dppa'] = $this->dppa->combo_child();
        
	// ---------------------------------------- //
 
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'Parent', 'Code', 'DPPA', 'Bendahara', 'Kadis', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('dppa/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
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
              $img = $this->Dppa_model->get_by_id($cek[$i])->row();
              $img = $img->image;
              if ($img){ $img = "./images/dppa/".$img; unlink("$img"); }

              $this->Dppa_model->delete($cek[$i]); 
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

    function delete($uid,$type='soft')
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
        if ($type == 'soft'){
           $this->Dppa_model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully soft removed..!";
       }
       else
       {
        if ( $this->cek_relation($uid) == TRUE )
        {
           $img = $this->Dppa_model->get_by_id($uid)->row();
           $img = $img->image;
           if ($img){ $img = "./images/dppa/".$img; unlink("$img"); }

           $this->Dppa_model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully removed..!";
        }
        else { $this->session->set_flashdata('message', "$this->title related to another component..!"); 
        echo  "invalid|$this->title related to another component..!";} 
       }
       }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

    private function cek_relation($id)
    {
        $product = $this->product->cek_relation($id, $this->title);
        if ($product == TRUE) { return TRUE; } else { return FALSE; }
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'dppa_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('dppa/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tcode', 'Dppa Code', 'required|callback_valid_code');
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_valid_dppa');
        $this->form_validation->set_rules('cparent', 'Parent Dppa', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/dppa/';
            $config['file_name'] = split_space($this->input->post('tname'));
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = true;
            $config['max_size']	= '1000';
            $config['max_width']  = '3000';
            $config['max_height']  = '3000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
//
            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();
                $dppa = array('name' => strtolower($this->input->post('tname')),
                              'code' => strtolower($this->input->post('tcode')),
                              'bendahara' => $this->input->post('tbendahara'),
                              'nip_bendahara' => $this->input->post('tbendahara_nip'),
                              'kadis' => $this->input->post('tkadis'),
                              'nip_kadis' => $this->input->post('tkadis_nip'),
                              'parent_id' => $this->input->post('cparent'), 
                              'image' => null, 'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $info = $this->upload->data();
                $dppa = array('name' => strtolower($this->input->post('tname')),
                              'code' => strtolower($this->input->post('tcode')),
                              'bendahara' => $this->input->post('tbendahara'),
                              'nip_bendahara' => $this->input->post('tbendahara_nip'),
                              'kadis' => $this->input->post('tkadis'),
                              'nip_kadis' => $this->input->post('tkadis_nip'),
                              'parent_id' => $this->input->post('cparent'), 
                              'image' => $info['file_name'], 'created' => date('Y-m-d H:i:s'));
            }

            $this->Dppa_model->add($dppa);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//            redirect($this->title);
            
            if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
            else { echo 'true|'.$this->title.' successfully saved..!|'.base_url().'images/dppa/'.$info['file_name']; }
            
          //  echo 'true';
        }
        else{ echo "error|".validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $data['parent'] = $this->dppa->combo_update($uid);
        $dppa = $this->Dppa_model->get_by_id($uid)->row();
        $data['default']['name'] = $dppa->name;
        $data['default']['parent'] = $dppa->parent_id;
        $data['default']['image'] = base_url().'images/dppa/'.$dppa->image;
//
	$this->session->set_userdata('langid', $dppa->id);
//        $this->load->view('dppa_update', $data);
        
        echo $uid.'|'.$dppa->code.'|'.$dppa->name.'|'.$dppa->bendahara.'|'.$dppa->nip_bendahara.'|'.$dppa->kadis.'|'.
             $dppa->nip_kadis.'|'.
             $dppa->parent_id.'|'.base_url().'images/dppa/'.$dppa->image;
    }


    public function valid_dppa($name)
    {
        if ($this->Dppa_model->valid('name',$name) == FALSE)
        {
            $this->form_validation->set_message('valid_dppa', "This $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    public function valid_code($code)
    {
        if ($this->Dppa_model->valid('code',$code) == FALSE)
        {
            $this->form_validation->set_message('valid_code', "This $this->title code is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validation_dppa($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Dppa_model->validating('name',$name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_dppa', 'This '.$this->title.'is already registered!');
            return FALSE;
        }
        else { return TRUE; }
    }
    
    function validation_code($code)
    {
	$id = $this->session->userdata('langid');
	if ($this->Dppa_model->validating('code',$code,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_code', 'This '.$this->title.'code is already registered!');
            return FALSE;
        }
        else { return TRUE; }
    }

    // Fungsi update untuk mengupdate db
    function update_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'dppa_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('dppa/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tcode', 'Dppa Code', 'required|callback_validation_code');
        $this->form_validation->set_rules('tname', 'Name', 'required|max_length[100]|callback_validation_dppa');
        $this->form_validation->set_rules('cparent', 'Parent Dppa', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/dppa/';
            $config['file_name'] = split_space($this->input->post('tname'));
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '10000';
            $config['max_height']  = '10000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();
                $dppa = array('name' => strtolower($this->input->post('tname')),
                              'code' => strtolower($this->input->post('tcode')),
                              'bendahara' => $this->input->post('tbendahara'),
                              'nip_bendahara' => $this->input->post('tbendahara_nip'),
                              'kadis' => $this->input->post('tkadis'),
                              'nip_kadis' => $this->input->post('tkadis_nip'),
                              'parent_id' => $this->input->post('cparent'), 
                              'created' => date('Y-m-d H:i:s'));
                $img = null;
            }
            else
            {
                $info = $this->upload->data();                
                $dppa = array('name' => strtolower($this->input->post('tname')),
                              'code' => strtolower($this->input->post('tcode')),
                              'bendahara' => $this->input->post('tbendahara'),
                              'nip_bendahara' => $this->input->post('tbendahara_nip'),
                              'kadis' => $this->input->post('tkadis'),
                              'nip_kadis' => $this->input->post('tkadis_nip'),
                              'parent_id' => $this->input->post('cparent'), 
                              'image' => $info['file_name']);
                $img = base_url().'images/dppa/'.$info['file_name'];
            }

	    $this->Dppa_model->update($this->session->userdata('langid'), $dppa);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            
            if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
            else { echo 'true|Data successfully saved..!|'.base_url().'images/dppa/'.$info['file_name']; }
            
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function remove_image($uid)
    {
       $img = $this->Dppa_model->get_by_id($uid)->row();
       $img = $img->image;
       if ($img){ $img = "./images/dppa/".$img; @unlink("$img"); } 
    }
    
    function report_process()
    {
        $this->acl->otentikasi2($this->title);
        $data['title'] = $this->properti['name'].' | Report '.ucwords($this->modul['title']);

        $data['rundate'] = tglin(date('Y-m-d'));
        $data['log'] = $this->session->userdata('log');
        $data['dppa'] = strtoupper($this->dppa->get_name($this->input->post('cdppa')));
        $data['month'] = $this->input->post('cmonth');
        $data['year'] = $this->input->post('tyear');
        $data['dppa_id'] = $this->input->post('cdppa');
        
        $dppa = $this->Dppa_model->get_by_id($this->input->post('cdppa'))->row();
        $data['bendahara'] = $dppa->bendahara;
        $data['bendahara_nip'] = $dppa->nip_bendahara;
        $data['kadis'] = $dppa->kadis;
        $data['kadis_nip'] = $dppa->nip_kadis;
        $data['code_dppa'] = $dppa->code;
        
        // balance
        $data['source'] = $this->balance->get_priority($this->input->post('cdppa'),$this->input->post('tyear'),0);
        $data['pagu'] = $this->balance->get_balance($this->input->post('cdppa'), 'null', 'null', $this->input->post('cmonth'), $this->input->post('tyear'));
        
        
        // transaction sp2d
        $data['transaction_amount'] = $this->transaction->get_total_monthly($this->input->post('cdppa'),'null','null', $this->input->post('cmonth'), $this->input->post('tyear'),0);
        $data['previous_progress'] = $this->transaction->get_previous_total($this->input->post('cdppa'),'null','null', $this->input->post('cmonth'), $this->input->post('tyear'));
        
        
        $data['now_progress'] = $this->transaction->get_total_monthly($this->input->post('cdppa'),'null','null', $this->input->post('cmonth'), $this->input->post('tyear'),1);
        $data['total_progress'] =  $data['previous_progress']+$data['now_progress'];      
        $data['rest_balance'] = $data['pagu']-$data['total_progress'];
        
        // ======================== biaya tidak langsung ==============================
        $data['pagu_1'] = $this->balance->get_child_balance($this->input->post('cdppa'), $this->input->post('tyear'), 1);
        $data['transaction_amount_1'] = $this->transaction->get_total_monthly_based_belanja($this->input->post('cdppa'),'null','null', $this->input->post('cmonth'), $this->input->post('tyear'),0,1);
        $data['previous_progress_1'] = $this->transaction->get_previous_total_belanja($this->input->post('cdppa'),'null','null', $this->input->post('cmonth'), $this->input->post('tyear'),1);
        
        $data['now_progress_1'] = $this->transaction->get_total_monthly_based_belanja($this->input->post('cdppa'),'null','null', $this->input->post('cmonth'), $this->input->post('tyear'),1,1);
        $data['total_progress_1'] =  $data['previous_progress_1']+$data['now_progress_1']; 
        $data['rest_balance_1'] = $data['pagu_1']-$data['total_progress_1'];
        
        // ======================== biaya langsung =====================================
        $data['pagu_2'] = $this->balance->get_child_balance($this->input->post('cdppa'), $this->input->post('tyear'), 2);
        $data['transaction_amount_2'] = $this->transaction->get_total_monthly_based_belanja($this->input->post('cdppa'),'null','null', $this->input->post('cmonth'), $this->input->post('tyear'),0,2);
        $data['previous_progress_2'] = $this->transaction->get_previous_total_belanja($this->input->post('cdppa'),'null','null', $this->input->post('cmonth'), $this->input->post('tyear'),2);
        
        $data['now_progress_2'] = $this->transaction->get_total_monthly_based_belanja($this->input->post('cdppa'),'null','null', $this->input->post('cmonth'), $this->input->post('tyear'),1,2);
        $data['total_progress_2'] =  $data['previous_progress_2']+$data['now_progress_2']; 
        $data['rest_balance_2'] = $data['pagu_2']-$data['total_progress_2'];
        
        // get account parent belanja tidak langsung
        $data['account_category_1'] = $this->account->get_account_category($this->input->post('cdppa'),$this->input->post('tyear'),1)->result();
        
//        get account parent belanja langsung
        $data['account_category_2'] = $this->account->get_account_category($this->input->post('cdppa'),$this->input->post('tyear'),2)->result();
        
        
        
////        Property Details
        $data['company'] = $this->properti['name'];
        $data['logo'] = $this->properti['logo'];
                
//        $data['reports'] = $this->Dppa_model->report($this->input->post('cdppa'),$this->input->post('tyear'))->result();
        
        if ($this->input->post('ctype') == 0){ $this->load->view('progress_report', $data); }
        elseif ($this->input->post('ctype') == 1) { $this->load->view('procurement_report', $data); }
        elseif ($this->input->post('ctype') == 2) { $this->load->view('dppa_progress_report', $data); }
    }

}

?>