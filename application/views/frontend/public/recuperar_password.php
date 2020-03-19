<section class="work_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success">
                                Hemos enviado una nueva contraseña a la direccion de correo ingresada.
                            </div>
                        <?php endif ?>
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                Los datos ingresados son incorrectos.
                            </div>
                        <?php endif ?>
                        <br>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Recuperar Contraseña</h4>
                            </div>
                            <div class="panel-body">
                                <div id="errorFormLogin"></div>
                                <form role="form" action="#" method="POST" id="form_recuperar">
                                    <div class="form-group float-label-control">
                                        <label for="email">Email</label>
                                        <input  type="email" id="email" name="email" value="" class="form-control" placeholder="EMAIL" required />
                                    </div>
                                    <button type="submit" class="btn btn-default btn-block">Recuperar contraseña</button>
                                </form>
                            </div>  
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
