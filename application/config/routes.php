<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin'] = 'admin/index';
$route['admin/(:any)'] = 'admin/$1';

$route['sign-up'] = 'appuser/sign_up';
$route['sign-in'] = 'appuser/login';
$route['sign-out'] = 'appuser/logout';
$route['my-account'] = 'appuser/my_account';
$route['my-orders'] = 'appuser/my_orders';
$route['billing-address'] = 'appuser/billing_address';

$route['about-us'] = 'home/about_us';
$route['contact-us'] = 'home/contact_us';
$route['privacy-policy'] = 'home/privacy_policy';
$route['terms-conditions'] = 'home/terms_conditions';

$route['all-products'] = 'product/all_products';
$route['categories/(:any)'] = 'category/category_list/$1';
$route['subcategories/(:any)'] = 'category/subcategory_list/$1';
$route['product-details/(:any)'] = 'product/product_detail/$1';
$route['wish-list'] = 'product/wish_list';
$route['cart-list'] = 'product/cart_list';
$route['checkout'] = 'product/cart_checkout';
$route['order-summary/(:any)'] = 'order/order_summary/$1';

$route['ajax-login'] = 'appuser/ajax_login';
$route['ajax-signup'] = 'appuser/ajax_signup';

$route['page/(:any)'] = 'home/static_page/$1';
