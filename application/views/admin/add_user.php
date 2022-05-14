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
                    <h1 class="mt-4"><b>ADD USER</b></h1>
                    <hr style="border-bottom: solid 2px #e1e1e1;">
                    <br>
                    <?php echo form_open('admin/user/add'); ?> 
                    <div class="form-group">
                        <label for="inputUsername"><b>Username</b></label>
                        <input type="text" class="form-control col-5" name="username" id="username" autocomplete="off">
                        <?php echo form_error('username'); ?>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail"><b>E-mail</b></label>
                        <input type="email" class="form-control col-5" name="email" id="email" autocomplete="off">
                        <?php echo form_error('email'); ?>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword"><b>Password</b></label>
                        <input type="password" class="form-control col-5" name="password" id="password"  autocomplete="off">
                        <?php echo form_error('password'); ?>
                    </div>
                    <div class="form-group">
                        <label for="inputConfirmPassword"><b>Confirm Password</b></label>
                        <input type="password" class="form-control col-5" name="confirmpassword" id="confirmpassword"  autocomplete="off">
                        <?php echo form_error('confirmpassword'); ?>
                    </div>
                    <div class="form-group">
                        <label for="inputRole"><b>Role</b></label>
                        <select name="role" id="role" class="form-control col-5">
                            <option value="1"> Inventaris </option>
                            <option value="2"> Pimpinan</option>
                            <option value="3"> Event</option>
                        </select>
                        <?php echo form_error('role'); ?>
                    </div>
                    <br>
                    <button type="submit" name= "submit" id="save" class="btn btn-secondary"><b>Save</b></button> 
                    <a type="button" href="<?php echo base_url('admin/user'); ?>" class="btn btn-secondary"> <b>Cancel</b></a>

                    <?php if($this->session->flashdata('add_user_error')) echo $this->session->flashdata('add_user_error'); ?>
                    <?php form_close(); ?>

                </div>
            </main>
        </div>
    </div>
</body>
<?php $this->load->view('layout/script_list') ; ?>
