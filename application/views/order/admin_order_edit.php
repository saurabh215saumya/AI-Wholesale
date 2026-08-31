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
            <thead><tr><th>Product</th><th>Qty</th><th>Amount (ex. VAT)</th></tr></thead>
            <tbody>
            <?php foreach($items as $item):
                $unitPrice = $item['quantity'] > 0 ? $item['amount'] / $item['quantity'] : 0;
            ?>
            <tr id="item-row-<?php echo $item['item_id']; ?>">
              <td><?php echo htmlspecialchars($item['product_name']); ?></td>
              <td>
                <div class="input-group" style="width:120px;">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-xs btn-default" onclick="changeItemQty(<?php echo $item['item_id']; ?>, <?php echo $order['id']; ?>, -1)">-</button>
                  </span>
                  <input type="number" class="form-control input-sm item-qty" id="qty-<?php echo $item['item_id']; ?>"
                    value="<?php echo $item['quantity']; ?>" min="1"
                    data-item-id="<?php echo $item['item_id']; ?>"
                    data-order-id="<?php echo $order['id']; ?>">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-xs btn-default" onclick="changeItemQty(<?php echo $item['item_id']; ?>, <?php echo $order['id']; ?>, 1)">+</button>
                  </span>
                </div>
              </td>
              <td id="amt-<?php echo $item['item_id']; ?>">£<?php echo number_format($item['amount'],2); ?></td>
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
              <div class="col-md-3">
                <div class="form-group">
                  <label>Discount (£)</label>
                  <input type="number" step="0.01" min="0" name="discount" class="form-control" value="<?php echo $order['discount'] ?? 0; ?>" id="discountField">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Shipping Charge (£)</label>
                  <input type="number" step="0.01" min="0" name="shipping_charge" class="form-control" value="<?php echo $order['shipping_charge']; ?>" id="shippingField">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Other Charges (£)</label>
                  <input type="number" step="0.01" min="0" name="other_charges" class="form-control" value="<?php echo $order['other_charges']; ?>" id="otherField">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Updated Total (£)</label>
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
          <p><strong>Subtotal (ex. VAT):</strong> <span id="summary-subtotal"><?php echo '£'.number_format($order['pay_amount'],2); ?></span></p>
          <p><strong>VAT (20%):</strong> <span id="summary-vat"><?php echo '£'.number_format($order['vat_amount'],2); ?></span></p>
          <p><strong>Discount:</strong> <span id="summary-discount" style="color:#e74c3c;">-<?php echo '£'.number_format($order['discount'] ?? 0,2); ?></span></p>
          <p><strong>Shipping:</strong> <?php echo '£'.number_format($order['shipping_charge'],2); ?></p>
          <p><strong>Other:</strong> <?php echo '£'.number_format($order['other_charges'],2); ?></p>
          <p><strong>Total (inc. VAT):</strong> <span id="summary-total" style="font-size:16px;font-weight:700;color:#c8a951;"><?php echo '£'.number_format($order['total_amount'],2); ?></span></p>
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
var BASE_URL_ADMIN = '<?php echo base_url(); ?>';

function recalcTotal() {
    var subTotal  = parseFloat($('#summary-subtotal').text().replace('£','')) || 0;
    var vatAmount = parseFloat($('#summary-vat').text().replace('£','')) || 0;
    var discount  = parseFloat($('#discountField').val()) || 0;
    var shipping  = parseFloat($('#shippingField').val()) || 0;
    var other     = parseFloat($('#otherField').val()) || 0;
    var total     = Math.max(0, subTotal + vatAmount - discount + shipping + other);
    $('#totalField').val(total.toFixed(2));
    $('#summary-discount').text('-£' + discount.toFixed(2));
    $('#summary-total').text('£' + total.toFixed(2));
}

$('#discountField, #shippingField, #otherField').on('input', recalcTotal);

function changeItemQty(itemId, orderId, delta) {
    var $input = $('#qty-' + itemId);
    var newQty = Math.max(1, (parseInt($input.val()) || 1) + delta);
    $input.val(newQty);
    updateItemQty(itemId, orderId, newQty);
}

$('.item-qty').on('change', function() {
    var itemId  = $(this).data('item-id');
    var orderId = $(this).data('order-id');
    var qty     = Math.max(1, parseInt($(this).val()) || 1);
    $(this).val(qty);
    updateItemQty(itemId, orderId, qty);
});

function updateItemQty(itemId, orderId, qty) {
    $.post(BASE_URL_ADMIN + 'admin-orders/update_item_qty/' + orderId, {item_id: itemId, quantity: qty}, function(r) {
        if (r.status === 'ok') {
            $('#amt-' + itemId).text('£' + parseFloat(r.item_amount).toFixed(2));
            $('#summary-subtotal').text('£' + parseFloat(r.sub_total).toFixed(2));
            $('#summary-vat').text('£' + parseFloat(r.vat_amount).toFixed(2));
            recalcTotal();
        }
    }, 'json');
}
</script>
