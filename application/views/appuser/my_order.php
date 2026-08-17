<style>
.ma-wrap { max-width: 1100px; margin: 0 auto; padding: 30px 15px 60px; }
.ma-sidebar { background: #fff; border-radius: 14px; border: 1px solid #ffe5d0; box-shadow: 0 4px 20px rgba(255,96,0,.07); overflow: hidden; }
.ma-sidebar-header { background: linear-gradient(135deg,#ff6000,#ff8c42); padding: 24px 20px; text-align: center; }
.ma-avatar { width: 70px; height: 70px; border-radius: 50%; background: rgba(255,255,255,.25); border: 3px solid rgba(255,255,255,.6); display: flex; align-items: center; justify-content: center; font-size: 28px; color: #fff; margin: 0 auto 10px; }
.ma-sidebar-name { color: #fff; font-weight: 700; font-size: 15px; margin: 0 0 2px; }
.ma-nav a { display: flex; align-items: center; gap: 10px; padding: 13px 20px; font-size: 13px; font-weight: 600; color: #555; text-decoration: none; border-left: 3px solid transparent; transition: all .2s; border-bottom: 1px solid #f8f0ea; }
.ma-nav a:last-child { border-bottom: none; }
.ma-nav a i { width: 16px; text-align: center; color: #ff6000; }
.ma-nav a:hover { background: #fff8f5; color: #ff6000; border-left-color: #ff6000; }
.ma-nav a.active { background: #fff3ee; color: #ff6000; border-left-color: #ff6000; font-weight: 700; }
.ma-nav a.logout-link { color: #e44; }
.ma-nav a.logout-link i { color: #e44; }
.ma-nav a.logout-link:hover { background: #fff5f5; border-left-color: #e44; }
.ma-card { background: #fff; border-radius: 14px; border: 1px solid #ffe5d0; box-shadow: 0 4px 20px rgba(255,96,0,.07); padding: 28px; }
.ma-card-title { font-size: 16px; font-weight: 700; color: #222; margin: 0 0 20px; padding-bottom: 12px; border-bottom: 2px solid #ff6000; display: flex; align-items: center; gap: 8px; }
.ma-card-title i { color: #ff6000; }
.ma-orders-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.ma-orders-table thead tr { border-bottom: 2px solid #ff6000; }
.ma-orders-table thead th { padding: 10px 12px; font-weight: 700; color: #555; text-transform: uppercase; font-size: 11px; letter-spacing: .5px; }
.ma-orders-table tbody tr { border-bottom: 1px solid #f5ede8; transition: background .15s; }
.ma-orders-table tbody tr:hover { background: #fff8f5; }
.ma-orders-table tbody td { padding: 12px; color: #444; vertical-align: middle; }
.ma-status { display: inline-block; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; }
.ma-status-0 { background: #fff3cd; color: #856404; }
.ma-status-1 { background: #d1e7dd; color: #0a5c36; }
.ma-status-2 { background: #f8d7da; color: #842029; }
.ma-empty { text-align: center; padding: 50px 20px; }
.ma-empty i { font-size: 48px; color: #ffd0b0; margin-bottom: 14px; display: block; }
.ma-empty p { color: #999; font-size: 14px; margin-bottom: 18px; }
.ma-shop-btn { display: inline-block; background: linear-gradient(90deg,#ff6000,#ff8c42); color: #fff; border-radius: 30px; padding: 10px 24px; font-size: 13px; font-weight: 700; text-decoration: none; transition: opacity .2s; }
.ma-shop-btn:hover { opacity: .88; color: #fff; text-decoration: none; }
.ma-badge { display: inline-block; background: linear-gradient(90deg,#ff6000,#ff8c42); color: #fff; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
</style>

<?php if($this->input->get('payment') === 'success'): ?>
<div class="container" style="padding-top:20px;">
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <strong>Payment successful!</strong> Your payment has been received. A confirmation email has been sent to you.</div>
</div>
<?php elseif($this->input->get('payment') === 'confirmed'): ?>
<div class="container" style="padding-top:20px;">
  <div class="alert alert-info"><i class="fa fa-info-circle"></i> <strong>Offline payment confirmed.</strong> Our team will contact you with payment details shortly.</div>
</div>
<?php endif; ?>

<section class="page-header mb-lg" style="background:linear-gradient(135deg,#fff5f0,#fff);border-bottom:2px solid #ffe5d0;">
    <div class="container">
        <h1 style="font-size:22px;font-weight:700;color:#222;margin:0 0 6px;">My Orders</h1>
        <ul class="breadcrumb" style="background:none;padding:0;margin:0;">
            <li><a href="<?php echo base_url(); ?>" style="color:#ff6000;">Home</a></li>
            <li><a href="<?php echo base_url('my-account'); ?>" style="color:#ff6000;">My Account</a></li>
            <li class="active">My Orders</li>
        </ul>
    </div>
</section>
    <div class="container">
        <h1 style="font-size:22px;font-weight:700;color:#222;margin:0 0 6px;">My Orders</h1>
        <ul class="breadcrumb" style="background:none;padding:0;margin:0;">
            <li><a href="<?php echo base_url(); ?>" style="color:#ff6000;">Home</a></li>
            <li><a href="<?php echo base_url('my-account'); ?>" style="color:#ff6000;">My Account</a></li>
            <li class="active">My Orders</li>
        </ul>
    </div>
</section>

<div class="ma-wrap">
    <div class="row">
        <div class="col-md-3">
            <div class="ma-sidebar">
                <div class="ma-sidebar-header">
                    <div class="ma-avatar"><i class="fa fa-user"></i></div>
                    <div class="ma-sidebar-name"><?php $s = $this->session->userdata('front_logged_in'); echo htmlspecialchars($s['first_name'].' '.$s['last_name']); ?></div>
                </div>
                <div class="ma-nav">
                    <a href="<?php echo base_url('my-account'); ?>"><i class="fa fa-user-circle"></i> Account Details</a>
                    <a href="<?php echo base_url('my-orders'); ?>" class="active"><i class="fa fa-shopping-bag"></i> My Orders</a>
                    <a href="<?php echo base_url('billing-address'); ?>"><i class="fa fa-map-marker"></i> Addresses</a>
                    <a href="<?php echo base_url('wish-list'); ?>"><i class="fa fa-heart"></i> Wishlist</a>
                    <a href="<?php echo base_url('sign-out'); ?>" class="logout-link"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="ma-card">
                <div class="ma-card-title"><i class="fa fa-shopping-bag"></i> Order History</div>
                <?php if(!empty($orders)): ?>
                <div style="overflow-x:auto;">
                <table class="ma-orders-table">
                    <thead><tr>
                        <th>Order #</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Order Status</th>
                        <th>Pay Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr></thead>
                    <tbody>
                    <?php $statusLabels = array('0'=>'In Review','1'=>'Confirmed','2'=>'Cancelled');
                    foreach($orders as $o): ?>
                    <tr>
                        <td><strong style="color:#ff6000;">#<?php echo $o['id']; ?></strong></td>
                        <td><strong>£<?php echo number_format($o['total_amount'],2); ?></strong></td>
                        <td>
                          <?php if($o['payment_method'] === 'offline'): ?>
                          <span style="background:#fff3cd;color:#856404;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">Offline</span>
                          <?php elseif($o['payment_method'] === 'stripe'): ?>
                          <span style="background:#d1e7dd;color:#0a5c36;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">Stripe</span>
                          <?php else: ?>
                          <span style="background:#e2e3e5;color:#383d41;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">Pending</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php
                          $sLabel = array('0'=>'In Review','1'=>'Confirmed','2'=>'Cancelled');
                          $sColor = array('0'=>'#856404;background:#fff3cd','1'=>'#0a5c36;background:#d1e7dd','2'=>'#842029;background:#f8d7da');
                          $s = $o['status'];
                          ?>
                          <span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;color:<?php echo $sColor[$s] ?? '#555;background:#eee'; ?>"><?php echo $sLabel[$s] ?? 'Unknown'; ?></span>
                        </td>
                        <td>
                          <?php if($o['payment_status'] == 1): ?>
                          <span style="background:#d1e7dd;color:#0a5c36;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">Paid</span>
                          <?php else: ?>
                          <span style="background:#f8d7da;color:#842029;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">Unpaid</span>
                          <?php endif; ?>
                        </td>
                        <td style="color:#888;"><?php echo date('d M Y', strtotime($o['addedOn'])); ?></td>
                        <td>
                          <?php if($o['status'] == 1 && $o['payment_status'] == 0): ?>
                          <a href="<?php echo base_url('order/pay/'.$o['id']); ?>" class="ma-shop-btn" style="padding:6px 14px;font-size:12px;"><i class="fa fa-credit-card"></i> Pay Now</a>
                          <?php else: ?>
                          <span style="color:#aaa;font-size:12px;">-</span>
                          <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <?php else: ?>
                <div class="ma-empty">
                    <i class="fa fa-shopping-bag"></i>
                    <p>You haven't placed any orders yet.</p>
                    <a href="<?php echo base_url('all-products'); ?>" class="ma-shop-btn"><i class="fa fa-shopping-cart"></i>&nbsp; Start Shopping</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
