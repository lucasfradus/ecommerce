<div class="background-img-products position-relative">
    <h1 class="d-none d-md-block">PEDIDOS</h1>
    <h4 class="d-block d-md-none">PEDIDOS</h4>
</div>
<section class="cart">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3">
                <div class="list-group">
                    <a href="<?php echo(base_url('dashboard')); ?>" class="list-group-item list-group-item-action">Perfil</a>
                    <a href="<?php echo(base_url('order')); ?>" class="list-group-item list-group-item-action active">Pedidos</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="profile">
    <div class="container work_container">
        <p>&nbsp;</p>
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <div class="card">
                    <div class="card-header" style="background: #017cff;color: #fff;">
                        PEDIDOS
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $k => $v) : ?>
                                    <tr>
                                        <td><?php echo($k+1); ?></td>
                                        <td><?php echo(md5($v->id_order)); ?></td>
                                        <td><?php echo(date('d-m-Y',strtotime($v->created_at))); ?></td>
                                        <td><?php echo('$ '.number_format(($v->subtotal - $v->discount) + $v->cost_shipping , 2, '.', ',')); ?></td>
                                        <td><button data-id="<?php echo($v->id_order); ?>" data-action="showOrderDetail" class="btn btn-primary"><i class="fas fa-search"></i></button></td>
                                    </tr>
                                <?php endforeach ?>

                                <?php if(count($orders)<=0) : ?>
                                    <tr>
                                        <td class="text-center" colspan="5">No se encontraron pedidos.</td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="order_detail" tabindex="-1" role="dialog" aria-labelledby="order_detail" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="order_detail">Detalle del Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class=" table-responsive">
                    <table id="detail_table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Unidad Medida</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio Unitario</th>
                                <th scope="col">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="col-md-12 text-right" id="discount"></div>
                <div class="col-md-12 text-right" id="cost_shipping"></div>
                <div class="col-md-12 text-right" id="total_detail"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
  </div>
</div>
