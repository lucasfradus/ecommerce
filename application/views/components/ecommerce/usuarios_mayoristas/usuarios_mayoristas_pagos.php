<div class="col-lg-12">
    <div class="element-box">
        <div class="text-right">            
            <a href="javascript:history.back(1)" class="btn btn-danger"> Volver</a> 
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h4>DATOS DEL USUARIO MAYORISTA</h4>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Nombre</label>
                    <input readonly="" type="text" class="form-control" name="" value="<?php echo $user->name ?> <?php echo $user->surname ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Telefono</label>
                    <input readonly="" type="text" class="form-control" name="" value="<?php echo $user->phone ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Email</label>
                    <input readonly="" type="text" class="form-control" name="" value="<?php echo $user->email ?>">
                </div>
            </div>
        </div>
        <hr>
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th width="15%"><a href="#">ID</a></th>
                    <th><a href="#">Fecha</a></th>
                    <th><a href="#">Importe</a></th>
                    <th><a href="#">Estado del Pedido</a></th>
                    <th width="10%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $result) { ?>
                  <tr>
                    <td>PED-<?php echo sprintf("%09d", $result->id_order) ?></td>
                    <td><?php echo  date('d/m/Y h:i a', strtotime($result->created_at)) ?></td>
                    <td>$&nbsp;<?php echo number_format(( $result->subtotal + $result->cost_shipping - $result->discount ) , 2, '.', '') ?></td>
                    <td><?php echo $result->name ?></td>
                    <td align="center">
                      <div class="btn-group">
                        <a data-toggle="modal" href="<?php echo base_url().'ecommerce/pedidos/view/'.$result->id_order ?>" data-target="#myModalLarge" class="btn btn-info"><i class="fa fa-search"></i></a>
                      </div>
                    </td>
                  </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- <script type="text/javascript">
    $(document).on("click",".btn-add-pago",function(event){
        event.preventDefault();
        $("#modalPago").modal("show");
    });

    $(document).on("submit","#formPago",function(event){
        event.preventDefault();
        var datos = $("#formPago").serialize();
        var id = $("#pagoIdAfiliado").val();
        datos+="&id="+id;
        $.ajax({
            url:"<?php echo base_url() ?>backend/afiliados/agregarPago",
            data:datos,
            type:"POST",
            dataType:"json",
        }).done(function(response){
            var dataJson = eval(response);
            location.reload();
        }).fail(function(){
            console.log("error");
        });
    });
</script> -->