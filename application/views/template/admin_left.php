<?php $url = $this->uri->segment(1); ?>
<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu">
      <li class="treeview <?php echo ($url=='admin')?'active':''; ?>">
        <a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
      </li>

      <li class="treeview <?php echo ($url=='banner')?'active':''; ?>">
        <a href="javascript:void(0);"><i class="fa fa-image"></i> <span>Banner Management</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url('banner'); ?>"><i class="fa fa-circle-o"></i> Banner List</a></li>
          <li><a href="<?php echo base_url('banner/addbanner'); ?>"><i class="fa fa-circle-o"></i> Add Banner</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($url=='category')?'active':''; ?>">
        <a href="javascript:void(0);"><i class="fa fa-tags"></i> <span>Category Management</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url('category'); ?>"><i class="fa fa-circle-o"></i> Category List</a></li>
          <li><a href="<?php echo base_url('category/addcategory'); ?>"><i class="fa fa-circle-o"></i> Add Category</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($url=='product')?'active':''; ?>">
        <a href="javascript:void(0);"><i class="fa fa-shopping-bag"></i> <span>Product Management</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url('product'); ?>"><i class="fa fa-circle-o"></i> Product List</a></li>
          <li><a href="<?php echo base_url('product/addproduct'); ?>"><i class="fa fa-circle-o"></i> Add Product</a></li>
          <li><a href="<?php echo base_url('product/upload_bulk_product'); ?>"><i class="fa fa-circle-o"></i> Bulk Upload (CSV)</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($url=='appuser')?'active':''; ?>">
        <a href="javascript:void(0);"><i class="fa fa-users"></i> <span>User Management</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url('appuser'); ?>"><i class="fa fa-circle-o"></i> User List</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($url=='staticpage')?'active':''; ?>">
        <a href="javascript:void(0);"><i class="fa fa-file-text"></i> <span>Page Management</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url('staticpage'); ?>"><i class="fa fa-circle-o"></i> Page List</a></li>
          <li><a href="<?php echo base_url('staticpage/addpage'); ?>"><i class="fa fa-circle-o"></i> Add Page</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($url=='wholesale')?'active':''; ?>">
        <a href="javascript:void(0);"><i class="fa fa-percent"></i> <span>Wholesale Pricing</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url('wholesale/admin_pricing'); ?>"><i class="fa fa-circle-o"></i> Pricing Tiers</a></li>
          <li><a href="<?php echo base_url('wholesale/add_tier'); ?>"><i class="fa fa-circle-o"></i> Add Tier</a></li>
        </ul>
      </li>

      <li class="treeview <?php echo ($url=='testimonial')?'active':''; ?>">
        <a href="javascript:void(0);"><i class="fa fa-comments"></i> <span>Testimonial Management</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url('testimonial'); ?>"><i class="fa fa-circle-o"></i> Testimonial List</a></li>
          <li><a href="<?php echo base_url('testimonial/addtestimonial'); ?>"><i class="fa fa-circle-o"></i> Add Testimonial</a></li>
        </ul>
      </li>
    </ul>
  </section>
</aside>
