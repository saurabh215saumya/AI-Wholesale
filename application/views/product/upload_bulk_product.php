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
          Optional columns: <code>Category, Price, WholesalePrice, RetailerPrice, Barcode, Quantity, Description</code><br>
          <strong>Note:</strong> The <code>Category</code> column should contain the <strong>Sub Category name</strong>. If it matches an existing sub-category, the parent category will be auto-assigned.<br>
          If a product with the same name already exists it will be <strong>updated</strong>, otherwise a new product is <strong>inserted</strong>.
        </div>
        <?php echo form_open_multipart('product/import_csv'); ?>
        <div class="form-group">
          <label>Select CSV File</label>
          <input type="file" name="csv_file" class="form-control" accept=".csv">
        </div>
        <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Import CSV</button>
        <a href="<?php echo base_url('product'); ?>" class="btn btn-default">Cancel</a>
        <?php echo form_close(); ?>
      </div>
    </div>
    <div class="box">
      <div class="box-header"><h3 class="box-title">Sample CSV Template</h3></div>
      <div class="box-body">
        <pre>Product,Category,Price,WholesalePrice,RetailerPrice,Barcode,Quantity,Description
Arome-01-Baggy,Clear Zipper,1.40,1.00,1.20,AR001,60,Product description here
Simple Product,,,,,,, </pre>
        <a href="<?php echo base_url('assets/sample_products.csv'); ?>" class="btn btn-default btn-sm"><i class="fa fa-download"></i> Download Sample CSV</a>
      </div>
    </div>
  </section>
</div>
