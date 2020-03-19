
<style>
.hidden {
	display: none;
}

</style>



<div class="col-lg-12">
    <div class="ibox-content">
		<?php
		echo form_open(current_url(), array('class' => "", 'id' => 'myForm'));
		echo form_hidden('enviar_form', '1');
		?>
			<div class="text-right">
				<button class="btn btn-success" onclick="enviar()"><i class='fa fa-floppy-o'></i> Guardar</button>
				<a class="btn btn-danger" href="<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2); ?>"><i class="fa fa-arrow-circle-left"></i> Volver</a><hr>
			</div>
					<div class="row">
						<div class="col-md-3">
							<label for="name_differentias_discounts">Nombre<span class="required">*</span></label>
							<input required id="name_differentias_discounts" name="name_differentias_discounts" type="text" class="form-control" placeholder="Nombre" />
							<span id="name_differentias_discounts_id" class="hidden">Por Favor completar el Nombre</span>
						</div>
						<div class="col-sm-2">
							<label for="name_differentias_discounts"> <span class="required"></span></label>
							<input type='button' value='Agregar Rango' id='addsection' class="addsection form-control btn btn-primary btn-md">
						</div>
						
					</div>
					
				<div id="sections">
					<div class="section container">
						<fieldset>
						Rango
							<div class="row">
								<div class="col-md-3">
									<label for="min">Cantidad Minima<span class="required">*</span></label>
									<input required id="min_" name="min[]" type="number" min=1 class="form-control" placeholder="Ej:0" />
									<span id="min_val_" class="hidden"></span>
								</div>
								<div class="col-sm-3">
									<label for="max">Cantidad Máxima<span class="required">*</span></label>
									<input required  id="max_"  name="max[]" type="number" min=1 class="form-control" placeholder="Ej:5" />
									<span id="max_val_" class="hidden"></span>
								</div>
								<div class="col-sm-3">
									<label for="name_differentias_discounts">% Descuento<span class="required">*</span></label>
									<input required  id="desc_"  name="desc[]" type="number" min=1 max=99 class="form-control" placeholder="Ej:10" />
								</div>
								<div class="col-sm-2">
									<label for="name_differentias_discounts"><span class="required"></span></label><br>
									<button class="remove btn btn-danger btn-md"><i class="fa fa-trash"></i></button>
								</div>
							</div>
							
						</fieldset>
					</div>
				</div>
	</div>
</div>
					
<?php echo form_close(); ?>



<script>

function enviar(){
	if(myFunction()){
		console.log("Se volvio a escapar y trato de enviar el form");
		//document.getElementById("myForm").submit();
	}else{
		console.log("se encotraron errores en el formulario");
	}
}



function myFunction(value,id) {
	var nombre =  $("#name_differentias_discounts").val();
	if (nombre.length == 0){ 
			$('#name_differentias_discounts_id').removeClass("hidden").addClass("text-danger");
			return false;	  
      }else{
		$('#name_differentias_discounts_id').removeClass("text-dangers").addClass("hidden");
			var max = $("input[name='max[]']")
				.map(function(){return $(this).val();}).get();
			var min = $("input[name='min[]']")
				.map(function(){return $(this).val();}).get();
			if(customValidate(max,min)){
				console.log("SE ESCAPA")
				return false;
			}else{
				console.log("error en la validacion de los campos numericos")
				return false;
			}		
	}
}


function customValidate(max,min) {
	if( max.length == 0 && min.length ==0){
		alert("Al menos debe completar un rango de descuento")	
		return false;
	}else  if( max.length == 1 && min.length ==1){
		if(min[0]>max[0]){
			//alert("El valor minimo del rango no puede ser mayor al Valor Mayor del rango")
			$('#min_val_').removeClass("hidden").addClass("text-danger").text("El valor minimo del rango no puede ser mayor al Valor Mayor del rango");
			return false;
		}else{
			$('#min_val_').removeClass("text-danger").addClass("hidden").text("");
			alert("Se esta queriendo escapar")
			return false;
		}
	}else{
		//valido el array de maximos
		for (var i = 0; i < max.length - 1; i++) {
				if (max[i] > max[i+1]) {
					$('#max_val_').removeClass("hidden").addClass("text-danger").text("El valor de la cantidad máxima no puede ser menor al valor del rango anterior");
					return false;
					break;
   				 }
					$('#max_val_').removeClass("text-danger").addClass("hidden").text("");
			}
		//valido el array de minimos
		for (var i = 0; i < min.length - 1; i++) {
				if (min[i] > min[i+1]) {
					$('#min_val_').removeClass("hidden").addClass("text-danger").text("El valor de la cantidad mínima no puede ser menor al valor del rango anterior");
		
					return false;
					break;
   				 }
					$('#min_val_').removeClass("text-danger").addClass("hidden").text("");
			}
		//valido cruzadamente los min y ma	
			for (var i = 0; i < min.length; i++) {
				if (min[i] > max[i]) {
					$('#min_val_'+i).removeClass("hidden").addClass("text-danger").text("El valor minimo no puede ser más alto que el valor del mayor");
					console.log("Se encontro un valor incongruente");
					return false;
					break;
   				 }
					$('#min_val_').removeClass("text-danger").addClass("hidden").text("");

					if (min[i+1] <= max[i]) {
					$('#min_val_').removeClass("hidden").addClass("text-danger").text("El valor minimo no puede ser más alto que el valor del mayor");
					console.log("Se encontro un valor incongruente parte 2");
					return false;
					break;
   				 }
					$('#min_val_').removeClass("text-danger").addClass("hidden").text("");
		
			}
			console.log("valor en un array son congruentes")
			return false;
	}
	
}



//define template
var template = $('#sections .section:first').clone();

//define counter
var sectionsCount = 1;

//add new section
$('body').on('click', '.addsection', function() {

    //increment
    sectionsCount++;

    //loop through each input
    var section = template.clone().find(':input').each(function(){

        //set id to store the updated section number
        var newId = this.id + sectionsCount;

        //update for label
        $(this).prev().attr('for', newId);

        //update id
        this.id = newId;

    }).end()

    //inject new section
    .appendTo('#sections');
    return false;
});

//remove section
$('#sections').on('click', '.remove', function() {
    //fade out section
    $(this).parent().fadeOut(300, function(){
        //remove parent element (main section)
        $(this).parent().parent().empty();
        return false;
    });
    return false;
});




</script>