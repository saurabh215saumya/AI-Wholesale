<div class="content-wrapper">
  <section class="content-header">
    <h1>My Profile</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li class="active">Profile</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Update Profile</h3></div>
      <?php echo form_open('user/update_profile'); ?>
      <div class="box-body">
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="full_name" class="form-control" value="<?php echo $details['full_name']; ?>">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" value="<?php echo $details['email']; ?>">
        </div>
        <div class="form-group">
          <label>New Password <small class="text-muted">(leave blank to keep current)</small></label>
          <input type="password" name="new_password" class="form-control">
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Update Profile</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
