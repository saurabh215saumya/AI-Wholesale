<?php
$userId      = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['id'] : '';
$totalCount  = isset($wlTotalCount)  ? (int)$wlTotalCount  : 0;
$pageCount   = isset($wlPageCount)   ? (int)$wlPageCount   : 1;
$currentPage = isset($wlCurrentPage) ? (int)$wlCurrentPage : 0;
$baseUrl     = base_url('wish-list');
?>

<style>
.jly-product-grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
@media(max-width:1100px){.jly-product-grid-4{grid-template-columns:repeat(3,1fr);}}
@media(max-width:768px){.jly-product-grid-4{grid-template-columns:repeat(2,1fr);}}
@media(max-width:480px){.jly-product-grid-4{grid-template-columns:1fr;}}
.wl-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:10px;}
.wl-count{color:#999;font-size:13px;margin:4px 0 0;}
.wl-shop-btn{background:linear-gradient(90deg,#ff6b9d,#ff8c42);color:#fff;border:none;border-radius:30px;padding:9px 20px;font-size:13px;font-weight:700;text-decoration:none;transition:opacity .2s;display:inline-block;}
.wl-shop-btn:hover{opacity:.85;color:#fff;text-decoration:none;}
.wl-empty{text-align:center;padding:70px 20px;}
.wl-empty-icon{font-size:64px;color:#ffb3cc;margin-bottom:16px;}
.wl-empty h3{font-size:22px;font-weight:700;color:#333;margin-bottom:8px;}
.wl-empty p{color:#999;font-size:14px;margin-bottom:24px;}
.wl-browse-btn{display:inline-block;background:linear-gradient(90deg,#ff6b9d,#ff8c42);color:#fff;border-radius:30px;padding:12px 28px;font-size:15px;font-weight:700;text-decoration:none;transition:opacity .2s;}
.wl-browse-btn:hover{opacity:.85;color:#fff;text-decoration:none;}
.jly-card.wl-removing{opacity:0;transform:scale(.9);transition:all .3s ease;}
</style>

<section class="page-header mb-lg">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="active">My Wishlist</li>
        </ul>
    </div>
</section>

<div class="container mb-xlg">

    <div class="wl-header">
        <div>
            <h2 class="heading-primary mb-none">My Wishlist</h2>
            <p class="wl-count" id="wl-count-text"><?php echo $totalCount; ?> item<?php echo $totalCount != 1 ? 's' : ''; ?> saved</p>
        </div>
        <?php if($totalCount > 0): ?>
        <a href="<?php echo base_url('all-products'); ?>" class="wl-shop-btn"><i class="fa fa-plus"></i> Add More</a>
        <?php endif; ?>
    </div>

    <?php if(!empty($allWishlistProducts)): ?>

    <div class="jly-product-grid-4" id="wl-grid">
        <?php foreach($allWishlistProducts as $p):
            $CI        =& get_instance();
            $img       = getProductImage($p['image']);
            $detailUrl = base_url('product-details/'.$p['product_slug']);
            $variants  = $CI->Product_model->getVariantsByProduct($p['product_id']);
            $hasVar    = !empty($variants);
            $inStock   = isset($p['quantity']) ? $p['quantity'] > 0 : true;
            $minP      = $hasVar ? min(array_column($variants,'price')) : floatval($p['price']);
            $maxP      = $hasVar ? max(array_column($variants,'price')) : 0;
            $priceStr  = ($hasVar && $maxP > $minP)
                ? CURRENCY_SYMBOL.number_format($minP,2).' - '.CURRENCY_SYMBOL.number_format($maxP,2)
                : CURRENCY_SYMBOL.number_format($minP,2);
            $cardId    = 'wlcard-'.$p['product_id'];
        ?>
        <div class="jly-card" id="<?php echo $cardId; ?>">
            <button class="jly-wish-btn active" onclick="removeFromWishlist('<?php echo $p['product_id']; ?>','<?php echo $cardId; ?>')" title="Remove from Wishlist">
                <i class="fa fa-heart"></i>
            </button>
            <a href="<?php echo $detailUrl; ?>" class="jly-img-wrap">
                <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($p['product_name']); ?>" class="jly-img">
            </a>
            <div class="jly-info">
                <h3 class="jly-name"><a href="<?php echo $detailUrl; ?>"><?php echo $p['product_name']; ?></a></h3>
                <?php if($hasVar && $inStock): ?>
                <span class="jly-stock in">In Stock</span>
                <?php else: ?>
                <span class="jly-stock out"><i class="fa fa-exclamation-triangle"></i> Out of Stock</span>
                <?php endif; ?>
                <div class="jly-price"><?php echo $priceStr; ?></div>
                <a href="<?php echo $detailUrl; ?>" class="jly-btn jly-btn-view"><i class="fa fa-eye"></i> View Details</a>
                <?php if($hasVar): ?>
                <button class="jly-btn jly-btn-quick" onclick="toggleQuickAdd('<?php echo $cardId; ?>')" id="qabtn-<?php echo $cardId; ?>">
                    <i class="fa fa-shopping-cart"></i>&nbsp; Quick Add
                    <i class="fa fa-chevron-down jly-chevron" id="chev-<?php echo $cardId; ?>"></i>
                </button>
                <div class="jly-variants" id="variants-<?php echo $cardId; ?>">
                    <?php foreach($variants as $v):
                        $vLabel = htmlspecialchars($v['label'], ENT_QUOTES);
                        $vPrice = floatval($v['price']);
                    ?>
                    <button class="jly-variant-row<?php echo !$inStock?' variant-out':''; ?>"
                        <?php if($inStock): ?>onclick="qaSelectVariant(this, <?php echo $p['product_id']; ?>, <?php echo $vPrice; ?>, '<?php echo $vLabel; ?>')"<?php else: ?>disabled<?php endif; ?>>
                        <span class="jly-variant-icon"><i class="fa fa-tag"></i></span>
                        <span class="jly-variant-label"><?php echo is_numeric(trim($v['label'])) ? trim($v['label']).' pieces' : htmlspecialchars($v['label']); ?></span>
                        <span class="jly-variant-price"><?php echo CURRENCY_SYMBOL.number_format($vPrice,2); ?></span>
                        <?php if(!$inStock): ?><span class="jly-out-tag">Out</span><?php endif; ?>
                    </button>
                    <?php endforeach; ?>
                    <div class="jly-qa-footer">
                        <div class="jly-qa-qty">
                            <button class="jly-qa-qty-btn" onclick="qaChangeQty('<?php echo $p['product_id']; ?>', -1)">&#8722;</button>
                            <span class="jly-qa-qty-val" id="qa-qty-<?php echo $p['product_id']; ?>">1</span>
                            <button class="jly-qa-qty-btn" onclick="qaChangeQty('<?php echo $p['product_id']; ?>', 1)">&#43;</button>
                        </div>
                        <button class="jly-qa-cart-btn" id="qa-cart-<?php echo $p['product_id']; ?>" onclick="qaAddToCart('<?php echo $p['product_id']; ?>')" disabled>
                            <i class="fa fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
                <?php else: ?>
                <button class="jly-btn jly-btn-oos" disabled><i class="fa fa-shopping-cart"></i>&nbsp; Out of Stock</button>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if($pageCount > 1):
        $visiblePages = 5;
        $half      = floor($visiblePages / 2);
        $startPage = max(0, $currentPage - $half);
        $endPage   = min($pageCount - 1, $startPage + $visiblePages - 1);
        if($endPage - $startPage < $visiblePages - 1) $startPage = max(0, $endPage - $visiblePages + 1);
    ?>
    <div class="jly-pg-wrap" style="margin-top:30px;">
        <a class="jly-pg-btn<?php echo $currentPage==0?' jly-pg-dis':''; ?>" href="<?php echo $currentPage>0?$baseUrl.'?page=0':'#'; ?>" title="First">&laquo;</a>
        <a class="jly-pg-btn<?php echo $currentPage==0?' jly-pg-dis':''; ?>" href="<?php echo $currentPage>0?$baseUrl.'?page='.($currentPage-1):'#'; ?>" title="Previous">&lsaquo;</a>
        <?php for($pg=$startPage; $pg<=$endPage; $pg++): ?>
        <a class="jly-pg-btn<?php echo $pg==$currentPage?' jly-pg-active':''; ?>" href="<?php echo $baseUrl.'?page='.$pg; ?>"><?php echo $pg+1; ?></a>
        <?php endfor; ?>
        <a class="jly-pg-btn<?php echo $currentPage==$pageCount-1?' jly-pg-dis':''; ?>" href="<?php echo $currentPage<$pageCount-1?$baseUrl.'?page='.($currentPage+1):'#'; ?>" title="Next">&rsaquo;</a>
        <a class="jly-pg-btn<?php echo $currentPage==$pageCount-1?' jly-pg-dis':''; ?>" href="<?php echo $currentPage<$pageCount-1?$baseUrl.'?page='.($pageCount-1):'#'; ?>" title="Last">&raquo;</a>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="wl-empty">
        <div class="wl-empty-icon"><i class="fa fa-heart-o"></i></div>
        <h3>Your wishlist is empty</h3>
        <p>Save items you love and come back to them anytime.</p>
        <a href="<?php echo base_url('all-products'); ?>" class="wl-browse-btn"><i class="fa fa-shopping-bag"></i>&nbsp; Browse Products</a>
    </div>
    <?php endif; ?>

</div>

<input type="hidden" id="session_user_id" value="<?php echo $userId; ?>">

<script>
var wlCount = <?php echo $totalCount; ?>;

function removeFromWishlist(pid, cardId) {
    var uid = $('#session_user_id').val();
    if (!uid) { window.location.href = BASE_URL + '/sign-in'; return; }
    var $card = $('#' + cardId);
    $card.addClass('wl-removing');
    $.post(BASE_URL + '/product/addWishlistProduct', { product_id: pid, user_id: uid }, function() {
        setTimeout(function() {
            $card.remove();
            wlCount--;
            $('#wl-count-text').text(wlCount + ' item' + (wlCount !== 1 ? 's' : '') + ' saved');
            if ($('#wl-grid .jly-card').length === 0) location.reload();
        }, 300);
        showToast('Removed from wishlist.', 'info');
    });
}

function toggleQuickAdd(cardId) {
    var $v = $('#variants-' + cardId), $c = $('#chev-' + cardId);
    var isOpen = $v.hasClass('open');
    $('.jly-variants.open').removeClass('open');
    $('.jly-chevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    if (!isOpen) { $v.addClass('open'); $c.removeClass('fa-chevron-down').addClass('fa-chevron-up'); }
}

var qaState = {};
function qaSelectVariant(el, pid, price, label) {
    var $wrap = $(el).closest('.jly-variants');
    $wrap.find('.jly-variant-row').removeClass('jly-variant-selected');
    $(el).addClass('jly-variant-selected');
    qaState[pid] = { price: price, label: label };
    $('#qa-cart-' + pid).prop('disabled', false);
}
function qaChangeQty(pid, delta) {
    var $v = $('#qa-qty-' + pid);
    var q = Math.max(1, (parseInt($v.text()) || 1) + delta);
    $v.text(q);
}
function qaAddToCart(pid) {
    if (!qaState[pid]) return;
    var qty = parseInt($('#qa-qty-' + pid).text()) || 1;
    addToCart(pid, qty, qaState[pid].price, qaState[pid].label);
}
function addVariantToCart(pid, price, label) { addToCart(pid, 1, price, label); }

$(document).on('click', function(e) {
    if (!$(e.target).closest('.jly-btn-quick, .jly-variants').length) {
        $('.jly-variants.open').removeClass('open');
        $('.jly-chevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    }
});
</script>
