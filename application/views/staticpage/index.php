<div class="content-wrapper">
  <section class="content-header">
    <h1>Page Management</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li class="active">Pages</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box">
      <div class="box-header"><h3 class="box-title">Page List</h3>
        <a href="<?php echo base_url('staticpage/addpage'); ?>" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Add Page</a>
      </div>
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped" id="example1">
          <thead><tr><th>#</th><th>Page Name</th><th>Identifier</th><th>Status</th><th>Action</th></tr></thead>
          <tbody>
          <?php if(!empty($allpages)): $i=1; foreach($allpages as $p): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $p['page_name']; ?></td>
            <td><code><?php echo $p['identifire']; ?></code></td>
            <td><span class="label label-<?php echo $p['status']?'success':'danger'; ?>"><?php echo $p['status']?'Active':'Inactive'; ?></span></td>
            <td>
              <a href="<?php echo base_url('staticpage/edit/'.$p['id']); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
              <a href="<?php echo base_url('staticpage/delete/'.$p['id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this page?')"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
