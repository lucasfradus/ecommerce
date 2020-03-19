<style type="text/css">
	.row-no-gutter {
	margin-right: 0;
	margin-left: 0;
}

.row-no-gutter [class*="col-"] {
	padding-right: 0;
	padding-left: 0;
}


#card {
	background: #fff;
	position: relative;

	-webkit-box-shadow: 0px 1px 10px 0px rgba(207,207,207,1);
	-moz-box-shadow: 0px 1px 10px 0px rgba(207,207,207,1);
	box-shadow: 0px 1px 10px 0px rgba(207,207,207,1);

	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-ms-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;	
}

.weater{
	margin-bottom: 20px;
}

.city-selected {
	position: relative;
	overflow: hidden;
	min-height: 180px;
	background: #1584c7;
	width: 100%;
}

article {
	position: relative;
	z-index: 2;
	color: #fff;
	padding: 20px;

	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-webkit-flex-direction: row;
	-ms-flex-direction: row;
	flex-direction: row;
	-webkit-flex-wrap: wrap;
	-ms-flex-wrap: wrap;
	flex-wrap: wrap;
	-webkit-justify-content: space-between;
	-ms-flex-pack: justify;
	justify-content: space-between;
	-webkit-align-content: flex-start;
	-ms-flex-line-pack: start;
	align-content: flex-start;
	-webkit-align-items: flex-start;
	-ms-flex-align: start;
	align-items: flex-start;
}

.info .city,
.night {
	font-size: 24px;
	font-weight: 200;
	position: relative;


	-webkit-order: 0;
	-ms-flex-order: 0;
	order: 0;
	-webkit-flex: 0 1 auto;
	-ms-flex: 0 1 auto;
	flex: 0 1 auto;
	-webkit-align-self: auto;
	-ms-flex-item-align: auto;
	align-self: auto;
}

.info .city:after {
	content: '';
	width: 15px;
	height: 2px;
	background: #fff;
	position: relative;
	display: inline-block;
	vertical-align: middle;
	margin-left: 10px;
}

.city span {
	color: #fff;
	font-size: 13px;
	font-weight: bold;

	text-transform: lowercase;
	text-align: left;
}

.night {
	font-size: 15px;
	text-transform: uppercase;
}

.icon {
	width: 84px;
	height: 84px;
	-webkit-order: 0;
	-ms-flex-order: 0;
	order: 0;
	-webkit-flex: 0 0 auto;
	-ms-flex: 0 0 auto;
	flex: 0 0 auto;
	-webkit-align-self: center;
	-ms-flex-item-align: center;
	align-self: center;

	overflow: visible;

}
.icon i{
	font-size: 50px;
	float: right;
}

.temp {
	font-size: 40px;
	display: block;
	position: relative;
	font-weight: bold;
}

.city-selected:hover figure {
	opacity: 0.4;
}


figure {
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
    background-position: center;
    background-size: cover;
    opacity: 0.1;
    z-index: 1;

    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -ms-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

.days .row [class*="col-"]:nth-child(2) .day  {
    border-width: 0 1px 0 1px;
    border-style: solid;
    border-color: #eaeaea;
}

.days .row [class*="col-"] {
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-ms-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;	
}

.days .row [class*="col-"]:hover{
	background: #eaeaea;
}

.day {
	padding: 10px 0px;
	text-align: center;

}

.day h1 {
	font-size: 14px;
	text-transform: uppercase;
	margin-top: 10px;
}

.day svg {
	color: #000;
	width: 32px;
	height: 32px;
}
</style>

<div class="col-lg-12">
    <div class="ibox-content">
		<div class="text-right">
			<a href="javascript:history.back(1)" class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		</div>
		<br>
		<table id="results" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th class="col-md-1"><a href="#">ID</a></th>
                    <th class="col-md-2"><a href="#">Dia</a></th>
                    <th><a href="#">Comisiones Paypal</a></th>
                    <th><a href="#">Comisiones Payu</a></th>
                    <th class="col-md-2"><a href="#">Saldo</a></th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $value) { ?>
                  <tr>
                    <td><?php echo $value->id ?></td>
                    <td><?php echo $value->create ?></td>
                    <?php if ($value->medio_pago_id == 1): ?>
                        <td align="right">--</td>
                        <td align="right">$<?php echo $value->precio ?></td>
                    <?php else: ?>    
                        <td align="right">$<?php echo $value->precio ?></td>
                        <td align="right">--</td>
                    <?php endif ?>
                    <td>--</td>
                  </tr>
              <?php } ?>
            </tbody>
        </table>
	</div>
</div>