<div class="content-wrapper">
  <section class="content-header">
    <h1>User Management</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li class="active">Users</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box">
      <div class="box-header"><h3 class="box-title">User List</h3></div>
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped" id="example1">
          <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Mobile</th><th>Company</th><th>Type</th><th>Status</th><th>Joined</th><th>Action</th></tr></thead>
          <tbody>
          <?php if(!empty($allusers)): $i=1; foreach($allusers as $u): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $u['first_name'].' '.$u['last_name']; ?></td>
            <td><?php echo $u['email']; ?></td>
            <td><?php echo $u['mobile']; ?></td>
            <td><?php echo $u['company_name']; ?></td>
            <td><span class="label label-info"><?php echo ucfirst($u['user_type']); ?></span></td>
            <td><span class="label label-<?php echo $u['status']?'success':'danger'; ?>"><?php echo $u['status']?'Active':'Inactive'; ?></span></td>
            <td><?php echo $u['addedOn']; ?></td>
            <td>
              <a href="<?php echo base_url('appuser/view_user/'.$u['id']); ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
              <a href="<?php echo base_url('appuser/edit/'.$u['id']); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
              <a href="<?php echo base_url('appuser/delete/'.$u['id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete user?')"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
