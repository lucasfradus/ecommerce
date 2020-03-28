<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            $spreadsheet = $reader->load($path);
            $spreadsheet->getActiveSheet()->removeRow(1);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            //print_r($sheetData);
            
            foreach ($sheetData as $item) {
                try {
                    $product_data = array(
                        'code' => $item[0],
                        'name' => $item[1],
                        'description' => $item[2],
                        'unit_bulto' => $item[5],
                        'stock' =>  $item[6],
                        'price_individual' => $item[7],
                        'price_package' => $item[8],
                        'featured' => $item[9] ? $item[9] : '0',
                        'offer' =>  $item[10] ? $item[10] : '0',
                        'offer_price' => $item[11] ? $item[11] :'0',
                        'offer_price_bulto' => $item[12] ? $item[12] :'0',
                        'height' => $item[13],
                        'width' => $item[14],
                        'depth' => $item[15],
                        'weight' => $item[16],
                        'image1' => !empty($item[17]) ? $item[17] : '',
                        'id_iva' => $item[18],
                        'id_differential_discount' =>  $item[19],
                        'active' =>  1,  
                    );

                    $productId = $this->codegen_model->addNoAudit('products', $product_data);

                    if (!empty($item[4]) && is_numeric($item[4])) {
                        $subcategoryProduct = [
                            'id_product' => $productId,
                            'id_subcategory' => $item[4],
                            'active' => ACTIVE,
                        ];
                        $this->codegen_model->addNoAudit('products_subcategories', $subcategoryProduct);
                    }
                    if (!empty($item[3]) && is_numeric($item[3])) {
                        $categoryProduct = [
                            'id_product' => $productId,
                            'id_category' => $item[3],
                            'active' => ACTIVE,
                        ];
                        $this->codegen_model->addNoAudit('products_categories', $categoryProduct);
                    }
                    for ($i=20; $i < 25; $i++) {
                        $listPriceProduct = [
                            'id_product' => $productId,
                            'price' => $item[$i] ? $item[$i] : 0,
                            'id_list_price' => $i-19,
                            'active' => ACTIVE,
                        ];
                        $this->codegen_model->addNoAudit('price_products', $listPriceProduct);
                    }
                } catch (Exception $e) {
                    $e->getMessage();
                }
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
    public function export_template(){ 
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
     
        // add style to the header
            $styleArray = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'bottom' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('rgb' => '333333'),
                ),
            ),
            'fill' => array(
                'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation'   => 90,
                'startcolor' => array('rgb' => '0d0d0d'),
                'endColor'   => array('rgb' => 'f2f2f2'),
            ),
            );

    $spreadsheet->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styleArray);
    // auto fit column to content
    foreach(range('A', 'Y') as $columnID) {
      $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }
    $sheet->setCellValue('A1', 'Código');
    $sheet->setCellValue('B1', 'Nombre');
    $sheet->setCellValue('C1', 'Descripción');
    $sheet->setCellValue('D1', 'ID Categoria');
    $sheet->setCellValue('E1', 'ID SubCategoria');
    $sheet->setCellValue('F1', 'Unidades en Bulto');
    $sheet->setCellValue('G1', 'Stock');
    $sheet->setCellValue('H1', 'Precio Individual');
    $sheet->setCellValue('I1', 'Precio por Bulto');
    $sheet->setCellValue('J1', '¿Es Destacado?');
    $sheet->setCellValue('K1', '¿Es Oferta?');
    $sheet->setCellValue('L1', 'Precio Individual Oferta');
    $sheet->setCellValue('M1', 'Precio Por Bulto Oferta');
    $sheet->setCellValue('N1', 'Alto');
    $sheet->setCellValue('O1', 'Ancho');
    $sheet->setCellValue('P1', 'Profundo');
    $sheet->setCellValue('Q1', 'Peso');
    $sheet->setCellValue('R1', 'Imagen');
    $sheet->setCellValue('S1', 'IVA');
    $sheet->setCellValue('T1', 'ID Descuento Diferencial');
    $sheet->setCellValue('U1', 'Precio de Lista 1');
    $sheet->setCellValue('V1', 'Precio de Lista 2');
    $sheet->setCellValue('W1', 'Precio de Lista 3');
    $sheet->setCellValue('X1', 'Precio de Lista 4');
    $sheet->setCellValue('Y1', 'Precio de Lista 5');

     
      $writer = new Xlsx($spreadsheet);

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Template_Carga_Masiva_Productos.xlsx"'); 
      header('Cache-Control: max-age=0');
      
      $writer->save('php://output'); // download file 

}
    public function export()
    {
         // Create new Spreadsheet object
         $spreadsheet = new Spreadsheet();
         $sheet = $spreadsheet->getActiveSheet();
      
         // add style to the header
             $styleArray = array(
             'font' => array(
                 'bold' => true,
             ),
             'alignment' => array(
                 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                 'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
             ),
             'borders' => array(
                 'bottom' => array(
                     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                     'color' => array('rgb' => '333333'),
                 ),
             ),
             'fill' => array(
                 'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                 'rotation'   => 90,
                 'startcolor' => array('rgb' => '0d0d0d'),
                 'endColor'   => array('rgb' => 'f2f2f2'),
             ),
             );
 
     $spreadsheet->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styleArray);
     // auto fit column to content
     foreach(range('A', 'Y') as $columnID) {
       $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
     }
    $sheet->setCellValue('A1', 'Código');
    $sheet->setCellValue('B1', 'Nombre');
    $sheet->setCellValue('C1', 'Descripción');
    $sheet->setCellValue('D1', 'ID Categoria');
    $sheet->setCellValue('E1', 'ID SubCategoria');
    $sheet->setCellValue('F1', 'Unidades en Bulto');
    $sheet->setCellValue('G1', 'Stock');
    $sheet->setCellValue('H1', 'Precio Individual');
    $sheet->setCellValue('I1', 'Precio por Bulto');
    $sheet->setCellValue('J1', '¿Es Destacado?');
    $sheet->setCellValue('K1', '¿Es Oferta?');
    $sheet->setCellValue('L1', 'Precio Individual Oferta');
    $sheet->setCellValue('M1', 'Precio Por Bulto Oferta');
    $sheet->setCellValue('N1', 'Alto');
    $sheet->setCellValue('O1', 'Ancho');
    $sheet->setCellValue('P1', 'Profundo');
    $sheet->setCellValue('Q1', 'Peso');
    $sheet->setCellValue('R1', 'Imagen');
    $sheet->setCellValue('S1', 'IVA');
    $sheet->setCellValue('T1', 'ID Descuento Diferencial');
    $sheet->setCellValue('U1', 'Precio de Lista 1');
    $sheet->setCellValue('V1', 'Precio de Lista 2');
    $sheet->setCellValue('W1', 'Precio de Lista 3');
    $sheet->setCellValue('X1', 'Precio de Lista 4');
    $sheet->setCellValue('Y1', 'Precio de Lista 5');

   
  
  $products = $this->producto->getExport();
  

  $x = 2;
      foreach ($products as $key => $product)
      {            
          $prices[] = explode(',', $product->prices);

          $sheet->setCellValue('A'.$x, $product->code);
          $sheet->setCellValue('B'.$x, $product->name);
          $sheet->setCellValue('C'.$x, $product->description);
          $sheet->setCellValue('D'.$x, $product->id_category);
          $sheet->setCellValue('E'.$x, $product->id_subcategory);
          $sheet->setCellValue('F'.$x, $product->unit_bulto);
          $sheet->setCellValue('G'.$x, $product->stock);
          $sheet->setCellValue('H'.$x, $product->price_individual);
          $sheet->setCellValue('I'.$x, $product->price_package); 
          $sheet->setCellValue('J'.$x, $product->featured);
          $sheet->setCellValue('K'.$x, $product->offer);
          $sheet->setCellValue('L'.$x, $product->offer_price);
          $sheet->setCellValue('M'.$x, $product->offer_price_bulto);
          $sheet->setCellValue('N'.$x, $product->height);
          $sheet->setCellValue('O'.$x, $product->width);
          $sheet->setCellValue('P'.$x, $product->depth);
          $sheet->setCellValue('Q'.$x, $product->weight);
          $sheet->setCellValue('R'.$x, $product->image1);      
          $sheet->setCellValue('S'.$x, $product->id_iva);
          $sheet->setCellValue('T'.$x, $product->id_differential_discount);    
          $sheet->setCellValue('U'.$x, $prices[$key][0]);
          $sheet->setCellValue('V'.$x, $prices[$key][1]);
          $sheet->setCellValue('W'.$x, $prices[$key][2]);
          $sheet->setCellValue('X'.$x, $prices[$key][3]);
          $sheet->setCellValue('Y'.$x, $prices[$key][4]);
    
          $x++;
      }

      $filename = 'productos_'.date('d-m-Y_H:m:s').'.xlsx';
      $writer = new Xlsx($spreadsheet);

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename='.$filename); 
      header('Cache-Control: max-age=0');
      
      $writer->save('php://output'); // download file 



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
