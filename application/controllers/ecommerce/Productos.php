<?php

class Productos extends CI_Controller
{
    private $permisos;

    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
        $this->load->model('categoria_model', 'categoria');
        $this->load->model('categoria_producto_model', 'categoria_producto');
        $this->load->model('subcategoria_model', 'subcategoria');
        $this->load->model('producto_model', 'producto');
        $this->load->model('producto_imagen_model', 'producto_imagen');
        $this->load->model('producto_subcategoria_model', 'producto_subcategoria');
        $this->load->model('product_listprice_model', 'Producto_listprice');
        $this->load->model('producto_relacionado_model', 'related_product');
        $this->load->model('afip_iva_model', 'iva');
        $this->load->model('Descuentos_diferenciales_model', 'descuento_custom');
    }

    function render($vista, $data = array(), $title = null)
    {

        $data['permisos_efectivos'] = $this->permisos;

        $vista_externa = array(
            'title' => ucwords(($title)? $title : $this->router->fetch_class()),
            'contenido_main' => $this->load->view($vista['view'], $data, true),
        );

        if (empty($vista['template'])) {
            $vista['template'] = 'template/backend';
        }

        $this->load->view($vista['template'], $vista_externa);
    }

    function index()
    {
        $datos = array(
            'results' => $this->producto->get(),
        );

        $vista = array(
            'view' => 'components/ecommerce/productos/productos_list',
        );

        $this->render($vista, $datos);
    }

    function add()
    {

        if ($this->input->post('enviar_form')) {
            $imagen1 = '';

            if (!empty($_FILES['imagen1']['tmp_name'])) {
                $imagen1 = $this->backend_lib->imagen_upload('imagen1', 'img_productos');
            }

            $offer = $this->input->post('oferta');

            $producto = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'description' => $this->input->post('description'),
                'stock' => $this->input->post('stock'),
                'featured' => $this->input->post('destacado'),
                'offer' => $this->input->post('oferta'),
                'price_individual' => $this->input->post('indi_price'),
                'price_package' => $this->input->post('bulto_price'),
                'unit_bulto' => $this->input->post('unitXbulto'),
                'height'=> $this->input->post('height'),
                'width'=>$this->input->post('width'),
                'depth'=>$this->input->post('depth'),
                'weight'=>$this->input->post('weight'),
                'image1' => $imagen1,
                'offer_price' => ($offer == 1) ? $this->input->post('offer-price') : 0,
                'offer_price_bulto' => ($offer == 1) ? $this->input->post('offer-price-bulto') : 0,
                'create_by' => $this->session->userdata('user_id'),
                'id_iva' => $this->input->post('iva'),
                'id_differential_discount' => $this->input->post('id_differential_discount'),
            );

            //  $this->generateXmlProducts();

            $productoId = $this->producto->insert($producto);

            $image_gallery = $_FILES['op']['tmp_name'];
            if (count($image_gallery) > 0 && !empty($image_gallery)) {
                foreach ($image_gallery as $f => $valor) {
                    if (!empty($image_gallery[$f])) {
                        $_FILES['image_gallery']['name'] = $_FILES['op']['name'][$f];
                        $_FILES['image_gallery']['type'] = $_FILES['op']['type'][$f];
                        $_FILES['image_gallery']['tmp_name'] = $_FILES['op']['tmp_name'][$f];
                        $_FILES['image_gallery']['error'] = $_FILES['op']['error'][$f];
                        $_FILES['image_gallery']['size'] = $_FILES['op']['size'][$f];
                        $image = $this->backend_lib->imagen_upload('image_gallery', 'img_productos');
                        $data = array(
                            'id_product'    =>  $productoId,
                            'image'         =>  $image,
                            'create_by' => $this->session->userdata('user_id')
                        );
                        $this->codegen_model->add('product_images', $data);
                    }
                }
            }
            $subcategoria = $this->input->post('subcategoria_id');
            $categoria = $this->input->post('categoria_id');
            $price = $this->input->post('list_price_id');
            $list= $this->codegen_model->get('list_price', 'id_list_price', '');
            

            $this->addProductoSubcategoria($productoId, $subcategoria);
            $this->addProductoCategoria($productoId, $categoria);
            foreach ($list as $k => $value) {
                $price[$k];
                $lista=$value->id_list_price;
                $this->addListPriceProducto($productoId, $lista, $price[$k]);
            }
            $tags = $this->input->post('related_products');
            if ($tags) {
                foreach ($tags as $k => $v) {
                    $data = array(
                        'id_product'    =>  $productoId,
                        'id_secondary_product'  =>  $v,
                        'create_by' => $this->session->userdata('user_id')
                    );
                    $this->codegen_model->addNoAudit('related_products', $data);
                }
            }
            redirect(base_url('ecommerce/productos'), 'refresh');
        }

        $datos = array(
            'categorias' => $this->categoria->get(),
            // 'categorias_productos' => $this->categoria_producto->get(),
            'productos' => $this->producto->get(),
            'ivas' => $this->iva->get(),
            'descuentos' => $this->descuento_custom->get(),
            'listprecio' => $this->codegen_model->get('list_price', '*', '')
        );

        $vista = array(
            'view' => 'components/ecommerce/productos/productos_add',
        );

        $this->render($vista, $datos);
    }

    function edit($id)
    {
        $result = $this->producto->find($id);

        if ($this->input->post('enviar_form')) {
            $offer = $this->input->post('oferta');
            $producto = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'description' => $this->input->post('description'),
                'stock' => $this->input->post('stock'),
                'featured' => $this->input->post('destacado'),
                'offer' => $this->input->post('oferta'),
                'price_individual' => $this->input->post('indi_price'),
                'price_package' => $this->input->post('bulto_price'),
                'height'=> $this->input->post('height'),
                'width'=>$this->input->post('width'),
                'depth'=>$this->input->post('depth'),
                'weight'=>$this->input->post('weight'),
                'offer_price' => ($offer == 1) ? $this->input->post('offer-price') : 0,
                'offer_price_bulto' => ($offer == 1) ? $this->input->post('offer-price-bulto') : 0,
                'unit_bulto' => $this->input->post('unitXbulto'),
                'update_by' => $this->session->userdata('user_id'),
                'id_iva' => $this->input->post('iva'),
                'id_differential_discount' => $this->input->post('id_differential_discount'),
            );

            if (!empty($_FILES['imagen1']['tmp_name'])) {
                $producto['image1'] = $this->backend_lib->imagen_upload('imagen1', 'img_productos');
            }

            $this->producto->edit($producto, $id);

            $image_gallery = $_FILES['op']['tmp_name'];

            if (count($image_gallery) > 0 && !empty($image_gallery)) {
                foreach ($image_gallery as $f => $valor) {
                    if (!empty($image_gallery[$f])) {
                        $_FILES['image_gallery']['name'] = $_FILES['op']['name'][$f];
                        $_FILES['image_gallery']['type'] = $_FILES['op']['type'][$f];
                        $_FILES['image_gallery']['tmp_name'] = $_FILES['op']['tmp_name'][$f];
                        $_FILES['image_gallery']['error'] = $_FILES['op']['error'][$f];
                        $_FILES['image_gallery']['size'] = $_FILES['op']['size'][$f];
                        $image = $this->backend_lib->imagen_upload('image_gallery', 'img_productos');
                        $data = array(
                            'id_product'    =>  $id,
                            'image'         =>  $image,
                            'create_by' => $this->session->userdata('user_id')
                        );
                        $this->codegen_model->add('product_images', $data);
                    }
                }
            }

            $subcategoria_estado = array(
                'active' => DELETE,
            );
            $this->producto_subcategoria->deleteProductoSubcategoria($subcategoria_estado, $id);
            $subcategoria = $this->input->post('subcategoria_id');
            $this->addProductoSubcategoria($id, $subcategoria);

            $categoria_estado = array(
                'active' => DELETE,
            );
            $this->categoria_producto->deleteProductoCategoria($categoria_estado, $id);
            $categoria = $this->input->post('categoria_id');

            $this->addProductoCategoria($id, $categoria);

            $pricelist_estado = array(
                'active' => DELETE,
            );

            $this->Producto_listprice->deletePriceList($pricelist_estado, $id);

            $price = $this->input->post('list_price_id');
            $list = $this->codegen_model->get('list_price', 'id_list_price', '');

            foreach ($list as $k => $value) {
                $price[$k];
                $lista=$value->id_list_price;
                $this->addListPriceProducto($id, $lista, $price[$k]);
            }

            $related_estado = array(
                'active' => DELETE,
            );

            $this->codegen_model->edit('related_products', $related_estado, 'id_product', $id);

            $tags = $this->input->post('related_products');

            if ($tags) {
                foreach ($tags as $k => $v) {
                    $data = array(
                        'id_product'    =>  $id,
                        'id_secondary_product'  =>  $v,
                        'create_by' => $this->session->userdata('user_id')
                    );
                    $this->codegen_model->addNoAudit('related_products', $data);
                }
            }

            redirect(base_url('ecommerce/productos'), 'refresh');
        }

        $producto = $this->producto->find($id);

        $producto_subcategoria = $this->producto_subcategoria->findCategoriaProducto($id);

        if ($producto_subcategoria) {
            $id_category = $producto_subcategoria->id_category;
            $id_subcategory = $producto_subcategoria->id_subcategory;
        } else {
            $id_category = 0;
            $id_subcategory = 0;
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $result,
            'id_category' => $id_category,
            'id_subcategory' => $id_subcategory,
            'categorias' => $this->categoria->get(),
            'subcategorias' => $this->subcategoria->getCategory($id_category),
            'listpre' => $this->Producto_listprice->getLisProcducPrice($id),
            'related_products' => $this->related_product->getRelatedProducts($id),
            'productos' => $this->producto->get(),
            'gallery'   =>  $this->producto->getGallery($id),
            'ivas' => $this->iva->get(),
            'descuentos' => $this->descuento_custom->get(),
        );

        $vista_externa = array(
            'title' => ucwords("productos"),
            'contenido_main' => $this->load->view('components/ecommerce/productos/productos_edit', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function view($id)
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->producto->findDetail($id),
        );

        $vista_externa = array(
            'title' => ucwords("productos"),
            'contenido_main' => $this->load->view('components/ecommerce/productos/productos_view', $vista_interna, true)
        );
        $this->load->view('template/view', $vista_externa);
    }

    function delete($id)
    {
        $data = array(
            'active'    => 0,
        );
        $this->producto->edit($data, $id);
        // $this->generateXmlProducts();
    }

    function jsonProductosRelacion($id = 0)
    {

        $term = $this->input->post('term');
        $buscar = $term['term'];
        $users = $this->producto->search($buscar, $id);
        echo json_encode(array('results' => $users, 'more' => false));
    }
    function deleteGalleryImg()
    {
        $img_id = $this->input->post('img');
        $this->producto->deleteGallery($img_id);
    }
    function addListPriceProducto($productoId, $lista, $price)
    {
        if ($lista) {
            $data = array(
            'id_product' => $productoId,
            'id_list_price' => $lista,
            'price' => $price
            );
            $this->Producto_listprice->insert($data);
        }
    }
    function addProductoSubcategoria($id_producto, $subcategoria_id)
    {
        if ($subcategoria_id) {
            $subcategoria_producto = array(
                'id_subcategory' => $subcategoria_id,
                'id_product' => $id_producto,
                'active' => ACTIVE,
            );
            $this->producto_subcategoria->insert($subcategoria_producto);
        }
    }
    function addProductoCategoria($id_producto, $categoria_id)
    {
        if ($categoria_id) {
            $categoria_producto = array(
                'id_category' => $categoria_id,
                'id_product' => $id_producto,
                'active' => ACTIVE,
            );
            $this->categoria_producto->insert($categoria_producto);
        }
    }
    function jsonSubcategorias($categoriaId)
    {

        $subcategorias = $this->subcategoria->get(['subcategories.id_category' => $categoriaId]);

        $response = [
            'success' => true,
            'subcategorias' => $subcategorias,
        ];

        echo json_encode($response);
    }

    function import()
    {
        if ($this->input->post('enviar_form')) {
            $this->producto->truncate();
            $this->producto->truncatelistprices();
            $path = $_FILES['file']['tmp_name'];
            $this->load->library('excel');
            $objPHPExcel = PHPExcel_IOFactory::load($path);

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle = $worksheet->getTitle();
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                $nrColumns = ord($highestColumn) - 64;

                for ($row = 2; $row <= $highestRow; ++$row) {
                    for ($col = 0; $col < $highestColumnIndex; ++$col) {
                        $cell  = $worksheet->getCellByColumnAndRow($col, 1);
                        $value = $worksheet->getCellByColumnAndRow($col, $row);
                        $field = $cell->getValue();
                        $val   = $value->getValue();
                        $arr[$row][$field] = $val;
                    }
                }

                foreach ($arr as $item) {
                    try {
                        $product_data = array(
                            'code' => $item['codigo'],
                            'description' => $item['decripcion'],
                            'name' => $item['nombre'],
                            'width' => $item['ancho'],
                            'height' => $item['alto'],
                            'depth' => $item['profundidad'],
                            'weight' => $item['peso'],
                            'id_iva' => $item['iva'],
                            'price_individual' => $item['precio_minorista_individual'],
                            'price_package' => $item['precio_minorista_por_bulto'],
                            'offer_price' => $item['oferta_precio_individual'] ? $item['oferta_precio_individual'] :'0',
                            'offer_price_bulto' => $item['oferta_precio_bulto'] ? $item['oferta_precio_bulto'] :'0',
                            'stock' =>  $item['stock'],
                            'unit_bulto' => $item['unidades_por_bulto'],
                            'featured' => $item['destacado'] ? $item['destacado'] : '0',
                            'offer' =>  $item['oferta'] ? $item['oferta'] : '0',
                            'image1' => !empty($item['imagen']) ? $item['imagen'] : '',
                        );

                        $productId = $this->codegen_model->addNoAudit('products', $product_data);

                        if (!empty($item['subcategoria']) && is_numeric($item['subcategoria'])) {
                            $subcategoryProduct = [
                                'id_product' => $productId,
                                'id_subcategory' => $item['subcategoria'],
                                'active' => ACTIVE,
                            ];
                            $this->codegen_model->addNoAudit('products_subcategories', $subcategoryProduct);
                        }
                        if (!empty($item['categoria']) && is_numeric($item['categoria'])) {
                            $categoryProduct = [
                                'id_product' => $productId,
                                'id_category' => $item['categoria'],
                                'active' => ACTIVE,
                            ];
                            $this->codegen_model->addNoAudit('products_categories', $categoryProduct);
                        }

                        for ($i=1; $i <= 5; $i++) {
                            $listPriceProduct = [
                                'id_product' => $productId,
                                'price' => $item['lista_'.$i] ? $item['lista_'.$i] : 0,
                                'id_list_price' => $i,
                                'active' => ACTIVE,
                            ];
                            $this->codegen_model->addNoAudit('price_products', $listPriceProduct);
                        }
                    } catch (Exception $e) {
                        $e->getMessage();
                    }
                }
            }

            // $this->generateXmlProducts();

            $this->session->set_flashdata('success', 'Se han importado los productos satisfactoriamente.');

            redirect(base_url('ecommerce/productos'), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
        );

        $vista_externa = array(
            'title' => ucwords("productos"),
            'contenido_main' => $this->load->view('components/ecommerce/productos/productos_importacion', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }
    function importCodeDetected()
    {
        if ($this->input->post('enviar_form'))
        {
            $path = $_FILES['file']['tmp_name'];
            $this->load->library('excel');
            $objPHPExcel = PHPExcel_IOFactory::load($path);

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
            {
                $worksheetTitle = $worksheet->getTitle();
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                $nrColumns = ord($highestColumn) - 64;

                for ($row = 2; $row <= $highestRow; ++$row)
                {
                    for ($col = 0; $col < $highestColumnIndex; ++$col)
                    {
                        $cell  = $worksheet->getCellByColumnAndRow($col, 1);
                        $value = $worksheet->getCellByColumnAndRow($col, $row);
                        $field = $cell->getValue();
                        $val   = $value->getValue();
                        $arr[$row][$field] = $val;
                    }
                }

                foreach ($arr as $item)
                {
                    try
                    {
                        $code = $this->producto->findCode($item['codigo']);
                        if (!$code)
                        {
                            $productData = array(
                                'code' => $item['codigo'],
                                'description' => $item['decripcion'],
                                'name' => $item['nombre'],
                                'width' => $item['ancho'],
                                'height' => $item['alto'],
                                'depth' => $item['profundidad'],
                                'weight' => $item['peso'],
                                'price_individual' => $item['precio_minorista_individual'],
                                'price_package' => $item['precio_minorista_por_bulto'],
                                'offer_price' => $item['oferta_precio_individual'] ? $item['oferta_precio_individual'] :'0',
                                'offer_price_bulto' => $item['oferta_precio_bulto'] ? $item['oferta_precio_bulto'] :'0',
                                'stock' =>  $item['stock'],
                                'unit_bulto' => $item['unidades_por_bulto'],
                                'featured' => $item['destacado'] ? $item['destacado'] : '0',
                                'offer' =>  $item['oferta'] ? $item['oferta'] : '0',
                                'image1' => !empty($item['imagen']) ? $item['imagen'] : '',
                            );

                            $productId = $this->codegen_model->addNoAudit('products', $productData);

                            if (!empty($item['subcategoria']) && is_numeric($item['subcategoria']))
                            {
                                $subcategoryProduct = [
                                    'id_product' => $productId,
                                    'id_subcategory' => $item['subcategoria'],
                                    'active' => ACTIVE,
                                ];
                                $this->codegen_model->addNoAudit('products_subcategories', $subcategoryProduct);
                            }

                            if (!empty($item['categoria']) && is_numeric($item['categoria']))
                            {
                                $categoryProduct = [
                                    'id_product' => $productId,
                                    'id_category' => $item['categoria'],
                                    'active' => ACTIVE,
                                ];
                                $this->codegen_model->addNoAudit('products_categories', $categoryProduct);
                            }

                            if (!empty($item['productos_relacionados']) && is_numeric($item['productos_relacionados'])) {
                                $ids = explode(',', $item['productos_relacionados']);
                                foreach ($ids as $k => $v) {
                                    $relatedProduct = [
                                        'id_product' => $productId,
                                        'id_secondary_product' => $v,
                                        'active' => ACTIVE,
                                    ];
                                    $this->codegen_model->addNoAudit('related_products', $relatedProduct);
                                }
                            }

                            if (!empty($item['lista_de_precios']))
                            {
                                $ids = explode(',', $item['lista_de_precios']);
                                foreach ($ids as $k => $v)
                                {
                                    $listPriceProduct = [
                                        'id_product' => $productId,
                                        'price' => $v,
                                        'id_list_price' => $k+1,
                                        'active' => ACTIVE,
                                    ];
                                    $this->codegen_model->addNoAudit('price_products', $listPriceProduct);
                                }
                            }

                        } else {
                            $msg[] = $item['codigo'];
                        }

                    } catch (Exception $e) {
                        $e->getMessage();
                    }

                }

                foreach ($msg as $key => $value)
                {
                    var_dump($value);
                }exit;
            }

            $this->session->set_flashdata('success', 'Se han importado los productos satisfactoriamente.');

            redirect(base_url('ecommerce/productos'), 'refresh');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
        );

        $vista_externa = array(
            'title' => ucwords("productos"),
            'contenido_main' => $this->load->view('components/ecommerce/productos/productos_importacion', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);

    }

    public function export()
    {
        $this->load->library('excel');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'codigo');
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'nombre');
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'decripcion');
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'categoria');
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'subcategoria');
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'unidades_por_bulto');
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'stock');
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'precio_minorista_individual');
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'precio_minorista_por_bulto');
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'destacado');
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'oferta');
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, 'oferta_precio_individual');
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, 'oferta_precio_bulto');
        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, 'alto');
        $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, 'ancho');
        $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, 'profundidad');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, 'peso');
        $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, 'imagen');
        $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, 'iva');
        $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, 'lista_1');
        $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, 'lista_2');
        $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, 'lista_3');
        $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, 'lista_4');
        $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, 'lista_5');

        $rowCount++;
        $products = $this->producto->getExport();

        $related_product = $this->producto->related_products();

        foreach ($products as $key => $product)
        {
            $prices[] = explode(',', $product->prices);
            
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $product->code);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $product->name);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $product->description);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $product->id_category);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $product->id_subcategory);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $product->unit_bulto);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $product->stock);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $product->price_individual);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $product->price_package);
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $product->featured);
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $product->offer);
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $product->offer_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $product->offer_price_bulto);
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $product->height);
            $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $product->width);
            $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $product->depth);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $product->weight);
            $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $product->image1);
            $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $product->id_iva);
            $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $prices[$key][0]);
            $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $prices[$key][1]);
            $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $prices[$key][2]);
            $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $prices[$key][3]);
            $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $prices[$key][4]);

            $rowCount++;

        }

        foreach (range('A', 'X') as $columnID)
        {
            $objPHPExcel
                ->getActiveSheet()
                ->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $filename = 'productos_';

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . date('d-m-Y_H:m:s') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');

    }

    public function registroVariantes($productoId)
    {
        $talle = $this->input->post('talle');
        $color = $this->input->post('color');
        $stock = $this->input->post('stock');

        if ($stock) {
            foreach ($stock as $index => $value) {
                $sizeId = $talle[$index];
                $colorId = $color[$index];
                $cantidad = $stock[$index];

                $data = array(
                    'id_product' => $productoId,
                    'id_size' => $sizeId,
                    'id_color' => $colorId,
                    'stock' => $cantidad,
                );

                $this->variant_products->insert($data);
            }
        }
    }

    public function registroGaleriaColores($productoId)
    {
        $coloresGrupos = $this->input->post('color_group');

        if ($coloresGrupos) {
            foreach ($coloresGrupos as $key => $colorId) {
                if (!empty($_FILES['color_imagen']['tmp_name'][$colorId])) {
                    $total = count($_FILES['color_imagen']['name'][$colorId]);

                    for ($i=0; $i < $total; $i++) {
                        $tmpFilePath = $_FILES['color_imagen']['tmp_name'][$colorId][$i];

                        if (!empty($tmpFilePath)) {
                            $_FILES['image_producto']['name'] = $_FILES['color_imagen']['name'][$colorId][$i];
                            $_FILES['image_producto']['type'] = $_FILES['color_imagen']['type'][$colorId][$i];
                            $_FILES['image_producto']['tmp_name'] = $_FILES['color_imagen']['tmp_name'][$colorId][$i];
                            $_FILES['image_producto']['error'] = $_FILES['color_imagen']['error'][$colorId][$i];
                            $_FILES['image_producto']['size'] = $_FILES['color_imagen']['size'][$colorId][$i];

                            $imageTmp = $this->backend_lib->imagen_upload('image_producto', 'img_productos');

                            $dataImageProduct = array(
                                'id_product' => $productoId,
                                'id_color' => $colorId,
                                'image' => $imageTmp,
                                'active' => ACTIVE,
                            );

                            $this->producto_imagen->insert($dataImageProduct);
                        }
                    }
                }
            }
        }
    }

    public function registroImagenesPrecargadas($productoId)
    {
        $imagenesAntiguas = $this->input->post('color_group_old');
        $coloresGrupos = $this->input->post('color_group');

        if ($coloresGrupos) {
            foreach ($coloresGrupos as $key => $colorId) {
                if (!empty($imagenesAntiguas[$colorId]) && count(!empty($imagenesAntiguas[$colorId])) > 0) {
                    foreach ($imagenesAntiguas[$colorId] as $key => $image) {
                        $dataImageProduct = array(
                            'id_product' => $productoId,
                            'id_color' => $colorId,
                            'image' => $image,
                            'active' => ACTIVE,
                        );
                        $this->producto_imagen->insert($dataImageProduct);
                    }
                }
            }
        }
    }

    function jsonRelatedProducts($id = 0)
    {
        $term = $this->input->post('term');
        $search = $term['term'];
        $products = $this->producto->search($search, $id);
        echo json_encode(array('results' => $products, 'more' => false));
    }

    public function ValidarCode()
    {
        $id = $this->input->post('id');
        $code = $this->input->post('code');

        $query_product_info = '';

        if (isset($id) && !empty($id))
        {
            $query_product_info = ' AND id_product != "'.$id.'"';
        }

        $product_exist = $this->codegen_model->row('products', 'id_product', 'code = "'.$code.'"'.$query_product_info.' AND active = "1"');
        
        $response = array(
            'status' => true,
            'msg' => 'Success' ,
            'msj' => 'Codigo Libre',
        );

        if ($product_exist) {
            $response['status'] = false;
            $response['msg'] = 'Ocurrio un error';
            $response['msj'] = 'El código ya existe';
        }

        echo json_encode($response);
    }
}
