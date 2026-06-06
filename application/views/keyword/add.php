<div class="content-wrapper">
  <section class="content-header">
    <h1>Add Keyword</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('keyword'); ?>">Keywords</a></li><li class="active">Add</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Add Keyword</h3></div>
      <?php echo form_open('keyword/save'); ?>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group <?php echo form_error('keyword') ? 'has-error' : ''; ?>">
              <label>Keyword <span class="text-danger">*</span></label>
              <input type="text" name="keyword" class="form-control" value="<?php echo set_value('keyword'); ?>" placeholder="e.g. buy wholesale products">
              <?php echo form_error('keyword'); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group <?php echo form_error('status') ? 'has-error' : ''; ?>">
              <label>Status <span class="text-danger">*</span></label>
              <select name="status" class="form-control">
                <option value="1" <?php echo set_select('status','1',TRUE); ?>>Active</option>
                <option value="0" <?php echo set_select('status','0'); ?>>Inactive</option>
              </select>
              <?php echo form_error('status'); ?>
            </div>
          </div>
        </div>

        <?php $this->load->view('template/seo_fields'); ?>

      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save Keyword</button>
        <a href="<?php echo base_url('keyword'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
