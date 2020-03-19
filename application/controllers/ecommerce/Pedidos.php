<?php

class Pedidos extends CI_Controller
{

    private $permisos;

    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
        $this->load->model('pedido_model', 'pedido');
        $this->load->model('pedido_estado_model', 'pedido_estado');
        $this->load->model('envio_model', 'envio');
        $this->load->model('pago_model', 'pago');
        $this->load->model('producto_model', 'product');
        $this->load->model('product_listprice_model', 'producto_listprice');
        $this->load->model('pedido_resumen_model', 'pedido_resumen');
        $this->load->model('customer_model', 'customer');
        $this->load->model('factura_model', 'factura');
        $this->load->model('pedido_producto_model', 'pedido_producto');
    }

    function index()
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'condiciones'   => $this->codegen_model->get('condition_iva', '*', ''),
            'results' => $this->pedido->get(),
        );

        $vista_externa = array(
            'title' => ucwords("pedidos"),
            'contenido_main' => $this->load->view('components/ecommerce/pedidos/pedidos_list', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function add()
    {
        if ($this->input->post('enviar_form'))
        {
            $user_id = $this->session->userdata('user_id');
            $productos = $this->input->post('producto_id');

            $price = $this->input->post('price');
            $qty = $this->input->post('product_qty');
            $ivas = $this->input->post('iva');
            $ivas_id = $this->input->post('id_iva');

            $metodo_pago_id = $this->input->post('metodo_pago_id');
            $estado_id = $this->input->post('estado_id');

            $subtotal_iva = 0;
            $subtotal_neto = 0;
            $subtotal = 0;

            $productos_pedido = [];

            foreach ($productos as $key => $producto)
            {
                $data_product_orden = [
                    'id_product' => $producto,
                    'price' => $price[$key],
                    'qty' => $qty[$key],
                    'create_by' => $user_id,
                    'net_price' => calcularNeto(($price[$key] * $qty[$key]), $ivas[$key]),
                    'iva_amount' => calcularIVA(($price[$key] * $qty[$key]), $ivas[$key]),
                    'id_iva' => $ivas_id[$key],
                    'type_id' => 1,
                ];

                $productos_pedido[] = $data_product_orden;

                $subtotal += $data_product_orden['price'] * $data_product_orden['qty'];
                $subtotal_neto += $data_product_orden['net_price'];
                $subtotal_iva += $data_product_orden['iva_amount'];
            }

            $data_orden = [
                'id_users' => $this->input->post('usuario_id'),
                'id_status' => $this->input->post('estado_id'),
                'date' => date('Y-m-d H:i:s'),
                'id_payment_method' => $metodo_pago_id,
                'subtotal' => $subtotal,
                'net_price' => $subtotal_neto,
                'iva_amount' => $subtotal_iva,
                'id_shipping' => 2,
                'cost_shipping' => 0,
                'can_unity' => 0,
                'can_bulto' => 0,
                'sale_mode' => SALE_DASHBOARD,
                'id_business' => 1,
            ];

            $orden_id = $this->codegen_model->addNoAudit('orders', $data_orden);

            foreach ($productos_pedido as $key => $producto_pedido)
            {
                $producto_pedido['id_order'] = $orden_id;
                $this->pedido_producto->add($producto_pedido);
            }

            $this->session->set_flashdata('success', 'Se ha registrado su pedido exitosamente.');

            redirect(base_url('ecommerce/pedidos'), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'estados' => $this->pedido_estado->get(),
            'users' =>  $this->codegen_model->get('ecommerce_users', '*', ''),
            'metodos_pagos' => $this->pago->get(['id_payment_method' => 5]),
            'metodos_envio' => $this->envio->get(['id_shipping' => 2]),
        );

        $vista_externa = array(
            'title' => ucwords("pedidos"),
            'contenido_main' => $this->load->view('components/ecommerce/pedidos/pedidos_add', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function edit($id)
    {
        if ($this->input->post('enviar_form'))
        {
            $data = array(
                'id_status' => $this->input->post('estado_id')
            );
            $this->pedido->edit($data, $id);
            redirect(base_url('ecommerce/pedidos'), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->pedido->find($id),
            'estados' => $this->pedido_estado->get(),
        );

        $vista_externa = array(
            'title' => ucwords("pedidos"),
            'contenido_main' => $this->load->view('components/ecommerce/pedidos/pedidos_edit', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);

    }

    function view($id)
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->pedido->getPedido($id),
            'pedidos' => $this->pedido->getOrderProducts($id),
        );

        $vista_externa = array(
            'title' => ucwords("pedidos"),
            'contenido_main' => $this->load->view('components/ecommerce/pedidos/pedidos_view', $vista_interna, true)
        );

        $this->load->view('template/view', $vista_externa);

    }

    function delete($id)
    {
        $update_pedido = array(
            'active'    =>  DELETE,
        );
        $this->pedido->edit($update_pedido, $id);
    }

    function jsonProducts()
    {
        $term = $this->input->post('term');
        $products = $this->product->select($term['term']);
        echo json_encode(array('results' => $products, 'more' => false));

    }

    function jsonUsuario()
    {
        $term = $this->input->post('term');
        $products = $this->customer->select($term['term']);
        echo json_encode(array('results' => $products, 'more' => false));

    }

    function producto()
    {
        $cliente_id = $this->input->post('cliente_id');
        $producto_id = $this->input->post('producto_id');

        $where_customer = [
            'id_users' => $cliente_id,
        ];

        $cliente = $this->customer->find($where_customer);

        if ($cliente)
        {
            $producto = $this->product->find($producto_id);

            if ($producto->offer == ACTIVE)
            {
                $precio = $producto->offer_price;
            } else {
                $precio = $producto->price_individual;
            }

            if ($cliente->id_list_price > 0)
            {
                $lista_precio = $this->producto_listprice->getLisProcducPrice($producto_id);
                foreach ($lista_precio as $key => $value) {
                    if ($value->id_list_price === $cliente->id_list_price)
                    {
                        $precio = $value->price;
                    }
                }
            }

            $response = [
                'success' => true,
                'data' => [
                    'producto' => $producto,
                    'precio_producto' => $precio,
                ],
            ];

        } else {
            $response = [
                'success' => false,
                'data' => [
                    'message' => 'Debe seleccionar un usuario mayorista.',
                ],
            ];
        }

        echo json_encode($response);

    }

    function producto_precio()
    {
        $producto_id = $this->input->post('productoId');

        $response = [
            'success' => true,
            'listproduct' => $this->producto_listprice->getLisProcducPrice($producto_id),
        ];

        echo json_encode($response);
    }

    function colorsTalle()
    {
        $productId = $this->input->post('product_id');
        $talleId = $this->input->post('size_id');

        $filters = [
            'size_id' => $talleId,
            'product_id' => $productId,
        ];

        $response = [
            'success' => true,
        ];

        echo json_encode($response);
    }

    function facturacion()
    {
        include_once APPPATH . 'libraries/afip/src/Afip.php';

        $id_order = $this->input->post('id_order');

        $venta = $this->codegen_model->row('orders', '*', 'id_order = "' . $id_order . '" AND active = "'. ACTIVE .'"');

        if ($venta) {
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

            if (!empty($datos_cliente_afip['numero_documento']))
            {
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
                    'ImpTotal'  =>  round(($venta->subtotal + $venta->cost_shipping - $venta->discount), 2), # Importe total del comprobante
                    'ImpTotConc'    => 0,   # Importe neto no gravado
                    'ImpNeto'   =>  round($venta->net_price, 2), # Importe neto gravado
                    'ImpIVA'    =>  round($venta->iva_amount, 2),  # Importe total de IVA
                    'ImpOpEx'   =>  $venta->cost_shipping, # Importe exento de IVA
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

    function calcularAdicional($cost_shipping)
    {
        $net_adicitional = 0;
        $iva_adicitional = 0;

        return [
            'afip_id' => 5, # 21%
            'description' => 'Entrega a domicilio',
            'subtotal' => $cost_shipping,
            'net_adicitional' => $net_adicitional,
            'iva_adicitional' => $iva_adicitional,
        ];
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
                if (!empty($datos_cliente->dni))
                {
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

    function alicuotasIva($venta_id, $amount_shipping)
    {
        $venta_productos = $this->pedido_resumen->subtotalImpuestos($venta_id);

        $items_iva = array();

        foreach ($venta_productos as $k => $venta)
        {
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
