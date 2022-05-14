<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
        $this->load->database();
    }

	public function index(){
		if(!$this->session->userdata('email')){
			redirect("auth");
		}else{
            $data["data"] = $this->user_model->get_user_without_admin();
			$this->load->view('admin/users', $data);
		}
	}

    public function add_user(){
        if(!$this->session->userdata('email')){
			redirect("auth");
		}else{
			$this->load->view('admin/add_user');
		}
    }

    public function add(){
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[dataUser.namaUser]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[dataUser.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('role', 'Role', 'required');


        if($this->form_validation->run() == FALSE){
            $this->load->view('admin/add_user');
        }else{
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $role = $this->input->post('role');
            
            $check_user = $this->user_model->check_user(array("email" => $email));

            if(!$check_user){
                $data = array(
                    'namaUser' => $username,
                    'email' => $email,
                    'password' => $password,
                    'role' => $role
                );
    
                $this->user_model->add_user($data);
                $this->session->set_flashdata('success', 'Sukses add user!');
                redirect("admin/user");
            }else{
                $this->session->set_flashdata('add_user_error', 'User already registered!',300);
                $this->load->view('admin/add_user');
            }
           
        }
    }

    public function delete($id){
        if($id != NULL){
            $this->user_model->delete_user($id);
            $this->session->set_flashdata('success', 'Sukses delete user!');
            redirect('admin/user');
        }
    }
}
