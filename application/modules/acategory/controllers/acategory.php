<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Acategory extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Acategory_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->acategory = new Acategory_lib();
        $this->dppa = new Dppa_lib();
    }

    private $properti, $modul, $title, $acategory, $dppa;

    function index()
    {
       $this->get_last(); 
    }
    
    public function getdatatable($search=null)
    {
        if(!$search){ $result = $this->Acategory_model->get_last($this->modul['limit'])->result(); }
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ($res->id, $this->acategory->get_name($res->parent_id), $this->acategory->type($res->type), $res->code, $res->name, $this->dppa->get_name($res->dppa_id),
                              $res->description, $res->created, $res->updated, $res->deleted);
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
        $result = $this->Acategory_model->get_last_dppa($dppa)->result(); 
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ($res->id, ucfirst($this->acategory->get_name($res->parent_id)), $this->acategory->type($res->type), $res->code, ucfirst($res->name), ucfirst($this->dppa->get_name($res->dppa_id)),
                              $res->description, $res->created, $res->updated, $res->deleted);
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
        $data['main_view'] = 'acategory_dppa_view';
	$data['form_action'] = site_url($this->title.'/add_process/'.$dppa);
        $data['form_action_update'] = site_url($this->title.'/update_process/'.$dppa);
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('dppa/','Back', array('class' => 'btn btn-danger')));
        $this->session->set_userdata('dppa',$dppa);
	// ---------------------------------------- //
        
        $data['parent'] = $this->acategory->combo_dppa($dppa);
        $data['parent_update'] = $this->acategory->combo_update($dppa,$this->session->userdata('langid'));
 
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'DPPA', 'Jenis', 'Parent', 'Code', 'Nama', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('acategory/getdatatable_dppa/'.$dppa);
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'acategory_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));
	// ---------------------------------------- //
        
        $data['parent'] = $this->acategory->combo();
        $data['parent_update'] = $this->acategory->combo_update($this->session->userdata('langid'));
 
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'DPPA', 'Jenis', 'Parent', 'Code', 'Nama', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('acategory/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Acategory_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Acategory_model->update($uid,$lng);
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
              $img = $this->Acategory_model->get_acategory_by_id($cek[$i])->row();
              $img = $img->image;
              if ($img){ $img = "./images/acategory/".$img; unlink("$img"); }

              $this->Acategory_model->delete($cek[$i]); 
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
           $this->Acategory_model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully soft removed..!";
       }
       else
       {
        if ( $this->cek_relation($uid) == TRUE )
        {
           $img = $this->Acategory_model->get_acategory_by_id($uid)->row();
           $img = $img->image;
           if ($img){ $img = "./images/acategory/".$img; unlink("$img"); }

           $this->Acategory_model->delete($uid);
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

    function add_process($dppa=null)
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'acategory_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('acategory/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tcode', 'Kode Rekening', 'required|callback_valid_code');
        $this->form_validation->set_rules('tname', 'Nama Rekening', 'required|callback_valid_acategory');
        $this->form_validation->set_rules('tdesc', 'Keterangan', '');
        $this->form_validation->set_rules('cparent', 'Parent', 'numeric');
        $this->form_validation->set_rules('ctype', 'Jenis Kategory', 'callback_valid_type['.$this->input->post('cparent').']');

        
//        protected $field = array('id', 'parent_id', 'type', 'code', 'name', 'dppa_id', 'description', 'created', 'updated', 'deleted');
        
        if ($this->form_validation->run($this) == TRUE)
        {
            if ($this->input->post('cparent')=='0'){ $type = $this->input->post('ctype'); }
            else{ $type = $this->acategory->get_type($this->input->post('cparent')); }
            
            $acategory = array('name' => strtolower($this->input->post('tname')),
                             'code' => strtolower($this->input->post('tcode')),
                             'parent_id' => $this->input->post('cparent'),
                             'type' => $type,
                             'dppa_id' => $dppa,
                             'description' => $this->input->post('tdesc'),
                             'created' => date('Y-m-d H:i:s'));

            $this->Acategory_model->add($acategory);
//            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
            
            echo 'true|Data successfully saved..!';
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null,$type='get')
    {        
        $acategory = $this->Acategory_model->get_by_id($uid)->row();
        if ($type=='update'){
            $this->session->unset_userdata('langid');
	    $this->session->set_userdata('langid', $acategory->id);    
        }
        
        $field = array($acategory->id, $acategory->parent_id, $acategory->code, $acategory->name, $acategory->description,
                       $acategory->publish);
        echo implode('|', $field);
    }
    
    
    public function valid_code($code)
    {
        if ($this->Acategory_model->valid('code',$code) == FALSE)
        {
            $this->form_validation->set_message('valid_code', "This $this->title code is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    function validation_code($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Acategory_model->validating('code',$name,$id) == FALSE)
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

    public function valid_acategory($name)
    {
        if ($this->Acategory_model->valid('name',$name) == FALSE)
        {
            $this->form_validation->set_message('valid_acategory', "This $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validation_acategory($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Acategory_model->validating('name',$name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_acategory', 'This acategory is already registered!');
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
        $data['main_view'] = 'acategory_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('acategory/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tcode', 'Kode Rekening', 'required|callback_validation_code');
        $this->form_validation->set_rules('tname', 'Nama Rekening', 'required|callback_validation_acategory');
        $this->form_validation->set_rules('tdesc', 'Keterangan', '');
        $this->form_validation->set_rules('cparent', 'Parent', 'numeric');

        if ($this->form_validation->run($this) == TRUE)
        {

            $acategory = array('name' => strtolower($this->input->post('tname')),
                             'code' => strtolower($this->input->post('tcode')),
                             'parent_id' => $this->input->post('cparent'),
                             'description' => $this->input->post('tdesc'));
            
	    $this->Acategory_model->update($this->session->userdata('langid'), $acategory);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            
            echo 'true|Data successfully saved..!';
            
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function remove_image($uid)
    {
       $img = $this->Acategory_model->get_acategory_by_id($uid)->row();
       $img = $img->image;
       if ($img){ $img = "./images/acategory/".$img; unlink("$img"); } 
    }

}

?>