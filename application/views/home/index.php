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
            $varType  = !empty($p['variant_type']) ? $p['variant_type'] : 'per_quantity';
            $inStock  = $p['quantity'] > 0;
            $minP     = $hasVar ? min(array_column($variants,'price')) : floatval($p['price']);
            $maxP     = $hasVar ? max(array_column($variants,'price')) : 0;
            $priceStr = ($hasVar && $maxP > $minP)
                ? '£ '.number_format($minP,2).' - '.'£ '.number_format($maxP,2)
                : '£ '.number_format($minP,2);
            $pqHomeTiers = array();
            if($hasVar && $varType === 'per_quantity') {
                foreach($variants as $v) {
                    $mn = (int)preg_replace('/[^0-9]/','', $v['label']);
                    if($mn < 1) $mn = 1;
                    $pqHomeTiers[] = array('min'=>$mn,'price'=>floatval($v['price']));
                }
                usort($pqHomeTiers, function($a,$b){ return $a['min']-$b['min']; });
            }
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

                <div class="jly-price"><?php echo $userId ? $priceStr : '—'; ?></div>

                <?php if(!$userId): ?>
                <p style="font-size:12px;color:#e74c3c;margin:4px 0 6px;"><i class="fa fa-lock"></i> Register/Login to view variant prices</p>
                <?php endif; ?>

                <a href="<?php echo base_url('product-details/'.$p['product_slug']); ?>" class="jly-btn jly-btn-view">
                    <i class="fa fa-eye"></i> View Details
                </a>

                <?php if($hasVar && $varType === 'per_quantity'): ?>
                <button class="jly-btn jly-btn-quick" <?php if($userId && $inStock): ?>onclick="toggleQuickAdd('card-<?php echo $p['id']; ?>')"<?php else: ?>disabled style="opacity:.5;cursor:not-allowed;pointer-events:none;"<?php endif; ?> id="qabtn-card-<?php echo $p['id']; ?>">
                    <i class="fa fa-shopping-cart"></i>&nbsp; Quick Add
                    <i class="fa fa-chevron-down jly-chevron" id="chev-card-<?php echo $p['id']; ?>"></i>
                </button>
                <div class="jly-variants" id="variants-card-<?php echo $p['id']; ?>">
                    <?php foreach($pqHomeTiers as $ti => $tier):
                        $tierLabel = ($ti < count($pqHomeTiers)-1)
                            ? $tier['min'].' - '.($pqHomeTiers[$ti+1]['min']-1).' pcs'
                            : $tier['min'].'+ pcs';
                    ?>
                            <div class="jly-variant-row pq-tier-row <?php echo $ti===0?'jly-variant-selected':''; echo !$inStock?' variant-out':''; ?>"
                                 data-min="<?php echo $tier['min']; ?>" data-price="<?php echo $tier['price']; ?>"
                                 id="pq-tier-<?php echo $p['id'].'-'.$ti; ?>">
                                <span class="jly-variant-icon"><i class="fa fa-tag"></i></span>
                                <span class="jly-variant-label"><?php echo $tierLabel; ?></span>
                                <span class="jly-variant-price">£ <?php echo number_format($tier['price'],2); ?>/pc</span>
                            </div>
                    <?php endforeach; ?>
                            <div class="jly-qa-footer">
                                <div class="jly-qa-total">Total: <strong id="qa-total-<?php echo $p['id']; ?>">£ <?php echo number_format($pqHomeTiers[0]['price'],2); ?></strong></div>
                                <div class="jly-qa-bottom">
                                    <div class="jly-qa-qty">
                                        <button class="jly-qa-qty-btn" onclick="pqCardChangeQty('<?php echo $p['id']; ?>', -1)">&#8722;</button>
                                        <input type="number" class="jly-qa-qty-input" id="qa-qty-<?php echo $p['id']; ?>" value="1" min="1" oninput="pqCardChangeQty('<?php echo $p['id']; ?>', 0, this.value)">
                                        <button class="jly-qa-qty-btn" onclick="pqCardChangeQty('<?php echo $p['id']; ?>', 1)">&#43;</button>
                                    </div>
                                    <button class="jly-qa-cart-btn" onclick="pqCardAddToCart('<?php echo $p['id']; ?>')">
                                        <i class="fa fa-shopping-cart"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php elseif($hasVar && $varType === 'per_carton'): ?>
                        <button class="jly-btn jly-btn-quick" <?php if($userId): ?>onclick="toggleQuickAdd('card-<?php echo $p['id']; ?>')"<?php else: ?>disabled style="opacity:.5;cursor:not-allowed;pointer-events:none;"<?php endif; ?> id="qabtn-card-<?php echo $p['id']; ?>">
                            <i class="fa fa-shopping-cart"></i>&nbsp; Quick Add
                            <i class="fa fa-chevron-down jly-chevron" id="chev-card-<?php echo $p['id']; ?>"></i>
                        </button>
                        <div class="jly-variants" id="variants-card-<?php echo $p['id']; ?>">
                            <?php foreach($variants as $v):
                                $vLabel = htmlspecialchars($v['label'], ENT_QUOTES);
                                $vPrice = floatval($v['price']);
                                $vPcs   = (int)preg_replace('/[^0-9]/','', $v['label']); if($vPcs < 1) $vPcs = 1;
                                $perPc  = round($vPrice / $vPcs, 2);
                            ?>
                            <button class="jly-variant-row<?php echo !$inStock?' variant-out':''; ?>"
                                <?php if($inStock): ?>onclick="qaSelectVariant(this, <?php echo $p['id']; ?>, <?php echo $vPrice; ?>, '<?php echo $vLabel; ?>')"<?php else: ?>disabled<?php endif; ?>>
                                <span class="jly-variant-icon"><i class="fa fa-tag"></i></span>
                                <span class="jly-variant-label"><?php echo is_numeric(trim($v['label'])) ? trim($v['label']).' pieces' : htmlspecialchars($v['label']); ?><br><small style="color:#999;font-weight:400;">£ <?php echo number_format($perPc,2); ?>/pc</small></span>
                                <span class="jly-variant-price">£ <?php echo number_format($vPrice,2); ?></span>
                                <?php if(!$inStock): ?><span class="jly-out-tag">Out</span><?php endif; ?>
                            </button>
                            <?php endforeach; ?>
                            <div class="jly-qa-footer">
                                <div class="jly-qa-total">Total: <strong id="qa-total-<?php echo $p['id']; ?>">£ —</strong></div>
                                <div class="jly-qa-bottom">
                                    <div class="jly-qa-qty">
                                        <button class="jly-qa-qty-btn" onclick="qaChangeQty('<?php echo $p['id']; ?>', -1)">&#8722;</button>
                                        <input type="number" class="jly-qa-qty-input" id="qa-qty-<?php echo $p['id']; ?>" value="1" min="1" oninput="qaChangeQty('<?php echo $p['id']; ?>', 0, this.value)">
                                        <button class="jly-qa-qty-btn" onclick="qaChangeQty('<?php echo $p['id']; ?>', 1)">&#43;</button>
                                    </div>
                                    <button class="jly-qa-cart-btn" id="qa-cart-<?php echo $p['id']; ?>" onclick="qaAddToCart('<?php echo $p['id']; ?>')" disabled>
                                        <i class="fa fa-shopping-cart"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
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
function toggleQuickAdd(cardId) {
    var $v = $('#variants-' + cardId), $c = $('#chev-' + cardId);
    var isOpen = $v.hasClass('open');
    $('.jly-variants.open').removeClass('open');
    $('.jly-chevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    if (!isOpen) { $v.addClass('open'); $c.removeClass('fa-chevron-down').addClass('fa-chevron-up'); }
}
var qaState = {};
var pqCardTiersMap = {};
<?php foreach($featuredProducts as $p2):
    $v2  = $CI->Product_model->getVariantsByProduct($p2['id']);
    $vt2 = !empty($p2['variant_type']) ? $p2['variant_type'] : 'per_quantity';
    if(!empty($v2) && $vt2 === 'per_quantity'):
        $t2 = array();
        foreach($v2 as $vv) { $mn=(int)preg_replace('/[^0-9]/','', $vv['label']); if($mn<1)$mn=1; $t2[]=array('min'=>$mn,'price'=>floatval($vv['price'])); }
        usort($t2, function($a,$b){ return $a['min']-$b['min']; });
?>
pqCardTiersMap[<?php echo $p2['id']; ?>] = <?php echo json_encode(array_values($t2)); ?>;
<?php endif; endforeach; ?>
function pqCardGetPrice(pid, qty) {
    var tiers = pqCardTiersMap[pid] || [], price = tiers.length ? tiers[0].price : 0;
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
$(document).on('click', function(e) {
    if (!$(e.target).closest('.jly-btn-quick, .jly-variants').length) {
        $('.jly-variants.open').removeClass('open');
        $('.jly-chevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    }
});
</script>
