<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Page</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('staticpage'); ?>">Pages</a></li><li class="active">Edit</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Edit Page</h3></div>
      <?php echo form_open('staticpage/update_page'); ?>
      <input type="hidden" name="page_id" value="<?php echo $details['id']; ?>">
      <div class="box-body">
        <div class="form-group <?php echo form_error('page_name') ? 'has-error' : ''; ?>">
          <label>Page Name <span class="text-danger">*</span></label>
          <input type="text" name="page_name" class="form-control" value="<?php echo set_value('page_name', $details['page_name']); ?>">
          <?php echo form_error('page_name'); ?>
        </div>
        <div class="form-group">
          <label>Identifier <small class="text-muted">(read-only)</small></label>
          <input type="text" class="form-control" value="<?php echo $details['identifire']; ?>" readonly>
        </div>
        <div class="form-group">
          <label>Content</label>
          <textarea name="content" id="editor" class="form-control" rows="10"><?php echo set_value('content', $details['content']); ?></textarea>
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
        <button type="submit" class="btn btn-primary">Update Page</button>
        <a href="<?php echo base_url('staticpage'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
