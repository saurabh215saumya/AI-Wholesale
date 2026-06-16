<?php
$userId   = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['id'] : '';
$userType = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['user_type'] : '';
$pageSlug = $this->uri->segment(1);
$slug     = $this->uri->segment(2) ?: '';
$search   = $this->input->get('search');
?>

<section class="page-header mb-lg">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <?php if($pageSlug && $pageSlug !== 'all-products'): ?>
            <li><a href="javascript:void(0);"><?php echo $pageSlug==='categories'?'Category':'Sub Category'; ?></a></li>
            <?php endif; ?>
            <li class="active"><?php echo isset($pageTitle) ? $pageTitle : 'All Products'; ?></li>
        </ul>
    </div>
</section>

<div class="container">
    <div class="row">

        <!-- Products Grid -->
        <div class="col-md-9 col-md-push-3">

            <!-- Search + Results bar -->
            <div class="shop-toolbar clearfix mb-md">
                <form action="<?php echo base_url('all-products'); ?>" method="get" class="pull-left" style="width:60%;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
                <?php if(!empty($totalCount)): ?>
                <p class="pull-right" style="line-height:34px;color:#777;"><?php echo $totalCount; ?> product(s) found</p>
                <?php endif; ?>
            </div>

            <?php if(!empty($allProducts)): ?>
            <div class="jly-product-grid-3">
                <?php foreach($allProducts as $p):
                    $img       = getProductImage($p['image']);
                    $detailUrl = base_url('product-details/'.$p['product_slug']);
                    $inWish    = checkUserProductInWishlist($p['id'], $userId);
                    $CI        =& get_instance();
                    $variants  = $CI->Product_model->getVariantsByProduct($p['id']);
                    $hasVar    = !empty($variants);
                    $varType   = !empty($p['variant_type']) ? $p['variant_type'] : 'per_quantity';
                    $inStock   = $p['quantity'] > 0;
                    $minP      = $hasVar ? min(array_column($variants,'price')) : floatval($p['price']);
                    $maxP      = $hasVar ? max(array_column($variants,'price')) : 0;
                    $priceStr  = ($hasVar && $maxP > $minP)
                        ? '£ '.number_format($minP,2).' - '.'£ '.number_format($maxP,2)
                        : '£ '.number_format($minP,2);
                    // Build per_quantity tiers sorted
                    $pqCardTiers = array();
                    if($hasVar && $varType === 'per_quantity') {
                        foreach($variants as $v) {
                            $m2 = (int)preg_replace('/[^0-9]/','',$v['label']);
                            if($m2 < 1) $m2 = 1;
                            $pqCardTiers[] = array('min'=>$m2,'price'=>floatval($v['price']));
                        }
                        usort($pqCardTiers, function($a,$b){ return $a['min']-$b['min']; });
                    }
                    $cardId    = 'card-'.$p['id'];
                ?>
                <div class="jly-card" id="<?php echo $cardId; ?>">
                    <?php if($p['new_product']): ?><span class="jly-badge jly-badge-new">New</span><?php endif; ?>
                    <?php if($p['best_seller']): ?><span class="jly-badge jly-badge-hot">Best Seller</span><?php endif; ?>
                    <button class="jly-wish-btn <?php echo !empty($inWish)?'active':''; ?>" onclick="return doWishlist('<?php echo $p['id']; ?>')" title="Wishlist">
                        <i class="fa fa-heart<?php echo !empty($inWish)?'':'-o'; ?>"></i>
                    </button>
                    <a href="<?php echo $detailUrl; ?>" class="jly-img-wrap">
                        <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($p['product_name']); ?>" class="jly-img">
                    </a>
                    <div class="jly-info">
                        <h3 class="jly-name">
                            <a href="<?php echo $detailUrl; ?>"><?php echo $p['product_name']; ?></a>
                        </h3>
                        <?php if(!empty($p['description'])): ?>
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

                        <a href="<?php echo $detailUrl; ?>" class="jly-btn jly-btn-view">
                            <i class="fa fa-eye"></i> View Details
                        </a>

                        <?php if($hasVar && $varType === 'per_quantity'): ?>
                        <!-- PER QUANTITY: tier rows auto-highlight by qty -->
                        <button class="jly-btn jly-btn-quick" <?php if($userId && $inStock): ?>onclick="toggleQuickAdd('<?php echo $cardId; ?>')"<?php else: ?>disabled style="opacity:.5;cursor:not-allowed;pointer-events:none;"<?php endif; ?> id="qabtn-<?php echo $cardId; ?>">
                            <i class="fa fa-shopping-cart"></i>&nbsp; Quick Add
                            <i class="fa fa-chevron-down jly-chevron" id="chev-<?php echo $cardId; ?>"></i>
                        </button>
                        <div class="jly-variants" id="variants-<?php echo $cardId; ?>">
                            <?php foreach($pqCardTiers as $ti => $tier):
                                $tierLabel = ($ti < count($pqCardTiers)-1)
                                    ? $tier['min'].' - '.($pqCardTiers[$ti+1]['min']-1).' pcs'
                                    : $tier['min'].'+ pcs';
                            ?>
                            <div class="jly-variant-row pq-tier-row <?php echo $ti===0?'jly-variant-selected':''; echo (!$inStock)?' variant-out':''; ?>"
                                 data-min="<?php echo $tier['min']; ?>"
                                 data-price="<?php echo $tier['price']; ?>"
                                 id="pq-tier-<?php echo $p['id'].'-'.$ti; ?>">
                                <span class="jly-variant-icon"><i class="fa fa-tag"></i></span>
                                <span class="jly-variant-label"><?php echo $tierLabel; ?></span>
                                <span class="jly-variant-price">£ <?php echo number_format($tier['price'],2); ?>/pc</span>
                            </div>
                            <?php endforeach; ?>
                            <div class="jly-qa-footer">
                                <div class="jly-qa-total">Total: <strong id="qa-total-<?php echo $p['id']; ?>">£ <?php echo number_format($pqCardTiers[0]['price'],2); ?></strong></div>
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
                        <!-- PER CARTON: select carton size variant -->
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
                            <button class="jly-variant-row<?php echo (!$inStock)?' variant-out':''; ?>"
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

            <!-- Pagination -->
            <?php if(!empty($pageCount) && $pageCount > 1):
                $currentPage = (int)$this->input->get('page');
                $totalPages  = $pageCount;
                $visiblePages = 5;
                $half = floor($visiblePages / 2);
                $startPage = max(0, $currentPage - $half);
                $endPage   = min($totalPages - 1, $startPage + $visiblePages - 1);
                if ($endPage - $startPage < $visiblePages - 1) {
                    $startPage = max(0, $endPage - $visiblePages + 1);
                }
                $qs = isset($search) && $search ? '&search='.urlencode($search) : '';
            ?>
            <div class="jly-pg-wrap">
                <a class="jly-pg-btn<?php echo $currentPage==0?' jly-pg-dis':''; ?>" href="<?php echo $currentPage>0?$baseUrl.'?page=0'.$qs:'#'; ?>" title="First">&laquo;</a>
                <a class="jly-pg-btn<?php echo $currentPage==0?' jly-pg-dis':''; ?>" href="<?php echo $currentPage>0?$baseUrl.'?page='.($currentPage-1).$qs:'#'; ?>" title="Previous">&lsaquo;</a>
                <?php for($pg=$startPage;$pg<=$endPage;$pg++): ?>
                <a class="jly-pg-btn<?php echo $pg==$currentPage?' jly-pg-active':''; ?>" href="<?php echo $baseUrl.'?page='.$pg.$qs; ?>"><?php echo $pg+1; ?></a>
                <?php endfor; ?>
                <a class="jly-pg-btn<?php echo $currentPage==$totalPages-1?' jly-pg-dis':''; ?>" href="<?php echo $currentPage<$totalPages-1?$baseUrl.'?page='.($currentPage+1).$qs:'#'; ?>" title="Next">&rsaquo;</a>
                <a class="jly-pg-btn<?php echo $currentPage==$totalPages-1?' jly-pg-dis':''; ?>" href="<?php echo $currentPage<$totalPages-1?$baseUrl.'?page='.($totalPages-1).$qs:'#'; ?>" title="Last">&raquo;</a>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <div class="alert alert-info mt-lg">
                <i class="fa fa-info-circle"></i>
                <?php echo $search ? 'No products found for "<strong>'.htmlspecialchars($search).'</strong>".' : 'No products available.'; ?>
                <a href="<?php echo base_url('all-products'); ?>" class="btn btn-primary btn-sm ml-sm">View All</a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <aside class="col-md-3 col-md-pull-9 sidebar shop-sidebar">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" href="#panel-filter-category">Categories</a>
                        </h4>
                    </div>
                    <div id="panel-filter-category" class="accordion-body collapse in">
                        <div class="panel-body">
                            <ul>
                                <?php if(!empty($isActiveCategories)): foreach($isActiveCategories as $cat): ?>
                                <?php
                                    $children    = getCategoryChildren($cat->id);
                                    $hasSubs     = !empty($children);
                                    $catId       = 'cat-subs-'.$cat->id;
                                    $isCatActive = ($pageSlug=='categories' && $slug==$cat->category_slug);
                                    // Check if current slug belongs to any child or grandchild of this cat
                                    $expandSubs  = $isCatActive;
                                    if(!$expandSubs && $hasSubs) {
                                        foreach($children as $child) {
                                            if($slug == $child->category_slug) { $expandSubs = true; break; }
                                            $grandchildren = getCategoryChildren($child->id);
                                            foreach($grandchildren as $gc) {
                                                if($slug == $gc->category_slug) { $expandSubs = true; break 2; }
                                            }
                                        }
                                    }
                                ?>
                                <li class="<?php echo $isCatActive?'active':''; ?>">
                                    <div class="sidebar-cat-row">
                                        <a href="<?php echo base_url('categories/'.$cat->category_slug); ?>"><?php echo $cat->category_name; ?></a>
                                        <?php if($hasSubs): ?>
                                        <span class="sidebar-cat-toggle <?php echo $expandSubs?'open':''; ?>" onclick="toggleSidebarCat('<?php echo $catId; ?>', this)">
                                            <i class="fa <?php echo $expandSubs?'fa-chevron-up':'fa-chevron-down'; ?>"></i>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($hasSubs): ?>
                                    <ul id="<?php echo $catId; ?>" class="sidebar-sub-list" style="<?php echo $expandSubs?'':'display:none;'; ?>padding-left:15px;margin-top:5px;">
                                        <?php foreach($children as $child):
                                            $isChildActive = ($slug == $child->category_slug);
                                            $grandchildren = getCategoryChildren($child->id);
                                            $hasGrand      = !empty($grandchildren);
                                            $gcId          = 'cat-subs-'.$child->id;
                                            $expandGrand   = $isChildActive;
                                            if(!$expandGrand && $hasGrand) {
                                                foreach($grandchildren as $gc) {
                                                    if($slug == $gc->category_slug) { $expandGrand = true; break; }
                                                }
                                            }
                                        ?>
                                        <li>
                                            <div class="sidebar-cat-row">
                                                <a href="<?php echo base_url('categories/'.$child->category_slug); ?>" style="font-size:13px;<?php echo $isChildActive?'color:#ff6000;font-weight:700;':''; ?>"><?php echo $child->category_name; ?></a>
                                                <?php if($hasGrand): ?>
                                                <span class="sidebar-cat-toggle <?php echo $expandGrand?'open':''; ?>" onclick="toggleSidebarCat('<?php echo $gcId; ?>', this)">
                                                    <i class="fa <?php echo $expandGrand?'fa-chevron-up':'fa-chevron-down'; ?>"></i>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if($hasGrand): ?>
                                            <ul id="<?php echo $gcId; ?>" class="sidebar-sub-list" style="<?php echo $expandGrand?'':'display:none;'; ?>padding-left:12px;margin-top:3px;">
                                                <?php foreach($grandchildren as $gc): ?>
                                                <li><a href="<?php echo base_url('categories/'.$gc->category_slug); ?>" style="font-size:12px;<?php echo ($slug==$gc->category_slug)?'color:#ff6000;font-weight:700;':''; ?>"><i class="fa fa-angle-right"></i> <?php echo $gc->category_name; ?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <?php endif; ?>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php endif; ?>
                                </li>
                                <?php endforeach; endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature boxes -->
            <div class="feature-box feature-box-style-3 mt-md">
                <div class="feature-box-icon"><i class="fa fa-truck"></i></div>
                <div class="feature-box-info"><h4>FREE SHIPPING</h4><p class="mb-none">On orders over <?php echo '£ '; ?>99</p></div>
            </div>
            <div class="feature-box feature-box-style-3">
                <div class="feature-box-icon"><i class="fa fa-gbp"></i></div>
                <div class="feature-box-info"><h4>MONEY BACK</h4><p class="mb-none">100% guarantee</p></div>
            </div>
        </aside>
    </div>
</div>

<input type="hidden" id="session_user_id" value="<?php echo $userId; ?>">

<script>
function toggleSidebarCat(id, el) {
    var $ul = $('#' + id);
    var $icon = $(el).find('i');
    if ($ul.is(':visible')) {
        $ul.slideUp(200);
        $icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        $(el).removeClass('open');
    } else {
        $ul.slideDown(200);
        $icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        $(el).addClass('open');
    }
}
function toggleQuickAdd(cardId) {
    var $v = $('#variants-' + cardId);
    var $c = $('#chev-' + cardId);
    var isOpen = $v.hasClass('open');
    $('.jly-variants.open').removeClass('open');
    $('.jly-chevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    if (!isOpen) {
        $v.addClass('open');
        $c.removeClass('fa-chevron-down').addClass('fa-chevron-up');
    }
}
var qaState = {};
var pqCardTiersMap = {};
<?php foreach($allProducts as $p2):
    $v2 = $CI->Product_model->getVariantsByProduct($p2['id']);
    $vt2 = !empty($p2['variant_type']) ? $p2['variant_type'] : 'per_quantity';
    if(!empty($v2) && $vt2 === 'per_quantity'):
        $tiers2 = array();
        foreach($v2 as $vv) {
            $mn = (int)preg_replace('/[^0-9]/','', $vv['label']);
            if($mn < 1) $mn = 1;
            $tiers2[] = array('min'=>$mn,'price'=>floatval($vv['price']));
        }
        usort($tiers2, function($a,$b){ return $a['min']-$b['min']; });
?>
pqCardTiersMap[<?php echo $p2['id']; ?>] = <?php echo json_encode(array_values($tiers2)); ?>;
<?php endif; endforeach; ?>
function pqCardGetPrice(pid, qty) {
    var tiers = pqCardTiersMap[pid] || [];
    var price = tiers.length ? tiers[0].price : 0;
    for (var i = 0; i < tiers.length; i++) {
        if (qty >= tiers[i].min) price = tiers[i].price;
    }
    return price;
}
function pqCardChangeQty(pid, delta, directVal) {
    var $v = $('#qa-qty-' + pid), q = directVal !== undefined ? Math.max(1, parseInt(directVal)||1) : Math.max(1, (parseInt($v.val())||1) + delta);
    $v.val(q);
    var tiers = pqCardTiersMap[pid] || [];
    for (var i = 0; i < tiers.length; i++) $('#pq-tier-' + pid + '-' + i).removeClass('jly-variant-selected');
    for (var i = tiers.length - 1; i >= 0; i--) { if (q >= tiers[i].min) { $('#pq-tier-' + pid + '-' + i).addClass('jly-variant-selected'); break; } }
    var price = pqCardGetPrice(pid, q);
    $('#qa-total-' + pid).text('£ ' + (q * price).toFixed(2));
}
function pqCardAddToCart(pid) {
    var qty = Math.max(1, parseInt($('#qa-qty-' + pid).val()) || 1);
    addToCart(pid, qty, pqCardGetPrice(pid, qty), '');
}
function qaSelectVariant(el, pid, price, label) {
    var $wrap = $(el).closest('.jly-variants');
    $wrap.find('.jly-variant-row').removeClass('jly-variant-selected');
    $(el).addClass('jly-variant-selected');
    qaState[pid] = { price: price, label: label };
    $('#qa-cart-' + pid).prop('disabled', false);
    var qty = Math.max(1, parseInt($('#qa-qty-' + pid).val()) || 1);
    $('#qa-total-' + pid).text('£ ' + (qty * price).toFixed(2));
}
function qaChangeQty(pid, delta, directVal) {
    var $v = $('#qa-qty-' + pid), q = directVal !== undefined ? Math.max(1, parseInt(directVal)||1) : Math.max(1, (parseInt($v.val())||1) + delta);
    $v.val(q);
    if (qaState[pid]) $('#qa-total-' + pid).text('£ ' + (q * qaState[pid].price).toFixed(2));
}
function qaAddToCart(pid) {
    if (!qaState[pid]) return;
    var qty = Math.max(1, parseInt($('#qa-qty-' + pid).val()) || 1);
    addToCart(pid, qty, qaState[pid].price, qaState[pid].label);
}
function doWishlist(pid) {
    var uid = $('#session_user_id').val();
    if (!uid) { window.location.href = BASE_URL + '/sign-in'; return false; }
    $.post(BASE_URL + '/product/addWishlistProduct', {product_id: pid, user_id: uid}, function(r) {
        var $btn = $('#card-' + pid + ' .jly-wish-btn');
        if (r === 'added') {
            $btn.addClass('active').find('i').removeClass('fa-heart-o').addClass('fa-heart');
            showToast('Added to wishlist!', 'success');
        } else {
            $btn.removeClass('active').find('i').removeClass('fa-heart').addClass('fa-heart-o');
            showToast('Removed from wishlist.', 'info');
        }
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
