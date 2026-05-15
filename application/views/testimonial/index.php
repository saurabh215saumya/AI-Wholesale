<div class="content-wrapper">
  <section class="content-header">
    <h1>Testimonial Management</h1>
    <ol class="breadcrumb"><li><a href="<?php echo base_url('admin'); ?>">Home</a></li><li class="active">Testimonials</li></ol>
  </section>
  <section class="content">
    <?php echo $this->session->flashdata('response'); ?>
    <div class="box">
      <div class="box-header"><h3 class="box-title">Testimonial List</h3>
        <a href="<?php echo base_url('testimonial/addtestimonial'); ?>" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Add Testimonial</a>
      </div>
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped" id="example1">
          <thead><tr><th>#</th><th>Image</th><th>Name</th><th>Designation</th><th>Review</th><th>Status</th><th>Action</th></tr></thead>
          <tbody>
          <?php if(!empty($alltestimonials)): $i=1; foreach($alltestimonials as $t): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php if($t['image']): ?><img src="<?php echo SHOW_TESTIMONIAL_PATH.$t['image']; ?>" width="50" height="50" style="border-radius:50%;object-fit:cover;"><?php endif; ?></td>
            <td><?php echo $t['name']; ?></td>
            <td><?php echo $t['designation']; ?></td>
            <td><?php echo substr(strip_tags($t['description']),0,80).'...'; ?></td>
            <td>
              <span statusid="<?php echo $t['id']; ?>" statusvalue="<?php echo $t['status']; ?>" controllername="<?php echo $controller; ?>" style="color:<?php echo $t['status']?'#00a65a':'#ff0000'; ?>;cursor:pointer;">
                <i class="fa fa-2x <?php echo $t['status']?'fa-check':'fa-ban'; ?>"></i>
              </span>
            </td>
            <td>
              <a href="<?php echo base_url('testimonial/edit/'.$t['id']); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
              <a href="<?php echo base_url('testimonial/delete/'.$t['id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete?')"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
