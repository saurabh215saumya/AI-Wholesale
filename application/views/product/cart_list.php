<?php
$userId   = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['id'] : '';
$userType = $this->session->userdata('front_logged_in') ? $this->session->userdata('front_logged_in')['user_type'] : '';
?>
<div class="cart">
    <div class="container">
        <h1 class="h2 heading-primary mt-lg clearfix"><span>Shopping Cart</span></h1>
        <div class="row">
            <div class="col-md-8 col-lg-9">
                <div class="cart-table-wrap">
                    <table class="cart-table">
                        <thead>
                            <tr><th></th><th></th><th>Product Name</th><th>Unit Price</th><th>Qty</th><th>Subtotal</th></tr>
                        </thead>
                        <tbody>
                        <?php
                        $subTotal = 0; $i = 1;
                        if(!empty($allCartProducts)):
                            foreach($allCartProducts as $row):
                                $proImg = getProductImage($row['image']);
                                if($userType=='business' && $row['wholesale_price']>0) $proPrice = $row['wholesale_price'];
                                elseif($userType && $row['retailer_price']>0) $proPrice = $row['retailer_price'];
                                else $proPrice = $row['price'];
                                $totPrice = $proPrice * $row['quantity'];
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
                            </td>
                            <td>
                                <span id="proPrice_<?php echo $i; ?>" class="amount"><?php echo CURRENCY_SYMBOL.' '.number_format($proPrice,2); ?></span>
                            </td>
                            <td>
                                <div class="qty-holder">
                                    <a href="javascript:void(0);" onclick="return updateCartQty('<?php echo $row['product_id']; ?>','<?php echo $i; ?>',-1);" class="qty-dec-btn" title="Dec">-</a>
                                    <input type="text" class="qty-input" id="quantity_<?php echo $i; ?>" value="<?php echo $row['quantity']; ?>">
                                    <a href="javascript:void(0);" onclick="return updateCartQty('<?php echo $row['product_id']; ?>','<?php echo $i; ?>',1);" class="qty-inc-btn" title="Inc">+</a>
                                </div>
                            </td>
                            <td>
                                <span class="text-primary" id="totPrice_<?php echo $i; ?>"><?php echo CURRENCY_SYMBOL.' '.number_format($totPrice,2); ?></span>
                            </td>
                        </tr>
                        <?php $i++; endforeach; endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="clearfix">
                                    <a href="<?php echo base_url(); ?>"><button class="btn btn-default hover-primary btn-update">Continue Shopping</button></a>
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
                                        <tr><td>Subtotal</td><td><?php echo CURRENCY_SYMBOL.' '.number_format($subTotal,2); ?></td></tr>
                                        <tr><td>Shipping</td><td>Free</td></tr>
                                        <tr><td><strong>Grand Total</strong></td><td><strong><?php echo CURRENCY_SYMBOL.' '.number_format($subTotal,2); ?></strong></td></tr>
                                    </tbody>
                                </table>
                                <?php if(!empty($allCartProducts)): ?>
                                <div class="totals-table-action">
                                    <a href="<?php echo base_url('checkout'); ?>" class="btn btn-primary btn-block">Proceed to Checkout</a>
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

<input type="hidden" id="session_user_id" value="<?php echo $userId; ?>">
<script>
function updateCartQty(product_id, id, delta) {
    var qty = parseInt($('#quantity_'+id).val()) + delta;
    if (qty < 1) return false;
    $('#quantity_'+id).val(qty);
    $.ajax({ type:'POST', url: BASE_URL+'/product/addItemIntoCart', data:'product_id='+product_id+'&user_id='+$('#session_user_id').val()+'&quantity='+qty,
        success: function() { window.location.href = BASE_URL+'/cart-list/'; }
    });
    return false;
}
</script>
