<div style="background:#f8f9fa;padding:30px 0;border-bottom:1px solid #eee;">
  <div class="container">
    <h2>Checkout</h2>
    <ol class="breadcrumb" style="background:none;padding:0;margin:0;">
      <li><a href="<?php echo base_url(); ?>">Home</a></li>
      <li><a href="<?php echo base_url('cart-list'); ?>">Cart</a></li>
      <li class="active">Checkout</li>
    </ol>
  </div>
</div>

<div class="container" style="padding:40px 15px;">
  <div class="row">
    <div class="col-md-7">
      <h4 style="font-weight:700;margin-bottom:20px;">Billing Address</h4>
      <?php if(!empty($billingArr)): ?>
      <div style="margin-bottom:20px;">
        <?php foreach($billingArr as $i => $b): ?>
        <div style="border:1px solid #ddd;border-radius:6px;padding:15px;margin-bottom:10px;cursor:pointer;" onclick="document.getElementById('billing_address_id').value=<?php echo $b['id']; ?>;document.querySelectorAll('.billing-card').forEach(el=>el.style.borderColor='#ddd');this.style.borderColor='#667eea';" class="billing-card">
          <input type="radio" name="billing_sel" value="<?php echo $b['id']; ?>" <?php echo $i==0?'checked':''; ?> style="margin-right:8px;">
          <strong><?php echo $b['first_name'].' '.$b['last_name']; ?></strong>
          <p style="margin:5px 0 0;color:#666;font-size:13px;"><?php echo $b['address_1'].', '.$b['city'].', '.$b['postal_code'].', '.$b['country']; ?></p>
        </div>
        <?php endforeach; ?>
        <a href="<?php echo base_url('billing-address'); ?>" class="btn btn-default btn-sm">+ Add New Address</a>
      </div>
      <?php else: ?>
      <div class="alert alert-warning">No billing address found. <a href="<?php echo base_url('billing-address'); ?>">Add one now</a>.</div>
      <?php endif; ?>

      <h4 style="font-weight:700;margin:25px 0 15px;">Payment Method</h4>
      <div style="border:1px solid #ddd;border-radius:6px;padding:15px;">
        <label style="display:block;margin-bottom:10px;cursor:pointer;">
          <input type="radio" name="payment_method_sel" value="cod" checked style="margin-right:8px;"> Cash on Delivery
        </label>
        <label style="display:block;cursor:pointer;">
          <input type="radio" name="payment_method_sel" value="bank_transfer" style="margin-right:8px;"> Bank Transfer
        </label>
      </div>
    </div>

    <div class="col-md-5">
      <div style="background:#f8f9fa;border:1px solid #eee;border-radius:8px;padding:20px;">
        <h5 style="font-weight:700;border-bottom:1px solid #ddd;padding-bottom:10px;">Order Total</h5>
        <table class="table table-condensed">
          <tr><td>Subtotal</td><td class="text-right">£<?php echo number_format($subTotal,2); ?></td></tr>
          <tr><td>Shipping</td><td class="text-right">Free</td></tr>
          <tr style="font-weight:700;font-size:16px;"><td>Total</td><td class="text-right">£<?php echo number_format($subTotal,2); ?></td></tr>
        </table>
        <input type="hidden" id="billing_address_id" value="<?php echo !empty($billingArr) ? $billingArr[0]['id'] : ''; ?>">
        <button id="place-order-btn" class="btn btn-primary btn-block btn-lg" <?php echo empty($billingArr)?'disabled':''; ?>>Place Order</button>
      </div>
    </div>
  </div>
</div>

<script>
$('#place-order-btn').on('click', function() {
  var billingId = $('#billing_address_id').val();
  var payMethod = $('input[name="payment_method_sel"]:checked').val();
  if (!billingId) { alert('Please select a billing address.'); return; }
  $(this).prop('disabled', true).text('Processing...');
  $.post(BASE_URL + '/product/place_user_order_item', {billing_address_id: billingId, payment_method: payMethod}, function(res) {
    if (res === 'login') { window.location = BASE_URL + '/sign-in'; return; }
    if (res === 'error') { alert('Something went wrong. Please try again.'); $('#place-order-btn').prop('disabled',false).text('Place Order'); return; }
    window.location = BASE_URL + '/order/order_summary/' + res;
  });
});
</script>
