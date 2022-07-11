<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alat extends CI_Controller {

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
		$this->load->model('pengajuan_alat_model');
        $this->load->model('event_baru_model');
    }

	public function index(){
		if(!$this->session->userdata('email')){
			redirect("auth");
		}else{
            $data["data_alat"] = $this->inventaris_model->get_available();
            $data["data_event"] = $this->event_baru_model->get_accepted();
			$this->load->view('event/pengajuan_alat', $data);
		}
	}

	public function get_alat_by_event(){
		$id = $this->input->post("kodeEVent");

		$get_event_detail = $this->event_baru_model->get($id);

		$get_start_date = $get_event_detail[0]->tanggalWaktuMulaiEvent;
		$get_end_date = $get_event_detail[0]->tanggalWaktuSelesaiEvent;

		$startDate = "CAST('".$get_start_date."' AS DATETIME)";
		$endDate = " CAST('".$get_end_date."' AS DATETIME)";

		$where_event = " tanggalWaktuMulaiEvent >= ".$startDate." AND tanggalWaktuSelesaiEvent <= ".$endDate. "";

		$get_list_event = $this->event_baru_model->get_list_event($where_event);
		$get_alat = $this->inventaris_model->get_available();

		$list_alat_event = array();
		$list_array_fix = array();
		$kodeAlatTr = array();

		foreach($get_list_event as $list){
			$get_alat_tr = $this->event_baru_model->get_list_alat($list->kodeEvent);
			$get_kode_alat = array_column($get_alat_tr, 'kodeAlat');

			foreach($get_alat_tr as $list2){
				array_push($list_alat_event, $list2->kodeAlat);
			}
			
		}
		
		$kodeAlatTr = $list_alat_event;

		foreach($get_alat as $list){
			if(!in_array($list->kodeAlat,$kodeAlatTr)){
				array_push($list_array_fix, $list->kodeAlat);
			}
		}
		
		echo json_encode($list_array_fix);
	}

	public function pengajuan_submit(){
		$this->form_validation->set_rules('namaAlatInput[]', 'Nama Alat', 'required');
		$this->form_validation->set_rules('hargaAlatInput[]', 'Harga Alat', 'required');
		if($this->form_validation->run() == FALSE){
			$this->load->view('event/pengajuan_alat');
        }else{
			$alat = $this->input->post("namaAlatInput");
			$kodeAlat = $this->input->post("kodeAlatInput");
			$harga = $this->input->post("hargaAlatInput");
			$kodeEVent = $this->input->post("kodeEvent");

			$get_event_detail = $this->event_baru_model->get($kodeEVent)[0];
			$total = $get_event_detail->totalHarga;

			$totalFix = 0;
		
			for($i =0; $i< sizeof($alat);$i++){
				$array_insert_alat = array(
					"kodeEvent" => $kodeEVent,
					"kodeAlat" => $kodeAlat[$i],
					"status" => 3
				);

				$temp = explode("Rp. ",$harga[$i])[1];
				$edit_total = (int)$total + (int)$temp;
				
				$totalFix = $edit_total;

				$this->event_baru_model->add_alat_event($array_insert_alat);
			}

			// $this->event_baru_model->edit_status(array("totalHarga"=>$totalFix), $kodeEVent);

			$this->session->set_flashdata('success', 'Sukses mengajukan alat baru!');
			redirect("event/schedule_event");
		}
	
	}
}
