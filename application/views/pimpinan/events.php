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
                                            <a href="<?=base_url()?>pimpinan/schedule_event/view_rundown/?path=<?=urlencode($data[$i]->rundownEvent)?>" class="btn btn-secondary">Lihat</a>
                                        </td>
                                        <td class="text-center">
                                            <!-- <a href="<?php echo base_url('pimpinan/schedule_event/view_peralatan/'.$data[$i]->kodeEvent); ?>" class="btn btn-secondary">Lihat</a> -->
                                            <a  id="viewBtn" data-toggle="modal" data-target="#modalAlat" data-id="<?= $data[$i]->kodeEvent?>" style="color:white;" class="btn btn-secondary dataAlat">Lihat</a>
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
    <div class="modal fade" id="modalAlat" tabindex="-1" role="dialog" aria-labelledby="ModalBobot" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReject"><b>Peralatan</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <table class="table table-secondary" id="tableListALat" name="tableListAlat">
                    <thead>
                        <tr>
                            <th class="text-center" >Nama Alat</th>
                            <th class="text-center" >Harga Alat</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</body>
<?php $this->load->view('layout/script_list') ; ?>
<script type="text/javascript">
    $(document).ready( function () {
        $('#tb_event').DataTable();

        $(".data").on("click", function(e){
            const dataEl = e.target;
            $("#kodeEvent").val(dataEl.dataset.id)
        })

        $(".dataAlat").on("click", function(e){
            const dataEl = e.target;
            $.ajax({
                "type": "POST",
                "url": "http://localhost/divine/pimpinan/schedule_event/view_peralatan",
                "data": {
                    "id":dataEl.dataset.id,
                }
            }).done(function (res) {
                console.log(res)
                var result = JSON.parse(res)

                $("#tableListALat").find('tbody').children().remove()
                if(result["error"] == 0){
                    var data = result["data"]

                    for(var i=0;i<data.length;i++){
                        console.log(data[i])
                        $("#tableListALat").find('tbody').append('<tr><td>'+ data[i].namaAlat +'</td> <td class="text-center">Rp. '+ data[i].hargaAlat+'</td></tr>');
                    }
                }else{
                    alert("Gagal mendapatkan data peralatan!")
                }
            })
        })
    } );
</script>