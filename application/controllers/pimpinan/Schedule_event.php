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
		$this->load->library(['form_validation','session','pdf']);
		$this->load->model('event_baru_model');
		$this->load->model('inventaris_model');
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

	public function view_peralatan($id){
		$data = array();
		$alat = array();

		$get_list = $this->event_baru_model->get_list_alat($id);
		$get_nama_event = $this->event_baru_model->get($id);

		$no = 1;
		if($get_list){
			for($i=0;$i<count($get_list);$i++){
				$details = $this->inventaris_model->get($get_list[$i]->kodeAlat);
				
				foreach($details as $l){
					$temp = (object)[
						"no" => $no,
						"namaAlat" => $l->namaAlat,
						"hargaAlat" => $l->hargaRetail
					];
					$no++;
					array_push($alat, $temp);
				}	
			}
		}

		$url = "http://" . $_SERVER['SERVER_NAME'];
		$path_img = $url."/divine/public/assets/img/divine.png";

		$pdf = new FPDF('P','mm','A4');
		$pdf->AddPage();

		//sett logo
		$pdf->Image($path_img,10,10,-700);
		$pdf->Cell(10,7,'',0,1); //next line
		$pdf->Cell(10,7,'',0,1);

		//title
		$pdf->SetFont('Arial','BU',16);
		$pdf->Cell(80);
		$pdf->Cell(70,10,'Peralatan');
		
		$pdf->Cell(10,7,'',0,1); //next line
		$pdf->Cell(10,7,'',0,1);

		//nama event
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(10);
		$pdf->Cell(10,7,'Event			:'."   ".$get_nama_event[0]->namaEvent);

		$pdf->Cell(10,7,'',0,1); //next line

		//table
		$header = array('No. ', 'Nama', 'Harga');
		// Colors, line width and bold font
		$pdf->SetFillColor(0,0,0);
		$pdf->SetTextColor(255);
		$pdf->SetDrawColor(0,0,0);
		$pdf->SetLineWidth(.3);
		$pdf->SetFont('Arial','B');

		// Header
		$pdf->Cell(10);
		$w = array(15, 100, 50);
		for($i=0;$i<count($header);$i++)
			$pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
		$pdf->Ln();
		// Color and font restoration
		$pdf->SetFillColor(255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('');

		// Data alat
		$pdf->Cell(10);
		$dataAlat = $alat;
		$w = array(15, 100, 50);
		foreach($dataAlat as $row){
			$pdf->Cell($w[0],7,$row->no,1,0,'C',true);
			$pdf->Cell($w[1],7,$row->namaAlat,1,0,'L',true);
			$pdf->Cell($w[2],7,'Rp. '.$row->hargaAlat,1,0,'C',true);
			$pdf->Ln();
			$pdf->Cell(10);
		}
		$pdf->SetFillColor(255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('');
		$pdf->Output("D", "Peralatan_event_".$get_nama_event[0]->namaEvent.".pdf", true);
	}
}
