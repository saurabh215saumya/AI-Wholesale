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
        $newStatus = (int)$this->input->post('status');
        $oldUser   = $this->Appuser_model->userDetails($id);
        $update = array(
            'first_name'   => $this->input->post('first_name'),
            'last_name'    => $this->input->post('last_name'),
            'email'        => $this->input->post('email'),
            'mobile'       => $this->input->post('mobile'),
            'company_name' => $this->input->post('company_name'),
            'status'       => $newStatus,
            'updatedOn'    => date('Y-m-d H:i:s'),
        );
        $this->Appuser_model->updateUser($id, $update);

        // Send account approved email if status changed from inactive to active
        if ($oldUser && (int)$oldUser['status'] == 0 && $newStatus == 1) {
            $fullName  = trim($oldUser['first_name'] . ' ' . $oldUser['last_name']);
            $approvedBody = '
                <p style="font-size:17px;font-weight:bold;color:#1a1a2e;">Great News, ' . $fullName . '!</p>
                <p style="background:#e8f5e9;border-left:4px solid #4caf50;padding:12px 16px;border-radius:4px;">
                    Your <strong>' . SITE_NAME . '</strong> account has been <strong style="color:#2e7d32;">approved and activated</strong>!
                </p>
                <p>You can now log in and start exploring our wholesale products.</p>
                <p style="text-align:center;">
                    <a href="' . BASE_URL . '/sign-in" style="display:inline-block;background:#c8a951;color:#ffffff;padding:12px 28px;border-radius:5px;text-decoration:none;font-weight:bold;font-size:15px;">Login Now</a>
                </p>
                <p style="color:#777;font-size:13px;">If you have any questions, feel free to contact us at <a href="mailto:' . ADMIN_EMAIL . '" style="color:#c8a951;">' . ADMIN_EMAIL . '</a></p>
                <p>Regards,<br><strong>' . SITE_NAME . ' Team</strong></p>';
            sendMail($oldUser['email'], 'Account Approved - ' . SITE_NAME, emailTemplate('Account Approved!', $approvedBody));
        }

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
        $email     = $this->input->post('email');
        $user_type = $this->input->post('user_type') ?: 'business';
        if ($this->Appuser_model->getUserByEmail($email)) { echo 'duplicate_email'; return; }
        $insert = array(
            'user_type'          => $user_type,
            'first_name'         => $this->input->post('first_name'),
            'last_name'          => $this->input->post('last_name'),
            'email'              => $email,
            'mobile'             => $this->input->post('mobile'),
            'company_name'       => $this->input->post('company_name'),
            'company_reg_number' => $this->input->post('company_reg_number'),
            'password'           => md5($this->input->post('password')),
            'status'             => 0,
            'addedOn'            => date('Y-m-d H:i:s'),
            'updatedOn'          => date('Y-m-d H:i:s'),
        );
        if ($user_type === 'business') {
            $insert['business_type']          = $this->input->post('business_type');
            $insert['companies_house_number'] = $this->input->post('companies_house_number');
            $insert['vat_number']             = $this->input->post('vat_number');
            $insert['website']                = $this->input->post('website');
            $insert['estimated_volume']       = $this->input->post('estimated_volume');
            $insert['monthly_order']          = $this->input->post('monthly_order');
            $insert['business_address']       = $this->input->post('business_address');
            $insert['city']                   = $this->input->post('city');
            $insert['postal_code']            = $this->input->post('postal_code');
            $insert['country']                = $this->input->post('country');
        }
        $this->db->insert('tbl_users', $insert);
        if (!$this->db->insert_id()) { echo 'error'; return; }

        $fullName = trim($insert['first_name'] . ' ' . $insert['last_name']);

        // --- Email to User ---
        $userBody = '
            <p style="font-size:17px;font-weight:bold;color:#1a1a2e;">Hello, ' . $fullName . '!</p>
            <p>Thank you for registering with <strong>' . SITE_NAME . '</strong>.</p>
            <p style="background:#fff8e1;border-left:4px solid #c8a951;padding:12px 16px;border-radius:4px;">
                Your account is currently <strong>pending approval</strong>.<br>
                Our team will review your details and activate your account shortly.
            </p>
            <p>Once approved, you will receive a confirmation email and can log in at:</p>
            <p style="text-align:center;">
                <a href="' . BASE_URL . '/sign-in" style="display:inline-block;background:#c8a951;color:#ffffff;padding:12px 28px;border-radius:5px;text-decoration:none;font-weight:bold;font-size:15px;">Login to Your Account</a>
            </p>
            <p style="color:#777;font-size:13px;">If you did not register, please ignore this email.</p>
            <p>Regards,<br><strong>' . SITE_NAME . ' Team</strong></p>';
        sendMail($email, 'Registration Received - ' . SITE_NAME, emailTemplate('Registration Received', $userBody));

        // --- Email to Admin ---
        $adminBody = '
            <p style="font-size:17px;font-weight:bold;color:#1a1a2e;">New User Registration</p>
            <p>A new user has registered and is awaiting approval.</p>
            <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse:collapse;font-size:14px;">
                <tr style="background:#f5f5f5;">
                    <td style="border:1px solid #ddd;font-weight:bold;width:35%;">Name</td>
                    <td style="border:1px solid #ddd;">' . $fullName . '</td>
                </tr>
                <tr>
                    <td style="border:1px solid #ddd;font-weight:bold;">Email</td>
                    <td style="border:1px solid #ddd;">' . $email . '</td>
                </tr>
                <tr style="background:#f5f5f5;">
                    <td style="border:1px solid #ddd;font-weight:bold;">Mobile</td>
                    <td style="border:1px solid #ddd;">' . $insert['mobile'] . '</td>
                </tr>
                <tr>
                    <td style="border:1px solid #ddd;font-weight:bold;">Company</td>
                    <td style="border:1px solid #ddd;">' . $insert['company_name'] . '</td>
                </tr>
                <tr style="background:#f5f5f5;">
                    <td style="border:1px solid #ddd;font-weight:bold;">User Type</td>
                    <td style="border:1px solid #ddd;">' . ucfirst($user_type) . '</td>
                </tr>
                <tr>
                    <td style="border:1px solid #ddd;font-weight:bold;">Registered On</td>
                    <td style="border:1px solid #ddd;">' . $insert['addedOn'] . '</td>
                </tr>
            </table>
            <br>
            <p style="text-align:center;">
                <a href="' . BASE_URL . '/appuser" style="display:inline-block;background:#1a1a2e;color:#ffffff;padding:12px 28px;border-radius:5px;text-decoration:none;font-weight:bold;font-size:15px;">Review in Admin Panel</a>
            </p>';
        sendMail(ADMIN_EMAIL, 'New User Registration - ' . SITE_NAME, emailTemplate('New User Registration', $adminBody));

        echo 'success';
    }

    public function ajax_forgot_password() {
        $email = trim($this->input->post('email'));
        $user  = $this->Appuser_model->getUserByEmail($email);
        if (!$user) { echo 'not_found'; return; }

        // Invalidate old tokens
        $this->db->where('user_id', $user['id'])->update('tbl_password_reset', ['used' => 1]);

        $token   = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $this->db->insert('tbl_password_reset', [
            'user_id'    => $user['id'],
            'token'      => $token,
            'expires_at' => $expires,
            'used'       => 0,
            'addedOn'    => date('Y-m-d H:i:s'),
        ]);

        $fullName  = trim($user['first_name'] . ' ' . $user['last_name']);
        $resetLink = BASE_URL . '/reset-password/' . $token;
        $body = '
            <p style="font-size:17px;font-weight:bold;color:#1a1a2e;">Password Reset Request</p>
            <p>Hi <strong>' . $fullName . '</strong>, we received a request to reset your password.</p>
            <p style="text-align:center;margin:24px 0;">
                <a href="' . $resetLink . '" style="display:inline-block;background:#c8a951;color:#ffffff;padding:12px 28px;border-radius:5px;text-decoration:none;font-weight:bold;font-size:15px;">Reset My Password</a>
            </p>
            <p style="color:#888;font-size:13px;">This link expires in 1 hour. If you did not request this, please ignore this email.</p>
            <p>Regards,<br><strong>' . SITE_NAME . ' Team</strong></p>';
        sendMail($email, 'Password Reset - ' . SITE_NAME, emailTemplate('Password Reset', $body));
        echo 'success';
    }

    public function ajax_reset_password() {
        $token    = trim($this->input->post('token'));
        $password = trim($this->input->post('password'));
        $row = $this->db->where('token', $token)->where('used', 0)->get('tbl_password_reset')->row_array();
        if (empty($row)) { echo 'expired'; return; }
        if (strtotime($row['expires_at']) < time()) {
            $this->db->where('id', $row['id'])->update('tbl_password_reset', ['used' => 1]);
            echo 'expired'; return;
        }
        $this->db->where('id', $row['user_id'])->update('tbl_users', ['password' => md5($password), 'updatedOn' => date('Y-m-d H:i:s')]);
        $this->db->where('id', $row['id'])->update('tbl_password_reset', ['used' => 1]);
        echo 'success';
    }

    public function forgot_password() {
        if ($this->session->userdata('front_logged_in')) redirect('/');
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('appuser/forgot_password', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function reset_password($token) {
        if ($this->session->userdata('front_logged_in')) redirect('/');
        $row = $this->db->where('token', $token)->where('used', 0)->get('tbl_password_reset')->row_array();
        $data['valid_token'] = !empty($row) && strtotime($row['expires_at']) >= time();
        $data['token']       = $token;
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('appuser/reset_password', $data);
        $this->load->view('template/front/footer', $data);
    }

    /* ---- FRONT-END SECTION ---- */

    public function sign_up() {
        redirect('wholesale/apply');
    }

    public function login() {
        if ($this->session->userdata('front_logged_in')) redirect('/');
        $data['isActiveCategories'] = getAllRootCategories();
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
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('appuser/my_account', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function my_orders() {
        if (!$this->session->userdata('front_logged_in')) redirect('sign-in');
        $user_id = $this->session->userdata('front_logged_in')['id'];
        $data['orders'] = $this->Appuser_model->getUserOrders($user_id);
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('appuser/my_order', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function update_account() {
        if (!$this->session->userdata('front_logged_in')) redirect('sign-in');
        $user_id = $this->session->userdata('front_logged_in')['id'];
        $update = array(
            'first_name'   => $this->input->post('first_name'),
            'last_name'    => $this->input->post('last_name'),
            'mobile'       => $this->input->post('mobile'),
            'company_name' => $this->input->post('company_name'),
            'updatedOn'    => date('Y-m-d H:i:s'),
        );
        $new_pass = $this->input->post('new_password');
        if ($new_pass) $update['password'] = md5($new_pass);
        $this->Appuser_model->updateUser($user_id, $update);
        // Refresh session name
        $sess = $this->session->userdata('front_logged_in');
        $sess['first_name'] = $update['first_name'];
        $sess['last_name']  = $update['last_name'];
        $this->session->set_userdata('front_logged_in', $sess);
        $this->session->set_flashdata('success', 'Profile updated successfully.');
        redirect('my-account');
    }

    public function delete_billing($id) {
        if (!$this->session->userdata('front_logged_in')) redirect('sign-in');
        $user_id = $this->session->userdata('front_logged_in')['id'];
        $this->db->where('id', $id)->where('user_id', $user_id)->delete('tbl_user_billing');
        $this->session->set_flashdata('success', 'Address removed.');
        redirect('billing-address');
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
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('appuser/billing_address', $data);
        $this->load->view('template/front/footer', $data);
    }
}
