<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Testimonial</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('testimonial'); ?>">Testimonials</a></li><li class="active">Edit</li></ol>
  </section>
  <section class="content">
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Edit Testimonial</h3></div>
      <?php echo form_open_multipart('testimonial/update_testimonial'); ?>
      <input type="hidden" name="testimonial_id" value="<?php echo $details['id']; ?>">
      <input type="hidden" name="image_file_name" value="<?php echo $details['image']; ?>">
      <div class="box-body">
        <div class="form-group">
          <label>Name <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" value="<?php echo $details['name']; ?>">
          <?php echo form_error('name'); ?>
        </div>
        <div class="form-group">
          <label>Designation</label>
          <input type="text" name="designation" class="form-control" value="<?php echo $details['designation']; ?>">
        </div>
        <div class="form-group">
          <label>Review <span class="text-danger">*</span></label>
          <textarea name="description" class="form-control" rows="4"><?php echo $details['description']; ?></textarea>
          <?php echo form_error('description'); ?>
        </div>
        <div class="form-group">
          <label>Current Photo</label><br>
          <?php if($details['image']): ?>
          <img src="<?php echo SHOW_TESTIMONIAL_PATH.$details['image']; ?>" width="80" height="80" style="border-radius:50%;object-fit:cover;" class="img-thumbnail">
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>Change Photo <small class="text-muted">(auto resized 150x150)</small></label>
          <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control">
            <option value="1" <?php echo $details['status']=='1'?'selected':''; ?>>Active</option>
            <option value="0" <?php echo $details['status']=='0'?'selected':''; ?>>Inactive</option>
          </select>
          <?php echo form_error('status'); ?>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?php echo base_url('testimonial'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
