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

    public function offline_confirmation($order_id) {
        if (!$this->session->userdata('front_logged_in')) redirect('sign-in');
        $user_id = $this->session->userdata('front_logged_in')['id'];
        $data['orderDetails'] = $this->db->where('id', $order_id)->where('user_id', $user_id)->get('tbl_order')->row_array();
        $data['orderItems']   = $this->db->select('toi.quantity, toi.amount, tp.product_name')
            ->from('tbl_order_item toi')
            ->join('tbl_products tp', 'tp.id = toi.product_id', 'left')
            ->where('toi.order_id', $order_id)
            ->get()->result_array();
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('order/offline_confirmation', $data);
        $this->load->view('template/front/footer', $data);
    }

    // User: pay for a confirmed order
    public function pay($order_id) {
        if (!$this->session->userdata('front_logged_in')) redirect('sign-in');
        $user_id = $this->session->userdata('front_logged_in')['id'];
        $order   = $this->db->where('id', $order_id)->where('user_id', $user_id)->get('tbl_order')->row_array();
        if (empty($order) || $order['status'] != 1 || $order['payment_status'] == 1) redirect('my-orders');
        $data['order'] = $order;
        $data['items'] = $this->db->select('toi.quantity, toi.amount, tp.product_name')
            ->from('tbl_order_item toi')
            ->join('tbl_products tp', 'tp.id = toi.product_id', 'left')
            ->where('toi.order_id', $order_id)
            ->get()->result_array();
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('order/pay_order', $data);
        $this->load->view('template/front/footer', $data);
    }

    // User: confirm offline payment intent
    public function confirm_offline_payment() {
        if (!$this->session->userdata('front_logged_in')) { echo json_encode(['status'=>'login']); return; }
        $user_id  = $this->session->userdata('front_logged_in')['id'];
        $order_id = (int)$this->input->post('order_id');
        $order    = $this->db->where('id', $order_id)->where('user_id', $user_id)->get('tbl_order')->row_array();
        if (empty($order)) { echo json_encode(['status'=>'error']); return; }
        $this->db->where('id', $order_id)->update('tbl_order', [
            'payment_method' => 'offline',
            'payment_status' => 1,
            'updatedOn'      => date('Y-m-d H:i:s'),
        ]);
        $front = $this->session->userdata('front_logged_in');
        $this->_sendPaymentNotification($order_id, $front, 'offline');
        echo json_encode(['status'=>'success']);
    }

    // User: stripe payment for confirmed order
    public function stripe_order_payment() {
        if (!$this->session->userdata('front_logged_in')) { echo json_encode(['status'=>'login']); return; }
        $user_id      = $this->session->userdata('front_logged_in')['id'];
        $order_id     = (int)$this->input->post('order_id');
        $stripe_token = $this->input->post('stripe_token');
        $order        = $this->db->where('id', $order_id)->where('user_id', $user_id)->get('tbl_order')->row_array();
        if (empty($order) || $order['payment_status'] == 1) { echo json_encode(['status'=>'error','msg'=>'Invalid order']); return; }

        require_once APPPATH . 'libraries/Stripe/init.php';
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
        try {
            $charge = \Stripe\Charge::create([
                'amount'      => (int)round($order['total_amount'] * 100),
                'currency'    => 'eur',
                'source'      => $stripe_token,
                'description' => 'Order #' . $order_id . ' - ' . SITE_NAME,
            ]);
            if ($charge->status === 'succeeded') {
                $this->db->where('id', $order_id)->update('tbl_order', [
                    'payment_method' => 'stripe',
                    'payment_status' => 1,
                    'transaction_no' => $charge->id,
                    'updatedOn'      => date('Y-m-d H:i:s'),
                ]);
                $front = $this->session->userdata('front_logged_in');
                $this->_sendPaymentNotification($order_id, $front, 'stripe');
                echo json_encode(['status'=>'success']);
            } else {
                echo json_encode(['status'=>'error','msg'=>'Payment not completed']);
            }
        } catch (Exception $e) {
            echo json_encode(['status'=>'error','msg'=>$e->getMessage()]);
        }
    }

    private function _sendPaymentNotification($orderId, $front, $method) {
        $order    = $this->db->where('id', $orderId)->get('tbl_order')->row_array();
        if (!$order) return;
        $fullName = trim($front['first_name'] . ' ' . $front['last_name']);
        $total    = '€' . number_format($order['total_amount'], 2);
        $methodLabel = $method === 'stripe' ? 'Online (Stripe)' : 'Offline';

        $userBody = '
            <p style="font-size:17px;font-weight:bold;color:#1a1a2e;">Payment Received, ' . $fullName . '!</p>
            <p style="background:#e8f5e9;border-left:4px solid #4caf50;padding:12px 16px;border-radius:4px;">
                Your payment of <strong>' . $total . '</strong> for Order <strong>#' . $orderId . '</strong> has been received successfully.
            </p>
            <p>Payment Method: <strong>' . $methodLabel . '</strong></p>
            <p style="text-align:center;">
                <a href="' . BASE_URL . '/my-orders" style="display:inline-block;background:#c8a951;color:#ffffff;padding:12px 28px;border-radius:5px;text-decoration:none;font-weight:bold;">View My Orders</a>
            </p>
            <p>Regards,<br><strong>' . SITE_NAME . ' Team</strong></p>';
        sendMail($front['email'], 'Payment Confirmed - Order #' . $orderId . ' - ' . SITE_NAME, emailTemplate('Payment Confirmed', $userBody));

        $adminBody = '
            <p style="font-size:17px;font-weight:bold;color:#1a1a2e;">Payment Received for Order #' . $orderId . '</p>
            <p>Customer <strong>' . $fullName . '</strong> (' . $front['email'] . ') has made a payment of <strong>' . $total . '</strong> via <strong>' . $methodLabel . '</strong>.</p>
            <p style="text-align:center;">
                <a href="' . BASE_URL . '/admin-orders/edit/' . $orderId . '" style="display:inline-block;background:#1a1a2e;color:#ffffff;padding:12px 28px;border-radius:5px;text-decoration:none;font-weight:bold;">View in Admin</a>
            </p>';
        sendMail(ADMIN_EMAIL, 'Payment Received - Order #' . $orderId . ' - ' . SITE_NAME, emailTemplate('Payment Received', $adminBody));
    }
}
