<div class="content-wrapper">
  <section class="content-header">
    <h1>User Details</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('appuser'); ?>">Users</a></li><li class="active">Details</li></ol>
  </section>
  <section class="content">
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">User: <?php echo $details['first_name'].' '.$details['last_name']; ?></h3></div>
      <div class="box-body">
        <table class="table table-bordered">
          <tr><th>Name</th><td><?php echo $details['first_name'].' '.$details['last_name']; ?></td></tr>
          <tr><th>Email</th><td><?php echo $details['email']; ?></td></tr>
          <tr><th>Mobile</th><td><?php echo $details['mobile']; ?></td></tr>
          <tr><th>Company</th><td><?php echo $details['company_name']; ?></td></tr>
          <tr><th>User Type</th><td><?php echo ucfirst($details['user_type']); ?></td></tr>
          <tr><th>Status</th><td><?php echo $details['status']?'Active':'Inactive'; ?></td></tr>
          <tr><th>Joined</th><td><?php echo $details['addedOn']; ?></td></tr>
        </table>
      </div>
      <div class="box-footer">
        <a href="<?php echo base_url('appuser/edit/'.$details['id']); ?>" class="btn btn-warning">Edit</a>
        <a href="<?php echo base_url('appuser'); ?>" class="btn btn-default">Back</a>
      </div>
    </div>
  </section>
</div>
