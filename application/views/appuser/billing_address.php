<style>
.ma-wrap { max-width: 1100px; margin: 0 auto; padding: 30px 15px 60px; }
.ma-sidebar { background: #fff; border-radius: 14px; border: 1px solid #ffe5d0; box-shadow: 0 4px 20px rgba(255,96,0,.07); overflow: hidden; }
.ma-sidebar-header { background: linear-gradient(135deg,#ff6000,#ff8c42); padding: 24px 20px; text-align: center; }
.ma-avatar { width: 70px; height: 70px; border-radius: 50%; background: rgba(255,255,255,.25); border: 3px solid rgba(255,255,255,.6); display: flex; align-items: center; justify-content: center; font-size: 28px; color: #fff; margin: 0 auto 10px; }
.ma-sidebar-name { color: #fff; font-weight: 700; font-size: 15px; }
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
.ma-addr-card { border: 1.5px solid #ffe5d0; border-radius: 12px; padding: 16px; margin-bottom: 14px; background: #fafafa; position: relative; transition: border-color .2s, box-shadow .2s; }
.ma-addr-card:hover { border-color: #ff6000; box-shadow: 0 4px 16px rgba(255,96,0,.1); }
.ma-addr-name { font-weight: 700; font-size: 14px; color: #222; margin-bottom: 4px; }
.ma-addr-text { font-size: 13px; color: #666; line-height: 1.6; }
.ma-addr-del { position: absolute; top: 12px; right: 12px; background: none; border: 1.5px solid #e44; color: #e44; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 700; cursor: pointer; transition: all .2s; text-decoration: none; }
.ma-addr-del:hover { background: #e44; color: #fff; }
.ma-form-group { margin-bottom: 14px; }
.ma-form-group label { display: block; font-size: 12px; font-weight: 700; color: #555; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 5px; }
.ma-form-group input { width: 100%; border: 1.5px solid #e8e8e8; border-radius: 10px; padding: 11px 14px; font-size: 14px; color: #333; outline: none; transition: all .2s; background: #fafafa; box-sizing: border-box; }
.ma-form-group input:focus { border-color: #ff6000; background: #fff; box-shadow: 0 0 0 3px rgba(255,96,0,.1); }
.ma-form-row { display: flex; gap: 14px; }
.ma-form-row .ma-form-group { flex: 1; }
@media(max-width:600px) { .ma-form-row { flex-direction: column; gap: 0; } }
.ma-btn-save { background: linear-gradient(90deg,#ff6000,#ff8c42); border: none; border-radius: 30px; color: #fff; font-size: 14px; font-weight: 700; padding: 12px 30px; cursor: pointer; transition: all .2s; }
.ma-btn-save:hover { opacity: .9; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(255,96,0,.3); }
</style>

<section class="page-header mb-lg" style="background:linear-gradient(135deg,#fff5f0,#fff);border-bottom:2px solid #ffe5d0;">
    <div class="container">
        <h1 style="font-size:22px;font-weight:700;color:#222;margin:0 0 6px;">Addresses</h1>
        <ul class="breadcrumb" style="background:none;padding:0;margin:0;">
            <li><a href="<?php echo base_url(); ?>" style="color:#ff6000;">Home</a></li>
            <li><a href="<?php echo base_url('my-account'); ?>" style="color:#ff6000;">My Account</a></li>
            <li class="active">Addresses</li>
        </ul>
    </div>
</section>

<div class="ma-wrap">
    <?php echo $this->session->flashdata('success') ? '<div class="alert alert-success" style="border-radius:10px;border-left:4px solid #28a745;">'.$this->session->flashdata('success').'</div>' : ''; ?>
    <div class="row">
        <div class="col-md-3">
            <div class="ma-sidebar">
                <div class="ma-sidebar-header">
                    <div class="ma-avatar"><i class="fa fa-user"></i></div>
                    <div class="ma-sidebar-name"><?php $s = $this->session->userdata('front_logged_in'); echo htmlspecialchars($s['first_name'].' '.$s['last_name']); ?></div>
                </div>
                <div class="ma-nav">
                    <a href="<?php echo base_url('my-account'); ?>"><i class="fa fa-user-circle"></i> Account Details</a>
                    <a href="<?php echo base_url('my-orders'); ?>"><i class="fa fa-shopping-bag"></i> My Orders</a>
                    <a href="<?php echo base_url('billing-address'); ?>" class="active"><i class="fa fa-map-marker"></i> Addresses</a>
                    <a href="<?php echo base_url('wish-list'); ?>"><i class="fa fa-heart"></i> Wishlist</a>
                    <a href="<?php echo base_url('sign-out'); ?>" class="logout-link"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <!-- Saved Addresses -->
            <?php if(!empty($billingArr)): ?>
            <div class="ma-card">
                <div class="ma-card-title"><i class="fa fa-map-marker"></i> Saved Addresses</div>
                <?php foreach($billingArr as $b): ?>
                <div class="ma-addr-card">
                    <a href="<?php echo base_url('delete-billing/'.$b['id']); ?>" class="ma-addr-del" onclick="return confirm('Remove this address?');"><i class="fa fa-trash"></i> Remove</a>
                    <div class="ma-addr-name"><?php echo htmlspecialchars($b['first_name'].' '.$b['last_name']); ?></div>
                    <div class="ma-addr-text">
                        <?php if($b['company_name']): ?><?php echo htmlspecialchars($b['company_name']); ?><br><?php endif; ?>
                        <?php echo htmlspecialchars($b['address_1']); ?>
                        <?php if($b['address_2']): ?>, <?php echo htmlspecialchars($b['address_2']); ?><?php endif; ?><br>
                        <?php echo htmlspecialchars($b['city'].', '.$b['postal_code']); ?><br>
                        <?php echo htmlspecialchars($b['country']); ?><br>
                        <?php if($b['contact']): ?><i class="fa fa-phone" style="color:#ff6000;"></i> <?php echo htmlspecialchars($b['contact']); ?><?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Add New Address -->
            <div class="ma-card">
                <div class="ma-card-title"><i class="fa fa-plus-circle"></i> Add New Address</div>
                <?php echo form_open('billing-address'); ?>
                <div class="ma-form-row">
                    <div class="ma-form-group"><label>First Name <span style="color:#ff6000;">*</span></label><input type="text" name="first_name" required></div>
                    <div class="ma-form-group"><label>Last Name</label><input type="text" name="last_name"></div>
                </div>
                <div class="ma-form-group"><label>Company Name</label><input type="text" name="company_name"></div>
                <div class="ma-form-group"><label>Address Line 1 <span style="color:#ff6000;">*</span></label><input type="text" name="address_1" required></div>
                <div class="ma-form-group"><label>Address Line 2</label><input type="text" name="address_2"></div>
                <div class="ma-form-row">
                    <div class="ma-form-group"><label>City <span style="color:#ff6000;">*</span></label><input type="text" name="city" required></div>
                    <div class="ma-form-group"><label>Postal Code <span style="color:#ff6000;">*</span></label><input type="text" name="postal_code" required></div>
                </div>
                <div class="ma-form-group"><label>Country <span style="color:#ff6000;">*</span></label><input type="text" name="country" value="United Kingdom" required></div>
                <div class="ma-form-row">
                    <div class="ma-form-group"><label>Email <span style="color:#ff6000;">*</span></label><input type="email" name="email" required></div>
                    <div class="ma-form-group"><label>Contact Number</label><input type="text" name="contact"></div>
                </div>
                <button type="submit" class="ma-btn-save"><i class="fa fa-save"></i>&nbsp; Save Address</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
