<section class="section-slider position-relative ">
    <div id="slider" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($sliders as $key => $value) : ?>
                <div class="carousel-item <?php echo ($key == 0)? 'active' : '' ?>">
                    <div class="img-fluid d-none d-md-block d-xl-block"  style="background: url('<?php echo base_url().'uploads/img_slider/'.$value->image; ?>');background-size: cover;background-position: center;background-repeat: no-repeat;height: 450px;"></div>
                    <div class="img-fluid d-none d-sm-block d-md-none"  style="background: url('<?php echo base_url().'uploads/img_slider/'.$value->image; ?>');background-size: cover;background-position: center;background-repeat: no-repeat;height: 300px;"></div>
                    <div class="img-fluid d-block d-sm-none"  style="background: url('<?php echo base_url().'uploads/img_slider/'.$value->image; ?>');background-size: cover;background-position: center;background-repeat: no-repeat;height: 200px;"></div>
                </div>
            <?php endforeach ?>
        </div>
        <a class="carousel-control-prev" href="#slider" data-slide="prev">
            <span class="my-carousel-control-prev-icon"><i class="fas fa-chevron-left"></i></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#slider" data-slide="next">
            <span class="my-carousel-control-next-icon"><i class="fas fa-chevron-right"></i></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>
