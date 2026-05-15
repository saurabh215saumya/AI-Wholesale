<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Appuser extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->table = 'tbl_users';
        $this->load->model('Appuser_model');
        $this->controller = $this->router->fetch_class();
    }

    /* ---- ADMIN SECTION ---- */

    public function index() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['allusers'] = $this->Appuser_model->allUsers();
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('appuser/index', $data);
        $this->load->view('template/admin_footer');
    }

    public function view_user($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['details'] = $this->Appuser_model->userDetails($id);
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('appuser/details', $data);
        $this->load->view('template/admin_footer');
    }

    public function edit($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['details'] = $this->Appuser_model->userDetails($id);
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('appuser/edit', $data);
        $this->load->view('template/admin_footer');
    }

    public function update_user() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $id = $this->input->post('user_id');
        $update = array(
            'first_name'   => $this->input->post('first_name'),
            'last_name'    => $this->input->post('last_name'),
            'email'        => $this->input->post('email'),
            'mobile'       => $this->input->post('mobile'),
            'company_name' => $this->input->post('company_name'),
            'status'       => $this->input->post('status'),
            'updatedOn'    => date('Y-m-d H:i:s'),
        );
        $this->Appuser_model->updateUser($id, $update);
        $this->session->set_flashdata('response', '<div class="alert alert-success">User updated successfully.</div>');
        redirect($this->controller);
    }

    public function delete($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $this->Appuser_model->deleteRecord($id);
        redirect($this->controller);
    }

    public function ajax_login() {
        $email    = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $user = $this->Appuser_model->getUserByEmail($email);
        if ($user && $user['password'] === $password && $user['status'] == 1) {
            $this->session->set_userdata('front_logged_in', array(
                'id'           => $user['id'],
                'first_name'   => $user['first_name'],
                'last_name'    => $user['last_name'],
                'email'        => $user['email'],
                'user_type'    => $user['user_type'],
                'company_name' => $user['company_name'],
            ));
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    public function ajax_signup() {
        $email = $this->input->post('email');
        if ($this->Appuser_model->getUserByEmail($email)) { echo 'duplicate_email'; return; }
        $insert = array(
            'user_type'    => $this->input->post('user_type') ?: 'person',
            'first_name'   => $this->input->post('first_name'),
            'last_name'    => $this->input->post('last_name'),
            'email'        => $email,
            'mobile'       => $this->input->post('mobile'),
            'company_name' => $this->input->post('company_name'),
            'password'     => md5($this->input->post('password')),
            'status'       => 1,
            'addedOn'      => date('Y-m-d H:i:s'),
            'updatedOn'    => date('Y-m-d H:i:s'),
        );
        $this->db->insert($this->table, $insert);
        echo $this->db->insert_id() ? 'success' : 'error';
    }

    /* ---- FRONT-END SECTION ---- */

    public function sign_up() {
        if ($this->session->userdata('front_logged_in')) redirect('/');
        $data['isActiveCategories'] = getAllCategory();
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $existing = $this->Appuser_model->getUserByEmail($email);
            if ($existing) {
                $data['error'] = 'Email already registered.';
            } else {
                $insert = array(
                    'user_type'    => $this->input->post('user_type') ?: 'person',
                    'first_name'   => $this->input->post('first_name'),
                    'last_name'    => $this->input->post('last_name'),
                    'email'        => $email,
                    'mobile'       => $this->input->post('mobile'),
                    'company_name' => $this->input->post('company_name'),
                    'password'     => md5($this->input->post('password')),
                    'status'       => 1,
                    'addedOn'      => date('Y-m-d H:i:s'),
                    'updatedOn'    => date('Y-m-d H:i:s'),
                );
                $this->db->insert($this->table, $insert);
                $this->session->set_flashdata('success', 'Registration successful! Please login.');
                redirect('sign-in');
            }
        }
        $this->load->view('template/front/header', $data);
        $this->load->view('appuser/signup', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function login() {
        if ($this->session->userdata('front_logged_in')) redirect('/');
        $data['isActiveCategories'] = getAllCategory();
        if ($this->input->post()) {
            $email    = $this->input->post('email');
            $password = md5($this->input->post('password'));
            $user = $this->Appuser_model->getUserByEmail($email);
            if ($user && $user['password'] === $password && $user['status'] == 1) {
                $this->session->set_userdata('front_logged_in', array(
                    'id'           => $user['id'],
                    'first_name'   => $user['first_name'],
                    'last_name'    => $user['last_name'],
                    'email'        => $user['email'],
                    'user_type'    => $user['user_type'],
                    'company_name' => $user['company_name'],
                ));
                redirect('/');
            } else {
                $data['error'] = 'Invalid email or password.';
            }
        }
        $this->load->view('template/front/header', $data);
        $this->load->view('appuser/signin', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function logout() {
        $this->session->unset_userdata('front_logged_in');
        redirect('sign-in');
    }

    public function my_account() {
        if (!$this->session->userdata('front_logged_in')) redirect('sign-in');
        $user_id = $this->session->userdata('front_logged_in')['id'];
        $data['details'] = $this->Appuser_model->userDetails($user_id);
        $data['isActiveCategories'] = getAllCategory();
        $this->load->view('template/front/header', $data);
        $this->load->view('appuser/my_account', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function my_orders() {
        if (!$this->session->userdata('front_logged_in')) redirect('sign-in');
        $user_id = $this->session->userdata('front_logged_in')['id'];
        $data['orders'] = $this->Appuser_model->getUserOrders($user_id);
        $data['isActiveCategories'] = getAllCategory();
        $this->load->view('template/front/header', $data);
        $this->load->view('appuser/my_order', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function billing_address() {
        if (!$this->session->userdata('front_logged_in')) redirect('sign-in');
        $user_id = $this->session->userdata('front_logged_in')['id'];
        if ($this->input->post()) {
            $insert = array(
                'user_id'      => $user_id,
                'first_name'   => $this->input->post('first_name'),
                'last_name'    => $this->input->post('last_name'),
                'company_name' => $this->input->post('company_name'),
                'address_1'    => $this->input->post('address_1'),
                'address_2'    => $this->input->post('address_2'),
                'city'         => $this->input->post('city'),
                'postal_code'  => $this->input->post('postal_code'),
                'country'      => $this->input->post('country'),
                'email'        => $this->input->post('email'),
                'contact'      => $this->input->post('contact'),
                'addedOn'      => date('Y-m-d H:i:s'),
                'updatedOn'    => date('Y-m-d H:i:s'),
            );
            $this->db->insert('tbl_user_billing', $insert);
            $this->session->set_flashdata('success', 'Billing address saved.');
            redirect('billing-address');
        }
        $data['billingArr'] = getUserBillingDetails($user_id);
        $data['isActiveCategories'] = getAllCategory();
        $this->load->view('template/front/header', $data);
        $this->load->view('appuser/billing_address', $data);
        $this->load->view('template/front/footer', $data);
    }
}
