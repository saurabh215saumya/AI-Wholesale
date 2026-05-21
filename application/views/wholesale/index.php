<?php $brandColor = '#ff6000'; $loggedIn = isset($loggedIn) ? $loggedIn : false; ?>

<!-- Page Header -->
<section class="page-header page-header-classic">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="active">Wholesale</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="font-weight-light text-7">Wholesale Program</h1>
            </div>
        </div>
    </div>
</section>

<!-- HERO BANNER -->
<div style="background:linear-gradient(135deg,#1a1a2e 0%,#16213e 55%,#0f3460 100%); padding:60px 0; position:relative; overflow:hidden;">
    <div class="container" style="position:relative; z-index:1;">
        <div class="row">
            <div class="col-md-7">
                <p style="color:#ff6000; font-weight:700; text-transform:uppercase; letter-spacing:2px; font-size:12px; margin-bottom:10px;">
                    <i class="fa fa-star"></i> &nbsp; WHOLESALE PROGRAM
                </p>
                <h2 style="color:#fff; font-size:36px; font-weight:800; line-height:1.25; margin-bottom:18px;">
                    Partner With Us &amp;<br>Grow Your Business
                </h2>
                <p style="color:rgba(255,255,255,0.8); font-size:16px; line-height:1.8; margin-bottom:28px;">
                    Join our wholesale program and unlock exclusive volume pricing, priority stock access, and a dedicated account manager — built for retailers, distributors, and online sellers.
                </p>
                <?php if(!$loggedIn): ?>
                <a href="<?php echo base_url('wholesale/apply'); ?>" class="btn btn-primary btn-lg" style="margin-right:10px; border-radius:4px;">
                    Apply as Wholesaler &nbsp;<i class="fa fa-arrow-right"></i>
                </a>
                <a href="<?php echo base_url('sign-in'); ?>" style="color:rgba(255,255,255,0.75); font-size:14px; line-height:46px; vertical-align:middle;">
                    Already a member? Login
                </a>
                <?php else: ?>
                <div style="background:rgba(255,96,0,0.15); border:1px solid rgba(255,96,0,0.4); border-radius:6px; padding:14px 20px; display:inline-block;">
                    <i class="fa fa-check-circle" style="color:#ff6000; font-size:18px; margin-right:8px;"></i>
                    <span style="color:#fff; font-size:15px; font-weight:600;">You are logged in as a wholesale member.</span>
                    &nbsp;&nbsp;
                    <a href="<?php echo base_url('all-products'); ?>" class="btn btn-primary btn-sm" style="border-radius:4px;">Shop Now &nbsp;<i class="fa fa-shopping-bag"></i></a>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-5 hidden-sm hidden-xs text-center">
                <div style="display:inline-block; position:relative; margin-top:10px;">
                    <div style="width:200px; height:200px; border-radius:50%; border:2px solid rgba(255,96,0,0.3); display:flex; align-items:center; justify-content:center; margin:0 auto;">
                        <div style="width:140px; height:140px; border-radius:50%; border:2px solid rgba(255,96,0,0.5); background:rgba(255,96,0,0.08); display:flex; align-items:center; justify-content:center;">
                            <i class="fa fa-handshake-o" style="font-size:56px; color:#ff6000;"></i>
                        </div>
                    </div>
                    <div style="position:absolute; top:0; right:-10px; background:#ff6000; color:#fff; border-radius:6px; padding:8px 14px; font-size:12px; font-weight:700; box-shadow:0 4px 12px rgba(0,0,0,0.25);">
                        Up to 20% OFF
                    </div>
                    <div style="position:absolute; bottom:10px; left:-20px; background:#fff; color:#333; border-radius:6px; padding:8px 14px; font-size:12px; font-weight:700; box-shadow:0 4px 12px rgba(0,0,0,0.2);">
                        500+ Products
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BENEFITS -->
<div style="background:#f8f8f6; padding:55px 0;">
    <div class="container">
        <div class="row text-center" style="margin-bottom:35px;">
            <div class="col-md-12">
                <h2 style="font-weight:800; font-size:28px; margin-bottom:8px;">Why Choose Our Wholesale Program?</h2>
                <p class="text-muted">Everything you need to run a successful wholesale business</p>
            </div>
        </div>
        <div class="row">
            <?php
            $benefits = [
                ['fa-tags',         'Exclusive Pricing',   'Volume-based discounts up to 20% off retail prices on our full catalogue.'],
                ['fa-truck',        'Priority Shipping',   'Fast 48-hour dispatch with dedicated logistics support for wholesale orders.'],
                ['fa-user',         'Account Manager',     'A dedicated account manager to support all your wholesale requirements.'],
                ['fa-cubes',        'Full Catalogue',      'Access to 500+ products across all categories at wholesale rates.'],
            ];
            foreach ($benefits as $b):
            ?>
            <div class="col-md-3 col-sm-6" style="margin-bottom:24px;">
                <div class="featured-box featured-box-primary featured-box-flat text-center" style="padding:30px 20px; border-radius:8px; height:100%; transition:transform .25s, box-shadow .25s;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='';this.style.boxShadow='';">
                    <div class="box-content">
                        <div style="width:64px; height:64px; background:#ff6000; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; margin-bottom:16px;">
                            <i class="fa <?php echo $b[0]; ?>" style="font-size:26px; color:#fff;"></i>
                        </div>
                        <h4 style="font-weight:700; margin-bottom:10px;"><?php echo $b[1]; ?></h4>
                        <p style="color:#888; font-size:14px; margin:0;"><?php echo $b[2]; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- PRICING TIERS -->
<div style="background:#fff; padding:55px 0;">
    <div class="container">
        <div class="row text-center" style="margin-bottom:35px;">
            <div class="col-md-12">
                <h2 style="font-weight:800; font-size:28px; margin-bottom:8px;">Volume-Based Pricing Tiers</h2>
                <p class="text-muted">The more you order, the more you save — automatically</p>
            </div>
        </div>

        <?php if (!empty($pricingTiers)): ?>
        <div class="row" style="display:flex; flex-wrap:wrap; align-items:stretch;">
            <?php
            $tierColors = ['#6c757d','#17a2b8','#ff6000','#343a40'];
            foreach ($pricingTiers as $i => $tier):
                $col   = isset($tierColors[$i]) ? $tierColors[$i] : '#ff6000';
                $isFeat = ($i == 2);
            ?>
            <div class="col-md-3 col-sm-6" style="margin-bottom:24px; display:flex;">
                <div style="border-radius:10px; overflow:hidden; box-shadow:<?php echo $isFeat ? '0 8px 40px rgba(255,96,0,0.25)' : '0 2px 16px rgba(0,0,0,0.08)'; ?>; width:100%; display:flex; flex-direction:column; position:relative; transition:transform .25s, box-shadow .25s; <?php echo $isFeat ? 'transform:scale(1.03);' : ''; ?>" onmouseover="this.style.transform='translateY(-8px) <?php echo $isFeat ? 'scale(1.03)' : ''; ?>';this.style.boxShadow='0 16px 50px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='<?php echo $isFeat ? 'scale(1.03)' : ''; ?>';this.style.boxShadow='<?php echo $isFeat ? '0 8px 40px rgba(255,96,0,0.25)' : '0 2px 16px rgba(0,0,0,0.08)'; ?>';">
                    <?php if ($isFeat): ?>
                    <div style="position:absolute; top:0; right:0; background:#ff6000; color:#fff; font-size:10px; font-weight:700; padding:5px 12px; border-radius:0 0 0 8px; text-transform:uppercase; letter-spacing:1px;">Most Popular</div>
                    <?php endif; ?>
                    <!-- Tier Header -->
                    <div style="background:<?php echo $col; ?>; padding:28px 20px 22px; text-align:center;">
                        <div style="font-size:15px; font-weight:700; text-transform:uppercase; letter-spacing:2px; color:rgba(255,255,255,0.9); margin-bottom:8px;">
                            <?php echo htmlspecialchars($tier['tier_name']); ?>
                        </div>
                        <div style="font-size:52px; font-weight:800; color:#fff; line-height:1;">
                            <?php echo number_format($tier['discount_percent'], 0); ?>%
                        </div>
                        <div style="font-size:11px; text-transform:uppercase; letter-spacing:1px; color:rgba(255,255,255,0.75); margin-top:4px;">
                            OFF RETAIL PRICE
                        </div>
                    </div>
                    <!-- Tier Body -->
                    <div style="padding:22px 22px 26px; background:#fff; flex:1; display:flex; flex-direction:column;">
                        <div style="text-align:center; font-size:14px; font-weight:700; color:#333; margin-bottom:10px;">
                            <i class="fa fa-cubes" style="color:<?php echo $col; ?>;"></i> &nbsp;
                            <?php if ($tier['max_qty']): ?>
                                <?php echo number_format($tier['min_qty']); ?> &ndash; <?php echo number_format($tier['max_qty']); ?> units
                            <?php else: ?>
                                <?php echo number_format($tier['min_qty']); ?>+ units
                            <?php endif; ?>
                        </div>
                        <?php if ($tier['description']): ?>
                        <p style="text-align:center; color:#888; font-size:13px; margin-bottom:16px;"><?php echo htmlspecialchars($tier['description']); ?></p>
                        <?php endif; ?>
                        <ul style="list-style:none; padding:0; margin:0 0 20px; flex:1;">
                            <li style="font-size:13px; color:#555; padding:6px 0; border-bottom:1px solid #f5f5f5;">
                                <i class="fa fa-check" style="color:<?php echo $col; ?>; margin-right:8px;"></i>
                                <?php echo number_format($tier['discount_percent'], 0); ?>% off all products
                            </li>
                            <li style="font-size:13px; color:#555; padding:6px 0; border-bottom:1px solid #f5f5f5;">
                                <i class="fa fa-check" style="color:<?php echo $col; ?>; margin-right:8px;"></i>
                                Priority order processing
                            </li>
                            <li style="font-size:13px; color:#555; padding:6px 0; border-bottom:1px solid #f5f5f5;">
                                <i class="fa fa-check" style="color:<?php echo $col; ?>; margin-right:8px;"></i>
                                Dedicated account support
                            </li>
                            <?php if ($tier['discount_percent'] >= 15): ?>
                            <li style="font-size:13px; color:#555; padding:6px 0; border-bottom:1px solid #f5f5f5;">
                                <i class="fa fa-check" style="color:<?php echo $col; ?>; margin-right:8px;"></i>
                                Early access to new stock
                            </li>
                            <?php endif; ?>
                            <?php if ($tier['discount_percent'] >= 20): ?>
                            <li style="font-size:13px; color:#555; padding:6px 0;">
                                <i class="fa fa-check" style="color:<?php echo $col; ?>; margin-right:8px;"></i>
                                Custom pricing available
                            </li>
                            <?php endif; ?>
                        </ul>
                        <a href="<?php echo $loggedIn ? base_url('all-products') : base_url('wholesale/apply'); ?>" class="btn btn-block btn-primary" style="background:<?php echo $col; ?> !important; border-color:<?php echo $col; ?> !important; font-weight:700; border-radius:4px;">
                            <?php echo $loggedIn ? 'Shop Now' : 'Get Started'; ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="text-muted">Pricing tiers coming soon. Please <a href="<?php echo base_url('contact-us'); ?>">contact us</a> for wholesale rates.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- HOW IT WORKS -->
<div style="background:#f8f8f6; padding:55px 0;">
    <div class="container">
        <div class="row text-center" style="margin-bottom:35px;">
            <div class="col-md-12">
                <h2 style="font-weight:800; font-size:28px; margin-bottom:8px;">How It Works</h2>
                <p class="text-muted">Get started in three simple steps</p>
            </div>
        </div>
        <div class="row text-center">
            <?php
            $steps = [
                ['Apply Online',   'Fill in your business details and submit your wholesale application in minutes.'],
                ['Get Approved',   'Our team reviews your application and activates your wholesale account quickly.'],
                ['Start Ordering', 'Log in and enjoy exclusive wholesale pricing across our full product catalogue.'],
            ];
            foreach ($steps as $n => $s):
            ?>
            <div class="col-md-4" style="margin-bottom:24px;">
                <div style="width:60px; height:60px; background:#ff6000; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; margin-bottom:16px;">
                    <span style="color:#fff; font-size:22px; font-weight:800;"><?php echo $n+1; ?></span>
                </div>
                <h4 style="font-weight:700; margin-bottom:8px;"><?php echo $s[0]; ?></h4>
                <p style="color:#888; font-size:14px;"><?php echo $s[1]; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="row" style="margin-top:20px;">
            <div class="col-md-12 text-center">
                <?php if(!$loggedIn): ?>
                <a href="<?php echo base_url('wholesale/apply'); ?>" class="btn btn-primary btn-lg" style="border-radius:4px; padding:12px 36px;">
                    Apply Now &nbsp;<i class="fa fa-arrow-right"></i>
                </a>
                <?php else: ?>
                <a href="<?php echo base_url('all-products'); ?>" class="btn btn-primary btn-lg" style="border-radius:4px; padding:12px 36px;">
                    Browse Products &nbsp;<i class="fa fa-shopping-bag"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- FAQ -->
<!-- <div style="background:#fff; padding:55px 0;">
    <div class="container">
        <div class="row text-center" style="margin-bottom:35px;">
            <div class="col-md-12">
                <h2 style="font-weight:800; font-size:28px; margin-bottom:8px;">Frequently Asked Questions</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel-group" id="wsFaq" role="tablist">
                    <?php
                    $faqs = [
                        ['What is the minimum order quantity?',
                         'Our minimum order starts at 50 units to qualify for the Starter wholesale tier. Higher volumes unlock greater discounts.'],
                        ['How long does account approval take?',
                         'Most applications are reviewed and approved within 1–2 business days. You\'ll receive an email confirmation once your account is active.'],
                        ['Can I mix products across categories?',
                         'Yes! Your order quantity is calculated across all products in your order, so you can mix and match from our full catalogue to reach your tier.'],
                        ['What payment methods are accepted?',
                         'We accept all major payment methods including bank transfer, credit/debit card, and PayPal for wholesale orders.'],
                        ['Do you offer custom pricing for very large orders?',
                         'Yes, for orders of 500+ units or regular high-volume buyers, our team can discuss custom pricing arrangements. Contact us directly after applying.'],
                    ];
                    foreach ($faqs as $fi => $faq):
                    ?>
                    <div class="panel panel-default" style="border-radius:6px; margin-bottom:8px; border:1px solid #eee; box-shadow:0 1px 6px rgba(0,0,0,0.05);">
                        <div class="panel-heading" role="tab" style="background:#fff; border-radius:6px; padding:0;">
                            <h4 class="panel-title" style="margin:0;">
                                <a role="button" data-toggle="collapse" data-parent="#wsFaq" href="#faq<?php echo $fi; ?>" <?php echo $fi > 0 ? 'class="collapsed"' : ''; ?> style="display:block; padding:15px 18px; font-weight:600; color:#333; font-size:14px; text-decoration:none;">
                                    <i class="fa fa-<?php echo $fi === 0 ? 'minus' : 'plus'; ?> pull-right" style="color:#ff6000; margin-top:2px;" id="faqIcon<?php echo $fi; ?>"></i>
                                    <?php echo $faq[0]; ?>
                                </a>
                            </h4>
                        </div>
                        <div id="faq<?php echo $fi; ?>" class="panel-collapse collapse <?php echo $fi === 0 ? 'in' : ''; ?>" role="tabpanel">
                            <div class="panel-body" style="color:#666; font-size:14px; line-height:1.7; border-top:1px solid #f0f0f0;">
                                <?php echo $faq[1]; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- CTA -->
<div style="background:linear-gradient(135deg,#1a1a2e,#0f3460); padding:65px 0; text-align:center;">
    <div class="container">
        <h2 style="color:#fff; font-size:32px; font-weight:800; margin-bottom:14px;">Ready to Get Started?</h2>
        <p style="color:rgba(255,255,255,0.75); font-size:16px; margin-bottom:28px;">Join hundreds of businesses already benefiting from our wholesale program.</p>
        <?php if(!$loggedIn): ?>
        <a href="<?php echo base_url('wholesale/apply'); ?>" class="btn btn-primary btn-lg" style="border-radius:4px; padding:14px 42px; font-size:16px; font-weight:700;">
            Apply as Wholesaler &nbsp;<i class="fa fa-arrow-right"></i>
        </a>
        <?php else: ?>
        <a href="<?php echo base_url('all-products'); ?>" class="btn btn-primary btn-lg" style="border-radius:4px; padding:14px 42px; font-size:16px; font-weight:700;">
            Start Shopping &nbsp;<i class="fa fa-shopping-bag"></i>
        </a>
        <?php endif; ?>
        <br><br>
        <p style="color:rgba(255,255,255,0.45); font-size:13px; margin:0;">
            Have questions? <a href="<?php echo base_url('contact-us'); ?>" style="color:#ff6000;">Contact our team</a>
        </p>
    </div>
</div>

<script>
// FAQ icon toggle
$('#wsFaq').on('show.bs.collapse', function(e) {
    var id = $(e.target).attr('id').replace('faq','');
    $('#faqIcon'+id).removeClass('fa-plus').addClass('fa-minus');
});
$('#wsFaq').on('hide.bs.collapse', function(e) {
    var id = $(e.target).attr('id').replace('faq','');
    $('#faqIcon'+id).removeClass('fa-minus').addClass('fa-plus');
});
</script>
