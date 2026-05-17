<section class="form-section register-form">
    <div class="container">
        <h1 class="h2 heading-primary font-weight-normal mb-md mt-lg">
            <?php echo isset($is_wholesale) ? 'Apply as Wholesaler' : 'Create an Account'; ?>
        </h1>

        <?php if (isset($is_wholesale)): ?>
        <div class="alert alert-info" style="border-left:4px solid #CCC9A1; background:#fafaf5;">
            <i class="fa fa-info-circle"></i> Fill in your business details below to apply for a wholesale account. Our team will review and activate your account.
        </div>
        <?php endif; ?>

        <div id="resSuccessMsg"></div>
        <div id="resErrorMsg"></div>

        <div class="featured-box featured-box-primary featured-box-flat featured-box-text-left mt-md">
            <div class="box-content">

                <h4 class="heading-primary text-uppercase mb-lg">PERSONAL INFORMATION</h4>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="font-weight-normal">First Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="first_name">
                            <span id="firstNameError" style="color:red;display:none;"></span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="font-weight-normal">Last Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="last_name">
                            <span id="lastNameError" style="color:red;display:none;"></span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="font-weight-normal">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="font-weight-normal">Email Address <span class="required">*</span></label>
                            <input type="email" class="form-control" id="reg_email">
                            <span id="emailError" style="color:red;display:none;"></span>
                        </div>
                    </div>
                </div>

                <?php if (!isset($is_wholesale)): ?>
                <!-- Account Type only shown on regular signup -->
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="font-weight-normal">Account Type <span class="required">*</span></label>
                            <select class="form-control" id="user_type" onchange="toggleWholesaleFields()">
                                <option value="person" selected>Individual</option>
                                <option value="business">Business / Wholesaler</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="font-weight-normal">Company Name <span id="companyRequired" style="display:none;" class="required">*</span></label>
                            <input type="text" class="form-control" id="company_name">
                            <span id="companyNameError" style="color:red;display:none;"></span>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <!-- Wholesale: company name always shown, no account type dropdown -->
                <input type="hidden" id="user_type" value="business">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="font-weight-normal">Company Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="company_name">
                            <span id="companyNameError" style="color:red;display:none;"></span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Wholesale Extra Fields -->
                <div id="wholesaleFields" <?php echo isset($is_wholesale) ? '' : 'style="display:none;"'; ?>>
                    <h4 class="heading-primary text-uppercase mb-lg mt-lg" style="border-top:1px solid #eee; padding-top:15px;">
                        <i class="fa fa-building-o"></i> BUSINESS INFORMATION
                    </h4>
                    <div class="row">
                        <div class="col-sm-4">
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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="font-weight-normal">Companies House Number <small class="text-muted">(optional)</small></label>
                                <input type="text" class="form-control" id="companies_house_number" placeholder="e.g. 12345678">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="font-weight-normal">VAT / Tax Number <small class="text-muted">(optional)</small></label>
                                <input type="text" class="form-control" id="vat_number" placeholder="e.g. GB123456789">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="font-weight-normal">Website / Social Media <small class="text-muted">(optional)</small></label>
                                <input type="text" class="form-control" id="website" placeholder="e.g. www.yourbusiness.com">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="font-weight-normal">Estimated Volume (cases per order) <span class="required">*</span></label>
                                <select class="form-control" id="estimated_volume">
                                    <option value="">Select Range</option>
                                    <option value="1-10">1 &ndash; 10 cases</option>
                                    <option value="11-25">11 &ndash; 25 cases</option>
                                    <option value="26-50">26 &ndash; 50 cases</option>
                                    <option value="51-100">51 &ndash; 100 cases</option>
                                    <option value="100+">100+ cases</option>
                                </select>
                                <span id="estimatedVolumeError" style="color:red;display:none;"></span>
                            </div>
                        </div>
                        <div class="col-sm-4">
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

                    <h4 class="heading-primary text-uppercase mb-lg mt-lg" style="border-top:1px solid #eee; padding-top:15px;">
                        <i class="fa fa-map-marker"></i> BUSINESS ADDRESS
                    </h4>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="font-weight-normal">Street Address <span class="required">*</span></label>
                                <input type="text" class="form-control" id="business_address" placeholder="Street address, building number">
                                <span id="businessAddressError" style="color:red;display:none;"></span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="font-weight-normal">City <span class="required">*</span></label>
                                <input type="text" class="form-control" id="city" placeholder="City">
                                <span id="cityError" style="color:red;display:none;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="font-weight-normal">Postal Code <span class="required">*</span></label>
                                <input type="text" class="form-control" id="postal_code" placeholder="Postal / ZIP code">
                                <span id="postalCodeError" style="color:red;display:none;"></span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="font-weight-normal">Country <span class="required">*</span></label>
                                <select class="form-control" id="country">
                                    <option value="">Select Country</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="France">France</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Other">Other</option>
                                </select>
                                <span id="countryError" style="color:red;display:none;"></span>
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
                            <a href="<?php echo isset($is_wholesale) ? base_url('wholesale') : base_url('sign-in'); ?>" class="pull-left">
                                <i class="fa fa-angle-double-left"></i> <?php echo isset($is_wholesale) ? 'Back to Wholesale' : 'Back to Login'; ?>
                            </a>
                            <input onclick="return doSignup();" class="btn btn-primary" id="submitBtn"
                                value="<?php echo isset($is_wholesale) ? 'Submit Application' : 'Create Account'; ?>" type="button">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
var isWholesalePage = <?php echo isset($is_wholesale) ? 'true' : 'false'; ?>;

function toggleWholesaleFields() {
    var isBusiness = $('#user_type').val() === 'business';
    if (isBusiness) {
        $('#wholesaleFields').slideDown(300);
        $('#companyRequired').show();
        $('#submitBtn').val('Submit Application');
    } else {
        $('#wholesaleFields').slideUp(300);
        $('#companyRequired').hide();
        $('#submitBtn').val('Create Account');
    }
}

function doSignup() {
    var first_name = $.trim($('#first_name').val());
    var last_name  = $.trim($('#last_name').val());
    var email      = $.trim($('#reg_email').val());
    var mobile     = $.trim($('#mobile').val());
    var company_name = $.trim($('#company_name').val());
    var user_type  = $('#user_type').val();
    var password   = $('#reg_password').val();
    var confirm_password = $('#confirm_password').val();
    var isWholesale = (user_type === 'business');
    var valid = true;

    // Clear all errors
    $('.form-error').hide();

    if (!first_name) { $('#firstNameError').show().html('<strong>Enter your first name.</strong>'); valid = false; }
    if (!last_name)  { $('#lastNameError').show().html('<strong>Enter your last name.</strong>'); valid = false; }
    if (!email || email.indexOf('@') < 1) { $('#emailError').show().html('<strong>Enter a valid email.</strong>'); valid = false; }
    if (!password)   { $('#passwordError').show().html('<strong>Enter your password.</strong>'); valid = false; }
    if (password && password !== confirm_password) { $('#confirmPasswordError').show().html('<strong>Passwords do not match.</strong>'); valid = false; }

    if (isWholesale) {
        if (!company_name)              { $('#companyNameError').show().html('<strong>Enter your company name.</strong>'); valid = false; }
        if (!$('#business_type').val()) { $('#businessTypeError').show().html('<strong>Select your business type.</strong>'); valid = false; }
        if (!$('#estimated_volume').val()) { $('#estimatedVolumeError').show().html('<strong>Select estimated volume.</strong>'); valid = false; }
        if (!$.trim($('#business_address').val())) { $('#businessAddressError').show().html('<strong>Enter your business address.</strong>'); valid = false; }
        if (!$.trim($('#city').val()))        { $('#cityError').show().html('<strong>Enter your city.</strong>'); valid = false; }
        if (!$.trim($('#postal_code').val())) { $('#postalCodeError').show().html('<strong>Enter your postal code.</strong>'); valid = false; }
        if (!$('#country').val())             { $('#countryError').show().html('<strong>Select your country.</strong>'); valid = false; }
    }

    if (!valid) return false;

    var data = {
        first_name:   first_name,
        last_name:    last_name,
        email:        email,
        mobile:       mobile,
        company_name: company_name,
        user_type:    user_type,
        password:     password
    };

    if (isWholesale) {
        data.business_type          = $('#business_type').val();
        data.companies_house_number = $.trim($('#companies_house_number').val());
        data.vat_number             = $.trim($('#vat_number').val());
        data.website                = $.trim($('#website').val());
        data.estimated_volume       = $('#estimated_volume').val();
        data.monthly_order          = $('#monthly_order').val();
        data.business_address       = $.trim($('#business_address').val());
        data.city                   = $.trim($('#city').val());
        data.postal_code            = $.trim($('#postal_code').val());
        data.country                = $('#country').val();
    }

    $('#submitBtn').prop('disabled', true).val('Please wait...');

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/appuser/ajax_signup',
        data: data,
        success: function(r) {
            $('#submitBtn').prop('disabled', false).val(isWholesalePage ? 'Submit Application' : 'Create Account');
            if (r === 'success') {
                var msg = isWholesalePage
                    ? '<div class="alert alert-success"><strong>Application submitted! Our team will review and activate your account.</strong></div>'
                    : '<div class="alert alert-success"><strong>Account created! You can now <a href="' + BASE_URL + '/sign-in">log in</a>.</strong></div>';
                $('#resSuccessMsg').html(msg);
                $('html,body').animate({scrollTop: 0}, 400);
            } else if (r === 'duplicate_email') {
                $('#resErrorMsg').html('<div class="alert alert-danger"><strong>This email is already registered.</strong></div>');
                $('html,body').animate({scrollTop: 0}, 400);
            } else {
                $('#resErrorMsg').html('<div class="alert alert-danger"><strong>Registration failed. Please try again.</strong></div>');
            }
        },
        error: function() {
            $('#submitBtn').prop('disabled', false).val(isWholesalePage ? 'Submit Application' : 'Create Account');
            $('#resErrorMsg').html('<div class="alert alert-danger"><strong>An error occurred. Please try again.</strong></div>');
        }
    });
    return false;
}
</script>
