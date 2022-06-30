<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		$this->load->library('session');
		$this->load->model('inventaris_model');
		$this->load->model('event_baru_model');
    }

	public function index(){
		if(!$this->session->userdata('email')){
			redirect("auth");
		}else{
			$check_event =  $this->event_baru_model->get();
			$today = date('Y-m-d');
			foreach($check_event as $list){
				if( $today  >= date('Y-m-d', strtotime($list->tanggalWaktuMulaiEvent)) &&  $today <= date('Y-m-d', strtotime($list->tanggalWaktuSelesaiEvent)) ){
					$get_list = $this->event_baru_model->get_list_alat($list->kodeEvent);

					if($get_list){
						for($i=0;$i<count($get_list);$i++){
							$array_update = array(
								"statusAlat" => 2
							);

							$this->inventaris_model->edit_alat($array_update, $get_list[$i]->kodeAlat);
						}
					}
				}else{
					$get_list = $this->event_baru_model->get_list_alat($list->kodeEvent);

					if($get_list){
						for($i=0;$i<count($get_list);$i++){
							$array_update = array(
								"statusAlat" => 3
							);

							$this->inventaris_model->edit_alat($array_update, $get_list[$i]->kodeAlat);
						}
					}

					
				}
			}
			$this->load->view('dashboard');
		}
	}
}
