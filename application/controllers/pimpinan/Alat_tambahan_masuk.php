<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alat_tambahan_masuk extends CI_Controller {

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
        $this->load->model('inventaris_model');
		$this->load->model('event_baru_model');
    }

	public function index(){
		if(!$this->session->userdata('email')){
			redirect("auth");
		}else{
            $data = null;
            $alat = $this->event_baru_model->get_list_alat_pending();
            $list = array();
           
            foreach($alat as $l){
                $get_event = $this->event_baru_model->get($l->kodeEvent)[0];
                $get_harga = $this->inventaris_model->get($l->kodeAlat)[0];

				$temp = (object) [
					"namaAlat" => $get_harga->namaAlat,
					"hargaAlat" => $get_harga->hargaRetail,
					"namaEvent" => $get_event->namaEvent,
					"status" => $l->status,
					"kodeEvent" => $l->kodeEvent,
					"kodeAlat" => $l->kodeAlat,
					"id"=> $l->id
				];

				array_push($list, $temp);
            }

			$data["data"] = $list;
			$this->load->view('pimpinan/alat_tambahan_masuk', $data);
		}
	}

	public function accept($id){
		if($id !=NULL){
			$get = $this->event_baru_model->get_list_alat_pending($id);
			$get_nama_alat = $this->inventaris_model->get($get[0]->kodeAlat)[0];
			
			$array_update_status = array(
				"statusAlat" => 2
			);

			$array_update_status_alat = array(
				"status" => 1
			);

			$this->event_baru_model->edit_status_alat($array_update_status_alat, array("id" => $id));
			$this->inventaris_model->edit_alat($array_update_status, $get[0]->kodeAlat);

			$this->session->set_flashdata('success',  'Alat '.$get_nama_alat->namaAlat.' telah diaccept!');
            redirect('pimpinan/alat_tambahan_masuk');
		}else{
			$this->session->set_flashdata('error', "Accept alat error!");
			redirect('pimpinan/alat_tambahan_masuk');
		}
	}

	public function reject($id){
		if($id !=NULL){
			$get = $this->event_baru_model->get_list_alat_pending($id);
			$get_nama_alat = $this->inventaris_model->get($get[0]->kodeAlat)[0];

			$array_update_status_alat = array(
				"status" => 2
			);

			$this->event_baru_model->edit_status_alat($array_update_status_alat, array("id" => $id));
			
			$this->session->set_flashdata('success',  'Alat '.$get_nama_alat->namaAlat.' telah direject!');
            redirect('pimpinan/alat_tambahan_masuk');
		}else{
			$this->session->set_flashdata('error', "Reject alat error!");
			redirect('pimpinan/alat_tambahan_masuk');
		}
	}
}
