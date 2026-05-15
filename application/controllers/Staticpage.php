<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Staticpage extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->table = 'tbl_staticpages';
        $this->load->model('Staticpage_model');
        $this->controller = $this->router->fetch_class();
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['allpages'] = $this->Staticpage_model->allPages();
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('staticpage/index', $data);
        $this->load->view('template/admin_footer');
    }

    public function addpage() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('staticpage/add_page', $data);
        $this->load->view('template/admin_footer');
    }

    public function add_newpage() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $this->form_validation->set_error_delimiters('<p class="help-block text-danger">', '</p>');
        $this->form_validation->set_rules('page_name', 'Page Name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('identifire', 'Identifier', 'trim|required|max_length[255]|is_unique[tbl_staticpages.identifire]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');
        if ($this->form_validation->run() == FALSE) {
            $this->addpage();
        } else {
            $insert = array(
                'page_name'  => $this->input->post('page_name'),
                'identifire' => url_title(strtolower($this->input->post('identifire')), '_'),
                'content'    => $this->input->post('content'),
                'meta_title' => $this->input->post('meta_title'),
                'meta_description' => $this->input->post('meta_description'),
                'status'     => $this->input->post('status'),
                'addedOn'    => date('Y-m-d H:i:s'),
            );
            $this->db->insert($this->table, $insert);
            $this->session->set_flashdata('response', '<div class="alert alert-success">Page added successfully.</div>');
            redirect($this->controller);
        }
    }

    public function edit($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['details'] = $this->Staticpage_model->pageDetails($id);
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('staticpage/edit', $data);
        $this->load->view('template/admin_footer');
    }

    public function update_page() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $id = $this->input->post('page_id');
        $this->form_validation->set_error_delimiters('<p class="help-block text-danger">', '</p>');
        $this->form_validation->set_rules('page_name', 'Page Name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $update = array(
                'page_name'          => $this->input->post('page_name'),
                'content'            => $this->input->post('content'),
                'status'             => $this->input->post('status'),
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
            $this->db->where('id', $id)->update($this->table, $update);
            $this->session->set_flashdata('response', '<div class="alert alert-success">Page updated successfully.</div>');
            redirect($this->controller);
        }
    }

    public function delete($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $this->Staticpage_model->deleteRecord($id);
        redirect($this->controller);
    }
}
