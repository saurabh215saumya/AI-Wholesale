<section class="page-header mb-lg">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url('my-account'); ?>">My Account</a></li>
            <li class="active">My Orders</li>
        </ul>
    </div>
</section>
<div class="container mb-xlg">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading"><h4 class="panel-title">My Account</h4></div>
                <div class="list-group">
                    <a href="<?php echo base_url('my-account'); ?>" class="list-group-item">Account Details</a>
                    <a href="<?php echo base_url('my-orders'); ?>" class="list-group-item active">My Orders</a>
                    <a href="<?php echo base_url('billing-address'); ?>" class="list-group-item">Addresses</a>
                    <a href="<?php echo base_url('wish-list'); ?>" class="list-group-item">Wishlist</a>
                    <a href="<?php echo base_url('sign-out'); ?>" class="list-group-item text-danger">Logout</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h4 class="heading-primary text-uppercase mb-lg">My Orders</h4>
            <?php if(!empty($orders)): ?>
            <table class="table table-bordered table-striped">
                <thead><tr><th>Order #</th><th>Transaction No</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                <?php $statuses = array('Processing','Complete','Cancelled'); $cls = array('warning','success','danger');
                foreach($orders as $o): ?>
                <tr>
                    <td><?php echo $o['id']; ?></td>
                    <td><?php echo $o['transaction_no']; ?></td>
                    <td><?php echo '£ '.number_format($o['total_amount'],2); ?></td>
                    <td><span class="label label-<?php echo $cls[$o['status']]??'default'; ?>"><?php echo $statuses[$o['status']]??'Unknown'; ?></span></td>
                    <td><?php echo date('d M Y', strtotime($o['addedOn'])); ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="alert alert-info">No orders yet. <a href="<?php echo base_url('all-products'); ?>">Start shopping</a></div>
            <?php endif; ?>
        </div>
    </div>
</div>
