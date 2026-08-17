<div style="background:#f8f9fa;padding:30px 0;border-bottom:1px solid #eee;">
  <div class="container">
    <h2>Order in Review</h2>
    <ol class="breadcrumb" style="background:none;padding:0;margin:0;">
      <li><a href="<?php echo base_url(); ?>">Home</a></li>
      <li class="active">Order Confirmation</li>
    </ol>
  </div>
</div>
<div class="container" style="padding:50px 15px;">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div style="background:#fff;border:1px solid #eee;border-radius:10px;padding:40px;">
        <div class="text-center">
          <i class="fa fa-check-circle fa-5x" style="color:#5cb85c;"></i>
          <h3 style="margin-top:20px;font-weight:700;">Thank You! Your Order is in Review, update within 24 hours.</h3>
          <?php if(!empty($orderDetails)): ?>
          <p style="color:#666;">Order <strong>#<?php echo $orderDetails['id']; ?></strong> &mdash; Ref: <strong><?php echo $orderDetails['transaction_no']; ?></strong></p>
          <p style="font-size:20px;font-weight:700;color:#e44;">Total: <?php echo CURRENCY_SYMBOL; ?><?php echo number_format($orderDetails['total_amount'],2); ?></p>
          <?php endif; ?>
          <div style="background:#fff8f5;border:1px solid #ffe0cc;border-radius:8px;padding:16px;margin:20px 0;text-align:left;">
            <p style="margin:0 0 8px;font-weight:700;color:#ff6000;"><i class="fa fa-money"></i>&nbsp; Offline Payment Selected</p>
            <p style="margin:0;color:#555;font-size:14px;">Our team will contact you shortly with payment instructions. You can pay via bank transfer or arrange cash on delivery.</p>
          </div>
        </div>

        <?php if(!empty($orderItems)): ?>
        <h4 style="font-weight:700;margin:24px 0 12px;">Order Items</h4>
        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <thead>
            <tr style="background:#1a1a2e;color:#fff;">
              <th style="padding:10px;text-align:left;border:1px solid #ddd;">Product</th>
              <th style="padding:10px;text-align:center;border:1px solid #ddd;">Qty</th>
              <th style="padding:10px;text-align:right;border:1px solid #ddd;">Amount</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($orderItems as $item): ?>
            <tr>
              <td style="padding:10px;border:1px solid #ddd;"><?php echo htmlspecialchars($item['product_name']); ?></td>
              <td style="padding:10px;text-align:center;border:1px solid #ddd;"><?php echo $item['quantity']; ?></td>
              <td style="padding:10px;text-align:right;border:1px solid #ddd;"><?php echo CURRENCY_SYMBOL; ?><?php echo number_format($item['amount'],2); ?></td>
            </tr>
          <?php endforeach; ?>
            <tr style="background:#f9f9f9;">
              <td colspan="2" style="padding:10px;border:1px solid #ddd;">Subtotal (ex. VAT)</td>
              <td style="padding:10px;text-align:right;border:1px solid #ddd;"><?php echo CURRENCY_SYMBOL; ?><?php echo number_format($orderDetails['pay_amount'],2); ?></td>
            </tr>
            <tr style="background:#f9f9f9;">
              <td colspan="2" style="padding:10px;border:1px solid #ddd;">VAT (20%)</td>
              <td style="padding:10px;text-align:right;border:1px solid #ddd;"><?php echo CURRENCY_SYMBOL; ?><?php echo number_format($orderDetails['vat_amount'],2); ?></td>
            </tr>
            <tr>
              <td colspan="2" style="padding:10px;border:1px solid #ddd;font-weight:700;">Total (inc. VAT)</td>
              <td style="padding:10px;text-align:right;border:1px solid #ddd;font-weight:700;color:#c8a951;font-size:16px;"><?php echo CURRENCY_SYMBOL; ?><?php echo number_format($orderDetails['total_amount'],2); ?></td>
            </tr>
          </tbody>
        </table>
        <?php endif; ?>

        <div style="margin-top:25px;text-align:center;">
          <a href="<?php echo base_url('all-products'); ?>" class="btn btn-primary">Continue Shopping</a>
          <a href="<?php echo base_url('my-orders'); ?>" class="btn btn-default" style="margin-left:10px;">View My Orders</a>
        </div>
      </div>
    </div>
  </div>
</div>
