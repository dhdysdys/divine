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
                    <h1 class="mt-4"><b>ADD EVENT</b></h1>
                    <hr style="border-bottom: solid 2px #e1e1e1;">
                    <br>
                    <?php echo form_open_multipart('event/add_event/submit'); ?> 
                    
                    <div class="form-group">
                        <label for="namaEvent"><b>Nama Event</b></label>
                        <input type="text" class="form-control col-5" name="namaEvent" id="namaEvent" autocomplete="off">
                        <?php echo form_error('namaEvent'); ?>
                    </div>
                    <div class="form-group">
                        <label for="namaClient"><b>Nama Client</b></label>
                        <input type="text" class="form-control col-5" name="namaClient" id="namaClient" autocomplete="off">
                        <?php echo form_error('namaClient'); ?>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-1"> 
                            <label for="durasi"><b>Durasi</b></label>
                            <input type="text" class="form-control col-5" name="durasi" id="durasi" autocomplete="off" style="width:70px;">
                        </div>
                        <div class="form-group col-sm-0"> 
                            <label for="hari" style="color:black;">.</label>
                            <p style="width:65px;margin-left:-65px;margin-top:10px;"><b>hari</b></p>
                        </div>
                        <?php echo form_error('durasi'); ?>
                    </div>
                    <div class="form-group">
                        <label for="tanggalMulai"><b>Tanggal Mulai Event</b></label>
                        <input type="text" class="form-control col-5" name="tanggalMulai" id="tanggalMulai" autocomplete="off" placeholder="yyyy-mm-dd">
                        <?php echo form_error('tanggalMulai'); ?>
                    </div>
                    <div class="form-group">
                        <label for="tanggalSelesai"><b>Tanggal Berakhir Event</b></label>
                        <input type="text" class="form-control col-5" name="tanggalSelesai" id="tanggalSelesai" autocomplete="off" placeholder="yyyy-mm-dd">
                        <?php echo form_error('tanggalSelesai'); ?>
                    </div>

                   <div class="form-group">
                    <table id="waktuEvent" class="table table-borderless table-dark" style="width:42%;">
                        <thead>
                            <tr>
                                <td class="text-center">Waktu Mulai</td>
                                <td class="text-center">Waktu Selesai</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="addWaktu">
                                <td >
                                    <div class="form-row justify-content-center">
                                        <input type="number" min="0" max="23" name="jamEventMulai[]" id="jamEventMulai" class="form-control" placeholder="hh" style="width:65px;">
                                        <input type="number" min="0" max="59" name="menitEventMulai[]" id="menitEventMulai" class="form-control" placeholder="mm" style="width:65px; margin-left:10px;">
                                    </div>
                                </td>
                                <td>
                                   <div class="form-row justify-content-center">
                                        <input type="number" min="0" max="23" name="jamEventSelesai[]" id="jamEventSelesai" class="form-control" placeholder="hh" style="width:65px;">
                                        <input type="number" min="0" max="59" name="menitEventSelesai[]" id="menitEventSelesai" class="form-control" placeholder="mm" style="width:65px; margin-left:10px;">
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                   </div>
                    <div class="form-group">
                        <label for="lokasiEvent"><b>Lokasi Event</b></label>
                        <input type="text" class="form-control col-5" name="lokasiEvent" id="lokasiEvent" autocomplete="off">
                        <?php echo form_error('lokasiEvent'); ?>
                    </div>
                    <div class="form-group">
                        <label for="rundownEvent"><b>Rundown Event</b></label>
                        <input type="file" class="form-control col-sm-5" id="rundownEvent" name="rundownEvent" required>
                        <?php echo form_error('rundownEvent'); ?>
                    </div>
                    <div class="form-group">
                        <label for="hargaRetail"><b>Peralatan dan Harga</b></label>
                        <table id="alat" class="table table-borderless table-dark" style="width:42%;">
                            <tbody>
                                <tr id="addAlat">
                                    <td width="250">
                                        <select class="form-control" name="namaAlat" id="namaAlat">
                                            <option value="0">-Choose-</option>
                                        </select>
                                    </td>
                                    <td width="150">
                                        <input type="text" name="hargaAlat" id="hargaAlat" class="form-control" readonly>
                                    </td>
                                    <td width="10">
                                        <button type="button" class="btn btn-success" id="addRow"><b>+</b></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td width="250" style="color:white; font-weight:bold;text-align:right;">Total</td>
                                    <td width="150"><input type="text" name="hargaAlatTotal" id="hargaAlatTotal" class="form-control" readonly></td>
                                    <td width="10"></td>
                                </tr>
                            </tfoot>
                        </table>
                        <?php echo form_error('namaAlatInput'); ?>
                    </div>
                    <div class="form-group">
                        <label for="lokasiEvent"><b>Harga Kesepakatan</b></label>
                        <input type="text" class="form-control col-5" name="hargaKesepakatan" id="hargaKesepakatan" autocomplete="off">
                        <?php echo form_error('hargaKesepakatan'); ?>
                    </div>
                    <br>
                    <button type="submit" name= "submit" id="save" class="btn btn-primary"><b>Request</b></button> 
                    <a type="button" href="<?php echo base_url('dashboard'); ?>" class="btn btn-danger"> <b>Cancel</b></a>

                    <?php if($this->session->flashdata('add_alat_error')) echo $this->session->flashdata('add_alat_error'); ?>
                    <?php form_close(); ?>

                </div>
                <br>
            </main>
        </div>
    </div>
</body>
<?php $this->load->view('layout/script_list') ; ?>
<script type="text/javascript">
    var i = 1;
    var row = 0;
    var alat = <?= json_encode($alat)?>;
    var total = []
    var rowCount = 0
    var durasi = 0

    if(alat.length > 0){
        for(var i=0;i<alat.length;i++){
            if(alat[i].statusAlat != 4){
                var o = new Option(alat[i].namaAlat, alat[i].kodeAlat);
                $(o).html(alat[i].namaAlat);
                $("#namaAlat").append(o);
            }
           
        }
    }

    function childrenRow(kode,nama,harga){
        i++;
        $("#alat").find('tbody').append('<tr><td width="250"><input type="text" name="namaAlatInput[]" id="namaAlatInput" class="form-control" value="'+nama+'" readonly></td><input type="hidden" name="kodeAlatInput[]" id="kodeAlatInput" class="form-control" value="'+kode+'" readonly></td><td width="150"><input type="text" name="hargaAlatInput[]" id="hargaAlatInput" class="form-control" value="'+harga+'" readonly></td><td width="10"></td></tr>');
        row++

        harga = harga.split(" ")
        total.push(parseInt(harga[1]))
    }   

    $(document).ready(function () {
        $("#tanggalMulai").datepicker({
            format: 'yyyy-mm-dd'
        });  

        $("#tanggalSelesai").datepicker({
            format: 'yyyy-mm-dd'
        });  

        $("#durasi").on("change", function(){
            durasi = this.value
           
            if(durasi != null){ 
                var get_tanggal_mulai = $("#tanggalMulai").val()
                if(get_tanggal_mulai == ""){
                    $("#tanggalMulai").on("change", function(){
                        var [year, month, day] = this.value.split("-")

                        var start_date = new Date(year, month-1, day);
                        var get_end_date = start_date.setDate(start_date.getDate() + parseInt(durasi));
                        var end_date = new Date(get_end_date).toISOString().split('T')[0] 


                        $("#tanggalSelesai").change().val(end_date)

                        $.ajax({
                            "type": "POST",
                            "url": "http://localhost/divine/event/add_event/get_alat_by_date",
                            "data": {
                                "tanggalMulai": $("#tanggalMulai").val(),
                                "tanggalSelesai": $("#tanggalSelesai").val()
                            }
                        }).done(function (res) {
                            // console.log("res", res)
                            if(res != ""){
                                var result = JSON.parse(res)

                                if(result.length > 0){
                                    for(var i=0;i<alat.length;i++){
                                        if(!result.includes(alat[i].kodeAlat) && alat[i].statusAlat != 4){
                                            // console.log("alat not inc", alat[i].kodeAlat)
                                            $("#namaAlat option[value='"+alat[i].kodeAlat+"']").remove();
                                        }
                                    }
                                }
                            }
                        })
                    })
                }else{
                    var [year, month, day] = get_tanggal_mulai.split("-")

                    var start_date = new Date(year, month-1, day);
                    var get_end_date = start_date.setDate(start_date.getDate() + parseInt(durasi));
                    var end_date = new Date(get_end_date).toISOString().split('T')[0] 

                    $("#tanggalSelesai").change().val(end_date)

                    $.ajax({
                        "type": "POST",
                        "url": "http://localhost/divine/event/add_event/get_alat_by_date",
                        "data": {
                            "tanggalMulai": $("#tanggalMulai").val(),
                            "tanggalSelesai": $("#tanggalSelesai").val()
                        }
                    }).done(function (res) {
                        // console.log("res", res)
                        if(res != ""){
                            var result = JSON.parse(res)

                            if(result.length > 0){
                                for(var i=0;i<alat.length;i++){
                                    if(!result.includes(alat[i].kodeAlat)){
                                        // console.log("alat not inc", alat[i].kodeAlat)
                                        $("#namaAlat option[value='"+alat[i].kodeAlat+"']").remove();
                                    }
                                }
                            }
                        }
                    })
                }
              
                if(durasi > 1){
                    rowCount = $('#waktuEvent tr').length;
                    var rowCount = rowCount - 1
                    var row = durasi - rowCount

                    console.log("row", row)
                    for(var i=0;i<=row;i++){
                        $("#waktuEvent").find('tbody').append('<tr><td ><div class="form-row justify-content-center"><input type="number" min="0" max="23" name="jamEventMulai[]" id="jamEventMulai" class="form-control" placeholder="hh" style="width:65px;"><input type="number" min="0" max="59" name="menitEventMulai[]" id="menitEventMulai" class="form-control" placeholder="mm" style="width:65px; margin-left:10px;"></div></td><td><div class="form-row justify-content-center"><input type="number" min="0" max="23" name="jamEventSelesai[]" id="jamEventSelesai" class="form-control" placeholder="hh" style="width:65px;"><input type="number" min="0" max="59" name="menitEventSelesai[]" id="menitEventSelesai" class="form-control" placeholder="mm" style="width:65px; margin-left:10px;"></div></td></tr>');
                        i++
                    }
                }

               
                
            }
        })

        $("#namaAlat").on("change", function(){
            $('#namaAlat option').each(function() {
                if(this.selected){
                    if(alat.length > 0){
                        for(var i=0;i<alat.length;i++){
                            if(alat[i].namaAlat == this.text && alat[i].kodeAlat == this.value ){
                                $("#hargaAlat").val("Rp. "+alat[i].hargaRetail)
                            }
                        }
                    }
                }
            });
        })

        $("#addRow").on("click", function(){
            var namaAlat = $('#namaAlat').find(":selected").text()
            var kodeAlat = $('#namaAlat').find(":selected").val()
            var hargaAlat = $("#hargaAlat").val()        

            if(namaAlat != "" && hargaAlat != ""){
                childrenRow(kodeAlat, namaAlat, hargaAlat)

                $('#namaAlat').find(":selected").remove()
                $("#namaAlat select").val("0");
                $("#hargaAlat").val("");
        
                
                if(total.length > 0){
                    var sum = total.reduce((a, b) => a + b, 0)
                    $("#hargaAlatTotal").val("Rp. "+sum)
                }
            }
        })
    });
</script>