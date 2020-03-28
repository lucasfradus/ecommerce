<style>

@media (min-width: 40rem) {
    .cards_item {
    width: 50%!important;
  }
}

/* adapto la cantidad de items que muestro por fila si la pantalla es grande*/
@media (min-width: 56rem)
{
    .parent {
    display: flex;
    flex-wrap: wrap;
    }

    .child {
    flex: 1 0 21%; 
    }

}


</style>




<div class="row">
<div class="main-product-list">
<ul class="cards parent">
<?php foreach ($load_Products as $i => $f): ?>
    <?php if ($i <= 8) : ?>
     
        <a href="<?php echo base_url('producto/'.$f->id_product) ?>">
       
        <li class="child cards_item">
                <div class="card-2 ">
                     <div class="card_image"><img src="<?php echo(base_url('uploads/img_productos/' . $f->image1)); ?>"></div>
                     <div class="card_content">
                 
                      <div align="center"> 
                            <div class="text-code"> Cod. <?php echo($f->code); ?></div>
                            <div class="text-product mb-2"> <?php echo($f->name); ?></div>
                        </div>
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
                                <div class="row">
                                        <div class="column-left">
                                            <span class="text-uniandpack">P. x Uni </span>
                                            <p class="text-price"><?php echo('$ '.$f->price_individual); ?></p>
                                            <br>
                                        </div>
                                        <div class="column-right">
                                            <span class="text-uniandpack">P. x Pack </span>
                                            <p class="text-price"><?php echo('$ '.$f->price_package); ?></p>
                                            <br>
                                        </div>
                                    </div>
                            <?php else: ?> 
                                <div class="row">
                                        <div class="column-left">
                                            <span class="text-uniandpack">P. x Uni </span>
                                            <p class="text-price-offer"><?php echo('$ '.$f->offer_price); ?></p>
                                            <p class="text-price-offer-cross"><?php echo('$ '.$f->price_individual); ?></p>
                                        </div>
                                        <div class="column-right">
                                            <span class="text-uniandpack">P. x Pack </span>
                                            <p class="text-price-offer"><?php echo('$ '.$f->offer_price_bulto); ?></p>
                                            <p class="text-price-offer-cross"><?php echo('$ '.$f->price_package); ?></p>
                                        </div>
                                    </div> 
                                    <?php endif ?>
                            <?php endif ?>  
                            
                            <?php if ($f->stock != 0) : ?>
                                <a role="button" onclick="shopFastProduct(event, this)" data-action="open-shopping-modal" data-id="<?php echo $f->id_product ?>" data-pack="<?php echo $f->unit_bulto ?>" href="#" class="btn btn-add-cart-2"><i class="lnr lnr-cart"></i> Añadir al Carrito</a>
                            <?php else : ?>
                                <a role="button" href="#" class="btn btn-light btn-lg btn-block btn-stock">SIN STOCK</a>
                            <?php endif ?>                           
                    </div>
                </div> 
        </li>
        
    </a>                       
    <?php endif ?>
<?php endforeach ?> 
</ul>
</div>     
</div>