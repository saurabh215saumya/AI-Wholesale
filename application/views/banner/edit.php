<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Banner</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('banner'); ?>">Banners</a></li><li class="active">Edit</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Edit Banner</h3></div>
      <?php echo form_open_multipart('banner/update_banner'); ?>
      <input type="hidden" name="banner_id" value="<?php echo $details['id']; ?>">
      <input type="hidden" name="image_file_name" value="<?php echo $details['image']; ?>">
      <div class="box-body">
        <div class="form-group <?php echo form_error('title') ? 'has-error' : ''; ?>">
          <label>Title <span class="text-danger">*</span></label>
          <input type="text" name="title" class="form-control" value="<?php echo set_value('title', $details['title']); ?>">
          <?php echo form_error('title'); ?>
        </div>
        <div class="form-group">
          <label>Current Image</label><br>
          <?php if($details['image']): ?>
          <img src="<?php echo SHOW_BANNER_PATH.$details['image']; ?>" style="max-width:300px;max-height:120px;object-fit:cover;" class="img-thumbnail">
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>Change Image <small class="text-muted">(Recommended: 1920x750px - auto resized)</small></label>
          <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>
        <div class="form-group <?php echo form_error('status') ? 'has-error' : ''; ?>">
          <label>Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="1" <?php echo set_select('status','1',$details['status']=='1'); ?>>Active</option>
            <option value="0" <?php echo set_select('status','0',$details['status']=='0'); ?>>Inactive</option>
          </select>
          <?php echo form_error('status'); ?>
        </div>
      </div>
      <?php $this->load->view('template/seo_fields'); ?>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Update Banner</button>
        <a href="<?php echo base_url('banner'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
