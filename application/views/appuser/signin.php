<section class="form-section">
    <div class="container">
        <h1 class="h2 heading-primary font-weight-normal mb-md mt-lg">Login or Create an Account</h1>
        <?php if(isset($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
        <?php echo $this->session->flashdata('success') ? '<div class="alert alert-success">'.$this->session->flashdata('success').'</div>' : ''; ?>

        <div class="featured-box featured-box-primary featured-box-flat featured-box-text-left mt-md">
            <div class="box-content">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-content">
                            <h3 class="heading-text-color font-weight-normal">New Customers</h3>
                            <p>Want to shop with us? Apply for a wholesale account to get access to exclusive pricing and our full product catalogue.</p>
                        </div>
                        <div class="form-action clearfix">
                            <a href="<?php echo base_url('wholesale/apply'); ?>" class="btn btn-primary">Apply as Wholesaler</a>
                            <a href="<?php echo base_url('wholesale'); ?>" class="btn btn-default" style="margin-left:8px;">Learn More</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-content">
                            <h3 class="heading-text-color font-weight-normal">Registered Customers</h3>
                            <p>If you have an account with us, please log in.</p>
                            <p id="resLoginErrorMsg" class="resErrorMsg"></p>
                            <div class="form-group">
                                <label class="font-weight-normal">Email Address <span class="required">*</span></label>
                                <input type="email" name="email" id="login_email" class="form-control">
                                <span id="emailLoginError" style="color:red;display:none;"></span>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-normal">Password <span class="required">*</span></label>
                                <input type="password" name="password" id="login_password" class="form-control">
                                <span id="passwordLoginError" style="color:red;display:none;"></span>
                            </div>
                            <p class="required">* Required Fields</p>
                        </div>
                        <div class="form-action clearfix">
                            <input onclick="return doLogin();" class="btn btn-primary" value="Login" type="button">
                            <a href="<?php echo base_url('forgot-password'); ?>" style="margin-left:12px;font-size:13px;color:#ff6000;line-height:34px;">Forgot Password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function doLogin() {
    var email = $('#login_email').val();
    var password = $('#login_password').val();
    var valid = 1;
    if (!email) { $('#emailLoginError').show().html('<strong>Enter your email.</strong>'); valid = 0; } else { $('#emailLoginError').hide(); }
    if (!password) { $('#passwordLoginError').show().html('<strong>Enter your password.</strong>'); valid = 0; } else { $('#passwordLoginError').hide(); }
    if (!valid) return false;

    // Detect redirect param from URL
    var urlParams = new URLSearchParams(window.location.search);
    var redirectTo = urlParams.get('redirect');

    $.ajax({ type:'POST', url: BASE_URL+'/appuser/ajax_login', data: {email:email, password:password},
        success: function(r) {
            if (r === 'success') {
                // Merge guest cart then redirect
                $.post(BASE_URL+'/ajax-merge-guest-cart', {}, function() {
                    if (redirectTo === 'checkout') {
                        window.location.href = BASE_URL+'/checkout';
                    } else {
                        window.location.href = BASE_URL+'/';
                    }
                });
            } else {
                $('#resLoginErrorMsg').html('<div class="alert alert-danger"><strong>Invalid email or password.</strong></div>');
            }
        }
    });
    return false;
}
</script>
