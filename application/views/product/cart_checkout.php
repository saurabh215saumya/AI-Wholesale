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
      <div class="co-step-label">Delivery</div>
    </div>
    <div class="co-step-line" id="pl-3"></div>
    <div class="co-step" id="ps-4">
      <div class="co-step-circle" id="pc-4">4</div>
      <div class="co-step-label">Payment</div>
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
    <button class="co-btn-next" onclick="goStep(3)"><i class="fa fa-arrow-right"></i>&nbsp; Continue to Delivery</button>
    <button class="co-btn-back" onclick="goStep(1)"><i class="fa fa-arrow-left"></i>&nbsp; Back</button>
  </div>

  <!-- Step 3: Delivery Options -->
  <div class="co-card" id="step-3">
    <div class="co-card-header">
      <div class="co-card-icon"><i class="fa fa-truck"></i></div>
      <div><div class="co-card-title">Delivery Options</div><div class="co-card-subtitle">Choose how fast you want your order</div></div>
    </div>

    <label class="co-delivery selected" id="dopt-1">
      <input type="radio" name="delivery_option" value="royal_mail_tracked_48" checked onchange="selectDelivery(this,'dopt-1',0)">
      <div class="co-delivery-icon">📦</div>
      <div class="co-delivery-info">
        <div class="co-delivery-name">Royal Mail Tracked 48 <span class="co-delivery-badge">Most Popular</span></div>
        <div class="co-delivery-desc">2–3 business days · Full tracking included</div>
      </div>
      <div class="co-delivery-price free">FREE</div>
    </label>

    <label class="co-delivery" id="dopt-2">
      <input type="radio" name="delivery_option" value="royal_mail_first_class" onchange="selectDelivery(this,'dopt-2',2.95)">
      <div class="co-delivery-icon">🚀</div>
      <div class="co-delivery-info">
        <div class="co-delivery-name">Royal Mail First Class</div>
        <div class="co-delivery-desc">1–2 business days</div>
      </div>
      <div class="co-delivery-price">£2.95</div>
    </label>

    <label class="co-delivery" id="dopt-3">
      <input type="radio" name="delivery_option" value="royal_mail_special_delivery" onchange="selectDelivery(this,'dopt-3',8.95)">
      <div class="co-delivery-icon">⚡</div>
      <div class="co-delivery-info">
        <div class="co-delivery-name">Special Delivery Guaranteed <span class="co-delivery-badge paid">Fast</span></div>
        <div class="co-delivery-desc">Next working day by 1pm · £500 compensation</div>
      </div>
      <div class="co-delivery-price">£8.95</div>
    </label>

    <label class="co-delivery" id="dopt-4">
      <input type="radio" name="delivery_option" value="royal_mail_special_saturday" onchange="selectDelivery(this,'dopt-4',12.95)">
      <div class="co-delivery-icon">📅</div>
      <div class="co-delivery-info">
        <div class="co-delivery-name">Saturday Delivery <span class="co-delivery-badge paid">Weekend</span></div>
        <div class="co-delivery-desc">Saturday by 1pm · £500 compensation</div>
      </div>
      <div class="co-delivery-price">£12.95</div>
    </label>

    <button class="co-btn-next" onclick="goStep(4)"><i class="fa fa-arrow-right"></i>&nbsp; Continue to Payment</button>
    <button class="co-btn-back" onclick="goStep(2)"><i class="fa fa-arrow-left"></i>&nbsp; Back</button>
  </div>

  <!-- Step 4: Payment -->
  <div class="co-card" id="step-4">
    <div class="co-card-header">
      <div class="co-card-icon"><i class="fa fa-credit-card"></i></div>
      <div><div class="co-card-title">Payment</div><div class="co-card-subtitle">Your payment is encrypted and secure</div></div>
    </div>

    <!-- Order Summary -->
    <div style="background:#fafafa;border-radius:10px;padding:14px 16px;margin-bottom:18px;">
      <div style="font-size:12px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Order Summary</div>
      <?php $netTotal = $subTotal / 1.20; $vatTotal = $subTotal - $netTotal; ?>
      <div class="co-summary-item"><span>Subtotal (ex. VAT)</span><span>£<?php echo number_format($netTotal,2); ?></span></div>
      <div class="co-summary-item"><span>VAT (20%)</span><span>£<?php echo number_format($vatTotal,2); ?></span></div>
      <div class="co-summary-item"><span>Shipping</span><span id="shipping-display" style="color:#28a745;font-weight:700;">FREE</span></div>
      <div class="co-summary-total"><span>Total (inc. VAT)</span><span id="total-display">£<?php echo number_format($subTotal,2); ?></span></div>
    </div>

    <div class="co-field">
      <label><i class="fa fa-lock" style="color:#ff6b9d;"></i>&nbsp; Card Details</label>
      <div class="co-stripe-box" id="stripe-card-element"></div>
      <div class="co-stripe-error" id="stripe-card-errors"></div>
    </div>

    <input type="hidden" id="billing_address_id" value="<?php echo !empty($billing['id']) ? $billing['id'] : ''; ?>">

    <button class="co-btn-pay" id="stripe-pay-btn">
      <i class="fa fa-lock"></i>&nbsp; Pay £<span id="pay-btn-amount"><?php echo number_format($subTotal,2); ?></span> Securely
    </button>
    <div class="co-secure"><i class="fa fa-shield"></i> SSL Encrypted &nbsp;·&nbsp; <i class="fa fa-cc-stripe"></i> Powered by Stripe</div>
    <button class="co-btn-back" onclick="goStep(3)" style="margin-top:10px;"><i class="fa fa-arrow-left"></i>&nbsp; Back</button>
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
var shippingCost = 0;
var currentStep = 1;
var stripe, cardElement;

function goStep(n) {
    if (n > currentStep && !validateStep(currentStep)) return;
    document.getElementById('step-' + currentStep).classList.remove('active');
    // update progress
    for (var i = 1; i <= 4; i++) {
        var ps = document.getElementById('ps-' + i);
        var pc = document.getElementById('pc-' + i);
        ps.classList.remove('active','done');
        if (i < n) { ps.classList.add('done'); pc.innerHTML = '<i class="fa fa-check"></i>'; }
        else if (i === n) { ps.classList.add('active'); pc.textContent = i; }
        else { pc.textContent = i; }
        if (i < 4) {
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

function selectDelivery(radio, optId, cost) {
    document.querySelectorAll('.co-delivery').forEach(function(el){ el.classList.remove('selected'); });
    document.getElementById(optId).classList.add('selected');
    shippingCost = cost;
    var total = SUBTOTAL + cost;
    document.getElementById('shipping-display').textContent = cost > 0 ? '£' + cost.toFixed(2) : 'FREE';
    document.getElementById('shipping-display').style.color = cost > 0 ? '#222' : '#28a745';
    document.getElementById('total-display').textContent = '£' + total.toFixed(2);
    document.getElementById('pay-btn-amount').textContent = total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');
    var elements = stripe.elements();
    cardElement = elements.create('card', {
        hidePostalCode: true,
        style: { base: { fontSize: '15px', color: '#333', '::placeholder': { color: '#bbb' }, fontFamily: "'Segoe UI', sans-serif" } }
    });
    cardElement.mount('#stripe-card-element');
    cardElement.on('change', function(e) {
        document.getElementById('stripe-card-errors').textContent = e.error ? e.error.message : '';
    });

    document.getElementById('stripe-pay-btn').addEventListener('click', function() {
    if (!validateStep(1) || !validateStep(2)) { goStep(1); return; }
    var btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>&nbsp; Processing...';

    stripe.createToken(cardElement, { name: document.getElementById('co_fullname').value.trim() }).then(function(result) {
        if (result.error) {
            document.getElementById('stripe-card-errors').textContent = result.error.message;
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-lock"></i>&nbsp; Pay £<span id="pay-btn-amount">' + (SUBTOTAL + shippingCost).toFixed(2) + '</span> Securely';
            return;
        }
        var deliveryOption = document.querySelector('input[name="delivery_option"]:checked').value;
        $.post(BASE_URL + '/stripe-payment', {
            stripe_token:         result.token.id,
            billing_address_id:   document.getElementById('billing_address_id').value,
            special_instructions: document.getElementById('co_instructions').value,
            delivery_option:      deliveryOption
        }, function(res) {
            var r = typeof res === 'string' ? JSON.parse(res) : res;
            if (r.status === 'success') {
                window.location = BASE_URL + '/order-summary/' + r.order_id;
            } else if (r.status === 'login') {
                window.location = BASE_URL + '/sign-in';
            } else {
                alert('Payment failed: ' + (r.msg || 'Unknown error'));
                btn.disabled = false;
                btn.innerHTML = '<i class="fa fa-lock"></i>&nbsp; Pay £<span id="pay-btn-amount">' + (SUBTOTAL + shippingCost).toFixed(2) + '</span> Securely';
            }
        });
    });
    }); // end stripe-pay-btn click

    // Live input validation feedback
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
    }); // end forEach
}); // end DOMContentLoaded
</script>
