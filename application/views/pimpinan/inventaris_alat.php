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
                                            <td class="text-center" style="color:green;">Accepted</td>
                                        <?php }else if($data[$i]->statusAlat == 2 ){ ?>
                                            <td class="text-center"  style="color:gray;">Not Available</td>
                                        <?php }else if($data[$i]->statusAlat == 3){?> 
                                            <td class="text-center"  style="color:blue;">Available</td>
                                        <?php }else if($data[$i]->statusAlat == 4){ ?>   
                                            <td class="text-center"  style="color:orange;">Rusak</td>
                                        <?php }else{ ?>
                                            <td class="text-center"  style="color:red;">Rejected</td>
                                            
                                        <?php } ?>      
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
    } );
</script>