<section class="form-section register-form">
    <div class="container">
        <h1 class="h2 heading-primary font-weight-normal mb-md mt-lg">Apply as Wholesaler</h1>

        <div class="alert alert-info" style="border-left:4px solid #ff6000; background:#fafaf5;">
            <i class="fa fa-info-circle"></i> Fill in your business details below to apply for a wholesale account. Our team will review and activate your account.
        </div>

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
                            <label class="font-weight-normal">Mobile Number <span class="required">*</span></label>
                            <input type="text" class="form-control" id="mobile">
                            <span id="mobileError" style="color:red;display:none;"></span>
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

                <!-- Business Info -->
                <h4 class="heading-primary text-uppercase mb-lg mt-lg" style="border-top:1px solid #eee; padding-top:15px;">
                    <i class="fa fa-building-o"></i> BUSINESS INFORMATION
                </h4>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="font-weight-normal">Company Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="company_name">
                            <span id="companyNameError" style="color:red;display:none;"></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="font-weight-normal">Company Registration Number <span class="required">*</span></label>
                            <input type="text" class="form-control" id="company_reg_number" placeholder="e.g. 12345678">
                            <span id="companyRegError" style="color:red;display:none;"></span>
                        </div>
                    </div>
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
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="font-weight-normal">VAT / Tax Number <small class="text-muted">(optional)</small></label>
                            <input type="text" class="form-control" id="vat_number" placeholder="e.g. GB123456789">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="font-weight-normal">Website / Social Media <small class="text-muted">(optional)</small></label>
                            <input type="text" class="form-control" id="website" placeholder="e.g. www.yourbusiness.com">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="font-weight-normal">Estimated Volume (cases/order) <span class="required">*</span></label>
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
                </div>
                <div class="row">
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

                <!-- Business Address -->
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

                <!-- Login Info -->
                <h4 class="heading-primary text-uppercase mb-lg mt-lg" style="border-top:1px solid #eee; padding-top:15px;">LOGIN INFORMATION</h4>
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
                            <a href="<?php echo base_url('sign-in'); ?>" class="pull-left">
                                <i class="fa fa-angle-double-left"></i> Back to Login
                            </a>
                            <input onclick="return doSignup();" class="btn btn-primary" id="submitBtn" value="Submit Application" type="button">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
function doSignup() {
    var first_name          = $.trim($('#first_name').val());
    var last_name           = $.trim($('#last_name').val());
    var email               = $.trim($('#reg_email').val());
    var mobile              = $.trim($('#mobile').val());
    var company_name        = $.trim($('#company_name').val());
    var company_reg_number  = $.trim($('#company_reg_number').val());
    var business_type       = $('#business_type').val();
    var estimated_volume    = $('#estimated_volume').val();
    var business_address    = $.trim($('#business_address').val());
    var city                = $.trim($('#city').val());
    var postal_code         = $.trim($('#postal_code').val());
    var country             = $('#country').val();
    var password            = $('#reg_password').val();
    var confirm_password    = $('#confirm_password').val();
    var valid = true;

    // Clear errors
    $('[id$="Error"]').hide().html('');

    if (!first_name)         { $('#firstNameError').show().html('<strong>Enter your first name.</strong>'); valid = false; }
    if (!last_name)          { $('#lastNameError').show().html('<strong>Enter your last name.</strong>'); valid = false; }
    if (!mobile)          { $('#mobileError').show().html('<strong>Enter your contact number.</strong>'); valid = false; }
    if (!email || email.indexOf('@') < 1) { $('#emailError').show().html('<strong>Enter a valid email.</strong>'); valid = false; }
    if (!company_name)       { $('#companyNameError').show().html('<strong>Enter your company name.</strong>'); valid = false; }
    if (!company_reg_number) { $('#companyRegError').show().html('<strong>Company Registration Number is required.</strong>'); valid = false; }
    if (!business_type)      { $('#businessTypeError').show().html('<strong>Select your business type.</strong>'); valid = false; }
    if (!estimated_volume)   { $('#estimatedVolumeError').show().html('<strong>Select estimated volume.</strong>'); valid = false; }
    if (!business_address)   { $('#businessAddressError').show().html('<strong>Enter your business address.</strong>'); valid = false; }
    if (!city)               { $('#cityError').show().html('<strong>Enter your city.</strong>'); valid = false; }
    if (!postal_code)        { $('#postalCodeError').show().html('<strong>Enter your postal code.</strong>'); valid = false; }
    if (!country)            { $('#countryError').show().html('<strong>Select your country.</strong>'); valid = false; }
    if (!password)           { $('#passwordError').show().html('<strong>Enter your password.</strong>'); valid = false; }
    if (password && password !== confirm_password) { $('#confirmPasswordError').show().html('<strong>Passwords do not match.</strong>'); valid = false; }

    if (!valid) return false;

    $('#submitBtn').prop('disabled', true).val('Please wait...');

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/appuser/ajax_signup',
        data: {
            user_type:           'business',
            first_name:          first_name,
            last_name:           last_name,
            email:               email,
            mobile:              mobile,
            company_name:        company_name,
            company_reg_number:  company_reg_number,
            business_type:       business_type,
            vat_number:          $.trim($('#vat_number').val()),
            website:             $.trim($('#website').val()),
            estimated_volume:    estimated_volume,
            monthly_order:       $('#monthly_order').val(),
            business_address:    business_address,
            city:                city,
            postal_code:         postal_code,
            country:             country,
            password:            password
        },
        success: function(r) {
            $('#submitBtn').prop('disabled', false).val('Submit Application');
            if (r === 'success') {
                $('#resSuccessMsg').html('<div class="alert alert-success"><strong>Application submitted! Our team will review and activate your account. You can now <a href="' + BASE_URL + '/sign-in">log in</a>.</strong></div>');
                $('html,body').animate({scrollTop: 0}, 400);
                // Clear form
                $('input[type="text"], input[type="email"], input[type="password"], select, textarea').val('');
            } else if (r === 'duplicate_email') {
                $('#resErrorMsg').html('<div class="alert alert-danger"><strong>This email is already registered. <a href="' + BASE_URL + '/sign-in">Login here</a>.</strong></div>');
                $('html,body').animate({scrollTop: 0}, 400);
            } else {
                $('#resErrorMsg').html('<div class="alert alert-danger"><strong>Registration failed. Please try again.</strong></div>');
            }
        },
        error: function() {
            $('#submitBtn').prop('disabled', false).val('Submit Application');
            $('#resErrorMsg').html('<div class="alert alert-danger"><strong>An error occurred. Please try again.</strong></div>');
        }
    });
    return false;
}
</script>
