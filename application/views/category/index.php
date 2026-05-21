<div class="content-wrapper">
  <section class="content-header">
    <h1>Category Management</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li class="active">Categories</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box">
      <div class="box-header"><h3 class="box-title">Category List</h3>
        <a href="<?php echo base_url('category/addcategory'); ?>" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Add Category</a>
      </div>
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped" id="example1">
          <thead><tr><th>#</th><th>Image</th><th>Name</th><th>Parent</th><th>Level</th><th>Status</th><th>Action</th></tr></thead>
          <tbody>
          <?php
          // Build id=>name map for parent lookup
          $catMap = array();
          foreach($allcategories as $c) $catMap[$c['id']] = $c['category_name'];
          if(!empty($allcategories)): $i=1; foreach($allcategories as $c):
            $level = $c['parent_id'] == 0 ? 'Root' : ($catMap[$c['parent_id']] ?? 'Child');
            $indent = $c['parent_id'] == 0 ? '' : '&nbsp;&nbsp;&nbsp;<i class="fa fa-level-up fa-rotate-90 text-muted"></i> ';
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php if($c['image']): ?><img src="<?php echo SHOW_CATEGORY_PATH.$c['image']; ?>" width="50" height="50" style="object-fit:cover;"><?php endif; ?></td>
            <td><?php echo $indent.$c['category_name']; ?></td>
            <td><?php echo $c['parent_id'] > 0 ? ($catMap[$c['parent_id']] ?? '-') : '<span class="label label-primary">Root</span>'; ?></td>
            <td><?php echo $c['parent_id'] == 0 ? '<span class="label label-default">Level 1</span>' : '<span class="label label-info">Sub Level</span>'; ?></td>
            <td>
              <span statusid="<?php echo $c['id']; ?>" statusvalue="<?php echo $c['status']; ?>" controllername="<?php echo $controller; ?>" style="color:<?php echo $c['status']?'#00a65a':'#ff0000'; ?>;cursor:pointer;">
                <i class="fa fa-2x <?php echo $c['status']?'fa-check':'fa-ban'; ?>"></i>
              </span>
            </td>
            <td>
              <a href="<?php echo base_url('category/edit/'.$c['id']); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
              <a href="<?php echo base_url('category/delete/'.$c['id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete?')"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
