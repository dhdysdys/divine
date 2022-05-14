<?php $this->load->view('layout/header') ; ?>
<style>
    .loginBody{
        background-image: url(<?= base_url('public/assets/img/camera.png') ?>);
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        height: 100% !important;
        overflow: hidden;
    }
    
</style>
<body class="loginBody"> 
    <a class="navbar-brand ps-3" href="#">
        <img width="150"  height="40" style="margin:10px;" src="<?php echo base_url('public/assets/img/divine.png'); ?>">
    </a>
    <div class="container">
        <div class="row align-items-center vh-100" style="height: 85vh !important;">
            <div class="col-7 mx-auto">
                <div class="card-body bg-dark align-items-center" style="color:white;opacity:90%;">
                    <?php echo form_open('auth/login'); ?>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-5 col-form-label"><b>USERNAME</b></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control"  id="inputUsername" name="inputUsername" autocomplete="off" placeholder="email@example.com">
                            </div>
                            <?php echo form_error('inputUsername'); ?>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-5 col-form-label"><b>PASSWORD</b></label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" id="inputPassword" autocomplete="off" name="inputPassword" placeholder="Password">
                            </div>
                            <?php echo form_error('inputPassword'); ?>
                        </div>
                        <br>
                        <button type="submit" name= "submit" id="login_button" style="width:100%" class="btn btn-secondary btn-block"><b>LOGIN</b></button> 
                        <?php if($this->session->flashdata('login_error')) echo $this->session->flashdata('login_error'); ?>
                    <?php form_close(); ?>
                </div>
            </div>
        </div>        
    </div>
</body>
<?php $this->load->view('layout/script_list') ; ?>
