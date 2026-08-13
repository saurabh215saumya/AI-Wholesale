<?php
$CI =& get_instance();
$CI->load->model('Promo_banner_model');
$promos = $CI->Promo_banner_model->getActive();
if (empty($promos)) return;
?>
<div class="banners-container">
    <div class="container">
        <div class="row">
            <?php foreach ($promos as $i => $p): ?>
            <?php if ($i == 2): ?><div class="clearfix visible-sm visible-xs"></div><?php endif; ?>
            <div class="col-xs-6 col-md-3">
                <a href="<?php echo htmlspecialchars($p['link']); ?>" class="banner">
                    <img src="<?php echo SHOW_PROMO_BANNER_PATH . $p['image']; ?>" alt="<?php echo htmlspecialchars($p['alt_text']); ?>">
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
