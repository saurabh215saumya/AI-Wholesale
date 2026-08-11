<section class="form-section">
    <div class="container">
        <h1 class="h2 heading-primary font-weight-normal mb-md mt-lg">Reset Password</h1>
        <?php echo $this->session->flashdata('error') ? '<div class="alert alert-danger">'.$this->session->flashdata('error').'</div>' : ''; ?>

        <?php if(!empty($valid_token)): ?>
        <div class="featured-box featured-box-primary featured-box-flat featured-box-text-left mt-md" style="max-width:480px;">
            <div class="box-content">
                <p style="color:#666;margin-bottom:20px;">Enter your new password below.</p>
                <form id="reset-form">
                    <input type="hidden" id="reset_token" value="<?php echo htmlspecialchars($token); ?>">
                    <div class="form-group">
                        <label class="font-weight-normal">New Password <span class="required">*</span></label>
                        <input type="password" id="new_password" class="form-control" placeholder="Minimum 6 characters">
                        <span id="new_pass_err" style="color:red;font-size:12px;display:none;"></span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-normal">Confirm Password <span class="required">*</span></label>
                        <input type="password" id="confirm_password" class="form-control" placeholder="Re-enter new password">
                        <span id="confirm_pass_err" style="color:red;font-size:12px;display:none;"></span>
                    </div>
                    <div id="reset_msg"></div>
                    <button type="button" onclick="submitReset()" class="btn btn-primary" id="reset_btn">
                        <i class="fa fa-lock"></i> Reset Password
                    </button>
                </form>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-triangle"></i> This reset link is invalid or has expired.
            <a href="<?php echo base_url('forgot-password'); ?>">Request a new one</a>.
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
function submitReset() {
    var pass = $('#new_password').val().trim();
    var conf = $('#confirm_password').val().trim();
    var valid = true;
    if (pass.length < 6) { $('#new_pass_err').show().text('Password must be at least 6 characters.'); valid = false; } else { $('#new_pass_err').hide(); }
    if (pass !== conf) { $('#confirm_pass_err').show().text('Passwords do not match.'); valid = false; } else { $('#confirm_pass_err').hide(); }
    if (!valid) return;
    var btn = document.getElementById('reset_btn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Resetting...';
    $.post(BASE_URL + '/ajax-reset-password', {
        token: $('#reset_token').val(),
        password: pass
    }, function(res) {
        if (res === 'success') {
            $('#reset_msg').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> Password reset successfully! <a href="' + BASE_URL + '/sign-in">Login now</a>.</div>');
            $('#reset-form input, #reset_btn').prop('disabled', true);
        } else if (res === 'expired') {
            $('#reset_msg').html('<div class="alert alert-danger">This link has expired. <a href="' + BASE_URL + '/forgot-password">Request a new one</a>.</div>');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-lock"></i> Reset Password';
        } else {
            $('#reset_msg').html('<div class="alert alert-danger">Something went wrong. Please try again.</div>');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-lock"></i> Reset Password';
        }
    });
}
</script>
