<div class="content-wrapper">
    <section class="content-header" style="display:flex;align-items:center;justify-content:space-between;">
        <h1 style="margin:0;">Promo Banner Management</h1>
        <a href="<?php echo base_url('promo-banner/add'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Promo Banner</a>
    </section>
    <section class="content">
        <?php echo $this->session->flashdata('response'); ?>
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Link</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($promos)): foreach ($promos as $i => $p): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td>
                                <?php if ($p['image']): ?>
                                <img src="<?php echo SHOW_PROMO_BANNER_PATH . $p['image']; ?>" style="height:50px;border-radius:4px;">
                                <?php else: ?>—<?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($p['title']); ?></td>
                            <td><?php echo htmlspecialchars($p['link']); ?></td>
                            <td><?php echo $p['sort_order']; ?></td>
                            <td>
                                <span statusid="<?php echo $p['id']; ?>" statusvalue="<?php echo $p['status']; ?>" controllername="promo_banner"
                                    style="color:<?php echo $p['status'] ? '#00a65a' : '#ff0000'; ?>;cursor:pointer;"
                                    title="<?php echo $p['status'] ? 'Active' : 'In Active'; ?>"
                                    onclick="changeStatus(this)">
                                    <i class="fa fa-2x <?php echo $p['status'] ? 'fa-check' : 'fa-ban'; ?>"></i>
                                </span>
                            </td>
                            <td>
                                <a href="<?php echo base_url('promo-banner/edit/' . $p['id']); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
                                <a href="<?php echo base_url('promo-banner/delete/' . $p['id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this promo banner?')"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="7" class="text-center">No promo banners found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<script>
function changeStatus(el) {
    $.post('<?php echo base_url("promo-banner/changestatus"); ?>', {
        statusid: $(el).attr('statusid'),
        statusvalue: $(el).attr('statusvalue'),
        controllername: $(el).attr('controllername')
    }, function(res) { $(el).replaceWith(res); });
}
</script>
