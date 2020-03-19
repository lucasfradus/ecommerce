<?php

if (!function_exists('calcularNeto'))
{
    function calcularNeto($precio, $iva)
    {
        $neto = $precio / (($iva / 100) + 1);
        return round($neto, 2);
    }
}

if (!function_exists('calcularIVA'))
{
    function calcularIVA($precio, $iva)
    {
        $neto = $precio / (($iva / 100) + 1);
        return round($precio - $neto, 2);
    }
}

if (!function_exists('datosCompradorFactura'))
{
    function datosCompradorFactura($usuario)
    {
        $CI =& get_instance();

        $tipo_documento = 80;

        switch ($usuario->id_condition_iva)
        {
            case '1':
                $afip_cliente = 'CONSUMIDOR FINAL';
                if (!empty($usuario->dni))
                {
                    $numero_documento = $usuario->dni;
                    $tipo_documento = 96;
                } else {
                    $numero_documento = 0;
                    $tipo_documento = 99;
                }
                $tipo_factura = FACTURA_B;
                break;

            case '2':
                $afip_cliente = 'MONOTRIBUTISTA';
                $numero_documento =  (double) $usuario->dni;
                $tipo_factura = FACTURA_B;
                break;

            case '3':
                $afip_cliente = 'RESPONSABLE INSCRIPTO';
                $numero_documento =  (double) $usuario->dni;
                $tipo_factura   =   FACTURA_A;
                break;

            case '4':
                $afip_cliente = 'EXENTO';
                $numero_documento =  (double)$usuario->dni;
                $tipo_factura = FACTURA_B;
                break;

            default:
                $afip_cliente = 'CONSUMIDOR FINAL';
                $tipo_factura = FACTURA_B;
                $numero_documento = 0;
                $tipo_documento = 99;
                break;
        }

        return [
            'tipo_factura' => $tipo_factura,
            'nombre_afip_cliente' => $afip_cliente,
            'numero_documento' => $numero_documento,
            'tipo_documento' => $tipo_documento,
        ];
    }
}

if (!function_exists('alicuotasVenta'))
{
    function alicuotasVenta($ventas_productos)
    {
        $items_iva = [];

        foreach ($ventas_productos as $k => $venta)
        {
            $alicutota = [
                'Id'        =>  $venta->afip_id,
                'BaseImp'   =>  $venta->net_price,
                'Importe'   =>  $venta->iva_amount,
            ];
            array_push($items_iva, $alicutota);
        }

        return $items_iva;
    }
}

if (!function_exists('documentoFactura'))
{
    function documentoFactura($datos_factura, $datos_cliente, $productos, $orden)
    {
        $ci = &get_instance();

        $path = APPPATH . '../assets/public/logo_limpieza_web.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $footer = APPPATH . '../assets/public/factura/footer_factura.png';
        $type = pathinfo($footer, PATHINFO_EXTENSION);
        $data = file_get_contents($footer);
        $footer = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $icon = APPPATH . '../assets/public/factura/whatsapp.png';
        $type = pathinfo($icon, PATHINFO_EXTENSION);
        $data = file_get_contents($icon);
        $icon = 'data:image/' . $type . ';base64,' . base64_encode($data);

        //$empresa_id = $ci->session->userdata('empresa_id');
        //$empresa = $ci->codegen_model->row('configuracion_empresas','*','id_configuration = "'.$empresa_id.'"');

        /*switch ($datos_cliente->afip)
        {
            case '1':
              $condicion_afip = "Responsable Inscripto";
            break;
            case '2':
              $condicion_afip = "Monotributista";
            break;
            case '3':
              $condicion_afip = "Consumidor Final";
            break;
            case '4':
              $condicion_afip = "Exento";
            break;
            default:
              $condicion_afip = "";
            break;
        }*/

        $cantidad_compras = count($productos);
        $subtotal = 0;

        $template = '<!DOCTYPE html>'.
          '<html lang="en">'.
            '<head>'.
              '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>'.
              '<title>Factura</title>'.
            '</head>'.
            '<style type="text/css">'.
              '*{'.
                    'font-family: Roboto-Regular, sans-serif;'.
                '}'.
                'p{'.
                    'margin-bottom: 4px;'.
                    'margin-top: 0px;'.
                    'font-size: 11px;'.
                '}'.
                'h4 {'.
                    'margin-bottom: 4px;'.
                '}'.
                'table{'.
                    'width: 100%;'.
                '}'.
                'table tr td, table tr th{'.
                    'font-size: 11px;'.
                '}'.
                '.table-footer{'.
                    'border: 1px solid #000;'.
                    'width: 100%;'.
                '}'.
                '.table-footer-afip{'.
                    'border: 1px solid #000;'.
                    'width: 100%;'.
                '}'.
                '.table-footer-afip tbody td{'.
                    'padding: 8px;'.
                '}'.
                '.table-description{'.
                    'height:600px;'.
                    'min-height: 600px;'.
                    'display:block;'.
                '}'.
                '.table-description td{'.
                    'font-size: 12px;'.
                    'height: 30px;'.
                '}'.
                '.tipo_factura{'.
                    'width: 46px;'.
                    'height: 42px;'.
                    'border: 1px solid #000;'.
                    'display: block;'.
                    'border-radius: 8px;'.
                    'margin-top:20px;'.
                    'text-align: center;'.
                    'font-size: 32px;'.
                    'padding: 4px;'.
                '}'.
                '.border-bottom{'.
                    'border-bottom: 1px solid #000;'.
                    'margin-bottom: 4px;'.
                    'display: inline-block;'.
                '}'.
                '.numero_factura{'.
                    'margin-top: 4px;'.
                    'margin-bottom: 2px;'.
                    'margin-left: 60px'.
                '}'.
                '.factura_title{'.
                    'margin-top: 4px;'.
                    'margin-bottom: 2px;'.
                    'margin-left: 60px'.
                '}'.
            '</style>'.
            '<body>'.
              '<header class="clearfix">'.
                
                '<table style="margin-bottom: 25px;position:relative;z-index:1001;">'.
                  '<tr>'.
                    '<td width="230" valign="top">'.
                        
                        '<table>'.
                            '<tr>'.
                                '<td><br/><br/>'.
                                    '&nbsp;&nbsp;&nbsp;'.
                                '</td>'.
                            '</tr>'.
                            /*'<tr>'.
                                '<td width="" valign="top">'.
                                    '<br/>'.
                                    '<h4 class="factura/_title" style="margin-bottom:5px;">DE FERNANDEZ J. EBER</h4>'.
                                    '<p style="line-height:16px;">'.$empresa->direccion.'</p>'.
                                    '<p><img src="'.$icon.'" width="15"> TEL: '.$empresa->telefono.'</p>'.
                                    '<p>'.$empresa->email.'</p>'.
                                    '<p>'.$empresa->sitio_web.'</p>'.
                                '</td>'.
                            '</tr>'. */
                        '</table>'.
                        
                    '</td>'.
                    '<td width="100%" align="center" valign="top">' .
                      '<h1 class="tipo_factura">' . $datos_factura['factura_letra'] . '</h1>' . 
                    '</td>'.
                    '<td width="200"><br>'.
                        '<h2 class="factura_title" style="margin-bottom:5px;">FACTURA</h2>'.
                        '<h2 class="numero_factura">N° '.$datos_factura['numero_factura'].'</h2>'.
                        /*'<h4 class="factura_title" style="margin-bottom:5px;">FECHA: '.date('d/m/Y').'</h4>'.
                        '<p>CUIT: '.$empresa->cuit.'</p>'.
                        '<p>ING.  BRUTOS: '.$empresa->ingresos_brutos.'</p>'.
                        '<p>Inic. Actividad: '.date('d/m/Y',strtotime($empresa->inicio_actividad)).'</p>'.
                        '<p>IVA RESPONSABLE INSCRIPTO</p>'.
                        '<p>Pe N° '.$datos_factura['numero_remito'].'</p>'.
                        '<p>Pr N° '.$datos_factura['numero_presupuesto'].'</p>'
                        */
                    '</td>'.
                  '</tr>'.
                '</table>'.
                
                '<table class="table-footer" style="margin-bottom: 5px;">'.
                    '<tr>'.
                        '<td>'.
                            '<div style="padding: 5px 15px;">'.
                                '<table>'.
                                    '<tbody>'.
                                        '<tr>'.
                                            '<td width="50%">'.
                                                '<div>RAZÓN SOCIAL: <span style="text-transform:uppercase;"> ' . $datos_cliente->name . ' ' . $datos_cliente->surname .'</span></div>'.
                                            '</td>'.
                                            '<td width="5%"></td>'.
                                            '<td width="40%">TELEFONO: ' . $datos_cliente->phone . '</td>'.
                                        '</tr>'.
                                        '<tr>'.
                                            '<td>CUIT: ' . $datos_cliente->dni . '</td>'.
                                            '<td width="5%"></td>'.
                                            '<td>EMAIL: ' . $datos_cliente->email . '</td>'.
                                        '</tr>'.
                                        '<tr>'.
                                             '<td>CONDICIÓN AFIP: ' . $datos_cliente->condition . '</td>'.
                                            '<td width="5%"></td>'.
                                            '<td>CONDICIÓN DE VENTA: ' . $orden->payment_method . '</td>'.
                                        '</tr>' .
                                        '<tr>' .
                                             '<td>PROVINCIA: ' . $datos_cliente->province . '</td>' .
                                            '<td width="5%"></td>' .
                                            '<td>LOCALIDAD: ' . $datos_cliente->location . '</td>' .
                                        '</tr>' .
                                        '<tr>' .
                                             '<td>DIRECCIÓN: ' . $datos_cliente->address . '</td>' .
                                            '<td width="5%"></td>'.
                                            '<td>FECHA: ' . date('d/m/Y', strtotime($orden->date)) . '</td>' .
                                        '</tr>'.
                                    '</tbody>'.
                                '</table>'.
                            '</div>'.
                        '</td>'.
                    '</tr>'.
                '</table>'.
              '</header>'.
              '<div class="table-description">'.
                '<table border="0" style="border-collapse: collapse;position:relative;z-index:1000;">'.
                  '<thead style="background:#e6e6e6;">'.
                    '<tr>'.
                      '<th width="10%" style="padding:7px;" class="service">Código</th>'.
                      '<th width="45%" style="padding:7px;" class="desc">Descripción</th>';

                        if ($datos_factura['tipo_factura'] == 1) {

                            if ($datos_factura['condicion_afip'] == '1' || $datos_factura['condicion_afip'] == '3') {
                                
                                $template .=  '<th align="center">IVA</th>';
                                
                            }

                            $template .=    '<th style="padding:7px;" align="right">Cant.</th>'.
                                            '<th style="padding:7px;" align="right">P. Unit.</th>'.
                                            '<th style="padding:7px;" align="right">P. Total</th>';
                        }
                        
                        else {

                            $template .=    '<th style="padding:7px;" align="right">Cant.</th>'.
                                            '<th style="padding:7px;" align="right">P. Unit.</th>'.
                                            '<th style="padding:7px;" align="right">Descuento (%)</th>'.
                                            '<th style="padding:7px;" align="right">P. Total</th>';

                        }

        $template .=    '</tr>'.
                    '</thead>'.
                    '<tbody>';

                    //$subtotal = 0;
                    $subtotal_neto = 0;
                    $subtotal_iva_21 = 0;
                    $subtotal_iva_10_5 = 0;

                    foreach ($productos as $key => $value)
                    {

                        if ($datos_factura['tipo_factura'] == 1)
                        {

                            /*$precio_unitario = number_format($value->precio,2,'.',',');
                            $precio_subtotal = number_format(round($value->precio_neto, 2), 2, '.', ',');
                            $subtotal_real_neto = $subtotal_real_neto + ($value->precio_neto * $value->cantidad);*/

                        }
                        else {

                            /*$precio_unitario = number_format($value->precio,2,'.',',');
                            $precio_subtotal = number_format(round($value->total, 2), 2, '.', ',');
                            $subtotal_real_neto = $subtotal_real_neto + ($value->total);*/

                        }

                        if ($value->id_iva == 1)
                        {
                            $subtotal_iva_10_5 += $value->iva_amount;
                        } else {
                            $subtotal_iva_21 += $value->iva_amount;
                        }

                        $template .= ''.
                        '<tr>'.
                            '<td align="center" valign="middle" style="padding-top:4px;">'.$value->code.'</td>'.
                            '<td class="desc" valign="middle" style="padding-top:4px;">'.$value->name.'</td>';

                            if ($datos_factura['tipo_factura'] == 1)
                            {

                                if ($datos_factura['condicion_afip'] == '1' || $datos_factura['condicion_afip'] == '3')
                                {
                                    $template .= '<td class="unit" valign="middle" style="padding-top:4px;" align="center">'.$value->percent.'%</td>';
                                }

                                $template .= ''.
                                    '<td class="qty" valign="middle" style="padding-top:4px;" align="right">'.$value->qty.'</td>'.
                                    '<td class="qty" valign="middle" style="padding-top:4px;" align="right">'.$value->price.'</td>'.
                                    '<td class="total" valign="middle" style="padding-top:4px;" align="right">'.number_format($value->price * $value->qty, 2, '.', '').'</td>';

                            } else {

                                $template .= ''.
                                    '<td class="qty" valign="middle" style="padding-top:4px;" align="right">'.$value->qty.'</td>'.
                                    '<td class="qty" valign="middle" style="padding-top:4px;" align="right">'.$value->price.'</td>'.
                                    '<td class="qty" valign="middle" style="padding-top:4px;" align="right">0.00</td>'.
                                    '<td class="total" valign="middle" style="padding-top:4px;" align="right">'.number_format($value->price * $value->qty, 2, '.', '').'</td>';
                            
                            }

                        $template .= '</tr>';

                    }

                    if ($orden->cost_shipping > 0)
                    {
                        $template .= ''.
                        '<tr>'.
                            '<td align="center" valign="middle" style="padding-top:4px;"></td>'.
                            '<td class="desc" valign="middle" style="padding-top:4px;">'.$datos_factura['envio']['description'].'</td>';
                            if ($datos_factura['tipo_factura'] == 1)
                            {
                                if ($datos_factura['condicion_afip'] == '1' || $datos_factura['condicion_afip'] == '3')
                                {
                                    $template .= '<td class="unit" valign="middle" style="padding-top:4px;" align="center">0.00%</td>';
                                }
                                $template .= ''.
                                    '<td class="qty" valign="middle" style="padding-top:4px;" align="right">1</td>'.
                                    '<td class="qty" valign="middle" style="padding-top:4px;" align="right">'.$datos_factura['envio']['subtotal'].'</td>'.
                                    '<td class="total" valign="middle" style="padding-top:4px;" align="right">'.number_format($datos_factura['envio']['subtotal'], 2, '.', '').'</td>';
                            } else {
                                $template .= ''.
                                    '<td class="qty" valign="middle" style="padding-top:4px;" align="right">1</td>'.
                                    '<td class="qty" valign="middle" style="padding-top:4px;" align="right">'.$datos_factura['envio']['subtotal'].'</td>'.
                                    '<td class="qty" valign="middle" style="padding-top:4px;" align="right">0.00</td>'.
                                    '<td class="total" valign="middle" style="padding-top:4px;" align="right">'.number_format($datos_factura['envio']['subtotal'], 2, '.', '').'</td>';
                            }

                        $template .= ''.
                        '</tr>';
                    }


        $template .=            '</tbody>'.
                            '</table>'.
                        '</div>'.
                    '<br/>';

        $template .='<div>'.
                '</div>';

        if ($cantidad_compras < 16 && $cantidad_compras > 9)
        {
            $template .= '<div style="page-break-after:always;"></div>';
        }

        $subtotal = number_format($orden->subtotal + $orden->cost_shipping - $orden->discount, 2, '.', '');

        if ($datos_factura['tipo_factura'] == 1)
        {
            $template .= '<table style="width:100%;position:relative;z-index:1000;">'.
                '<tr>'.
                    '<td width="350" style="width:350px;"> &nbsp;</td>'.
                    '<td width="100" style="width:100px;">'.
                        '<table style="margin-bottom:0px;margin-top:0px;padding-bottom:0px;">'.
                            '<tr>'.
                                '<td>Subtotal: </td>'.
                                '<td>$ ' . number_format($orden->subtotal + $orden->cost_shipping, 2, '.', '') . '</td>'.
                            '</tr>';

            if ($orden->discount > 0)
            {
                $template .= '<tr>'.
                    '<td>Descuento: </td>'.
                    '<td>$ ' . $orden->discount . '</td>'.
                '</tr>';
            }

            if ($datos_factura['condicion_afip'] == '1' || $datos_factura['condicion_afip'] == '3')
            {

                $template .= ''.
                            '<tr>'.
                                '<td>Neto: </td>'.
                                '<td>$ ' . number_format($orden->net_price, 2, '.', '') . '</td>'.
                            '</tr>';

                $template .= ''.
                            '<tr>'.
                                '<td>IVA 21%: </td>'.
                                '<td>$ ' . number_format($subtotal_iva_21, 2, '.', '') . '</td>'.
                            '</tr>';

                $template .= ''.
                            '<tr>'.
                                '<td>IVA 10.5%:</td>'.
                                '<td>$ ' . number_format($subtotal_iva_10_5, 2, '.', '') . '</td>'.
                            '</tr>';
            }

            $template .= '</table>'.
                        '<table style="margin-bottom:18px;margin-top:0px;padding-bottom:-20px;">'.
                            '<tr>'.
                                '<td><h5 style="font-size: 16px;margin:0px;padding:0px;">Total:</h5></td>'.
                                '<td><h5 style="font-size: 16px;margin:0px;padding:0px;">$ '.$subtotal.'</h5></td>'.
                            '</tr>'.
                        '</table>'.
                    '</td>'.
                '</tr>'.
            '</table>';

        } else {

            $template .= '' .
            '<table style="width:100%;position:relative;z-index:1000;">'.
                '<tr>'.
                    '<td width="350" style="width:350px;">&nbsp;</td>'.
                    '<td width="100" style="width:100px;">'.
                        '<table style="margin-bottom:0px;margin-top:0px;padding-bottom:0px;">'.
                            '<tr>'.
                                '<td>Subtotal: </td>'.
                                '<td>$ '. $orden->subtotal  .'</td>'.
                            '</tr>'.
                        '</table>';

            if ($orden->discount > 0)
            {
                $template .= '<tr>' .
                    '<td>Descuento: </td>' .
                    '<td>$ ' . $orden->discount . '</td>' .
                '</tr>';
            }

            $template .= '<table style="margin-bottom:18px;margin-top:0px;padding-bottom:-20px;">'.
                            '<tr>'.
                                '<td><h5 style="font-size: 16px;margin:0px;padding:0px;">Total:</h5></td>'.
                                '<td><h5 style="font-size: 16px;margin:0px;padding:0px;">$ '.$subtotal.'</h5></td>'.
                            '</tr>'.
                        '</table>'.
                    '</td>'.
                '</tr>'.
            '</table>';

        }

        $template .= '<br/><br/>' .
                '<div style="padding:10px 15px;background:#e6e6e6;width:100%;">'.
                    '<table class="table-footer-afip" style="border:1px solid #000" width="100%">'.
                        '<tr>'.
                            '<td style="padding-left:25px;">'.
                              'Factura electrónica/CAE'.
                            '</td>'.
                            '<td>'.
                                $datos_factura['afip_cae'] .
                            '</td>'.
                            '<td>Fecha Vto. CAE: <b>'.date('d/m/Y', strtotime($datos_factura['afip_vencimiento'])).'</b></td>'.
                        '</tr>'.
                    '</table>'.
                '</div>'.
            '</body>'.
        '</html>';

        /*  GENERAR PDF */

        $ci->load->library('html2pdf');
        $ci->html2pdf->folder(APPPATH . '../uploads/comprobantes/');
        $ci->html2pdf->filename($datos_factura['filename']);
        $ci->html2pdf->paper('a4', 'portrait');
        $ci->html2pdf->html($template);
        $ci->html2pdf->create('save');

    }

}