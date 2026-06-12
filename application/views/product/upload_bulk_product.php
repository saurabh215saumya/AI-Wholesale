<div class="content-wrapper">
  <section class="content-header">
    <h1>Bulk Upload Products</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('product'); ?>">Products</a></li><li class="active">Bulk Upload</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Upload Products via CSV</h3></div>
      <div class="box-body">
        <div class="alert alert-info">
          <strong>CSV Format:</strong> Only <code>Product</code> (product name) column is required.<br>
          <strong>Product columns (optional):</strong> <code>Category</code>, <code>Price</code>, <code>Barcode</code>, <code>Quantity</code>, <code>Description</code><br>
          <strong>SEO columns (all optional):</strong> <code>MetaTitle</code>, <code>MetaDescription</code>, <code>MetaKeywords</code>, <code>H1Tag</code>, <code>H2Tag</code>, <code>H3Tag</code>, <code>Robots</code>, <code>Canonical</code>, <code>OgTitle</code>, <code>OgDescription</code>, <code>OgImage</code>, <code>OgUrl</code>, <code>OgSiteName</code>, <code>OgLocale</code>, <code>OgType</code>, <code>OgTag</code>, <code>Author</code>, <code>TwitterSite</code>, <code>TwitterDescription</code>, <code>Facebook</code>, <code>Instagram</code>, <code>Youtube</code><br>
          <strong>Note:</strong> The <code>Category</code> column should contain the <strong>Sub Category name</strong>. If a product with the same name already exists it will be <strong>updated</strong>, otherwise a new product is <strong>inserted</strong>.
        </div>
        <?php echo form_open_multipart('product/import_csv'); ?>
        <div class="form-group">
          <label>Select CSV File <span class="text-danger">*</span></label>
          <input type="file" name="csv_file" class="form-control" accept=".csv">
        </div>
        <a href="<?php echo base_url('product/sample_csv'); ?>" class="btn btn-default btn-sm"><i class="fa fa-download"></i> Download Sample CSV</a>
        &nbsp;
        <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Import CSV</button>
        <a href="<?php echo base_url('product'); ?>" class="btn btn-default">Cancel</a>
        <?php echo form_close(); ?>
      </div>
    </div>
  </section>
</div>
