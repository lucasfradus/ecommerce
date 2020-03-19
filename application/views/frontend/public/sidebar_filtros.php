
            <div>
                <div id="section-filtros-items" class="filtro">
                </div>
                <hr class="filtro-linea">
                <div class="panel-group panel-group-v2" id="accordion-productos">
                    
                    <button onclick="toggleCategories(event)" style="margin-bottom: 15px;" class="btn btn-inverse btn-block visible-xs text-center">CATEGORÍAS</button>
                    
                    <div class="section-categories-sidebar box-categories hide-mobile">
                        <?php foreach ($categorias as $key => $categoria): ?>
                            <?php $show = ''; ?>
                            <?php if (isset($categoria_selected) && $categoria->id_category == $categoria_selected->id_category): ?>
                                <?php $show = 'in'; ?>
                            <?php endif ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="<?php echo base_url('categoria/'.$categoria->id_category.'/'.url_title($categoria->name,'-',TRUE)) ?>" class="text-uppercase <?php echo empty($show)? 'collapsed' : '' ?>" data-parent="#accordion-productos"><?php echo $categoria->name ?></a>
                                    </h4>
                                </div>
                                <div id="collapse<?php echo $key ?>" class="panel-collapse collapse <?php echo $show ?>" aria-expanded="<?php echo !empty($show) ? 'true' : 'false' ?>">
                                    <div class="panel-body">
                                        <?php foreach ($subcategorias as $key => $subcategoria): ?>
                                            <?php $active = ''; ?>
                                            <?php if (isset($subcategoria_selected) && $subcategoria_selected->id_subcategory == $subcategoria->id_subcategory): ?>
                                                <?php $active = 'active'; ?>
                                            <?php endif ?>
                                            <?php if($categoria->id_category == $subcategoria->id_category): ?>
                                                <p><a href="<?php echo base_url('subcategoria/' . $subcategoria->id_subcategory . '/' . url_title($subcategoria->name,'-',TRUE)) ?>" class="<?php echo $active ?>"><?php echo $subcategoria->name ?></a></p>
                                                <?php if (!empty($active)): ?>
                                                    <?php foreach ($segundas_subcategorias as $key => $segunda_subcategoria): ?>
                                                        <?php $active = ''; ?>
                                                        <?php if (isset($segunda_subcategoria_selected) && $segunda_subcategoria_selected->id_second_subcategory == $segunda_subcategoria->id_second_subcategory): ?>
                                                            <?php $active = 'active'; ?>
                                                        <?php endif ?>
                                                        <?php if ($segunda_subcategoria->id_subcategory == $subcategoria->id_subcategory): ?>
                                                            <p class="pl-3"><a href="<?php echo base_url('segunda-subcategoria/' . $segunda_subcategoria->id_second_subcategory . '/' . url_title($segunda_subcategoria->name,'-',TRUE)) ?>" class="<?php echo $active ?>"><?php echo $segunda_subcategoria->name ?></a></p>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <p class="visible-xs">&nbsp;</p>
                    </div>

                    <button onclick="toggleFilters(event)" class="btn btn-inverse btn-block visible-xs text-center">FILTROS</button>

                    <div class="hide-mobile">
                        <br>
                        <hr class="filtro-linea hide-mobile">
                        <br>
                    </div>

                    <div class="section-filters-sidebar box-filtros hide-mobile">
                        <?php if ($talles ||  $colores || $tacos): ?>

                            <form id="formFiltroSidebar" method="GET" action="<?php echo isset($form_base) ? $form_base : base_url('productos') ?>">
                                <input type="hidden" name="color" value="<?php echo $this->input->get('color') ?>">
                                <input type="hidden" name="talle" value="<?php echo $this->input->get('talle') ?>">
                                <input type="hidden" name="taco" value="<?php echo $this->input->get('taco') ?>">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5>
                                            FILTRAR
                                        </h5>
                                    </div>
                                </div>

                                <?php if ($talles): ?>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse9">TALLE</a>
                                            </h4>
                                        </div>
                                        <div id="collapse9" class="panel-collapse">
                                            <div class="panel-body">
                                                <?php foreach ($talles as $key => $value): ?>
                                                    <div style="display: inline-block;">
                                                        <a href="#" onclick="selectSizeFiltro(event,this)" data-id="<?php echo $value->id_size ?>" class="seccion-talle <?php echo ($value->id_size == $this->input->get('talle')) ? 'active' : '' ?>"><?php echo $value->name ?></a>
                                                    </div>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif ?>

                                <?php if ($colores): ?>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse10">COLOR</a>
                                            </h4>
                                        </div>
                                        <div id="collapse10" class="panel-collapse">
                                            <div class="panel-body">
                                                <div class="seccion-color">
                                                    <?php foreach ($colores as $key => $value): ?>
                                                        <p>
                                                            <span style="cursor: pointer;" onclick="selectColorFiltro(event,this)" data-id="<?php echo $value->id_color ?>" class="span-color <?php echo ($value->id_color == $this->input->get('color')) ? 'active' : '' ?>">
                                                                <span class="span-color-fondo" style="background-color: <?php echo $value->color ?>;"></span>
                                                            </span>
                                                            <span class="span-texto"><?php echo $value->name ?></span>
                                                        </p>
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif ?>

                                <?php if ($tacos): ?>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse11">
                                                    TACO</a>
                                            </h4>
                                        </div>
                                        <div id="collapse11" class="panel-collapse">
                                            <div class="panel-body">
                                                <div class="seccion-taco">
                                                    <?php foreach ($tacos as $key => $value): ?>
                                                        <p>
                                                            <span style="cursor: pointer;" onclick="selectTacoFiltro(event, this)" data-id="<?php echo $value->id_heel ?>" class="span-taco <?php echo ($value->id_heel == $this->input->get('taco')) ? 'active' : '' ?>">
                                                                <span class="span-taco-fondo"></span>
                                                            </span>
                                                            <span class="span-texto"><?php echo $value->name ?></span>
                                                        </p>
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif ?>

                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn-buscar hidden-xs hidden-sm" style=";padding-left: 15px;">BUSCAR</button>
                                        <button type="submit" class="btn-buscar visible-xs visible-sm btn-block" >BUSCAR</button>
                                    </div>
                                </div>
                            </form>
                        <?php endif ?>
                    </div>
                </div>
            </div>


            <br class="visible-xs visible-sm"/>

            <script type="text/javascript">
                var formFiltro = $(document.getElementById('formFiltroSidebar'));
                function selectTacoFiltro(event, elemento) {
                    event.preventDefault();
                    var tacoId = $(elemento).attr('data-id');
                    formFiltro.find('input[name="taco"]').val(tacoId);
                    $(elemento).closest('div.panel-body').find('.span-taco').removeClass('active');
                    $(elemento).addClass('active');
                }
                function selectColorFiltro(event, elemento) {
                    event.preventDefault();
                    var colorId = $(elemento).attr('data-id');
                    formFiltro.find('input[name="color"]').val(colorId);
                    $(elemento).closest('div.panel-body').find('.span-color').removeClass('active');
                    $(elemento).addClass('active');
                }
                function selectSizeFiltro(event, elemento) {
                    event.preventDefault();
                    var sizeId = $(elemento).attr('data-id');
                    formFiltro.find('input[name="talle"]').val(sizeId);
                    $(elemento).closest('div.panel-body').find('a').removeClass('active');
                    $(elemento).addClass('active');
                }

                function removeFilterForm(event, elemento) {
                    event.preventDefault();
                    var type = $(elemento).attr('type');
                    formFiltro.find('input[name="'+type+'"]').val('');
                    formFiltro.submit();
                }

                function initFilters() {
                    
                    if($("form#formFiltroSidebar").length) {

                        var talleSelected = $("form#formFiltroSidebar").find('a.seccion-talle.active');
                        var tacoSelected = $("form#formFiltroSidebar").find('span.span-taco.active');
                        var colorSelected = $("form#formFiltroSidebar").find('span.span-color.active');

                        var innerHtml = '';

                        if (talleSelected.length) {
                            innerHtml += '<a href="#" onclick="removeFilterForm(event, this)" type="talle" class="filtro-texto"> X ' + talleSelected.text() + '</a>';
                        }

                        if (colorSelected.length) {
                            innerHtml += '<a href="#" onclick="removeFilterForm(event, this)" type="color" class="filtro-texto"> X ' + colorSelected.next('.span-texto').text() + '</a>';    
                        }
                        
                        if (tacoSelected.length) {
                            innerHtml += '<a href="#" onclick="removeFilterForm(event, this)" type="taco" class="filtro-texto"> X ' + tacoSelected.next('.span-texto').text() + '</a>';    
                        }

                        $("div#section-filtros-items").html(innerHtml);

                    }

                }

                function toggleFilters(event)
                {
                    event.preventDefault();
                    $("div.box-filtros").toggleClass('hide-mobile');
                }

                function toggleCategories(event)
                {
                    event.preventDefault();
                    $("div.box-categories").toggleClass('hide-mobile');
                }

                initFilters();
            </script>