<?php
require APPPATH . 'third_party/todopago/TodoPago/lib/Sdk.php';
require APPPATH . 'third_party/todopago/TodoPago/lib/Data/User.php';

/*$credenciales = new \TodoPago\Data\User("juanjaruf@gmail.com", "contraseña");
var_dump($credenciales); die;*/

class Todo_pago extends \TodoPago\Sdk
{

    protected $cliente = array();
    protected $importe = 0;
    protected $order = 0;
    protected $url_ok = '';
    protected $url_error = '';
    protected $http_header = array();
    protected $mode = 'test';
    protected $autorization = '';
    protected $security = '';
    protected $merchant = '';


    protected $items = array(); // Array con los productos estructora array(array('id','name','qty','price'))

    protected $CSITPRODUCTDESCRIPTION = '';
    protected $CSITPRODUCTNAME = '';
    protected $CSITPRODUCTSKU = '';
    protected $CSITTOTALAMOUNT = '';
    protected $CSITQUANTITY = '';
    protected $CSITUNITPRICE = '';

    public function __construct(array $config = array())
    {

        if (count($config) > 0) {
            $this->initialize($config);
        }

        $this->http_header = array('Authorization' => $this->autorization, 'user_agent' => 'PHPSoapClient');
        parent::__construct($this->http_header, $this->mode);
    }

    /**
     * Initialize
     *  array(
     * 'merchant','Authorization'
     * )
     *
     * @param array $config
     * @return $this
     */
    public function initialize($config = array())
    {
        foreach ($config as $key => $val) {
            $this->$key = $val;
        }

        return $this;
    }

    /*
     *
     * */
    public function requestAuth()
    {

        $optionsSAR_comercio = array(
            'Security'       => $this->security,
            'EncodingMethod' => 'XML',
            'Merchant'       => $this->merchant,
            'URL_OK'         => $this->url_ok,
            'URL_ERROR'      => $this->url_error
        );

        $this->items_products(); // Prepara los productos para poder armar la operacion de compra
        $optionsSAR_operacion = array(
            'MERCHANT'     => $this->merchant, //dato fijo (número identificador del comercio)
            'OPERATIONID'  => $this->order, //número único que identifica la operación, generado por el comercio.
            'CURRENCYCODE' => 32, //por el momento es el único tipo de moneda aceptada
            'AMOUNT'       => $this->fix_decimal($this->importe),
            'EMAILCLIENTE' => $this->cliente['email'],

            //Datos ejemplos CS
            'CSBTCITY'     => $this->cliente['localidad'],
            'CSSTCITY'     => $this->cliente['localidad'],

            'CSBTCOUNTRY' => "AR",
            'CSSTCOUNTRY' => "AR",

            'CSBTEMAIL' => $this->cliente['email'],
            'CSSTEMAIL' => $this->cliente['email'],

            'CSBTFIRSTNAME' => $this->cliente['nombre'],
            'CSSTFIRSTNAME' => $this->cliente['nombre'],

            'CSBTLASTNAME' => $this->cliente['apellido'],
            'CSSTLASTNAME' => $this->cliente['apellido'],

            'CSBTPHONENUMBER' => $this->cliente['telefono'],
            'CSSTPHONENUMBER' => $this->cliente['telefono'],

            'CSBTPOSTALCODE' => $this->cliente['cpostal'],
            'CSSTPOSTALCODE' => $this->cliente['cpostal'],

            'CSBTSTATE' => "B",
            'CSSTSTATE' => "B",

            'CSBTSTREET1' => $this->cliente['domicilio'],
            'CSSTSTREET1' => $this->cliente['domicilio'],

            'CSBTCUSTOMERID'         => $this->cliente['nombre_id'],
            'CSBTIPADDRESS'          => $this->cliente['cliente_ip'],
            'CSPTCURRENCY'           => "ARS",
            'CSPTGRANDTOTALAMOUNT'   => $this->fix_decimal($this->importe),
            //'CSPTGRANDTOTALAMOUNT'   => $this->importe,
            /*'CSMDD7'=> "",
            'CSMDD8'=> "Y",
            'CSMDD9'=> "",
            'CSMDD10'=> "",
            'CSMDD11'=> "",
            'CSMDD12'=> "",
            'CSMDD13'=> "",
            'CSMDD14'=> "",
            'CSMDD15'=> "",
            'CSMDD16'=> "",*/
            
            'CSITPRODUCTCODE'        => "default",
            'CSITPRODUCTDESCRIPTION' => substr($this->CSITPRODUCTDESCRIPTION, 0, 255),
            'CSITPRODUCTNAME'        => substr($this->CSITPRODUCTNAME, 0, 255),
            'CSITPRODUCTSKU'         => $this->CSITPRODUCTSKU,
            'CSITTOTALAMOUNT'        => $this->fix_decimal($this->CSITTOTALAMOUNT),
            'CSITQUANTITY'           => $this->CSITQUANTITY,
            'CSITUNITPRICE'          => $this->fix_decimal($this->CSITUNITPRICE)
        );


        //print_r($this->fix_decimal($this->CSITTOTALAMOUNT)); die;

        $request = $this->sendAuthorizeRequest($optionsSAR_comercio, $optionsSAR_operacion);
        if($request['StatusCode'] > -1){ // si status code es mayor a -1  mirar el mensaje de error
            show_error($request['StatusMessage'].' Codigo de error :'.$request['StatusCode']);
        }

        return $request;

    }

    private function fix_decimal($valor = 0)
    {
        return number_format($valor, 2,'.','');
    }

    private function items_products()
    {

        $cantidad_total = 0;
        $subtotal = 0;
        $total = 0;

        foreach ($this->items as $item) {
            
            //$this->CSITPRODUCTDESCRIPTION .= $item['name'] . '#';
            //$this->CSITPRODUCTNAME        .= $item['name'] . '#';
            //$this->CSITPRODUCTSKU         .= $item['id'] . '#';
            //$this->CSITQUANTITY           .= $item['qty'] . '#';
            //$this->CSITUNITPRICE          .= $this->fix_decimal($item['price']) . '#';
            //$this->CSITTOTALAMOUNT        .= $this->fix_decimal($item['qty'] * $item['price']) . '#';
            
            $this->CSITPRODUCTDESCRIPTION .= $item['name'] . ' ';
            $this->CSITPRODUCTNAME        .= $item['name'] . ' ';
            $this->CSITPRODUCTSKU         .= 'PRODUCTO'.$item['id'] . '';
            
            $cantidad_total = $cantidad_total + $item['qty'];
            $subtotal = $subtotal + $item['price'];
            $total = $total + ($item['qty'] * $item['price']);

        }

        $this->CSITPRODUCTDESCRIPTION = rtrim($this->CSITPRODUCTDESCRIPTION, "#");
        $this->CSITPRODUCTNAME        = rtrim($this->CSITPRODUCTNAME, "#");
        $this->CSITPRODUCTSKU         = rtrim($this->CSITPRODUCTSKU, "#");
        
        $this->CSITQUANTITY           = $cantidad_total;
        $this->CSITUNITPRICE          = $subtotal;
        $this->CSITTOTALAMOUNT        = $total;

        //$this->CSITUNITPRICE          = rtrim($this->CSITUNITPRICE, "#");
        //$this->CSITTOTALAMOUNT        = rtrim($this->CSITTOTALAMOUNT, "#");
        //$this->CSITQUANTITY           = rtrim($this->CSITQUANTITY, "#");

        return $this;

    }
}