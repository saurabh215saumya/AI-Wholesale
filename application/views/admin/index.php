<div class="content-wrapper">
  <section class="content-header">
    <h1>Dashboard</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li class="active">Dashboard</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner"><h3><?php echo $counts['total_products']; ?></h3><p>Total Products</p></div>
          <div class="icon"><i class="fa fa-shopping-bag"></i></div>
          <a href="<?php echo base_url('product'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner"><h3><?php echo $counts['total_categories']; ?></h3><p>Total Categories</p></div>
          <div class="icon"><i class="fa fa-tags"></i></div>
          <a href="<?php echo base_url('category'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
          <div class="inner"><h3><?php echo $counts['total_users']; ?></h3><p>Total Users</p></div>
          <div class="icon"><i class="fa fa-users"></i></div>
          <a href="<?php echo base_url('appuser'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner"><h3><?php echo $counts['total_orders']; ?></h3><p>Total Orders</p></div>
          <div class="icon"><i class="fa fa-shopping-cart"></i></div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header"><h3 class="box-title">Recent Orders</h3></div>
          <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="example1">
              <thead><tr><th>#</th><th>Transaction No</th><th>Amount</th><th>Payment</th><th>Status</th><th>Date</th></tr></thead>
              <tbody>
              <?php if(!empty($recent_orders)): foreach($recent_orders as $o): ?>
              <tr>
                <td><?php echo $o['id']; ?></td>
                <td><?php echo $o['transaction_no']; ?></td>
                <td>£<?php echo number_format($o['total_amount'],2); ?></td>
                <td>
                  <?php if($o['payment_method'] === 'offline'): ?>
                  <span class="label label-warning">Offline</span>
                  <?php else: ?>
                  <span class="label label-success"><?php echo ucfirst($o['payment_method']); ?></span>
                  <?php endif; ?>
                </td>
                <td><?php $s=['Processing','Complete','Cancel']; echo $s[$o['status']]??''; ?></td>
                <td><?php echo $o['addedOn']; ?></td>
              </tr>
              <?php endforeach; endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
