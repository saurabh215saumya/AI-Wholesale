<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    protected $table = 'tbl_products';

    public function allproducts() {
        return $this->db->select('tbl_products.*, tbl_category.category_name, tbl_sub_category.sub_category_name')
            ->from($this->table)
            ->join('tbl_category', 'tbl_category.id = tbl_products.category_id', 'left')
            ->join('tbl_sub_category', 'tbl_sub_category.id = tbl_products.sub_cat_id', 'left')
            ->where('tbl_products.is_deleted', '0')
            ->order_by('tbl_products.id', 'DESC')
            ->get()->result_array();
    }

    public function productDetails($id) {
        return $this->db->where('id', $id)->where('is_deleted', '0')->get($this->table)->row_array();
    }

    public function getProductBySlug($slug) {
        return $this->db->where('product_slug', $slug)->where('status', '1')->where('is_deleted', '0')->get($this->table)->row_array();
    }

    public function changeStatus($id, $val) {
        return $this->db->where('id', $id)->update($this->table, array('status' => $val));
    }

    public function deleteRecord($id) {
        return $this->db->where('id', $id)->update($this->table, array('is_deleted' => 1));
    }

    public function updateProductFlag($id, $type) {
        $details = $this->productDetails($id);
        if ($type == 'new') {
            $data = array('new_product' => $details['new_product'] == 1 ? 0 : 1);
        } else {
            $data = array('best_seller' => $details['best_seller'] == 1 ? 0 : 1);
        }
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function getAllProducts($limit = '', $offset = '', $search = '') {
        $this->db->where('is_deleted', '0')->where('status', '1');
        if ($search) $this->db->like('product_name', $search);
        $this->db->order_by('id', 'DESC');
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result_array();
    }

    public function countAllProducts($search = '') {
        $this->db->where('is_deleted', '0')->where('status', '1');
        if ($search) $this->db->like('product_name', $search);
        return $this->db->count_all_results($this->table);
    }

    public function getProductsByCategory($cat_id, $limit = '', $offset = '') {
        $this->db->where('category_id', $cat_id)->where('is_deleted', '0')->where('status', '1')->order_by('id', 'DESC');
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result_array();
    }

    public function countByCategory($cat_id) {
        return $this->db->where('category_id', $cat_id)->where('is_deleted', '0')->where('status', '1')->count_all_results($this->table);
    }

    public function getProductsBySubCategory($sub_cat_id, $limit = '', $offset = '') {
        $this->db->where('sub_cat_id', $sub_cat_id)->where('is_deleted', '0')->where('status', '1')->order_by('id', 'DESC');
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result_array();
    }

    public function countBySubCategory($sub_cat_id) {
        return $this->db->where('sub_cat_id', $sub_cat_id)->where('is_deleted', '0')->where('status', '1')->count_all_results($this->table);
    }

    public function getProductById($id) {
        return $this->db->where('id', $id)->where('status', '1')->where('is_deleted', '0')->get($this->table)->row_array();
    }

    public function getFeaturedProducts($limit = 8) {
        return $this->db->where('best_seller', '1')->where('is_deleted', '0')->where('status', '1')->limit($limit)->get($this->table)->result_array();
    }

    public function getNewProducts($limit = 8) {
        return $this->db->where('new_product', '1')->where('is_deleted', '0')->where('status', '1')->limit($limit)->get($this->table)->result_array();
    }

    public function getUserCartProduct($user_id) {
        return $this->db->select('tc.id as cartId, tc.user_id, tc.product_id, tc.quantity, tc.amount, tp.product_name, tp.product_slug, tp.price, tp.wholesale_price, tp.retailer_price, tp.image')
            ->from('tbl_cart AS tc')
            ->join('tbl_products AS tp', 'tp.id = tc.product_id')
            ->where('tc.user_id', $user_id)
            ->order_by('tc.id', 'DESC')
            ->get()->result_array();
    }

    public function getUserCartSubTotal($user_id) {
        $row = $this->db->select('SUM(amount) AS subTotal')->where('user_id', $user_id)->get('tbl_cart')->row_array();
        return $row ? $row['subTotal'] : 0;
    }

    public function checkCartProduct($product_id, $user_id) {
        return $this->db->where('product_id', $product_id)->where('user_id', $user_id)->get('tbl_cart')->row_array();
    }

    public function deleteCartProduct($id) {
        return $this->db->where('id', $id)->delete('tbl_cart');
    }

    public function deleteAllUserCart($user_id) {
        return $this->db->where('user_id', $user_id)->delete('tbl_cart');
    }

    public function checkWishlistProduct($product_id, $user_id) {
        return $this->db->where('product_id', $product_id)->where('user_id', $user_id)->count_all_results('tbl_wishlist_product');
    }

    public function getAllUserWishlist($user_id) {
        return $this->db->select('twp.id as wishId, twp.product_id, tp.product_name, tp.product_slug, tp.price, tp.wholesale_price, tp.retailer_price, tp.image')
            ->from('tbl_wishlist_product AS twp')
            ->join('tbl_products AS tp', 'tp.id = twp.product_id')
            ->where('twp.user_id', $user_id)
            ->order_by('twp.id', 'DESC')
            ->get()->result_array();
    }

    public function getVariantsByProduct($product_id) {
        return $this->db->where('product_id', $product_id)->where('status', 1)->order_by('sort_order', 'ASC')->get('tbl_product_variants')->result_array();
    }

    public function getAllVariantsByProduct($product_id) {
        return $this->db->where('product_id', $product_id)->order_by('sort_order', 'ASC')->get('tbl_product_variants')->result_array();
    }

    public function saveVariants($product_id, $variants) {
        $this->db->where('product_id', $product_id)->delete('tbl_product_variants');
        foreach ($variants as $v) {
            if (empty($v['label'])) continue;
            $this->db->insert('tbl_product_variants', array(
                'product_id' => $product_id,
                'label'      => $v['label'],
                'price'      => $v['price'],
                'sort_order' => $v['sort_order'],
                'status'     => 1,
            ));
        }
    }

    public function placeOrder($user_id, $payment_method, $billing_address_id) {
        $cartItems  = $this->getUserCartProduct($user_id);
        $totalAmt   = 0;
        $totalQty   = 0;
        foreach ($cartItems as $item) {
            $totalAmt += $item['amount'];
            $totalQty += $item['quantity'];
        }
        $txnNo = generateCode(10);
        $orderId = null;
        $this->db->insert('tbl_order', array(
            'user_id'            => $user_id,
            'transaction_no'     => $txnNo,
            'status'             => 0,
            'pay_amount'         => $totalAmt,
            'shipping_charge'    => 0,
            'total_amount'       => $totalAmt,
            'payment_method'     => $payment_method,
            'billing_address_id' => $billing_address_id,
            'comment'            => '',
            'addedOn'            => date('Y-m-d H:i:s'),
            'updatedOn'          => date('Y-m-d H:i:s'),
        ));
        $orderId = $this->db->insert_id();
        if ($orderId) {
            foreach ($cartItems as $item) {
                $this->db->insert('tbl_order_item', array(
                    'order_id'   => $orderId,
                    'product_id' => $item['product_id'],
                    'user_id'    => $user_id,
                    'quantity'   => $item['quantity'],
                    'amount'     => $item['amount'],
                    'addedOn'    => date('Y-m-d H:i:s'),
                ));
            }
        }
        return $orderId;
    }
}
