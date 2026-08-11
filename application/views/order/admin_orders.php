<div class="content-wrapper">
<?php echo $this->session->flashdata('response'); ?>
<section class="content-header">
  <h1>Order Management</h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Orders</li>
  </ol>
</section>
<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">All Orders</h3>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="ordersTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Customer</th>
              <th>Email</th>
              <th>Items</th>
              <th>Pay Amount</th>
              <th>Shipping</th>
              <th>Other</th>
              <th>Total</th>
              <th>Payment</th>
              <th>Pay Status</th>
              <th>Order Status</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($orders as $o):
            $statusLabels = ['0'=>'In Review','1'=>'Confirmed','2'=>'Cancelled'];
            $payLabels    = ['0'=>'Unpaid','1'=>'Paid'];
            $statusClass  = ['0'=>'warning','1'=>'success','2'=>'danger'];
            $payClass     = ['0'=>'danger','1'=>'success'];
          ?>
          <tr>
            <td><strong>#<?php echo $o['id']; ?></strong></td>
            <td><?php echo htmlspecialchars($o['first_name'].' '.$o['last_name']); ?></td>
            <td><?php echo htmlspecialchars($o['email']); ?></td>
            <td><?php echo $o['item_count']; ?></td>
            <td>€<?php echo number_format($o['pay_amount'],2); ?></td>
            <td>€<?php echo number_format($o['shipping_charge'],2); ?></td>
            <td>€<?php echo number_format($o['other_charges'],2); ?></td>
            <td><strong>€<?php echo number_format($o['total_amount'],2); ?></strong></td>
            <td><?php echo ucfirst($o['payment_method']); ?></td>
            <td><span class="label label-<?php echo $payClass[$o['payment_status']] ?? 'default'; ?>"><?php echo $payLabels[$o['payment_status']] ?? '-'; ?></span></td>
            <td><span class="label label-<?php echo $statusClass[$o['status']] ?? 'default'; ?>"><?php echo $statusLabels[$o['status']] ?? '-'; ?></span></td>
            <td><?php echo date('d M Y', strtotime($o['addedOn'])); ?></td>
            <td>
              <a href="<?php echo base_url('admin-orders/edit/'.$o['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Manage</a>
            </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<script>
$(document).ready(function(){ if($.fn.DataTable) $('#ordersTable').DataTable({order:[[0,'desc']]}); });
</script>
</div>
