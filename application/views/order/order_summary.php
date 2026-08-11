<div style="background:#f8f9fa;padding:30px 0;border-bottom:1px solid #eee;">
  <div class="container">
    <h2>Order in Review</h2>
    <ol class="breadcrumb" style="background:none;padding:0;margin:0;">
      <li><a href="<?php echo base_url(); ?>">Home</a></li>
      <li class="active">Order Summary</li>
    </ol>
  </div>
</div>
<div class="container" style="padding:50px 15px;">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 text-center">
      <div style="background:#fff;border:1px solid #eee;border-radius:10px;padding:40px;">
        <i class="fa fa-check-circle fa-5x" style="color:#5cb85c;"></i>
        <h3 style="margin-top:20px;font-weight:700;">Thank You! Your Order is in Review, update within 24 hours.</h3>
        <?php if(!empty($orderDetails)): ?>
        <p style="color:#666;">Order #<?php echo $orderDetails['id']; ?> &mdash; Transaction: <strong><?php echo $orderDetails['transaction_no']; ?></strong></p>
        <p style="font-size:20px;font-weight:700;color:#e44;">Total: £<?php echo number_format($orderDetails['total_amount'],2); ?></p>
        <p style="color:#888;">We will process your order shortly. You can track it in <a href="<?php echo base_url('my-orders'); ?>">My Orders</a>.</p>
        <?php endif; ?>
        <div style="margin-top:25px;">
          <a href="<?php echo base_url('all-products'); ?>" class="btn btn-primary">Continue Shopping</a>
          <a href="<?php echo base_url('my-orders'); ?>" class="btn btn-default" style="margin-left:10px;">View My Orders</a>
        </div>
      </div>
    </div>
  </div>
</div>
