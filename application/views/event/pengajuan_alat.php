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
                    <h1 class="mt-4"><b>ALAT TAMBAHAN</b></h1>
                    <hr style="border-bottom: solid 2px #e1e1e1;">
                    <br>
                    <?php echo form_open('event/alat/pengajuan_submit'); ?> 
                    <div class="form-group">
                        <label for="namaAlat"><b>Event</b></label>
                        <select class="form-control col-5" name="kodeEvent" id="kodeEvent">
                            <option value="">--Choose Event--</option>
                            <?php if($data_event){ ?>
                                <?php for($i =0; $i < count($data_event);$i++){ ?>
                                    <option value="<?= $data_event[$i]->kodeEvent?>"> <?= $data_event[$i]->namaEvent ?> </option>
                                <?php } ?>        
                            <?php } ?>
                        </select>
                        <?php echo form_error('namaAlat'); ?>
                    </div>
                    <div class="form-group">
                        <label for="hargaAlat"><b>Peralatan</b></label>
                        <table id="alat" class="table table table-borderless table-dark" style="width:42%;">
                            <tbody>
                                <tr id="addAlat">
                                    <td width="250">
                                        <select class="form-control" name="namaAlat" id="namaAlat">
                                            <option value="">-Choose-</option>
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
    var i = 1;
    var row = 0;
    var alat = <?= json_encode($data_alat)?>;
    var total = []
    var rowCount = 0
    
    if(alat.length > 0){
        for(var i=0;i<alat.length;i++){
            var o = new Option(alat[i].namaAlat, alat[i].kodeAlat);
            $(o).html(alat[i].namaAlat);
            $("#namaAlat").append(o);
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
        $("#tanggalMasuk").datepicker({
            format: 'yyyy-mm-dd'
        });

        $("#kodeEvent").on("change", function(){
            $.ajax({
                "type": "POST",
                "url": "http://localhost/divine/event/alat/get_alat_by_event",
                "data": {
                    "kodeEvent": this.value
                }
            }).done(function (res) {
                console.log("res", res)
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
        })

        $("#namaAlat").on("change", function(){
            $('#namaAlat option').each(function() {
                if(this.selected){
                    if(alat.length > 0){
                        for(var i=0;i<alat.length;i++){
                            if(alat[i].namaAlat == this.text){
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
