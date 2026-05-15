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
                            <p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
                        </div>
                        <div class="form-action clearfix">
                            <a href="<?php echo base_url('sign-up'); ?>" class="btn btn-primary">Create an Account</a>
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
    $.ajax({ type:'POST', url: BASE_URL+'/appuser/ajax_login', data: {email:email, password:password},
        success: function(r) {
            if (r === 'success') { window.location.href = BASE_URL+'/'; }
            else { $('#resLoginErrorMsg').html('<div class="alert alert-danger"><strong>Invalid email or password.</strong></div>'); }
        }
    });
    return false;
}
</script>
