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
                    <h1 class="mt-4"><b>INVENTARIS ALAT</b></h1>
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
                                <th class="text-center" width="300">Nama Alat</th>
                                <th class="text-center" width="250">Tanggal Alat Masuk</th>
                                <th class="text-center" width="250">Status Alat</th>
                                <th class="text-center" width="150">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($data){ ?>
                                <?php for($i =0; $i < count($data);$i++){ ?>
                                    <tr>
                                        <td class="text-center"><?= $data[$i]->kodeAlat ?></td>
                                        <td><?= $data[$i]->namaAlat ?></td>
                                        <td class="text-center"><?= date_format(date_create($data[$i]->tanggalAlatMasuk),"d-m-Y")?></td>
                                        <?php if($data[$i]->statusAlat == 1){ ?>
                                            <td class="text-center" style="color: green;"><b>Accepted</b></td>
                                        <?php }else if($data[$i]->statusAlat == 2){ ?>
                                            <td class="text-center"  style="color: gray;"><b>Not Available</b></td>
                                        <?php }else if($data[$i]->statusAlat == 3){?> 
                                            <td class="text-center"  style="color: blue;"><b>Available</b></td>
                                        <?php }else if($data[$i]->statusAlat == 4){ ?>   
                                            <td class="text-center"  style="color: orange;"><b>Rusak</b></td>
                                        <?php }else if($data[$i]->statusAlat == 5){ ?>
                                            <td class="text-center"  style="color: red;"><b>Rejected</b></td>
                                        <?php }?>
                                        <td class="text-center">
                                            <?php if($data[$i]->statusAlat != 5){?>
                                                <a href="<?php echo base_url('inventaris/alat/input_alat/'.$data[$i]->kodeAlat); ?>" class="btn btn-secondary">Edit</a>
                                                <a onclick="return confirm(' Apakah anda yakin untuk menghapus data?')" href="<?php echo base_url('inventaris/alat/delete/'.$data[$i]->kodeAlat); ?>" class="btn btn-danger">Delete</a>
                                            <?php }else{ ?>
                                                <p style="word-wrap: break-word; width:250px;"><?= $data[$i]->alasan?></p>
                                                <!-- <button id="btnNote" class="btn btn-warning dataNote"  data-toggle="modal" data-target="#noteModal" data-id="<?= $data[$i]->namaAlat?>">
                                                    Note
                                                </button> -->
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
                            <input type="hidden" id="namaalat" name="namaalat">
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
        $('#tb_alat').DataTable({
            order: [0, "desc"]
        });

        $("#btnNote").on("click", function(event){
            var dataEl= event.target
            $("#namaalat").val(dataEl.dataset.id)
            get_note()
        })

        // $(".dataNote").on("click", function(e){
        //     const dataEl = e.target;
        //     $("#alasanNote").val(dataEl.dataset.note)
        // })
        
        // $("#nodetBtn").on("click", function(e){
        //     var dataEl = e.target

        //     console.log(dataEl.dataset.id)
        // })
        

        // $(".data").on("click", function(e){
        //     const dataEl = e.target;
        //     console.log(dataEl.dataset.id)
        //     $.ajax({
        //         "type": "POST",
        //         "url": "http://localhost/divine/inventaris/alat/get_note",
        //         "data": {
        //             "namaAlat": dataEl.dataset.id,
        //         }
        //     }).done(function (res) {
        //         $("#alasanNote").val(res)
        //     })
        // })
    } );

    function get_note(){
        console.log($("#namaalat").val())
        $.ajax({
            "type": "POST",
            "url": "http://localhost/divine/inventaris/alat/get_note",
            "data": {
                "namaAlat": $("#namaalat").val(),
            }
        }).done(function (res) {
            $("#alasanNote").val(res)
        })
    }
</script>