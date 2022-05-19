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
                    <h1 class="mt-4"><b>ALAT MASUK</b></h1>
                    <hr style="border-bottom: solid 2px #e1e1e1;">

                    <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div><br>
                    <?php } ?>

                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div><br>
                    <?php } ?>
                    <br>
                    <table id="tb_alat" class="table table-secondary" style="width:100%; font-size:22px;">
                        <thead>
                            <tr>
                                <th class="text-center" width="50">ID</th>
                                <th class="text-center" width="250">Nama Alat</th>
                                <th class="text-center" width="250">Harga Alat</th>
                                <th class="text-center" width="300">Alasan Pengajuan</th>
                                <th class="text-center" width="150">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($data){ ?>
                                <?php for($i =0; $i < count($data);$i++){ ?>
                                    <tr>
                                        <td class="text-center"><?= $data[$i]->kodeAlat ?></td>
                                        <td ><?= $data[$i]->namaAlat ?></td>
                                        <td class="text-center">Rp. <?= $data[$i]->hargaAlat ?></td>
                                        <td><?= $data[$i]->alasan ?></td>
                                        <td class="text-center">
                                            <?php if($data[$i]->status == 0){ ?>
                                                <a href="<?php echo base_url('pimpinan/alat_masuk/accept/'.$data[$i]->kodeAlat); ?>" class="btn btn-success">Accept</a>
                                                <a  id="rejectBtn" data-toggle="modal" data-target="#rejectModal" data-id="<?= $data[$i]->kodeAlat?>" class="btn btn-danger data">Reject</a>
                                            <?php }else{ ?>
                                                <?php if($data[$i]->status == 1){?> 
                                                    <p style="color:green;font-weight:bold;font-size:1rem;">Accepted</p>
                                                <?php }else{ ?>   
                                                    <button class="btn btn-danger dataNote" data-toggle="modal" data-target="#noteModal" data-note="<?= isset($data)?$data[$i]->alasanReject:""?>"  style="color:black;font-weight:bold;">
                                                    Rejected
                                                    </button>
                                                <?php } ?>       
                                            <?php } ?>     
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

    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="ModalBobot" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReject"><b>Reject Note</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kodeAlat" id="kodeAlat">
                    <div class="form-group">
                        <label for="inputBobot" class="col-sm-6 col-form-label">Alasan reject alat</label>
                        <div class="col-sm-12">
                            <textarea name="alasan" id="alasan" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="ModalBobot" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReject"><b>Reject Note</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputBobot" class="col-sm-6 col-form-label">Alasan reject alat</label>
                        <div class="col-sm-12">
                            <textarea name="alasanNote" id="alasanNote" cols="30" rows="3" class="form-control" readonly></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php $this->load->view('layout/script_list') ; ?>
<script type="text/javascript">
    $(document).ready( function () {
        $('#tb_alat').DataTable();

        $("#btn-submit").on("click", function(){
            reject()
        })

        $(".data").on("click", function(e){
            const dataEl = e.target;
            $("#kodeAlat").val(dataEl.dataset.id)
        })

        $(".dataNote").on("click", function(e){
            const dataEl = e.target;
            $("#alasanNote").val(dataEl.dataset.note)
        })
        
    } );

    function reject(){
        $.ajax({
            "type": "POST",
            "url": "<?=base_url()?>pimpinan/alat_masuk/reject",
            "data": {
                "id": $("#kodeAlat").val(),
                "alasan": $('#alasan').val()
            }
        }).done(function (res) {
            console.log(res)
            if(res == "success"){
                alert("Berhasil reject request!")
                window.location.href = "<?=base_url()?>pimpinan/alat_masuk"; 
            }else if(res == "failed"){
                alert("Gagal reject request!")
                window.location.href = "<?=base_url()?>pimpinan/alat_masuk"; 
            }
        })
    }
</script>