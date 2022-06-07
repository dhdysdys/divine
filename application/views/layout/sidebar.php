<nav class="sb-sidenav accordion" id="sidenavAccordion">
    <div class="sb-sidenav-menu" style="color:white; font-family: 'Courier New', monospace;">
        <div class="nav">
            <center>
            <div class="sb-sidenav-menu-heading" style="margin-top:80px;">
                <a href="<?php echo base_url('/dashboard'); ?>">
                    <img width="350"  height="100" src="<?php echo base_url('public/assets/img/putih.png'); ?>">
                </a>
                
            </div>
            </center>
            <?php if($this->session->userdata('role') == 0 ){ ?>
                <a class="nav-link" href="<?php echo base_url('admin/user'); ?>" style="font-size:20px;margin-top:50px;color:white;background-color: rgba(0,0,0,.5)">
                    <div class="sb-nav-link-icon"><i class="fas fa-users fa-2x" style="color:white;margin-right:10px;"></i></div>
                    <b>USERS</b>
                </a>
                <a class="nav-link" href="<?php echo base_url('admin/user/add_user'); ?>" style="font-size:20px;color:white;background-color: rgba(0,0,0,.5)">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-plus fa-2x" style="color:white;margin-right:10px;"></i></div>
                    <b>ADD USER</b>
                </a>
            <?php }else if($this->session->userdata('role') == 1){ ?>
                <a class="nav-link" href="<?php echo base_url('inventaris/alat'); ?>" style="font-size:20px;margin-top:50px;color:white;background-color: rgba(0,0,0,.5)">
                    <b>INVENTARIS ALAT</b>
                </a>
                <a class="nav-link" href="<?php echo base_url('inventaris/alat/input_alat'); ?>" style="font-size:20px;color:white;background-color: rgba(0,0,0,.5)">
                    <b>INPUT ALAT</b>
                </a>
                <a class="nav-link" href="<?php echo base_url('inventaris/alat/pengajuan_alat'); ?>" style="font-size:20px;color:white;background-color: rgba(0,0,0,.5)">
                    <b>PENGAJUAN ALAT BARU</b>
                </a>
            <?php  }else if($this->session->userdata('role') == 2){ ?>
                <a class="nav-link" href="<?php echo base_url('pimpinan/alat_masuk'); ?>" style="font-size:20px;margin-top:50px;color:white;background-color: rgba(0,0,0,.5)">
                    <b>ALAT MASUK</b>
                </a>
                <a class="nav-link" href="<?php echo base_url('pimpinan/event_masuk'); ?>" style="font-size:20px;color:white;background-color: rgba(0,0,0,.5)">
                    <b>EVENT MASUK</b>
                </a>
                <a class="nav-link" href="<?php echo base_url('pimpinan/schedule_event'); ?>" style="font-size:20px;color:white;background-color: rgba(0,0,0,.5)">
                    <b>SCHEDULE EVENT</b>
                </a>
                <a class="nav-link" href="<?php echo base_url('pimpinan/alat'); ?>" style="font-size:20px;color:white;background-color: rgba(0,0,0,.5)">
                    <b>INVENTARIS ALAT</b>
                </a>
                <a class="nav-link" href="<?php echo base_url('pimpinan/alat/pengajuan_alat'); ?>" style="font-size:20px;color:white;background-color: rgba(0,0,0,.5)">
                    <b>ALAT TAMBAHAN MASUK</b>
                </a>
                <a class="nav-link" href="<?php echo base_url('pimpinan/alat/pengajuan_alat'); ?>" style="font-size:20px;color:white;background-color: rgba(0,0,0,.5)">
                    <b>REPORT</b>
                </a>
            <?php }else if($this->session->userdata('role') == 3){ ?>
                <a class="nav-link" href="<?php echo base_url('event/add_event'); ?>" style="font-size:20px;margin-top:50px;color:white;background-color: rgba(0,0,0,.5)">
                    <b>ADD EVENT</b>
                </a>
                <a class="nav-link" href="<?php echo base_url('event/alat'); ?>" style="font-size:20px;color:white;background-color: rgba(0,0,0,.5)">
                    <b>PENGAJUAN ALAT TAMBAHAN</b>
                </a>
                <a class="nav-link" href="<?php echo base_url('event/schedule_event'); ?>" style="font-size:20px;color:white;background-color: rgba(0,0,0,.5)">
                    <b>SCHEDULE EVENT</b>
                </a>
            <?php } ?>
        
            <!-- <div class="sb-sidenav-menu-heading">Interface</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Layouts
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                </nav>
            </div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Pages
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                        Authentication
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="login.html">Login</a>
                            <a class="nav-link" href="register.html">Register</a>
                            <a class="nav-link" href="password.html">Forgot Password</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                        Error
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="401.html">401 Page</a>
                            <a class="nav-link" href="404.html">404 Page</a>
                            <a class="nav-link" href="500.html">500 Page</a>
                        </nav>
                    </div>
                </nav>
            </div>
            <div class="sb-sidenav-menu-heading">Addons</div>
            <a class="nav-link" href="charts.html">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Charts
            </a>
            <a class="nav-link" href="tables.html">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Tables
            </a> -->
        </div>
    </div>
</nav>