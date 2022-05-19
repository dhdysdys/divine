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
                    <h1 class="mt-4"><b>USERS</b></h1>
                    <hr style="border-bottom: solid 2px #e1e1e1;">
                    <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div><br>
                    <?php } ?>
                    <br>
                    <table id="tb_user" class="table table-secondary" style="width:100%;font-size:22px;">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Register Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($data){ ?>
                                <?php for($i =0; $i < count($data);$i++){ ?>
                                    <tr>
                                        <td class="text-center"><?= $data[$i]->kodeAdmin ?></td>
                                        <td><?= $data[$i]->namaUser ?></td>
                                        <td><?= $data[$i]->email ?></td>
                                    
                                        <?php if($data[$i]->role == 1){ ?>
                                            <td class="text-center">Inventaris</td>
                                        <?php }else if($data[$i]->role == 2){ ?>
                                            <td class="text-center">Pimpinan</td>
                                        <?php }else if($data[$i]->role == 3){ ?>     
                                            <td class="text-center">Event</td>
                                        <?php } ?>  
                                        <td class="text-center"><?= $data[$i]->registerDate ?> </td>
                                        <td class="text-center">
                                            <!-- <button class="data" data-toggle="modal" data-target="#confirmationModal" data-id="<?= $data[$i]->kodeAdmin?>" data-dismiss="modal">Delete</button> -->
                                            <a  onclick="return confirm(' Apakah anda yakin untuk menghapus data?')" href="<?php echo base_url('admin/user/delete/'.$data[$i]->kodeAdmin); ?>" class="btn btn-danger">Delete</a>
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

    <!-- <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" >
        <div class="modal-dialog  modal-dialog-centered " role="document">
            <div class="modal-content" style="background-color:black;color:white; box-shadow: 5px 10px white;">
                <br>
                <div class="modal-body" >
                    <center>
                        <p style="font-family:'Courier New', monospace; font-size: 25px;">Apakah anda yakin untuk menghapus data?</p>
                    </center>
                </div>
                <center>
                    <input type="hidden" id="delete">
                    <button class="btn btn-secondary btn-lg" style="font-family:'Courier New', monospace; font-size: 20px;" type="submit" id="submit">Delete</button>
                    <button class="btn btn-secondary btn-lg" style="font-family:'Courier New', monospace; font-size: 20px;" type="button" data-dismiss="modal" data-toggle="modal">Cancel</button>
                </center>
                <br>
            </div>
        </div>
    </div> -->

</body>
<?php $this->load->view('layout/script_list') ; ?>
<script type="text/javascript">
    $(document).ready( function () {
        $('#tb_user').DataTable();
    });
</script>