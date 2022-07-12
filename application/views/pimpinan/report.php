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
                    <h1 class="mt-4"><b>REPORT</b></h1>
                    <hr style="border-bottom: solid 2px #e1e1e1;">

                    <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div><br>
                    <?php } ?>

                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div><br>
                    <?php } ?>
                    <br>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="startdate"><b>Start Date</b></label>
                            <input type="text" class="form-control" id="start_date" name="start_date" placeholder="yyyy-mm-dd" readonly="">
                        </div>
                        <div class="col-sm-2">
                            <label for="enddate"><b>End Date</b></label>
                            <input type="text" class="form-control" id="end_date" name="end_date" placeholder="yyyy-mm-dd" readonly="">
                        </div>
                        <div class="col-sm-3">
                            <label for="report"><b>Report</b></label>
                            <select name="typeReport" id="typeReport" class="form-control">
                                <option value="1">Report Event</option>
                                <option value="2">Report Pembelian Alat</option>
                                <option value="3">Report Alat Rusak</option>
                                <option value="4">Report Most Used Item(s)</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button style="margin-top:30px;" class="btn btn-secondary" id="input_filter" >Show</button>
                        </div>
                    </div>

                    <table id="tb_event" class="table table-secondary" style="width:100%;display:none">
                        <thead>
                            <tr>
                                <th class="text-center" >ID</th>
                                <th class="text-center" >Nama Event</th>
                                <th class="text-center" >Lokasi</th>
                                <th class="text-center" >Rundown</th>
                                <th class="text-center" >Peralatan</th>
                                <th class="text-center"> Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <br>
                    <table id="tb_total_event" class="table table table-borderless table-dark" style="width:100%;display:none">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="">Total Event</label>
                                        <input type="text" disabled id="totalEvent" class="form-control" >
                                    </div> 
                                </td>
                                <td >
                                    <div class="form-group">
                                        <label for="">Total Pemasukan</label>
                                        <input type="text" disabled id="totalPemasukan" class="form-control" >
                                    </div> 
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table id="tb_alat" class="table table-secondary" style="width:100%;display:none">
                        <thead>
                            <tr>
                                <th class="text-center" >ID</th>
                                <th class="text-center" >Nama Alat</th>
                                <th class="text-center" >Harga Alat</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <br>
                    <table id="tb_total_alat" class="table table table-borderless table-dark" style="width:100%;display:none">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="">Total Alat</label>
                                        <input type="text" disabled id="totalAlat" class="form-control" >
                                    </div> 
                                </td>
                                <td >
                                    <div class="form-group">
                                        <label for="">Total Pengeluaran</label>
                                        <input type="text" disabled id="totalPengeluaran" class="form-control" >
                                    </div> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="modalAlat" tabindex="-1" role="dialog" aria-labelledby="ModalBobot" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReject"><b>Peralatan</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <table class="table table-secondary" id="tableListALat" name="tableListAlat">
                    <thead>
                        <tr>
                            <th class="text-center" >Nama Alat</th>
                            <th class="text-center" >Harga Alat</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

</body>
<?php $this->load->view('layout/script_list') ; ?>
<script type="text/javascript">
    $(document).ready( function () {
        

        $("#start_date").datepicker({
            format: 'yyyy-mm-dd'
        });
        
        $("#end_date").datepicker({
            format: 'yyyy-mm-dd'
        });

        $("#input_filter").on("click", function(){
            var start_date = $("#start_date").val()
            var end_date = $("#end_date").val()
            var type_report = $("#typeReport").val()

            if(type_report == 1){
                //report event (web)
                $('#tb_alat').DataTable().destroy();
                $('#tb_alat').hide();
                $("#tb_total_alat").hide();

                $('#tb_event').show();
                var table = $('#tb_event').DataTable({ 
                    "destroy": true,
                    "processing": true, 
                    "serverSide": true, 
                    "ajax": {
                        "url": "http://localhost/divine/pimpinan/report/get_event_report",
                        "type": "POST",
                        "data": {
                            "start_date":start_date,
                            "end_date":end_date,
                        }
                    },
                    "columns":[
                        {
                            data:"id",
                            className: 'text-center',
                        },
                        {data:"namaEvent"},
                        {data:"lokasi"},
                        {
                            data:"rundownEvent",
                            orderable:false,
                            searchable:false,
                            className: 'text-center',
                            render: function(data,type,full,meta){
                                return '<a href="http://localhost/divine/pimpinan/report/view_rundown/?path=' + data+'" class="btn btn-secondary">Lihat</a>'
                            }
                        },
                        {
                            data:"kodeEvent",
                            orderable:false,
                            searchable:false,
                            className: 'text-center',
                            render: function(data,type,full,meta){
                                return '<a href="http://localhost/divine/pimpinan/report/view_peralatan/' + data+'" class="btn btn-secondary">Lihat</a>'
                            }
                        },
                        {
                            data:"totalHarga",
                            orderable:false,
                            searchable:false,
                            render: function(row,type,full,meta){
                                $("#totalEvent").val(full["totalEvent"])
                                $("#totalPemasukan").val("Rp. " + full["totalHargaAll"])
                                return  'Rp. ' + row
                            }
                        },
                    ]
                })

                $("#tb_total_event").show()
            }else if(type_report == 2){
                // report alat (web)
                $('#tb_event').DataTable().destroy();
                $('#tb_event').hide();
                $("#tb_total_event").hide();


                $('#tb_alat').show();
                var table = $('#tb_alat').DataTable({ 
                    "destroy": true,
                    "processing": true, 
                    "serverSide": true, 
                    "ajax": {
                        "url": "http://localhost/divine/pimpinan/report/get_alat_report",
                        "type": "POST",
                        "data": {
                            "start_date":start_date,
                            "end_date":end_date,
                        }
                    },
                    "columns":[
                        {
                            data:"id",
                            className: 'text-center',
                        },
                        {data:"namaAlat"},
                        {
                            data:"hargaAlat",
                            orderable:false,
                            searchable:false,
                            render: function(row,type,full,meta){
                                $("#totalAlat").val(full["totalAlat"])
                                $("#totalPengeluaran").val("Rp. " + full["totalHargaAll"])
                                return  'Rp. ' + row
                            }
                        },
                    ]
                })

                $("#tb_total_alat").show()
            }else if(type_report == 3){
                // report inventaris (pdf)
                $url = "http://localhost/divine/pimpinan/report/get_inventaris_report/"+start_date+"/"+end_date
                window.open($url, '_blank');
            }else{
                // report most used (pdf)
                $url = "http://localhost/divine/pimpinan/report/get_most_used_report/"+start_date+"/"+end_date
                window.open($url, '_blank');
            }
        });

       

       
    } );
</script>