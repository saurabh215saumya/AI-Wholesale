<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->table = 'tbl_banners';
        $this->load->model('Banner_model');
        $this->controller = $this->router->fetch_class();
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['allbanners'] = $this->Banner_model->allbanner();
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('banner/index', $data);
        $this->load->view('template/admin_footer');
    }

    public function addbanner() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('banner/add_banner', $data);
        $this->load->view('template/admin_footer');
    }

    public function add_newbanner() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $this->form_validation->set_error_delimiters('<p class="help-block text-danger">', '</p>');
        $this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');
        if ($this->form_validation->run() == FALSE) {
            $this->addbanner();
        } else {
            if (empty($_FILES['image_file']['name'])) {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">Banner image is required.</div>');
                $this->addbanner(); return;
            }
            $insert = array(
                'title'   => $this->input->post('title'),
                'status'  => $this->input->post('status'),
                'addedOn' => date('Y-m-d H:i:s'),
            );
            $uploads_dir = dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/banners';
            $img = upload_image('image_file', $uploads_dir, 1920, 750);
            if ($img) $insert['image'] = $img;
            $this->db->insert($this->table, $insert);
            $this->session->set_flashdata('response', '<div class="alert alert-success">Banner added successfully.</div>');
            redirect($this->controller);
        }
    }

    public function edit($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['details'] = $this->Banner_model->bannerDetails($id);
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('banner/edit', $data);
        $this->load->view('template/admin_footer');
    }

    public function update_banner() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $id = $this->input->post('banner_id');
        $this->form_validation->set_error_delimiters('<p class="help-block text-danger">', '</p>');
        $this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $update = array(
                'title'  => $this->input->post('title'),
                'status' => $this->input->post('status'),
                'meta_title'         => $this->input->post('meta_title'),
                'meta_description'   => $this->input->post('meta_description'),
                'meta_keywords'      => $this->input->post('meta_keywords'),
                'h1_tag'             => $this->input->post('h1_tag'),
                'h2_tag'             => $this->input->post('h2_tag'),
                'h3_tag'             => $this->input->post('h3_tag'),
                'img_alt_1'          => $this->input->post('img_alt_1'),
                'img_alt_2'          => $this->input->post('img_alt_2'),
                'img_alt_3'          => $this->input->post('img_alt_3'),
                'img_alt_4'          => $this->input->post('img_alt_4'),
                'img_alt_5'          => $this->input->post('img_alt_5'),
                'robots'             => $this->input->post('robots'),
                'revisit_after'      => $this->input->post('revisit_after'),
                'og_locale'          => $this->input->post('og_locale'),
                'og_type'            => $this->input->post('og_type'),
                'og_image'           => $this->input->post('og_image'),
                'og_tag'             => $this->input->post('og_tag'),
                'og_title'           => $this->input->post('og_title'),
                'og_url'             => $this->input->post('og_url'),
                'og_description'     => $this->input->post('og_description'),
                'og_site_name'       => $this->input->post('og_site_name'),
                'author'             => $this->input->post('author'),
                'canonical'          => $this->input->post('canonical'),
                'geo_region'         => $this->input->post('geo_region'),
                'geo_place_name'     => $this->input->post('geo_place_name'),
                'geo_position'       => $this->input->post('geo_position'),
                'icbm'               => $this->input->post('icbm'),
                'subject'            => $this->input->post('subject'),
                'owner'              => $this->input->post('owner'),
                'coverage'           => $this->input->post('coverage'),
                'language'           => $this->input->post('language'),
                'distribution'       => $this->input->post('distribution'),
                'country'            => $this->input->post('country'),
                'geography'          => $this->input->post('geography'),
                'cache_control'      => $this->input->post('cache_control'),
                'instagram'          => $this->input->post('instagram'),
                'twitter_description'=> $this->input->post('twitter_description'),
                'facebook'           => $this->input->post('facebook'),
                'twitter_site'       => $this->input->post('twitter_site'),
                'youtube'            => $this->input->post('youtube'),
            );
            $old = $this->input->post('image_file_name');
            $uploads_dir = dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/banners';
            $img = upload_image('image_file', $uploads_dir, 1920, 750);
            if ($img) {
                $update['image'] = $img;
                delete_file($uploads_dir . '/' . $old);
            }
            $this->db->where('id', $id)->update($this->table, $update);
            $this->session->set_flashdata('response', '<div class="alert alert-success">Banner updated successfully.</div>');
            redirect($this->controller);
        }
    }

    public function changestatus() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $id  = $this->input->post('statusid');
        $val = $this->input->post('statusvalue') ? 0 : 1;
        $cn  = $this->input->post('controllername');
        $this->Banner_model->changeStatus($id, $val);
        $color = $val ? '#00a65a' : '#ff0000';
        $title = $val ? 'Active' : 'In Active';
        $icon  = $val ? 'fa-check' : 'fa-ban';
        echo "<span statusid=$id statusvalue=$val controllername=$cn style='color:$color;cursor:pointer;' title='$title'><i class='fa fa-2x $icon'></i></span>";
    }

    public function delete($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $banner = $this->Banner_model->bannerDetails($id);
        if ($banner && $banner['image']) {
            delete_file(dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/banners/' . $banner['image']);
        }
        $this->Banner_model->deleteRecord($id);
        redirect($this->controller);
    }
}
