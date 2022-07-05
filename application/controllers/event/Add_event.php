<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_event extends CI_Controller {

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
			$listAlat = array();
			$data["alat"] = $this->inventaris_model->get_available();
			$this->load->view('event/add_event', $data);
		}
	}

	public function get_alat_by_date(){
		$start_date = $this->input->post("tanggalMulai");
		$end_date = $this->input->post("tanggalSelesai");

		$startDate = "CAST('".$start_date."' AS DATETIME)";
		$endDate = " CAST('".$end_date."' AS DATETIME)";

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

	public function submit(){
		$this->form_validation->set_rules('namaEvent', 'Nama Event', 'required');
        $this->form_validation->set_rules('namaClient', 'Nama Client', 'required');
        $this->form_validation->set_rules('tanggalMulai', 'Tanggal Mulai Event', 'required');
		$this->form_validation->set_rules('tanggalSelesai', 'Tanggal Berakhir Event', 'required');
        $this->form_validation->set_rules('jamEventMulai[]', 'Waktu Mulai', 'required|numeric');
		$this->form_validation->set_rules('menitEventMulai[]', 'Waktu Mulai', 'required|numeric');
		$this->form_validation->set_rules('jamEventSelesai[]', 'Waktu Mulai', 'required|numeric');
		$this->form_validation->set_rules('menitEventSelesai[]', 'Waktu Mulai', 'required|numeric');
		$this->form_validation->set_rules('lokasiEvent', 'Lokasi Event', 'required');
        $this->form_validation->set_rules('namaAlatInput[]', 'Nama Alat', 'required');
		$this->form_validation->set_rules('hargaAlatInput[]', 'Harga Alat', 'required');
		$this->form_validation->set_rules('hargaKesepakatan', 'Harga Kesepakatan', 'required');

		if($this->form_validation->run() == FALSE){
			$data["alat"] = $this->inventaris_model->get_available();
            $this->load->view('event/add_event', $data);
        }else{
			$namaEvent = $this->input->post("namaEvent");
			$namaClient = $this->input->post("namaClient");
			$tanggalMulai = $this->input->post("tanggalMulai");
			$durasi = $this->input->post("durasi");
			$tanggalSelesai = $this->input->post("tanggalSelesai");
			$alat = $this->input->post("namaAlatInput");
			$kodeAlat = $this->input->post("kodeAlatInput");
			$harga = $this->input->post("hargaAlatInput");
			$total = $this->input->post("hargaAlatTotal");
			$totalHarga = explode(" ",$total)[1];
			$jamMulai = $this->input->post("jamEventMulai");
			$menitMulai = $this->input->post("menitEventMulai");
			$jamSelesai = $this->input->post("jamEventSelesai");
			$menitSelesai = $this->input->post("menitEventSelesai");
			$hargaKesepakatan = $this->input->post("hargaKesepakatan");
			$rundown = $this->input->post("rundownEvent");
			$lokasi = $this->input->post("lokasiEvent");

			if (!is_dir('data')) {
                mkdir('data/', 0777);
            }
            if (!is_dir('data/upload/')) {
                mkdir('data/upload', 0777);
            }
            $folder = "/data/upload/";

			$this->load->library('upload');
			
            $config['upload_path'] = '.'.$folder;
			if(is_file($config['upload_path'])){
				chmod($config['upload_path'], 0777);
			}

            $config['file_name'] = $_FILES['rundownEvent']['name'];
			$config['max_size']  = '5048000';
			$config['overwrite'] = true;
			$config['allowed_types'] = 'pdf';
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('rundownEvent')){ 
                $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
                $this->session->set_flashdata('error', $this->upload->display_errors());
				redirect("event/schedule_event");
            }else{
                $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
				$uploadData = $this->upload->data(); 
				$filename = $uploadData['file_name'];

				$array_insert = array(
					"namaEvent" => $namaEvent,
					"namaClient" => $namaClient,
					"durasi" => $durasi,
					"tanggalWaktuMulaiEvent" => $tanggalMulai,
					"tanggalWaktuSelesaiEvent" => $tanggalSelesai,
					"lokasiEvent" => $lokasi,
					"rundownEvent" => $filename,
					"totalHarga" => $totalHarga,
					"hargaKesepakatan" => $hargaKesepakatan,
					"status" => 0
				);

				$insert_id = $this->event_baru_model->add_event($array_insert);

				
				if(sizeof($jamMulai) > 1 && sizeof($jamSelesai) > 1){

					$tglMulaiSplit = explode('-', $tanggalMulai)[2];
					$bulanMulaiSplit = explode('-', $tanggalMulai)[1];
					$tahunMulaiSplit = explode('-', $tanggalMulai)[0];
					$tglSelesaiSplit = explode("-",$tanggalSelesai)[2];
					$bulanSelesaiSplit = explode('-', $tanggalSelesai)[1];
					$tahunSelesaiSplit = explode('-', $tanggalSelesai)[0];

					$timeMulai = $jamMulai[0].":".$menitMulai[0].":00";
					$timeSelesai = $jamSelesai[0].":".$menitSelesai[0].":00";

					$tanggalMulaicurr = $tanggalMulai;
					$tanggalMulai = $tanggalMulai." ".$timeMulai;
					$tanggalSelesai = $tanggalMulaicurr." ".$timeSelesai;

					if($insert_id){
						$array_insert = array(
							"kodeEvent" => $insert_id,
							"tanggalMulai" => $tanggalMulai,
							"tanggalSelesai" => $tanggalSelesai
						);

						$this->event_baru_model->add_waktu($array_insert);
					}

					for($j=1;$j<$durasi;$j++){
						if($j < $durasi){
							$tglMulaiSplit = intval($tglMulaiSplit) + 1;

							if($tglMulaiSplit < 10 && strlen($tglMulaiSplit) == 1){
								$tglMulaiSplit = "0".$tglMulaiSplit;
							}

							$tglMulaiFix = $tahunMulaiSplit."-".$bulanMulaiSplit."-".$tglMulaiSplit;
							
							if($jamMulai[$j] < 10 && strlen($jamMulai[$j]) == 1){
								$jamMulai[$j] = "0".$jamMulai[$j];
							}
				
							if($menitMulai[$j] < 10 && strlen($menitMulai[$j]) == 1){
								$menitMulai = "$j".$menitMulai;
							}
				
							if($jamSelesai[$j] < 10 && strlen($jamSelesai[$j]) == 1){
								$jamSelesai[$j] = "$i".$jamSelesai[$j];
							}
				
							if($menitSelesai[$j] < 10 && strlen($menitSelesai[$j]) == 1 ){
								$menitSelesai[$j] = "$i".$menitSelesai[$j];
							}
				
							$timeMulai = $jamMulai[$j].":".$menitMulai[$j].":00";
							$timeSelesai = $jamSelesai[$j].":".$menitSelesai[$j].":00";
							

							$tanggalMulai = $tglMulaiFix." ".$timeMulai;
							$tanggalSelesai = $tglMulaiFix." ".$timeSelesai;
						}else{
							$tglSelesaiSplit = $tahunSelesaiSplit."-".$bulanSelesaiSplit."-".$tglSelesaiSplit." ";
							
							$tglSelesaiFix = $tahunMulaiSplit."-".$bulanMulaiSplit."-".$tglMulaiSplit;
							
							if($jamMulai[$j] < 10 && strlen($jamMulai[$j]) == 1){
								$jamMulai[$j] = "0".$jamMulai[$j];
							}
				
							if($menitMulai[$j] < 10 && strlen($menitMulai[$j]) == 1){
								$menitMulai = "$j".$menitMulai;
							}

							if($jamSelesai[$j] < 10 && strlen($jamSelesai[$j]) == 1){
								$jamSelesai[$j] = "$i".$jamSelesai[$j];
							}
				
							if($menitSelesai[$j] < 10 && strlen($menitSelesai[$j]) == 1 ){
								$menitSelesai[$j] = "$i".$menitSelesai[$j];
							}
				
						
							$timeMulai = $jamMulai[$j].":".$menitMulai[$j].":00";
							$timeSelesai = $jamSelesai[$j].":".$menitSelesai[$j].":00";
							

							print_r($timeSelesai);
							$tanggalMulai = $tglMulaiFix." ".$timeMulai;
							$tanggalSelesai = $tglSelesaiFix." ".$timeSelesai;
						
						}
						
						if($insert_id){
							$array_insert = array(
								"kodeEvent" => $insert_id,
								"tanggalMulai" => $tanggalMulai,
								"tanggalSelesai" => $tanggalSelesai
							);
	
							$this->event_baru_model->add_waktu($array_insert);
						}

					}

					
				}else{
					if($jamMulai[0] < 10 && strlen($jamMulai[0]) == 1){
						$jamMulai[0] = "0".$jamMulai[0];
					}
		
					if($menitMulai[0] < 10 && strlen($menitMulai[0]) == 1){
						$menitMulai = "0".$menitMulai;
					}
		
					if($jamSelesai[0] < 10 && strlen($jamSelesai[0]) == 1){
						$jamSelesai[0] = "0".$jamSelesai[0];
					}
		
					if($menitSelesai[0] < 10 && strlen($menitSelesai[0]) == 1 ){
						$menitSelesai[0] = "0".$menitSelesai[0];
					}
		
					$timeMulai = $jamMulai[0].":".$menitMulai[0].":00";
					$timeSelesai = $jamSelesai[0].":".$menitSelesai[0].":00";
	
					$tanggalMulaiEvent = $tanggalMulai." ".$timeMulai;
					$tanggalSelesaiEvent = $tanggalSelesai." ".$timeSelesai;

					if($insert_id){
						$array_insert = array(
							"kodeEvent" => $insert_id,
							"tanggalMulai" => $tanggalMulaiEvent,
							"tanggalSelesai" => $tanggalSelesaiEvent
						);

						$this->event_baru_model->add_waktu($array_insert);
					}
				}

				$success = 0;
				if($insert_id){
					for($i =0; $i< sizeof($alat);$i++){
						$array_insert_alat = array(
							"kodeEvent" => $insert_id,
							"kodeAlat" => $kodeAlat[$i]
						);
	
						$this->event_baru_model->add_alat_event($array_insert_alat);
					}
	
					$this->session->set_flashdata('success', 'Sukses mengajukan event baru!');
					redirect("event/schedule_event");
				}else{
					$this->session->set_flashdata('error', 'Gagal mengajukan event baru!');
					redirect("event/schedule_event");
				}
			}
		}
	}
}
