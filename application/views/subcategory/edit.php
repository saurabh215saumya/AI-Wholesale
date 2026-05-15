<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Sub Category</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('subcategory'); ?>">Sub Categories</a></li><li class="active">Edit</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Edit Sub Category</h3></div>
      <?php echo form_open('subcategory/update_subcategory'); ?>
      <input type="hidden" name="sub_category_id" value="<?php echo $details['id']; ?>">
      <div class="box-body">
        <div class="form-group <?php echo form_error('category_id') ? 'has-error' : ''; ?>">
          <label>Category <span class="text-danger">*</span></label>
          <select name="category_id" class="form-control">
            <option value="">Select Category</option>
            <?php foreach($categoryDataArr as $c): ?>
            <option value="<?php echo $c->id; ?>" <?php echo set_select('category_id', $c->id, $details['category_id']==$c->id); ?>><?php echo $c->category_name; ?></option>
            <?php endforeach; ?>
          </select>
          <?php echo form_error('category_id'); ?>
        </div>
        <div class="form-group <?php echo form_error('sub_category_name') ? 'has-error' : ''; ?>">
          <label>Sub Category Name <span class="text-danger">*</span></label>
          <input type="text" name="sub_category_name" class="form-control" value="<?php echo set_value('sub_category_name', $details['sub_category_name']); ?>">
          <?php echo form_error('sub_category_name'); ?>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="3"><?php echo set_value('description', $details['description']); ?></textarea>
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
        <button type="submit" class="btn btn-primary">Update Sub Category</button>
        <a href="<?php echo base_url('subcategory'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
