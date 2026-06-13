<div class="content-wrapper">
  <section class="content-header">
    <h1>Add Product</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('product'); ?>">Products</a></li><li class="active">Add</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Add New Product</h3></div>
      <?php echo form_open_multipart('product/add_newproduct'); ?>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group <?php echo form_error('category_id') ? 'has-error' : ''; ?>">
              <label>Category <span class="text-danger">*</span></label>
              <select name="category_id" id="category_id" class="form-control" onchange="loadSubCategories(this.value)">
                <option value="">Select Category</option>
                <?php foreach($categoryDataArr as $c): ?>
                <option value="<?php echo $c->id; ?>" <?php echo set_select('category_id',$c->id); ?>><?php echo $c->category_name; ?></option>
                <?php endforeach; ?>
              </select>
              <?php echo form_error('category_id'); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group <?php echo form_error('sub_category_id') ? 'has-error' : ''; ?>">
              <label>Sub Category</label>
              <select name="sub_category_id" id="sub_category_id" class="form-control" onchange="loadGrandSubCategories(this.value)">
                <option value="">Select Sub Category</option>
                <?php foreach($subCategoryDataArr as $s): ?>
                <option value="<?php echo $s->id; ?>" <?php echo set_select('sub_category_id',$s->id); ?>><?php echo $s->category_name; ?></option>
                <?php endforeach; ?>
              </select>
              <?php echo form_error('sub_category_id'); ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group" <?php echo empty($grandSubCategoryDataArr) ? 'style="display:none;"' : ''; ?>>
              <label>Grand Sub Category <small class="text-muted">(3rd level, optional)</small></label>
              <select name="grand_sub_category_id" id="grand_sub_category_id" class="form-control">
                <option value="">Select Grand Sub Category</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group <?php echo form_error('product_name') ? 'has-error' : ''; ?>">
              <label>Product Name <span class="text-danger">*</span></label>
              <input type="text" name="product_name" class="form-control" value="<?php echo set_value('product_name'); ?>">
              <?php echo form_error('product_name'); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group <?php echo form_error('product_code') ? 'has-error' : ''; ?>">
              <label>Product Code <span class="text-danger">*</span></label>
              <input type="text" name="product_code" class="form-control" value="<?php echo set_value('product_code'); ?>">
              <?php echo form_error('product_code'); ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group <?php echo form_error('price') ? 'has-error' : ''; ?>">
              <label>RRP Price <span class="text-danger">*</span></label>
              <input type="number" step="0.01" min="0" name="price" class="form-control" value="<?php echo set_value('price'); ?>">
              <?php echo form_error('price'); ?>
            </div>
          </div>
          <!-- <div class="col-md-4">
            <div class="form-group <?php //echo form_error('wholesale_price') ? 'has-error' : ''; ?>">
              <label>Wholesale Price</label>
              <input type="number" step="0.01" min="0" name="wholesale_price" class="form-control" value="<?php //echo set_value('wholesale_price'); ?>">
              <?php //echo form_error('wholesale_price'); ?>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group <?php //echo form_error('retailer_price') ? 'has-error' : ''; ?>">
              <label>Retailer Price</label>
              <input type="number" step="0.01" min="0" name="retailer_price" class="form-control" value="<?php //echo set_value('retailer_price'); ?>">
              <?php //echo form_error('retailer_price'); ?>
            </div>
          </div> -->
        </div>
        <div class="form-group <?php echo form_error('quantity') ? 'has-error' : ''; ?>">
          <label>Quantity</label>
          <input type="number" min="0" name="quantity" class="form-control" value="<?php echo set_value('quantity',0); ?>">
          <?php echo form_error('quantity'); ?>
        </div>

        <!-- Price Variants / Quick Add Tiers -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-tags"></i> Price Variants (Quick Add Tiers) <small class="text-muted">- Optional. e.g. "10 pieces" = £6.99</small></h3>
          </div>
          <div class="box-body">
            <div id="variants-container">
              <div class="variant-row row" style="margin-bottom:8px;">
                <div class="col-md-5"><input type="text" name="variant_label[]" class="form-control" placeholder="Label e.g. 10 pieces"></div>
                <div class="col-md-4"><input type="number" step="0.01" name="variant_price[]" class="form-control" placeholder="Price e.g. 6.99"></div>
                <div class="col-md-3"><button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fa fa-trash"></i> Remove</button></div>
              </div>
            </div>
            <button type="button" class="btn btn-success btn-sm" id="add-variant-btn"><i class="fa fa-plus"></i> Add Tier</button>
          </div>
        </div>

        <div class="form-group">
          <label>Short Description</label>
          <textarea name="description" class="form-control" rows="3"><?php echo set_value('description'); ?></textarea>
        </div>
        <div class="form-group">
          <label>Long Description</label>
          <textarea name="long_description" id="editor" class="form-control" rows="5"><?php echo set_value('long_description'); ?></textarea>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Main Image <small class="text-muted">(auto resized 800x800)</small></label>
              <input type="file" name="image_file" class="form-control" accept="image/*">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Sub Image 1</label>
              <input type="file" name="image_file_1" class="form-control" accept="image/*">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Sub Image 2</label>
              <input type="file" name="image_file_2" class="form-control" accept="image/*">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Sub Image 3</label>
              <input type="file" name="image_file_3" class="form-control" accept="image/*">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Sub Image 4</label>
              <input type="file" name="image_file_4" class="form-control" accept="image/*">
            </div>
          </div>
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
        <button type="submit" class="btn btn-primary">Save Product</button>
        <a href="<?php echo base_url('product'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
<script>
function loadSubCategories(catId) {
  if (!catId) { $('#sub_category_id').html('<option value="">Select Sub Category</option>'); $('#grand_sub_category_id').html('<option value="">Select Grand Sub Category</option>').closest('.form-group').hide(); return; }
  $.post('<?php echo base_url('category/getChildCategories'); ?>', {parent_id: catId}, function(res) {
    $('#sub_category_id').html(res);
    $('#grand_sub_category_id').html('<option value="">Select Grand Sub Category</option>').closest('.form-group').hide();
  });
}
function loadGrandSubCategories(subCatId) {
  if (!subCatId) { $('#grand_sub_category_id').html('<option value="">Select Grand Sub Category</option>').closest('.form-group').hide(); return; }
  $.post('<?php echo base_url('category/getChildCategories'); ?>', {parent_id: subCatId}, function(res) {
    var $tmp = $('<select>').html(res);
    if ($tmp.find('option[value!=""]').length > 0) {
      $('#grand_sub_category_id').html(res).closest('.form-group').show();
    } else {
      $('#grand_sub_category_id').html('<option value="">Select Grand Sub Category</option>').closest('.form-group').hide();
    }
  });
}
$(document).ready(function(){ $('#grand_sub_category_id').closest('.form-group').hide(); });
$(document).on('click','#add-variant-btn',function(){
  var row = '<div class="variant-row row" style="margin-bottom:8px;"><div class="col-md-5"><input type="text" name="variant_label[]" class="form-control" placeholder="Label e.g. 25 pieces"></div><div class="col-md-4"><input type="number" step="0.01" name="variant_price[]" class="form-control" placeholder="Price"></div><div class="col-md-3"><button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fa fa-trash"></i> Remove</button></div></div>';
  $('#variants-container').append(row);
});
$(document).on('click','.remove-variant',function(){ $(this).closest('.variant-row').remove(); });
</script>
