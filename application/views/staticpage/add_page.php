<div class="content-wrapper">
  <section class="content-header">
    <h1>Add Page</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('staticpage'); ?>">Pages</a></li><li class="active">Add</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Add New Page</h3></div>
      <?php echo form_open('staticpage/add_newpage'); ?>
      <div class="box-body">
        <div class="form-group <?php echo form_error('page_name') ? 'has-error' : ''; ?>">
          <label>Page Name <span class="text-danger">*</span></label>
          <input type="text" name="page_name" class="form-control" value="<?php echo set_value('page_name'); ?>">
          <?php echo form_error('page_name'); ?>
        </div>
        <div class="form-group <?php echo form_error('identifire') ? 'has-error' : ''; ?>">
          <label>Identifier <span class="text-danger">*</span> <small class="text-muted">(unique key, e.g. about_us)</small></label>
          <input type="text" name="identifire" class="form-control" value="<?php echo set_value('identifire'); ?>">
          <?php echo form_error('identifire'); ?>
        </div>
        <div class="form-group">
          <label>Content</label>
          <textarea name="content" id="editor" class="form-control" rows="10"><?php echo set_value('content'); ?></textarea>
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
      <?php $this->load->view('template/seo_fields'); ?>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save Page</button>
        <a href="<?php echo base_url('staticpage'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
