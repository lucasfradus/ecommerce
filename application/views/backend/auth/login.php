<div class="auth-box-w  animated fadeInDown">
    <div class="logo-w" style="/*padding: 5%*/;max-height: 175px;display: block;">
        <img src="<?php echo base_url('assets/backend/img/logo_limpieza_panel.png') ?>" width="300" class="img-fluid">
    </div>
    
    <?php echo form_open("backend/auth/login", 'class="m-t"');?>

    <h4 class="auth-header"></h4> 

        <?php if ($this->session->flashdata('message')) print_r($this->session->flashdata('message')) ?>

        <div class="form-group">
            <label for="">Usuario</label>
            <input name="identity" id="identity" type="text" placeholder="Usuario" class="form-control" required>
            <div class="pre-icon os-icon os-icon-user-male-circle"></div>
        </div>
        <div class="form-group">
            <label for="">Contraseña</label>
            <input type="password" name="password" id="password" placeholder="Contraseña" class="form-control password" required>
            <div class="pre-icon os-icon os-icon-fingerprint"></div>
        </div>
        <div class="buttons-w">
            <button class="btn btn-primary btn-block">Acceder</button>
        </div>
        <br>
        <p align="center"> <small>&copy; <?php echo date('Y') ?></small> </p>
    <?php echo form_close();?>
</div>