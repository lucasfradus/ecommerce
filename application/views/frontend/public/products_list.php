<?php foreach ($load_Products as $i => $f): ?>
    <?php if ($i <= 8) : ?>
        <div class="  col-6 col-lg-4 col-md-4 col-sm-6 product-card">
            <div class="rounded card card-product-lg " align="center">
                <a href="<?php echo(base_url('producto/' . $f->id_product)) ?>">
                    <div class="card-img position-relative">
                        <div class="card-img-top img-products" style="background: url('<?php echo(base_url('uploads/img_productos/' . $f->image1)); ?>'); background-position: center;background-size: contain;background-repeat: no-repeat;width: 100%;height: 250px; border-color:1px solid black;">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-code"> <?php echo($f->code); ?></div>
                        <div class="text-product mb-2"> <?php echo($f->name); ?></div>
                        <div class="mb-2">
                            <?php if($this->session->userdata('customer_id')) : ?>
                                <div class="row">
                                    <div class=" col-md-12 text-price ml-1">
                                        <span class="text-uniandpack">P. x Pack </span>
                                        <?php if($user->id_list_price): ?>
                                            <?php echo('$ '.$f->prices[$user->id_list_price]); ?>
                                        <?php else: ?>   
                                            <?php echo('$ '.$f->price_package);  ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <?php if($f->offer != 1): ?>
                                    <div class="text-priceOffer">&nbsp;</div>
                                    <div class="row">
                                        <div class="text-price ml-3"><span class="text-uniandpack">P. x Uni </span>
                                        <?php echo('$ '.$f->price_individual);?>
                                        </div>
                                        <div class="text-price ml-1"><span class="text-uniandpack">P. x Pack </span>
                                        <?php echo('$ '.$f->price_package);?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="row">
                                        <div class="ml-3">
                                            <div class="text-priceOffer ml-5"><?php echo('$ '.$f->price_individual); ?></div> 
                                            <div class="text-price"><span class="text-uniandpack">P.&nbsp;x&nbsp;Uni&nbsp;</span><?php echo('$ '.$f->offer_price); ?></div>
                                        </div> 
                                        <div class="ml-2">
                                            <div class="text-priceOffer ml-5"><?php echo('$ '.$f->price_package); ?></div>
                                            <div class="text-price"><span class="text-uniandpack">P.&nbsp;x&nbsp;Pack&nbsp;</span><?php echo('$ '.$f->offer_price_bulto); ?></div> 
                                        </div> 
                                    </div>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                        <div>
                            <?php if ($f->stock != 0) : ?>
                                <a role="button" onclick="shopFastProduct(event, this)" data-action="open-shopping-modal" data-id="<?php echo $f->id_product ?>" data-pack="<?php echo $f->unit_bulto ?>" href="#" class="btn btn-primary btn-buy btn-block btn-lg rounded"><i class="fa fa-shopping-cart"></i> AÑADIR AL CARRITO</a>
                            <?php else : ?>
                                <a role="button" href="#" class="btn btn-light btn-lg btn-block btn-stock">SIN STOCK</a>
                            <?php endif ?>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php endif ?>
<?php endforeach ?> 
