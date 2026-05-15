<div class="content-wrapper">
  <section class="content-header">
    <h1>Product Management</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li class="active">Products</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box">
      <div class="box-header"><h3 class="box-title">Product List</h3>
        <div class="pull-right">
          <a href="<?php echo base_url('product/addproduct'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Product</a>
          <a href="<?php echo base_url('product/upload_bulk_product'); ?>" class="btn btn-success btn-sm"><i class="fa fa-upload"></i> Bulk Upload</a>
        </div>
      </div>
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped" id="example1">
          <thead><tr><th>#</th><th>Image</th><th>Name</th><th>Code</th><th>Category</th><th>Price</th><th>Qty</th><th>Variants</th><th>New</th><th>Featured</th><th>Status</th><th>Action</th></tr></thead>
          <tbody>
          <?php if(!empty($allproducts)): $i=1; foreach($allproducts as $p): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php if($p['image']): ?><img src="<?php echo SHOW_PRODUCT_PATH.$p['image']; ?>" width="50" height="50" style="object-fit:cover;"><?php endif; ?></td>
            <td><?php echo $p['product_name']; ?></td>
            <td><?php echo $p['product_code']; ?></td>
            <td><?php echo $p['category_name']; ?><br><small><?php echo $p['sub_category_name']; ?></small></td>
            <td>£<?php echo number_format($p['price'],2); ?></td>
            <td><?php echo $p['quantity']; ?></td>
            <td>
              <?php
              $CI =& get_instance();
              $vCount = count($CI->Product_model->getAllVariantsByProduct($p['id']));
              ?>
              <?php if($vCount > 0): ?>
              <span class="badge bg-green" title="<?php echo $vCount; ?> price tier(s)"><?php echo $vCount; ?> tier<?php echo $vCount>1?'s':''; ?></span>
              <?php else: ?>
              <span class="text-muted">—</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="<?php echo base_url('product/updateflag/'.$p['id'].'/new'); ?>" class="btn btn-xs <?php echo $p['new_product']?'btn-success':'btn-default'; ?>" title="Toggle New">N</a>
            </td>
            <td>
              <a href="<?php echo base_url('product/updateflag/'.$p['id'].'/featured'); ?>" class="btn btn-xs <?php echo $p['best_seller']?'btn-warning':'btn-default'; ?>" title="Toggle Featured">F</a>
            </td>
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
    </div>
  </section>
</div>
