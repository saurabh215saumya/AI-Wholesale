<?php
$userId   = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['id'] : '';
$userType = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['user_type'] : '';
?>

<!-- Our Products Section -->
<?php if(!empty($featuredProducts)): ?>
<div class="container mb-lg">
    <h2 class="slider-title">
        <span class="inline-title">OUR PRODUCTS</span>
        <span class="line"></span>
    </h2>
    <div class="jly-product-grid">
        <?php foreach($featuredProducts as $p):
            $img      = getProductImage($p['image']);
            $CI       =& get_instance();
            $variants = $CI->Product_model->getVariantsByProduct($p['id']);
            $inWish   = checkUserProductInWishlist($p['id'], $userId);
            $hasVar   = !empty($variants);
            $inStock  = $p['quantity'] > 0;
            $minP     = $hasVar ? min(array_column($variants,'price')) : floatval($p['price']);
            $maxP     = $hasVar ? max(array_column($variants,'price')) : 0;
            $priceStr = ($hasVar && $maxP > $minP)
                ? CURRENCY_SYMBOL.number_format($minP,2).' - '.CURRENCY_SYMBOL.number_format($maxP,2)
                : CURRENCY_SYMBOL.number_format($minP,2);
        ?>
        <div class="jly-card" id="card-<?php echo $p['id']; ?>">
            <?php if($p['new_product']): ?><span class="jly-badge jly-badge-new">New</span><?php endif; ?>
            <?php if($p['best_seller']): ?><span class="jly-badge jly-badge-hot">Best Seller</span><?php endif; ?>
            <button class="jly-wish-btn <?php echo !empty($inWish)?'active':''; ?>" onclick="return doWishlist('<?php echo $p['id']; ?>')" title="Wishlist">
                <i class="fa fa-heart<?php echo !empty($inWish)?'':'-o'; ?>"></i>
            </button>
            <a href="<?php echo base_url('product-details/'.$p['product_slug']); ?>" class="jly-img-wrap">
                <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($p['product_name']); ?>" class="jly-img">
            </a>
            <div class="jly-info">
                <h3 class="jly-name">
                    <a href="<?php echo base_url('product-details/'.$p['product_slug']); ?>"><?php echo $p['product_name']; ?></a>
                </h3>
                <?php if($p['description']): ?>
                <p class="jly-size">Size: <?php echo htmlspecialchars(substr(strip_tags($p['description']),0,40)); ?></p>
                <?php endif; ?>

                <?php if($hasVar && $inStock): ?>
                <span class="jly-stock in">In Stock</span>
                <?php else: ?>
                <span class="jly-stock out"><i class="fa fa-exclamation-triangle"></i> Out of Stock</span>
                <?php endif; ?>

                <div class="jly-price"><?php echo $priceStr; ?></div>

                <a href="<?php echo base_url('product-details/'.$p['product_slug']); ?>" class="jly-btn jly-btn-view">
                    <i class="fa fa-eye"></i> View Details
                </a>

                <?php if($hasVar): ?>
                <button class="jly-btn jly-btn-quick" onclick="toggleQuickAdd(<?php echo $p['id']; ?>)" id="qabtn-<?php echo $p['id']; ?>">
                    <i class="fa fa-shopping-cart"></i>&nbsp; Quick Add
                    <i class="fa fa-chevron-down jly-chevron" id="chev-<?php echo $p['id']; ?>"></i>
                </button>
                <div class="jly-variants" id="variants-<?php echo $p['id']; ?>">
                    <?php foreach($variants as $v):
                        $vLabel = htmlspecialchars($v['label'], ENT_QUOTES);
                        $vPrice = floatval($v['price']);
                    ?>
                    <button class="jly-variant-row<?php echo (!$inStock)?' variant-out':''; ?>"
                        <?php if($inStock): ?>onclick="addVariantToCart(<?php echo $p['id']; ?>, <?php echo $vPrice; ?>, '<?php echo $vLabel; ?>')"<?php else: ?>disabled<?php endif; ?>>
                        <span class="jly-variant-icon"><i class="fa fa-shopping-cart"></i></span>
                        <span class="jly-variant-label"><?php echo is_numeric(trim($v['label'])) ? trim($v['label']).' pieces' : htmlspecialchars($v['label']); ?></span>
                        <span class="jly-variant-price"><?php echo CURRENCY_SYMBOL.number_format($vPrice,2); ?></span>
                        <?php if(!$inStock): ?><span class="jly-out-tag">Out</span><?php endif; ?>
                    </button>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <button class="jly-btn jly-btn-oos" disabled>
                    <i class="fa fa-shopping-cart"></i>&nbsp; Out of Stock
                </button>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="text-center mt-md">
        <a href="<?php echo base_url('all-products'); ?>" class="btn btn-primary btn-lg" style="border-radius:30px;padding:10px 40px;">View All Products</a>
    </div>
</div>
<?php endif; ?>



<input type="hidden" id="session_user_id" value="<?php echo $userId; ?>">
<script>
function toggleQuickAdd(pid) {
    var $v = $('#variants-' + pid), $c = $('#chev-' + pid);
    var isOpen = $v.hasClass('open');
    $('.jly-variants.open').removeClass('open');
    $('.jly-chevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    if (!isOpen) { $v.addClass('open'); $c.removeClass('fa-chevron-down').addClass('fa-chevron-up'); }
}
function doAddCart(pid, qty) {
    var uid = $('#session_user_id').val();
    if (!uid) { window.location.href = BASE_URL + '/sign-in'; return; }
    $.post(BASE_URL + '/product/addItemIntoCart', {product_id: pid, user_id: uid, quantity: qty}, function(r) {
        if (r === 'login') { window.location.href = BASE_URL + '/sign-in'; return; }
        showToast('Added to cart!', 'success');
        var $qty = $('.cart-qty'); $qty.text(parseInt($qty.text()) + 1);
        var $btn = $('#card-' + pid + ' .jly-btn-quick');
        $btn.html('<i class="fa fa-check"></i>&nbsp; Item in Cart').attr('onclick', "window.location.href=BASE_URL+'/cart-list'");
    });
}
function addVariantToCart(pid, price, label) {
    var uid = $('#session_user_id').val();
    if (!uid) { window.location.href = BASE_URL + '/sign-in'; return; }
    $.post(BASE_URL + '/product/addItemIntoCart', {product_id: pid, user_id: uid, quantity: 1, variant_price: price, variant_label: label}, function(r) {
        if (r === 'login') { window.location.href = BASE_URL + '/sign-in'; return; }
        showToast(label + ' added to cart!', 'success');
        var $qty = $('.cart-qty'); $qty.text(parseInt($qty.text()) + 1);
        $('#variants-' + pid).removeClass('open');
        $('#chev-' + pid).removeClass('fa-chevron-up').addClass('fa-chevron-down');
    });
}
function doWishlist(pid) {
    var uid = $('#session_user_id').val();
    if (!uid) { window.location.href = BASE_URL + '/sign-in'; return false; }
    $.post(BASE_URL + '/product/addWishlistProduct', {product_id: pid, user_id: uid}, function(r) {
        var $btn = $('#card-' + pid + ' .jly-wish-btn');
        if (r === 'added') { $btn.addClass('active').find('i').removeClass('fa-heart-o').addClass('fa-heart'); showToast('Added to wishlist!', 'success'); }
        else { $btn.removeClass('active').find('i').removeClass('fa-heart').addClass('fa-heart-o'); showToast('Removed from wishlist.', 'info'); }
    });
    return false;
}
function showToast(msg, type) {
    var $t = $('<div class="jly-toast jly-toast-' + type + '">' + msg + '</div>');
    $('body').append($t);
    setTimeout(function() { $t.addClass('show'); }, 10);
    setTimeout(function() { $t.removeClass('show'); setTimeout(function(){ $t.remove(); }, 400); }, 2500);
}
$(document).on('click', function(e) {
    if (!$(e.target).closest('.jly-btn-quick, .jly-variants').length) {
        $('.jly-variants.open').removeClass('open');
        $('.jly-chevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    }
});
</script>
