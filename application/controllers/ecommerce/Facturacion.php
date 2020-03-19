<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Facturacion extends CI_Controller
{
    private $permisos;

    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
        $this->load->model('pedido_model', 'pedido');
        $this->load->model('pedido_producto_model', 'pedido_producto');
        $this->load->model('pago_model', 'pago');
        $this->load->model('producto_model', 'product');
        $this->load->model('pedido_estado_model', 'pedido_estado');
        $this->load->model('condicion_usuario_model', 'condicion_usuario');
        $this->load->model('empresa_model', 'empresa');
        $this->load->model('customer_model', 'customer');
        $this->load->model('factura_model', 'factura');
        $this->load->model('pedido_resumen_model', 'pedido_resumen');
        $this->load->model('configuracion_model', 'configuracion');
    }

    function index()
    {
        $filtros = $this->input->get();

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'results' => $this->factura->get($filtros),
            'empresas' => $this->empresa->get(),
            'estados' => $this->pedido_estado->get(),
            'condiciones' => $this->codegen_model->get('condition_iva', '*', ''),
        );

        $vista_externa = array(
            'title' => ucwords("facturación electrónica"),
            'contenido_main' => $this->load->view('components/ecommerce/facturacion/facturacion_list', $vista_interna, true),
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function add()
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'empresas' => $this->empresa->get(),
            'metodo_pago' => $this->pago->get(['id_payment_method' => 5]),
            'estados' => $this->pedido_estado->get(),
            'condiciones_afip' => $this->condicion_usuario->get(),
        );

        $vista_externa = array(
            'title' => ucwords("facturación electrónica"),
            'contenido_main' => $this->load->view('components/ecommerce/facturacion/facturacion_add', $vista_interna, true),
        );

        $this->load->view('template/backend', $vista_externa);

    }

    function registroFactura()
    {
        $nombre = $this->input->post('nombre');
        $tipo_usuario = $this->input->post('tipo_usuario');
        $documento = $this->input->post('documento');
        $empresa_id = $this->input->post('empresa_id');
        $fecha = $this->input->post('fecha');
        $metodo_pago_id = $this->input->post('metodo_pago_id');
        $estado_id = $this->input->post('estado_id');
        $email = $this->input->post('email');

        $productos = $this->input->post('product');
        $cantidades = $this->input->post('product_qty');
        $precios = $this->input->post('precio');
        $ivas = $this->input->post('iva');
        $ivas_id = $this->input->post('iva_id');

        $datos_cliente = [
            'name' => $nombre,
            'dni' => $documento,
            'email' => '',
            'phone' => '',
            'password' => substr(sha1(uniqid()), 0, 6),
            'id_condition_iva' => $tipo_usuario,
            'status_code_confirmation' => 0,
        ];

        $usuario_id = $this->customer->add($datos_cliente);

        $subtotal_iva = 0;
        $subtotal_neto = 0;
        $subtotal = 0;

        $productos_pedido = [];

        foreach ($productos as $key => $producto_id)
        {
            $data_producto = [
                'id_product' => $producto_id,
                'qty' => $cantidades[$key],
                'price' => $precios[$key],
                'net_price' => calcularNeto(($precios[$key] * $cantidades[$key]), $ivas[$key]),
                'iva_amount' => calcularIVA(($precios[$key] * $cantidades[$key]), $ivas[$key]),
                'id_iva' => $ivas_id[$key],
                'type_id' => 1,
            ];

            $productos_pedido[] = $data_producto;

            $subtotal += $data_producto['price'] * $data_producto['qty'];
            $subtotal_neto += $data_producto['net_price'];
            $subtotal_iva += $data_producto['iva_amount'];
        }

        $datos_pedido = [
            'id_users' => $usuario_id,
            'id_payment_method' => $metodo_pago_id,
            'id_status' => $estado_id,
            'subtotal' => $subtotal,
            'date' => $fecha,
            'id_shipping' => 2,
            'cost_shipping' => 0,
            'can_unity' => 0,
            'can_bulto' => 0,
            'net_price' => $subtotal_neto,
            'iva_amount' => $subtotal_iva,
            'sale_mode' => SALE_DASHBOARD,
            'id_business' => 1,
        ];

        $orden_id = $this->pedido->insert($datos_pedido);

        foreach ($productos_pedido as $key => $producto_pedido)
        {
            $producto_pedido['id_order'] = $orden_id;
            $this->pedido_producto->add($producto_pedido);
        }

        # Facturación

        include_once APPPATH . 'libraries/afip/src/Afip.php';

        $where_empresa = [
            'id_business' => $empresa_id,
        ];

        $datos_empresa = $this->empresa->find($where_empresa);

        $data_afip = [
            'CUIT'  =>  $datos_empresa->cuit,
            'cert'  =>  $datos_empresa->certificate,
            'key'   =>  $datos_empresa->api_key,
            'production'    =>  false,
        ];

        $where_customer = [ 'id_users' => $usuario_id ];
        $usuario = $this->customer->find($where_customer);
        $datos_cliente_afip = datosCompradorFactura($usuario);
        $venta_productos = $this->pedido_resumen->subtotalImpuestos($orden_id);

        $afip = new Afip($data_afip);

        $datos_factura = [
            'CantReg'   =>  1, # Cantidad de comprobantes a registrar
            'PtoVta'    =>  21, # Punto de venta
            'Concepto'  =>  1, # Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
            'CbteTipo'  =>  $datos_cliente_afip['tipo_factura'], # Tipo de comprobante (ver tipos disponibles)
            'DocTipo'   =>  $datos_cliente_afip['tipo_documento'], # Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
            'DocNro'    =>  $datos_cliente_afip['numero_documento'], # Número de documento del comprador (0 consumidor final)
            'CbteFch'       =>  intval(date('Ymd')), # (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
            'ImpTotal'      =>  round($subtotal, 2), # Importe total del comprobante
            'ImpTotConc'    =>  0,  # Importe neto no gravado
            'ImpNeto'   =>  round($subtotal_neto, 2), # Importe neto gravado
            'ImpIVA'    =>  round($subtotal_iva, 2),  # Importe total de IVA
            'ImpOpEx'   =>  0, # Importe exento de IVA
            'ImpTrib'   =>  0, # Importe total de tributos
            'MonId'     =>  'PES', # Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos)
            'MonCotiz'  =>  1, # Cotización de la moneda usada (1 para pesos argentinos)
            'Iva'       =>  alicuotasVenta($venta_productos),
        ];

        try {
            $res = $afip->ElectronicBilling->CreateNextVoucher($datos_factura);

            if (isset($res['CAE'])) {
                $data_invoice = [
                    'id_order' => $orden_id,
                    'cae' => $res['CAE'],
                    'expiration_date' => $res['CAEFchVto'],
                    'ticket' => $res['voucher_number'],
                    'id_business' => $empresa_id,
                    'active' => ACTIVE,
                    'filename' => '',
                ];

                $this->factura->add($data_invoice);

                $filename = $this->generacionPDF($orden_id);

                if (!empty($email)) {
                    $site_name = $this->configuracion->find(1);
                    $site_email = $this->configuracion->find(3);

                    $data_email = [
                        'filename' => APPPATH.'../uploads/comprobantes/' . $filename,
                        'name' => $nombre,
                        'email' => $email,
                    ];

                    $this->frontend_lib->enviarEmail($data_email, 'frontend/email/detail_invoice', $site_name->value . ' - factura de compra', $email, $site_email->value, $site_name->value);
                }

                $response = [
                    'success' => true,
                    'data' => [
                        'filename' => base_url('uploads/comprobantes/' . $filename),
                        'message' => 'Se ha registrado su factura exitosamente.',
                        'redirect' => base_url('ecommerce/facturacion'),
                    ],
                ];
            } else {
                $response = [
                    'success' => false,
                    'data' => [
                        'message' => 'Ocurrio un error al registrar la factura.',
                    ]
                ];
            }

        } catch (Exception $e) {
            $response = [
                'success' => false,
                'data' => [
                    'message' => $e->getMessage(),
                ]
            ];

        }

        echo json_encode($response);
    }

    public function producto()
    {
        $usuario = $this->input->post('usuarioId');
        $producto_id = $this->input->post('productoId');

        $producto = $this->product->find($producto_id);

        if ($producto)
        {
            if ($producto->offer == ACTIVE)
            {
                $precio = $producto->offer_price;

            } else {
                $precio = $producto->price_individual;

            }

            $producto_info = [
                'producto_id' => $producto->id_product,
                'nombre'    =>  $producto->name,
                'codigo' => $producto->code,
                'iva'   =>  $producto->iva,
                'iva_id' => $producto->id_iva,
                'neto'  =>  calcularNeto($precio, $producto->iva),
                'precio'    =>  $precio,
            ];

            $response = [
                'success' => true,
                'data' => $producto_info,
            ];

        } else {
            $response = [
                'success' => false,
                'data' => [
                    'message' => 'Producto no encontrado',
                ],
            ];

        }

        echo json_encode($response);

    }

    function generacionPDF($orden_id)
    {
        $where_factura = [
            'id_order' => $orden_id,
        ];

        $factura = $this->factura->find($where_factura);

        $orden = $this->pedido->find($orden_id);

        $where_customer = [
            'customer.id_users' => $orden->id_users,
        ];

        $datos_cliente = $this->customer->detail($where_customer);

        $filename = 'factura-' . uniqid() . '.pdf';

        $datos_factura = [
            'afip_cae' => $factura->cae,
            'afip_vencimiento' => date('Y-m-d', strtotime($orden->date)),
            'filename' => $filename,
            'tipo_factura' => 1,
            'condicion_afip' => '1',
            'numero_factura' => str_pad($factura->point_sale, 4, '0', STR_PAD_LEFT) . '-' . str_pad($factura->ticket, 8, '0', STR_PAD_LEFT),
            'factura_letra' => ($datos_cliente->id_condition_iva == 4) ? 'A' : 'B',
            'envio' => $this->calcularAdicional($orden->cost_shipping),
        ];

        $where_empresa = [
            'order_product.active' => ACTIVE,
            'order_product.id_order' => $orden_id,
        ];

        $productos = $this->pedido_producto->get($where_empresa);

        documentoFactura($datos_factura, $datos_cliente, $productos, $orden);

        $invoice_update = [
            'filename' => $filename,
        ];

        $invoice_where = [
            'id_order' => $orden_id,
            'active' => ACTIVE,
        ];

        $this->factura->edit($invoice_where, $invoice_update);

        return $filename;
    }

    function calcularAdicional($cost_shipping)
    {
        $net_adicitional = 0;
        $iva_adicitional = 0;

        return [
            'afip_id' => 5,
            'description' => 'Entrega a domicilio',
            'subtotal' => $cost_shipping,
            'net_adicitional' => $net_adicitional,
            'iva_adicitional' => $iva_adicitional,
        ];
    }

    function consultaCuit()
    {
        if ($this->input->post('enviar_form'))
        {
            include_once APPPATH . 'libraries/afip/src/Afip.php';

            $documento = $this->input->post('documento');

            if ($documento) {
                $datos_empresa = $this->codegen_model->row('business_configurations', '*', 'active = "' . ACTIVE . '"');

                $data_afip = [
                    'CUIT' => $datos_empresa->cuit,
                    'cert' => $datos_empresa->certificate,
                    'key' => $datos_empresa->api_key,
                    'production' => false,
                ];

                try {
                    $afip = new Afip($data_afip);
                    $taxpayer_details = $afip->RegisterScopeTen->GetTaxpayerDetails($documento);

                    $response = [
                        'success' => true,
                        'data' => $taxpayer_details,
                    ];
                } catch (Exception $e) {
                    $response = [
                        'success' => false,
                        'data' => [
                            'message' => $e->getMessage(),
                        ],
                    ];
                }

            } else {
                $response = [
                    'success' => false,
                    'data' => [
                        'message' => 'Ingrese un número de documento',
                    ],
                ];

            }

            echo json_encode($response);
        }
    }

    function facturacion()
    {
        include_once APPPATH . 'libraries/afip/src/Afip.php';
        $id_order = $this->input->post('id_order');

        $venta = $this->codegen_model->row('orders', '*', 'id_order = "' . $id_order . '" AND active = "'. ACTIVE .'"');

        if ($venta)
        {
            $datos_empresa = $this->codegen_model->row('business_configurations', '*', 'active = "' . ACTIVE . '" ORDER BY id_business');

            if ($this->input->post('enviar_form'))
            {
                $data_update = [
                    'id_condition_iva' => $this->input->post('condicion'),
                    'dni' => $this->input->post('cuit'),
                ];

                $data_where = [
                    'id_users' => $venta->id_users
                ];

                $this->customer->edit($data_update, $data_where);
            }

            $datos_cliente_afip = $this->datosComprador($venta->id_users);

            if (!empty($datos_cliente_afip['numero_documento'])) {
                $data_afip = [
                    'CUIT' => $datos_empresa->cuit,
                    'cert' => $datos_empresa->certificate,
                    'key' => $datos_empresa->api_key,
                    'production' => false,
                ];

                $afip = new Afip($data_afip);

                $datos_factura = [
                    'CantReg'   =>  1, # Cantidad de comprobantes a registrar
                    'PtoVta'    =>  21, # Punto de venta
                    'Concepto'  =>  1, # Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
                    'CbteTipo'  =>  $datos_cliente_afip['tipo_factura'], # Tipo de comprobante (ver tipos disponibles)
                    'DocTipo'   =>  $datos_cliente_afip['tipo_documento'], # Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
                    'DocNro'    =>  $datos_cliente_afip['numero_documento'], # Número de documento del comprador (0 consumidor final)
                    'CbteFch'   =>  intval(date('Ymd')), # (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
                    'ImpTotal'  =>  round($venta->subtotal - $venta->discount, 2), # Importe total del comprobante
                    'ImpTotConc'    =>  0,  # Importe neto no gravado
                    'ImpNeto'   =>  round($venta->net_price, 2), # Importe neto gravado
                    'ImpIVA'    =>  round($venta->iva_amount, 2),  # Importe total de IVA
                    'ImpOpEx'   =>  0, # Importe exento de IVA
                    'ImpTrib'   =>  0, # Importe total de tributos
                    'MonId'     =>  'PES', # Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos)
                    'MonCotiz'  =>  1, # Cotización de la moneda usada (1 para pesos argentinos)
                    'Iva'       =>  $this->alicuotasIva($venta->id_order),
                ];

                try
                {
                    $res = $afip->ElectronicBilling->CreateNextVoucher($datos_factura);

                    if (isset($res['CAE']))
                    {
                        $data_invoice = [
                            'id_business' => 1,
                            'id_order' => $id_order,
                            'cae' => $res['CAE'],
                            'expiration_date' => $res['CAEFchVto'],
                            'point_sale' => str_pad($datos_factura['PtoVta'], 4, '0', STR_PAD_LEFT),
                            'ticket' => str_pad($res['voucher_number'], 8, '0', STR_PAD_LEFT),
                            'active' => ACTIVE,
                            'filename' => '',
                        ];

                        $this->factura->add($data_invoice);

                        $this->generacionPDF($id_order);
                    }

                    $response = [
                        'success' => true,
                    ];

                } catch (Exception $e) {
                    $response = [
                        'success' => false,
                        'data' => [
                            'message' => $e->getMessage(),
                        ]
                    ];
                }

            } else {
                $response = [
                    'success' => false,
                    'data' => [
                        'message' => 'Registre un número de documento para este cliente.',
                    ]
                ];

            }

        } else {
            $response = [
                'success' => false,
                'data' => [
                    'message' => 'La venta no existe.',
                ]
            ];

        }

        echo json_encode($response);

    }

    function datosComprador($id_user)
    {
        $where_customer = [
            'id_users' => $id_user,
        ];

        $datos_cliente = $this->customer->find($where_customer);
        $tipo_documento = 80;

        switch ($datos_cliente->id_condition_iva)
        {
            case '1':
                $afip_cliente = 'CONSUMIDOR FINAL';
                if (!empty($datos_cliente->dni)) {
                    $numero_documento = $datos_cliente->dni;
                    $tipo_documento = 96;
                } else {
                    $numero_documento = 0;
                    $tipo_documento = 99;
                }
                $tipo_factura = FACTURA_B;
                break;

            case '2':
                $afip_cliente = 'MONOTRIBUTISTA';
                $numero_documento = (double) $datos_cliente->dni;
                $tipo_factura = FACTURA_B;
                break;

            case '3':
                $afip_cliente = 'RESPONSABLE INSCRIPTO';
                $numero_documento = (double) $datos_cliente->dni;
                $tipo_factura = FACTURA_A;
                break;

            case '4':
                $afip_cliente = 'EXENTO';
                $numero_documento = (double) $datos_cliente->dni;
                $tipo_factura = FACTURA_B;
                break;

            default:
                $afip_cliente = 'CONSUMIDOR FINAL';
                $tipo_factura = FACTURA_B;
                $numero_documento = 0;
                $tipo_documento = 99;
                break;
        }

        $response = array(
            'tipo_factura' => $tipo_factura,
            'nombre_afip_cliente' => $afip_cliente,
            'numero_documento' => $numero_documento,
            'tipo_documento' => $tipo_documento,
        );

        return $response;
    }

    function alicuotasIva($venta_id)
    {
        $venta_productos = $this->pedido_resumen->subtotalImpuestos($venta_id);

        $items_iva = array();

        foreach ($venta_productos as $k => $venta) {
            $alicutota = array(
                'Id' => $venta->afip_id,
                'BaseImp' => $venta->net_price,
                'Importe' => $venta->iva_amount,
            );
            array_push($items_iva, $alicutota);
        }

        return $items_iva;
    }

}

/* End of file Facturacion.php */
/* Location: ./application/controllers/ecommerce/Facturacion.php */
