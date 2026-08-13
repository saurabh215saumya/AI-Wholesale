<div class="content-wrapper">
  <section class="content-header">
    <h1>User Details</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('appuser'); ?>">Users</a></li><li class="active">Details</li></ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border"><h3 class="box-title">User: <?php echo htmlspecialchars($details['first_name'].' '.$details['last_name']); ?></h3></div>
          <div class="box-body">
            <table class="table table-bordered">
              <tr><th style="width:35%">Name</th><td><?php echo htmlspecialchars($details['first_name'].' '.$details['last_name']); ?></td></tr>
              <tr><th>Email</th><td><?php echo htmlspecialchars($details['email']); ?></td></tr>
              <tr><th>Mobile</th><td><?php echo htmlspecialchars($details['mobile'] ?: '-'); ?></td></tr>
              <tr><th>Company</th><td><?php echo htmlspecialchars($details['company_name'] ?: '-'); ?></td></tr>
              <tr><th>Company Reg No.</th><td><?php echo htmlspecialchars($details['company_reg_number'] ?: '-'); ?></td></tr>
              <tr><th>Business Type</th><td><?php echo $details['business_type'] ? ucfirst(str_replace('_',' ',$details['business_type'])) : '-'; ?></td></tr>
              <tr><th>User Type</th><td><?php echo ucfirst($details['user_type']); ?></td></tr>
              <tr><th>Status</th><td><span class="label label-<?php echo $details['status'] ? 'success' : 'danger'; ?>"><?php echo $details['status'] ? 'Active' : 'Inactive'; ?></span></td></tr>
              <tr><th>Joined</th><td><?php echo $details['addedOn']; ?></td></tr>
            </table>
          </div>
          <div class="box-footer">
            <a href="<?php echo base_url('appuser/edit/'.$details['id']); ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
            <a href="<?php echo base_url('appuser'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="box box-info">
          <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-map-marker"></i> Business Address</h3></div>
          <div class="box-body">
            <?php
            $hasAddress = !empty($details['business_address']) || !empty($details['city']) || !empty($details['postal_code']) || !empty($details['country']);
            ?>
            <?php if($hasAddress): ?>
            <table class="table table-bordered">
              <?php if(!empty($details['business_address'])): ?>
              <tr><th style="width:35%">Address</th><td><?php echo htmlspecialchars($details['business_address']); ?></td></tr>
              <?php endif; ?>
              <?php if(!empty($details['city'])): ?>
              <tr><th>City</th><td><?php echo htmlspecialchars($details['city']); ?></td></tr>
              <?php endif; ?>
              <?php if(!empty($details['postal_code'])): ?>
              <tr><th>Postal Code</th><td><?php echo htmlspecialchars($details['postal_code']); ?></td></tr>
              <?php endif; ?>
              <?php if(!empty($details['country'])): ?>
              <tr><th>Country</th><td><?php echo htmlspecialchars($details['country']); ?></td></tr>
              <?php endif; ?>
              <?php if(!empty($details['vat_number'])): ?>
              <tr><th>VAT Number</th><td><?php echo htmlspecialchars($details['vat_number']); ?></td></tr>
              <?php endif; ?>
              <?php if(!empty($details['companies_house_number'])): ?>
              <tr><th>Companies House No.</th><td><?php echo htmlspecialchars($details['companies_house_number']); ?></td></tr>
              <?php endif; ?>
              <?php if(!empty($details['website'])): ?>
              <tr><th>Website</th><td><a href="<?php echo htmlspecialchars($details['website']); ?>" target="_blank"><?php echo htmlspecialchars($details['website']); ?></a></td></tr>
              <?php endif; ?>
              <?php if(!empty($details['estimated_volume'])): ?>
              <tr><th>Est. Volume</th><td><?php echo htmlspecialchars($details['estimated_volume']); ?></td></tr>
              <?php endif; ?>
              <?php if(!empty($details['monthly_order'])): ?>
              <tr><th>Monthly Order</th><td><?php echo htmlspecialchars($details['monthly_order']); ?></td></tr>
              <?php endif; ?>
            </table>
            <?php else: ?>
            <p class="text-muted" style="margin:0;"><i class="fa fa-info-circle"></i> No business address on record.</p>
            <?php endif; ?>
          </div>
        </div>

        <?php if(!empty($billingArr)): ?>
        <div class="box box-default">
          <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-home"></i> Saved Billing Addresses</h3></div>
          <div class="box-body">
            <?php foreach($billingArr as $i => $addr): ?>
            <div style="border:1px solid #d2d6de;border-radius:4px;padding:14px;<?php echo $i > 0 ? 'margin-top:12px;' : ''; ?>">
              <p style="margin:0 0 6px;font-weight:700;color:#555;">Address <?php echo $i+1; ?></p>
              <table class="table table-condensed" style="margin:0;">
                <tr><th style="width:40%;border-top:none;">Name</th><td style="border-top:none;"><?php echo htmlspecialchars($addr['first_name'].' '.$addr['last_name']); ?></td></tr>
                <?php if(!empty($addr['company_name'])): ?>
                <tr><th>Company</th><td><?php echo htmlspecialchars($addr['company_name']); ?></td></tr>
                <?php endif; ?>
                <tr><th>Address</th><td>
                  <?php echo htmlspecialchars($addr['address_1']); ?>
                  <?php if(!empty($addr['address_2'])): ?><br><?php echo htmlspecialchars($addr['address_2']); ?><?php endif; ?>
                </td></tr>
                <tr><th>City</th><td><?php echo htmlspecialchars($addr['city'] ?: '-'); ?></td></tr>
                <tr><th>Postal Code</th><td><?php echo htmlspecialchars($addr['postal_code'] ?: '-'); ?></td></tr>
                <tr><th>Country</th><td><?php echo htmlspecialchars($addr['country'] ?: '-'); ?></td></tr>
                <?php if(!empty($addr['contact'])): ?>
                <tr><th>Phone</th><td><?php echo htmlspecialchars($addr['contact']); ?></td></tr>
                <?php endif; ?>
                <?php if(!empty($addr['email'])): ?>
                <tr><th>Email</th><td><?php echo htmlspecialchars($addr['email']); ?></td></tr>
                <?php endif; ?>
              </table>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
</div>
