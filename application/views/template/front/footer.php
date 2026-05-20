</div><!-- /.main -->

<!-- ── Age Verification Dialog ─────────────────────────────────────────── -->
<div id="age-verify-overlay" style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(10,10,20,.82);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;max-width:460px;width:92%;margin:auto;overflow:hidden;box-shadow:0 30px 80px rgba(0,0,0,.45);position:relative;">
        <!-- Top gradient bar -->
        <div style="background:linear-gradient(135deg,#ff6000 0%,#ff8c42 50%,#ff6b9d 100%);padding:36px 30px 28px;text-align:center;">
            <div style="width:72px;height:72px;background:rgba(255,255,255,.18);border:3px solid rgba(255,255,255,.5);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:32px;color:#fff;line-height:1;">18+</div>
            <h2 style="color:#fff;font-size:24px;font-weight:800;margin:0 0 6px;letter-spacing:.5px;">Age Verification</h2>
            <p style="color:rgba(255,255,255,.88);font-size:13px;margin:0;">You must be 18 or older to enter this site</p>
        </div>
        <!-- Body -->
        <div style="padding:28px 32px 32px;text-align:center;">
            <p style="color:#555;font-size:14px;line-height:1.7;margin:0 0 24px;">This website contains products intended for adults only. By entering, you confirm that you are <strong style="color:#ff6000;">18 years of age or older</strong> and agree to our <a href="<?php echo base_url('terms-conditions'); ?>" style="color:#ff6000;">Terms &amp; Conditions</a>.</p>
            <div style="display:flex;gap:12px;justify-content:center;">
                <button onclick="ageVerifyConfirm()" style="flex:1;max-width:180px;background:linear-gradient(135deg,#ff6000,#ff8c42);color:#fff;border:none;border-radius:30px;padding:13px 20px;font-size:15px;font-weight:700;cursor:pointer;transition:opacity .2s;box-shadow:0 4px 18px rgba(255,96,0,.35);">
                    <i class="fa fa-check"></i>&nbsp; Yes, I'm 18+
                </button>
                <button onclick="ageVerifyDecline()" style="flex:1;max-width:180px;background:#f5f5f5;color:#888;border:1px solid #e0e0e0;border-radius:30px;padding:13px 20px;font-size:15px;font-weight:700;cursor:pointer;transition:background .2s;">
                    <i class="fa fa-times"></i>&nbsp; No, Exit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Age-blocked screen (shown when user clicks No) -->
<div id="age-blocked-screen" style="display:none;position:fixed;inset:0;z-index:99999;background:linear-gradient(135deg,#1a1a2e 0%,#16213e 60%,#0f3460 100%);align-items:center;justify-content:center;text-align:center;padding:30px;">
    <div>
        <div style="font-size:64px;margin-bottom:16px;">🚫</div>
        <h2 style="color:#fff;font-size:26px;font-weight:800;margin:0 0 10px;">Access Denied</h2>
        <p style="color:rgba(255,255,255,.65);font-size:15px;max-width:340px;margin:0 auto 24px;line-height:1.7;">Sorry, you must be 18 or older to access this website.</p>
        <a href="https://www.google.com" style="display:inline-block;background:linear-gradient(135deg,#ff6000,#ff8c42);color:#fff;border-radius:30px;padding:12px 32px;font-size:14px;font-weight:700;text-decoration:none;"><i class="fa fa-arrow-left"></i>&nbsp; Leave Site</a>
    </div>
</div>

<script>
(function(){
    if(sessionStorage.getItem('age_verified') === '1') return;
    var overlay = document.getElementById('age-verify-overlay');
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
})();
function ageVerifyConfirm(){
    sessionStorage.setItem('age_verified','1');
    document.getElementById('age-verify-overlay').style.display = 'none';
    document.body.style.overflow = '';
}
function ageVerifyDecline(){
    document.getElementById('age-verify-overlay').style.display = 'none';
    var blocked = document.getElementById('age-blocked-screen');
    blocked.style.display = 'flex';
}
</script>

<footer id="footer" style="background:#1e1e1e; color:#ccc;">
    <div class="container">
        <div class="row">
            <div class="footer-ribbon">
                <span>Get in Touch</span>
            </div>
            <div class="col-md-3">
                <h4>My Account</h4>
                <ul class="links">
                    <li><i class="fa fa-caret-right text-color-primary"></i><a href="<?php echo base_url('about-us'); ?>">About Us</a></li>
                    <li><i class="fa fa-caret-right text-color-primary"></i><a href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
                    <li><i class="fa fa-caret-right text-color-primary"></i><a href="<?php echo base_url('my-account'); ?>">My Account</a></li>
                    <li><i class="fa fa-caret-right text-color-primary"></i><a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a></li>
                    <li><i class="fa fa-caret-right text-color-primary"></i><a href="<?php echo base_url('terms-conditions'); ?>">Terms &amp; Conditions</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <div class="contact-details">
                    <h4>Contact Information</h4>
                    <ul class="contact">
                        <li><p><i class="fa fa-map-marker"></i> <strong>Address:</strong><br> Unit D2, Tamian Way, TW4 6BL</p></li>
                        <li><p><i class="fa fa-phone"></i> <strong>Phone:</strong><br> 07414 560342</p></li>
                        <li><p><i class="fa fa-envelope-o"></i> <strong>Email:</strong><br> <a href="mailto:<?php echo ADMIN_EMAIL; ?>"><?php echo ADMIN_EMAIL; ?></a></p></li>
                        <li><p><i class="fa fa-clock-o"></i> <strong>Working Days/Hours:</strong><br> Mon - Sat / 9:00AM - 8:00PM</p></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <h4>Categories</h4>
                <ul class="features">
                    <?php $footerCats = getAllCategory(); foreach($footerCats as $fc): ?>
                    <li><i class="fa fa-check text-color-primary"></i><a href="<?php echo base_url('categories/'.$fc->category_slug); ?>"><?php echo $fc->category_name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-3">
                <div class="newsletter">
                    <h4>Be the First to Know</h4>
                    <p class="newsletter-info">Get all the latest information on Events, Sales and Offers. Sign up for newsletter today.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <a href="<?php echo base_url(); ?>" class="logo">
                <img alt="<?php echo SITE_NAME; ?>" class="img-responsive" width="111" height="51" src="<?php echo base_url('assets/images/img/demos/shop/logo-shop.png'); ?>">
            </a>
            <ul class="social-icons">
                <li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                <li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                <li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
            </ul>
            <img alt="Payments" src="<?php echo base_url('assets/images/img/demos/shop/payments.png'); ?>" class="footer-payment">
            <p class="copyright-text">&copy; Copyright <?php echo date('Y'); ?>. All Rights Reserved.</p>
        </div>
    </div>
</footer>
</div><!-- /.body -->

<!-- Vendor JS -->
<script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery.appear/jquery.appear.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery.easing/jquery.easing.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery-cookie/jquery-cookie.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/common/common.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery.validation/jquery.validation.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery.lazyload/jquery.lazyload.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/isotope/jquery.isotope.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/owl.carousel/owl.carousel.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/magnific-popup/jquery.magnific-popup.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/vide/vide.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/theme.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/rs-plugin/js/jquery.themepunch.tools.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/views/view.contact.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/elevatezoom/jquery.elevatezoom.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/demos/demo-shop-5.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/theme.init.js'); ?>"></script>
<script>var BASE_URL = '<?php echo BASE_URL; ?>';</script>
<script>
// ── Global guest-friendly cart functions ──────────────────────────────────
function addToCart(pid, qty, variantPrice, variantLabel) {
    var data = {product_id: pid, quantity: qty || 1};
    if (variantPrice) data.variant_price = variantPrice;
    if (variantLabel) data.variant_label = variantLabel;
    $.post(BASE_URL + '/product/addItemIntoCart', data, function(r) {
        var res = typeof r === 'string' ? JSON.parse(r) : r;
        if (!res || res.status !== 'added') { showToast('Could not add to cart.', 'error'); return; }
        showToast('Added to cart!', 'success');
        var $qty = $('.cart-qty');
        $qty.text(parseInt($qty.text() || 0) + 1);
        // Close variant panel immediately
        $('#variants-card-' + pid).removeClass('open');
        $('#chev-card-' + pid).removeClass('fa-chevron-up').addClass('fa-chevron-down');
        // Flash the variant row that was clicked
        if (variantLabel) {
            var $row = $('#variants-card-' + pid + ' .jly-variant-row').filter(function() {
                return $(this).find('.jly-variant-label').text().trim() === variantLabel ||
                       $(this).find('.jly-variant-label').text().trim() === variantLabel + ' pieces';
            });
            $row.addClass('jly-variant-added');
            setTimeout(function(){ $row.removeClass('jly-variant-added'); }, 1500);
        }
    }, 'json').fail(function(){ showToast('Could not add to cart.', 'error'); });
}
function showToast(msg, type) {
    var $t = $('<div class="jly-toast jly-toast-' + (type||'success') + '">' + msg + '</div>');
    $('body').append($t);
    setTimeout(function(){ $t.addClass('show'); }, 10);
    setTimeout(function(){ $t.removeClass('show'); setTimeout(function(){ $t.remove(); }, 400); }, 2500);
}
</script>
</body>
</html>
