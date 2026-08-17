<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    protected $table = 'tbl_products';

    public function allproducts() {
        return $this->db->select('tbl_products.*, tbl_category.category_name, sc.category_name as sub_category_name, gc.category_name as grand_sub_category_name')
            ->from($this->table)
            ->join('tbl_category', 'tbl_category.id = tbl_products.category_id', 'left')
            ->join('tbl_category sc', 'sc.id = tbl_products.sub_cat_id', 'left')
            ->join('tbl_category gc', 'gc.id = tbl_products.grand_sub_cat_id', 'left')
            ->where('tbl_products.is_deleted', '0')
            ->order_by('tbl_products.id', 'DESC')
            ->get()->result_array();
    }

    public function allproductsFiltered($category_id = '', $sub_cat_id = '', $grand_sub_cat_id = '') {
        $this->db->select('tbl_products.*, tbl_category.category_name, sc.category_name as sub_category_name, gc.category_name as grand_sub_category_name')
            ->from($this->table)
            ->join('tbl_category', 'tbl_category.id = tbl_products.category_id', 'left')
            ->join('tbl_category sc', 'sc.id = tbl_products.sub_cat_id', 'left')
            ->join('tbl_category gc', 'gc.id = tbl_products.grand_sub_cat_id', 'left')
            ->where('tbl_products.is_deleted', '0');
        if ($grand_sub_cat_id) $this->db->where('tbl_products.grand_sub_cat_id', $grand_sub_cat_id);
        elseif ($sub_cat_id)   $this->db->where('tbl_products.sub_cat_id', $sub_cat_id);
        elseif ($category_id)  $this->db->where('tbl_products.category_id', $category_id);
        return $this->db->order_by('tbl_products.id', 'DESC')->get()->result_array();
    }

    public function deleteMultiple($ids) {
        if (empty($ids)) return;
        $this->db->where_in('id', $ids)->update($this->table, array('is_deleted' => 1));
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
        $this->db->order_by('(quantity > 0)', 'DESC', FALSE)->order_by('id', 'DESC');
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result_array();
    }

    public function countAllProducts($search = '') {
        $this->db->where('is_deleted', '0')->where('status', '1');
        if ($search) $this->db->like('product_name', $search);
        return $this->db->count_all_results($this->table);
    }

    public function getProductsByCategory($cat_id, $limit = '', $offset = '') {
        $allIds = array_merge(array((int)$cat_id), getAllDescendantIds($cat_id));
        $this->db->where('is_deleted', '0')->where('status', '1')
            ->group_start()
                ->where_in('category_id', $allIds)
                ->or_where_in('sub_cat_id', $allIds)
                ->or_where_in('grand_sub_cat_id', $allIds)
            ->group_end()
            ->order_by('(quantity > 0)', 'DESC', FALSE)->order_by('id', 'DESC');
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result_array();
    }

    public function countByCategory($cat_id) {
        $allIds = array_merge(array((int)$cat_id), getAllDescendantIds($cat_id));
        return $this->db->where('is_deleted', '0')->where('status', '1')
            ->group_start()
                ->where_in('category_id', $allIds)
                ->or_where_in('sub_cat_id', $allIds)
                ->or_where_in('grand_sub_cat_id', $allIds)
            ->group_end()
            ->count_all_results($this->table);
    }

    public function getProductsBySubCategory($sub_cat_id, $limit = '', $offset = '') {
        $this->db->where('sub_cat_id', $sub_cat_id)->where('is_deleted', '0')->where('status', '1')->order_by('(quantity > 0)', 'DESC', FALSE)->order_by('id', 'DESC');
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
        return $this->db->select('tc.id as cartId, tc.user_id, tc.product_id, tc.quantity, tc.amount, tc.variant_label, tc.variant_price, tp.product_name, tp.product_slug, tp.price, tp.wholesale_price, tp.retailer_price, tp.image')
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

    public function checkCartProduct($product_id, $user_id, $variant_label = NULL) {
        $this->db->where('product_id', $product_id)->where('user_id', $user_id);
        if ($variant_label !== NULL) $this->db->where('variant_label', $variant_label);
        else $this->db->where('variant_label IS NULL', NULL, FALSE);
        return $this->db->get('tbl_cart')->row_array();
    }

    public function checkGuestCartProduct($product_id, $guest_id, $variant_label = NULL) {
        $this->db->where('product_id', $product_id)->where('guest_id', $guest_id)->where('user_id', 0);
        if ($variant_label !== NULL) $this->db->where('variant_label', $variant_label);
        else $this->db->where('variant_label IS NULL', NULL, FALSE);
        return $this->db->get('tbl_cart')->row_array();
    }

    public function getGuestCartProducts($guest_id) {
        return $this->db->select('tc.id as cartId, tc.user_id, tc.guest_id, tc.product_id, tc.quantity, tc.amount, tc.variant_label, tc.variant_price, tp.product_name, tp.product_slug, tp.price, tp.wholesale_price, tp.retailer_price, tp.image')
            ->from('tbl_cart AS tc')
            ->join('tbl_products AS tp', 'tp.id = tc.product_id')
            ->where('tc.guest_id', $guest_id)
            ->where('tc.user_id', 0)
            ->order_by('tc.id', 'DESC')
            ->get()->result_array();
    }

    public function getGuestCartSubTotal($guest_id) {
        $row = $this->db->select('SUM(amount) AS subTotal')->where('guest_id', $guest_id)->where('user_id', 0)->get('tbl_cart')->row_array();
        return $row ? $row['subTotal'] : 0;
    }

    public function mergeGuestCartToUser($guest_id, $user_id, $user_type = 'person') {
        $guestItems = $this->getGuestCartProducts($guest_id);
        foreach ($guestItems as $item) {
            $product = $this->getProductById($item['product_id']);
            if (!$product) continue;
            if ($user_type === 'business' && $product['wholesale_price'] > 0) $price = $product['wholesale_price'];
            elseif ($product['retailer_price'] > 0) $price = $product['retailer_price'];
            else $price = $product['price'];
            $existing = $this->checkCartProduct($item['product_id'], $user_id);
            if ($existing) {
                $newQty = $existing['quantity'] + $item['quantity'];
                $this->db->where('id', $existing['id'])->update('tbl_cart', array('quantity' => $newQty, 'amount' => $newQty * $price));
            } else {
                $this->db->insert('tbl_cart', array(
                    'product_id' => $item['product_id'],
                    'user_id'    => $user_id,
                    'guest_id'   => NULL,
                    'quantity'   => $item['quantity'],
                    'amount'     => $item['quantity'] * $price,
                    'addedOn'    => date('Y-m-d H:i:s'),
                ));
            }
        }
        $this->db->where('guest_id', $guest_id)->where('user_id', 0)->delete('tbl_cart');
    }

    public function deleteCartProduct($id) {
        return $this->db->where('id', $id)->delete('tbl_cart');
    }

    public function deleteGuestCartProduct($id, $guest_id) {
        return $this->db->where('id', $id)->where('guest_id', $guest_id)->where('user_id', 0)->delete('tbl_cart');
    }

    public function deleteAllUserCart($user_id) {
        return $this->db->where('user_id', $user_id)->delete('tbl_cart');
    }

    public function checkWishlistProduct($product_id, $user_id) {
        return $this->db->where('product_id', $product_id)->where('user_id', $user_id)->count_all_results('tbl_wishlist_product');
    }

    public function countUserWishlist($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results('tbl_wishlist_product');
    }

    public function getWishlistPaginated($user_id, $limit, $offset) {
        return $this->db->select('twp.id as wishId, twp.product_id, tp.product_name, tp.product_slug, tp.price, tp.wholesale_price, tp.retailer_price, tp.image, tp.quantity')
            ->from('tbl_wishlist_product AS twp')
            ->join('tbl_products AS tp', 'tp.id = twp.product_id')
            ->where('twp.user_id', $user_id)
            ->order_by('twp.id', 'DESC')
            ->limit($limit, $offset)
            ->get()->result_array();
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
        return $this->db->where('product_id', $product_id)->where('status', 1)->order_by('CAST(label AS UNSIGNED)', 'ASC')->order_by('label', 'ASC')->get('tbl_product_variants')->result_array();
    }

    public function getAllVariantsByProduct($product_id) {
        return $this->db->where('product_id', $product_id)->order_by('CAST(label AS UNSIGNED)', 'ASC')->order_by('label', 'ASC')->get('tbl_product_variants')->result_array();
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

    public function placeOrder($user_id, $payment_method, $billing_address_id, $special_instructions = '', $delivery_option = '', $transaction_ref = '') {
        $cartItems  = $this->getUserCartProduct($user_id);
        $subTotal   = 0;
        foreach ($cartItems as $item) {
            $subTotal += $item['amount'];
        }
        $vatAmount  = round($subTotal * 0.20, 2);
        $totalAmt   = round($subTotal + $vatAmount, 2);
        $txnNo = $transaction_ref ?: generateCode(10);
        $orderId = null;
        $this->db->insert('tbl_order', array(
            'user_id'              => $user_id,
            'transaction_no'       => $txnNo,
            'status'               => 0,
            'pay_amount'           => $subTotal,
            'vat_amount'           => $vatAmount,
            'shipping_charge'      => 0,
            'total_amount'         => $totalAmt,
            'payment_method'       => $payment_method,
            'billing_address_id'   => $billing_address_id,
            'comment'              => $special_instructions,
            'delivery_option'      => $delivery_option,
            'addedOn'              => date('Y-m-d H:i:s'),
            'updatedOn'            => date('Y-m-d H:i:s'),
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
