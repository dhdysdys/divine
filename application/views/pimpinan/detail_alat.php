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
                    <h1 class="mt-4"><b>Detail Report Alat</b></h1>
                    <hr style="border-bottom: solid 2px #e1e1e1;">

                    <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div><br>
                    <?php } ?>

                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div><br>
                    <?php } ?>
                    <br>
                    <table id="tb_alat" class="table table-secondary" >
                        <thead>
                            <tr>
                                <th class="text-center" >ID</th>
                                <th class="text-center" >Nama Alat</th>
                                <th class="text-center" >Harga Alat</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if($data){ ?>
                                <?php for($i =0; $i < count($data);$i++){ ?>
                                    <tr>
                                        <td class="text-center"><?= $data[$i]->id ?></td>
                                        <td><?= $data[$i]->namaAlat ?></td>
                                        <td class="text-center">Rp. <?= $data[$i]->hargaAlat ?></td>
                                    </tr>
                                <?php } ?>        
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table id="tb_total_alat" class="table table table-borderless table-dark" style="width:100%;">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="">Total Alat</label>
                                        <input type="text" disabled id="totalAlat" class="form-control" value="<?=isset($totalAlat)?$totalAlat:""?>">
                                    </div> 
                                </td>
                                <td >
                                    <div class="form-group">
                                        <label for="">Total Pengeluaran</label>
                                        <input type="text" disabled id="totalPengeluaran" class="form-control" value="<?=isset($totalHarga)?"Rp. ".$totalHarga:""?>" >
                                    </div> 
                                </td>
                            </tr>
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
        $("#tb_alat").DataTable()
    } );
</script>