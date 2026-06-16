<?php
$userId      = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['id'] : '';
$userType    = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['user_type'] : '';
$p           = $productDetails;
if(empty($p)) { redirect('all-products'); return; }
$img         = getProductImage($p['image']);
$wishlistExist = checkUserProductInWishlist($p['id'], $userId);
$hasVar      = !empty($productVariants);
$variantType = !empty($p['variant_type']) ? $p['variant_type'] : 'per_quantity';

// Parse features from long_description
$features = array();
if(!empty($p['long_description'])) {
    $stripped = strip_tags($p['long_description']);
    $lines = preg_split('/\r\n|\r|\n|<br\s*\/?>/', $stripped);
    foreach($lines as $line) {
        $line = trim(ltrim(trim($line), '-•*'));
        if($line !== '') $features[] = $line;
    }
}

// Build sorted tiers for per_quantity: [ ['min'=>1,'price'=>10.00], ['min'=>15,'price'=>9.25], ... ]
$pqTiers = array();
if($hasVar && $variantType === 'per_quantity') {
    foreach($productVariants as $v) {
        $min = (int)preg_replace('/[^0-9]/', '', $v['label']);
        if($min < 1) $min = 1;
        $pqTiers[] = array('min' => $min, 'price' => floatval($v['price']));
    }
    usort($pqTiers, function($a,$b){ return $a['min'] - $b['min']; });
}
?>
<section class="page-header mb-lg">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url('all-products'); ?>">Products</a></li>
            <li class="active"><?php echo $p['product_name']; ?></li>
        </ul>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <!-- Left: Product Images -->
                <div class="col-sm-5">
                    <div class="pd-img-main-wrap">
                        <button class="jly-wish-btn pd-wish-btn <?php echo !empty($wishlistExist)?'active':''; ?>" onclick="return addProductInWishlist('<?php echo $p['id']; ?>')" title="Wishlist">
                            <i class="fa fa-heart<?php echo !empty($wishlistExist)?'':'-o'; ?>"></i>
                        </button>
                        <img id="pd-main-img" src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($p['product_name']); ?>" class="pd-main-img">
                    </div>
                    <!-- Thumbnails -->
                    <?php
                    $thumbs = array_filter(array('image','image_1','image_2','image_3','image_4'), function($k) use($p){ return !empty($p[$k]); });
                    if(count($thumbs) > 1):
                    ?>
                    <div class="pd-thumbs">
                        <?php foreach($thumbs as $tf):
                            $ti = getProductImage($p[$tf]);
                        ?>
                        <img src="<?php echo $ti; ?>" alt="" class="pd-thumb <?php echo $tf=='image'?'active':''; ?>" onclick="document.getElementById('pd-main-img').src='<?php echo $ti; ?>'; document.querySelectorAll('.pd-thumb').forEach(function(t){t.classList.remove('active');}); this.classList.add('active');">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right: Product Info -->
                <div class="col-sm-7">
                    <h1 class="pd-title"><?php echo $p['product_name']; ?></h1>
                    <?php if($p['description']): ?>
                    <p class="pd-size">Size: <?php echo htmlspecialchars(strip_tags($p['description'])); ?></p>
                    <?php endif; ?>

                    <!-- Description -->
                    <?php if($p['description']): ?>
                    <div class="pd-section">
                        <h4 class="pd-section-title">Description</h4>
                        <p class="pd-desc-text"><?php echo strip_tags($p['description']); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- Purchase Options -->
                    <div class="pd-section">
                        <h4 class="pd-section-title">Purchase Options</h4>
                        <div class="pd-purchase-box">
                            <?php if(!$userId): ?>
                            <p style="color:#e74c3c;font-size:13px;margin:0 0 10px;"><i class="fa fa-lock"></i> Register/Login to view variant prices</p>
                            <a href="<?php echo base_url('sign-in'); ?>" class="pd-add-cart-btn" style="text-decoration:none;display:inline-block;">
                                <i class="fa fa-sign-in"></i> Login / Register
                            </a>

                            <?php elseif($hasVar && $variantType === 'per_quantity'): ?>
                            <!-- PER QUANTITY: price tiers, no manual variant select -->
                            <div class="pd-tier-info" style="margin-bottom:12px;">
                                <p class="pd-select-label" style="margin-bottom:6px;"><i class="fa fa-tags"></i> Price Tiers</p>
                                <?php foreach($pqTiers as $ti => $tier): ?>
                                <div class="pd-tier-row">
                                    <span><?php echo ($ti < count($pqTiers)-1) ? $tier['min'].' - '.($pqTiers[$ti+1]['min']-1).' pcs' : $tier['min'].'+ pcs'; ?></span>
                                    <span class="pd-var-price"><?php echo '£ '.number_format($tier['price'],2); ?> / pc</span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="pd-qty-row">
                                <label class="pd-qty-label">Quantity</label>
                                <div class="pd-qty-ctrl">
                                    <button class="pd-qty-btn" onclick="pqChangeQty(-1)">&#8722;</button>
                                    <input type="number" id="pd-qty-val" class="pd-qty-input" value="1" min="1" oninput="pqOnInput(this.value)">
                                    <button class="pd-qty-btn" onclick="pqChangeQty(1)">&#43;</button>
                                </div>
                                <span class="pd-qty-info" id="pd-qty-info">@ £ <?php echo number_format($pqTiers[0]['price'],2); ?>/pc</span>
                            </div>
                            <div class="pd-total-row">
                                <span>Total:</span>
                                <span class="pd-total-price" id="pd-total-price"><?php echo '£ '.number_format($pqTiers[0]['price'],2); ?></span>
                            </div>
                            <?php if($p['quantity'] > 0): ?>
                            <button class="pd-add-cart-btn" onclick="pqAddToCart()">
                                <i class="fa fa-shopping-cart"></i> Add to Cart
                            </button>
                            <?php else: ?>
                            <button class="pd-add-cart-btn pd-add-cart-oos" disabled><i class="fa fa-ban"></i> Out of Stock</button>
                            <?php endif; ?>

                            <?php elseif($hasVar && $variantType === 'per_carton'): ?>
                            <!-- PER CARTON: select carton variant first -->
                            <p class="pd-select-label"><i class="fa fa-tag"></i> Select Carton Size</p>
                            <div class="pd-variant-list" id="pd-variant-list">
                                <?php foreach($productVariants as $i => $v):
                                    $vPrice = floatval($v['price']);
                                    $vLabel = htmlspecialchars($v['label'], ENT_QUOTES);
                                    $displayLabel = is_numeric(trim($v['label'])) ? trim($v['label']).' pieces' : htmlspecialchars($v['label']);
                                ?>
                                <div class="pd-variant-option <?php echo $i===0?'selected':''; ?>"
                                     data-price="<?php echo $vPrice; ?>"
                                     data-label="<?php echo $vLabel; ?>"
                                     onclick="selectVariant(this)">
                                    <div class="pd-var-left">
                                        <span class="pd-var-name"><?php echo $displayLabel; ?></span>
                                        <div class="pd-var-per">£ <?php echo number_format($vPrice,2); ?> per carton &nbsp;|&nbsp; £ <?php $cPcs=(int)preg_replace('/[^0-9]/','', $v['label']); if($cPcs<1)$cPcs=1; echo number_format(round($vPrice/$cPcs,2),2); ?>/pc</div>
                                    </div>
                                    <div class="pd-var-price">£ <?php echo number_format($vPrice,2); ?></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="pd-qty-row">
                                <label class="pd-qty-label">Cartons</label>
                                <div class="pd-qty-ctrl">
                                    <button class="pd-qty-btn" onclick="changeQty(-1)">&#8722;</button>
                                    <input type="number" id="pd-qty-val" class="pd-qty-input" value="1" min="1" oninput="pdOnInput(this.value)">
                                    <button class="pd-qty-btn" onclick="changeQty(1)">&#43;</button>
                                </div>
                            </div>
                            <div class="pd-total-row">
                                <span>Total:</span>
                                <span class="pd-total-price" id="pd-total-price"><?php echo '£ '.number_format(floatval($productVariants[0]['price']),2); ?></span>
                            </div>
                            <?php if($p['quantity'] > 0): ?>
                            <button class="pd-add-cart-btn" onclick="addVariantDetail()">
                                <i class="fa fa-shopping-cart"></i> Add to Cart
                            </button>
                            <?php else: ?>
                            <button class="pd-add-cart-btn pd-add-cart-oos" disabled><i class="fa fa-ban"></i> Out of Stock</button>
                            <?php endif; ?>

                            <?php else: ?>
                            <!-- No variants -->
                            <?php
                            if($userType=='business' && $p['wholesale_price']>0) $price = $p['wholesale_price'];
                            elseif($userType && $p['retailer_price']>0) $price = $p['retailer_price'];
                            else $price = $p['price'];
                            ?>
                            <div class="pd-single-price"><?php echo '£ '.number_format($price,2); ?></div>
                            <div class="pd-qty-row">
                                <label class="pd-qty-label">Quantity</label>
                                <div class="pd-qty-ctrl">
                                    <button class="pd-qty-btn" onclick="changeQty(-1)">&#8722;</button>
                                    <span id="pd-qty-val">1</span>
                                    <button class="pd-qty-btn" onclick="changeQty(1)">&#43;</button>
                                </div>
                            </div>
                            <div class="pd-total-row">
                                <span>Total:</span>
                                <span class="pd-total-price" id="pd-total-price"><?php echo '£ '.number_format($price,2); ?></span>
                            </div>
                            <button class="pd-add-cart-btn pd-add-cart-oos" disabled>
                                <i class="fa fa-ban"></i> Out of Stock
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="col-md-3 sidebar product-sidebar">
            <!-- Features from long_description -->
            <?php if(!empty($features)): ?>
            <div class="pd-section">
                <h4 class="pd-section-title">Features</h4>
                <ul class="pd-features">
                    <?php foreach($features as $f): ?>
                    <li><span class="pd-feat-dot">●</span><?php echo htmlspecialchars($f); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </aside>
    </div>
</div>

<input type="hidden" id="session_user_id" value="<?php echo $userId; ?>">
<input type="hidden" id="pd-product-id" value="<?php echo $p['id']; ?>">
<input type="hidden" id="pd-variant-type" value="<?php echo $variantType; ?>">

<script>
var pdQty = 1;
// Per Carton state
var pdSelectedPrice = <?php echo ($hasVar && $variantType==='per_carton') ? floatval($productVariants[0]['price']) : floatval($p['price']); ?>;
var pdSelectedLabel = '<?php echo ($hasVar && $variantType==='per_carton') ? htmlspecialchars($productVariants[0]['label'], ENT_QUOTES) : ''; ?>';

// Per Quantity tiers
var pqTiers = <?php echo $hasVar && $variantType==='per_quantity' ? json_encode(array_values($pqTiers)) : '[]'; ?>;

function pqGetTierPrice(qty) {
    var price = pqTiers.length ? pqTiers[0].price : 0;
    for (var i = 0; i < pqTiers.length; i++) {
        if (qty >= pqTiers[i].min) price = pqTiers[i].price;
    }
    return price;
}

function pqChangeQty(delta) {
    pdQty = Math.max(1, pdQty + delta);
    document.getElementById('pd-qty-val').value = pdQty;
    var price = pqGetTierPrice(pdQty);
    document.getElementById('pd-qty-info').textContent = '@ £ ' + price.toFixed(2) + '/pc';
    document.getElementById('pd-total-price').textContent = '£ ' + (pdQty * price).toFixed(2);
}
function pqOnInput(val) {
    pdQty = Math.max(1, parseInt(val) || 1);
    document.getElementById('pd-qty-val').value = pdQty;
    var price = pqGetTierPrice(pdQty);
    document.getElementById('pd-qty-info').textContent = '@ £ ' + price.toFixed(2) + '/pc';
    document.getElementById('pd-total-price').textContent = '£ ' + (pdQty * price).toFixed(2);
}

function pqAddToCart() {
    var price = pqGetTierPrice(pdQty);
    addToCart($('#pd-product-id').val(), pdQty, price, '');
}

// Per Carton functions
function selectVariant(el) {
    document.querySelectorAll('.pd-variant-option').forEach(function(o){ o.classList.remove('selected'); });
    el.classList.add('selected');
    pdSelectedPrice = parseFloat(el.dataset.price);
    pdSelectedLabel = el.dataset.label;
    updateTotal();
}

function changeQty(delta) {
    pdQty = Math.max(1, pdQty + delta);
    document.getElementById('pd-qty-val').value = pdQty;
    updateTotal();
}
function pdOnInput(val) {
    pdQty = Math.max(1, parseInt(val) || 1);
    document.getElementById('pd-qty-val').value = pdQty;
    updateTotal();
}

function updateTotal() {
    document.getElementById('pd-total-price').textContent = '£ ' + (pdQty * pdSelectedPrice).toFixed(2);
}

function addVariantDetail() {
    addToCart($('#pd-product-id').val(), pdQty, pdSelectedPrice, pdSelectedLabel);
}

function addProductInWishlist(product_id) {
    var user_id = $('#session_user_id').val();
    if (!user_id) { window.location.href = BASE_URL + '/sign-in'; return false; }
    $.post(BASE_URL+'/product/addWishlistProduct', {product_id: product_id, user_id: user_id}, function(r) {
        var $btn = $('.pd-wish-btn');
        if (r === 'added') { $btn.addClass('active').find('i').removeClass('fa-heart-o').addClass('fa-heart'); }
        else { $btn.removeClass('active').find('i').removeClass('fa-heart').addClass('fa-heart-o'); }
    });
    return false;
}
</script>
