</div><!-- /.main -->

<footer id="footer">
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
</body>
</html>
