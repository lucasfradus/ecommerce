<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ecommerce extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('envio_model', 'envio');
        $this->load->model('pedido_model', 'pedido');
        $this->load->model('producto_model', 'producto');
        $this->load->model('producto_stock_model', 'producto_stock');
        $this->load->model('customer_model', 'customer');
        $this->load->model('shipping_model', 'shipping');
        $this->load->model('discount_model', 'discount');
        $this->load->model('Descuentos_diferenciales_model', 'diff_discount');
    }

    public function cart()
    {
        $vista_interna = array(
            'payment_methods' => $this->codegen_model->get('payment_methods', '*', 'active = "1"'),
            'shipping_methods' => $this->shipping->get(),
            'provinces' => $this->codegen_model->get('geo_provincias', '*', ''),
            'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),
        );

        $vista_config = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/private/cart', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
        );

        $this->load->view('template/frontend', $vista_externa);
    }

    public function getLocalidadesProvincia()
    {
        $provincia = $this->input->post('id');
        $data = $this->codegen_model->get('localidades', '*', 'id_provincia = "' . $provincia . '"');
        echo json_encode(array('localidades' => $data));
    }

    public function compraRegistrada()
    {
        $vista_interna = array(
        );

        $vista_config = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/private/compra_registrada', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
        );

        $this->load->view('template/frontend', $vista_externa);
    }

    public function mercadoEnvio()
    {

        $codigo_postal = $this->input->post('codigo_postal');

        require_once APPPATH . '/libraries/mercadopago.php';

        #   MERCADOPAGO CREDENCIALES

        $mp_client_id = $this->codegen_model->row('configurations', '*', 'id_configuration = 18');
        $mp_secret_id = $this->codegen_model->row('configurations', '*', 'id_configuration = 19');
        $mp_sandbox = $this->codegen_model->row('configurations', '*', 'id_configuration = 20');

        #   MERCADOPAGO CREDENCIALES

        $mp = new MP($mp_client_id->value, $mp_secret_id->value);

        $params = array(
            "dimensions" => $this->paqueteTotal(),
            "zip_code" => $codigo_postal,
            "item_price" => $this->cart->total(),
        );

        try {
            $response = $mp->get("/shipping_options", $params);
            echo json_encode(array('success' => true, 'response' => $response));
        } catch (Exception $e) {
            echo json_encode(array('success' => false, 'response' => 'Excepción capturada: ', $e->getMessage(), "\n"));
        }
    }

    public function paqueteTotal()
    {

        $peso_total = 0;
        $alto_total = 0;
        $ancho_total = 0;
        $profundidad_total = 0;

        foreach ($this->cart->contents() as $items) {
            $producto = $this->codegen_model->row('products', '*', 'id_product = ' . $items["id"]);

            $alto_total = $alto_total + ($producto->height * $items["qty"]);
            $ancho_total = $ancho_total + ($producto->width * $items["qty"]);
            $profundidad_total = $profundidad_total + ($producto->depth * $items["qty"]);
            $peso_total = $peso_total + ($producto->weight * $items["qty"]);
        }

        if ($alto_total > 70) {
            $alto_total = 70;
        }

        if ($ancho_total > 70) {
            $ancho_total = 70;
        }

        if ($profundidad_total > 70) {
            $profundidad_total = 70;
        }

        $dimensiones_totales = $alto_total . "x" . $ancho_total . "x" . $profundidad_total . "," . $peso_total;

        return $dimensiones_totales;

    }

    public function process_shopping_cart()
    {
        $usuario_id = $this->session->userdata('customer_id');

        if ($usuario_id) {
            $data_where = [
                'id_users' => $usuario_id,
            ];

            $usuario = $this->customer->find($data_where);

        } else {
            $user_id;
            $codigo_postal = $this->input->post('postal_code');
            $direccion = $this->input->post('address');
            $datosPersonales = array(
                'name' => $this->input->post('name'),
                'surname' => $this->input->post('surname'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'provincia_id' => $this->input->post('province'),
                'localidad_id' => $this->input->post('locality'),
                'password' => "",
                'code_confirmation' => uniqid(),
                'type_id' => CUSTOMER_GUEST,
                'phone' => $this->input->post('telephone'),
                'status_code_confirmation' => CUSTOMER_ACCOUNT_PENDIENT,
            );

            $usuario_id = $this->codegen_model->addNoAudit('ecommerce_users', $datosPersonales);

        }

        $codigo_postal = $this->input->post('postal_code');
        $modo_entrega = $this->input->post('shipping_method');

        switch ($modo_entrega) {
            case ZONA_ESPECIFICA:
                $shipping_id = $this->input->post('shipping_id');
                $zone = $this->shipping->findByPostalCode($codigo_postal);
                if ($zone) {
                    $shipping_cost = $zone->price_shipping;
                } else {
                    $shipping_cost = $this->input->post('shipping_cost');
                }
                break;
            case ENVIO_DOMICILIO:
                $shipping_cost = $this->input->post('shipping_cost');
                break;
            case RECOJO_SUCURSAL:
                $shipping_cost = 0;
                break;
        }

        $qty_unity = 0;
        $qty_bulto = 0;

        foreach ($this->cart->contents() as $items) {
            if ($items['options']['type_id'] == 1) {
                $qty_unity += $items['qty'];
            }

            if ($items['options']['type_id'] == 2) {
                $qty_bulto += $items['qty'];
            }
        }
        //AGERGO a la cuenta los descuento diferenciales asi el descuento por precio se aplica al total 
        $diff_discount = $this->GetDiffDiscount();
        $total_cart = $this->cart->total() - $diff_discount;
        $response = $this->discount->getDiscountPercent($total_cart);

        if ($response) {
            $discount = $response->discount;
        } else {
            $discount = 0;
        }

        $medio_pago = $this->input->post('payment_method');
        $datos_pedido = array(
            'id_users' => $usuario_id,
            'id_status' => PEDIDO_CANCELADO,
            'id_payment_method' => $medio_pago,
            'subtotal' => $total_cart,
            'date' => date('Y-m-d H:i:s'),
            'can_unity' => $qty_unity,
            'can_bulto' => $qty_bulto,
            'id_shipping' => $modo_entrega,
            'cost_shipping' => ($shipping_cost > 0) ? $shipping_cost : 0,
            'discount' => number_format($total_cart * $discount / 100, 2, '.', ''),
            'description' => $this->input->post('description_expreso') ? $this->input->post('description_expreso') : '',
            'sale_mode' => SALE_ECOMMERCE,
            'id_business' => 1,
        );

        $pedido = $this->codegen_model->addNoAudit('orders', $datos_pedido);

        $descuento_item = 0;

        if ($datos_pedido['discount'] > 0) {
            $descuento_item = $datos_pedido['discount'] / ($datos_pedido['can_unity'] + $datos_pedido['can_bulto']);
        }

        $items = array();

        $peso_total = 0;
        $alto_total = 0;
        $ancho_total = 0;
        $profundidad_total = 0;

        $precio_neto_subtotal = 0;
        $precio_iva_subtotal = 0;

        foreach ($this->cart->contents() as $item) {
            $subcategoria = $categoria = $imagen = '';

            foreach ($item['options'] as $option_name => $value) {
                switch ($option_name) {
                    case 'subcategoria':
                        $subcategoria = $value;
                        break;
                    case 'categoria':
                        $categoria = $value;
                        break;
                    case 'imagen':
                        $imagen = $value;
                        break;
                    case 'type_id':
                        $type_id = $value;
                        break;
                    default:
                        break;
                }
            }

            $product = $this->producto->find($item['id']);
            $subtotal = $item['price'] * $item['qty'];

            if ($descuento_item > 0) {
                $descuento_subtotal = round($descuento_item * $item['qty'], 2);
                $subtotal = $subtotal - $descuento_subtotal;
            }

            $data = array(
                'id_order' => $pedido,
                'id_product' => $item['id'],
                'price' => $item['price'],
                'qty' => $item['qty'],
                'type_id' => $type_id,
                'id_iva' => $product->id_iva,
                'net_price' => calcularNeto($subtotal, $product->iva),
                'iva_amount' => calcularIVA($subtotal, $product->iva),
            );

            $precio_neto_subtotal += $data['net_price'];
            $precio_iva_subtotal += $data['iva_amount'];

            $pedido_producto = $this->codegen_model->addNoAudit('ordered_products', $data);

            $precio = floatval(number_format($item['price'], 2, '.', ''));
            $producto = $this->producto->find($item['id']);

            if ($type_id == 2) {
                $Unity_bulto_total = $producto->unit_bulto * $item['qty'];
                $this->descuentoStockProducto($producto->id_product, $Unity_bulto_total, $producto->stock);
            } else if ($type_id == 1) {
                $unit_total = $item['qty'];
                $this->descuentoStockProducto($producto->id_product, $unit_total, $producto->stock);
            }

            $items[] = array(
                'id' => $item['id'],
                'title' => $item['name'],
                'currency_id' => 'ARS',
                'picture_url' => base_url() . 'uploads/img_productos/' . $imagen,
                'description' => 'Categoria: ' . $categoria,
                'category_id' => 'others',
                'quantity' => intval($item['qty']),
                'unit_price' => $precio,
            );

            if ($modo_entrega == ENVIO_DOMICILIO) {
                $alto_total = $alto_total + ($producto->height * $item['qty']);
                $ancho_total = $ancho_total + ($producto->width * $item['qty']);
                $profundidad_total = $profundidad_total + ($producto->depth * $item['qty']);
                $peso_total = $peso_total + ($producto->weight * $item['qty']);
            }
        }

        $data_prices = [
            'net_price' => $precio_neto_subtotal,
            'iva_amount' => $precio_iva_subtotal,
        ];

        $this->codegen_model->edit('orders', $data_prices, 'id_order', $pedido);

        if ($medio_pago == MERCADOPAGO || $medio_pago == RAPIPAGO || $medio_pago == PAGOFACIL) {
            $mp_client_id = $this->codegen_model->row('configurations', '*', 'id_configuration = 18');
            $mp_secret_id = $this->codegen_model->row('configurations', '*', 'id_configuration = 19');
            $mp_sandbox = $this->codegen_model->row('configurations', '*', 'id_configuration = 20');

            require_once APPPATH . '/libraries/mercadopago.php';
            $mp = new MP($mp_client_id->value, $mp_secret_id->value);

            $usuario = $this->codegen_model->row('ecommerce_users', '*', 'id_users = "' . $usuario_id . '"');

            $datos_envio = array(
                "receiver_address" => array(
                    "zip_code" => "1430",
                    "street_number" => 123,
                    "street_name" => "Street",
                    "floor" => 4,
                    "apartment" => "C",
                ),
            );

            if ($modo_entrega == ENVIO_DOMICILIO) {
                if ($alto_total > 70) {
                    $alto_total = 70;
                }

                if ($ancho_total > 70) {
                    $ancho_total = 70;
                }

                if ($profundidad_total > 70) {
                    $profundidad_total = 70;
                }

                $dimensiones_totales = $alto_total . "x" . $ancho_total . "x" . $profundidad_total . "," . $peso_total;

                $datos_envio = array(
                    "mode" => "me2",
                    "dimensions" => $dimensiones_totales,
                    "receiver_address" => array(
                        "zip_code" => $codigo_postal . '',
                        "street_name" => $direccion,
                    ),
                );
            }

            if ($discount > 0) {
                $Discount = ($total_cart * $discount / 100);
                $items[] = array(
                    'id' => $item['id'],
                    'title' => 'Descuento',
                    'currency_id' => 'ARS',
                    'picture_url' => '',
                    'description' => 'Categoria: Descuento',
                    'category_id' => 'others',
                    'quantity' => 1,
                    'unit_price' => floatval(number_format(($Discount * -1) + $shipping_cost, 2, '.', '')),
                );
            } elseif ($shipping_cost > 0) {
                $items[] = array(
                    'id' => uniqid(),
                    'title' => 'Costo de envío',
                    'currency_id' => 'ARS',
                    'picture_url' => '',
                    'description' => 'Categoria: Costo de Envío',
                    'category_id' => 'others',
                    'quantity' => 1,
                    'unit_price' => floatval(number_format($shipping_cost, 2, '.', '')),
                );
            }

            $preference_data = array(
                "items" => $items,
                "payer" => array(
                    "name" => $usuario->name,
                    "surname" => $usuario->surname,
                    "email" => $usuario->email,
                ),
                "back_urls" => array(
                    "success" => base_url() . 'procesar-compra/' . $usuario_id . '/' . $pedido . '/' . PEDIDO_PAGADO . '/',
                    "failure" => base_url() . 'procesar-compra/' . $usuario_id . '/' . $pedido . '/' . PEDIDO_CANCELADO . '/',
                    "pending" => base_url() . 'procesar-compra/' . $usuario_id . '/' . $pedido . '/' . PEDIDO_NUEVO . '/',
                ),
                "auto_return" => "approved",
                "payment_methods" => array(
                    "installments" => 12,
                    "default_payment_method_id" => null,
                    "default_installments" => null,
                ),
                "shipments" => $datos_envio,
                # "notification_url" => base_url().'frontend/ecommerce/mercadopago_procesar/'.$usuario_id.'/'.$pedido.'/2/',
                "external_reference" => sprintf("%09d", $pedido),
                "expires" => false,
                "expiration_date_from" => null,
                "expiration_date_to" => null,
            );

            if ($shipping_cost <= 0) {
                $preference_data[] = array('shipping' => array("mode" => "me2", "free_shipping" => true));
            }
            if ($mp_sandbox->value == ACTIVE) {
                $mp->sandbox_mode(true);
                $preference = $mp->create_preference($preference_data);
                $url_mercadopago = $preference["response"]["sandbox_init_point"];
            } else {
                $mp->sandbox_mode(false);
                $preference = $mp->create_preference($preference_data);
                $url_mercadopago = $preference["response"]["init_point"];
            }

            echo "<script> document.location.href='" . $url_mercadopago . "';</script>";
        } elseif ($medio_pago == TODO_PAGO) {
            $apiKey = $this->codegen_model->row('configurations', '*', 'id_configuration = 26');
            $merchant = $this->codegen_model->row('configurations', '*', 'id_configuration = 27');
            $sandbox = $this->codegen_model->row('configurations', '*', 'id_configuration = 20');

            $config = array(
                'mode' => $sandbox->value == '1' ? 'test' : 'prod',
                'autorization' => 'TODOPAGO ' . $apiKey->value,
                'security' => $apiKey->value,
                'merchant' => $merchant->value,
                'url_ok' => base_url(array(
                    'procesar-compra',
                    $usuario_id,
                    $pedido,
                    2,
                )),
                'url_error' => base_url(array(
                    'procesar-compra',
                    $usuario_id,
                    $pedido,
                    3,
                )),
                //  estado cancelado
                'importe' => $this->cart->total() - $Discount,
                'order' => $pedido,
                'items' => $this->cart->contents(),
                'cliente' => array(
                    'email' => $datosPersonales['email'],
                    'localidad' => $datosPersonales['location'],
                    'nombre' => $datosPersonales['name'],
                    'apellido' => $datosPersonales['surname'],
                    'telefono' => $datosPersonales['phone'],
                    'cpostal' => $datosPersonales['postal_code'],
                    'domicilio' => $datosPersonales['address'],
                    'nombre_id' => $usuario_id,
                    'cliente_ip' => ENVIRONMENT == 'development' ? '127.0.0.1' : $this->input->ip_address(),
                ),
            );

            $this->load->library('todo_pago', $config);
            $request = $this->todo_pago->requestAuth();
            echo "<script> document.location.href='" . $request['URL_Request'] . "';</script>";
        } else {
            redirect(base_url('procesar-compra/' . $usuario_id . '/' . $pedido . '/' . PEDIDO_NUEVO), 'refresh');
        }
    }

    public function mercadopago_procesar($usuario, $pedido, $estado)
    {

        switch ($estado) {
            case PEDIDO_NUEVO:
                $this->mailPedido($pedido, $usuario);
                $data = array('id_status' => PEDIDO_NUEVO);
                $datos_respuesta = 'PENDIENTE: "Su compra se encuentra Pendiente de pago"';
                break;

            case PEDIDO_PAGADO:
                # $this->session->set_flashdata('mi-carrito', 'precesado');
                $this->mailPedido($pedido, $usuario);
                $data = array('id_status' => PEDIDO_PAGADO);
                $datos_respuesta = 'PAGADO: "Gracias por su compra"';
                break;

            case PEDIDO_CANCELADO:
                $data = array('id_status' => PEDIDO_CANCELADO);
                $datos_respuesta = 'CANCELADO: "Su orden de compra fue Cancelada"';
                break;
            default:
                redirect(base_url(''), 'refresh');
                break;
        }

        $this->cart->destroy();
        $this->sudaca_md->edit('orders', $data, 'id_order', $pedido);
        $this->session->set_flashdata('carritoOk', $datos_respuesta);

        redirect(base_url('carrito'), 'refresh');
    }

    public function descuentoStockProducto($productoId, $stockCompra, $stockDisponible)
    {

        $stockActualDisponible = $stockDisponible - $stockCompra;

        $updateStock = array(
            'stock' => ($stockActualDisponible < 0) ? 0 : $stockActualDisponible,
        );

        $this->producto->edit($updateStock, $productoId);
    }

    public function descuentStockProductoVariante($id_product, $id_size, $id_color, $id_heel, $stock)
    {

        $groupWhere = [
            'id_product' => $id_product,
            'id_size' => $id_size,
            'id_color' => $id_color,
        ];

        $stockVariante = $this->variante_producto->getProducto($groupWhere);

        if ($stockVariante) {
            if ($stockVariante->stock > 0) {
                $stockActualDisponible = $stockVariante->stock - $stock;

                $updateStock = array(
                    'stock' => ($stockActualDisponible < 0) ? 0 : $stockActualDisponible,
                );

                $this->variante_producto->edit($updateStock, $stockVariante->variant_product_id);
            }
        }
    }

    public function mailPedido($id_order, $id_usuario)
    {
        $configuracion = $this->codegen_model->row('configurations', '*', 'id_configuration = 3');
        $remitente = $this->codegen_model->row('configurations', '*', 'id_configuration = 4');
        $orden = $this->pedido->find($id_order);
        $datos = array(
            'productos' => $this->cart->contents(),
            'nombre' => $orden->name . ' ' . $orden->surname,
            'telefono' => $orden->phone,
            'provincia' => $orden->province,
            'localidad' => $orden->location,
            'direccion' => $orden->address,
            'codigo_postal' => $orden->postal_code,
            'metodo_pago' => $orden->payment_method,
            'metodo_envio' => $orden->shipping_method,
            'importe' => $orden->subtotal,
            'costo_envio' => $orden->cost_shipping,
            'discount' => $orden->discount,
            'identy_shipping' => $orden->id_payment_method,
        );
        $this->frontend_lib->enviarEmail($datos, 'frontend/email/detalle_pedido', 'Nuevo Pedido', $orden->email, $configuracion->value, $orden->email);
        $this->frontend_lib->enviarEmail($datos, 'frontend/email/detalle_pedido', 'Nuevo Pedido', $configuracion->value, $orden->email, $remitente->value);
    }

    public function validar_email()
    {
        $usuario = $this->codegen_model->row('ecommerce_users', '*', 'email = "' . $this->input->post('email') . '"');
        if ($usuario && $usuario->password != null) {
            if ($this->session->userdata('usuario_email')) {
                if ($this->session->userdata('usuario_email') == $usuario->email) {
                    echo json_encode(array('Value' => 1));
                } else {
                    echo json_encode(array('Value' => 0));
                }
            } else {
                if ($usuario->active != 0 && $usuario->type_id == 2) {
                    echo json_encode(array('Value' => 0));
                } else {
                    echo json_encode(array('Value' => 1));
                }
            }
        } else {
            echo json_encode(array('Value' => 1));
        }
    }
    public function validar_dni()
    {
        $usuario = $this->codegen_model->row('ecommerce_users', '*', 'dni = "' . $this->input->post('dni') . '"');
        if ($usuario && $usuario->password != null) {
            if ($this->session->userdata('dni')) {
                if ($this->session->userdata('dni') == $usuario->dni) {
                    echo json_encode(array('Value' => 1));
                } else {
                    echo json_encode(array('Value' => 0));
                }
            } else {
                if ($usuario->active != 0 && $usuario->type_id == 2) {
                    echo json_encode(array('Value' => 0));
                } else {
                    echo json_encode(array('Value' => 1));
                }
            }
        } else {
            echo json_encode(array('Value' => 1));
        }
    }

    public function login()
    {
        if ($this->input->post('enviar_form')) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $filter_customer = [
                'email' => $username,
                'password' => sha1($password),
                'status_code_confirmation' => CUSTOMER_ACCOUNT_CONFIRMED,
                'active' => ACTIVE,
            ];

            $customer = $this->customer->find($filter_customer);

            if ($customer) {
                $data_session = [
                    'customer_id' => $customer->id_users,
                    'customer_name' => $customer->name . ' ' . $customer->surname,
                ];
                $this->session->set_userdata($data_session);
                redirect(base_url('productos'), 'refresh');
            } else {
                $this->session->set_flashdata('error', MESSAGE_LOGIN_FAIL);
                redirect(base_url('login'), 'refresh');
            }
        }

        $vista_interna = array(
        );

        $vista_config = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/private/login', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
        );

        $this->load->view('template/frontend', $vista_externa);
    }

    public function register()
    {
        if ($this->input->post('enviar_form')) {
            $name = $this->input->post('name');
            $surname = $this->input->post('surname');
            $province = $this->input->post('province');
            $location = $this->input->post('location');
            $telephone = $this->input->post('telephone');
            $address = $this->input->post('address');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $repeat_password = $this->input->post('repeat_password');
            $dni = $this->input->post('dni');

            $confirmation_code = uniqid();

            $data_register = [
                'name' => $name,
                'surname' => $surname,
                'provincia_id' => $province,
                'localidad_id' => $location,
                'phone' => $telephone,
                'email' => $email,
                'password' => sha1($password),
                'type_id' => CUSTOMER_REGISTERED,
                'status_code_confirmation' => CUSTOMER_ACCOUNT_PENDIENT,
                'code_confirmation' => $confirmation_code,
                'address' => $address,
                'dni' => $dni,
            ];

            $user_id = $this->customer->add($data_register);

            $site_name = $this->codegen_model->row('configurations', '*', 'id_configuration = "1"');
            $site_email = $this->codegen_model->row('configurations', '*', 'id_configuration = "3"');

            $data_register['password'] = $password;

            $this->frontend_lib->enviarEmail($data_register, 'frontend/email/confirm_account', 'Confirme su cuenta', $data_register['email'], $site_email->value, $site_name->value);
            $this->session->set_flashdata('success', MESSAGE_REGISTER_SUCCESS);

            redirect(base_url('login'), 'refresh');
        }

        $vista_interna = array(
            'provinces' => $this->codegen_model->get('geo_provincias', '*', ''),
        );

        $vista_config = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/public/register', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
        );

        $this->load->view('template/frontend', $vista_externa);
    }

    public function accountConfirmation($code_confirmation)
    {
        $filter_customer = [
            'code_confirmation' => $code_confirmation,
            'status_code_confirmation' => CUSTOMER_ACCOUNT_PENDIENT,
            'active' => ACTIVE,
        ];

        $data_update = [
            'status_code_confirmation' => CUSTOMER_ACCOUNT_CONFIRMED,
            'code_confirmation' => '',
        ];

        $number_confirmed = $this->customer->edit($data_update, $filter_customer);

        if ($number_confirmed > 0) {
            $this->session->set_flashdata('success', MESSAGE_CONFIRMATION_SUCCESS);
        } else {
            $this->session->set_flashdata('error', MESSAGE_CONFIRMATION_FAIL);
        }

        redirect(base_url('login'), 'refresh');
    }
    public function changePassword()
    {
        if ($this->input->post('enviar_form')) {
            $user_id = $this->session->userdata('customer_id');
            $data_user = $this->codegen_model->row('ecommerce_users', '*', 'id_users = "' . $user_id . '"');

            $new_password = sha1($this->input->post('password'));
            $old_password = sha1($this->input->post('old_password'));
            if ($data_user->password == $old_password) {
                $data = array(
                    'password' => $new_password,
                );
                $datawhere = array(
                    'id_users' => $user_id,
                );
                $this->customer->edit($data, $datawhere);
                $this->session->set_flashdata('mensaje', 'Success');
                redirect(base_url('dashboard'), 'refresh');
            } else {
                $this->session->set_flashdata('mensaje', 'Error');
                redirect(base_url('change-password'), 'refresh');
            }
        } else {
            $vista_interna = array(
            );

            $vista_config = array(
                'metadata' => '',
                'title' => '',
                'description' => '',
            );

            $vista_externa = array(
                'contenido_main' => $this->load->view('frontend/private/change_password', $vista_interna, true),
                'configuracion' => $this->frontend_lib->configuraciones($vista_config),
            );

            $this->load->view('template/frontend', $vista_externa);
        }
    }
    public function recoverPassword()
    {
        if ($this->input->post('enviar_form')) {
            $username = $this->input->post('username');

            $filter_customer = [
                'email' => $username,
                'type_id' => CUSTOMER_REGISTERED,
                'status_code_confirmation' => CUSTOMER_ACCOUNT_CONFIRMED,
                'active' => ACTIVE,
            ];

            $customer = $this->customer->find($filter_customer);

            if ($customer) {
                $new_password = substr(uniqid(), 0, 6);

                $data_update = [
                    'password' => sha1($new_password),
                ];

                $data_where = [
                    'id_users' => $customer->id_users,
                ];

                $this->customer->edit($data_update, $data_where);

                $site_name = $this->codegen_model->row('configurations', '*', 'id_configuration = "1"');
                $site_email = $this->codegen_model->row('configurations', '*', 'id_configuration = "3"');

                $data_register = [
                    'email' => $customer->email,
                    'password' => $new_password,
                ];

                $this->frontend_lib->enviarEmail($data_register, 'frontend/email/recover_password', 'Se ha restablecido su contraseña', $data_register['email'], $site_email->value, $site_name->value);

                redirect(base_url('login'), 'refresh');
            } else {
                $this->session->set_flashdata('error', MESSAGE_RECOVER_FAIL);
                redirect(base_url('recuperar-password'), 'refresh');
            }
        }

        $vista_interna = array(
        );

        $vista_config = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/public/recover_password', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
        );

        $this->load->view('template/frontend', $vista_externa);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }
    public function terms()
    {

        $vista_interna = array(
            'section' => $this->codegen_model->row('sections', '*', 'id_section = 4'),
        );
        $vista_config = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/public/terms', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
        );

        $this->load->view('template/frontend', $vista_externa);
    }

    public function dashboard()
    {
        $user_id = $this->session->userdata('customer_id');

        if ($this->input->post('enviar_form')) {
            $data_update = [
                'name' => $this->input->post('name'),
                'surname' => $this->input->post('surname'),
                'provincia_id' => $this->input->post('province'),
                'localidad_id' => $this->input->post('location'),
                'phone' => $this->input->post('telephone'),
                'email' => $this->input->post('email'),
            ];

            $data_where = [
                'id_users' => $user_id,
            ];

            $this->customer->edit($data_update, $data_where);

            redirect(base_url('dashboard'), 'refresh');
        }

        $data_where = [
            'id_users' => $user_id,
        ];

        $user = $this->customer->find($data_where);

        $vista_interna = array(
            'user' => $user,
            'provinces' => $this->codegen_model->get('geo_provincias', '*', 'id != "0" ORDER BY provincia'),
            'locations' => $this->codegen_model->get('localidades', '*', 'id_provincia = "' . $user->provincia_id . '" ORDER BY localidad'),
        );

        $vista_config = array(
            'metadata' => '',
            'title' => '',
            'description' => '',
        );

        $vista_externa = array(
            'contenido_main' => $this->load->view('frontend/private/dashboard', $vista_interna, true),
            'configuracion' => $this->frontend_lib->configuraciones($vista_config),
        );

        $this->load->view('template/frontend', $vista_externa);
    }
    public function getShippingSpecific()
    {
        $response = $this->shipping->findByPostalCode($this->input->post('postal_code'));
        if ($response) {
            echo json_encode(array('success' => true, 'response' => $response));
        } else {
            echo json_encode(array('success' => false));
        }
    }
    public function getOrderProducts()
    {
        $response = $this->pedido->getOrderProducts($this->input->post('id_order'));
        echo json_encode(array('success' => true, 'response' => $response));
    }
    public function getDiscount()
    {
        $response = $this->discount->getDiscountPercent($this->input->post('total'));
        if ($response) {
            echo json_encode(array('success' => true, 'response' => $response));
        } else {
            echo json_encode(array('success' => false));
        }
    }

    /*
     * Descuento Diferenciales
     * @return valor total de descuentos diferenciales aplicables
     */

    public function GetDiffDiscount()
    {
        $response = 0;
        foreach ($this->cart->contents() as $items) {
            //reviso si el type_id es diferente de 1 -> siendo 1 "unidad" y 2 "bulto"
            if ($items['desc']) {
                $response += ($items['desc'] / 100) * ($items['price'] * $items['qty']);
            }
        }
        return $response;

    }

}
