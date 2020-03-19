<div class="background-img-products position-relative">
    <h1 class="d-none d-md-block"><?php if($category==''){ ?>PRODUCTOS<?php }else{ echo($category->name); } ?></h1>
    <h4 class="d-block d-md-none"><?php if($category==''){ ?>PRODUCTOS<?php }else{ echo($category->name); } ?></h4>
</div>
<section class="products">
    <div class="img-bot d-none d-sm-none d-lg-block d-md-none"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 offset-md-0col-12 text-right">
                <div class="my-breadcrumb">
                    <a href="<?php echo(base_url()); ?>">Home</a> - 
                    <?php if(isset($offer)){ ?>
                        <a href="<?php echo(base_url('ofertas')); ?>">Ofertas</a>
                    <?php }else{ ?>
                        <a href="<?php echo(base_url('productos')); ?>">Productos</a>
                    <?php } ?>
                    <?php if($category!=''): ?> - <a href="<?php echo(base_url('productos').'/'.$category->id_category.'/1'); ?>"><?php echo($category->category); ?></a><?php endif ?>
                    <?php if($category!=''){ if($category->id_subcategory>0) { ?> - <a href="<?php echo(base_url('productos').'/'.$category->id_subcategory.'/2'); ?>"><?php echo($category->subcategory); ?></a><?php } } ?>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-2 offset-md-0 col-2 text-left">
                <div class="my-breadcrumb">
                    <label for="ordenar">Ordenar</label>
                        <select class="form-control">
                                <option value="">Menor Precio</option>
                                <option value="">Mayor Precio</option>
                        <select>
                </div>
            </div>
        </div>
      
        <div id="products_list" class="row">
            <?php if($load_Products){ ?>
            <div class="col-lg-3 col-md-12 col-12">
                <?php $this->load->view('frontend/public/category_list'); ?>
            </div>
            <div class="col-lg-9 col-md-12 col-12">
                <br class="d-xs-inline d-md-none">
                <div class="row">
                    <?php $this->load->view('frontend/public/products_list') ?>
                    <?php if(count($load_Products)<=0){ ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5>No se encontraron productos.</h5>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo($links); ?>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
                <div class="col-lg-12">
                    <div class="alert alert-warning animated fadeInDown">
                        <h6>No se encontraron productos en oferta.</h6>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        $.each($('ul.my-pagination li a'), function( i, v ) {
            $(v).addClass('my-page-link');
        });
    });
</script>