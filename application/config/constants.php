<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('ACTIVE', 1);
define('DELETE', 0);
define('APP_NAME', 'LIMPIEZA');
define('FACTURA_A', 1);
define('FACTURA_B', 6);
define('IVA_10', 4);
define('IVA_21', 5);
define('PAGO_EFECTIVO', 1);
define('MERCADOPAGO', 2);
define('RAPIPAGO', 8);
define('PAGOFACIL', 9);
define('TODO_PAGO', 3);
define('ENVIO_DOMICILIO', 1);
define('RECOJO_SUCURSAL', 2);
define('ZONA_ESPECIFICA', 3);
define('PER_PAGE', 15);
define('PEDIDO_NUEVO', 1);
define('PEDIDO_PAGADO', 2);
define('PEDIDO_CANCELADO', 5);
define('PRODUCTO_SIN_VARIANTE', 0);
define('PRODUCTO_VARIANTE', 1);
define('FACEBOOK', 1);
define('INSTAGRAM', 2);
define('CUSTOMER_ACCOUNT_CONFIRMED', 1);
define('CUSTOMER_ACCOUNT_PENDIENT', 0);
define('CUSTOMER_GUEST', 1);
define('CUSTOMER_REGISTERED', 2);
define('PRODUCT_ADD_TYPE_UNITY', 1);
define('PRODUCT_ADD_TYPE_PACK', 2);
define('SALE_ECOMMERCE', 1);
define('SALE_DASHBOARD', 2);

/* TABLAS */
define('TABLE_INVOICE', 'order_invoices');
define('TABLE_STOCK', 'products_stock');
define('TABLE_PRODUCTS', 'products');
define('TABLE_CATEGORIES', 'categories');
define('TABLE_SUBCATEGORIES', 'subcategories');
define('TABLE_SECOND_SUBCATEGORIES', 'second_subcategories');
define('TABLE_CATEGORIES_PRODUCTS', 'products_categories');
define('TABLE_SPORTS', 'sports');
define('TABLE_PRODUCT_IMAGES', 'product_images');
define('TABLE_BRANDS', 'brands');
define('TABLE_RELATED_PRODUCTS', 'related_products');
define('TABLE_PRODUCTS_SIZES', 'products_sizes');
define('TABLE_SECTIONS', 'sections');
define('TABLE_IMAGE_GALLERY', 'image_gallery');
define('TABLE_IMAGE_BRANDS_SALIDER', 'slider_marcas');
define('TABLE_BRANCH_OFFICES', 'branch_offices');
define('TABLE_WIDGETS', 'widgets');
define('TABLE_ORDERS', 'orders');
define('TABLE_ORDERS_STATUSES', 'orders_statuses');
define('TABLE_PRODUCTS_SUBCATEGORIES', 'products_subcategories');
define('TABLE_PRICE_PRODUCTS', 'price_products');
define('TABLE_PRODUCTS_SECOND_SUBCATEGORIES', 'products_second_subcategories');
define('TABLE_PRODUCTOS_SPORTS', 'products_sports');
define('TABLE_COLORS', 'colors');
define('TABLE_SIZES', 'sizes');
define('TABLE_HEELS', 'heels');
define('TABLE_PRODUCTS_COLOR', 'products_colors');
define('TABLE_SHIPPING', 'shippings');
define('TABLE_DISCOUNTS', 'discount_code');
define('TABLE_VARIANT_PRODUCTS', 'variant_products');
define('TABLE_PAYMENT_METHODS', 'payment_methods');
define('TABLE_BULK_DISCOUNTS', 'differential_discounts');
define('TABLE_BULK_DISCOUNTS_DETAILS', 'differential_discounts_details');


define('MESSAGE_REGISTER_SUCCESS', 'Gracias por su registro, hemos enviado un email para confirmar su cuenta.');
define('MESSAGE_CONFIRMATION_SUCCESS', 'Se ha confirmado su cuenta exitosamente, ingrese su usuario y contraseña para continuar.');
define('MESSAGE_CONFIRMATION_FAIL', 'El código de confirmación no existe o ha expirado, ingrese usuario y contraseña para continuar.');
define('MESSAGE_LOGIN_FAIL', 'El usuario y/o contraseña ingresados no existen o son incorrectos, vuelva a intentarlo.');
define('MESSAGE_RECOVER_FAIL', 'El email ingresado no esta registrado');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
