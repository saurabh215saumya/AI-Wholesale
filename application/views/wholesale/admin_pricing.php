<div class="content-wrapper">
    <section class="content-header">
        <h1>Wholesale Pricing Tiers</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Pricing Tiers</li>
        </ol>
    </section>
    <section class="content">
        <?php echo $this->session->flashdata('response'); ?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">All Pricing Tiers</h3>
                <div class="box-tools pull-right">
                    <a href="<?php echo base_url('wholesale/add_tier'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Tier</a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" id="tiersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tier Name</th>
                            <th>Min Qty</th>
                            <th>Max Qty</th>
                            <th>Discount %</th>
                            <th>Description</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($tiers)): foreach($tiers as $i => $tier): ?>
                        <tr>
                            <td><?php echo $i+1; ?></td>
                            <td><?php echo htmlspecialchars($tier['tier_name']); ?></td>
                            <td><?php echo number_format($tier['min_qty']); ?></td>
                            <td><?php echo $tier['max_qty'] ? number_format($tier['max_qty']) : 'Unlimited'; ?></td>
                            <td><strong><?php echo $tier['discount_percent']; ?>%</strong></td>
                            <td><?php echo htmlspecialchars($tier['description']); ?></td>
                            <td><?php echo $tier['sort_order']; ?></td>
                            <td><?php echo $tier['status'] ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>'; ?></td>
                            <td>
                                <a href="<?php echo base_url('wholesale/edit_tier/'.$tier['id']); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
                                <a href="<?php echo base_url('wholesale/delete_tier/'.$tier['id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this tier?');"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="9" class="text-center">No pricing tiers found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<script>$(function(){ $('#tiersTable').DataTable(); });</script>
