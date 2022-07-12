<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

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
		$this->load->library(['form_validation','session', 'pdf']);
        $this->load->model('inventaris_model');
		$this->load->model('event_baru_model');
		$this->load->model('pengajuan_alat_model');
    }

	public function index(){
		if(!$this->session->userdata('email')){
			redirect("auth");
		}else{
            $data["data"] = $this->inventaris_model->get();
			$this->load->view('pimpinan/report', $data);
		}
	}

	public function get_event_report(){
		$start_date = $this->input->post("start_date");
		$end_date = $this->input->post("end_date");

		$data = array();
		$totalHarga = 0;
		$totalEvent = 0;
		$curr_event = [];
		$curr_harga = [];

		$startDate = "CAST('".$start_date."' AS DATETIME)";
		$endDate = "CAST('".$end_date."' AS DATETIME)";

		$where = "tanggalWaktuMulaiEvent >= ".$startDate." AND tanggalWaktuSelesaiEvent <=".$endDate." AND status = 1";

		$get_event = $this->event_baru_model->get_list_event($where);

		foreach($get_event as $list){
			array_push($curr_event, $list->kodeEvent);
			array_push($curr_harga, $list->totalHarga);
		}

		$totalEvent = sizeof($curr_event);
		$totalHarga = array_sum($curr_harga);

		foreach($get_event as $list){
			$temp = (object)[
				"id" => $list->kodeEvent,
				"namaEvent"	=> $list->namaEvent,
				"lokasi" => $list->lokasiEvent,
				"rundownEvent" => urlencode($list->rundownEvent),
				"kodeEvent" => $list->kodeEvent,
				"totalHarga" => $list->totalHarga,
				"totalEvent" => $totalEvent,
				"totalHargaAll" => $totalHarga
			];

			array_push($data, $temp);
		}

		$output = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => sizeof($get_event),
			"recordsFiltered" => sizeof($get_event),
			"data" => $data
		);
		
		echo json_encode($output);
	}

	public function get_alat_report(){
		$start_date = $this->input->post("start_date");
		$end_date = $this->input->post("end_date");

		$data = array();
		$totalHarga = 0;
		$totalAlat = 0;
		$curr_alat = [];
		$curr_harga = [];

		$startDate = "CAST('".$start_date."' AS DATETIME)";
		$endDate = "CAST('".$end_date."' AS DATETIME)";

		$where = "tanggalAlatMasuk >= ".$startDate." AND tanggalAlatMasuk <=".$endDate;

		$get_alat = $this->inventaris_model->get_list_alat($where);

		foreach($get_alat as $list){
			array_push($curr_alat, $list->kodeAlat);
			array_push($curr_harga, $list->hargaAlat);
		}

		$totalAlat = sizeof($curr_alat);
		$totalHarga = array_sum($curr_harga);

		foreach($get_alat as $list){
			$temp = (object)[
				"id" => $list->kodeAlat,
				"namaAlat"	=> $list->namaAlat,
				"hargaAlat" => $list->hargaAlat,
				"totalAlat" => $totalAlat,
				"totalHargaAll" => $totalHarga
			];

			array_push($data, $temp);
		}

		$output = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => sizeof($get_alat),
			"recordsFiltered" => sizeof($get_alat),
			"data" => $data
		);
		
		echo json_encode($output);
	}

	public function get_inventaris_report($start_date, $end_date){
		$data = array();
		$dataTotal = array();

		$startDate = "CAST('".$start_date."' AS DATETIME)";
		$endDate = " CAST('".$end_date."' AS DATETIME)";

		$where1 = "tanggalAlatMasuk >= ".$startDate." AND tanggalAlatMasuk <=".$endDate;
		$where2 = "tanggalAlatMasuk >= ".$startDate." AND tanggalAlatMasuk <=".$endDate." AND statusAlat = 4";
	
		$get_alat = $this->inventaris_model->get_list_alat($where1);

		$get_alat_rusak = $this->inventaris_model->get_list_alat($where2);
		
		$totalAlat = sizeof($get_alat);
		$totalAlatRusak = sizeof($get_alat_rusak);
		$no = 1;

		foreach($get_alat_rusak as $list ){
			$temp = (object)[
				"no" => $no,
				"id" => $list->kodeAlat,
				"namaAlat" => $list->namaAlat,
				"status" => "Rusak"
			];
			$no++;

			array_push($data, $temp);
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
		$pdf->Cell(70);
		$pdf->Cell(70,10,'Report Alat Rusak');

		$pdf->Cell(10,7,'',0,1); //next line
		$pdf->Cell(10,7,'',0,1);
		
		//report time
		$pdf->SetFont('Arial','U',16);
		$pdf->Cell(10);
		$pdf->Cell(10,7,'Report Time');
		$pdf->Cell(10,7,'',0,1);

		//startdate
		$startdate = date_format(date_create($start_date),"d F Y");
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(10);
		$pdf->Cell(10,7,'From			:'."   ".$startdate);

		$pdf->Cell(10,7,'',0,1); //next line

		//enddate
		$enddate = date_format(date_create($end_date),"d F Y");
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(10);
		$pdf->Cell(10,7,'To				   :'."   ".$enddate);
		$pdf->Cell(10,7,'',0,1); //next line
		$pdf->Cell(10,7,'',0,1);

		//jumlah alat rusak
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(10);
		$pdf->Cell(10,7,'Jumlah Alat Rusak');

		$pdf->Cell(10,7,'',0,1); //next line

		$totalRow = 0;

		//table
		$header = array('Jumlah Alat', 'Jumlah Alat Rusak');
		// Colors, line width and bold font
		$pdf->SetFillColor(0,0,0);
		$pdf->SetTextColor(255);
		$pdf->SetDrawColor(0,0,0);
		$pdf->SetLineWidth(.3);
		$pdf->SetFont('Arial','B');

		// Header jumlah alat
		$pdf->Cell(10);
		$w = array(90, 90);
		for($i=0;$i<count($header);$i++)
			$pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
		$pdf->Ln();
		// Color and font restoration
		$pdf->SetFillColor(255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('');

		// Data jumlah alat
		$pdf->Cell(10);
		$dataTotal = array($totalAlat, $totalAlatRusak);
		$w = array(90, 90);
		for($i=0;$i<count($dataTotal);$i++)
			$pdf->Cell($w[$i],7,$dataTotal[$i],1,0,'C',true);
			$totalRow++;
		$pdf->Ln();
		// Color and font restoration
		$pdf->SetFillColor(255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('');

		$pdf->Cell(10,7,'',0,1); //next line
		$pdf->Cell(10,7,'',0,1);

		//deskripsi alat rusak
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(10);
		$pdf->Cell(10,7,'Deskripsi Alat Rusak');

		$pdf->Cell(10,7,'',0,1); //next line

		//table deskrpsi
		$headerDesc = array('No. ', 'ID', 'Nama Alat', 'Status Alat');
		// Colors, line width and bold font
		$pdf->SetFillColor(0,0,0);
		$pdf->SetTextColor(255);
		$pdf->SetDrawColor(0,0,0);
		$pdf->SetLineWidth(.3);
		$pdf->SetFont('Arial','B');

		// Header desc
		$pdf->Cell(10);
		$w = array(15, 15, 100, 50);
		for($i=0;$i<count($headerDesc);$i++)
			$pdf->Cell($w[$i],7,$headerDesc[$i],1,0,'C',true);
		$pdf->Ln();
		// Color and font restoration
		$pdf->SetFillColor(255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('');

		// Data desc
		$pdf->Cell(10);
		$dataAlat = $data;
		$w = array(15, 15, 100, 50);
		
		foreach($dataAlat as $row){
			$pdf->Cell($w[0],7,$row->no,1,0,'C',true);
			$pdf->Cell($w[1],7,$row->id,1,0,'C',true);
			$pdf->Cell($w[2],7,$row->namaAlat,1,0,'L',true);
			$pdf->Cell($w[3],7,$row->status,1,0,'C',true);
			$pdf->Ln();
			$pdf->Cell(10);
			$totalRow++;
		}
		$pdf->SetFillColor(255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('');

		$tz = 'Asia/Jakarta';
		$timestamp = time();
		$dt = new DateTime("now", new DateTimeZone($tz)); 
		$dt->setTimestamp($timestamp);
		$todayDate =  $dt->format('d/m/Y');
		$todayTime =  $dt->format('H:i');

		if($totalRow >= 3){
			$pdf->Ln(108);
		}else{
			$pdf->Ln(130);
		}

		$pdf->Cell(180);
		$pdf->Cell(10,7,'Dicetak Oleh: '.$this->session->userdata('nama'),0, 0, 'R' );
		$pdf->Cell(10,7,'',0,1);
		$pdf->Cell(180);
		$pdf->Cell(10,7,'Tangal cetak: '.$todayDate, 0, 0, 'R' );
		$pdf->Cell(10,7,'',0,1);
		$pdf->Cell(180);
		$pdf->Cell(10,7,'Waktu cetak: '.$todayTime, 0, 0, 'R' );
		$pdf->Output("D", "Report_Alat_Rusak.pdf", true);
	}

	public function get_most_used_report($start_date, $end_date){
		$data = array();
		$dataTotal = array();
		$curr_kodeEvent = array();

		$startDate = "CAST('".$start_date."' AS DATETIME)";
		$endDate = "CAST('".$end_date."' AS DATETIME)";

		$where = "tanggalWaktuMulaiEvent >= ".$startDate." AND tanggalWaktuSelesaiEvent <=".$endDate;

		$get_event = $this->event_baru_model->get_list_event($where);

		foreach($get_event as $list){
			array_push($curr_kodeEvent, $list->kodeEvent);
		}

		$get_alat = $this->event_baru_model->get_most_used($curr_kodeEvent);

		$no = 1;

		foreach($get_alat as $list){
			$get_nama_alat = $this->inventaris_model->get($list->kodeAlat)[0];
			$temp = (object)[
				"no" => $no,
				"id" => $list->kodeAlat,
				"namaAlat" => $get_nama_alat->namaAlat,
				"used" => $list->jumlah
			];

			$no++;

			array_push($data, $temp);
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
		$pdf->Cell(70);
		$pdf->Cell(70,10,'Report Most Used Item(s)');

		$pdf->Cell(10,7,'',0,1); //next line
		$pdf->Cell(10,7,'',0,1);

		//report time
		$pdf->SetFont('Arial','U',16);
		$pdf->Cell(10);
		$pdf->Cell(10,7,'Report Time');
		$pdf->Cell(10,7,'',0,1);
		
		//startdate
		$startdate = date_format(date_create($start_date),"d F Y");
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(10);
		$pdf->Cell(10,7,'From			:'."   ".$startdate);

		$pdf->Cell(10,7,'',0,1); //next line

		//enddate
		$enddate = date_format(date_create($end_date),"d F Y");
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(10);
		$pdf->Cell(10,7,'To		   		:'."   ".$enddate);

		$pdf->Cell(10,7,'',0,1); //next line
		$pdf->Cell(10,7,'',0,1);

		//Most used title
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(10);
		$pdf->Cell(10,7,'Most Used Item(s)');

		$pdf->Cell(10,7,'',0,1); //next line

		//table most used
		$headerDesc = array('No. ', 'ID', 'Nama Alat', 'Frekuensi Penggunaan');
		// Colors, line width and bold font
		$pdf->SetFillColor(0,0,0);
		$pdf->SetTextColor(255);
		$pdf->SetDrawColor(0,0,0);
		$pdf->SetLineWidth(.3);
		$pdf->SetFont('Arial','B');

		// Header most used
		$pdf->Cell(10);
		$w = array(15, 15, 100, 50);
		for($i=0;$i<count($headerDesc);$i++)
			$pdf->Cell($w[$i],7,$headerDesc[$i],1,0,'C',true);
		$pdf->Ln();
		// Color and font restoration
		$pdf->SetFillColor(255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('');

		// Data most used
		$pdf->Cell(10);
		$dataAlat = $data;
		$w = array(15, 15, 100, 50);
		$totalRow = 0;
		foreach($dataAlat as $row){
			$pdf->Cell($w[0],7,$row->no,1,0,'C',true);
			$pdf->Cell($w[1],7,$row->id,1,0,'C',true);
			$pdf->Cell($w[2],7,$row->namaAlat,1,0,'L',true);
			$pdf->Cell($w[3],7,$row->used,1,0,'C',true);
			$pdf->Ln();
			$pdf->Cell(10);
			$totalRow++;
		}
		$pdf->SetFillColor(255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('');

		$tz = 'Asia/Jakarta';
		$timestamp = time();
		$dt = new DateTime("now", new DateTimeZone($tz)); 
		$dt->setTimestamp($timestamp);
		$todayDate =  $dt->format('d/m/Y');
		$todayTime =  $dt->format('H:i');

		if($totalRow >= 5){
			$pdf->Ln(108);
		}else{
			$pdf->Ln(130);
		}

		$pdf->Cell(180);
		$pdf->Cell(10,7,'Dicetak Oleh: '.$this->session->userdata('nama'),0, 0, 'R' );
		$pdf->Cell(10,7,'',0,1);
		$pdf->Cell(180);
		$pdf->Cell(10,7,'Tangal cetak: '.$todayDate, 0, 0, 'R' );
		$pdf->Cell(10,7,'',0,1);
		$pdf->Cell(180);
		$pdf->Cell(10,7,'Waktu cetak: '.$todayTime, 0, 0, 'R' );
		$pdf->Output("D", "Report_Most_Used_Items.pdf", true);
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

		$get_list = $this->event_baru_model->get_list_alat_accepted($id);
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
		$pdf->Cell(10,10,'Peralatan');
		
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
