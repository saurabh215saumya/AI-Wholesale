<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Pricing Tier</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo base_url('wholesale/admin_pricing'); ?>">Pricing Tiers</a></li>
            <li class="active">Edit Tier</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Pricing Tier</h3>
            </div>
            <form action="<?php echo base_url('wholesale/update_tier'); ?>" method="post">
                <input type="hidden" name="tier_id" value="<?php echo $tier['id']; ?>">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tier Name <span class="text-danger">*</span></label>
                                <input type="text" name="tier_name" class="form-control" required value="<?php echo htmlspecialchars($tier['tier_name']); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Min Qty <span class="text-danger">*</span></label>
                                <input type="number" name="min_qty" class="form-control" required min="1" value="<?php echo $tier['min_qty']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Max Qty <small>(blank = unlimited)</small></label>
                                <input type="number" name="max_qty" class="form-control" min="1" value="<?php echo $tier['max_qty']; ?>" placeholder="Unlimited">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Discount % <span class="text-danger">*</span></label>
                                <input type="number" name="discount_percent" class="form-control" required min="0" max="100" step="0.01" value="<?php echo $tier['discount_percent']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="<?php echo $tier['sort_order']; ?>" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($tier['description']); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" <?php echo $tier['status']==1?'selected':''; ?>>Active</option>
                                    <option value="0" <?php echo $tier['status']==0?'selected':''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Update Tier</button>
                    <a href="<?php echo base_url('wholesale/admin_pricing'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
