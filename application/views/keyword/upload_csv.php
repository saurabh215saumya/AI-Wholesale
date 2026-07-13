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
          <strong>CSV Format:</strong> Required column: <code>Keyword_name</code>. Optional: <code>Location</code>, <code>page_slug</code>, <code>page_title</code>, <code>page_url</code>, <code>meta_title</code>, <code>meta_description</code>, <code>meta_keywords</code>, <code>meta_heading</code>, <code>h1_tag</code>, <code>h2_tag</code>, <code>h3_tag</code>, <code>image_alt_1</code>, <code>image_alt_2</code>, <code>image_alt_3</code>, <code>og_title</code>, <code>og_url</code>, <code>og_tag</code>, <code>og_type</code>, <code>og_local</code>, <code>og_image</code>, <code>og_site_name</code>, <code>og_description</code>, <code>robots</code>, <code>revisit after </code>, <code>author</code>, <code>canonical</code>, <code>geo_region</code>, <code>geo_place_name</code>, <code>geo_position</code>, <code>icbm </code>, <code>subject</code>, <code>owner</code>, <code>coverage</code>, <code>language</code>, <code>distribution</code>, <code>country</code>, <code>geography</code>, <code>cache-control</code>, <code>instagram</code>, <code>facebook </code>, <code>tik-tok</code>, <code>youtube </code>.<br>
          Existing keywords (matched by name + location) will be updated. New ones will be inserted.
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
