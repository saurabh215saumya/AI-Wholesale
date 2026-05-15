<section class="form-section register-form">
    <div class="container">
        <h1 class="h2 heading-primary font-weight-normal mb-md mt-lg">Create an Account</h1>
        <div id="resSuccessMsg" class="resSuccessMsg"></div>
        <div id="resErrorMsg" class="resErrorMsg"></div>

        <div class="featured-box featured-box-primary featured-box-flat featured-box-text-left mt-md">
            <div class="box-content">
                <h4 class="heading-primary text-uppercase mb-lg">PERSONAL INFORMATION</h4>
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        <div class="form-group">
                            <label class="font-weight-normal">First Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="first_name">
                            <span id="firstNameError" style="color:red;display:none;"></span>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <div class="form-group">
                            <label class="font-weight-normal">Last Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="last_name">
                            <span id="lastNameError" style="color:red;display:none;"></span>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <div class="form-group">
                            <label class="font-weight-normal">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile">
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <div class="form-group">
                            <label class="font-weight-normal">Email Address <span class="required">*</span></label>
                            <input type="email" class="form-control" id="reg_email">
                            <span id="emailError" style="color:red;display:none;"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <label class="font-weight-normal">Company Name</label>
                            <input type="text" class="form-control" id="company_name">
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <label class="font-weight-normal">Account Type <span class="required">*</span></label>
                            <select class="form-control" id="user_type">
                                <option value="person">Individual</option>
                                <option value="business">Business / Wholesaler</option>
                            </select>
                        </div>
                    </div>
                </div>
                <h4 class="heading-primary text-uppercase mb-lg mt-lg">LOGIN INFORMATION</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="font-weight-normal">Password <span class="required">*</span></label>
                            <input type="password" class="form-control" id="reg_password">
                            <span id="passwordError" style="color:red;display:none;"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="font-weight-normal">Confirm Password <span class="required">*</span></label>
                            <input type="password" class="form-control" id="confirm_password">
                            <span id="confirmPasswordError" style="color:red;display:none;"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <p class="required mt-lg mb-none">* Required Fields</p>
                        <div class="form-action clearfix mt-none">
                            <a href="<?php echo base_url('sign-in'); ?>" class="pull-left"><i class="fa fa-angle-double-left"></i> Back to Login</a>
                            <input onclick="return doSignup();" class="btn btn-primary" value="Create Account" type="button">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function doSignup() {
    var first_name = $('#first_name').val(), last_name = $('#last_name').val(), email = $('#reg_email').val();
    var mobile = $('#mobile').val(), company_name = $('#company_name').val(), user_type = $('#user_type').val();
    var password = $('#reg_password').val(), confirm_password = $('#confirm_password').val();
    var valid = 1;
    if (!first_name) { $('#firstNameError').show().html('<strong>Enter your first name.</strong>'); valid=0; } else { $('#firstNameError').hide(); }
    if (!last_name) { $('#lastNameError').show().html('<strong>Enter your last name.</strong>'); valid=0; } else { $('#lastNameError').hide(); }
    if (!email || email.indexOf('@')<1) { $('#emailError').show().html('<strong>Enter a valid email.</strong>'); valid=0; } else { $('#emailError').hide(); }
    if (!password) { $('#passwordError').show().html('<strong>Enter your password.</strong>'); valid=0; } else { $('#passwordError').hide(); }
    if (password !== confirm_password) { $('#confirmPasswordError').show().html('<strong>Passwords do not match.</strong>'); valid=0; } else { $('#confirmPasswordError').hide(); }
    if (!valid) return false;
    $.ajax({ type:'POST', url: BASE_URL+'/appuser/ajax_signup',
        data: {first_name:first_name, last_name:last_name, email:email, mobile:mobile, company_name:company_name, user_type:user_type, password:password},
        success: function(r) {
            if (r==='success') { $('#resSuccessMsg').html('<div class="alert alert-success"><strong>Account created! You can now <a href="'+BASE_URL+'/sign-in">log in</a>.</strong></div>'); }
            else if (r==='duplicate_email') { $('#resErrorMsg').html('<div class="alert alert-danger"><strong>Email already registered.</strong></div>'); }
            else { $('#resErrorMsg').html('<div class="alert alert-danger"><strong>Registration failed. Please try again.</strong></div>'); }
        }
    });
    return false;
}
</script>
