<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin'] = 'admin/index';
$route['admin/(:any)'] = 'admin/$1';

$route['admin-orders'] = 'admin_orders/index';
$route['admin-orders/edit/(:num)'] = 'admin_orders/edit/$1';
$route['admin-orders/update/(:num)'] = 'admin_orders/update/$1';

$route['sign-up'] = 'wholesale/apply';
$route['sign-in'] = 'appuser/login';
$route['sign-out'] = 'appuser/logout';
$route['my-account'] = 'appuser/my_account';
$route['update-account'] = 'appuser/update_account';
$route['my-orders'] = 'appuser/my_orders';
$route['billing-address'] = 'appuser/billing_address';
$route['delete-billing/(:num)'] = 'appuser/delete_billing/$1';
$route['forgot-password'] = 'appuser/forgot_password';
$route['reset-password/(:any)'] = 'appuser/reset_password/$1';
$route['ajax-forgot-password'] = 'appuser/ajax_forgot_password';
$route['ajax-reset-password'] = 'appuser/ajax_reset_password';

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
$route['place-offline-order'] = 'product/place_offline_order';
$route['order-summary/(:any)'] = 'order/order_summary/$1';
$route['offline-order-confirmation/(:any)'] = 'order/offline_confirmation/$1';
$route['order/pay/(:num)'] = 'order/pay/$1';
$route['order/confirm_offline_payment'] = 'order/confirm_offline_payment';
$route['order/stripe_order_payment'] = 'order/stripe_order_payment';

$route['wholesale'] = 'wholesale/index';
$route['wholesale/apply'] = 'wholesale/apply';

$route['chatbot/ask'] = 'chatbot/ask';
$route['chatbot/submit'] = 'chatbot/submit';

$route['ajax-login'] = 'appuser/ajax_login';
$route['ajax-signup'] = 'appuser/ajax_signup';
$route['ajax-merge-guest-cart'] = 'product/ajax_merge_guest_cart';
$route['ajax-forgot-password'] = 'appuser/ajax_forgot_password';
$route['ajax-reset-password'] = 'appuser/ajax_reset_password';

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

$route['promo-banner'] = 'promo_banner/index';
$route['promo-banner/add'] = 'promo_banner/add';
$route['promo-banner/save'] = 'promo_banner/save';
$route['promo-banner/edit/(:num)'] = 'promo_banner/edit/$1';
$route['promo-banner/update'] = 'promo_banner/update';
$route['promo-banner/changestatus'] = 'promo_banner/changestatus';
$route['promo-banner/delete/(:num)'] = 'promo_banner/delete/$1';

$route['banner'] = 'banner/index';
$route['banner/(:any)'] = 'banner/$1';

$route['category'] = 'category/index';
$route['category/(:any)'] = 'category/$1';

$route['product'] = 'product/index';
$route['product/(:any)'] = 'product/$1';

$route['appuser'] = 'appuser/index';
$route['appuser/(:any)'] = 'appuser/$1';

$route['staticpage'] = 'staticpage/index';
$route['staticpage/(:any)'] = 'staticpage/$1';

$route['testimonial'] = 'testimonial/index';
$route['testimonial/(:any)'] = 'testimonial/$1';

$route['order'] = 'order/index';
$route['order/(:any)'] = 'order/$1';

$route['user'] = 'user/index';
$route['user/(:any)'] = 'user/$1';

$route['(:any)'] = 'keyword/keyword_page/$1';
