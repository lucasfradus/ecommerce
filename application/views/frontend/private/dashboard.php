<div class="background-img-products position-relative">
    <h1 class="d-none d-md-block">PERFIL</h1>
    <h4 class="d-block d-md-none">PERFIL</h4>
</div>
<section class="cart">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3">
                <div class="list-group">
                    <a href="<?php echo(base_url('dashboard'))?>" class="list-group-item list-group-item-action active">Perfil</a>
                    <a href="<?php echo(base_url('order')) ?>" class="list-group-item list-group-item-action ">Pedidos</a>
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
                        DATOS PERSONALES
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <input type="hidden" name="enviar_form" value="1"/>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>DNI/CUIT</label>
                                        <input type="text" placeholder="DNI ó CUIT" name="dni" class="form-control" value="<?php echo $user->dni ?>" disabled/>
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Nombre" name="name" class="form-control" value="<?php echo $user->name ?>" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Apellido <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Apellido" name="surname" class="form-control" value="<?php echo $user->surname ?>" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Provincia <span class="text-danger">*</span></label>
                                        <select name="province" onchange="changeProvince(event, this);" class="form-control" required="">
                                            <option value="">Selecciona</option>
                                            <?php foreach ($provinces as $key => $value): ?>
                                                <option value="<?php echo $value->id ?>" <?php echo $user->provincia_id == $value->id ? 'selected=""' : '' ?>><?php echo $value->provincia ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Teléfono <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Teléfono" name="telephone" class="form-control" value="<?php echo $user->phone ?>" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="email" placeholder="Email" name="email" class="form-control" value="<?php echo $user->email ?>" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Dirección <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Dirección" name="address" class="form-control" value="<?php echo $user->address ?>" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Localidad <span class="text-danger">*</span></label>
                                        <select name="location" data-element="locations" class="form-control" required="">
                                            <option value="">Selecciona</option>
                                            <?php foreach ($locations as $key => $value): ?>
                                                <option value="<?php echo $value->id ?>" <?php echo $user->localidad_id == $value->id ? 'selected=""' : '' ?>><?php echo $value->localidad ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 offset-md-4">
                                <div class="form-group">
                                    <br>
                                    <button class="btn btn-primary btn-block" type="submit">GUARDAR</button>
                                    <div class="text-center">
                                    <a href="<?php echo(base_url('change-password'))?>">Cambiar Contraseña</a>
                                    </div>
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