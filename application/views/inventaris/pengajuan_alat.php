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
                    <h1 class="mt-4"><b>PENGAJUAN ALAT BARU</b></h1>
                    <hr style="border-bottom: solid 2px #e1e1e1;">
                    <br>
                    <?php echo form_open('inventaris/alat/pengajuan_submit'); ?> 
                    <div class="form-group">
                        <label for="namaAlat"><b>Nama Alat</b></label>
                        <textarea name="namaAlat" type="text"  class="form-control col-5"  id="namaAlat" cols="10" rows="2"></textarea>
                        <!-- <input type="text" class="form-control col-5" name="namaAlat" id="namaAlat" autocomplete="off"> -->
                        <?php echo form_error('namaAlat'); ?>
                    </div>
                    <div class="form-group">
                        <label for="hargaAlat"><b>Harga Alat</b></label>
                        <input type="text" class="form-control col-5" name="hargaAlat" id="hargaAlat" autocomplete="off">
                        <?php echo form_error('hargaAlat'); ?>
                    </div>
            
                    <div class="form-group">
                        <label for="alasan"><b>Alasan Pengajuan</b></label>
                        <textarea name="alasan" class="form-control col-5" id="alasan" cols="10" rows="5"></textarea>
                        <?php echo form_error('alasan'); ?>
                    </div>
                    
                    <button type="submit" name= "submit" id="save" class="btn btn-primary"><b>Request</b></button> 
                    <a type="button" href="<?php echo base_url('inventaris/alat'); ?>" class="btn btn-secondary"> <b>Cancel</b></a>

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
