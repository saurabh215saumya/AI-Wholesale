<div class="content-wrapper">
  <section class="content-header">
    <h1>Banner Management</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li class="active">Banners</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box">
      <div class="box-header"><h3 class="box-title">Banner List</h3>
        <a href="<?php echo base_url('banner/addbanner'); ?>" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Add Banner</a>
      </div>
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped" id="example1">
          <thead><tr><th>#</th><th>Image</th><th>Title</th><th>Status</th><th>Action</th></tr></thead>
          <tbody>
          <?php if(!empty($allbanners)): $i=1; foreach($allbanners as $b): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php if($b['image']): ?><img src="<?php echo SHOW_BANNER_PATH.$b['image']; ?>" width="100" style="max-height:60px;object-fit:cover;"><?php endif; ?></td>
            <td><?php echo $b['title']; ?></td>
            <td>
              <span statusid="<?php echo $b['id']; ?>" statusvalue="<?php echo $b['status']; ?>" controllername="<?php echo $controller; ?>" style="color:<?php echo $b['status']?'#00a65a':'#ff0000'; ?>;cursor:pointer;" title="<?php echo $b['status']?'Active':'Inactive'; ?>">
                <i class="fa fa-2x <?php echo $b['status']?'fa-check':'fa-ban'; ?>"></i>
              </span>
            </td>
            <td>
              <a href="<?php echo base_url('banner/edit/'.$b['id']); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
              <a href="<?php echo base_url('banner/delete/'.$b['id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this banner?')"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
