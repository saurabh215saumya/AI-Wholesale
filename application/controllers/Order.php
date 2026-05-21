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
}
