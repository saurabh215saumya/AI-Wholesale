<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Product_model');
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['counts'] = $this->Admin_model->getDashboardCounts();
        $data['recent_orders'] = $this->db->order_by('id', 'DESC')->limit(10)->get('tbl_order')->result_array();
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('admin/index', $data);
        $this->load->view('template/admin_footer');
    }
}
