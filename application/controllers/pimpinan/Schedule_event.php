<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_event extends CI_Controller {

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
		$this->load->helper(array('form', 'url', 'download'));
		$this->load->library(['form_validation','session']);
		$this->load->model('event_baru_model');
    }

	public function index(){
		if(!$this->session->userdata('email')){
			redirect("auth");
		}else{
			$data["data"] = $this->event_baru_model->get();
			$this->load->view('pimpinan/events', $data);
		}
	}

	public function view_rundown(){
		$filename = $this->input->get('path');		
		$path = 'data/upload/'.$filename;
		chmod($path, 0777);

        if(file_exists($path)){
            // get file content
            $data = file_get_contents($path);
            $path_explode = explode("/",$path);
            $path_count = count($path_explode);
            force_download($path_explode[$path_count-1],$data);
        } else {
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }
	}
}
