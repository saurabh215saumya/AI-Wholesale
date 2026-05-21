<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Category</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('category'); ?>">Categories</a></li><li class="active">Edit</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Edit Category</h3></div>
      <?php echo form_open_multipart('category/update_category'); ?>
      <input type="hidden" name="category_id" value="<?php echo $details['id']; ?>">
      <input type="hidden" name="image_file_name" value="<?php echo $details['image']; ?>">
      <input type="hidden" name="banner_image_file_name" value="<?php echo $details['banner_image']; ?>">
      <div class="box-body">
        <div class="form-group">
          <label>Parent Category <small class="text-muted">(Set to "None" for Root/Top-level category)</small></label>
          <select name="parent_id" class="form-control">
            <option value="0">-- None (Root Category) --</option>
            <?php
            $catMap = array();
            foreach($allcategories as $c) $catMap[$c['id']] = $c;
            foreach($allcategories as $c):
                if($c['id'] == $details['id']) continue;
                $parentLabel = $c['parent_id'] > 0 ? ' [under: '.($catMap[$c['parent_id']]['category_name'] ?? '').' ]' : '';
                $sel = ($details['parent_id'] == $c['id']) ? 'selected' : '';
            ?>
            <option value="<?php echo $c['id']; ?>" <?php echo $sel; ?>><?php echo $c['category_name'].$parentLabel; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group <?php echo form_error('category_name') ? 'has-error' : ''; ?>">
          <label>Category Name <span class="text-danger">*</span></label>
          <input type="text" name="category_name" class="form-control" value="<?php echo set_value('category_name', $details['category_name']); ?>">
          <?php echo form_error('category_name'); ?>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="3"><?php echo set_value('description', $details['description']); ?></textarea>
        </div>
        <div class="form-group">
          <label>Current Icon/Image</label><br>
          <?php if($details['image']): ?><img src="<?php echo SHOW_CATEGORY_PATH.$details['image']; ?>" width="80" height="80" style="object-fit:cover;" class="img-thumbnail"><?php endif; ?>
        </div>
        <div class="form-group">
          <label>Change Icon/Image</label>
          <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>
        <div class="form-group">
          <label>Current Banner Image</label><br>
          <?php if($details['banner_image']): ?><img src="<?php echo SHOW_CATEGORY_PATH.$details['banner_image']; ?>" style="max-width:300px;max-height:80px;object-fit:cover;" class="img-thumbnail"><?php endif; ?>
        </div>
        <div class="form-group">
          <label>Change Banner Image <small class="text-muted">(Optional - auto resized to 1350x530)</small></label>
          <input type="file" name="banner_image_file" class="form-control" accept="image/*">
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
        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="<?php echo base_url('category'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
