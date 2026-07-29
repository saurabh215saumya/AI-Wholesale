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
        // Detect real image type from tmp file content, not extension
        $props = @getimagesize($image['tmp_name']);
        if (!$props) return ''; // not a real image
        $detectedType = $props[2];
        // WebP: convert to JPEG (GD WebP may not be compiled in)
        if ($detectedType == IMAGETYPE_WEBP) {
            $rawBytes = file_get_contents($image['tmp_name']);
            $res = @imagecreatefromstring($rawBytes);
            if (!$res) return ''; // cannot decode webp
            $baseName   = substr(preg_replace('/[^a-zA-Z0-9_]/', '_', pathinfo($image['name'], PATHINFO_FILENAME)), 0, 50);
            $newImgName = $baseName . time() . '.jpg';
            $uploadPath = $upload_dir . '/' . $newImgName;
            if ($resize_w > 0 && $resize_h > 0) {
                $res = fn_resize($res, $props[0], $props[1], $resize_w, $resize_h);
            }
            imagejpeg($res, $uploadPath, 90);
            imagedestroy($res);
            return file_exists($uploadPath) ? $newImgName : '';
        }
        $typeMap = array(
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG  => 'png',
            IMAGETYPE_GIF  => 'gif',
        );
        if (!isset($typeMap[$detectedType])) return '';
        $ext        = $typeMap[$detectedType];
        $baseName   = substr(preg_replace('/[^a-zA-Z0-9_]/', '_', pathinfo($image['name'], PATHINFO_FILENAME)), 0, 50);
        $newImgName = $baseName . time() . '.' . $ext;
        $uploadPath = $upload_dir . '/' . $newImgName;
        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            if ($resize_w > 0 && $resize_h > 0) {
                if ($detectedType == IMAGETYPE_JPEG) {
                    $res = imagecreatefromjpeg($uploadPath);
                    $res = fn_resize($res, $props[0], $props[1], $resize_w, $resize_h);
                    imagejpeg($res, $uploadPath, 90);
                } elseif ($detectedType == IMAGETYPE_PNG) {
                    $res = imagecreatefrompng($uploadPath);
                    $res = fn_resize($res, $props[0], $props[1], $resize_w, $resize_h);
                    imagepng($res, $uploadPath);
                } elseif ($detectedType == IMAGETYPE_GIF) {
                    $res = imagecreatefromgif($uploadPath);
                    $res = fn_resize($res, $props[0], $props[1], $resize_w, $resize_h);
                    imagegif($res, $uploadPath);
                }
                if (isset($res)) imagedestroy($res);
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
        $query = $CI->db->where('is_deleted', '0')->where('status', '1')->where('parent_id', 0)->order_by('category_name', 'ASC')->get('tbl_category');
        return $query->num_rows() > 0 ? $query->result() : array();
    }
}

if (!function_exists('getAllRootCategories')) {
    function getAllRootCategories() {
        return getAllCategory();
    }
}

if (!function_exists('getCategoryChildren')) {
    function getCategoryChildren($parent_id) {
        $CI =& get_instance();
        $query = $CI->db->where('parent_id', $parent_id)->where('is_deleted', '0')->where('status', '1')->order_by('category_name', 'ASC')->get('tbl_category');
        return $query->num_rows() > 0 ? $query->result() : array();
    }
}

if (!function_exists('getAllSubCategory')) {
    function getAllSubCategory($category_id) {
        return getCategoryChildren($category_id);
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
        return getCategoryName($id);
    }
}

if (!function_exists('getCategoryBySlug')) {
    function getCategoryBySlug($slug) {
        $CI =& get_instance();
        $row = $CI->db->where('category_slug', $slug)->where('is_deleted', '0')->get('tbl_category')->row();
        return $row ? $row : null;
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
        return getCategoryIdByCatSlug($slug);
    }
}

if (!function_exists('getSubCategoryIdByName')) {
    function getSubCategoryIdByName($name) {
        $CI =& get_instance();
        $row = $CI->db->select('id, parent_id')
                      ->where('LOWER(category_name)', strtolower(trim($name)))
                      ->where('parent_id >', 0)
                      ->get('tbl_category')->row();
        return $row ? (object)array('id' => $row->id, 'category_id' => $row->parent_id) : null;
    }
}

if (!function_exists('getSubCatIdByProductId')) {
    function getSubCatIdByProductId($id) {
        $CI =& get_instance();
        $row = $CI->db->select('sub_cat_id')->where('id', $id)->get('tbl_products')->row();
        return $row ? $row->sub_cat_id : 0;
    }
}

if (!function_exists('getAllDescendantIds')) {
    function getAllDescendantIds($cat_id) {
        $CI =& get_instance();
        $ids = array();
        $stack = array($cat_id);
        while (!empty($stack)) {
            $current = array_pop($stack);
            $rows = $CI->db->select('id')->where('parent_id', $current)->where('is_deleted', '0')->get('tbl_category')->result();
            foreach ($rows as $r) {
                $ids[] = (int)$r->id;
                $stack[] = (int)$r->id;
            }
        }
        return $ids;
    }
}

if (!function_exists('getCategoryBreadcrumb')) {
    function getCategoryBreadcrumb($id) {
        $CI =& get_instance();
        $breadcrumb = array();
        $current = $CI->db->where('id', $id)->get('tbl_category')->row();
        while ($current) {
            array_unshift($breadcrumb, $current);
            if ($current->parent_id == 0) break;
            $current = $CI->db->where('id', $current->parent_id)->get('tbl_category')->row();
        }
        return $breadcrumb;
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
        if ($user_id) {
            $query = $CI->db->select('tc.id')->from('tbl_cart AS tc')->where('tc.user_id', $user_id)->get();
            return $query->num_rows() > 0 ? $query->result() : array();
        }
        // Guest: count by cookie
        $guest_id = isset($_COOKIE['guest_cart_id']) ? $_COOKIE['guest_cart_id'] : '';
        if (!$guest_id) return array();
        $query = $CI->db->select('tc.id')->from('tbl_cart AS tc')->where('tc.guest_id', $guest_id)->where('tc.user_id', 0)->get();
        return $query->num_rows() > 0 ? $query->result() : array();
    }
}

if (!function_exists('getSeoPageMetaData')) {
    function getSeoPageMetaData($pageSlug = '') {
        return array();
    }
}

if (!function_exists('getKeywordLocations')) {
    function getKeywordLocations() {
        $CI =& get_instance();
        $rows = $CI->db->select('location')->where('status', 1)->where('is_deleted', 0)->where('location !=', '')->group_by('location')->order_by('location', 'ASC')->get('tbl_keywords')->result_array();
        return array_column($rows, 'location');
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
        return getCategoryNameBySlug($slug);
    }
}

if (!function_exists('sendMail')) {
    function sendMail($to, $subject, $message) {
        $CI =& get_instance();
        $CI->load->library('email');
        $CI->email->clear(true);
        $CI->email->initialize(array(
            'protocol'    => 'smtp',
            'smtp_host'   => SMTP_HOST,
            'smtp_port'   => SMTP_PORT,
            'smtp_user'   => SMTP_USER,
            'smtp_pass'   => SMTP_PASS,
            'smtp_crypto' => 'tls',
            'mailtype'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n",
            'crlf'        => "\r\n",
            'wordwrap'    => FALSE,
        ));
        $CI->email->from(SMTP_USER, SITE_NAME);
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);
        return $CI->email->send();
    }
}

if (!function_exists('emailTemplate')) {
    function emailTemplate($title, $bodyHtml) {
        return '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>' . $title . '</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f4;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;padding:30px 0;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
      <!-- Header -->
      <tr>
        <td style="background:#1a1a2e;padding:24px 32px;text-align:center;">
          <span style="color:#ffffff;font-size:22px;font-weight:bold;letter-spacing:1px;">' . SITE_NAME . '</span>
        </td>
      </tr>
      <!-- Body -->
      <tr>
        <td style="padding:32px 36px;color:#333333;font-size:15px;line-height:1.7;">
          ' . $bodyHtml . '
        </td>
      </tr>
      <!-- Footer -->
      <tr>
        <td style="background:#f9f9f9;border-top:1px solid #eeeeee;padding:18px 36px;text-align:center;font-size:12px;color:#999999;">
          &copy; ' . date('Y') . ' ' . SITE_NAME . '. All rights reserved.<br>
          <a href="' . BASE_URL . '" style="color:#c8a951;text-decoration:none;">' . BASE_URL . '</a>
        </td>
      </tr>
    </table>
  </td></tr>
</table>
</body>
</html>';
    }
}

if (!function_exists('sendMailAdmin')) {
    function sendMailAdmin($to, $subject, $message, $from_mail = '', $from_name = '') {
        if (ISSMTP == 1) {
            return sendMail($to, $subject, $message);
        }
        return false;
    }
}
