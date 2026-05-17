<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Wholesale extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Wholesale_model');
    }

    public function index() {
        $data['pricingTiers']       = $this->Wholesale_model->getActiveTiers();
        $data['isActiveCategories'] = getAllCategory();
        $data['pageTitle']          = 'Wholesale';
        $this->load->view('template/front/header', $data);
        $this->load->view('wholesale/index', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function apply() {
        if ($this->session->userdata('front_logged_in')) redirect('/');
        $data['isActiveCategories'] = getAllCategory();
        $data['pageTitle']          = 'Apply as Wholesaler';
        $data['is_wholesale']       = true;
        $this->load->view('template/front/header', $data);
        $this->load->view('appuser/signup', $data);
        $this->load->view('template/front/footer', $data);
    }

    /* ---- ADMIN SECTION ---- */

    public function admin_pricing() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['tiers']      = $this->Wholesale_model->getAllTiers();
        $data['controller'] = 'wholesale';
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('wholesale/admin_pricing', $data);
        $this->load->view('template/admin_footer');
    }

    public function add_tier() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['controller'] = 'wholesale';
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('wholesale/add_tier', $data);
        $this->load->view('template/admin_footer');
    }

    public function save_tier() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $insert = array(
            'tier_name'        => $this->input->post('tier_name'),
            'min_qty'          => (int)$this->input->post('min_qty'),
            'max_qty'          => $this->input->post('max_qty') !== '' ? (int)$this->input->post('max_qty') : NULL,
            'discount_percent' => (float)$this->input->post('discount_percent'),
            'description'      => $this->input->post('description'),
            'status'           => (int)$this->input->post('status'),
            'sort_order'       => (int)$this->input->post('sort_order'),
            'addedOn'          => date('Y-m-d H:i:s'),
        );
        $this->Wholesale_model->addTier($insert);
        $this->session->set_flashdata('response', '<div class="alert alert-success">Pricing tier added successfully.</div>');
        redirect('wholesale/admin_pricing');
    }

    public function edit_tier($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['tier']       = $this->Wholesale_model->getTierById($id);
        $data['controller'] = 'wholesale';
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('wholesale/edit_tier', $data);
        $this->load->view('template/admin_footer');
    }

    public function update_tier() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $id     = $this->input->post('tier_id');
        $update = array(
            'tier_name'        => $this->input->post('tier_name'),
            'min_qty'          => (int)$this->input->post('min_qty'),
            'max_qty'          => $this->input->post('max_qty') !== '' ? (int)$this->input->post('max_qty') : NULL,
            'discount_percent' => (float)$this->input->post('discount_percent'),
            'description'      => $this->input->post('description'),
            'status'           => (int)$this->input->post('status'),
            'sort_order'       => (int)$this->input->post('sort_order'),
        );
        $this->Wholesale_model->updateTier($id, $update);
        $this->session->set_flashdata('response', '<div class="alert alert-success">Pricing tier updated successfully.</div>');
        redirect('wholesale/admin_pricing');
    }

    public function delete_tier($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $this->Wholesale_model->deleteTier($id);
        redirect('wholesale/admin_pricing');
    }
}
