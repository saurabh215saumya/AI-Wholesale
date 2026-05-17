<section class="form-section register-form">
    <div class="container">
        <h1 class="h2 heading-primary font-weight-normal mb-md mt-lg" id="formTitle"><?php echo isset($is_wholesale) ? 'Apply as Wholesaler' : 'Create an Account'; ?></h1>
        <div id="wholesaleIntro" style="<?php echo isset($is_wholesale) ? '' : 'display:none;'; ?>">
            <div class="alert alert-info" style="border-left:4px solid #CCC9A1; background:#fafaf5;">
                <i class="fa fa-info-circle"></i> Fill in your business details below to apply for a wholesale account. Our team will review and activate your account.
            </div>
        </div>
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
                            <label class="font-weight-normal">Account Type <span class="required">*</span></label>
                            <select class="form-control" id="user_type" onchange="toggleWholesaleFields()">
                                <option value="person" <?php echo isset($is_wholesale) ? '' : 'selected'; ?>>Individual</option>
                                <option value="business" <?php echo isset($is_wholesale) ? 'selected' : ''; ?>>Business / Wholesaler</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <label class="font-weight-normal">Company Name <span id="companyRequired" style="<?php echo isset($is_wholesale) ? '' : 'display:none;'; ?>" class="required">*</span></label>
                            <input type="text" class="form-control" id="company_name">
                            <span id="companyNameError" style="color:red;display:none;"></span>
                        </div>
                    </div>
                </div>

                <!-- Wholesale Extra Fields -->
                <div id="wholesaleFields" style="<?php echo isset($is_wholesale) ? '' : 'display:none;'; ?>">
                    <h4 class="heading-primary text-uppercase mb-lg mt-lg" style="border-top:1px solid #eee; padding-top:15px;">
                        <i class="fa fa-building-o"></i> BUSINESS INFORMATION
                    </h4>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="font-weight-normal">Business Type <span class="required">*</span></label>
                                <select class="form-control" id="business_type">
                                    <option value="">Select Business Type</option>
                                    <option value="retailer">Retailer</option>
                                    <option value="distributor">Distributor</option>
                                    <option value="online_seller">Online Seller</option>
                                    <option value="other">Other</option>
                                </select>
                                <span id="businessTypeError" style="color:red;display:none;"></span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="font-weight-normal">VAT / Tax Number <small class="text-muted">(optional)</small></label>
                                <input type="text" class="form-control" id="vat_number" placeholder="e.g. GB123456789">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="font-weight-normal">Website / Social Media <small class="text-muted">(optional)</small></label>
                                <input type="text" class="form-control" id="website" placeholder="e.g. www.yourbusiness.com">
                            </div>
                        </div>
                        <div class="col-sm-8 col-md-8">
                            <div class="form-group">
                                <label class="font-weight-normal">Business Address <span class="required">*</span></label>
                                <input type="text" class="form-control" id="business_address" placeholder="Full business address">
                                <span id="businessAddressError" style="color:red;display:none;"></span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="font-weight-normal">Expected Monthly Order</label>
                                <select class="form-control" id="monthly_order">
                                    <option value="">Select Range</option>
                                    <option value="50-99">50 &ndash; 99 units</option>
                                    <option value="100-249">100 &ndash; 249 units</option>
                                    <option value="250-499">250 &ndash; 499 units</option>
                                    <option value="500+">500+ units</option>
                                </select>
                            </div>
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
                            <a href="<?php echo isset($is_wholesale) ? base_url('wholesale') : base_url('sign-in'); ?>" class="pull-left"><i class="fa fa-angle-double-left"></i> <?php echo isset($is_wholesale) ? 'Back to Wholesale' : 'Back to Login'; ?></a>
                            <input onclick="return doSignup();" class="btn btn-primary" id="submitBtn" value="<?php echo isset($is_wholesale) ? 'Submit Application' : 'Create Account'; ?>" type="button">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
var initWholesale = <?php echo isset($is_wholesale) ? 'true' : 'false'; ?>;

function toggleWholesaleFields() {
    var isBusiness = $('#user_type').val() === 'business';
    if (isBusiness) {
        $('#wholesaleFields').slideDown(300);
        $('#wholesaleIntro').slideDown(200);
        $('#companyRequired').show();
        $('#formTitle').text('Apply as Wholesaler');
        $('#submitBtn').val('Submit Application');
    } else {
        $('#wholesaleFields').slideUp(300);
        $('#wholesaleIntro').slideUp(200);
        $('#companyRequired').hide();
        $('#formTitle').text('Create an Account');
        $('#submitBtn').val('Create Account');
    }
}

function doSignup() {
    var first_name = $('#first_name').val(), last_name = $('#last_name').val(), email = $('#reg_email').val();
    var mobile = $('#mobile').val(), company_name = $('#company_name').val(), user_type = $('#user_type').val();
    var password = $('#reg_password').val(), confirm_password = $('#confirm_password').val();
    var isWholesale = (user_type === 'business');
    var valid = 1;

    if (!first_name) { $('#firstNameError').show().html('<strong>Enter your first name.</strong>'); valid=0; } else { $('#firstNameError').hide(); }
    if (!last_name)  { $('#lastNameError').show().html('<strong>Enter your last name.</strong>'); valid=0; }  else { $('#lastNameError').hide(); }
    if (!email || email.indexOf('@') < 1) { $('#emailError').show().html('<strong>Enter a valid email.</strong>'); valid=0; } else { $('#emailError').hide(); }
    if (!password)   { $('#passwordError').show().html('<strong>Enter your password.</strong>'); valid=0; }   else { $('#passwordError').hide(); }
    if (password !== confirm_password) { $('#confirmPasswordError').show().html('<strong>Passwords do not match.</strong>'); valid=0; } else { $('#confirmPasswordError').hide(); }

    if (isWholesale) {
        if (!company_name) { $('#companyNameError').show().html('<strong>Enter your company name.</strong>'); valid=0; } else { $('#companyNameError').hide(); }
        if (!$('#business_type').val()) { $('#businessTypeError').show().html('<strong>Select your business type.</strong>'); valid=0; } else { $('#businessTypeError').hide(); }
        if (!$('#business_address').val()) { $('#businessAddressError').show().html('<strong>Enter your business address.</strong>'); valid=0; } else { $('#businessAddressError').hide(); }
    }
    if (!valid) return false;

    var data = {first_name:first_name, last_name:last_name, email:email, mobile:mobile, company_name:company_name, user_type:user_type, password:password};
    if (isWholesale) {
        data.business_type    = $('#business_type').val();
        data.vat_number       = $('#vat_number').val();
        data.website          = $('#website').val();
        data.business_address = $('#business_address').val();
        data.monthly_order    = $('#monthly_order').val();
    }

    $.ajax({ type:'POST', url: BASE_URL+'/appuser/ajax_signup', data: data,
        success: function(r) {
            if (r === 'success') {
                $('#resSuccessMsg').html('<div class="alert alert-success"><strong>Account created! You can now <a href="'+BASE_URL+'/sign-in">log in</a>.</strong></div>');
                $('html,body').animate({scrollTop:0}, 400);
            } else if (r === 'duplicate_email') {
                $('#resErrorMsg').html('<div class="alert alert-danger"><strong>This email is already registered.</strong></div>');
            } else {
                $('#resErrorMsg').html('<div class="alert alert-danger"><strong>Registration failed. Please try again.</strong></div>');
            }
        }
    });
    return false;
}
</script>
