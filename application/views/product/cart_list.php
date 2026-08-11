<?php
$userId   = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['id'] : '';
$userType = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['user_type'] : '';
$isGuest  = isset($isGuest) ? $isGuest : false;
?>
<div class="cart">
    <div class="container">
        <h1 class="h2 heading-primary mt-lg clearfix"><span>Shopping Cart</span></h1>
        <?php if ($isGuest): ?>
        <div class="alert alert-info" style="margin-bottom:15px;">
            <i class="fa fa-info-circle"></i> You are shopping as a guest. <a href="<?php echo base_url('sign-in?redirect=checkout'); ?>"><strong>Sign in</strong></a> or <a href="<?php echo base_url('sign-up'); ?>"><strong>create an account</strong></a> to complete your purchase.
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-8 col-lg-9">
                <div class="cart-table-wrap">
                    <table class="cart-table">
                        <thead>
                            <tr><th></th><th></th><th>Product Name</th><th>Unit Price</th><th>Qty</th><th>Subtotal (inc. VAT)</th></tr>
                        </thead>
                        <tbody>
                        <?php
                        $subTotal = 0; $i = 1;
                        if(!empty($allCartProducts)):
                            foreach($allCartProducts as $row):
                                $proImg = getProductImage($row['image']);
                                if(!empty($row['variant_price']) && $row['variant_price'] > 0) {
                                    $proPrice = floatval($row['variant_price']);
                                } elseif($userType=='business' && $row['wholesale_price']>0) {
                                    $proPrice = $row['wholesale_price'];
                                } elseif($userType && $row['retailer_price']>0) {
                                    $proPrice = $row['retailer_price'];
                                } else {
                                    $proPrice = $row['price'];
                                }
                                $vatAmount  = $proPrice * 0.20;
                                $priceWithVat = $proPrice * 1.20;
                                $totPrice = $priceWithVat * $row['quantity'];
                                $subTotal += $totPrice;
                        ?>
                        <tr>
                            <td class="product-action-td">
                                <a href="<?php echo base_url('product/delete_cart_product/'.$row['cartId']); ?>" title="Remove" class="btn-remove" onclick="return confirm('Remove this item?')"><i class="fa fa-times"></i></a>
                            </td>
                            <td class="product-image-td">
                                <a href="<?php echo base_url('product-details/'.$row['product_slug']); ?>">
                                    <img src="<?php echo $proImg; ?>" alt="<?php echo $row['product_name']; ?>">
                                </a>
                            </td>
                            <td class="product-name-td">
                                <h2 class="product-name"><a href="<?php echo base_url('product-details/'.$row['product_slug']); ?>"><?php echo $row['product_name']; ?></a></h2>
                                <?php if(!empty($row['variant_label'])): ?>
                                <small class="text-muted"><i class="fa fa-tag"></i> <?php echo htmlspecialchars($row['variant_label']); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span id="proPrice_<?php echo $i; ?>" class="amount"><?php echo '£ '.number_format($proPrice,2); ?></span><br>
                                <span class="vat-label">VAT 20%: £ <?php echo number_format($vatAmount * $row['quantity'],2); ?></span>
                            </td>
                            <td>
                                <div class="qty-holder">
                                    <a href="javascript:void(0);" onclick="return updateCartQty('<?php echo $row['product_id']; ?>','<?php echo $i; ?>',-1,'<?php echo addslashes($row['variant_label']); ?>','<?php echo $row['variant_price']; ?>');" class="qty-dec-btn" title="Dec">-</a>
                                    <input type="text" class="qty-input" id="quantity_<?php echo $i; ?>" value="<?php echo $row['quantity']; ?>">
                                    <a href="javascript:void(0);" onclick="return updateCartQty('<?php echo $row['product_id']; ?>','<?php echo $i; ?>',1,'<?php echo addslashes($row['variant_label']); ?>','<?php echo $row['variant_price']; ?>');" class="qty-inc-btn" title="Inc">+</a>
                                </div>
                            </td>
                            <td>
                                <span class="subtotal-price" id="totPrice_<?php echo $i; ?>"><?php echo '£ '.number_format($totPrice,2); ?></span>
                            </td>
                        </tr>
                        <?php $i++; endforeach; endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="clearfix">
                                    <a href="<?php echo base_url('all-products'); ?>" class="btn-cart-continue">
                                        <i class="fa fa-arrow-left"></i> Continue Shopping
                                    </a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <aside class="col-md-4 col-lg-3 sidebar shop-sidebar">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" href="#panel-cart-total">Cart Totals</a>
                            </h4>
                        </div>
                        <div id="panel-cart-total" class="accordion-body collapse in">
                            <div class="panel-body">
                                <table class="totals-table">
                                    <tbody>
                                        <?php $netTotal = $subTotal / 1.20; $vatTotal = $subTotal - $netTotal; ?>
                                        <tr><td>Subtotal (ex. VAT)</td><td>£ <?php echo number_format($netTotal,2); ?></td></tr>
                                        <tr><td>VAT (20%)</td><td>£ <?php echo number_format($vatTotal,2); ?></td></tr>
                                        <tr><td>Shipping</td><td>Free</td></tr>
                                        <tr><td><strong>Grand Total</strong><br><small style="font-weight:400;color:#888;">(inc. VAT)</small></td><td><strong>£ <?php echo number_format($subTotal,2); ?></strong></td></tr>
                                    </tbody>
                                </table>
                                <?php if(!empty($allCartProducts)): ?>
                                <div class="totals-table-action">
                                    <?php if ($isGuest): ?>
                                    <a href="<?php echo base_url('sign-in?redirect=checkout'); ?>" class="btn btn-primary btn-block">Proceed to Order</a>
                                    <?php else: ?>
                                    <a href="<?php echo base_url('checkout'); ?>" class="btn btn-primary btn-block">Proceed to Order</a>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
function updateCartQty(product_id, id, delta, variant_label, variant_price) {
    var qty = parseInt($('#quantity_'+id).val()) + delta;
    if (qty < 1) return false;
    $('#quantity_'+id).val(qty);
    var data = {product_id: product_id, quantity: qty, replace: 1};
    if (variant_label) data.variant_label = variant_label;
    if (variant_price > 0) data.variant_price = variant_price;
    $.ajax({ type:'POST', url: BASE_URL+'/product/addItemIntoCart', data: data, dataType: 'json',
        success: function() { window.location.href = BASE_URL+'/cart-list'; }
    });
    return false;
}
</script>
