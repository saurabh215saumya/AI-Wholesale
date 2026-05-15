<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
    }

    public function index() {
        redirect('user/login');
    }

    public function login() {
        if ($this->session->userdata('logged_in')) redirect('admin');
        $data = array();
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));
            $admin = $this->Admin_model->getAdminByUsername($username);
            if ($admin && $admin['password'] === $password && $admin['status'] == 1) {
                $this->session->set_userdata('logged_in', array(
                    'id'           => $admin['id'],
                    'fullname'     => $admin['full_name'],
                    'email'        => $admin['email'],
                    'profileimage' => $admin['profile_image'],
                    'membersince'  => $admin['addedOn'],
                ));
                redirect('admin');
            } else {
                $data['error'] = 'Invalid username or password.';
            }
        }
        $this->load->view('template/login_layout', $data);
        $this->load->view('user/login', $data);
        $this->load->view('template/admin_footer');
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        redirect('user/login');
    }

    public function profile() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $user_data = $this->session->userdata('logged_in');
        $data['details'] = $this->Admin_model->getAdminById($user_data['id']);
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('user/profile', $data);
        $this->load->view('template/admin_footer');
    }

    public function update_profile() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $user_data = $this->session->userdata('logged_in');
        $update = array('full_name' => $this->input->post('full_name'), 'email' => $this->input->post('email'));
        $new_pass = $this->input->post('new_password');
        if ($new_pass) $update['password'] = md5($new_pass);
        $this->Admin_model->updateAdmin($user_data['id'], $update);
        $this->session->set_flashdata('response', '<div class="alert alert-success">Profile updated successfully.</div>');
        redirect('user/profile');
    }
}
