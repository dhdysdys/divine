<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alat_masuk extends CI_Controller {

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
    }

	public function index(){
		if(!$this->session->userdata('email')){
			redirect("auth");
		}else{
            $data = null;
            $data["data"] =  $this->pengajuan_alat_model->get_list();

			$this->load->view('pimpinan/alat_masuk', $data);
		}
	}

	public function accept($id){
		if($id !=NULL){
			$detail = $this->pengajuan_alat_model->get($id);
			$data = array(
				"status" => 1
			);

			$this->pengajuan_alat_model->edit_pengajuan($data, $id);

			$array_insert = array(
				"namaAlat" => $detail[0]->namaAlat,
				"tanggalAlatMasuk" => date("Y-m-d"),
				"statusAlat" => 1,
				"hargaAlat" => $detail[0]->hargaAlat,
			);

			$this->inventaris_model->add_alat($array_insert);

			$this->session->set_flashdata('success',  'Alat '.$detail[0]->namaAlat.' telah diaccept!');
            redirect('pimpinan/alat_masuk');
		}else{
			$this->session->set_flashdata('error', "Accept alat error!");
            redirect('pimpinan/alat_masuk');
		}
	}

	public function reject(){
		$id = $this->input->post("id");
		$alasan = $this->input->post("alasan");

		if($id != NULL){
			$array_update = array(
				"alasanReject" => $alasan,
				"status" => 2
			);

			$this->pengajuan_alat_model->edit_pengajuan($array_update, $id);
			echo "success";
		}else{
			echo "failed";
		}
	}
}
