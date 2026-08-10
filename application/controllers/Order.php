<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function order_summary($order_id) {
        if (!$this->session->userdata('front_logged_in')) redirect('sign-in');
        $user_id = $this->session->userdata('front_logged_in')['id'];
        $data['orderDetails'] = $this->db->where('id', $order_id)->where('user_id', $user_id)->get('tbl_order')->row_array();
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('order/order_summary', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function offline_confirmation($order_id) {
        if (!$this->session->userdata('front_logged_in')) redirect('sign-in');
        $user_id = $this->session->userdata('front_logged_in')['id'];
        $data['orderDetails'] = $this->db->where('id', $order_id)->where('user_id', $user_id)->get('tbl_order')->row_array();
        $data['orderItems']   = $this->db->select('toi.quantity, toi.amount, tp.product_name')
            ->from('tbl_order_item toi')
            ->join('tbl_products tp', 'tp.id = toi.product_id', 'left')
            ->where('toi.order_id', $order_id)
            ->get()->result_array();
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('order/offline_confirmation', $data);
        $this->load->view('template/front/footer', $data);
    }
}
