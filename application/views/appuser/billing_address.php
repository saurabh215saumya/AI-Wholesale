<div style="background:#f8f9fa;padding:30px 0;border-bottom:1px solid #eee;">
  <div class="container">
    <h2>Billing Address</h2>
    <ol class="breadcrumb" style="background:none;padding:0;margin:0;">
      <li><a href="<?php echo base_url(); ?>">Home</a></li>
      <li><a href="<?php echo base_url('my-account'); ?>">My Account</a></li>
      <li class="active">Billing Address</li>
    </ol>
  </div>
</div>
<div class="container" style="padding:40px 15px;">
  <?php echo $this->session->flashdata('success') ? '<div class="alert alert-success">'.$this->session->flashdata('success').'</div>' : ''; ?>
  <div class="row">
    <?php if(!empty($billingArr)): ?>
    <div class="col-md-6">
      <h5 style="font-weight:700;margin-bottom:15px;">Saved Addresses</h5>
      <?php foreach($billingArr as $b): ?>
      <div style="border:1px solid #ddd;border-radius:6px;padding:15px;margin-bottom:15px;">
        <strong><?php echo $b['first_name'].' '.$b['last_name']; ?></strong>
        <?php if($b['company_name']): ?><br><span style="color:#666;"><?php echo $b['company_name']; ?></span><?php endif; ?>
        <br><?php echo $b['address_1']; ?>
        <?php if($b['address_2']): ?>, <?php echo $b['address_2']; ?><?php endif; ?>
        <br><?php echo $b['city'].', '.$b['postal_code']; ?>
        <br><?php echo $b['country']; ?>
        <br><i class="fa fa-phone" style="color:#667eea;"></i> <?php echo $b['contact']; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="col-md-6">
      <h5 style="font-weight:700;margin-bottom:15px;">Add New Address</h5>
      <?php echo form_open('billing-address'); ?>
      <div class="row">
        <div class="col-sm-6"><div class="form-group"><label>First Name *</label><input type="text" name="first_name" class="form-control" required></div></div>
        <div class="col-sm-6"><div class="form-group"><label>Last Name</label><input type="text" name="last_name" class="form-control"></div></div>
      </div>
      <div class="form-group"><label>Company Name</label><input type="text" name="company_name" class="form-control"></div>
      <div class="form-group"><label>Address Line 1 *</label><input type="text" name="address_1" class="form-control" required></div>
      <div class="form-group"><label>Address Line 2</label><input type="text" name="address_2" class="form-control"></div>
      <div class="row">
        <div class="col-sm-6"><div class="form-group"><label>City *</label><input type="text" name="city" class="form-control" required></div></div>
        <div class="col-sm-6"><div class="form-group"><label>Postal Code *</label><input type="text" name="postal_code" class="form-control" required></div></div>
      </div>
      <div class="form-group"><label>Country *</label><input type="text" name="country" class="form-control" value="United Kingdom" required></div>
      <div class="form-group"><label>Email *</label><input type="email" name="email" class="form-control" required></div>
      <div class="form-group"><label>Contact Number</label><input type="text" name="contact" class="form-control"></div>
      <button type="submit" class="btn btn-primary">Save Address</button>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
