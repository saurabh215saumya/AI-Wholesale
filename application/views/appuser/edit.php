<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit User</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('appuser'); ?>">Users</a></li><li class="active">Edit</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Edit User</h3></div>
      <?php echo form_open('appuser/update_user'); ?>
      <input type="hidden" name="user_id" value="<?php echo $details['id']; ?>">
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>First Name</label>
              <input type="text" name="first_name" class="form-control" value="<?php echo $details['first_name']; ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" name="last_name" class="form-control" value="<?php echo $details['last_name']; ?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" value="<?php echo $details['email']; ?>">
        </div>
        <div class="form-group">
          <label>Mobile</label>
          <input type="text" name="mobile" class="form-control" value="<?php echo $details['mobile']; ?>">
        </div>
        <div class="form-group">
          <label>Company Name</label>
          <input type="text" name="company_name" class="form-control" value="<?php echo $details['company_name']; ?>">
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control">
            <option value="1" <?php echo $details['status']=='1'?'selected':''; ?>>Active</option>
            <option value="0" <?php echo $details['status']=='0'?'selected':''; ?>>Inactive</option>
          </select>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="<?php echo base_url('appuser'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
