<?php $this->view('frontend/public/slider') ?>
<section class="home">
    <div class="container">
        <div class="row">
            <?php if ($load_Products) : ?>
            <div class="col-lg-3 col-md-12 col-12">
                <?php $this->load->view('frontend/public/category_list'); ?>
                <br class="d-xs-block d-md-block d-lg-none d-sm-block">
                <h5 class="d-xs-block d-md-block d-lg-none mb-0 text-center text-destacado">PRODUCTOS&nbsp;&nbsp;<span class="text-destacado-span">DESTACADOS</span></h5>
            </div>
            <div class="col-lg-9 col-md-12 col-12">
                <div id="featured-products" class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 offset-md-0 col-12 mb-3">
                        <h4 class="d-none d-lg-block text-destacado text-left">PRODUCTOS&nbsp;&nbsp;<span class="text-destacado-span">DESTACADOS</span></h4>
                    </div>
                    <?php $this->load->view('frontend/public/products_list') ?>
                </div>
            </div>
            <?php else : ?>
                <div class="col-lg-12">
                    <div class="alert alert-warning animated fadeInDown">
                        <h6>No se encontraron productos destacados.</h6>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>   
</section>
<?php $this->view('frontend/public/slider_marcas') ?>