<div class="background-img-products position-relative">
    <h1 class="d-none d-md-block"><?php echo ($category == '') ? 'OFERTAS' : $category->name; ?></h1>
    <h4 class="d-block d-md-none"><?php echo ($category == '') ? 'OFERTAS' : $category->name; ?></h4>
</div>
<section class="products">
    <div class="img-bot d-none d-sm-none d-lg-block d-md-none"></div>
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 ">
                <h3 class="d-none d-lg-block mb-0 text-destacado text-right">OFERTAS DEL MES</h3>
            </div>
        </div>
        <div id="products_list" class="row">
            <div class="col-lg-3 col-md-12 col-12 ">
                <?php $this->load->view('frontend/public/category_list'); ?>
                <br class="d-xs-block d-md-block d-lg-none d-sm-block">
                <h5 class="d-xs-block d-md-block d-lg-none mb-0 text-right text-destacado">OFERTAS DEL MES</h5>
            </div>
            <div class="col-lg-12 col-md-12 col-12">
                <br class="d-xs-inline d-md-none">
                <div class="row">
                    <?php $this->load->view('frontend/public/products_list') ?>
                    <?php if ($load_Products) : ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5>No se encontraron productos.</h5>
                                </div>
                            </div>
                            </div>
                    <?php endif ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo($links); ?>
                    </div>
                </div>
            </div>
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