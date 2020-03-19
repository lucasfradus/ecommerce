<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/frontend/extras/jquery-ui/jquery-ui.min.css') ?>">
<div class="col-lg-12">
    <div class="element-box">
        <?php     
            echo form_open_multipart(current_url(), array('class'=>""));
            echo form_hidden('enviar_form','1');
        ?>
            <div class="hide">
                <div class="col-sm-6">
                    <div class="form-group">
                        <input id="minimo" name="minimo" type="hidden" class="form-control" placeholder="Min." value="0" />
                    </div>
                </div>  
            </div>
            <input id="maximo" name="maximo" type="hidden" class="form-control" placeholder="Max." value="0" />
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="salarial"> Rangos de Descuento</label>
                </div>
                    <p>
                        <input type="text" id="amount-perfil" readonly style="border:0; color:#f6931f; font-weight:bold;">
                    </p>
                <div id="slider-range-perfil"></div>
                <br>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="discount">Descuento<span class="required">*</span></label>
                        <input id="discount" step=".01" type="number" min="1" max="99" name="discount" value="" class="form-control" />  
                    </div>
                </div>
            </div>
            <hr>
            <div class="controls">
                <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), 'Guardar'); ?> 
                <a class="btn btn-danger" href="javascript:window.history.back();"><i class="fa fa-arrow-left"></i> Volver</a>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script src="<?php echo base_url('assets/frontend/extras/jquery-ui/jquery-ui.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('assets/frontend/extras/bootstrapvalidator/js/bootstrapValidator.js')?>"></script>
<script type="text/javascript">
    var minimo = 0;
    var maximo = 0;
   
    $(function() {
         $( "#slider-range-perfil" ).slider({
           range: true,
           min: 0,
           max: 10000000,
           step: 50,
           values: [ minimo, maximo],
           slide: function( event, ui ) {
            $("#amount-perfil").val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
            $("#minimo").val(ui.values[ 0 ]);
            $("#maximo").val(ui.values[ 1 ]);
           }    
         });
         
         $( "#amount-perfil" ).val( "$" + $( "#slider-range-perfil" ).slider( "values", 0 ) +
           " - $" + $( "#slider-range-perfil" ).slider( "values", 1 ) );
        });
        
    
</script>