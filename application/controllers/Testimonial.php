<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->table = 'tbl_client_testimonial';
        $this->load->model('Testimonial_model');
        $this->controller = $this->router->fetch_class();
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['alltestimonials'] = $this->Testimonial_model->allTestimonials();
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('testimonial/index', $data);
        $this->load->view('template/admin_footer');
    }

    public function addtestimonial() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('testimonial/add_testimonial', $data);
        $this->load->view('template/admin_footer');
    }

    public function add_newtestimonial() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $this->form_validation->set_error_delimiters('<p class="help-block text-danger">', '</p>');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Review', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->addtestimonial();
        } else {
            $insert = array(
                'name'        => $this->input->post('name'),
                'designation' => $this->input->post('designation'),
                'description' => $this->input->post('description'),
                'status'      => $this->input->post('status'),
                'addedOn'     => date('Y-m-d H:i:s'),
            );
            $uploads_dir = dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/testimonials';
            $img = upload_image('image_file', $uploads_dir, 150, 150);
            if ($img) $insert['image'] = $img;
            $this->db->insert($this->table, $insert);
            $this->session->set_flashdata('response', '<div class="alert alert-success">Testimonial added successfully.</div>');
            redirect($this->controller);
        }
    }

    public function edit($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['details'] = $this->Testimonial_model->testimonialDetails($id);
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('testimonial/edit', $data);
        $this->load->view('template/admin_footer');
    }

    public function update_testimonial() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $id = $this->input->post('testimonial_id');
        $this->form_validation->set_error_delimiters('<p class="help-block text-danger">', '</p>');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Review', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $update = array(
                'name'        => $this->input->post('name'),
                'designation' => $this->input->post('designation'),
                'description' => $this->input->post('description'),
                'status'      => $this->input->post('status'),
            );
            $old = $this->input->post('image_file_name');
            $uploads_dir = dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/testimonials';
            $img = upload_image('image_file', $uploads_dir, 150, 150);
            if ($img) { $update['image'] = $img; delete_file($uploads_dir . '/' . $old); }
            $this->db->where('id', $id)->update($this->table, $update);
            $this->session->set_flashdata('response', '<div class="alert alert-success">Testimonial updated successfully.</div>');
            redirect($this->controller);
        }
    }

    public function changestatus() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $id  = $this->input->post('statusid');
        $val = $this->input->post('statusvalue') ? 0 : 1;
        $cn  = $this->input->post('controllername');
        $this->Testimonial_model->changeStatus($id, $val);
        $color = $val ? '#00a65a' : '#ff0000';
        $title = $val ? 'Active' : 'In Active';
        $icon  = $val ? 'fa-check' : 'fa-ban';
        echo "<span statusid=$id statusvalue=$val controllername=$cn style='color:$color;cursor:pointer;' title='$title'><i class='fa fa-2x $icon'></i></span>";
    }

    public function delete($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $t = $this->Testimonial_model->testimonialDetails($id);
        if ($t && $t['image']) delete_file(dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/testimonials/' . $t['image']);
        $this->Testimonial_model->deleteRecord($id);
        redirect($this->controller);
    }
}
