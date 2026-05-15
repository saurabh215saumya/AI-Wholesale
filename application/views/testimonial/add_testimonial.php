<div class="content-wrapper">
  <section class="content-header">
    <h1>Add Testimonial</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('testimonial'); ?>">Testimonials</a></li><li class="active">Add</li></ol>
  </section>
  <section class="content">
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Add Testimonial</h3></div>
      <?php echo form_open_multipart('testimonial/add_newtestimonial'); ?>
      <div class="box-body">
        <div class="form-group">
          <label>Name <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" value="<?php echo set_value('name'); ?>">
          <?php echo form_error('name'); ?>
        </div>
        <div class="form-group">
          <label>Designation</label>
          <input type="text" name="designation" class="form-control" value="<?php echo set_value('designation'); ?>">
        </div>
        <div class="form-group">
          <label>Review <span class="text-danger">*</span></label>
          <textarea name="description" class="form-control" rows="4"><?php echo set_value('description'); ?></textarea>
          <?php echo form_error('description'); ?>
        </div>
        <div class="form-group">
          <label>Photo <small class="text-muted">(auto resized 150x150)</small></label>
          <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>
        <div class="form-group">
          <label>Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="">Select</option>
            <option value="1" <?php echo set_select('status','1'); ?>>Active</option>
            <option value="0" <?php echo set_select('status','0'); ?>>Inactive</option>
          </select>
          <?php echo form_error('status'); ?>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?php echo base_url('testimonial'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
