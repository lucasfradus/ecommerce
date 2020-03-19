<div class="bg-white">
    <button class="navbar-toggler d-block d-sm-block d-md-block d-lg-none btn btn-categories" type="button" data-toggle="collapse" data-target="#categories" aria-controls="categories" aria-expanded="true" aria-label="Toggle navigation">
        CATEGORIAS
    </button>
    <h4 class="list-categories-title d-none d-sm-none d-md-none d-lg-block">
        CATEGORIAS
    </h4>
    <div class="collapse d-lg-block" id="categories">
        <div class="accordion" id="acordionCategories">
            <?php foreach ($categories as $i => $c) : ?>
            <div class="card">
                <div class="card-header <?php if($category) { echo ($category->id_category==$c->id_category) ? '' : 'collapsed';} else {echo('collapsed');} ?>" id="header<?php echo($c->id_category) ?>" data-toggle="collapse" data-target="#collapse<?php echo($c->id_category) ?>" aria-expanded="true" aria-controls="collapse<?php echo($c->id_category) ?>">
                    <p class="mb-0">
                        <a class="text-uppercase <?php if($category){if($category->id_category==$c->id_category){ echo ('active');}} ?>" href="<?php if(isset($offer)){echo(base_url('ofertas').'/'.$c->id_category.'/1');}else{echo(base_url('productos').'/'.$c->id_category.'/1');}?>">
                            <?php echo($c->name); ?>
                        </a>
                        <a class="collapsed float-right p-0">
                            <span class="panel-icon">
                                <i class="fa fa-chevron-down <?php if($category){if($category->id_category==$c->id_category){ echo ('active');}} ?>"></i>
                            </span>
                        </a>
                    </p>
                </div> 
                <div id="collapse<?php echo($c->id_category) ?>" class="collapse <?php if($category){if($category->id_category==$c->id_category){echo('show');}} ?>" aria-labelledby="header<?php echo($c->id_category) ?>" data-parent="#acordionCategories">
                    <div class="card-body  p-0">
                        <div class="list-group ml-2">
                            <?php foreach ($subcategories as $in => $s) : ?> 
                                <?php if($c->id_category == $s->id_category) : ?>
                                    <a href="<?php if(isset($offer)){echo(base_url('ofertas').'/'.$s->id_subcategory.'/2');}else{echo(base_url('productos').'/'.$s->id_subcategory.'/2');}?>" class="list-group-item list-group-item-action bg-transparent <?php if($category){if($category->id_subcategory==$s->id_subcategory){ echo ('active');}} ?>" tabindex="-1" aria-disabled="true"><?php echo($s->name); ?></a>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</div>