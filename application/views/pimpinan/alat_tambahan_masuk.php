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
                    <h1 class="mt-4"><b>ALAT TAMBAHAN MASUK</b></h1>
                    <hr style="border-bottom: solid 2px #e1e1e1;">

                    <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div><br>
                    <?php } ?>

                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div><br>
                    <?php } ?>
                    <br>
                    <table id="tb_alat" class="table table-secondary" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="text-center" width="50">ID</th>
                                <th class="text-center" width="250">Nama Alat</th>
                                <th class="text-center" width="250">Harga Alat</th>
                                <th class="text-center" width="300">Event</th>
                                <th class="text-center" width="150">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($data){ ?>
                                <?php for($i =0; $i < count($data);$i++){ ?>
                                    <tr>
                                        <td class="text-center"><?= $data[$i]->id ?></td>
                                        <td ><?= $data[$i]->namaAlat ?></td>
                                        <td class="text-center">Rp. <?= $data[$i]->hargaAlat ?></td>
                                        <td><?= $data[$i]->namaEvent ?></td>
                                        <td class="text-center">
                                            <?php if($data[$i]->status == 3){ ?>
                                                <a href="<?php echo base_url('pimpinan/alat_tambahan_masuk/accept/'.$data[$i]->id); ?>" class="btn btn-success">Accept</a>
                                                <a href="<?php echo base_url('pimpinan/alat_tambahan_masuk/reject/'.$data[$i]->id); ?>" class="btn btn-danger">Reject</a>
                                            <?php }else{ ?>
                                                <?php if($data[$i]->status == 1){?> 
                                                    <p style="color:green;font-weight:bold;font-size:1rem;">Accepted</p>
                                                <?php }else if($data[$i]->status == 2){ ?>   
                                                    <p style="color:red;font-weight:bold;font-size:1rem;">Rejected</p>
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
            "url": "http://localhost/divine/pimpinan/alat_masuk/reject",
            "data": {
                "id": $("#kodeAlat").val(),
                "alasan": $('#alasan').val()
            }
        }).done(function (res) {
            console.log(res)
            if(res == "success"){
                alert("Berhasil reject request!")
                window.location.href = "http://localhost/divine/pimpinan/alat_masuk"; 
            }else if(res == "failed"){
                alert("Gagal reject request!")
                window.location.href = "http://localhost/divine/pimpinan/alat_masuk"; 
            }
        })
    }
</script>