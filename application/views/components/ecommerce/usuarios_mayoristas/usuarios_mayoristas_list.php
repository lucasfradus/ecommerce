<div class="col-lg-12">
    <div class="element-box">
        <div class="text-right">            
            <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url('ecommerce/usuarios_mayoristas/add') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Usuario</a><?php } ?><hr>
        </div>        
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th width="10%">ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Compras Realizadas</th>
                    <th>Habilitado</th>
                    <th width="15%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $result) { ?>
                  <?php if($result->active > 0 && $result->type_id == 2):?> 
                  <tr>
                    <td><?php echo $result->id_users ?></td>
                    <td><?php echo $result->name.' '.$result->surname ?></td>
                    <td><?php echo $result->email ?></td> 
                    <td align="center">
                        <a href="<?php echo base_url('ecommerce/usuarios_mayoristas/compras/'.$result->id_users) ?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Compras Realizada</a>
                    </td>
                    <td align="center"><?php if($result->status_code_confirmation==1){?><i class="fa fa-check"></i><?php } else {?><i class="fa fa-times"></i><?php }?></td>
                    <td width="15%" align="right">
                      <div class="btn-group">
                        <a data-toggle="modal" href="<?php echo base_url().'ecommerce/usuarios_mayoristas/view/'.$result->id_users ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                        <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'ecommerce/usuarios_mayoristas/edit/'.$result->id_users ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                        <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'ecommerce/usuarios_mayoristas/deletelogic/'.$result->id_users ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                      </div>
                    </td>
                  </tr>
                  <?php endif ?>
              <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<SCRIPT TYPE="text/javascript">
    function cambiarValor(id){
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            type: "POST",
            url: base_url + 'cms/usuarios/cambiarValor',
            data: {id: id},
            dataType:'json',
            cache: false,
            beforeSend: function(){
                $('#usuario_'+id).html('<a href="javascript:void(0);"> <i class="fa fa-refresh fa-spin"></i></a>');
            },
            success: function(respuesta){
                var menu = eval(respuesta);     
                // console.log(menu);
                if (menu.id == 1) {
                    $('#usuario_'+id).html('<a id="'+id+'" href="javascript:cambiarValor('+id+')"> <i class="fa fa-check"></i></a>');
                }else{
                    $('#usuario_'+id).html('<a id="'+id+'" href="javascript:cambiarValor('+id+')"> <i class= "fa fa-times"></i></a>');
                } 
                // $('#articulos_portada_'+id).val(menu.id);
            },
            error:function(){
                console.log('error');
            }
        }); 
    }

</SCRIPT>