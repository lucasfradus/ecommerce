<section class="header-category">
    <div class="background-img-products position-relative">
        <h1  class="d-none d-md-block">CARRITO</h1>
        <h4  class="d-block d-md-none">CARRITO</h4>
    </div>
</section>
<section class="cart">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 text-right">
                <div class="my-breadcrumb">
                    <a href="<?php echo(base_url('index')); ?>"> Home</a> - 
                    <a href="<?php echo(base_url('carrito')); ?>"> Carrito</a>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="work_container">
    <p>&nbsp;</p>
    <form method="POST" action="<?php echo base_url('process_shopping_cart') ?>" onsubmit="registroOrden(event, this)">
    <div class="container animated fadeIn">
        <div class="row">
            <?php if ($this->session->flashdata('carritoOk')) : ?>
                <div class="col-lg-12">
                    <br>
                    <div class="alert alert-info animated fadeInDown">
                        <?php echo $this->session->flashdata('carritoOk') ?>
                    </div>
                </div>

            <?php else : ?>

                <div class="col-lg-12">
                    <?php if (count($this->cart->contents()) == 0) : ?>
                        <div class="alert alert-warning animated fadeInDown">
                            Todavía no cargo productos al carrito de compras.
                        </div>
                    <?php endif ?>

                    <div id="message-cart">
                    </div>
   
                    <?php if (count($this->cart->contents()) > 0) : ?>
                        <div class="table-responsive">
                            <table class="table table-hover" id="tabla-pedidos">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th><span class="hidden-xs">Producto</span></th>
                                        <th><span class="hidden-xs">Unidad de medida</span></th>
                                        <th><span class="hidden-xs">Precio</span></th>
                                        <th><span class="hidden-xs">Cantidad</span></th>                               
                                        <th><span class="hidden-xs">Descuento</span></th>
                                        <th><span class="hidden-xs">Subtotal</span></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="productos_listado_carrito">
                                    <?php
                                    $diff_discount = 0;
                                     foreach ($this->cart->contents() as $items) : ?>
                                        <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value) {
                                            switch ($option_name) {
                                                case 'subcategory':
                                                    $subcategory = $option_value;
                                                    break;
                                                case 'category':
                                                    $category = $option_value;
                                                    break;
                                                case 'imagen':
                                                    $imagen = $option_value;
                                                    break;
                                                case 'type_id':
                                                    $tipo_producto = $option_value;
                                                    break;
                                               
                                            }

                                        } 

                                        $discount = ($items['desc']/100)*($items['price']*$items['qty']);
                                        $diff_discount =+ $discount;
                                        ?>
                                        <tr id="grilla_producto_<?php echo $items['rowid']; ?>">
                                            <td align="center">
                                                <img src="<?php echo base_url().'uploads/img_productos/'.$imagen ?>" width="80" class="hidden-xs img-shopping-cart"/>
                                            </td>
                                            <td>
                                                <?php echo $items['name']; ?><br>
                                            </td>
                                            <td>
                                                <?php echo $tipo_producto == 1 ? 'Unidad':'Bulto'; ?>
                                            </td>
                                            <td>
                                                $<?php echo $this->cart->format_number($items['price']); ?>
                                            </td>
                                            <td>
                                                <div class="count">
                                                    <input name="qty" id="<?php echo $items['rowid']; ?>" onchange="calcularSubtotalPedido(this)" onkeyup="calcularSubtotalPedido(this)" data-price="<?php echo $items['price'] ?>" type="number" min="1" style="max-width: 70px;min-width: 70px;" class="form-control" value="<?php echo $items['qty']; ?>">
                                                </div>
                                                <span class="text-danger qty-message"></span>
                                            </td>
                                            <td>
                                                 <div class="diff_discount">$<?php echo $this->cart->format_number($discount); ?> </div>
                                                 <?php if($discount!=0):?>
                                                 <small class="desc text-info ">Descuento del <?php echo $items['desc']?>%</small>
                                                 <?php endif?>
                                            </td>
                                            <td>
                                                <div class="price">$<?php echo $this->cart->format_number($items['price']*$items['qty'] - $discount); ?></div>
                                            </td>
                                            
                                            <td>
                                                <a href="#" class="text-danger" data-id="<?php echo($items['rowid']); ?>" data-action="delete_product"><span class="fas fa-times"></span></a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif ?>
                </div>
                   
                <?php if (!$this->session->userdata('customer_id')) : ?>
                    <?php if ($this->cart->total() > 0) : ?>
                        <div class="col-md-12">
                            <hr>
                            <div class="form-group">
                                <h5>¿Ya estas registrado?</h5>
                                <br>
                                <a href="#" data-target="#modalLogin" data-toggle="modal" class="btn btn-primary" data-toggle="modal">Iniciar sesión</a>
                            </div>
                        </div>
                        <div class="col-md-12 offset-md-0 col-lg-12">
                            <hr>
                            <div class="detail">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Datos personales</h5>
                                        <br>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="elocker" id="elocker">
                                        <input type="hidden" name="entrega" id="entrega">
                                        <div class="form-group">
                                            <input name="name" class="form-control" type="text" placeholder="Nombre" required>
                                        </div>
                                        <div class="form-group">
                                            <input name="surname" class="form-control" type="text" placeholder="Apellido" required>
                                        </div>
                                        <div class="form-group">
                                            <select name="province" onchange="changeProvince(event, this);" class="form-control" required="">
                                                <option value="">Seleccionar provincia</option>
                                                <?php foreach ($provinces as $key => $value) : ?>
                                                    <option value="<?php echo $value->id ?>"><?php echo $value->provincia ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select name="locality" data-element="locations" class="form-control" required="">
                                                <option value="">Seleccionar localidad</option>
                                            </select>
                                        </div>
                                    <div class="form-group">
                                        <input name="address" class="form-control" type="text" id="direccion" placeholder="Dirección" required>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="telephone" class="form-control" type="text" placeholder="Teléfono" required>
                                        </div>
                                        <div class="form-group">
                                            <input name="email" class="form-control" type="email" placeholder="Email" required>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" id="payment_method" name="payment_method" required="">
                                                <option class="d-none" value="">Método de pago:</option>
                                                <?php foreach ($payment_methods as $key => $value) : ?>
                                                    <option value="<?php echo $value->id_payment_method ?>"><?php echo $value->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div id="santander" class="d-none">
                                                <br>
                                                <h5 class="text-danger"><strong>BANCO SANTANDER RIO</strong></h5>
                                                <h6><strong>CUENTA CTE. EN PESOS:</strong><span> Nº 147-004187 /8</span></h6>
                                                <h6><strong>TITULAR:</strong><span> TRANFOMER S.R.L.</span></h6>
                                                <h6><strong>CBU:</strong><span> 0720147520000000418786</span> </h6>
                                                <h6><strong>CUIT:</strong><span> 30-70768844 -7</span></h6>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" id="shipping_method"  name="shipping_method" required="">
                                                <option class="d-none" value="">Forma de entrega:</option>
                                                <?php foreach ($shipping_methods as $key => $value) : ?>
                                                    <option value="<?php echo $value->id_shipping_methods ?>"><?php echo $value->name ?></option>    
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group expreso d-none">
                                            <label>Expreso:</label>&nbsp;
                                            <span>Si </span><input type="radio" name="expreso" value="1">&nbsp;
                                            <span>No </span><input type="radio" name="expreso" value="0" checked>
                                        </div>
                                        <div class="form-group d-none" id="description_expreso">
                                            <textarea rows="2" name="description_expreso" class="form-control" placeholder="Descripción del Expreso"></textarea>
                                        </div>
                                        <div id="shipping_container">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <div class="col-lg-8 offset-lg-4 col-md-7 offset-md-5 col-sm-12 col-xs-12  ">
                        <div class="detail">
                            <input type="hidden" id="freeShipping" data-action="freeShipping" value="<?php echo($configurations[28]->value)?>" >
                            <?php if (count($this->cart->contents()) > 0) : ?>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="">
                                            <div class="pull-right">
                                                <div align="right" id="">COMPRA: $ <span id="total"><?php echo $this->cart->total(); ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div id="discount" class="float-right">
                                            DESCUENTO: $ 0.00
                                        </div><input type="hidden" name="discount" value="">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div id="shipping_cost" class="float-right">
                                            ENVÍO: $ 0.00
                        
                                        </div><input type="hidden" name="shipping_cost" value="">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div id="shipping_total" class="float-right">
                                            TOTAL: $ <?php echo number_format($this->cart->total(), 2, '.', ','); ?>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <p>&nbsp;</p>
                                    <div class="col-md-12">
                                        <div id="estado_compra"></div>
                                    </div>
                                </div>
                            <?php endif ?>
                            <div class="row text-right">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 buttons d-none d-sm-block d-block-md d-lg-block d-xl-block">
                                    <a href="<?php echo base_url('productos') ?>" class="btn btn-light btn-lg">Seguir Comprando</a>
                                    &nbsp;
                                    <?php if (count($this->cart->contents()) > 0) : ?>
                                        <button class="btn btn-primary btn-lg btn-shopping activo" id="btn-comprar-productos" type="submit">
                                            CONFIRMAR
                                        </button>
                                    <?php endif ?>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-md-none d-lg-none d-sm-none d-block">
                                    <p>&nbsp;</p>
                                    <div class="form-group">
                                        <a href="<?php echo base_url('productos') ?>" class="btn btn-light btn-lg btn-block">Seguir Comprando</a>
                                    </div>
                                    <?php if (count($this->cart->contents()) > 0) : ?>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-lg btn-shopping btn-block activo" id="btn-comprar-productos" type="submit">
                                                CONFIRMAR
                                            </button>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <?php if ($this->session->userdata('customer_id')) : ?>
                    <?php if (count($this->cart->contents()) > 0) : ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" id="payment_method" name="payment_method" required="">
                                <option class="d-none" value="">Método de pago:</option>
                                <?php foreach ($payment_methods as $key => $value) : ?>
                                    <option value="<?php echo $value->id_payment_method ?>"><?php echo $value->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="santander" class="d-none">
                                <br>
                                <h5 class="text-danger"><strong>BANCO SANTANDER RIO</strong></h5>
                                <h6><strong>CUENTA CTE. EN PESOS:</strong><span> Nº 147-004187 /8</span></h6>
                                <h6><strong>TITULAR:</strong><span> TRANFOMER S.R.L.</span></h6>
                                <h6><strong>CBU:</strong><span> 0720147520000000418786</span> </h6>
                                <h6><strong>CUIT:</strong><span> 30-70768844 -7</span></h6>
                            </div>
                        </div>
                        <div class="form-group expreso d-none">
                            <label>Expreso:</label>&nbsp;
                            <span>Si </span><input type="radio" name="expreso" value="1">&nbsp;
                            <span>No </span><input type="radio" name="expreso" value="0" checked>
                        </div>
                        <div class="form-group d-none" id="description_expreso">
                            <textarea rows="2" name="description_expreso" class="form-control" placeholder="Descripción del Expreso"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <select class="form-control" id="shipping_method"  name="shipping_method" required="">
                                <option class="d-none" value="">Forma de entrega:</option>
                                <?php foreach ($shipping_methods as $key => $value) : ?>
                                    <option value="<?php echo $value->id_shipping_methods ?>"><?php echo $value->name ?></option>    
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div id="shipping_container"></div>
                    </div> 
                    <?php endif ?>
                <div class="col-lg-8 offset-lg-4 col-md-7 offset-md-5 col-sm-12 col-xs-12  ">
                    <div class="detail">
                        <input type="hidden" id="freeShipping" data-action="freeShipping" value="<?php echo($configurations[28]->value)?>"/>
                        <?php if (count($this->cart->contents()) > 0) : ?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="">
                                        <div class="pull-right">
                                            <div align="right" id="">COMPRA: $ <span id="total"><?php echo $this->cart->total(); ?></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div id="discount" class="float-right">
                                        DESCUENTOS: <?php echo number_format($diff_discount, 2, '.', ','); ?>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div id="shipping_cost" class="float-right">
                                        ENVÍO: $ 0.00
                    
                                    </div><input type="hidden" name="shipping_cost" value="">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div id="shipping_total" class="float-right">
                                        TOTAL: $ <?php echo number_format($this->cart->total(), 2, '.', ','); ?>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <p>&nbsp;</p>
                                <div class="col-md-12">
                                    <div id="estado_compra"></div>
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="row text-right">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 buttons d-none d-sm-block d-block-md d-lg-block d-xl-block">
                                <a href="<?php echo base_url('productos') ?>" class="btn btn-light btn-lg">Seguir Comprando</a>
                                &nbsp;
                                <?php if (count($this->cart->contents()) > 0) : ?>
                                    <button class="btn btn-primary btn-lg btn-shopping activo" id="btn-comprar-productos" type="submit">
                                        CONFIRMAR
                                    </button>
                                <?php endif ?>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-md-none d-lg-none d-sm-none d-block">
                                <p>&nbsp;</p>
                                <div class="form-group">
                                    <a href="<?php echo base_url('productos') ?>" class="btn btn-light btn-lg btn-block">Seguir Comprando</a>
                                </div>
                                <?php if (count($this->cart->contents()) > 0) : ?>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-lg btn-shopping btn-block activo" id="btn-comprar-productos" type="submit">
                                            CONFIRMAR
                                        </button>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>
            <?php endif ?>
        </div>
    </div>
    <br><br>
    </form>
</div>
<script>
    $(document).ready(function() {
        if(<?php echo(count($this->cart->contents())); ?>>0){
            getDiscount();
        }
    });
  
</script>
