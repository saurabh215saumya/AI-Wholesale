<section class="page-header mb-lg">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="active"><?php echo isset($pageData['page_name']) ? $pageData['page_name'] : 'Page'; ?></li>
        </ul>
    </div>
</section>
<div class="container mb-xlg">
    <div class="row">
        <div class="col-md-9">
            <h2 class="heading-primary"><?php echo isset($pageData['page_name']) ? $pageData['page_name'] : ''; ?></h2>
            <div class="mt-lg">
                <?php echo !empty($pageData['content']) ? $pageData['content'] : '<p>Content coming soon.</p>'; ?>
            </div>
        </div>
        <aside class="col-md-3 sidebar">
            <div class="panel panel-default">
                <div class="panel-heading"><h4 class="panel-title">Quick Links</h4></div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li><i class="fa fa-caret-right text-color-primary"></i> <a href="<?php echo base_url('about-us'); ?>">About Us</a></li>
                        <li><i class="fa fa-caret-right text-color-primary"></i> <a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a></li>
                        <li><i class="fa fa-caret-right text-color-primary"></i> <a href="<?php echo base_url('terms-conditions'); ?>">Terms &amp; Conditions</a></li>
                        <li><i class="fa fa-caret-right text-color-primary"></i> <a href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>
