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
			$pengajuan = $this->pengajuan_alat_model->get();
			$alat =$this->inventaris_model->get();
			$listAlat = array();
			$listPengajuan = array();
			$flag = 0;
			$flagRest = 0;

			foreach($pengajuan as $list){
				for($i=0;$i<count($alat);$i++){
					if($list->namaAlat == $alat[$i]->namaAlat){
						$temp = (object) [
							"kodeAlat" => $alat[$i]->kodeAlat,
							"namaAlat" => $alat[$i]->namaAlat,
							"tanggalAlatMasuk" => $alat[$i]->tanggalAlatMasuk,
							"statusAlat" => $alat[$i]->statusAlat
						];
						array_push($listAlat, $temp);
						array_push($listPengajuan, $alat[$i]->namaAlat);
						$flag = 0;
					}else{
						$flag = 1;
						$flagRest = 1;	
					}
				}

				if($flag == 1){
					if($list->status == 2){
						$temp = (object)[
							"kodeAlat" => "-",
							"namaAlat" => $list->namaAlat,
							"tanggalAlatMasuk" => $list->created,
							"statusAlat" => 5
						];
						array_push($listAlat, $temp);
						$flag = 0;
						array_push($listPengajuan, $list->namaAlat);
					}
				}
			}

			if($flagRest == 1){
				for($i=0;$i<count($alat);$i++){
					if(!in_array($alat[$i]->namaAlat, $listPengajuan)){
						$temp = (object) [
							"kodeAlat" => $alat[$i]->kodeAlat,
							"namaAlat" => $alat[$i]->namaAlat,
							"tanggalAlatMasuk" => $alat[$i]->tanggalAlatMasuk,
							"statusAlat" => $alat[$i]->statusAlat
						];
						array_push($listAlat, $temp);
					}
				}
			}

            $data["data"] = $listAlat;
			$this->load->view('inventaris/inventaris_alat', $data);
		}
	}

	public function get_note(){
		$namaAlat = $this->input->post("namaAlat");
		$pengajuan = $this->pengajuan_alat_model->get_reject_note($namaAlat);
		echo $pengajuan[0]->alasanReject;
	}

    public function input_alat($id=null){
        if(!$this->session->userdata('email')){
			redirect("auth");
		}else{
			$data = null;
			$array_status = array(1,2,3,4);
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
        $this->form_validation->set_rules('hargaAlat', 'Harga Alat', 'required|numeric|max_length[10]');
		$this->form_validation->set_rules('hargaRetail', 'Harga Retail', 'required|numeric|max_length[10]');
      
		$id = $this->input->post("kodeAlat");
		if($id!=null){
			if($this->form_validation->run() == FALSE){
				$array_status = array(2,3,4);
				$data['data_alat']=$this->inventaris_model->get($id);
				$data["status_alat"] = $array_status;
				$this->load->view('inventaris/input_alat', $data);
			}else{
				$kodeAlat = $this->input->post("kodeAlat");
				$namaAlat = $this->input->post("namaAlat");
				$tanggalMasuk = $this->input->post("tanggalMasuk");
				$statusAlat = $this->input->post("statusAlat");
				$hargaAlat = $this->input->post("hargaAlat");
				$hargaRetail = $this->input->post("hargaRetail");
	
				$check_harga_retail = $this->inventaris_model->get($id);
				$array_edit = array();

				if($check_harga_retail[0]->hargaRetail == 0){
					$array_edit = array(
						"namaAlat" => $namaAlat,
						"tanggalAlatMasuk" => $tanggalMasuk,
						"statusAlat" => 3,
						"hargaAlat" => $hargaAlat,
						"hargaRetail" => $hargaRetail,
					);
				}else{
					$array_edit = array(
						"namaAlat" => $namaAlat,
						"tanggalAlatMasuk" => $tanggalMasuk,
						"statusAlat" => $statusAlat,
						"hargaAlat" => $hargaAlat,
						"hargaRetail" => $hargaRetail,
					);
				}

				//edit
				$this->inventaris_model->edit_alat($array_edit, $kodeAlat);

				$this->session->set_flashdata('success', 'Sukses edit alat!');
				redirect("inventaris/alat");
			}
		}else{
			if($this->form_validation->run() == FALSE){
				$array_status = array(2,3,4);
				$data["status_alat"] = $array_status;
				$this->load->view('inventaris/input_alat', $data);
			}else{
				$kodeAlat = $this->input->post("kodeAlat");
				$namaAlat = $this->input->post("namaAlat");
				$tanggalMasuk = $this->input->post("tanggalMasuk");
				$statusAlat = $this->input->post("statusAlat");
				$hargaAlat = $this->input->post("hargaAlat");
				$hargaRetail = $this->input->post("hargaRetail");
	
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
				redirect("inventaris/alat");
			}
		}
		
    }

	public function delete($id){
		if($id != NULL && $id != "-"){
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
        $this->form_validation->set_rules('hargaAlat', 'Harga Alat', 'required|numeric|max_length[10]');
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
