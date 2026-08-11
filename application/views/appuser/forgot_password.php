<section class="form-section">
    <div class="container">
        <h1 class="h2 heading-primary font-weight-normal mb-md mt-lg">Forgot Password</h1>
        <?php echo $this->session->flashdata('success') ? '<div class="alert alert-success">'.$this->session->flashdata('success').'</div>' : ''; ?>
        <?php echo $this->session->flashdata('error') ? '<div class="alert alert-danger">'.$this->session->flashdata('error').'</div>' : ''; ?>

        <div class="featured-box featured-box-primary featured-box-flat featured-box-text-left mt-md" style="max-width:480px;">
            <div class="box-content">
                <p style="color:#666;margin-bottom:20px;">Enter your registered email address and we'll send you a link to reset your password.</p>
                <form id="forgot-form">
                    <div class="form-group">
                        <label class="font-weight-normal">Email Address <span class="required">*</span></label>
                        <input type="email" id="forgot_email" class="form-control" placeholder="your@email.com">
                        <span id="forgot_email_err" style="color:red;font-size:12px;display:none;"></span>
                    </div>
                    <div id="forgot_msg"></div>
                    <button type="button" onclick="submitForgot()" class="btn btn-primary" id="forgot_btn">
                        <i class="fa fa-paper-plane"></i> Send Reset Link
                    </button>
                    <a href="<?php echo base_url('sign-in'); ?>" class="btn btn-default" style="margin-left:8px;">Back to Login</a>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
function submitForgot() {
    var email = $('#forgot_email').val().trim();
    if (!email) { $('#forgot_email_err').show().text('Please enter your email address.'); return; }
    $('#forgot_email_err').hide();
    var btn = document.getElementById('forgot_btn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sending...';
    $.post(BASE_URL + '/ajax-forgot-password', {email: email}, function(res) {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-paper-plane"></i> Send Reset Link';
        if (res === 'success') {
            $('#forgot_msg').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> Reset link sent! Please check your email.</div>');
            $('#forgot_email').val('').prop('disabled', true);
        } else if (res === 'not_found') {
            $('#forgot_msg').html('<div class="alert alert-danger">No account found with that email address.</div>');
        } else {
            $('#forgot_msg').html('<div class="alert alert-danger">Something went wrong. Please try again.</div>');
        }
    });
}
</script>
