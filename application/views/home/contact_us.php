<section class="page-header mb-lg">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="active">Contact Us</li>
        </ul>
    </div>
</section>
<div class="container mb-xlg">
    <div class="row">
        <div class="col-md-7">
            <h2 class="heading-primary">Send Us a Message</h2>
            <?php echo $this->session->flashdata('success') ? '<div class="alert alert-success">'.$this->session->flashdata('success').'</div>' : ''; ?>
            <?php echo form_open('contact-us'); ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group"><label>Your Name <span class="required">*</span></label><input type="text" name="name" class="form-control" required></div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group"><label>Email Address <span class="required">*</span></label><input type="email" name="email" class="form-control" required></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group"><label>Phone</label><input type="text" name="phone" class="form-control"></div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group"><label>Subject</label><input type="text" name="subject" class="form-control"></div>
                </div>
            </div>
            <div class="form-group"><label>Message <span class="required">*</span></label><textarea name="message" class="form-control" rows="6" required></textarea></div>
            <input type="submit" class="btn btn-primary" value="Send Message">
            <?php echo form_close(); ?>
        </div>
        <div class="col-md-5">
            <h2 class="heading-primary">Contact Information</h2>
            <ul class="contact-details">
                <li><i class="fa fa-map-marker fa-fw text-color-primary"></i> Unit D2, Tamian Way, TW4 6BL</li>
                <li><i class="fa fa-phone fa-fw text-color-primary"></i> 07414 560342</li>
                <li><i class="fa fa-envelope fa-fw text-color-primary"></i> <a href="mailto:<?php echo ADMIN_EMAIL; ?>"><?php echo ADMIN_EMAIL; ?></a></li>
                <li><i class="fa fa-clock-o fa-fw text-color-primary"></i> Mon - Sat / 9:00AM - 8:00PM</li>
            </ul>
        </div>
    </div>
</div>
