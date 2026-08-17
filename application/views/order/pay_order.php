<section class="page-header mb-lg" style="background:linear-gradient(135deg,#fff5f0,#fff);border-bottom:2px solid #ffe5d0;">
  <div class="container">
    <h1 style="font-size:22px;font-weight:700;color:#222;margin:0 0 6px;">Pay for Order #<?php echo $order['id']; ?></h1>
    <ul class="breadcrumb" style="background:none;padding:0;margin:0;">
      <li><a href="<?php echo base_url(); ?>" style="color:#ff6000;">Home</a></li>
      <li><a href="<?php echo base_url('my-orders'); ?>" style="color:#ff6000;">My Orders</a></li>
      <li class="active">Pay Order</li>
    </ul>
  </div>
</section>

<div class="container" style="padding:40px 15px 60px;">
  <div class="row">
    <div class="col-md-7">
      <div style="background:#fff;border:1px solid #ffe5d0;border-radius:14px;padding:28px;">
        <h4 style="font-weight:700;margin:0 0 20px;color:#222;">Order Summary</h4>
        <table style="width:100%;border-collapse:collapse;font-size:14px;margin-bottom:20px;">
          <thead>
            <tr style="background:#1a1a2e;color:#fff;">
              <th style="padding:10px;text-align:left;border:1px solid #ddd;">Product</th>
              <th style="padding:10px;text-align:center;border:1px solid #ddd;">Qty</th>
              <th style="padding:10px;text-align:right;border:1px solid #ddd;">Amount</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($items as $item): ?>
          <tr>
            <td style="padding:10px;border:1px solid #ddd;"><?php echo htmlspecialchars($item['product_name']); ?></td>
            <td style="padding:10px;text-align:center;border:1px solid #ddd;"><?php echo $item['quantity']; ?></td>
            <td style="padding:10px;text-align:right;border:1px solid #ddd;">£<?php echo number_format($item['amount'],2); ?></td>
          </tr>
          <?php endforeach; ?>
          <tr style="background:#f9f9f9;">
            <td colspan="2" style="padding:10px;border:1px solid #ddd;">Subtotal (ex. VAT)</td>
            <td style="padding:10px;text-align:right;border:1px solid #ddd;">£<?php echo number_format($order['pay_amount'],2); ?></td>
          </tr>
          <tr style="background:#f9f9f9;">
            <td colspan="2" style="padding:10px;border:1px solid #ddd;">VAT (20%)</td>
            <td style="padding:10px;text-align:right;border:1px solid #ddd;">£<?php echo number_format($order['vat_amount'],2); ?></td>
          </tr>
          <?php if(!empty($order['discount']) && $order['discount'] > 0): ?>
          <tr style="background:#fff8f5;">
            <td colspan="2" style="padding:10px;border:1px solid #ddd;color:#e74c3c;">Discount</td>
            <td style="padding:10px;text-align:right;border:1px solid #ddd;color:#e74c3c;">-£<?php echo number_format($order['discount'],2); ?></td>
          </tr>
          <?php endif; ?>
          <tr style="background:#f9f9f9;">
            <td colspan="2" style="padding:10px;border:1px solid #ddd;">Shipping</td>
            <td style="padding:10px;text-align:right;border:1px solid #ddd;">£<?php echo number_format($order['shipping_charge'],2); ?></td>
          </tr>
          <?php if(!empty($order['other_charges']) && $order['other_charges'] > 0): ?>
          <tr style="background:#f9f9f9;">
            <td colspan="2" style="padding:10px;border:1px solid #ddd;">Other Charges</td>
            <td style="padding:10px;text-align:right;border:1px solid #ddd;">£<?php echo number_format($order['other_charges'],2); ?></td>
          </tr>
          <?php endif; ?>
          <tr>
            <td colspan="2" style="padding:10px;border:1px solid #ddd;font-weight:700;">Total (inc. VAT)</td>
            <td style="padding:10px;text-align:right;border:1px solid #ddd;font-weight:700;color:#c8a951;font-size:16px;">£<?php echo number_format($order['total_amount'],2); ?></td>
          </tr>
          </tbody>
        </table>

        <?php if(!empty($order['admin_notes'])): ?>
        <div style="background:#fff8f5;border:1px solid #ffe0cc;border-radius:8px;padding:14px;margin-bottom:20px;">
          <strong style="color:#ff6000;"><i class="fa fa-info-circle"></i> Admin Note:</strong>
          <p style="margin:6px 0 0;color:#555;font-size:14px;"><?php echo htmlspecialchars($order['admin_notes']); ?></p>
        </div>
        <?php endif; ?>

        <!-- Payment Options -->
        <h4 style="font-weight:700;margin:0 0 16px;color:#222;">Choose Payment Method</h4>

        <div style="display:flex;gap:12px;margin-bottom:20px;">
          <label id="pm-offline-label" onclick="selectPM('offline')" style="flex:1;border:2px solid #ff6000;border-radius:8px;padding:14px;cursor:pointer;background:#fff8f5;">
            <input type="radio" name="pay_method" value="offline" checked style="accent-color:#ff6000;">
            <strong style="color:#ff6000;"><i class="fa fa-money"></i> Offline Payment</strong>
            <div style="font-size:12px;color:#888;margin-top:4px;">Bank transfer / cash on delivery</div>
          </label>
          <label id="pm-online-label" onclick="selectPM('online')" style="flex:1;border:2px solid #ddd;border-radius:8px;padding:14px;cursor:pointer;background:#fff;">
            <input type="radio" name="pay_method" value="online" style="accent-color:#ff6000;">
            <strong style="color:#555;"><i class="fa fa-credit-card"></i> Online Payment</strong>
            <div style="font-size:12px;color:#888;margin-top:4px;">Pay securely with card via Stripe</div>
          </label>
        </div>

        <!-- Offline Section -->
        <div id="offline-section">
          <div style="background:#fff8f5;border:1px solid #ffe0cc;border-radius:8px;padding:14px;margin-bottom:16px;">
            <p style="margin:0;font-size:14px;color:#555;"><i class="fa fa-info-circle" style="color:#ff6000;"></i> Our team will contact you with bank transfer details. Once payment is received, your order will be processed.</p>
          </div>
          <button onclick="submitOfflinePayment()" class="btn btn-warning btn-block" style="font-weight:700;font-size:15px;padding:14px;">
            <i class="fa fa-check"></i> Confirm Offline Payment Intent
          </button>
        </div>

        <!-- Online Section -->
        <div id="online-section" style="display:none;">
          <div style="border:1px solid #ddd;border-radius:8px;padding:14px;margin-bottom:16px;background:#fafafa;">
            <div id="stripe-card-element"></div>
            <div id="stripe-card-errors" style="color:#e44;font-size:13px;margin-top:8px;"></div>
          </div>
          <button id="stripe-pay-btn" class="btn btn-success btn-block" style="font-weight:700;font-size:15px;padding:14px;">
            <i class="fa fa-lock"></i> Pay £<?php echo number_format($order['total_amount'],2); ?> Securely
          </button>
          <p style="text-align:center;font-size:12px;color:#aaa;margin-top:8px;"><i class="fa fa-shield"></i> SSL Encrypted · Powered by Stripe</p>
        </div>

        <!-- Payment Logger -->
        <div id="pay-logger" style="display:none;margin-top:20px;background:#1a1a2e;border-radius:8px;padding:16px;font-size:13px;color:#ccc;font-family:monospace;line-height:2;"></div>
      </div>
    </div>
  </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
var stripe, cardElement;
var ORDER_ID = <?php echo (int)$order['id']; ?>;
var ORDER_TOTAL = <?php echo floatval($order['total_amount']); ?>;

function selectPM(method) {
  var ol = document.getElementById('pm-offline-label');
  var nl = document.getElementById('pm-online-label');
  var os = document.getElementById('offline-section');
  var ns = document.getElementById('online-section');
  if (method === 'offline') {
    document.querySelector('input[value="offline"]').checked = true;
    ol.style.borderColor='#ff6000'; ol.style.background='#fff8f5';
    nl.style.borderColor='#ddd';    nl.style.background='#fff';
    os.style.display='block'; ns.style.display='none';
  } else {
    document.querySelector('input[value="online"]').checked = true;
    nl.style.borderColor='#ff6000'; nl.style.background='#fff8f5';
    ol.style.borderColor='#ddd';    ol.style.background='#fff';
    os.style.display='none'; ns.style.display='block';
  }
}

function showLogger(msg) {
  var el = document.getElementById('pay-logger');
  el.style.display = 'block';
  el.innerHTML += '<div><i class="fa fa-circle-o-notch fa-spin" style="color:#ff6000;margin-right:6px;"></i>' + msg + '</div>';
}
function loggerDone(msg) {
  var el = document.getElementById('pay-logger');
  el.innerHTML += '<div><i class="fa fa-check-circle" style="color:#28a745;margin-right:6px;"></i>' + msg + '</div>';
}
function loggerError(msg) {
  var el = document.getElementById('pay-logger');
  el.innerHTML += '<div><i class="fa fa-times-circle" style="color:#e44;margin-right:6px;"></i>' + msg + '</div>';
}

function submitOfflinePayment() {
  if (!confirm('Confirm offline payment intent for this order?')) return;
  showLogger('Submitting offline payment confirmation...');
  $.post(BASE_URL + '/order/confirm_offline_payment', {order_id: ORDER_ID}, function(res) {
    var r = typeof res === 'string' ? JSON.parse(res) : res;
    if (r.status === 'success') {
      loggerDone('Confirmed! Redirecting to your orders...');
      setTimeout(function(){ window.location = BASE_URL + '/my-orders?payment=confirmed'; }, 800);
    } else {
      loggerError('Something went wrong. Please try again.');
    }
  });
}

document.addEventListener('DOMContentLoaded', function() {
  stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');
  var elements = stripe.elements();
  cardElement = elements.create('card', {hidePostalCode:true, style:{base:{fontSize:'15px',color:'#333'}}});
  cardElement.mount('#stripe-card-element');
  cardElement.on('change', function(e){
    document.getElementById('stripe-card-errors').textContent = e.error ? e.error.message : '';
  });

  document.getElementById('stripe-pay-btn').addEventListener('click', function() {
    var btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    showLogger('Connecting to payment gateway...');
    stripe.createToken(cardElement).then(function(result) {
      if (result.error) {
        document.getElementById('stripe-card-errors').textContent = result.error.message;
        loggerError('Card error: ' + result.error.message);
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-lock"></i> Pay £' + ORDER_TOTAL.toFixed(2) + ' Securely';
        return;
      }
      showLogger('Card tokenised. Authorising payment...');
      $.post(BASE_URL + '/order/stripe_order_payment', {
        order_id: ORDER_ID,
        stripe_token: result.token.id
      }, function(res) {
        var r = typeof res === 'string' ? JSON.parse(res) : res;
        if (r.status === 'success') {
          loggerDone('Payment authorised successfully!');
          showLogger('Sending confirmation emails...');
          loggerDone('All done! Redirecting...');
          setTimeout(function(){ window.location = BASE_URL + '/my-orders?payment=success'; }, 1200);
        } else {
          loggerError('Payment failed: ' + (r.msg || 'Unknown error'));
          btn.disabled = false;
          btn.innerHTML = '<i class="fa fa-lock"></i> Pay £' + ORDER_TOTAL.toFixed(2) + ' Securely';
        }
      });
    });
  });
});
</script>
