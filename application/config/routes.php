<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/*

| -------------------------------------------------------------------------

| URI ROUTING

| -------------------------------------------------------------------------

| This file lets you re-map URI requests to specific controller functions.

|

| Typically there is a one-to-one relationship between a URL string

| and its corresponding controller class/method. The segments in a

| URL normally follow this pattern:

|

|	example.com/class/method/id/

|

| In some instances, however, you may want to remap this relationship

| so that a different class/function is called than the one

| corresponding to the URL.

|

| Please see the user guide for complete details:

|

|	http://codeigniter.com/user_guide/general/routing.html

|

| -------------------------------------------------------------------------

| RESERVED ROUTES

| -------------------------------------------------------------------------

|

| There are three reserved routes:

|

|	$route['default_controller'] = 'welcome';

|

| This route indicates which controller class should be loaded if the

| URI contains no data. In the above example, the "welcome" class

| would be loaded.

|

|	$route['404_override'] = 'errors/page_missing';

|

| This route will tell the Router which controller/method to use if those

| provided in the URL cannot be matched to a valid route.

|

|	$route['translate_uri_dashes'] = FALSE;

|

| This is not exactly a route, but allows you to automatically route

| controller and method names that contain dashes. '-' isn't a valid

| class or method name character, so it requires translation.

| When you set this option to TRUE, it will replace ALL dashes in the

| controller and method URI segments.

|

| Examples:	my-controller/index	-> my_controller/index

|		my-controller/my-method	-> my_controller/my_method

*/

$route['default_controller'] = 'sudaca_controller';
$route['404_override'] = 'sudaca_errores/_404';
$route['translate_uri_dashes'] = FALSE;
$route['web_ctrl'] = "backend/auth/login";
$route['index'] = "frontend/web/index";
$route['productos'] = "frontend/web/products";
$route['productos/(:num)'] = "frontend/web/products/$1";
$route['productos/(:num)/(:num)'] = "frontend/web/products/$1/$2";
$route['productos/(:num)/(:num)/(:num)'] = "frontend/web/products/$1/$2/$3";
$route['producto/(:num)'] = "frontend/web/product/$1";
$route['ofertas'] = "frontend/web/offers";
$route['ofertas/(:num)'] = "frontend/web/offers/$1";
$route['ofertas/(:num)/(:num)'] = "frontend/web/offers/$1/$2";
$route['ofertas/(:num)/(:num)/(:num)'] = "frontend/web/offers/$1/$2/$3";
$route['contacto'] = "frontend/web/contact";
$route['empresa'] = "frontend/web/enterprise";
$route['como_comprar'] = "frontend/web/how_to_buy";
$route['ofertas'] = "frontend/web/offers";
$route['ofertas/(:num)'] = "frontend/web/offers/$1";
$route['ofertas/(:num)/(:num)'] = "frontend/web/offers/$1/$2";
$route['ofertas/(:num)/(:num)/(:num)'] = "frontend/web/offers/$1/$2/$3";
$route['carrito'] = "frontend/ecommerce/cart";
$route['process_shopping_cart'] = "frontend/ecommerce/process_shopping_cart";
$route['procesar-compra/(:num)/(:num)/(:num)'] = "frontend/ecommerce/mercadopago_procesar/$1/$2/$3";
$route['validar-email'] = "frontend/ecommerce/validar_email";
$route['validar-dni'] = "frontend/ecommerce/validar_dni";
$route['login'] = "frontend/ecommerce/login";
$route['registro'] = "frontend/ecommerce/register";
$route['confirmacion-cuenta/(:any)'] = 'frontend/ecommerce/accountConfirmation/$1';
$route['recuperar-password'] = 'frontend/ecommerce/recoverPassword';
$route['terms'] = 'frontend/ecommerce/terms';
$route['logout'] = 'frontend/ecommerce/logout';
$route['change-password'] = 'frontend/ecommerce/changePassword';
$route['dashboard'] = "frontend/dashboard/profile";
$route['order'] = "frontend/dashboard/order";
