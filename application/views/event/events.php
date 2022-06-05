<?php $this->load->view('layout/header') ; ?>
<body class="sb-nav-fixed">
    <?php $this->load->view('layout/topbar') ; ?>
  
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php $this->load->view('layout/sidebar') ; ?>
        </div>

        <!-- content -->
        <div id="layoutSidenav_content" class="sb-sidenav-dark" style="margin-left: 200px !important; font-family:'Courier New', monospace;">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><b>EVENTS</b></h1>
                    <hr style="border-bottom: solid 2px #e1e1e1;">

                    <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div><br>
                    <?php } ?>

                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div><br>
                    <?php } ?>
                    <br>
                    <table id="tb_event" class="table table-secondary" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="text-center" >ID</th>
                                <th class="text-center" >Nama Event</th>
                                <th class="text-center" >Tanggal Event</th>
                                <th class="text-center" >Lokasi Event</th>
                                <th class="text-center" >Status Event</th>
                                <th class="text-center" >Rundown</th>
                                <th class="text-center" >Peralatan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if($data){ ?>
                                <?php for($i =0; $i < count($data);$i++){ ?>
                                    <tr>
                                        <td class="text-center"> <?= $data[$i]->kodeEvent ?> </td>
                                        <td class="text-center"> <?= $data[$i]->namaEvent ?> </td>
                                        <td class="text-center"> <?= date_format(date_create($data[$i]->tanggalWaktuMulaiEvent),"d-m-Y") ?> </td>
                                        <td class="text-center"> <?= $data[$i]->lokasiEvent ?> </td>
                                        <td class="text-center">
                                            <?php if($data[$i]->status == 0){?>
                                                <p style="color:gray;font-weight:bold;font-size:1rem;">Waiting for Approval</p>
                                            <?php }else if($data[$i]->status == 1){ ?>
                                                <p style="color:green;font-weight:bold;font-size:1rem;">Accepted</p>
                                            <?php }else if($data[$i]->status == 2){ ?>     
                                                <p style="color:red;font-weight:bold;font-size:1rem;">Rejected</p>  
                                            <?php }else if($data[$i]->status == 3 &&  date_format(date_create($data[$i]->tanggalWaktuMulaiEvent),"d-m-Y") ==  date('d-m-Y')){ ?>
                                                <p style="color:orange;font-weight:bold;font-size:1rem;">On Going</p>
                                            <?php }else{?>
                                                <p style="color:green;font-weight:bold;font-size:1rem;">Done</p>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center"> 
                                            <a href="<?=base_url()?>event/schedule_event/view_rundown/?path=<?=urlencode($data[$i]->rundownEvent)?>" class="btn btn-secondary">Lihat</a>
                                        </td>
                                        <td class="text-center">
                                            <!-- <a href="<?php echo base_url('event/schedule_event/view_peralatan/'.$data[$i]->kodeEvent); ?>" class="btn btn-secondary">Lihat</a> -->
                                            <a href="<?php echo base_url('event/schedule_event/view_peralatan/'.$data[$i]->kodeEvent); ?>" class="btn btn-secondary">Lihat</a>
                                        </td> 
                                    </tr>
                                <?php } ?>        
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
<?php $this->load->view('layout/script_list') ; ?>
<script type="text/javascript">
    $(document).ready( function () {
        $('#tb_event').DataTable();
    } );
</script>