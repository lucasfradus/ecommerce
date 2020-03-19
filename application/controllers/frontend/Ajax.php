<?php

class Ajax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('producto_model', 'producto');
        $this->load->model('producto_stock_model', 'producto_stock');
        $this->load->model('producto_imagen_model', 'producto_imagen');
        $this->load->model('categoria_model', 'category');
        $this->load->model('discount_model', 'descuento');
        $this->load->model('customer_model', 'customer');
        $this->load->model('Descuentos_diferenciales_model', 'diff_discount');
    }

    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } else if (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } else if (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public function insertProductCart()
    {
        $response = [];
        $id_producto = $this->input->post('id_product');
        $cantidad = $this->input->post('qty');
        $id_tipo = $this->input->post('type_id');
        $unidad_bulto = $this->input->post('unit_bulto');

        $cantidad = ($id_tipo == PRODUCT_ADD_TYPE_PACK) ? $cantidad * $unidad_bulto : $cantidad;
        $product = $this->producto->find($id_producto);

        foreach ($this->cart->contents() as $key => $value) {
            if ($id_producto == $value['id']) {
                if ($value['options']['type_id'] == PRODUCT_ADD_TYPE_PACK) {
                    $cantidad += ($value['qty'] * $unidad_bulto);

                } else {
                    $cantidad += $value['qty'];
                }
            }
        }
        $diff_desc = null;

        if ($product->stock < $cantidad) {
            $response['success'] = false;
        } elseif ($this->input->post('enviar_form')) {
            $id_producto = $this->input->post('id_product');
            $cantidad = $this->input->post('qty');
            $unit_bulto = $this->input->post('unit_bulto');
            $type_id = $this->input->post('type_id');
            $id_talle = $this->input->post('id_size');
            $id_color = $this->input->post('id_color');
            $id_heel = $this->input->post('id_heel');

            $producto = $this->producto->detail($id_producto);

            if ($type_id == PRODUCT_ADD_TYPE_PACK) {
                //AGREGO al CART el desc differencial si existe, si no, agrego 100.
                $descuento = $this->diff_discount->get_descuento($producto->id_differential_discount, $cantidad);
                if ($descuento) {
                    $diff_desc = $descuento->discount;
                } else {
                    $diff_desc = null;
                }
            }

            $filters = [
                'id_product' => $id_producto,
                'id_size' => $id_talle,
                'id_color' => $id_color,
            ];
            
            $item_cart = array(
                'id' => intval($producto->id_product),
                'qty' => $cantidad,
                'codigo' => convert_accented_characters($producto->code),
                'name' => convert_accented_characters($producto->name),
                'desc' => $diff_desc,
                'options' => array(
                    'type_id' => $type_id,
                    'imagen' => $producto->image1,
                    'categoria' => convert_accented_characters($producto->category),
                    'subcategoria' => convert_accented_characters($producto->subcategory),
                   
                ),
            );

            if ($this->session->userdata('customer_id')) {
                $user = $this->codegen_model->row('ecommerce_users', 'id_users,id_list_price', 'id_users = "' . $this->session->userdata('customer_id') . '" AND ACTIVE = "' . ACTIVE . '"');

                if ($user->id_list_price > 0 && $user->id_list_price != '') {
                    $product_list = [];
                    $product_list_id = [];
                    $ids = explode(',', $producto->lista_id);
                    $prices = explode(',', $producto->prices);
                    $prices_ids = explode(',', $producto->lista_id);

                    foreach ($ids as $l => $lp) {
                        $product_list[$lp] = $prices[$l];
                        $product_list_id[$lp] = $prices_ids[$l];
                    }

                    $producto->prices = $product_list;
                    $producto->product_list_id = $product_list_id;

                    if ($producto->prices[$user->id_list_price] <= 0) {
                        $item_cart['price'] = number_format($producto->price_package, 2, '.', '');
                        $item_cart['options']['list_id'] = 0;
                    } else {
                        $item_cart['price'] = number_format($producto->prices[$user->id_list_price], 2, '.', '');
                        $item_cart['options']['list_id'] = $producto->product_list_id[$user->id_list_price];
                    }
                } else {
                    $item_cart['price'] = number_format($producto->price_package, 2, '.', '');
                    $item_cart['options']['list_id'] = 0;
                }
            } elseif ($producto->offer == 1) {
                if ($type_id == 1) {
                    $item_cart['price'] = number_format($producto->offer_price, 2, '.', '');
                    $item_cart['options']['list_id'] = 0;
                } else {
                    $item_cart['price'] = number_format($producto->offer_price_bulto, 2, '.', '');
                    $item_cart['options']['list_id'] = 0;
                }
            } else {
                if ($type_id == 1) {
                    $item_cart['price'] = number_format($producto->price_individual, 2, '.', '');
                    $item_cart['options']['list_id'] = 0;
                } else {
                    $item_cart['price'] = number_format($producto->price_package, 2, '.', '');
                    $item_cart['options']['list_id'] = 0;
                }
            }

            $this->cart->product_name_rules = '[:print:]';
            $cart = $this->cart->insert($item_cart);

            $response['success'] = true;
            $response['total'] = $this->cart->total();
            $response['num_items'] = $this->cart->total_items();
            $response['num'] = count($this->cart->contents());
            $response['redirect'] = base_url('carrito');
        } else {
            $response['message'] = "Sin stock disponible para este talle y color.";
            $response['success'] = false;
        }

        echo json_encode($response);
    }

    public function getIdRowCarrito($productoId, $talleId, $colorId)
    {
        $rowid = null;
        $item = $this->getItemCarrito($productoId, $talleId, $colorId);

        if ($item) {
            $rowid = $item['rowid'];
        }

        return $rowid;
    }

    public function getProductoCarritoRowId($rowid)
    {
        foreach ($this->cart->contents() as $item) {
            if ($item['rowid'] == $rowid) {
                return $item;
            }
        }
        return null;
    }

    public function getNumberItemsProductoCarrito($id_product, $id_talle, $id_color)
    {
        $number_items = 0;
        $item = $this->getItemCarrito($id_product, $id_talle, $id_color);

        if ($item) {
            $number_items = $item['qty'];
        }

        return $number_items;
    }

    public function getItemCarrito($id_product, $id_talle, $id_color)
    {
        foreach ($this->cart->contents() as $item) {
            if ($item['id'] == $id_product && $item['options']['id_talle'] == $id_talle && $item['options']['id_color'] == $id_color) {
                return $item;
            }
        }

        return null;
    }

    public function getTallesProduct()
    {
        if ($this->input->post('enviar_form')) {
            $id_product = $this->input->post('id_product');
            $data = [];
            $data['talles'] = $this->producto_stock->getSizesProductStock($id_product);
            $data['colores'] = $this->producto_stock->getColorsProductStock($id_product);
            echo json_encode(array('data' => $data));
        }
    }

    public function eliminacionProducto()
    {
        if ($this->input->post('enviar_form')) {
            $id = $this->input->post('id');
            $data = array(
                'rowid' => $id,
                'qty' => 0,
            );
            $this->cart->update($data);

            echo json_encode(array('success' => true, 'total' => $this->cart->total()));
        }
    }

    public function edicionProductCart()
    {
        $response['success'] = false;
        if ($this->input->post('enviar_form')) {
            $cantidad = $this->input->post('cantidad');
            $cantidad_tmp = $cantidad;
            $id = $this->input->post('rowid');

            $item = $this->getProductoCarritoRowId($id);

            $producto_info = $this->producto->find($item['id']);

            $cantidad_unidades_bultos_actuales = 0;
            $cantidad_actuales = 0;
            if ($item) {



                if ($item['options']['type_id'] == PRODUCT_ADD_TYPE_PACK) {
                    $cantidad_tmp = ($cantidad * $producto_info->unit_bulto);
                }

                foreach ($this->cart->contents() as $key => $value) {
                    if ($item['id'] == $value['id']) {
                        if ($item['options']['type_id'] == PRODUCT_ADD_TYPE_UNITY && $value['options']['type_id'] == PRODUCT_ADD_TYPE_PACK) {
                            $cantidad_tmp += ($value['qty'] * $producto_info->unit_bulto);
                            $cantidad_unidades_bultos_actuales = ($value['qty'] * $producto_info->unit_bulto);
                            $cantidad_actuales = $value['qty'];
                        }

                        if ($item['options']['type_id'] == PRODUCT_ADD_TYPE_PACK && $value['options']['type_id'] == PRODUCT_ADD_TYPE_UNITY) {
                            $cantidad_tmp += $value['qty'];
                            $cantidad_unidades_bultos_actuales = floor($value['qty'] / $producto_info->unit_bulto);
                            $cantidad_actuales = $value['qty'];
                        }
                    }
                }
            }

            if ($producto_info->stock >= $cantidad_tmp) {
                
            //valido los descuento diferenciales  
            if ($item['options']['type_id'] == PRODUCT_ADD_TYPE_PACK) {
                //AGREGO al CART el desc differencial si existe, si no, seteo en null.
                $descuento = $this->diff_discount->get_descuento($producto_info->id_differential_discount, $cantidad);
                if ($descuento) {
                    $response['new_desc'] = $descuento->discount;
                } else {
                    $response['new_desc'] = null;
                }
            }else{
                 $response['new_desc'] = null;
            }


                $response['cantidad'] = $cantidad;

                $datos_carrito = array(
                    'rowid' => $id,
                    'qty' => $cantidad,
                    'diff_desc' => $response['new_desc'],
                  

                );
                $this->cart->update($datos_carrito);

                $response['success'] = true;
            } else {
                if ($item['options']['type_id'] == PRODUCT_ADD_TYPE_PACK) {
                    $response['cantidad'] = floor(($producto_info->stock - $cantidad_actuales) / $producto_info->unit_bulto);
                } else {
                    $response['cantidad'] = $producto_info->stock - $cantidad_unidades_bultos_actuales;
                }
            }
            $response['total'] = $this->cart->total();
            $response['num_items'] = $this->cart->total_items();
        }

        echo json_encode($response);
    }

    public function getNumItems()
    {
        if ($this->input->post('enviar_form')) {
            echo json_encode(array('items' => $this->cart->total_items()));
        }
    }

    public function edicionCantidad(Type $var = null)
    {
        echo json_encode(array('items' => $this->cart->total_items()));
    }

    public function filterProducts($id_category_product = null, $category_product_slug = null, $id_category = null, $category_slug = null, $id_subcategory = null, $subcategory_slug = null, $page = 0)
    {

        $response = array(
            'status' => false,
            'data' => [],
            'info' => 'error',
            'code' => 404
        );

        $filters_brand = $this->input->get('filters_brand');
        $filters_sport = $this->input->get('filters_sport');
        $filters_color = $this->input->get('filters_color');
        $filters_size = $this->input->get('filters_size');
        $filters_price = $this->input->get('filters_price');

        $parameters = array(
            'where' => array(
                'id_category_product' => $id_category_product,
                'id_category' => $id_category,
                'id_subcategory' => $id_subcategory,
                'filters_brand' => $filters_brand,
                'filters_sport' => $filters_sport,
                'filters_color' => $filters_color,
                'filters_size' => $filters_size,
                'filters_price' => array(
                    'minimo' => $filters_price['minimo'],
                    'maximo' => $filters_price['maximo'],
                ),
            ),
            'page' => $page,
        );

        $responseProducts = $this->producto->getCategory($parameters);

        $parameters['num_rows'] = true;
        $links = $this->producto->getCategory($parameters);

        $this->load->library('pagination');

        $config['base_url'] = base_url();
        $config['total_rows'] = $links;
        $config['per_page'] = PER_PAGE;
        $config['first_link'] = 'Primero';
        $config['last_link'] = 'Último';
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        $this->pagination->initialize($config);
        $links = $this->pagination->create_links();

        $response['status'] = true;
        $response['data'] = array(
            'products' => $responseProducts,
            'links' => $links,
        );
        $response['info'] = 'Exito';
        $response['code'] = '';

        echo json_encode($response);
    }

    public function modo_entrega()
    {

        include APPPATH . '../system/libraries/oca_webservice.php';
        $oca = new Oca('27-30948143-2');

        $direccion = $this->input->post('direccion');

        $response = array(
            "estado" => true,
            "tipo_entrega" => $this->input->post('modo_entraga'),
        );

        switch ($this->input->post('modo_entraga')) {
            case 1:
                $tipo_entrega = "Entrega a su domicilio";
                $response["webservice"]["estado"] = false;
                break;
            case 2:
                $tipo_entrega = "Retiro en las oficinas";
                $response["webservice"]["estado"] = false;
                break;
            case 3:
                $tipo_entrega = "Sucursal de OCA";

                $response_webservice = $oca->getCentrosImposicion();

                $response["webservice"] = array(
                    "estado" => true,
                    "tipo" => "sucursal",
                    "response" => $response_webservice,
                );
                break;
            case 4:
                $tipo_entrega = "eLockers OCA";
                $response["webservice"] = array(
                    "estado" => true,
                    "tipo" => "elockers",
                    "response" => json_decode(file_get_contents('http://www5.oca.com.ar/WebApi/Api/EventosLockers.mvc/ObtenerELockers')),
                );
                break;
            default:
                $tipo_entrega = "Retiro en las oficinas";
                $response["webservice"]["estado"] = false;
                break;
        }
        echo json_encode($response);
    }

    public function costosEnviosPostal()
    {
        $result = $this->codegen_model->get('shipping', '*', 'status_id = "1"');
        echo json_encode(array('data' => $result));
    }

    public function validacionEmail()
    {
        $email_newsletter = $this->input->post('email_newsletter');
        $email = $this->codegen_model->row('newsletters', '*', 'email="' . $email_newsletter . '"');

        if (empty($email)) {
            $data = array(
                'email' => $email_newsletter,
            );

            $id = $this->codegen_model->add('newsletters', $data);

            $response['result'] = false;
        } else {
            $response['result'] = true;
        }

        echo json_encode($response);
    }

    public function productoVariante()
    {
        if ($this->input->post('enviar_form')) {
            $productoId = $this->input->post('productoId');
            $producto = $this->producto->find($productoId);

            if ($producto) {
                $response = [
                    'success' => true,
                    'producto' => $producto,
                    'talles_producto' => $this->variante_producto->getSizes($productoId),
                    'colores_producto' => $this->variante_producto->getColors($productoId),
                    'tacos_producto' => $this->producto->heel($productoId),
                    'variantes' => $this->variante_producto->getVariantProducto($productoId),
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No se encontraron resultados',
                ];
            }

            echo json_encode($response);
        }
    }

    public function imagenesProducto()
    {

        if ($this->input->post('enviar_form')) {
            $productoId = $this->input->post('producto_id');
            $imagenes = $this->producto_imagen->getGaleriaProducto($productoId);
            echo json_encode(array('success' => true, 'imagenes' => $imagenes));
        }
    }

    public function changeOrder()
    {
        $id_category_id = $this->input->post('id');
        $order = $this->input->post('order');
        $data = array(
            'order' => $this->input->post('order'),
        );
        $this->category->edit($data, $id_category_id);
        echo json_encode(array('success' => true));
    }

    public function validacionCupon()
    {

        if ($this->input->post('enviar_form')) {
            $where = [
                'code' => $this->input->post('cupon'),
            ];

            $discount = $this->descuento->first($where);

            if ($discount) {
                $response = [
                    'success' => true,
                    'discount' => $discount,
                ];
            } else {
                $response = [
                    'success' => false,
                ];
            }

            echo json_encode($response);
        }
    }

    public function locations()
    {
        $province = $this->input->post('province');
        $locations = $this->codegen_model->get('localidades', '*', 'id_provincia = "' . $province . '"');
        $response = [
            'success' => true,
            'locations' => $locations,
        ];
        echo json_encode($response);
    }

    public function login()
    {
        if ($this->input->post('enviar_form')) {
            $username = $this->input->post('usuario');
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
                $this->cart->destroy();
                $response = [
                    'success' => true,
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => MESSAGE_LOGIN_FAIL,
                ];
            }

            echo json_encode($response);
        }
    }

    public function deleteProduct()
    {
        if ($this->input->post('delete_form')) {
            $id = $this->input->post('id');
            $data = array(
                'rowid' => $id,
                'qty' => 0,
            );
            $this->cart->update($data);
            $response = array(
                'success' => true,
                'total' => number_format($this->cart->total(), 2, '.', ''),
                'num_items' => $this->cart->total_items(),
            );
            echo json_encode($response);
        }
    }

}
