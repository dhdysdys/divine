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
                    <h1 class="mt-4"><b>INPUT ALAT</b></h1>
                    <hr style="border-bottom: solid 2px #e1e1e1;">
                    <br>
                    <?php echo form_open('inventaris/alat/alat_submit'); ?> 
                    <input type="hidden" id="kodeAlat" name="kodeAlat" value="<?=isset($data_alat)?$data_alat[0]->kodeAlat:""?>">
                    <div class="form-group">
                        <label for="namaAlat"><b>Nama Alat</b></label>
                        <input type="text" class="form-control col-5" name="namaAlat" id="namaAlat" autocomplete="off" value="<?=isset($data_alat)?$data_alat[0]->namaAlat:""?>">
                        <?php echo form_error('namaAlat'); ?>
                    </div>
                    <div class="form-group">
                        <label for="tanggalMasuk"><b>Tanggal Alat Masuk</b></label>
                        <input type="text" class="form-control col-5" name="tanggalMasuk" id="tanggalMasuk" autocomplete="off" placeholder="yyyy-mm-dd" value="<?=isset($data_alat)?$data_alat[0]->tanggalAlatMasuk:""?>">
                        <?php echo form_error('tanggalMasuk'); ?>
                    </div>
                    <div class="form-group">
                        <label for="statusAlat"><b>Status Alat</b></label>
                        <select name="statusAlat" id="statusAlat" class="form-control col-5">
                            <?php for($i=1;$i < count($status_alat);$i++){ ?>
                                <option value="<?= $status_alat[$i]?>" <?= isset($data_alat) && $data_alat[0]->statusAlat == $status_alat[$i]?" selected":"" ?> > 
                                    <?php if($status_alat[$i] == 2) echo "Not Available";?>
                                    <?php if($status_alat[$i] == 3) echo "Available";?>
                                    <?php if($status_alat[$i] == 4) echo "Rusak";?>
                                </option>
                            <?php } ?>
                        </select>
                        <?php echo form_error('statusAlat'); ?>
                    </div>
                    <div class="form-group">
                        <label for="hargaAlat"><b>Harga Alat</b></label>
                        <input type="text" class="form-control col-5" name="hargaAlat" id="namaAlat" autocomplete="off" value="<?=isset($data_alat)?$data_alat[0]->hargaAlat:""?>">
                        <?php echo form_error('hargaAlat'); ?>
                    </div>
                    <div class="form-group">
                        <label for="hargaRetail"><b>Harga Retail</b></label>
                        <input type="text" class="form-control col-5" name="hargaRetail" id="hargaRetail" autocomplete="off" value="<?=isset($data_alat)?$data_alat[0]->hargaRetail:""?>">
                        <?php echo form_error('hargaRetail'); ?>
                    </div>
                    <br>
                    <button type="submit" name= "submit" id="save" class="btn btn-success"><b>Save</b></button> 
                    <a type="button" href="<?php echo base_url('inventaris/alat'); ?>" class="btn btn-danger"> <b>Cancel</b></a>

                    <?php if($this->session->flashdata('add_alat_error')) echo $this->session->flashdata('add_alat_error'); ?>
                    <?php form_close(); ?>

                </div>
            </main>
        </div>
    </div>
</body>
<?php $this->load->view('layout/script_list') ; ?>
<script>
    $(document).ready(function () {
        $("#tanggalMasuk").datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>
