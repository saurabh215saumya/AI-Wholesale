<div class="content-wrapper">
  <section class="content-header">
    <h1>Sub Category Management</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li class="active">Sub Categories</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box">
      <div class="box-header"><h3 class="box-title">Sub Category List</h3>
        <a href="<?php echo base_url('subcategory/addsubcategory'); ?>" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Add Sub Category</a>
      </div>
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped" id="example1">
          <thead><tr><th>#</th><th>Category</th><th>Sub Category</th><th>Status</th><th>Action</th></tr></thead>
          <tbody>
          <?php if(!empty($allsubcategories)): $i=1; foreach($allsubcategories as $s): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $s['category_name']; ?></td>
            <td><?php echo $s['sub_category_name']; ?></td>
            <td>
              <span statusid="<?php echo $s['id']; ?>" statusvalue="<?php echo $s['status']; ?>" controllername="<?php echo $controller; ?>" style="color:<?php echo $s['status']?'#00a65a':'#ff0000'; ?>;cursor:pointer;">
                <i class="fa fa-2x <?php echo $s['status']?'fa-check':'fa-ban'; ?>"></i>
              </span>
            </td>
            <td>
              <a href="<?php echo base_url('subcategory/edit/'.$s['id']); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
              <a href="<?php echo base_url('subcategory/delete/'.$s['id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete?')"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
