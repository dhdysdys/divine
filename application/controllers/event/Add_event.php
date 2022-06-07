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
			$data["alat"] = $this->inventaris_model->get_available();
			$this->load->view('event/add_event', $data);
		}
	}

	public function submit(){
		$this->form_validation->set_rules('namaEvent', 'Nama Event', 'required');
        $this->form_validation->set_rules('namaClient', 'Nama Client', 'required');
        $this->form_validation->set_rules('tanggalEvent', 'Tanggal Event', 'required');
        $this->form_validation->set_rules('jamEventMulai', 'Waktu Mulai', 'required|numeric');
		$this->form_validation->set_rules('menitEventMulai', 'Waktu Mulai', 'required|numeric');
		$this->form_validation->set_rules('jamEventSelesai', 'Waktu Mulai', 'required|numeric');
		$this->form_validation->set_rules('menitEventSelesai', 'Waktu Mulai', 'required|numeric');
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
			$tanggalEvent = $this->input->post("tanggalEvent");
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

			if($jamMulai < 10 && strlen($jamMulai) == 1){
				$jamMulai = "0".$jamMulai;
			}

			if($menitMulai < 10 && strlen($menitMulai) == 1){
				$menitMulai = "0".$menitMulai;
			}

			if($jamSelesai < 10 && strlen($jamSelesai) == 1){
				$jamSelesai = "0".$jamSelesai;
			}

			if($menitSelesai < 10 && strlen($menitSelesai) == 1 ){
				$menitSelesai = "0".$menitSelesai;
			}

			$timeMulai = $jamMulai.":".$menitMulai.":00";
			$timeSelesai = $jamSelesai.":".$menitSelesai.":00";

			$tanggalMulai = $tanggalEvent." ".$timeMulai;
			$tanggalSelesai = $tanggalEvent." ".$timeSelesai;

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
					"tanggalWaktuMulaiEvent" => $tanggalMulai,
					"tanggalWaktuSelesaiEvent" => $tanggalSelesai,
					"lokasiEvent" => $lokasi,
					"rundownEvent" => $filename,
					"totalHarga" => $totalHarga,
					"hargaKesepakatan" => $hargaKesepakatan,
					"status" => 0
				);

				$insert_id = $this->event_baru_model->add_event($array_insert);
	
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
