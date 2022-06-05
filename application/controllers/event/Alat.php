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

	public function pengajuan_submit(){
		$this->form_validation->set_rules('namaAlatInput[]', 'Nama Alat', 'required');
		$this->form_validation->set_rules('hargaAlatInput[]', 'Harga Alat', 'required');
		if($this->form_validation->run() == FALSE){
			$this->load->view('event/pengajuan_alat');
        }else{
			$alat = $this->input->post("namaAlatInput");
			$kodeAlat = $this->input->post("kodeAlatInput");
			$harga = $this->input->post("hargaAlatInput");
		
			// $array_insert = array(
			// 	"namaAlat" => $namaAlat,
			// 	"hargaAlat" => $hargaAlat,
			// 	"alasan" => $alasan,
			// 	"status" => 0
			// ); 

			// $this->pengajuan_alat_model->add_pengajuan($array_insert);
			// $this->session->set_flashdata('success', 'Sukses mengajukan alat baru!');
			// redirect("inventaris/alat");
		}
	
	}
}
