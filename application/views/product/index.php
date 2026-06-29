<div class="content-wrapper">
  <section class="content-header">
    <h1>Product Management</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li class="active">Products</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Product List</h3>
        <div class="pull-right">
          <a href="<?php echo base_url('product/addproduct'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Product</a>
          <a href="<?php echo base_url('product/upload_bulk_product'); ?>" class="btn btn-success btn-sm"><i class="fa fa-upload"></i> Bulk Upload</a>
          <a href="<?php echo base_url('product/export_packing_list'); ?>" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-print"></i> Export Packing List</a>
        </div>
      </div>
      <div class="box-body">

        <!-- Filter Row -->
        <div class="row" style="margin-bottom:12px;">
          <div class="col-sm-3">
            <select id="filter_category" class="form-control input-sm">
              <option value="">-- All Categories --</option>
              <?php foreach($categories as $cat): ?>
              <option value="<?php echo $cat['id']; ?>"><?php echo $cat['category_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-sm-3">
            <select id="filter_sub_category" class="form-control input-sm">
              <option value="">-- All Subcategories --</option>
            </select>
          </div>
          <div class="col-sm-3">
            <select id="filter_grand_sub_category" class="form-control input-sm">
              <option value="">-- All Grand Subcategories --</option>
            </select>
          </div>
          <div class="col-sm-3">
            <button id="btn_apply_filter" class="btn btn-info btn-sm"><i class="fa fa-filter"></i> Apply Filter</button>
            <button id="btn_reset_filter" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Reset</button>
          </div>
        </div>

        <!-- Bulk Delete Bar -->
        <form id="bulk_delete_form" action="<?php echo base_url('product/delete_multiple'); ?>" method="post">
          <div id="bulk_action_bar" style="display:none;margin-bottom:8px;">
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete selected products?')">
              <i class="fa fa-trash"></i> Delete Selected (<span id="selected_count">0</span>)
            </button>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered table-striped dt-managed" id="example1">
              <thead>
                <tr>
                  <th><input type="checkbox" id="select_all" title="Select All"></th>
                  <th>#</th><th>Image</th><th>Name</th><th>Code</th><th>Category</th><th>RRP Price</th><th>Qty</th><th>Variants</th><th>New</th><th>Featured</th><th>Status</th><th>Action</th>
                </tr>
              </thead>
              <tbody id="product_table_body">
              <?php if(!empty($allproducts)): $i=1; foreach($allproducts as $p): ?>
              <tr>
                <td><input type="checkbox" name="product_ids[]" value="<?php echo $p['id']; ?>" class="row-check"></td>
                <td><?php echo $i++; ?></td>
                <td><?php if($p['image']): ?><img src="<?php echo SHOW_PRODUCT_PATH.$p['image']; ?>" width="50" height="50" style="object-fit:cover;"><?php endif; ?></td>
                <td><?php echo $p['product_name']; ?></td>
                <td><?php echo $p['product_code']; ?></td>
                <td><?php echo $p['category_name']; ?><br><small><?php echo $p['sub_category_name']; ?></small><?php if(!empty($p['grand_sub_category_name'])): ?><br><small class="text-muted"><?php echo $p['grand_sub_category_name']; ?></small><?php endif; ?></td>
                <td>£<?php echo number_format($p['price'],2); ?></td>
                <td><?php echo $p['quantity']; ?></td>
                <td>
                  <?php
                  $CI =& get_instance();
                  $vCount = count($CI->Product_model->getAllVariantsByProduct($p['id']));
                  ?>
                  <?php if($vCount > 0): ?>
                  <span class="badge bg-green"><?php echo $vCount; ?> tier<?php echo $vCount>1?'s':''; ?></span>
                  <?php else: ?><span class="text-muted">—</span><?php endif; ?>
                </td>
                <td><a href="<?php echo base_url('product/updateflag/'.$p['id'].'/new'); ?>" class="btn btn-xs <?php echo $p['new_product']?'btn-success':'btn-default'; ?>">N</a></td>
                <td><a href="<?php echo base_url('product/updateflag/'.$p['id'].'/featured'); ?>" class="btn btn-xs <?php echo $p['best_seller']?'btn-warning':'btn-default'; ?>">F</a></td>
                <td>
                  <span statusid="<?php echo $p['id']; ?>" statusvalue="<?php echo $p['status']; ?>" controllername="<?php echo $controller; ?>" style="color:<?php echo $p['status']?'#00a65a':'#ff0000'; ?>;cursor:pointer;">
                    <i class="fa fa-2x <?php echo $p['status']?'fa-check':'fa-ban'; ?>"></i>
                  </span>
                </td>
                <td>
                  <a href="<?php echo base_url('product/edit/'.$p['id']); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                  <a href="<?php echo base_url('product/delete/'.$p['id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete?')"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php endforeach; endif; ?>
              </tbody>
            </table>
          </div>
        </form>

      </div>
    </div>
  </section>
</div>

<script>
var BASE_URL = '<?php echo base_url(); ?>';
var PRODUCT_IMG_PATH = '<?php echo SHOW_PRODUCT_PATH; ?>';
var CONTROLLER = '<?php echo $controller; ?>';

// Row template for AJAX results
function buildRow(p, idx) {
    var img = p.image ? '<img src="'+PRODUCT_IMG_PATH+p.image+'" width="50" height="50" style="object-fit:cover;">' : '';
    var cat = (p.category_name||'') + (p.sub_category_name ? '<br><small>'+p.sub_category_name+'</small>' : '') + (p.grand_sub_category_name ? '<br><small class="text-muted">'+p.grand_sub_category_name+'</small>' : '');
    var price = parseFloat(p.price||0).toFixed(2);
    return '<tr>'
        + '<td><input type="checkbox" name="product_ids[]" value="'+p.id+'" class="row-check"></td>'
        + '<td>'+idx+'</td>'
        + '<td>'+img+'</td>'
        + '<td>'+p.product_name+'</td>'
        + '<td>'+p.product_code+'</td>'
        + '<td>'+cat+'</td>'
        + '<td>£'+price+'</td>'
        + '<td>'+p.quantity+'</td>'
        + '<td><span class="text-muted">—</span></td>'
        + '<td><a href="'+BASE_URL+'product/updateflag/'+p.id+'/new" class="btn btn-xs '+(p.new_product==1?'btn-success':'btn-default')+'">N</a></td>'
        + '<td><a href="'+BASE_URL+'product/updateflag/'+p.id+'/featured" class="btn btn-xs '+(p.best_seller==1?'btn-warning':'btn-default')+'">F</a></td>'
        + '<td><span statusid="'+p.id+'" statusvalue="'+p.status+'" controllername="'+CONTROLLER+'" style="color:'+(p.status==1?'#00a65a':'#ff0000')+';cursor:pointer;"><i class="fa fa-2x '+(p.status==1?'fa-check':'fa-ban')+'"></i></span></td>'
        + '<td>'
            + '<a href="'+BASE_URL+'product/edit/'+p.id+'" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a> '
            + '<a href="'+BASE_URL+'product/delete/'+p.id+'" class="btn btn-xs btn-danger" onclick="return confirm(\'Delete?\')"><i class="fa fa-trash"></i></a>'
        + '</td>'
        + '</tr>';
}

function loadSubcategories(parentId, targetSelect, callback) {
    $(targetSelect).html('<option value="">Loading...</option>');
    $.post(BASE_URL + 'product/get_subcategories', { parent_id: parentId }, function(res) {
        var opts = '<option value="">-- All --</option>';
        if (res && res.length) $.each(res, function(i, c) { opts += '<option value="'+c.id+'">'+c.category_name+'</option>'; });
        $(targetSelect).html(opts);
        if (callback) callback(res);
    }, 'json');
}

// Category change → load subcategories
$('#filter_category').on('change', function() {
    $('#filter_grand_sub_category').html('<option value="">-- All Grand Subcategories --</option>');
    var val = $(this).val();
    if (!val) { $('#filter_sub_category').html('<option value="">-- All Subcategories --</option>'); return; }
    loadSubcategories(val, '#filter_sub_category');
});

// Subcategory change → load grand sub
$('#filter_sub_category').on('change', function() {
    var val = $(this).val();
    if (!val) { $('#filter_grand_sub_category').html('<option value="">-- All Grand Subcategories --</option>'); return; }
    loadSubcategories(val, '#filter_grand_sub_category');
});

var productDT = null;

function initDataTable() {
    if (productDT) {
        productDT.destroy();
        productDT = null;
    }
    productDT = $('#example1').DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        columnDefs: [{ orderable: false, targets: [0, 2, 8, 9, 10, 11, 12] }]
    });
}

// Apply filter
$('#btn_apply_filter').on('click', function() {
    var cat   = $('#filter_category').val();
    var sub   = $('#filter_sub_category').val();
    var grand = $('#filter_grand_sub_category').val();
    $.post(BASE_URL + 'product/filter_products', { category_id: cat, sub_cat_id: sub, grand_sub_cat_id: grand }, function(res) {
        if (productDT) { productDT.destroy(); productDT = null; }
        var html = '';
        if (res && res.length) {
            $.each(res, function(i, p) { html += buildRow(p, i+1); });
        } else {
            html = '<tr><td colspan="13" class="text-center">No products found.</td></tr>';
        }
        $('#product_table_body').html(html);
        initDataTable();
        $('#select_all').prop('checked', false);
        updateBulkBar();
    }, 'json');
});

// Reset filter
$('#btn_reset_filter').on('click', function() {
    $('#filter_category').val('');
    $('#filter_sub_category').html('<option value="">-- All Subcategories --</option>');
    $('#filter_grand_sub_category').html('<option value="">-- All Grand Subcategories --</option>');
    $('#btn_apply_filter').trigger('click');
});

// Select all — works on currently visible (paginated) rows only
$('#select_all').on('change', function() {
    var checked = $(this).is(':checked');
    $('#example1 tbody .row-check').prop('checked', checked);
    updateBulkBar();
});

// Row check
$(document).on('change', '#example1 tbody .row-check', function() {
    updateBulkBar();
    var total   = $('#example1 tbody .row-check').length;
    var checked = $('#example1 tbody .row-check:checked').length;
    $('#select_all').prop('checked', total > 0 && total === checked);
});

function updateBulkBar() {
    // Collect ALL checked across all pages from the form directly
    var n = $('input[name="product_ids[]"]:checked').length;
    $('#selected_count').text(n);
    n > 0 ? $('#bulk_action_bar').show() : $('#bulk_action_bar').hide();
}

</script>
