<?php
include '../src/Afip.php'; 

// CbteTipo = 1 = Factura
// DocTipo = 80 = CUIT

$data = array(
	'CantReg' 		=> 1, // Cantidad de comprobantes a registrar
	'PtoVta' 		=> 1, // Punto de venta
	'CbteTipo' 		=> 6, // Tipo de comprobante (ver tipos disponibles) 
	'Concepto' 		=> 1, // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
	'DocTipo' 		=> 80, // Tipo de documento del comprador (ver tipos disponibles)
	'DocNro' 		=> 20111111112, // Numero de documento del comprador
	'CbteDesde' 	=> 1, // Numero de comprobante o numero del primer comprobante en caso de ser mas de uno
	'CbteHasta' 	=> 1, // Numero de comprobante o numero del ultimo comprobante en caso de ser mas de uno
	'CbteFch' 		=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
	'ImpTotal' 		=> 184.05, // Importe total del comprobante
	'ImpTotConc' 	=> 0, // Importe neto no gravado
	'ImpNeto' 		=> 150, // Importe neto gravado
	'ImpOpEx' 		=> 0, // Importe exento de IVA
	'ImpIVA' 		=> 26.25, //Importe total de IVA
	'ImpTrib' 		=> 7.8, //Importe total de tributos
	'FchServDesde' 	=> NULL, // (Opcional) Fecha de inicio del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
	'FchServHasta' 	=> NULL, // (Opcional) Fecha de fin del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
	'FchVtoPago' 	=> NULL, // (Opcional) Fecha de vencimiento del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
	'MonId' 		=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
	'MonCotiz' 		=> 1, // Cotización de la moneda usada (1 para pesos argentinos)  
	'CbtesAsoc' 	=> array( // (Opcional) Comprobantes asociados
		array(
			'Tipo' 		=> 6, // Tipo de comprobante (ver tipos disponibles) 
			'PtoVta' 	=> 1, // Punto de venta
			'Nro' 		=> 1, // Numero de comprobante
			'Cuit' 		=> 20111111112 // (Opcional) Cuit del emisor del comprobante
			)
		),
	'Tributos' 		=> array( // (Opcional) Tributos asociados al comprobante
		array(
			'Id' 		=>  99, // Id del tipo de tributo (ver tipos disponibles) 
			'Desc' 		=> 'Ingresos Brutos', // (Opcional) Descripcion
			'BaseImp' 	=> 150, // Base imponible para el tributo
			'Alic' 		=> 5.2, // Alícuota
			'Importe' 	=> 7.8 // Importe del tributo
		)
	),
	'Iva' 			=> array( // (Opcional) Alícuotas asociadas al comprobante
		array(
			'Id' 		=> 5, // Id del tipo de IVA (ver tipos disponibles) 
			'BaseImp' 	=> 100, // Base imponible
			'Importe' 	=> 26.25 // Importe 
		)
	), 
	'Opcionales' 	=> array( // (Opcional) Campos auxiliares
		array(
			'Id' 		=> 17, // Codigo de tipo de opcion (ver tipos disponibles) 
			'Valor' 	=> 2 // Valor 
		)
	),
	'Compradores' 	=> array( // (Opcional) Detalles de los clientes del comprobante 
		array(
			'DocTipo' 		=> 80, // Tipo de documento (ver tipos disponibles) 
			'DocNro' 		=> 20111111112, // Numero de documento
			'Porcentaje' 	=> 100 // Porcentaje de titularidad del comprador
		)
	)
);


$data_afip = array(
	'CUIT' 	=> 	'20347468631',
	'cert' 	=> 	'facturacionhome1',
	'key' 	=>	'homemaker'
);

$afip = new Afip($data_afip);

//$last_voucher = $afip->ElectronicBilling->GetLastVoucher(1,6);

//$res = $afip->ElectronicBilling->CreateNextVoucher($data);

/*

$voucher_info = $afip->ElectronicBilling->GetVoucherInfo(2,1,6); //Devuelve la información del comprobante 1 para el punto de venta 1 y el tipo de comprobante 6 (Factura B)

if($voucher_info === NULL){
    echo 'El comprobante no existe';
}
else{
    echo 'Esta es la información del comprobante:';
    echo '<pre>';
    print_r($voucher_info);
    echo '</pre>';
}


$aloquot_types = $afip->ElectronicBilling->GetAliquotTypes();
echo '<pre>';
print_r($aloquot_types);
echo '</pre>';

*/

	$data = array(
		'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
		'PtoVta' 	=> 1,  // Punto de venta
		'CbteTipo' 	=> 6,  // Tipo de comprobante (ver tipos disponibles) 
		'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
		'DocTipo' 	=> 99, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
		'DocNro' 	=> 0,  // Número de documento del comprador (0 consumidor final)
		//'CbteDesde' 	=> $last_voucher+1,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
		//'CbteHasta' 	=> $last_voucher+1,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
		'CbteFch' 	=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
		'ImpTotal' 		=> 242, // Importe total del comprobante
		'ImpTotConc' 	=> 0,   // Importe neto no gravado
		'ImpNeto' 	=> 200, // Importe neto gravado
		'ImpOpEx' 	=> 0,   // Importe exento de IVA
		'ImpIVA' 	=> 42,  //Importe total de IVA
		'ImpTrib' 	=> 0,   //Importe total de tributos
		'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
		'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
		'Iva' 		=> array( // (Opcional) Alícuotas asociadas al comprobante
			array(
				'Id' 		=> 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
				'BaseImp' 	=> 100, // Base imponible
				'Importe' 	=> 21 // Importe 
			),
			array(
				'Id' 		=> 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
				'BaseImp' 	=> 100, // Base imponible
				'Importe' 	=> 21 // Importe 
			)
		), 
	);

	$res = $afip->ElectronicBilling->CreateNextVoucher($data);

	$res['CAE']; //CAE asignado el comprobante
	$res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)

	print_r($res);



//CUIT:20347468631
//CLAVE FISCAL: eber2014

//$afip->ElectronicBilling->CreateVoucher($data);

?>