<?php $isEdit = !empty($promo); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $isEdit ? 'Edit' : 'Add'; ?> Promo Banner</h1>
        <a href="<?php echo base_url('promo-banner'); ?>" class="btn btn-default btn-sm pull-right"><i class="fa fa-arrow-left"></i> Back</a>
    </section>
    <section class="content">
        <?php echo $this->session->flashdata('response'); ?>
        <div class="row">
            <div class="col-md-7">
                <div class="box box-primary">
                    <form action="<?php echo base_url($isEdit ? 'promo-banner/update' : 'promo-banner/save'); ?>" method="post" enctype="multipart/form-data">
                        <?php if ($isEdit): ?>
                        <input type="hidden" name="id" value="<?php echo $promo['id']; ?>">
                        <?php endif; ?>
                        <div class="box-body">
                            <?php if ($isEdit && $promo['image']): ?>
                            <div class="form-group">
                                <label>Current Image</label><br>
                                <img src="<?php echo SHOW_PROMO_BANNER_PATH . $promo['image']; ?>" style="max-height:80px;border:1px solid #ddd;padding:4px;">
                            </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label>Image <?php echo $isEdit ? '<small class="text-muted">(leave blank to keep current)</small>' : '<span class="text-danger">*</span>'; ?></label>
                                <input type="file" name="image_file" accept="image/*" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($isEdit ? $promo['title'] : ''); ?>">
                            </div>
                            <div class="form-group">
                                <label>Alt Text</label>
                                <input type="text" name="alt_text" class="form-control" value="<?php echo htmlspecialchars($isEdit ? $promo['alt_text'] : ''); ?>">
                            </div>
                            <div class="form-group">
                                <label>Link URL</label>
                                <input type="text" name="link" class="form-control" placeholder="#" value="<?php echo htmlspecialchars($isEdit ? $promo['link'] : '#'); ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sort Order</label>
                                        <input type="number" name="sort_order" class="form-control" value="<?php echo $isEdit ? (int)$promo['sort_order'] : 0; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1" <?php echo (!$isEdit || $promo['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                                            <option value="0" <?php echo ($isEdit && $promo['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"><?php echo $isEdit ? 'Update' : 'Save'; ?></button>
                            <a href="<?php echo base_url('promo-banner'); ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
