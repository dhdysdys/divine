<?php $this->load->view('layout/header') ; ?>
<body class="sb-nav-fixed">
    <?php $this->load->view('layout/topbar') ; ?>
  
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php $this->load->view('layout/sidebar') ; ?>
        </div>

        <!-- content -->
        <div id="layoutSidenav_content" class="sb-sidenav-dark" style="margin-left: 200px !important;">
            <main>
                <div class="container-fluid px-4">
                    <!-- <h1 class="mt-4">Sidenav</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sidenav Light</li>
                    </ol> -->

                    <div class="mt-5">
                        <br>
                        <center>
                            <p style="font-family:'Courier New', monospace; font-size: 20px;">Divine Production present to provide documentation and broadcasting services, such as: multicam system, photo booth, event documentation, company profile</p>
                            <br>

                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                    <img class="d-block" src="<?php echo base_url('public/assets/img/pict1.jpg'); ?>" alt="First slide">
                                    </div>
                                    <div class="carousel-item">
                                    <img class="d-block" src="<?php echo base_url('public/assets/img/pict1.jpg'); ?>" alt="Second slide">
                                    </div>
                                    <div class="carousel-item">
                                    <img class="d-block" src="<?php echo base_url('public/assets/img/pict1.jpg'); ?>" alt="Third slide">
                                    </div>
                                </div>
                            </div>
                       </center>
                      
                    </div>
                </div>
            </main>
            <!-- <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Divine 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer> -->
        </div>
      
        
    </div>
</body>
<?php $this->load->view('layout/script_list') ; ?>