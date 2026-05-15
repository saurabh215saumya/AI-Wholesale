<section class="page-header mb-lg">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="active">My Wishlist</li>
        </ul>
    </div>
</section>
<div class="container mb-xlg">
    <h2 class="heading-primary">My Wishlist</h2>
    <?php if(!empty($allWishlistProducts)): ?>
    <ul class="products-grid columns4">
        <?php foreach($allWishlistProducts as $p):
            $img = getProductImage($p['image']);
        ?>
        <li>
            <div class="product">
                <figure class="product-image-area">
                    <a href="<?php echo base_url('product-details/'.$p['product_slug']); ?>" class="product-image">
                        <img src="<?php echo $img; ?>" alt="<?php echo $p['product_name']; ?>">
                        <img src="<?php echo $img; ?>" alt="<?php echo $p['product_name']; ?>" class="product-hover-image">
                    </a>
                </figure>
                <div class="product-details-area">
                    <h2 class="product-name"><a href="<?php echo base_url('product-details/'.$p['product_slug']); ?>"><?php echo $p['product_name']; ?></a></h2>
                    <div class="product-bottom-row">
                        <div class="product-price-box">
                            <span class="product-price"><?php echo CURRENCY_SYMBOL.' '.number_format($p['price'],2); ?></span>
                        </div>
                        <div class="product-actions">
                            <a onclick="return addToCartFromWishlist('<?php echo $p['product_id']; ?>');" class="addtocart"><i class="fa fa-shopping-cart"></i><span>Add to Cart</span></a>
                            <a onclick="return removeFromWishlist('<?php echo $p['product_id']; ?>');" class="addtowishlist addtowishlist-always active" title="Remove from Wishlist"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <div class="alert alert-info mt-lg">Your wishlist is empty. <a href="<?php echo base_url('all-products'); ?>">Browse products</a></div>
    <?php endif; ?>
</div>
<input type="hidden" id="session_user_id" value="<?php echo $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['id'] : ''; ?>">
<script>
function addToCartFromWishlist(pid) {
    var uid = $('#session_user_id').val();
    if (!uid) { window.location.href = BASE_URL+'/sign-in'; return false; }
    $.ajax({ type:'POST', url: BASE_URL+'/product/addItemIntoCart', data:'product_id='+pid+'&user_id='+uid+'&quantity=1',
        success: function() { alert('Added to cart!'); window.location.href = BASE_URL+'/cart-list/'; }
    });
    return false;
}
function removeFromWishlist(pid) {
    var uid = $('#session_user_id').val();
    $.ajax({ type:'POST', url: BASE_URL+'/product/addWishlistProduct', data:'product_id='+pid+'&user_id='+uid,
        success: function() { location.reload(); }
    });
    return false;
}
</script>
