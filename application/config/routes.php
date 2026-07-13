<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin'] = 'admin/index';
$route['admin/(:any)'] = 'admin/$1';

$route['sign-up'] = 'wholesale/apply';
$route['sign-in'] = 'appuser/login';
$route['sign-out'] = 'appuser/logout';
$route['my-account'] = 'appuser/my_account';
$route['update-account'] = 'appuser/update_account';
$route['my-orders'] = 'appuser/my_orders';
$route['billing-address'] = 'appuser/billing_address';
$route['delete-billing/(:num)'] = 'appuser/delete_billing/$1';

$route['about-us'] = 'home/about_us';
$route['contact-us'] = 'home/contact_us';
$route['privacy-policy'] = 'home/privacy_policy';
$route['terms-conditions'] = 'home/terms_conditions';

$route['all-products'] = 'product/all_products';
$route['categories/(:any)'] = 'category/category_list/$1';
$route['subcategories/(:any)'] = 'category/category_list/$1';
$route['product-details/(:any)'] = 'product/product_detail/$1';
$route['wish-list'] = 'product/wish_list';
$route['cart-list'] = 'product/cart_list';
$route['checkout'] = 'product/cart_checkout';
$route['stripe-payment'] = 'product/stripe_payment';
$route['order-summary/(:any)'] = 'order/order_summary/$1';

$route['wholesale'] = 'wholesale/index';
$route['wholesale/apply'] = 'wholesale/apply';

$route['ajax-login'] = 'appuser/ajax_login';
$route['ajax-signup'] = 'appuser/ajax_signup';
$route['ajax-merge-guest-cart'] = 'product/ajax_merge_guest_cart';

$route['page/(:any)'] = 'home/static_page/$1';

$route['location/(:any)'] = 'keyword/location/$1';

$route['keyword'] = 'keyword/index';
$route['keyword/add'] = 'keyword/add';
$route['keyword/save'] = 'keyword/save';
$route['keyword/edit/(:num)'] = 'keyword/edit/$1';
$route['keyword/update'] = 'keyword/update';
$route['keyword/delete/(:num)'] = 'keyword/delete/$1';
$route['keyword/upload_csv'] = 'keyword/upload_csv';
$route['keyword/import_csv'] = 'keyword/import_csv';
$route['keyword/sample_csv'] = 'keyword/sample_csv';

$route['(:any)'] = 'keyword/keyword_page/$1';
