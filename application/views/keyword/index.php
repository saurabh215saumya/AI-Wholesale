<div class="content-wrapper">
  <section class="content-header">
    <h1>Keyword Management</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li class="active">Keywords</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">All Keywords</h3>
        <div class="pull-right">
          <a href="<?php echo base_url('keyword/add'); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Keyword</a>
          <a href="<?php echo base_url('keyword/upload_csv'); ?>" class="btn btn-info btn-sm"><i class="fa fa-upload"></i> Upload CSV</a>
        </div>
      </div>
      <div class="box-body table-responsive">
        <table class="table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th>#</th><th>Keyword</th><th>Status</th><th>Added On</th><th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($allKeywords)): $i=1; foreach($allKeywords as $row): ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo htmlspecialchars($row['keyword']); ?></td>
              <td><?php echo $row['status'] ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>'; ?></td>
              <td><?php echo date('d M Y', strtotime($row['addedOn'])); ?></td>
              <td>
                <a href="<?php echo base_url('keyword/edit/'.$row['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <a href="<?php echo base_url('keyword/delete/'.$row['id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this keyword?')"><i class="fa fa-trash"></i> Delete</a>
              </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="5" class="text-center">No keywords found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
