<?php
$userId      = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['id'] : '';
$totalCount  = isset($wlTotalCount)  ? (int)$wlTotalCount  : 0;
$pageCount   = isset($wlPageCount)   ? (int)$wlPageCount   : 1;
$currentPage = isset($wlCurrentPage) ? (int)$wlCurrentPage : 0;
$baseUrl     = base_url('wish-list');
?>

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
            $fullProd  = $CI->Product_model->getProductById($p['product_id']);
            $hasVar    = !empty($variants);
            $varType   = !empty($fullProd['variant_type']) ? $fullProd['variant_type'] : 'per_quantity';
            $inStock   = isset($p['quantity']) ? $p['quantity'] > 0 : true;
            $minP      = $hasVar ? min(array_column($variants,'price')) : floatval($p['price']);
            $maxP      = $hasVar ? max(array_column($variants,'price')) : 0;
            $priceStr  = ($hasVar && $maxP > $minP)
                ? '£ '.number_format($minP,2).' - '.'£ '.number_format($maxP,2)
                : '£ '.number_format($minP,2);
            $pqWlTiers = array();
            if($hasVar && $varType === 'per_quantity') {
                foreach($variants as $v) {
                    $mn = (int)preg_replace('/[^0-9]/','', $v['label']);
                    if($mn < 1) $mn = 1;
                    $pqWlTiers[] = array('min'=>$mn,'price'=>floatval($v['price']));
                }
                usort($pqWlTiers, function($a,$b){ return $a['min']-$b['min']; });
            }
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
                <div class="jly-price"><?php echo $userId ? $priceStr : '—'; ?></div>
                <?php if(!$userId): ?>
                <p style="font-size:12px;color:#e74c3c;margin:4px 0 6px;"><i class="fa fa-lock"></i> Register/Login to view variant prices</p>
                <?php endif; ?>
                <a href="<?php echo $detailUrl; ?>" class="jly-btn jly-btn-view"><i class="fa fa-eye"></i> View Details</a>
                <?php if($hasVar && $varType === 'per_quantity'): ?>
                <button class="jly-btn jly-btn-quick" <?php if($userId && $inStock): ?>onclick="toggleQuickAdd('<?php echo $cardId; ?>')"<?php else: ?>disabled style="opacity:.5;cursor:not-allowed;pointer-events:none;"<?php endif; ?> id="qabtn-<?php echo $cardId; ?>">
                    <i class="fa fa-shopping-cart"></i>&nbsp; Quick Add
                    <i class="fa fa-chevron-down jly-chevron" id="chev-<?php echo $cardId; ?>"></i>
                </button>
                <div class="jly-variants" id="variants-<?php echo $cardId; ?>">
                    <?php foreach($pqWlTiers as $ti => $tier):
                        $tierLabel = ($ti < count($pqWlTiers)-1)
                            ? $tier['min'].' - '.($pqWlTiers[$ti+1]['min']-1).' pcs'
                            : $tier['min'].'+ pcs';
                    ?>
                    <div class="jly-variant-row pq-tier-row <?php echo $ti===0?'jly-variant-selected':''; echo !$inStock?' variant-out':''; ?>"
                         data-min="<?php echo $tier['min']; ?>" data-price="<?php echo $tier['price']; ?>"
                         id="pq-tier-<?php echo $p['product_id'].'-'.$ti; ?>">
                        <span class="jly-variant-icon"><i class="fa fa-tag"></i></span>
                        <span class="jly-variant-label"><?php echo $tierLabel; ?></span>
                        <span class="jly-variant-price">£ <?php echo number_format($tier['price'],2); ?>/pc</span>
                    </div>
                    <?php endforeach; ?>
                    <div class="jly-qa-footer">
                        <div class="jly-qa-total">Total: <strong id="qa-total-<?php echo $p['product_id']; ?>">£ <?php echo number_format($pqWlTiers[0]['price'],2); ?></strong></div>
                        <div class="jly-qa-bottom">
                            <div class="jly-qa-qty">
                                <button class="jly-qa-qty-btn" onclick="pqCardChangeQty('<?php echo $p['product_id']; ?>', -1)">&#8722;</button>
                                <input type="number" class="jly-qa-qty-input" id="qa-qty-<?php echo $p['product_id']; ?>" value="1" min="1" oninput="pqCardChangeQty('<?php echo $p['product_id']; ?>', 0, this.value)">
                                <button class="jly-qa-qty-btn" onclick="pqCardChangeQty('<?php echo $p['product_id']; ?>', 1)">&#43;</button>
                            </div>
                            <button class="jly-qa-cart-btn" onclick="pqCardAddToCart('<?php echo $p['product_id']; ?>')">
                                <i class="fa fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <?php elseif($hasVar && $varType === 'per_carton'): ?>
                <button class="jly-btn jly-btn-quick" <?php if($userId): ?>onclick="toggleQuickAdd('<?php echo $cardId; ?>')"<?php else: ?>disabled style="opacity:.5;cursor:not-allowed;pointer-events:none;"<?php endif; ?> id="qabtn-<?php echo $cardId; ?>">
                    <i class="fa fa-shopping-cart"></i>&nbsp; Quick Add
                    <i class="fa fa-chevron-down jly-chevron" id="chev-<?php echo $cardId; ?>"></i>
                </button>
                <div class="jly-variants" id="variants-<?php echo $cardId; ?>">
                    <?php foreach($variants as $v):
                        $vLabel = htmlspecialchars($v['label'], ENT_QUOTES);
                        $vPrice = floatval($v['price']);
                        $vPcs   = (int)preg_replace('/[^0-9]/','', $v['label']); if($vPcs < 1) $vPcs = 1;
                        $perPc  = round($vPrice / $vPcs, 2);
                    ?>
                    <button class="jly-variant-row<?php echo !$inStock?' variant-out':''; ?>"
                        <?php if($inStock): ?>onclick="qaSelectVariant(this, <?php echo $p['product_id']; ?>, <?php echo $vPrice; ?>, '<?php echo $vLabel; ?>')"<?php else: ?>disabled<?php endif; ?>>
                        <span class="jly-variant-icon"><i class="fa fa-tag"></i></span>
                        <span class="jly-variant-label"><?php echo is_numeric(trim($v['label'])) ? trim($v['label']).' pieces' : htmlspecialchars($v['label']); ?><br><small style="color:#999;font-weight:400;">£ <?php echo number_format($perPc,2); ?>/pc</small></span>
                        <span class="jly-variant-price">£ <?php echo number_format($vPrice,2); ?></span>
                        <?php if(!$inStock): ?><span class="jly-out-tag">Out</span><?php endif; ?>
                    </button>
                    <?php endforeach; ?>
                    <div class="jly-qa-footer">
                        <div class="jly-qa-total">Total: <strong id="qa-total-<?php echo $p['product_id']; ?>">£ —</strong></div>
                        <div class="jly-qa-bottom">
                            <div class="jly-qa-qty">
                                <button class="jly-qa-qty-btn" onclick="qaChangeQty('<?php echo $p['product_id']; ?>', -1)">&#8722;</button>
                                <input type="number" class="jly-qa-qty-input" id="qa-qty-<?php echo $p['product_id']; ?>" value="1" min="1" oninput="qaChangeQty('<?php echo $p['product_id']; ?>', 0, this.value)">
                                <button class="jly-qa-qty-btn" onclick="qaChangeQty('<?php echo $p['product_id']; ?>', 1)">&#43;</button>
                            </div>
                            <button class="jly-qa-cart-btn" id="qa-cart-<?php echo $p['product_id']; ?>" onclick="qaAddToCart('<?php echo $p['product_id']; ?>')" disabled>
                                <i class="fa fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
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
var pqCardTiersMap = {};
<?php foreach($allWishlistProducts as $p2):
    $v2  = $CI->Product_model->getVariantsByProduct($p2['product_id']);
    $fp2 = $CI->Product_model->getProductById($p2['product_id']);
    $vt2 = !empty($fp2['variant_type']) ? $fp2['variant_type'] : 'per_quantity';
    if(!empty($v2) && $vt2 === 'per_quantity'):
        $t2 = array();
        foreach($v2 as $vv) { $mn=(int)preg_replace('/[^0-9]/','', $vv['label']); if($mn<1)$mn=1; $t2[]=array('min'=>$mn,'price'=>floatval($vv['price'])); }
        usort($t2, function($a,$b){ return $a['min']-$b['min']; });
?>
pqCardTiersMap[<?php echo $p2['product_id']; ?>] = <?php echo json_encode(array_values($t2)); ?>;
<?php endif; endforeach; ?>
function pqCardGetPrice(pid, qty) {
    var tiers = pqCardTiersMap[pid]||[], price = tiers.length ? tiers[0].price : 0;
    for(var i=0;i<tiers.length;i++) { if(qty>=tiers[i].min) price=tiers[i].price; }
    return price;
}
function pqCardChangeQty(pid, delta, directVal) {
    var $v=$('#qa-qty-'+pid), q=directVal!==undefined?Math.max(1,parseInt(directVal)||1):Math.max(1,(parseInt($v.val())||1)+delta);
    $v.val(q);
    var tiers=pqCardTiersMap[pid]||[];
    for(var i=0;i<tiers.length;i++) $('#pq-tier-'+pid+'-'+i).removeClass('jly-variant-selected');
    for(var i=tiers.length-1;i>=0;i--) { if(q>=tiers[i].min){ $('#pq-tier-'+pid+'-'+i).addClass('jly-variant-selected'); break; } }
    $('#qa-total-'+pid).text('£ '+(q*pqCardGetPrice(pid,q)).toFixed(2));
}
function pqCardAddToCart(pid) {
    var qty=Math.max(1,parseInt($('#qa-qty-'+pid).val())||1);
    addToCart(pid, qty, pqCardGetPrice(pid,qty), '');
}
function qaSelectVariant(el, pid, price, label) {
    $(el).closest('.jly-variants').find('.jly-variant-row').removeClass('jly-variant-selected');
    $(el).addClass('jly-variant-selected');
    qaState[pid] = { price: price, label: label };
    $('#qa-cart-' + pid).prop('disabled', false);
    var qty=Math.max(1,parseInt($('#qa-qty-'+pid).val())||1);
    $('#qa-total-'+pid).text('£ '+(qty*price).toFixed(2));
}
function qaChangeQty(pid, delta, directVal) {
    var $v=$('#qa-qty-'+pid), q=directVal!==undefined?Math.max(1,parseInt(directVal)||1):Math.max(1,(parseInt($v.val())||1)+delta);
    $v.val(q);
    if(qaState[pid]) $('#qa-total-'+pid).text('£ '+(q*qaState[pid].price).toFixed(2));
}
function qaAddToCart(pid) {
    if(!qaState[pid]) return;
    addToCart(pid, Math.max(1,parseInt($('#qa-qty-'+pid).val())||1), qaState[pid].price, qaState[pid].label);
}

$(document).on('click', function(e) {
    if (!$(e.target).closest('.jly-btn-quick, .jly-variants').length) {
        $('.jly-variants.open').removeClass('open');
        $('.jly-chevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    }
});
</script>
