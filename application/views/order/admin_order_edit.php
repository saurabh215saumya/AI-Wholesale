<div class="content-wrapper">
<?php echo $this->session->flashdata('response'); ?>
<section class="content-header">
  <h1>Manage Order #<?php echo $order['id']; ?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo base_url('admin-orders'); ?>">Orders</a></li>
    <li class="active">Order #<?php echo $order['id']; ?></li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-header with-border"><h3 class="box-title">Order Items</h3></div>
        <div class="box-body">
          <table class="table table-bordered">
            <thead><tr><th>Product</th><th>Qty</th><th>Amount</th></tr></thead>
            <tbody>
            <?php foreach($items as $item): ?>
            <tr>
              <td><?php echo htmlspecialchars($item['product_name']); ?></td>
              <td><?php echo $item['quantity']; ?></td>
              <td>€<?php echo number_format($item['amount'],2); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="box box-warning">
        <div class="box-header with-border"><h3 class="box-title">Update Charges & Confirm Order</h3></div>
        <div class="box-body">
          <form method="post" action="<?php echo base_url('admin-orders/update/'.$order['id']); ?>">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Shipping Charge (€)</label>
                  <input type="number" step="0.01" min="0" name="shipping_charge" class="form-control" value="<?php echo $order['shipping_charge']; ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Other Charges (€)</label>
                  <input type="number" step="0.01" min="0" name="other_charges" class="form-control" value="<?php echo $order['other_charges']; ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Updated Total (€)</label>
                  <input type="number" step="0.01" min="0" name="total_amount" class="form-control" value="<?php echo $order['total_amount']; ?>" id="totalField">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Admin Notes</label>
              <textarea name="admin_notes" class="form-control" rows="3"><?php echo htmlspecialchars($order['admin_notes'] ?? ''); ?></textarea>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Order Status</label>
                  <select name="status" class="form-control">
                    <option value="0" <?php echo $order['status']==0?'selected':''; ?>>In Review</option>
                    <option value="1" <?php echo $order['status']==1?'selected':''; ?>>Confirmed</option>
                    <option value="2" <?php echo $order['status']==2?'selected':''; ?>>Cancelled</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Payment Status</label>
                  <select name="payment_status" class="form-control">
                    <option value="0" <?php echo $order['payment_status']==0?'selected':''; ?>>Unpaid</option>
                    <option value="1" <?php echo $order['payment_status']==1?'selected':''; ?>>Paid</option>
                  </select>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
            <?php if($order['status'] != 1): ?>
            <button type="submit" name="confirm_order" value="1" class="btn btn-success" style="margin-left:10px;"
              onclick="return confirm('Confirm this order and notify the customer?');">
              <i class="fa fa-check"></i> Confirm Order & Notify
            </button>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="box box-default">
        <div class="box-header with-border"><h3 class="box-title">Customer Info</h3></div>
        <div class="box-body">
          <p><strong>Name:</strong> <?php echo htmlspecialchars($user['first_name'].' '.$user['last_name']); ?></p>
          <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
          <p><strong>Mobile:</strong> <?php echo htmlspecialchars($user['mobile'] ?? '-'); ?></p>
          <p><strong>Company:</strong> <?php echo htmlspecialchars($user['company_name'] ?? '-'); ?></p>
        </div>
      </div>
      <div class="box box-default">
        <div class="box-header with-border"><h3 class="box-title">Order Summary</h3></div>
        <div class="box-body">
          <p><strong>Order #:</strong> <?php echo $order['id']; ?></p>
          <p><strong>Transaction:</strong> <?php echo $order['transaction_no'] ?: '-'; ?></p>
          <p><strong>Payment Method:</strong> <?php echo ucfirst($order['payment_method']); ?></p>
          <p><strong>Pay Amount:</strong> €<?php echo number_format($order['pay_amount'],2); ?></p>
          <p><strong>Shipping:</strong> €<?php echo number_format($order['shipping_charge'],2); ?></p>
          <p><strong>Other:</strong> €<?php echo number_format($order['other_charges'],2); ?></p>
          <p><strong>Total:</strong> <span style="font-size:16px;font-weight:700;color:#c8a951;">€<?php echo number_format($order['total_amount'],2); ?></span></p>
          <p><strong>Date:</strong> <?php echo date('d M Y H:i', strtotime($order['addedOn'])); ?></p>
          <?php if(!empty($order['comment'])): ?>
          <p><strong>Customer Note:</strong> <?php echo htmlspecialchars($order['comment']); ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<script>
// Auto-recalculate total when charges change
$(function(){
  var payAmount = <?php echo floatval($order['pay_amount']); ?>;
  $('input[name="shipping_charge"], input[name="other_charges"]').on('input', function(){
    var s = parseFloat($('input[name="shipping_charge"]').val()) || 0;
    var o = parseFloat($('input[name="other_charges"]').val()) || 0;
    $('#totalField').val((payAmount + s + o).toFixed(2));
  });
});
</script>
