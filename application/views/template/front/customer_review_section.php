<!-- Testimonials -->
<?php if(!empty($allTestimonials)): ?>
<div class="container mb-lg">
    <h2 class="slider-title">
        <span class="inline-title">CUSTOMER REVIEWS</span>
        <span class="line"></span>
    </h2>
    <div class="owl-carousel owl-theme" data-plugin-options='{"items":3,"loop":true,"autoplay":true,"margin":20}'>
        <?php foreach($allTestimonials as $t): ?>
        <div class="testimonial testimonial-style-4">
            <div class="testimonial-author">
                <?php if($t['image']): ?>
                <img src="<?php echo SHOW_TESTIMONIAL_PATH.$t['image']; ?>" class="img-circle" alt="<?php echo $t['name']; ?>" width="60" height="60">
                <?php endif; ?>
                <p><strong><?php echo $t['name']; ?></strong><?php if($t['designation']): ?><span><?php echo $t['designation']; ?></span><?php endif; ?></p>
            </div>
            <blockquote><p><?php echo $t['description']; ?></p></blockquote>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>