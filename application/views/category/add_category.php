<div class="content-wrapper">
  <section class="content-header">
    <h1>Add Category</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('category'); ?>">Categories</a></li><li class="active">Add</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Add New Category</h3></div>
      <?php echo form_open_multipart('category/add_newcategory'); ?>
      <div class="box-body">
        <div class="form-group <?php echo form_error('category_name') ? 'has-error' : ''; ?>">
          <label>Category Name <span class="text-danger">*</span></label>
          <input type="text" name="category_name" class="form-control" value="<?php echo set_value('category_name'); ?>">
          <?php echo form_error('category_name'); ?>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="3"><?php echo set_value('description'); ?></textarea>
        </div>
        <div class="form-group">
          <label>Category Icon/Image</label>
          <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>
        <div class="form-group">
          <label>Banner Image <small class="text-muted">(Optional - Recommended: 1350x530px - auto resized)</small></label>
          <input type="file" name="banner_image_file" class="form-control" accept="image/*">
        </div>
        <div class="form-group <?php echo form_error('status') ? 'has-error' : ''; ?>">
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
        <button type="submit" class="btn btn-primary">Save Category</button>
        <a href="<?php echo base_url('category'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
