<?php $this->view('frontend/email/_header'); ?>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="#000">
                <tr>
                    <td align="center" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                        <tr>
                            <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                    <tr>
                                        <td align="center" valign="top" class="textContent">
                                            <img src="<?php echo base_url('assets/public/logo_pintureriasintegrales.jpg') ?>" width="200">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- // MODULE ROW -->
    <tr>
    <td align="center" valign="top">
        <!-- CENTERING TABLE // -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center" valign="top">
                <!-- FLEXIBLE CONTAINER // -->
                <br>
                    <h2 style="text-align:center;font-weight:normal;font-family:Helvetica,Arial,sans-serif;font-size:23px;margin-bottom:0px;margin-top: 0px;color:#008fcc;line-height:135%;">
                        Nuevo pedido
                    </h2>
                <br>
                <!-- // FLEXIBLE CONTAINER -->
                </td>
            </tr>
        </table>
        <!-- // CENTERING TABLE -->
    </td>
    </tr>
    <!-- // MODULE ROW -->
    <!-- MODULE ROW // -->
    <tr>
        <td align="center" valign="top">
            <!-- CENTERING TABLE // -->
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="center" valign="top">
                        <!-- FLEXIBLE CONTAINER // -->
                        <table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer">
                            <tr>
                                <td style="padding-top:0;" align="center" valign="top" width="500" class="flexibleContainerCell">
                                    <!-- CONTENT TABLE // -->
                                    <table align="left" border="0" cellpadding="1" cellspacing="2" class="flexibleContainer">
                                        <tr>
                                            <td align="left" valign="top" class="textContent">
                                                <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:135%;">
                                                    Nombre y apellido: <?php echo $dato['nombre']; ?><br/>
                                                    Teléfono: <?php echo $dato['telefono']; ?><br/>
                                                    Provincia: <?php echo $dato['provincia']; ?><br/>
                                                    Ciudad: <?php echo $dato['localidad']; ?><br/>
                                                    Dirección: <?php echo $dato['direccion']; ?><br/>
                                                    <?php if (!empty($dato['codigo_postal'])): ?>
                                                        Código postal: <?php echo $dato['codigo_postal'] ?><br/>
                                                    <?php endif ?>
                                                    Forma de pago: <?php echo $dato['metodo_pago'] ?><br/>
                                                    Forma de envío: <?php echo $dato['metodo_envio'] ?><br/>
                                                    <?php if($dato['costo_envio'] > 0): ?>
                                                        SubTotal: $<?php echo number_format($dato['importe'],2,'.','') ?><br/>
                                                        Costo de envío: $<?php echo number_format($dato['costo_envio'],2,'.','') ?><br/>
                                                        Total: $<?php echo number_format($dato['importe'] + $dato['costo_envio'], 2, '.', '') ?><br/>
                                                    <?php else: ?>
                                                            Total: $<?php echo number_format($dato['importe'],2,'.','') ?><br/>
                                                    <?php endif ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // CONTENT TABLE -->
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="table table-striped table-bordered" cellspacing="2" cellpadding="4" style="width:100%;font-size:14px;">
                                        <thead>
                                            <tr>
                                                <th><span class="">Producto</span></th>
                                                <th><span class="">Cantidad</span></th>
                                                <th><span class="">Precio</span></th>
                                                <th><span class="">Subtotal</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($dato['productos'] as $key => $value): ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $value['name'] ?><br>
                                                        <?php if (!empty($value['options']['talle'])): ?>
                                                            Talle: <?php echo $value['options']['talle'] ?><br>
                                                        <?php endif ?>
                                                        <?php if (!empty($value['options']['color'])): ?>
                                                            Color: <?php echo $value['options']['color'] ?>
                                                        <?php endif ?>
                                                        <?php if (!empty($value['options']['heel'])): ?>
                                                            Taco: <?php echo $value['options']['heel'] ?>
                                                        <?php endif ?>
                                                    </td>
                                                    <td align="center"><?php echo $value['qty'] ?></td>
                                                    <td>$<?php echo $this->cart->format_number($value['price']) ?></td>
                                                    <td>$<?php echo $this->cart->format_number($value['price'] * $value['qty']) ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                    <p align="center"><small>Pronto nos pondremos en contacto con usted,  <br> Gracias por su compra.</small></p>
                                </td>
                            </tr>
                        </table>
                        <!-- // FLEXIBLE CONTAINER -->
                    </td>
                </tr>
            </table>
            <!-- // CENTERING TABLE -->
        </td>
    </tr>
<?php $this->view('frontend/email/_footer'); ?>