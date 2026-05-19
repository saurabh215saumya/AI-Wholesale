<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Product</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li><a href="<?php echo base_url('product'); ?>">Products</a></li><li class="active">Edit</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header"><h3 class="box-title">Edit Product</h3></div>
      <?php echo form_open_multipart('product/update_product'); ?>
      <input type="hidden" name="product_id" value="<?php echo $details['id']; ?>">
      <input type="hidden" name="image_file_name" value="<?php echo $details['image']; ?>">
      <input type="hidden" name="image_file_name_1" value="<?php echo $details['image_1']; ?>">
      <input type="hidden" name="image_file_name_2" value="<?php echo $details['image_2']; ?>">
      <input type="hidden" name="image_file_name_3" value="<?php echo $details['image_3']; ?>">
      <input type="hidden" name="image_file_name_4" value="<?php echo $details['image_4']; ?>">
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group <?php echo form_error('category_id') ? 'has-error' : ''; ?>">
              <label>Category <span class="text-danger">*</span></label>
              <select name="category_id" id="category_id" class="form-control" onchange="loadSubCategories(this.value)">
                <option value="">Select Category</option>
                <?php foreach($categoryDataArr as $c): ?>
                <option value="<?php echo $c->id; ?>" <?php echo set_select('category_id',$c->id,$details['category_id']==$c->id); ?>><?php echo $c->category_name; ?></option>
                <?php endforeach; ?>
              </select>
              <?php echo form_error('category_id'); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group <?php echo form_error('sub_category_id') ? 'has-error' : ''; ?>">
              <label>Sub Category <span class="text-danger">*</span></label>
              <select name="sub_category_id" id="sub_category_id" class="form-control">
                <option value="">Select Sub Category</option>
                <?php foreach($subCategoryDataArr as $s): ?>
                <option value="<?php echo $s->id; ?>" <?php echo set_select('sub_category_id',$s->id,$details['sub_cat_id']==$s->id); ?>><?php echo $s->sub_category_name; ?></option>
                <?php endforeach; ?>
              </select>
              <?php echo form_error('sub_category_id'); ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group <?php echo form_error('product_name') ? 'has-error' : ''; ?>">
              <label>Product Name <span class="text-danger">*</span></label>
              <input type="text" name="product_name" class="form-control" value="<?php echo set_value('product_name', $details['product_name']); ?>">
              <?php echo form_error('product_name'); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group <?php echo form_error('product_code') ? 'has-error' : ''; ?>">
              <label>Product Code <span class="text-danger">*</span></label>
              <input type="text" name="product_code" class="form-control" value="<?php echo set_value('product_code', $details['product_code']); ?>">
              <?php echo form_error('product_code'); ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group <?php echo form_error('price') ? 'has-error' : ''; ?>">
              <label>RRP Price <span class="text-danger">*</span></label>
              <input type="number" step="0.01" min="0" name="price" class="form-control" value="<?php echo set_value('price', $details['price']); ?>">
              <?php echo form_error('price'); ?>
            </div>
          </div>
          <!-- <div class="col-md-4">
            <div class="form-group <?php //echo form_error('wholesale_price') ? 'has-error' : ''; ?>">
              <label>Wholesale Price</label>
              <input type="number" step="0.01" min="0" name="wholesale_price" class="form-control" value="<?php //echo set_value('wholesale_price', $details['wholesale_price']); ?>">
              <?php //echo form_error('wholesale_price'); ?>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group <?php //echo form_error('retailer_price') ? 'has-error' : ''; ?>">
              <label>Retailer Price</label>
              <input type="number" step="0.01" min="0" name="retailer_price" class="form-control" value="<?php //echo set_value('retailer_price', $details['retailer_price']); ?>">
              <?php //echo form_error('retailer_price'); ?>
            </div>
          </div> -->
        </div>
        <div class="form-group <?php echo form_error('quantity') ? 'has-error' : ''; ?>">
          <label>Quantity</label>
          <input type="number" min="0" name="quantity" class="form-control" value="<?php echo set_value('quantity', $details['quantity']); ?>">
          <?php echo form_error('quantity'); ?>
        </div>

        <!-- Price Variants -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-tags"></i> Price Variants (Quick Add Tiers) <small class="text-muted">- Optional</small></h3>
          </div>
          <div class="box-body">
            <div id="variants-container">
              <?php if(!empty($variants)): foreach($variants as $v): ?>
              <div class="variant-row row" style="margin-bottom:8px;">
                <div class="col-md-5"><input type="text" name="variant_label[]" class="form-control" value="<?php echo htmlspecialchars($v['label']); ?>" placeholder="Label e.g. 10 pieces"></div>
                <div class="col-md-4"><input type="number" step="0.01" name="variant_price[]" class="form-control" value="<?php echo $v['price']; ?>" placeholder="Price"></div>
                <div class="col-md-3"><button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fa fa-trash"></i> Remove</button></div>
              </div>
              <?php endforeach; else: ?>
              <div class="variant-row row" style="margin-bottom:8px;">
                <div class="col-md-5"><input type="text" name="variant_label[]" class="form-control" placeholder="Label e.g. 10 pieces"></div>
                <div class="col-md-4"><input type="number" step="0.01" name="variant_price[]" class="form-control" placeholder="Price e.g. 6.99"></div>
                <div class="col-md-3"><button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fa fa-trash"></i> Remove</button></div>
              </div>
              <?php endif; ?>
            </div>
            <button type="button" class="btn btn-success btn-sm" id="add-variant-btn"><i class="fa fa-plus"></i> Add Tier</button>
          </div>
        </div>

        <div class="form-group">
          <label>Short Description</label>
          <textarea name="description" class="form-control" rows="3"><?php echo set_value('description', $details['description']); ?></textarea>
        </div>
        <div class="form-group">
          <label>Long Description</label>
          <textarea name="long_description" id="editor" class="form-control" rows="5"><?php echo set_value('long_description', $details['long_description']); ?></textarea>
        </div>
        <?php
        $imgs = array(
          array('field'=>'image','label'=>'Main Image','key'=>'image_file'),
          array('field'=>'image_1','label'=>'Sub Image 1','key'=>'image_file_1'),
          array('field'=>'image_2','label'=>'Sub Image 2','key'=>'image_file_2'),
          array('field'=>'image_3','label'=>'Sub Image 3','key'=>'image_file_3'),
          array('field'=>'image_4','label'=>'Sub Image 4','key'=>'image_file_4'),
        );
        ?>
        <div class="row">
        <?php foreach($imgs as $img): ?>
          <div class="col-md-4">
            <div class="form-group">
              <label><?php echo $img['label']; ?></label>
              <?php if(!empty($details[$img['field']])): ?>
              <div><img src="<?php echo SHOW_PRODUCT_PATH.$details[$img['field']]; ?>" width="80" height="80" style="object-fit:cover;" class="img-thumbnail"></div>
              <?php endif; ?>
              <input type="file" name="<?php echo $img['key']; ?>" class="form-control" accept="image/*">
            </div>
          </div>
        <?php endforeach; ?>
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
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="<?php echo base_url('product'); ?>" class="btn btn-default">Cancel</a>
      </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>
<script>
function loadSubCategories(catId) {
  $.post('<?php echo base_url('category/getSubcategoriesByCategory'); ?>', {category_id: catId}, function(res) {
    $('#sub_category_id').html(res);
  });
}
$(document).on('click','#add-variant-btn',function(){
  var row = '<div class="variant-row row" style="margin-bottom:8px;"><div class="col-md-5"><input type="text" name="variant_label[]" class="form-control" placeholder="Label e.g. 25 pieces"></div><div class="col-md-4"><input type="number" step="0.01" name="variant_price[]" class="form-control" placeholder="Price"></div><div class="col-md-3"><button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fa fa-trash"></i> Remove</button></div></div>';
  $('#variants-container').append(row);
});
$(document).on('click','.remove-variant',function(){ $(this).closest('.variant-row').remove(); });
</script>
