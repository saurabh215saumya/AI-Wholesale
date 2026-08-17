<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_orders extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('user/login');
    }

    public function index() {
        $data['orders'] = $this->db
            ->select('o.*, u.first_name, u.last_name, u.email, COUNT(oi.id) as item_count')
            ->from('tbl_order o')
            ->join('tbl_users u', 'u.id = o.user_id', 'left')
            ->join('tbl_order_item oi', 'oi.order_id = o.id', 'left')
            ->group_by('o.id')
            ->order_by('o.id', 'DESC')
            ->get()->result_array();
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('order/admin_orders', $data);
        $this->load->view('template/admin_footer');
    }

    public function edit($id) {
        $data['order'] = $this->db->where('id', $id)->get('tbl_order')->row_array();
        if (empty($data['order'])) redirect('admin-orders');
        $data['user']  = $this->db->where('id', $data['order']['user_id'])->get('tbl_users')->row_array();
        $data['items'] = $this->db->select('toi.id as item_id, toi.quantity, toi.amount, tp.product_name, tp.id as product_id')
            ->from('tbl_order_item toi')
            ->join('tbl_products tp', 'tp.id = toi.product_id', 'left')
            ->where('toi.order_id', $id)
            ->get()->result_array();
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('order/admin_order_edit', $data);
        $this->load->view('template/admin_footer');
    }

    public function update($id) {
        $order = $this->db->where('id', $id)->get('tbl_order')->row_array();
        if (empty($order)) redirect('admin-orders');

        $shipping     = floatval($this->input->post('shipping_charge'));
        $other        = floatval($this->input->post('other_charges'));
        $discount     = floatval($this->input->post('discount'));
        $total        = floatval($this->input->post('total_amount'));
        $status       = (int)$this->input->post('status');
        $payStatus    = (int)$this->input->post('payment_status');
        $adminNotes   = $this->input->post('admin_notes');
        $confirmOrder = $this->input->post('confirm_order');

        // Detect transitions before saving
        $wasConfirmed = ($order['status'] == 1);
        $wasPaid      = ($order['payment_status'] == 1);
        $nowConfirmed = ($status == 1 || $confirmOrder == '1');
        $nowPaid      = ($payStatus == 1);

        $update = [
            'shipping_charge' => $shipping,
            'other_charges'   => $other,
            'discount'        => $discount,
            'total_amount'    => $total,
            'status'          => $confirmOrder == '1' ? 1 : $status,
            'payment_status'  => $payStatus,
            'admin_notes'     => $adminNotes,
            'order_confirmed' => $nowConfirmed ? 1 : 0,
            'updatedOn'       => date('Y-m-d H:i:s'),
        ];

        $this->db->where('id', $id)->update('tbl_order', $update);

        // Send order confirmed notification (only on transition to confirmed)
        if (!$wasConfirmed && $nowConfirmed) {
            $this->_sendOrderConfirmedEmail($id);
        }

        // Send payment received notification (only on transition to paid)
        if (!$wasPaid && $nowPaid) {
            $this->_sendPaymentReceivedEmail($id);
        }

        $this->session->set_flashdata('response', '<div class="alert alert-success">Order updated successfully.</div>');
        redirect('admin-orders/edit/' . $id);
    }

    public function update_item_qty($order_id) {
        $item_id  = (int)$this->input->post('item_id');
        $quantity = max(1, (int)$this->input->post('quantity'));
        $item = $this->db->where('id', $item_id)->where('order_id', $order_id)->get('tbl_order_item')->row_array();
        if (!$item) { echo json_encode(['status'=>'error']); return; }
        $unit_price = $item['quantity'] > 0 ? $item['amount'] / $item['quantity'] : 0;
        $new_amount = round($unit_price * $quantity, 2);
        $this->db->where('id', $item_id)->update('tbl_order_item', ['quantity'=>$quantity,'amount'=>$new_amount]);
        // Recalculate order totals
        $items     = $this->db->select('amount')->where('order_id', $order_id)->get('tbl_order_item')->result_array();
        $subTotal  = array_sum(array_column($items, 'amount'));
        $vatAmount = round($subTotal * 0.20, 2);
        $order     = $this->db->where('id', $order_id)->get('tbl_order')->row_array();
        $discount  = floatval($order['discount'] ?? 0);
        $total     = round($subTotal + $vatAmount - $discount + floatval($order['shipping_charge']) + floatval($order['other_charges']), 2);
        $total     = max(0, $total);
        $this->db->where('id', $order_id)->update('tbl_order', ['pay_amount'=>$subTotal,'vat_amount'=>$vatAmount,'total_amount'=>$total]);
        echo json_encode(['status'=>'ok','sub_total'=>$subTotal,'vat_amount'=>$vatAmount,'total'=>$total,'item_amount'=>$new_amount]);
    }

    private function _sendOrderConfirmedEmail($orderId) {
        $order = $this->db->where('id', $orderId)->get('tbl_order')->row_array();
        if (!$order) return;
        $user  = $this->db->where('id', $order['user_id'])->get('tbl_users')->row_array();
        if (!$user) return;

        $items = $this->db->select('toi.quantity, toi.amount, tp.product_name')
            ->from('tbl_order_item toi')
            ->join('tbl_products tp', 'tp.id = toi.product_id', 'left')
            ->where('toi.order_id', $orderId)
            ->get()->result_array();

        $itemRows = '';
        foreach ($items as $item) {
            $itemRows .= '<tr>
                <td style="border:1px solid #ddd;padding:10px;">' . htmlspecialchars($item['product_name']) . '</td>
                <td style="border:1px solid #ddd;padding:10px;text-align:center;">' . $item['quantity'] . '</td>
                <td style="border:1px solid #ddd;padding:10px;text-align:right;">£' . number_format($item['amount'], 2) . '</td>
            </tr>';
        }

        $fullName = trim($user['first_name'] . ' ' . $user['last_name']);
        $total    = '£' . number_format($order['total_amount'], 2);

        $chargesTable = '<table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;font-size:14px;margin-bottom:16px;">
            <tr style="background:#1a1a2e;color:#fff;">
                <th style="border:1px solid #ddd;padding:10px;text-align:left;">Product</th>
                <th style="border:1px solid #ddd;padding:10px;text-align:center;">Qty</th>
                <th style="border:1px solid #ddd;padding:10px;text-align:right;">Amount</th>
            </tr>
            ' . $itemRows . '
            <tr style="background:#f9f9f9;">
                <td colspan="2" style="border:1px solid #ddd;padding:10px;">Shipping</td>
                <td style="border:1px solid #ddd;padding:10px;text-align:right;">£' . number_format($order['shipping_charge'], 2) . '</td>
            </tr>
            <tr style="background:#f9f9f9;">
                <td colspan="2" style="border:1px solid #ddd;padding:10px;">Other Charges</td>
                <td style="border:1px solid #ddd;padding:10px;text-align:right;">£' . number_format($order['other_charges'], 2) . '</td>
            </tr>
            <tr>
                <td colspan="2" style="border:1px solid #ddd;padding:10px;font-weight:bold;">Total</td>
                <td style="border:1px solid #ddd;padding:10px;text-align:right;font-weight:bold;color:#c8a951;font-size:16px;">' . $total . '</td>
            </tr>
        </table>';

        $adminNote = !empty($order['admin_notes'])
            ? '<div style="background:#fff8f5;border-left:4px solid #ff6000;padding:12px 16px;border-radius:4px;margin-bottom:16px;"><strong>Note from Admin:</strong><br>' . htmlspecialchars($order['admin_notes']) . '</div>'
            : '';

        // Email to user
        $userBody = '
            <p style="font-size:17px;font-weight:bold;color:#1a1a2e;">Your Order is Confirmed, ' . $fullName . '!</p>
            <p style="background:#e8f5e9;border-left:4px solid #4caf50;padding:12px 16px;border-radius:4px;">
                Order <strong>#' . $orderId . '</strong> has been confirmed. Please log in to your account to make the payment.
            </p>
            ' . $adminNote . '
            ' . $chargesTable . '
            <p style="text-align:center;">
                <a href="' . BASE_URL . '/order/pay/' . $orderId . '" style="display:inline-block;background:#c8a951;color:#ffffff;padding:12px 28px;border-radius:5px;text-decoration:none;font-weight:bold;font-size:15px;">Pay Now</a>
                &nbsp;
                <a href="' . BASE_URL . '/my-orders" style="display:inline-block;background:#1a1a2e;color:#ffffff;padding:12px 28px;border-radius:5px;text-decoration:none;font-weight:bold;font-size:15px;">View My Orders</a>
            </p>
            <p>Regards,<br><strong>' . SITE_NAME . ' Team</strong></p>';
        sendMail($user['email'], 'Order Confirmed - #' . $orderId . ' - ' . SITE_NAME, emailTemplate('Order Confirmed', $userBody));

        // Email to admin
        $adminBody = '
            <p style="font-size:17px;font-weight:bold;color:#1a1a2e;">Order #' . $orderId . ' Confirmed</p>
            <p>You have confirmed order <strong>#' . $orderId . '</strong> for customer <strong>' . $fullName . '</strong>.</p>
            <p>Total: <strong>' . $total . '</strong></p>
            <p style="text-align:center;">
                <a href="' . BASE_URL . '/admin-orders/edit/' . $orderId . '" style="display:inline-block;background:#1a1a2e;color:#ffffff;padding:12px 28px;border-radius:5px;text-decoration:none;font-weight:bold;">View in Admin</a>
            </p>';
        sendMail(ADMIN_EMAIL, 'Order Confirmed #' . $orderId . ' - ' . SITE_NAME, emailTemplate('Order Confirmed', $adminBody));
    }

    private function _sendPaymentReceivedEmail($orderId) {
        $order = $this->db->where('id', $orderId)->get('tbl_order')->row_array();
        if (!$order) return;
        $user  = $this->db->where('id', $order['user_id'])->get('tbl_users')->row_array();
        if (!$user) return;

        $fullName = trim($user['first_name'] . ' ' . $user['last_name']);
        $total    = '£' . number_format($order['total_amount'], 2);
        $method   = ucfirst($order['payment_method']);

        // Email to user
        $userBody = '
            <p style="font-size:17px;font-weight:bold;color:#1a1a2e;">Payment Confirmed, ' . $fullName . '!</p>
            <p style="background:#e8f5e9;border-left:4px solid #4caf50;padding:12px 16px;border-radius:4px;">
                Your payment of <strong>' . $total . '</strong> for Order <strong>#' . $orderId . '</strong> has been marked as <strong>Paid</strong> by our team.
            </p>
            <p>Payment Method: <strong>' . $method . '</strong></p>
            <p style="text-align:center;">
                <a href="' . BASE_URL . '/my-orders" style="display:inline-block;background:#c8a951;color:#ffffff;padding:12px 28px;border-radius:5px;text-decoration:none;font-weight:bold;font-size:15px;">View My Orders</a>
            </p>
            <p>Regards,<br><strong>' . SITE_NAME . ' Team</strong></p>';
        sendMail($user['email'], 'Payment Confirmed - Order #' . $orderId . ' - ' . SITE_NAME, emailTemplate('Payment Confirmed', $userBody));

        // Email to admin
        $adminBody = '
            <p style="font-size:17px;font-weight:bold;color:#1a1a2e;">Payment Marked as Paid - Order #' . $orderId . '</p>
            <p>Order <strong>#' . $orderId . '</strong> for customer <strong>' . $fullName . '</strong> has been marked as <strong>Paid</strong>.</p>
            <p>Amount: <strong>' . $total . '</strong> &nbsp;|&nbsp; Method: <strong>' . $method . '</strong></p>
            <p style="text-align:center;">
                <a href="' . BASE_URL . '/admin-orders/edit/' . $orderId . '" style="display:inline-block;background:#1a1a2e;color:#ffffff;padding:12px 28px;border-radius:5px;text-decoration:none;font-weight:bold;">View in Admin</a>
            </p>';
        sendMail(ADMIN_EMAIL, 'Payment Received - Order #' . $orderId . ' - ' . SITE_NAME, emailTemplate('Payment Received', $adminBody));
    }
}
