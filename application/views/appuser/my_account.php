<?php $u = $details; ?>
<style>
.ma-wrap { max-width: 1100px; margin: 0 auto; padding: 30px 15px 60px; }
.ma-sidebar { background: #fff; border-radius: 14px; border: 1px solid #ffe5d0; box-shadow: 0 4px 20px rgba(255,96,0,.07); overflow: hidden; }
.ma-sidebar-header { background: linear-gradient(135deg,#ff6000,#ff8c42); padding: 24px 20px; text-align: center; }
.ma-avatar { width: 70px; height: 70px; border-radius: 50%; background: rgba(255,255,255,.25); border: 3px solid rgba(255,255,255,.6); display: flex; align-items: center; justify-content: center; font-size: 28px; color: #fff; margin: 0 auto 10px; }
.ma-sidebar-name { color: #fff; font-weight: 700; font-size: 15px; margin: 0 0 2px; }
.ma-sidebar-type { color: rgba(255,255,255,.8); font-size: 12px; }
.ma-nav a { display: flex; align-items: center; gap: 10px; padding: 13px 20px; font-size: 13px; font-weight: 600; color: #555; text-decoration: none; border-left: 3px solid transparent; transition: all .2s; border-bottom: 1px solid #f8f0ea; }
.ma-nav a:last-child { border-bottom: none; }
.ma-nav a i { width: 16px; text-align: center; color: #ff6000; }
.ma-nav a:hover { background: #fff8f5; color: #ff6000; border-left-color: #ff6000; }
.ma-nav a.active { background: #fff3ee; color: #ff6000; border-left-color: #ff6000; font-weight: 700; }
.ma-nav a.logout-link { color: #e44; }
.ma-nav a.logout-link i { color: #e44; }
.ma-nav a.logout-link:hover { background: #fff5f5; border-left-color: #e44; }
.ma-card { background: #fff; border-radius: 14px; border: 1px solid #ffe5d0; box-shadow: 0 4px 20px rgba(255,96,0,.07); padding: 28px; margin-bottom: 20px; }
.ma-card-title { font-size: 16px; font-weight: 700; color: #222; margin: 0 0 20px; padding-bottom: 12px; border-bottom: 2px solid #ff6000; display: flex; align-items: center; gap: 8px; }
.ma-card-title i { color: #ff6000; }
.ma-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
@media(max-width:600px) { .ma-info-grid { grid-template-columns: 1fr; } }
.ma-info-item { background: #fafafa; border-radius: 10px; padding: 12px 16px; border: 1px solid #f0e8e0; }
.ma-info-label { font-size: 11px; font-weight: 700; color: #aaa; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px; }
.ma-info-value { font-size: 14px; font-weight: 600; color: #333; }
.ma-form-group { margin-bottom: 14px; }
.ma-form-group label { display: block; font-size: 12px; font-weight: 700; color: #555; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 5px; }
.ma-form-group input { width: 100%; border: 1.5px solid #e8e8e8; border-radius: 10px; padding: 11px 14px; font-size: 14px; color: #333; outline: none; transition: all .2s; background: #fafafa; box-sizing: border-box; }
.ma-form-group input:focus { border-color: #ff6000; background: #fff; box-shadow: 0 0 0 3px rgba(255,96,0,.1); }
.ma-form-row { display: flex; gap: 14px; }
.ma-form-row .ma-form-group { flex: 1; }
@media(max-width:600px) { .ma-form-row { flex-direction: column; gap: 0; } }
.ma-btn-save { background: linear-gradient(90deg,#ff6000,#ff8c42); border: none; border-radius: 30px; color: #fff; font-size: 14px; font-weight: 700; padding: 12px 30px; cursor: pointer; transition: all .2s; }
.ma-btn-save:hover { opacity: .9; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(255,96,0,.3); }
.ma-badge { display: inline-block; background: linear-gradient(90deg,#ff6000,#ff8c42); color: #fff; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
</style>

<section class="page-header mb-lg" style="background:linear-gradient(135deg,#fff5f0,#fff);border-bottom:2px solid #ffe5d0;">
    <div class="container">
        <h1 style="font-size:22px;font-weight:700;color:#222;margin:0 0 6px;">My Account</h1>
        <ul class="breadcrumb" style="background:none;padding:0;margin:0;">
            <li><a href="<?php echo base_url(); ?>" style="color:#ff6000;">Home</a></li>
            <li class="active">My Account</li>
        </ul>
    </div>
</section>

<div class="ma-wrap">
    <?php echo $this->session->flashdata('success') ? '<div class="alert alert-success" style="border-radius:10px;border-left:4px solid #28a745;">'.$this->session->flashdata('success').'</div>' : ''; ?>
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="ma-sidebar">
                <div class="ma-sidebar-header">
                    <div class="ma-avatar"><i class="fa fa-user"></i></div>
                    <div class="ma-sidebar-name"><?php echo htmlspecialchars($u['first_name'].' '.$u['last_name']); ?></div>
                    <div class="ma-sidebar-type"><span class="ma-badge"><?php echo ucfirst($u['user_type']); ?></span></div>
                </div>
                <div class="ma-nav">
                    <a href="<?php echo base_url('my-account'); ?>" class="active"><i class="fa fa-user-circle"></i> Account Details</a>
                    <a href="<?php echo base_url('my-orders'); ?>"><i class="fa fa-shopping-bag"></i> My Orders</a>
                    <a href="<?php echo base_url('billing-address'); ?>"><i class="fa fa-map-marker"></i> Addresses</a>
                    <a href="<?php echo base_url('wish-list'); ?>"><i class="fa fa-heart"></i> Wishlist</a>
                    <a href="<?php echo base_url('sign-out'); ?>" class="logout-link"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Account Info -->
            <div class="ma-card">
                <div class="ma-card-title"><i class="fa fa-info-circle"></i> Account Overview</div>
                <div class="ma-info-grid">
                    <div class="ma-info-item">
                        <div class="ma-info-label">Full Name</div>
                        <div class="ma-info-value"><?php echo htmlspecialchars($u['first_name'].' '.$u['last_name']); ?></div>
                    </div>
                    <div class="ma-info-item">
                        <div class="ma-info-label">Email</div>
                        <div class="ma-info-value"><?php echo htmlspecialchars($u['email']); ?></div>
                    </div>
                    <div class="ma-info-item">
                        <div class="ma-info-label">Mobile</div>
                        <div class="ma-info-value"><?php echo $u['mobile'] ? htmlspecialchars($u['mobile']) : '<span style="color:#bbb;">Not set</span>'; ?></div>
                    </div>
                    <div class="ma-info-item">
                        <div class="ma-info-label">Company</div>
                        <div class="ma-info-value"><?php echo $u['company_name'] ? htmlspecialchars($u['company_name']) : '<span style="color:#bbb;">Not set</span>'; ?></div>
                    </div>
                    <div class="ma-info-item">
                        <div class="ma-info-label">Account Type</div>
                        <div class="ma-info-value"><span class="ma-badge"><?php echo ucfirst($u['user_type']); ?></span></div>
                    </div>
                    <div class="ma-info-item">
                        <div class="ma-info-label">Member Since</div>
                        <div class="ma-info-value"><?php echo date('d M Y', strtotime($u['addedOn'])); ?></div>
                    </div>
                </div>
            </div>

            <!-- Edit Profile -->
            <div class="ma-card">
                <div class="ma-card-title"><i class="fa fa-pencil"></i> Edit Profile</div>
                <?php echo form_open('update-account'); ?>
                <div class="ma-form-row">
                    <div class="ma-form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="<?php echo htmlspecialchars($u['first_name']); ?>" required>
                    </div>
                    <div class="ma-form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="<?php echo htmlspecialchars($u['last_name']); ?>">
                    </div>
                </div>
                <div class="ma-form-group">
                    <label>Mobile</label>
                    <input type="text" name="mobile" value="<?php echo htmlspecialchars($u['mobile']); ?>">
                </div>
                <div class="ma-form-group">
                    <label>Company Name</label>
                    <input type="text" name="company_name" value="<?php echo htmlspecialchars($u['company_name']); ?>">
                </div>
                <div class="ma-form-row">
                    <div class="ma-form-group">
                        <label>New Password <small style="color:#aaa;font-weight:400;text-transform:none;">(leave blank to keep current)</small></label>
                        <input type="password" name="new_password" placeholder="Enter new password">
                    </div>
                    <div class="ma-form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password">
                    </div>
                </div>
                <button type="submit" class="ma-btn-save"><i class="fa fa-save"></i>&nbsp; Save Changes</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelector('form[action*="update-account"]').addEventListener('submit', function(e) {
    var np = this.querySelector('[name="new_password"]').value;
    var cp = document.getElementById('confirm_password').value;
    if (np && np !== cp) { e.preventDefault(); alert('Passwords do not match.'); }
});
</script>
