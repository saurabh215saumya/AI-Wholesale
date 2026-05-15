<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('fn_resize')) {
    function fn_resize($image_resource_id, $width, $height, $target_width, $target_height) {
        $target_layer = imagecreatetruecolor($target_width, $target_height);
        imagecopyresampled($target_layer, $image_resource_id, 0, 0, 0, 0, $target_width, $target_height, $width, $height);
        return $target_layer;
    }
}

if (!function_exists('upload_image')) {
    function upload_image($file_key, $upload_dir, $resize_w = 0, $resize_h = 0) {
        $image = $_FILES[$file_key];
        if (empty($image['name']) || $image['error'] > 0) return '';
        $imgName    = pathinfo($image['name']);
        $ext        = strtolower($imgName['extension']);
        $newImgName = substr(preg_replace('/[^a-zA-Z0-9\._]/', '_', $image['name']), 0, 50) . time() . '.' . $ext;
        $uploadPath = $upload_dir . '/' . $newImgName;
        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            if ($resize_w > 0 && $resize_h > 0) {
                $props = getimagesize($uploadPath);
                $type  = $props[2];
                if ($type == IMAGETYPE_JPEG) {
                    $res = imagecreatefromjpeg($uploadPath);
                    $res = fn_resize($res, $props[0], $props[1], $resize_w, $resize_h);
                    imagejpeg($res, $uploadPath);
                } elseif ($type == IMAGETYPE_PNG) {
                    $res = imagecreatefrompng($uploadPath);
                    $res = fn_resize($res, $props[0], $props[1], $resize_w, $resize_h);
                    imagepng($res, $uploadPath);
                } elseif ($type == IMAGETYPE_GIF) {
                    $res = imagecreatefromgif($uploadPath);
                    $res = fn_resize($res, $props[0], $props[1], $resize_w, $resize_h);
                    imagegif($res, $uploadPath);
                }
            }
            return $newImgName;
        }
        return '';
    }
}

if (!function_exists('delete_file')) {
    function delete_file($path) {
        if (file_exists($path)) @unlink($path);
    }
}

if (!function_exists('getAllCategory')) {
    function getAllCategory() {
        $CI =& get_instance();
        $query = $CI->db->where('is_deleted', '0')->where('status', '1')->order_by('category_name', 'ASC')->get('tbl_category');
        return $query->num_rows() > 0 ? $query->result() : array();
    }
}

if (!function_exists('getAllSubCategories')) {
    function getAllSubCategories() {
        $CI =& get_instance();
        $query = $CI->db->where('is_deleted', '0')->where('status', '1')->order_by('sub_category_name', 'ASC')->get('tbl_sub_category');
        return $query->num_rows() > 0 ? $query->result() : array();
    }
}

if (!function_exists('getAllSubCategory')) {
    function getAllSubCategory($category_id) {
        $CI =& get_instance();
        $query = $CI->db->where('category_id', $category_id)->where('is_deleted', '0')->where('status', '1')->order_by('sub_category_name', 'ASC')->get('tbl_sub_category');
        return $query->num_rows() > 0 ? $query->result() : array();
    }
}

if (!function_exists('getCategoryName')) {
    function getCategoryName($id) {
        $CI =& get_instance();
        $row = $CI->db->select('category_name')->where('id', $id)->get('tbl_category')->row();
        return $row ? $row->category_name : '';
    }
}

if (!function_exists('getSubCategoryName')) {
    function getSubCategoryName($id) {
        $CI =& get_instance();
        $row = $CI->db->select('sub_category_name')->where('id', $id)->get('tbl_sub_category')->row();
        return $row ? $row->sub_category_name : '';
    }
}

if (!function_exists('getCategoryIdByCatSlug')) {
    function getCategoryIdByCatSlug($slug) {
        $CI =& get_instance();
        $row = $CI->db->select('id')->where('category_slug', $slug)->get('tbl_category')->row();
        return $row ? $row->id : 0;
    }
}

if (!function_exists('getSubCategoryIdBySubCatSlug')) {
    function getSubCategoryIdBySubCatSlug($slug) {
        $CI =& get_instance();
        $row = $CI->db->select('id')->where('sub_category_slug', $slug)->get('tbl_sub_category')->row();
        return $row ? $row->id : 0;
    }
}

if (!function_exists('getSubCategoryIdByName')) {
    function getSubCategoryIdByName($name) {
        $CI =& get_instance();
        $row = $CI->db->select('id, category_id')
                      ->where('LOWER(sub_category_name)', strtolower(trim($name)))
                      ->get('tbl_sub_category')->row();
        return $row ? $row : null;
    }
}

if (!function_exists('getSubCatIdByProductId')) {
    function getSubCatIdByProductId($id) {
        $CI =& get_instance();
        $row = $CI->db->select('category_id')->where('id', $id)->get('tbl_products')->row();
        return $row ? $row->category_id : 0;
    }
}

if (!function_exists('getUserBillingDetails')) {
    function getUserBillingDetails($user_id) {
        $CI =& get_instance();
        $query = $CI->db->where('user_id', $user_id)->get('tbl_user_billing');
        return $query->num_rows() > 0 ? $query->result_array() : array();
    }
}

if (!function_exists('checkUserProductInCart')) {
    function checkUserProductInCart($product_id, $user_id) {
        $CI =& get_instance();
        $query = $CI->db->where('product_id', $product_id)->where('user_id', $user_id)->get('tbl_cart');
        return $query->num_rows() > 0 ? $query->row_array() : array();
    }
}

if (!function_exists('checkUserProductInWishlist')) {
    function checkUserProductInWishlist($product_id, $user_id) {
        $CI =& get_instance();
        $query = $CI->db->where('product_id', $product_id)->where('user_id', $user_id)->get('tbl_wishlist_product');
        return $query->num_rows() > 0 ? $query->row_array() : array();
    }
}

if (!function_exists('getProductImage')) {
    function getProductImage($image) {
        return (!empty($image) && file_exists(UPLOAD_PRODUCT_PATH.$image))
            ? SHOW_PRODUCT_PATH.$image
            : UPLOAD_PRODUCT_NO_IMAGE.'no_image.jpg';
    }
}

if (!function_exists('generateCode')) {
    function generateCode($length = 10) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle(str_repeat($chars, ceil($length / strlen($chars)))), 0, $length);
    }
}

if (!function_exists('getUserCartProduct')) {
    function getUserCartProduct($user_id = '') {
        $CI =& get_instance();
        if (!$user_id) return array();
        $query = $CI->db->select('tc.id')->from('tbl_cart AS tc')->where('tc.user_id', $user_id)->get();
        return $query->num_rows() > 0 ? $query->result() : array();
    }
}

if (!function_exists('getSeoPageMetaData')) {
    function getSeoPageMetaData($pageSlug = '') {
        return array();
    }
}

if (!function_exists('getCategoryNameBySlug')) {
    function getCategoryNameBySlug($slug) {
        $CI =& get_instance();
        $row = $CI->db->select('category_name')->where('category_slug', $slug)->get('tbl_category')->row();
        return $row ? $row->category_name : '';
    }
}

if (!function_exists('getSubCategoryNameBySlug')) {
    function getSubCategoryNameBySlug($slug) {
        $CI =& get_instance();
        $row = $CI->db->select('sub_category_name')->where('sub_category_slug', $slug)->get('tbl_sub_category')->row();
        return $row ? $row->sub_category_name : '';
    }
}

if (!function_exists('sendMailAdmin')) {
    function sendMailAdmin($to, $subject, $message, $from_mail = '', $from_name = '') {
        if (ISSMTP == 1) {
            $CI =& get_instance();
            $CI->load->library('email');
            $config = array(
                'protocol'  => SMTP_PROTOCOL,
                'smtp_host' => SMTP_HOST,
                'smtp_port' => SMTP_PORT,
                'smtp_user' => SMTP_USER,
                'smtp_pass' => SMTP_PASS,
                'mailtype'  => MAIL_TYPE,
                'newline'   => "\r\n",
            );
            $CI->email->initialize($config);
            $CI->email->from(SMTP_USER, SITE_NAME);
            $CI->email->to($to);
            $CI->email->subject($subject);
            $CI->email->message($message);
            return $CI->email->send();
        }
        return false;
    }
}
