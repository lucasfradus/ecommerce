<div class="background-img-products position-relative">
    <h1 class="d-none d-md-block">GESTION DE  CONTRASEÑA</h1>
    <h4 class="d-block d-md-none">GESTION DE CONTRASEÑA</h4>
</div>
<div class="work_container">
    <p>&nbsp;</p>
    <div class="container animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php if ($this->session->flashdata('mensaje')): ?>
                        <?php if ($this->session->flashdata('mensaje') == 'Success'): ?>
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <i class="fa fa-check"></i> Se cambió su contraseña correctamente.
                            </div>
                        <?php else: ?>
                            <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <i class="fa fa-times"></i> La clave ingresada es icorrecta.
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                    <div class="card-header" style="background: #017cff;color: #fff;">
                        CAMBIAR CONTRASEÑA
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <input type="hidden" name="enviar_form" value="1"/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Contraseña Actual <span class="text-danger">*</span></label>
                                        <input type="password" placeholder="Contraseña Actual" name="old_password" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Nueva Contraseña <span class="text-danger">*</span></label>
                                        <input type="password" placeholder="Nueva Contraseña" name="password" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Repetir Contraseña <span class="text-danger">*</span></label>
                                        <input type="password" placeholder="Reperit Contraseña" name="re_password" class="form-control" required=""/>
                                    </div>
                                </div>
                            <div class="col-md-4 offset-md-4">
                                <div class="form-group">
                                    <br>
                                    <button class="btn btn-primary btn-block" type="submit">GUARDAR</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
</div>