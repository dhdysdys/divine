<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
        $this->load->library(['form_validation','session']);
        $this->load->model('user_model');
    }

	public function index(){
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        if($this->session->userdata('username')){
            redirect('dashboard');
        }else{
            $this->load->view('auth/login');
        }
		
	}

    public function login(){
        $this->form_validation->set_rules('inputUsername', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('inputPassword', 'Password', 'required');

        if($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('login_error', 'Please check your email or password and try again!', 300);
            $this->load->view('auth/login');
        }else {
            $email = $this->input->post('inputUsername');
            $password = $this->input->post('inputPassword');

            $check_user = $this->user_model->check_user(array("email" => $email));
         
            if(!$check_user){
                $this->session->set_flashdata('login_error', 'User not registered!',300);
                $this->load->view('auth/login');
            }else{
                if($password != $check_user[0]->password) {
                    $this->session->set_flashdata('login_error', 'Password does not match!',300);
                    $this->load->view('auth/login');
                }else{
                    $data = array(
                        'id' => $check_user[0]->kodeAdmin,
                        'nama' => $check_user[0]->namaUser,
                        'role' => $check_user[0]->role,
                        'email' => $check_user[0]->email,
                    );
    
                    $this->session->set_userdata($data); 
                    
                    // if($check_user[0]->role == 0){
                    //     redirect('admin/dashboard');
                    // }else if($check_user[0]->role == 1){
                    //     redirect('inventaris/alat');
                    // }
                    redirect('dashboard');
                    
                }               
            }
        } 
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('auth');
    }
}
