<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs" role="tablist" id="myTab">
			<?php $i = 0; foreach ($padres as $f) {?>
				<li class="nav-item"><a href="#tabAccesoDirecto_<?php echo $f->id_menu?>" class="nav-link <?php if($i == 0){ echo 'active'; $i = 1;}?>" role="tab" data-toggle="tab"><?php echo $f->description ?></a></li>
			<?php } ?>
		</ul>
	</div>
	<div class="col-xs-12">
		<div class="tab-content miTab">				  	
		  	<?php $i = 0; foreach ($padres as $f) {?>
				<div class="tab-pane <?php if($i == 0){ echo 'active'; $i = 1;}?>" id="tabAccesoDirecto_<?php echo $f->id_menu?>">
			  		<div class="row" style="padding: 30px;">
			  			<?php foreach ($hijos as $h) {?>
				  			<?php if($h->parent == $f->id_menu){?>
					  			<div class='col-xs-4'>
									<a href='<?php echo base_url().$h->link?>' class='btn btn-icon btn-block'>
										<i class='<?php echo $h->iconpath?> fa-3x'></i><p><?php echo $h->description?></p>
									</a>
								</div>
							<?php } ?>
						<?php } ?>
			  		</div>
			  	</div>
			<?php } ?>  	
		</div>
	</div>
</div>