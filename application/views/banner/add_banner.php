<div class="content-wrapper">
  <section class="content-header">
    <h1>Add Banner</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('banner'); ?>">Banners</a></li><li class="active">Add</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Add New Banner</h3></div>
      <?php echo form_open_multipart('banner/add_newbanner'); ?>
      <div class="box-body">
        <div class="form-group <?php echo form_error('title') ? 'has-error' : ''; ?>">
          <label>Title <span class="text-danger">*</span></label>
          <input type="text" name="title" class="form-control" value="<?php echo set_value('title'); ?>">
          <?php echo form_error('title'); ?>
        </div>
        <div class="form-group <?php echo form_error('image_file') ? 'has-error' : ''; ?>">
          <label>Banner Image <span class="text-danger">*</span> <small class="text-muted">(Recommended: 1920x750px - auto resized)</small></label>
          <input type="file" name="image_file" class="form-control" accept="image/*">
          <?php echo form_error('image_file'); ?>
        </div>
        <div class="form-group <?php echo form_error('status') ? 'has-error' : ''; ?>">
          <label>Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="">Select Status</option>
            <option value="1" <?php echo set_select('status','1'); ?>>Active</option>
            <option value="0" <?php echo set_select('status','0'); ?>>Inactive</option>
          </select>
          <?php echo form_error('status'); ?>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save Banner</button>
        <a href="<?php echo base_url('banner'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
