<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_banner extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Promo_banner_model');
        $this->uploads_dir = dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/promo_banners';
    }

    private function _auth() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
    }

    private function _view($view, $data = []) {
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view($view, $data);
        $this->load->view('template/admin_footer');
    }

    public function index() {
        $this->_auth();
        $data['promos'] = $this->Promo_banner_model->getAll();
        $this->_view('promo_banner/index', $data);
    }

    public function add() {
        $this->_auth();
        $this->_view('promo_banner/form', ['promo' => null]);
    }

    public function save() {
        $this->_auth();
        if (empty($_FILES['image_file']['name'])) {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">Image is required.</div>');
            redirect('promo-banner/add'); return;
        }
        $img = upload_image('image_file', $this->uploads_dir, 0, 0);
        if (!$img) {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">Invalid image file.</div>');
            redirect('promo-banner/add'); return;
        }
        $this->Promo_banner_model->insert([
            'title'      => $this->input->post('title'),
            'link'       => $this->input->post('link') ?: '#',
            'alt_text'   => $this->input->post('alt_text'),
            'sort_order' => (int)$this->input->post('sort_order'),
            'status'     => (int)$this->input->post('status'),
            'image'      => $img,
            'addedOn'    => date('Y-m-d H:i:s'),
        ]);
        $this->session->set_flashdata('response', '<div class="alert alert-success">Promo banner added successfully.</div>');
        redirect('promo-banner');
    }

    public function edit($id) {
        $this->_auth();
        $data['promo'] = $this->Promo_banner_model->getById($id);
        $this->_view('promo_banner/form', $data);
    }

    public function update() {
        $this->_auth();
        $id = (int)$this->input->post('id');
        $promo = $this->Promo_banner_model->getById($id);
        $update = [
            'title'      => $this->input->post('title'),
            'link'       => $this->input->post('link') ?: '#',
            'alt_text'   => $this->input->post('alt_text'),
            'sort_order' => (int)$this->input->post('sort_order'),
            'status'     => (int)$this->input->post('status'),
        ];
        $img = upload_image('image_file', $this->uploads_dir, 0, 0);
        if ($img) {
            if ($promo && $promo['image']) delete_file($this->uploads_dir . '/' . $promo['image']);
            $update['image'] = $img;
        }
        $this->Promo_banner_model->update($id, $update);
        $this->session->set_flashdata('response', '<div class="alert alert-success">Promo banner updated successfully.</div>');
        redirect('promo-banner');
    }

    public function changestatus() {
        $this->_auth();
        $id  = (int)$this->input->post('statusid');
        $val = $this->input->post('statusvalue') ? 0 : 1;
        $cn  = $this->input->post('controllername');
        $this->Promo_banner_model->changeStatus($id, $val);
        $color = $val ? '#00a65a' : '#ff0000';
        $title = $val ? 'Active' : 'In Active';
        $icon  = $val ? 'fa-check' : 'fa-ban';
        echo "<span statusid=$id statusvalue=$val controllername=$cn style='color:$color;cursor:pointer;' title='$title'><i class='fa fa-2x $icon'></i></span>";
    }

    public function delete($id) {
        $this->_auth();
        $promo = $this->Promo_banner_model->getById($id);
        if ($promo && $promo['image']) delete_file($this->uploads_dir . '/' . $promo['image']);
        $this->Promo_banner_model->delete($id);
        redirect('promo-banner');
    }
}
