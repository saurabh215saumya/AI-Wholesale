<section class="page-header mb-lg">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="active">My Account</li>
        </ul>
    </div>
</section>
<div class="container mb-xlg">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading"><h4 class="panel-title">My Account</h4></div>
                <div class="list-group">
                    <a href="<?php echo base_url('my-account'); ?>" class="list-group-item active">Account Details</a>
                    <a href="<?php echo base_url('my-orders'); ?>" class="list-group-item">My Orders</a>
                    <a href="<?php echo base_url('billing-address'); ?>" class="list-group-item">Addresses</a>
                    <a href="<?php echo base_url('wish-list'); ?>" class="list-group-item">Wishlist</a>
                    <a href="<?php echo base_url('sign-out'); ?>" class="list-group-item text-danger">Logout</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="featured-box featured-box-primary featured-box-flat featured-box-text-left">
                <div class="box-content">
                    <h4 class="heading-primary text-uppercase mb-lg">Account Details</h4>
                    <table class="table table-bordered">
                        <tr><th width="30%">Name</th><td><?php echo $details['first_name'].' '.$details['last_name']; ?></td></tr>
                        <tr><th>Email</th><td><?php echo $details['email']; ?></td></tr>
                        <tr><th>Mobile</th><td><?php echo $details['mobile'] ?: '-'; ?></td></tr>
                        <tr><th>Company</th><td><?php echo $details['company_name'] ?: '-'; ?></td></tr>
                        <tr><th>Account Type</th><td><?php echo ucfirst($details['user_type']); ?></td></tr>
                        <tr><th>Member Since</th><td><?php echo date('d M Y', strtotime($details['addedOn'])); ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
