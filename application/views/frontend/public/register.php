<section class="header-category">
    <div class="background-img-products position-relative">
        <h1 class="d-none d-md-block">REGISTRO</h1>
        <h4 class="d-block d-md-none">REGISTRO</h4>
    </div>
</section>
<section class="cart">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 text-right">
                <div class="my-breadcrumb">
                    <a href="<?php echo(base_url('index')); ?>">Home</a> - 
                    <a href="<?php echo(base_url('registro')); ?>">Registro</a>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="work_container">
    <p>&nbsp;</p>
    <div class="container animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div id="errorForm"></div>
                    <div class="card-header" style="background: #017cff;color: #fff;">
                        REGISTRO
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <input type="hidden" name="enviar_form" value="1"/>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nombre <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Nombre" name="name" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Apellido <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Apellido" name="surname" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Provincia <span class="text-danger">*</span></label>
                                        <select name="province" onchange="changeProvince(event, this);" class="form-control" required="">
                                            <option value="">Selecciona</option>
                                            <?php foreach ($provinces as $key => $value) : ?>
                                                <option value="<?php echo $value->id ?>"><?php echo $value->provincia ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Localidad <span class="text-danger">*</span></label>
                                        <select name="location" data-element="locations" class="form-control" required="">
                                            <option value="">Selecciona</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Dirección <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Dirección" name="address" class="form-control" required=""/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>DNI/CUIT <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="DNI ó CUIT" id="dni" name="dni" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Teléfono <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Ej. (11) 123456" name="telephone" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input id="email" type="email" placeholder="Email" name="email" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Contraseña <span class="text-danger">*</span></label>
                                        <input type="password" placeholder="Contraseña" name="password" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Repetir contraseña <span class="text-danger">*</span></label>
                                        <input type="password" placeholder="Repetir contraseña" name="repeat_password" class="form-control" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 offset-md-4">
                                <div class="form-group text-center">
                                    <input align="center" type="checkbox" value="1" required><span>&nbsp;<a href="<?php echo(base_url('terms')); ?>" target="_blank">Terminos y Condiciones</a></span>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">REGISTRARME</button>
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
