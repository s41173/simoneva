<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {


   public function __construct()
   {
        parent::__construct();

        $this->load->model('Login_model', '', TRUE);

        $this->load->helper('date');
        $this->log = new Log_lib();
        $this->load->library('email');
        $this->login = new Login_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('login');

        $this->properti = $this->property->get();

        // Your own constructor code
   }

   private $date,$time,$log,$login;
   private $properti,$com;

   function index()
   {
       $data['pname'] = $this->properti['name'];
       $data['logo'] = $this->properti['logo'];
       $data['form_action'] = site_url('login/login_process');

        
       $this->load->library('user_agent');
       if ($this->agent->is_mobile()) { $this->load->view('m_login', $data);} 
       else { $this->load->view('login_view', $data); }
    }

    // function untuk memeriksa input user dari form sebagai admin
    function login_process()
    {
        
        $datax = (array)json_decode(file_get_contents('php://input')); 

        $username = $datax['user'];
        $password = $datax['pass'];

            if ($this->Login_model->check_user($username,$password) == TRUE)
            {
                $this->date  = date('Y-m-d');
                $this->time  = waktuindo();
                $userid = $this->Login_model->get_userid($username);
                $role = $this->Login_model->get_role($username);
                $rules = $this->Login_model->get_rules($role);
                $logid = $this->log->max_log();
                $waktu = tgleng(date('Y-m-d')).' - '.waktuindo().' WIB';

                $this->log->insert($userid, $this->date, $this->time, 'login');
                $this->login->add($userid, $logid);
                
                $dppa = $this->Login_model->get_dppa($username);
                if ($dppa){ $this->session->set_userdata('dppa',$dppa); }

                $data = array('username' => $username, 'userid' => $userid, 'role' => $role, 'rules' => $rules, 'log' => $logid, 'login' => TRUE, 'waktu' => $waktu);
                $this->session->set_userdata($data);
                
                $response = array(
                  'Success' => true,
		  'User' => $datax['user'],
                  'Info' => 'Login Success'); 
            }
            else
            {
                $response = array(
                'Success' => false,
                'Info' => 'Invalid Login..!!');
            }
            
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;

    }

    // function untuk logout
    function process_logout()
    {
        $userid = $this->Login_model->get_userid($this->session->userdata('username'));
        $this->date  = date('Y-m-d');
        $this->time  = waktuindo();
        
        $this->log->insert($userid, $this->date, $this->time, 'logout');
        $this->session->sess_destroy();
        redirect('login');
    }

    function forgot()
    {
	$data['form_action'] = site_url('login/send_password');
        $data['pname'] = $this->properti['name'];
        $data['logo'] = $this->properti['logo'];
        $this->load->view('forgot_view' ,$data);
    }

    function send_password()
    {
        $datax = (array)json_decode(file_get_contents('php://input')); 

        $username = $datax['user'];
        
        if ($this->Login_model->check_username($username) == FALSE)
        {
           $this->session->set_flashdata('message', 'Username not registered ..!!');

           $response = array(
              'Success' => false,
              'User' => $username,
              'Info' => 'Username / Email not registered...!'); 
        }
        else
        {  
            try
            {
              $this->send_email($username); 
              $response = array(
               'Success' => true,
               'User' => $username,
               'Info' => 'Password has been sent to your email!');  
              
            }
            catch(Exception $e) {  
//                echo 'Pesan Error: ' .$e->getMessage();  
                $this->log->insert(0, date('Y-m-d'), waktuindo(), 'error', $this->com, $e->getMessage());
                $response = array(
               'Success' => false,
               'User' => $username,
               'Info' => $e->getMessage());    
            } 
        }
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;
    }
    
    function send_email($username)
    {
        $email = $this->Login_model->get_email($username);
        $pass = $this->Login_model->get_pass($username);
        $mess = "
          ".$this->properti['name']." - ".base_url()."
          FORGOT PASSWORD :

          Your Username is: ".$username."
          Your Password : ".$pass." <hr />
Your password for this account has been recovered . You don�t need to do anything, this message is simply a notification to protect the security of your account.
Please note: your password may take awhile to activate. If it doesn�t work on your first try, please try it again later
DO NOT REPLY TO THIS MESSAGE. For further help or to contact support, please email to ".$this->properti['email']."
****************************************************************************************************************** ";

        $params = array($this->properti['email'], $this->properti['name'], $email, 'Password Recovery', $mess, 'text');
        $se = $this->load->library('send_email',$params);

        if ( $se->send_process() == TRUE ){ return TRUE; }
        else { return FALSE;}
    }
    
    function download()
    {
       $this->load->helper('download');
        
       $data = file_get_contents("ug/sismoneva.apk"); // Read the file's contents
       $name = 'sismoneva.apk';    
       force_download($name, $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */