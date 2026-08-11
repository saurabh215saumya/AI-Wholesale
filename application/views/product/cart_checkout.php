<?php
$billing  = !empty($billingArr) ? $billingArr[0] : [];
$fullName = !empty($billing) ? trim($billing['first_name'].' '.$billing['last_name']) : (isset($userInfo) ? trim($userInfo['first_name'].' '.$userInfo['last_name']) : '');
$email    = isset($userInfo) ? $userInfo['email'] : '';
?>
<?php
$addr1   = !empty($billing['address_1'])   ? htmlspecialchars($billing['address_1'])   : '';
$addr2   = !empty($billing['address_2'])   ? htmlspecialchars($billing['address_2'])   : '';
$city    = !empty($billing['city'])        ? htmlspecialchars($billing['city'])        : '';
$postal  = !empty($billing['postal_code']) ? htmlspecialchars($billing['postal_code']) : '';
$phone   = !empty($billing['contact'])     ? htmlspecialchars($billing['contact'])     : '';
$country = !empty($billing['country'])     ? $billing['country']                       : 'United Kingdom';
$countries = ['United Kingdom','United States','Canada','Australia','Germany','France','Other'];
?>

<div class="co-wrap">

  <!-- Progress Steps -->
  <div class="co-progress">
    <div class="co-step active" id="ps-1">
      <div class="co-step-circle" id="pc-1">1</div>
      <div class="co-step-label">Contact</div>
    </div>
    <div class="co-step-line" id="pl-1"></div>
    <div class="co-step" id="ps-2">
      <div class="co-step-circle" id="pc-2">2</div>
      <div class="co-step-label">Shipping</div>
    </div>
    <div class="co-step-line" id="pl-2"></div>
    <div class="co-step" id="ps-3">
      <div class="co-step-circle" id="pc-3">3</div>
      <div class="co-step-label">Review</div>
    </div>
  </div>

  <!-- Step 1: Contact -->
  <div class="co-card active" id="step-1">
    <div class="co-card-header">
      <div class="co-card-icon"><i class="fa fa-user"></i></div>
      <div><div class="co-card-title">Contact Information</div><div class="co-card-subtitle">We'll use this to send your order updates</div></div>
    </div>
    <div class="co-field">
      <label>Email Address <span class="req">*</span></label>
      <input type="email" id="co_email" placeholder="your@email.com" value="<?php echo htmlspecialchars($email); ?>">
    </div>
    <div class="co-row">
      <div class="co-field">
        <label>Full Name <span class="req">*</span></label>
        <input type="text" id="co_fullname" placeholder="John Doe" value="<?php echo htmlspecialchars($fullName); ?>">
      </div>
      <div class="co-field">
        <label>Phone Number</label>
        <input type="tel" id="co_phone" placeholder="+44 7000 000000" value="<?php echo $phone; ?>">
      </div>
    </div>
    <button class="co-btn-next" onclick="goStep(2)"><i class="fa fa-arrow-right"></i>&nbsp; Continue to Shipping</button>
  </div>

  <!-- Step 2: Shipping Address -->
  <div class="co-card" id="step-2">
    <div class="co-card-header">
      <div class="co-card-icon"><i class="fa fa-map-marker"></i></div>
      <div><div class="co-card-title">Shipping Address</div><div class="co-card-subtitle">Where should we deliver your order?</div></div>
    </div>
    <div class="co-field">
      <label>Address Line 1 <span class="req">*</span></label>
      <input type="text" id="co_addr1" placeholder="123 Main Street" value="<?php echo $addr1; ?>">
    </div>
    <div class="co-field">
      <label>Address Line 2</label>
      <input type="text" id="co_addr2" placeholder="Apartment, suite, etc. (optional)" value="<?php echo $addr2; ?>">
    </div>
    <div class="co-row">
      <div class="co-field">
        <label>City <span class="req">*</span></label>
        <input type="text" id="co_city" placeholder="London" value="<?php echo $city; ?>">
      </div>
      <div class="co-field">
        <label>County / State</label>
        <input type="text" id="co_state" placeholder="Greater London">
      </div>
    </div>
    <div class="co-row">
      <div class="co-field">
        <label>Postal Code <span class="req">*</span></label>
        <input type="text" id="co_postal" placeholder="SW1A 1AA" value="<?php echo $postal; ?>">
      </div>
      <div class="co-field">
        <label>Country</label>
        <select id="co_country">
          <?php foreach($countries as $c): ?>
          <option value="<?php echo $c; ?>" <?php echo $country===$c?'selected':''; ?>><?php echo $c; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="co-field">
      <label>Special Instructions</label>
      <textarea id="co_instructions" rows="2" placeholder="Leave at door, ring bell, etc."></textarea>
    </div>
    <button class="co-btn-next" onclick="goStep(3)"><i class="fa fa-arrow-right"></i>&nbsp; Review Order</button>
    <button class="co-btn-back" onclick="goStep(1)"><i class="fa fa-arrow-left"></i>&nbsp; Back</button>
  </div>

  <!-- Step 3: Review & Place Order -->
  <div class="co-card" id="step-3">
    <div class="co-card-header">
      <div class="co-card-icon"><i class="fa fa-check-square-o"></i></div>
      <div><div class="co-card-title">Review Your Order</div><div class="co-card-subtitle">Orders over €1000 qualify for free shipping</div></div>
    </div>

    <!-- Order Summary -->
    <div style="background:#fafafa;border-radius:10px;padding:14px 16px;margin-bottom:18px;">
      <div style="font-size:12px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Order Summary</div>
      <?php $netTotal = $subTotal / 1.20; $vatTotal = $subTotal - $netTotal; ?>
      <div class="co-summary-item"><span>Subtotal (ex. VAT)</span><span>€<?php echo number_format($netTotal,2); ?></span></div>
      <div class="co-summary-item"><span>VAT (20%)</span><span>€<?php echo number_format($vatTotal,2); ?></span></div>
      <div class="co-summary-item"><span>Shipping</span><span style="color:#28a745;font-weight:700;"><?php echo $subTotal >= 1000 ? 'FREE (over €1000)' : 'To be confirmed by admin'; ?></span></div>
      <div class="co-summary-total"><span>Total (inc. VAT)</span><span>€<?php echo number_format($subTotal,2); ?></span></div>
    </div>

    <div style="background:#fff8f5;border:1px solid #ffe0cc;border-radius:8px;padding:16px;margin-bottom:16px;">
      <p style="margin:0;font-size:14px;color:#555;"><i class="fa fa-info-circle" style="color:#ff6000;"></i>&nbsp; Your order will be reviewed by our team. We will update the final amount including any shipping charges within 24 hours. You can then make payment from your account.</p>
    </div>

    <button class="co-btn-pay" id="offline-place-btn" onclick="placeOfflineOrder()">
      <i class="fa fa-paper-plane"></i>&nbsp; Place Order for Review
    </button>

    <input type="hidden" id="billing_address_id" value="<?php echo !empty($billing['id']) ? $billing['id'] : ''; ?>">
    <button class="co-btn-back" onclick="goStep(2)" style="margin-top:10px;"><i class="fa fa-arrow-left"></i>&nbsp; Back</button>
  </div>

  <!-- Trust Bar -->
  <div class="co-trust">
    <div class="co-trust-item"><i class="fa fa-lock"></i> Secure Checkout</div>
    <div class="co-trust-item"><i class="fa fa-undo"></i> Easy Returns</div>
    <div class="co-trust-item"><i class="fa fa-headphones"></i> 24/7 Support</div>
    <div class="co-trust-item"><i class="fa fa-truck"></i> Fast Delivery</div>
  </div>

</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
var SUBTOTAL = <?php echo floatval($subTotal); ?>;
var currentStep = 1;

function goStep(n) {
    if (n > currentStep && !validateStep(currentStep)) return;
    document.getElementById('step-' + currentStep).classList.remove('active');
    for (var i = 1; i <= 3; i++) {
        var ps = document.getElementById('ps-' + i);
        var pc = document.getElementById('pc-' + i);
        ps.classList.remove('active','done');
        if (i < n) { ps.classList.add('done'); pc.innerHTML = '<i class="fa fa-check"></i>'; }
        else if (i === n) { ps.classList.add('active'); pc.textContent = i; }
        else { pc.textContent = i; }
        if (i < 3) {
            var pl = document.getElementById('pl-' + i);
            pl.classList.toggle('done', i < n);
        }
    }
    currentStep = n;
    document.getElementById('step-' + n).classList.add('active');
    window.scrollTo({top: document.querySelector('.co-wrap').offsetTop - 20, behavior: 'smooth'});
}

function validateStep(s) {
    if (s === 1) {
        var e = document.getElementById('co_email').value.trim();
        var nm = document.getElementById('co_fullname').value.trim();
        if (!e || !nm) { alert('Please enter your email and full name.'); return false; }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e)) { alert('Please enter a valid email address.'); return false; }
    }
    if (s === 2) {
        var a = document.getElementById('co_addr1').value.trim();
        var c = document.getElementById('co_city').value.trim();
        var p = document.getElementById('co_postal').value.trim();
        if (!a || !c || !p) { alert('Please fill in Address, City and Postal Code.'); return false; }
    }
    return true;
}

function placeOfflineOrder() {
    if (!validateStep(1) || !validateStep(2)) { goStep(1); return; }
    var btn = document.getElementById('offline-place-btn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>&nbsp; Placing Order...';
    $.post(BASE_URL + '/place-offline-order', {
        billing_address_id:   document.getElementById('billing_address_id').value,
        special_instructions: document.getElementById('co_instructions').value,
        delivery_option:      'standard'
    }, function(res) {
        var r = typeof res === 'string' ? JSON.parse(res) : res;
        if (r.status === 'success') {
            window.location = BASE_URL + '/offline-order-confirmation/' + r.order_id;
        } else if (r.status === 'login') {
            window.location = BASE_URL + '/sign-in';
        } else {
            alert('Error placing order. Please try again.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-paper-plane"></i>&nbsp; Place Order for Review';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    ['co_email','co_fullname','co_addr1','co_city','co_postal'].forEach(function(id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('blur', function() {
            this.classList.toggle('valid', this.value.trim().length > 0);
            this.classList.toggle('invalid', this.value.trim().length === 0);
        });
        el.addEventListener('input', function() {
            if (this.classList.contains('invalid') && this.value.trim().length > 0) {
                this.classList.remove('invalid'); this.classList.add('valid');
            }
        });
    });
}); // end DOMContentLoaded
</script>
