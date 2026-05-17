<div class="content-wrapper">
    <section class="content-header">
        <h1>Add Pricing Tier</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo base_url('wholesale/admin_pricing'); ?>">Pricing Tiers</a></li>
            <li class="active">Add Tier</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">New Pricing Tier</h3>
            </div>
            <form action="<?php echo base_url('wholesale/save_tier'); ?>" method="post">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tier Name <span class="text-danger">*</span></label>
                                <input type="text" name="tier_name" class="form-control" required placeholder="e.g. Gold">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Min Qty <span class="text-danger">*</span></label>
                                <input type="number" name="min_qty" class="form-control" required min="1" value="1">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Max Qty <small>(leave blank = unlimited)</small></label>
                                <input type="number" name="max_qty" class="form-control" min="1" placeholder="Unlimited">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Discount % <span class="text-danger">*</span></label>
                                <input type="number" name="discount_percent" class="form-control" required min="0" max="100" step="0.01" value="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="0" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" class="form-control" placeholder="Short description for this tier">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save Tier</button>
                    <a href="<?php echo base_url('wholesale/admin_pricing'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
