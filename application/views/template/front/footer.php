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
    if(localStorage.getItem('age_verified') === '1') { sessionStorage.setItem('age_verified','1'); return; }
    // Skip on keyword SEO pages and location pages
    var path = window.location.pathname;
    if(path.indexOf('/location/') !== -1) return;
    var skipSlugs = <?php
        $CI =& get_instance();
        $slugs = $CI->db->select('page_slug')->where('status',1)->where('is_deleted',0)->where('page_slug !=','')->get('tbl_keywords')->result_array();
        echo json_encode(array_column($slugs, 'page_slug'));
    ?>;
    for(var i=0;i<skipSlugs.length;i++){
        if(path.indexOf(skipSlugs[i]) !== -1) return;
    }
    var overlay = document.getElementById('age-verify-overlay');
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
})();
function ageVerifyConfirm(){
    sessionStorage.setItem('age_verified','1');
    localStorage.setItem('age_verified','1');
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
                <h4>Locations</h4>
                <ul class="links">
                    <?php foreach(getKeywordLocations() as $loc): ?>
                    <li><i class="fa fa-map-marker text-color-primary"></i><a href="<?php echo base_url('location/'.urlencode($loc)); ?>"><?php echo htmlspecialchars($loc); ?></a></li>
                    <?php endforeach; ?>
                </ul>
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
<!-- ── Chat Widget ───────────────────────────────────────────────────────── -->
<style>
#cw-wrap{position:fixed;bottom:25px;right:25px;z-index:99999;display:flex;flex-direction:column;align-items:flex-end;gap:10px;}
#cw-trigger{width:58px;height:58px;border-radius:50%;background:#25d366;border:none;cursor:pointer;box-shadow:0 4px 16px rgba(0,0,0,.25);display:flex;align-items:center;justify-content:center;transition:background .2s;flex-shrink:0;}
#cw-trigger:hover{background:#1ebe5d;}
#cw-trigger svg{width:30px;height:30px;fill:#fff;display:block;}
#cw-channels{display:none;flex-direction:column;align-items:flex-end;gap:8px;}
#cw-channels.open{display:flex;}
.cw-channel-btn{width:50px;height:50px;border-radius:50%;border:none;cursor:pointer;box-shadow:0 3px 12px rgba(0,0,0,.2);display:flex;align-items:center;justify-content:center;position:relative;transition:transform .15s;}
.cw-channel-btn:hover{transform:scale(1.08);}
.cw-channel-btn svg{width:26px;height:26px;fill:#fff;display:block;}
.cw-channel-btn .cw-label{position:absolute;right:58px;background:#fff;color:#333;font-size:13px;font-family:sans-serif;white-space:nowrap;padding:5px 10px;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,.15);pointer-events:none;opacity:0;transition:opacity .15s;}
.cw-channel-btn:hover .cw-label{opacity:1;}
#cw-form-box{display:none;position:fixed;bottom:100px;right:25px;width:300px;background:#fff;border-radius:12px;box-shadow:0 8px 32px rgba(0,0,0,.18);z-index:99999;font-family:sans-serif;overflow:hidden;}
#cw-form-box.open{display:block;}
.cw-form-header{background:#a886cd;color:#fff;padding:14px 16px;display:flex;justify-content:space-between;align-items:center;font-size:16px;font-weight:600;}
.cw-form-header button{background:none;border:none;color:#fff;font-size:22px;cursor:pointer;line-height:1;padding:0;}
.cw-form-body{padding:16px;}
.cw-field{margin-bottom:12px;}
.cw-field label{display:block;font-size:13px;color:#444;margin-bottom:4px;}
.cw-field input,.cw-field textarea{width:100%;box-sizing:border-box;border:1px solid #ddd;border-radius:6px;padding:8px 10px;font-size:14px;outline:none;font-family:sans-serif;}
.cw-field input:focus,.cw-field textarea:focus{border-color:#a886cd;}
.cw-field textarea{height:80px;resize:none;}
.cw-submit{width:100%;background:#a886cd;color:#fff;border:none;border-radius:6px;padding:10px;font-size:15px;cursor:pointer;margin-top:4px;}
.cw-submit:hover{background:#9570c0;}
.cw-msg{font-size:13px;text-align:center;margin-top:8px;display:none;}
.cw-success{color:#00a700;}
.cw-error{color:#da0000;}
/* product enquiry pre-fill notice */
#cw-product-info{font-size:12px;color:#888;margin-bottom:10px;padding:6px 8px;background:#f9f4ff;border-radius:4px;border-left:3px solid #a886cd;display:none;}
/* AI Chat Window */
#ai-chat-box{display:none;position:fixed;bottom:100px;right:25px;width:320px;height:440px;background:#fff;border-radius:14px;box-shadow:0 8px 32px rgba(0,0,0,.18);z-index:99999;font-family:sans-serif;flex-direction:column;overflow:hidden;}
#ai-chat-box.open{display:flex;}
.ai-chat-header{background:linear-gradient(135deg,#a886cd,#7c5cbf);color:#fff;padding:13px 16px;display:flex;justify-content:space-between;align-items:center;flex-shrink:0;}
.ai-chat-header span{font-size:15px;font-weight:600;}
.ai-chat-header small{font-size:11px;opacity:.8;display:block;}
.ai-chat-header button{background:none;border:none;color:#fff;font-size:22px;cursor:pointer;line-height:1;padding:0;}
#ai-chat-messages{flex:1;overflow-y:auto;padding:12px;display:flex;flex-direction:column;gap:8px;}
.ai-msg,.ai-user-msg{max-width:82%;padding:9px 12px;border-radius:12px;font-size:13px;line-height:1.5;word-break:break-word;}
.ai-msg{background:#f3eeff;color:#333;align-self:flex-start;border-bottom-left-radius:3px;}
.ai-user-msg{background:#a886cd;color:#fff;align-self:flex-end;border-bottom-right-radius:3px;}
.ai-msg a{color:#7c5cbf;}
.cb-product-card{display:flex;align-items:center;gap:8px;background:#fff;border:1px solid #e8e0f5;border-radius:8px;padding:6px;margin:3px 0;}
.cb-product-card img{width:44px;height:44px;object-fit:cover;border-radius:6px;flex-shrink:0;}
.cb-product-info{display:flex;flex-direction:column;gap:2px;}
.cb-product-info a{font-size:12px;color:#7c5cbf;text-decoration:none;font-weight:600;}
.cb-price{font-size:12px;color:#333;font-weight:700;}
.ai-typing{display:flex;gap:4px;align-items:center;padding:10px 14px;background:#f3eeff;border-radius:12px;align-self:flex-start;}
.ai-typing span{width:7px;height:7px;background:#a886cd;border-radius:50%;animation:aiDot 1.2s infinite;}
.ai-typing span:nth-child(2){animation-delay:.2s;}
.ai-typing span:nth-child(3){animation-delay:.4s;}
@keyframes aiDot{0%,80%,100%{transform:scale(.7);opacity:.5;}40%{transform:scale(1);opacity:1;}}
#ai-chat-input-row{display:flex;gap:8px;padding:10px 12px;border-top:1px solid #f0e8ff;flex-shrink:0;background:#fff;}
#ai-chat-input{flex:1;border:1px solid #ddd;border-radius:20px;padding:8px 14px;font-size:13px;outline:none;font-family:sans-serif;}
#ai-chat-input:focus{border-color:#a886cd;}
#ai-chat-send{background:#a886cd;color:#fff;border:none;border-radius:50%;width:36px;height:36px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
#ai-chat-send:hover{background:#9570c0;}
#ai-chat-send svg{width:16px;height:16px;fill:#fff;}
</style>

<div id="cw-wrap">
    <!-- Channel buttons (hidden until trigger clicked) -->
    <div id="cw-channels">
        <!-- WhatsApp -->
        <button class="cw-channel-btn" style="background:#25d366;" onclick="window.open('https://wa.me/447414560342','_blank')" title="WhatsApp">
            <span class="cw-label">WhatsApp</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M16 2C8.268 2 2 8.268 2 16c0 2.49.67 4.823 1.836 6.83L2 30l7.418-1.807A13.93 13.93 0 0016 30c7.732 0 14-6.268 14-14S23.732 2 16 2zm0 25.5a11.44 11.44 0 01-5.84-1.6l-.418-.25-4.404 1.072 1.1-4.285-.274-.44A11.5 11.5 0 1116 27.5zm6.32-8.64c-.347-.174-2.053-1.013-2.372-1.128-.32-.115-.552-.174-.784.174-.232.347-.9 1.128-1.1 1.36-.203.232-.405.26-.752.087-.347-.174-1.466-.54-2.792-1.722-1.032-.92-1.728-2.056-1.93-2.404-.203-.347-.022-.535.152-.707.157-.156.347-.405.52-.608.174-.203.232-.347.347-.579.115-.232.058-.434-.029-.608-.087-.174-.784-1.89-1.074-2.59-.283-.68-.57-.587-.784-.598l-.667-.011c-.232 0-.608.087-.927.434-.32.347-1.218 1.19-1.218 2.902s1.247 3.367 1.42 3.599c.174.232 2.453 3.746 5.942 5.252.83.358 1.479.572 1.984.733.833.265 1.592.228 2.192.138.668-.1 2.053-.84 2.343-1.651.29-.812.29-1.508.203-1.651-.087-.145-.32-.232-.667-.405z"/></svg>
        </button>
        <!-- AI Chatbot -->
        <button class="cw-channel-btn" style="background:#7c5cbf;" onclick="aiChatToggle()" title="AI Assistant">
            <span class="cw-label">AI Assistant</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/><path d="M9 8h2v8H9zm4 0h2v8h-2z" style="display:none"/><path d="M20 9V7c0-1.1-.9-2-2-2h-1V3h-2v2H9V3H7v2H6C4.9 5 4 5.9 4 7v2H2v2h2v6c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6h2V9h-2zm-4 8H8v-2h8v2zm0-4H8v-2h8v2zm0-4H8V7h8v2z"/></svg>
        </button>
        <!-- Contact / Enquiry form -->
        <button class="cw-channel-btn" style="background:#a886cd;" onclick="cwToggleForm()" title="Contact Us">
            <span class="cw-label">Contact Us</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
        </button>
    </div>

    <!-- Main trigger bubble -->
    <button id="cw-trigger" onclick="cwToggle()" title="Chat with us">
        <!-- Chat icon (shown when closed) -->
        <svg id="cw-icon-chat" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
        <!-- Close icon (shown when open) -->
        <svg id="cw-icon-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display:none;"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
    </button>
</div>

<!-- AI Chat Window -->
<div id="ai-chat-box">
    <div class="ai-chat-header">
        <div><span>🤖 AI Assistant</span><small>Ask about products, orders &amp; more</small></div>
        <button onclick="aiChatToggle()">&times;</button>
    </div>
    <div id="ai-chat-messages"></div>
    <div id="ai-chat-input-row">
        <input id="ai-chat-input" type="text" placeholder="Ask me anything..." autocomplete="off">
        <button id="ai-chat-send" onclick="aiChatSend()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
        </button>
    </div>
</div>

<!-- Contact / Enquiry Form popup -->
<div id="cw-form-box">
    <div class="cw-form-header">
        <span>Send Enquiry</span>
        <button onclick="cwCloseForm()">&times;</button>
    </div>
    <div class="cw-form-body">
        <div id="cw-product-info"></div>
        <form id="cw-form" onsubmit="cwSubmit(event)">
            <input type="hidden" name="product_name" id="cw-hidden-product">
            <div class="cw-field"><label>Name *</label><input type="text" name="name" placeholder="Your name" required></div>
            <div class="cw-field"><label>Email *</label><input type="email" name="email" placeholder="Your email" required></div>
            <div class="cw-field"><label>Phone</label><input type="text" name="phone" placeholder="Your phone"></div>
            <div class="cw-field"><label>Message *</label><textarea name="message" placeholder="How can we help?" required></textarea></div>
            <button type="submit" class="cw-submit">Send Message</button>
            <p class="cw-msg cw-success" id="cw-ok"></p>
            <p class="cw-msg cw-error" id="cw-err"></p>
        </form>
    </div>
</div>

<script>
var cwOpen = false;
var aiChatOpen = false;
var aiChatGreeted = false;
function aiChatToggle(){
    aiChatOpen = !aiChatOpen;
    document.getElementById('ai-chat-box').classList.toggle('open', aiChatOpen);
    if(aiChatOpen && !aiChatGreeted){
        aiChatGreeted = true;
        aiAppendMsg('bot', '👋 Hi! I\'m your AI shopping assistant. Ask me about products, prices, categories, shipping, or anything else!');
    }
    if(aiChatOpen) setTimeout(function(){ document.getElementById('ai-chat-input').focus(); }, 100);
}
function aiAppendMsg(who, html){
    var msgs = document.getElementById('ai-chat-messages');
    var div = document.createElement('div');
    div.className = who === 'bot' ? 'ai-msg' : 'ai-user-msg';
    div.innerHTML = html;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
    return div;
}
function aiChatSend(){
    var input = document.getElementById('ai-chat-input');
    var text = input.value.trim();
    if(!text) return;
    aiAppendMsg('user', text.replace(/</g,'&lt;'));
    input.value = '';
    var typing = aiAppendMsg('bot', '<div class="ai-typing"><span></span><span></span><span></span></div>');
    fetch('<?php echo base_url('chatbot/ask'); ?>', {method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body:'message='+encodeURIComponent(text)})
        .then(function(r){return r.json();})
        .then(function(res){
            typing.remove();
            aiAppendMsg('bot', res.reply || 'Sorry, I could not process that.');
        }).catch(function(){
            typing.remove();
            aiAppendMsg('bot', '⚠️ Something went wrong. Please try again.');
        });
}
document.addEventListener('keydown', function(e){
    if(e.key === 'Enter' && document.activeElement && document.activeElement.id === 'ai-chat-input') aiChatSend();
});
function cwToggle(){
    cwOpen = !cwOpen;
    document.getElementById('cw-channels').classList.toggle('open', cwOpen);
    document.getElementById('cw-icon-chat').style.display  = cwOpen ? 'none'  : 'block';
    document.getElementById('cw-icon-close').style.display = cwOpen ? 'block' : 'none';
    document.getElementById('cw-trigger').style.background = cwOpen ? '#e05555' : '#25d366';
    if(!cwOpen) cwCloseForm();
}
function cwToggleForm(){
    var box = document.getElementById('cw-form-box');
    box.classList.toggle('open');
}
function cwCloseForm(){
    document.getElementById('cw-form-box').classList.remove('open');
}
/* Called from product pages: cwEnquireProduct('Product Name') */
function cwEnquireProduct(name){
    document.getElementById('cw-hidden-product').value = name;
    var info = document.getElementById('cw-product-info');
    info.textContent = 'Enquiry about: ' + name;
    info.style.display = 'block';
    var msg = document.querySelector('#cw-form textarea[name=message]');
    if(msg && !msg.value) msg.value = 'I would like to enquire about: ' + name;
    if(!cwOpen) cwToggle();
    document.getElementById('cw-form-box').classList.add('open');
}
function cwSubmit(e){
    e.preventDefault();
    var ok  = document.getElementById('cw-ok');
    var err = document.getElementById('cw-err');
    ok.style.display = err.style.display = 'none';
    fetch('<?php echo base_url('chatbot/submit'); ?>', {method:'POST', body: new FormData(document.getElementById('cw-form'))})
        .then(function(r){return r.json();})
        .then(function(res){
            if(res.status==1){ok.textContent=res.message;ok.style.display='block';document.getElementById('cw-form').reset();document.getElementById('cw-product-info').style.display='none';}
            else{err.textContent=res.message||'Something went wrong.';err.style.display='block';}
        }).catch(function(){err.textContent='Request failed.';err.style.display='block';});
}
</script>
</body>
</html>
