<div class="content-wrapper">
  <section class="content-header">
    <h1>Upload Keywords CSV</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('keyword'); ?>">Keywords</a></li><li class="active">Upload CSV</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Upload Keywords via CSV</h3></div>
      <?php echo form_open_multipart('keyword/import_csv'); ?>
      <div class="box-body">
        <div class="alert alert-info">
          <strong>CSV Format:</strong> Required column: <code>Keyword</code>.<br>
          SEO columns (all optional): <code>MetaTitle</code>, <code>MetaDescription</code>, <code>MetaKeywords</code>, <code>H1Tag</code>, <code>H2Tag</code>, <code>H3Tag</code>, <code>Robots</code>, <code>Canonical</code>, <code>OgTitle</code>, <code>OgDescription</code>, <code>OgImage</code>, <code>OgUrl</code>, <code>OgSiteName</code>, <code>OgLocale</code>, <code>OgType</code>, <code>OgTag</code>, <code>Author</code>, <code>Twitter Site</code>, <code>TwitterDescription</code>, <code>Facebook</code>, <code>Instagram</code>, <code>Youtube</code>.<br>
          Existing keywords (matched by name) will be updated. New ones will be inserted.
        </div>
        <div class="form-group">
          <label>Select CSV File <span class="text-danger">*</span></label>
          <input type="file" name="csv_file" class="form-control" accept=".csv">
        </div>
        <a href="<?php echo base_url('keyword/sample_csv'); ?>" class="btn btn-default btn-sm"><i class="fa fa-download"></i> Download Sample CSV</a>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Import CSV</button>
        <a href="<?php echo base_url('keyword'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
