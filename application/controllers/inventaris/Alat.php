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
    }

	public function index(){
		if(!$this->session->userdata('email')){
			redirect("auth");
		}else{
            $data["data"] = $this->inventaris_model->get();
			$this->load->view('inventaris/inventaris_alat', $data);
		}
	}

    public function input_alat($id=null){
        if(!$this->session->userdata('email')){
			redirect("auth");
		}else{
			$data = null;
			$array_status = array(1,2,3);
			$data["status_alat"] = $array_status;
			if($id != null){
				$data['data_alat']=$this->inventaris_model->get($id);
			}

			$this->load->view('inventaris/input_alat', $data);
		}
    }

    public function alat_submit(){
		$this->form_validation->set_rules('namaAlat', 'Nama Alat', 'required');
        $this->form_validation->set_rules('tanggalMasuk', 'Tanggal Masuk', 'required');
        $this->form_validation->set_rules('statusAlat', 'Status Alat', 'required');
        $this->form_validation->set_rules('hargaAlat', 'Harga Alat', 'required|numeric');
		$this->form_validation->set_rules('hargaRetail', 'Harga Retail', 'required|numeric');
      
		if($this->form_validation->run() == FALSE){
			$array_status = array(1,2,3);
			$data["status_alat"] = $array_status;
            $this->load->view('inventaris/input_alat', $data);
        }else{
			$kodeAlat = $this->input->post("kodeAlat");
			$namaAlat = $this->input->post("namaAlat");
			$tanggalMasuk = $this->input->post("tanggalMasuk");
			$statusAlat = $this->input->post("statusAlat");
			$hargaAlat = $this->input->post("hargaAlat");
			$hargaRetail = $this->input->post("hargaRetail");

			if($this->input->post("kodeAlat")){
				//edit data alat
				$array_edit = array(
					"namaAlat" => $namaAlat,
					"tanggalAlatMasuk" => $tanggalMasuk,
					"statusAlat" => $statusAlat,
					"hargaAlat" => $hargaAlat,
					"hargaRetail" => $hargaRetail,
				);

				$this->inventaris_model->edit_alat($array_edit, $kodeAlat);

                $this->session->set_flashdata('success', 'Sukses edit alat!');
			}else{
				//insert data alat
				$array_insert = array(
					"namaAlat" => $namaAlat,
					"tanggalAlatMasuk" => $tanggalMasuk,
					"statusAlat" => $statusAlat,
					"hargaAlat" => $hargaAlat,
					"hargaRetail" => $hargaRetail,
				);

				$this->inventaris_model->add_alat($array_insert);

                $this->session->set_flashdata('success', 'Sukses input alat!');
			}
			redirect("inventaris/alat");
		}
    }

	public function delete($id){
		if($id != NULL){
            $this->inventaris_model->delete_alat($id);
            $this->session->set_flashdata('success', 'Sukses delete alat!');
            redirect('inventaris/alat');
        }	
	}

	public function pengajuan_alat(){
		if(!$this->session->userdata('email')){
			redirect("auth");
		}else{
			$this->load->view('inventaris/pengajuan_alat');
		}
	}

	public function pengajuan_submit(){
		$this->form_validation->set_rules('namaAlat', 'Nama Alat', 'required');
        $this->form_validation->set_rules('hargaAlat', 'Harga Alat', 'required|numeric');
		$this->form_validation->set_rules('alasan', 'Alasan Pengajuan', 'required');

		if($this->form_validation->run() == FALSE){
			$this->load->view('inventaris/pengajuan_alat');
        }else{
			$namaAlat = $this->input->post("namaAlat");
			$hargaAlat = $this->input->post("hargaAlat");
			$alasan = $this->input->post("alasan");

			$check_alat = $this->pengajuan_alat_model->check_alat($namaAlat);
		
			$array_insert = array(
				"namaAlat" => $namaAlat,
				"hargaAlat" => $hargaAlat,
				"alasan" => $alasan,
				"status" => 0
			); 

			$this->pengajuan_alat_model->add_pengajuan($array_insert);
			$this->session->set_flashdata('success', 'Sukses mengajukan alat baru!');
			redirect("inventaris/alat");
		}
	
	}
}
