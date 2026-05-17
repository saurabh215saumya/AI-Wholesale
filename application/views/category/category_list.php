<?php
$userId   = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['id'] : '';
$userType = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['user_type'] : '';
$pageSlug = $this->uri->segment(1);
$slug     = $this->uri->segment(2);
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
                    $inStock   = $p['quantity'] > 0;
                    $minP      = $hasVar ? min(array_column($variants,'price')) : floatval($p['price']);
                    $maxP      = $hasVar ? max(array_column($variants,'price')) : 0;
                    $priceStr  = ($hasVar && $maxP > $minP)
                        ? CURRENCY_SYMBOL.number_format($minP,2).' - '.CURRENCY_SYMBOL.number_format($maxP,2)
                        : CURRENCY_SYMBOL.number_format($minP,2);
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

                        <div class="jly-price"><?php echo $priceStr; ?></div>

                        <a href="<?php echo $detailUrl; ?>" class="jly-btn jly-btn-view">
                            <i class="fa fa-eye"></i> View Details
                        </a>

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
                                <li class="<?php echo $pageSlug=='all-products'||!$pageSlug?'active':''; ?>">
                                    <a href="<?php echo base_url('all-products'); ?>">All Products</a>
                                </li>
                                <?php if(!empty($isActiveCategories)): foreach($isActiveCategories as $cat): ?>
                                <?php
                                    $subs = getAllSubCategory($cat->id);
                                    $expandSubs = ($pageSlug=='categories' && $slug==$cat->category_slug)
                                               || ($pageSlug=='subcategories' && !empty($subs) && in_array($slug, array_column((array)$subs, 'sub_category_slug')));
                                    $hasSubs = !empty($subs);
                                    $catId   = 'cat-subs-'.$cat->id;
                                ?>
                                <li class="<?php echo $pageSlug=='categories'&&$slug==$cat->category_slug?'active':''; ?>">
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
                                        <?php foreach($subs as $sub): ?>
                                        <li><a href="<?php echo base_url('subcategories/'.$sub->sub_category_slug); ?>" style="font-size:12px;<?php echo ($pageSlug=='subcategories'&&$slug==$sub->sub_category_slug)?'color:#ff6000;font-weight:700;':''; ?>"><?php echo $sub->sub_category_name; ?></a></li>
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
                <div class="feature-box-info"><h4>FREE SHIPPING</h4><p class="mb-none">On orders over <?php echo CURRENCY_SYMBOL; ?>99</p></div>
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
function doAddCart(pid, qty) {
    var uid = $('#session_user_id').val();
    if (!uid) { window.location.href = BASE_URL + '/sign-in'; return; }
    $.post(BASE_URL + '/product/addItemIntoCart', {product_id: pid, user_id: uid, quantity: qty}, function(r) {
        if (r === 'login') { window.location.href = BASE_URL + '/sign-in'; return; }
        showToast('Added to cart!', 'success');
        var $qty = $('.cart-qty'); $qty.text(parseInt($qty.text()) + 1);
        var $btn = $('#card-' + pid + ' .jly-btn-quick');
        $btn.html('<i class="fa fa-check"></i> Item in Cart').attr('onclick', "window.location.href=BASE_URL+'/cart-list'");
    });
}
function addVariantToCart(pid, price, label) {
    var uid = $('#session_user_id').val();
    if (!uid) { window.location.href = BASE_URL + '/sign-in'; return; }
    $.post(BASE_URL + '/product/addItemIntoCart', {product_id: pid, user_id: uid, quantity: 1, variant_price: price, variant_label: label}, function(r) {
        if (r === 'login') { window.location.href = BASE_URL + '/sign-in'; return; }
        showToast(label + ' added to cart!', 'success');
        var $qty = $('.cart-qty'); $qty.text(parseInt($qty.text()) + 1);
        $('#variants-card-' + pid).removeClass('open');
        $('#chev-card-' + pid).removeClass('fa-chevron-up').addClass('fa-chevron-down');
    });
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
