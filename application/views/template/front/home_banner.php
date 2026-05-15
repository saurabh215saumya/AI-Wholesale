<!-- Banner Slider -->
<div class="slider-container rev_slider_wrapper" style="height:500px;">
    <div id="revolutionSlider" class="slider rev_slider manual">
        <ul>
            <?php if(!empty($allBanners)): foreach($allBanners as $b):
                $bImg = file_exists(UPLOAD_BANNER_PATH.$b['image']) ? SHOW_BANNER_PATH.$b['image'] : base_url('assets/images/img/demos/shop/slides/shop5/slide2.jpg');
            ?>
            <li data-transition="fade">
                <img src="<?php echo $bImg; ?>" alt="<?php echo $b['title']; ?>" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg">
                <div class="tp-caption top-label" data-x="227" data-y="180" data-start="500" data-transform_in="y:[-300%];opacity:0;s:500;"></div>
                <div class="tp-caption main-label" data-x="140" data-y="210" data-start="1500" data-whitespace="nowrap" data-transform_in="y:[100%];s:500;" data-transform_out="opacity:0;s:500;" data-mask_in="x:0px;y:0px;"></div>
                <div class="tp-caption bottom-label" data-x="185" data-y="280" data-start="2000" data-transform_in="y:[100%];opacity:0;s:500;"></div>
            </li>
            <?php endforeach; else: ?>
            <li data-transition="fade">
                <img src="<?php echo base_url('assets/images/img/demos/shop/slides/shop5/slide2.jpg'); ?>" alt="slide" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg">
                <div class="tp-caption top-label" data-x="227" data-y="180" data-start="500" data-transform_in="y:[-300%];opacity:0;s:500;"></div>
                <div class="tp-caption main-label" data-x="140" data-y="210" data-start="1500" data-whitespace="nowrap" data-transform_in="y:[100%];s:500;" data-transform_out="opacity:0;s:500;" data-mask_in="x:0px;y:0px;"></div>
                <div class="tp-caption bottom-label" data-x="185" data-y="280" data-start="2000" data-transform_in="y:[100%];opacity:0;s:500;"></div>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>