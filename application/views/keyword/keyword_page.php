<style>
/* ── Hero ── */
.kwp-hero{background:linear-gradient(135deg,#1a1a2e 0%,#16213e 55%,#0f3460 100%);padding:64px 0 54px;position:relative;overflow:hidden;}
.kwp-hero::after{content:'';position:absolute;right:-80px;top:-80px;width:400px;height:400px;background:radial-gradient(circle,rgba(255,96,0,.18) 0%,transparent 70%);pointer-events:none;}
.kwp-hero .kwp-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(255,96,0,.15);border:1px solid rgba(255,96,0,.35);color:#ff8c42;border-radius:20px;padding:5px 14px;font-size:12px;font-weight:600;margin-bottom:16px;}
.kwp-hero h1{color:#fff;font-size:clamp(22px,4vw,38px);font-weight:800;line-height:1.25;margin:0 0 14px;max-width:720px;}
.kwp-hero .kwp-lead{color:rgba(255,255,255,.75);font-size:16px;max-width:620px;line-height:1.7;margin:0 0 28px;}
.kwp-hero .breadcrumb{background:none;padding:0;margin:0 0 20px;}
.kwp-hero .breadcrumb li a{color:rgba(255,255,255,.55);}
.kwp-hero .breadcrumb li.active{color:rgba(255,255,255,.85);}
.kwp-hero .breadcrumb>li+li::before{color:rgba(255,255,255,.35);}
.kwp-btn-primary{background:linear-gradient(135deg,#ff6000,#ff8c42);color:#fff;border:none;border-radius:50px;padding:13px 34px;font-size:15px;font-weight:700;cursor:pointer;display:inline-block;text-decoration:none;transition:opacity .2s;box-shadow:0 4px 18px rgba(255,96,0,.35);}
.kwp-btn-primary:hover{opacity:.88;color:#fff;text-decoration:none;}
.kwp-btn-outline{background:transparent;color:#fff;border:2px solid rgba(255,255,255,.4);border-radius:50px;padding:11px 30px;font-size:15px;font-weight:600;display:inline-block;text-decoration:none;transition:all .2s;margin-left:12px;}
.kwp-btn-outline:hover{border-color:#ff8c42;color:#ff8c42;text-decoration:none;}

/* ── Trust bar ── */
.kwp-trust{background:#fff;border-bottom:1px solid #f0f0f0;padding:18px 0;}
.kwp-trust-inner{display:flex;align-items:center;justify-content:center;gap:40px;flex-wrap:wrap;}
.kwp-trust-item{display:flex;align-items:center;gap:8px;font-size:13px;color:#555;font-weight:500;}
.kwp-trust-item i{color:#ff6000;font-size:16px;}

/* ── Features ── */
.kwp-features{padding:60px 0;background:#f8f9fb;}
.kwp-feat-card{background:#fff;border-radius:14px;padding:28px 24px;text-align:center;border:1px solid #eee;transition:all .25s;height:100%;}
.kwp-feat-card:hover{box-shadow:0 8px 30px rgba(255,96,0,.12);transform:translateY(-4px);border-color:#ffd0b0;}
.kwp-feat-icon{width:60px;height:60px;background:linear-gradient(135deg,#fff3ec,#ffe0cc);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;}
.kwp-feat-icon i{color:#ff6000;font-size:24px;}
.kwp-feat-card h4{font-size:15px;font-weight:700;color:#222;margin:0 0 8px;}
.kwp-feat-card p{font-size:13px;color:#888;margin:0;line-height:1.6;}

/* ── Content section ── */
.kwp-content{padding:60px 0;background:#fff;}
.kwp-content-box{background:#f8f9fb;border-radius:16px;padding:36px 32px;border-left:5px solid #ff6000;}
.kwp-content-box h2{font-size:22px;font-weight:700;color:#222;margin:0 0 14px;}
.kwp-content-box h3{font-size:18px;font-weight:600;color:#444;margin:20px 0 10px;}
.kwp-content-box p{color:#555;line-height:1.8;margin:0 0 12px;}

.kwp-info-cards{margin-top:30px;}
.kwp-info-card{display:flex;align-items:flex-start;gap:14px;background:#fff;border-radius:10px;padding:18px 20px;margin-bottom:14px;border:1px solid #eee;}
.kwp-info-card i{color:#ff6000;font-size:20px;margin-top:2px;flex-shrink:0;}
.kwp-info-card h5{margin:0 0 4px;font-size:14px;font-weight:700;color:#222;}
.kwp-info-card p{margin:0;font-size:13px;color:#777;line-height:1.5;}

/* ── Sidebar ── */
.kwp-sidebar-card{background:#fff;border-radius:14px;border:1px solid #eee;padding:24px;margin-bottom:24px;}
.kwp-sidebar-card h4{font-size:15px;font-weight:700;color:#222;margin:0 0 16px;padding-bottom:10px;border-bottom:2px solid #fff3ec;}
.kwp-sidebar-card ul{list-style:none;padding:0;margin:0;}
.kwp-sidebar-card ul li{padding:8px 0;border-bottom:1px solid #f5f5f5;font-size:13px;color:#555;}
.kwp-sidebar-card ul li:last-child{border:none;}
.kwp-sidebar-card ul li i{color:#ff6000;margin-right:8px;}
.kwp-contact-box{background:linear-gradient(135deg,#ff6000,#ff8c42);border-radius:14px;padding:24px;color:#fff;text-align:center;}
.kwp-contact-box h4{color:#fff;font-size:16px;font-weight:700;margin:0 0 8px;}
.kwp-contact-box p{color:rgba(255,255,255,.85);font-size:13px;margin:0 0 16px;}
.kwp-contact-box a{background:#fff;color:#ff6000;border-radius:30px;padding:10px 24px;font-size:14px;font-weight:700;display:inline-block;text-decoration:none;}
.kwp-contact-box a:hover{background:#fff3ec;color:#ff6000;text-decoration:none;}

/* ── CTA ── */
.kwp-cta{background:linear-gradient(135deg,#1a1a2e,#0f3460);padding:70px 0;text-align:center;}
.kwp-cta h2{color:#fff;font-size:30px;font-weight:800;margin:0 0 12px;}
.kwp-cta p{color:rgba(255,255,255,.7);font-size:16px;margin:0 0 30px;}
</style>

<?php
$h1    = !empty($kw['h1_tag'])          ? $kw['h1_tag']          : $kw['keyword'];
$h2    = !empty($kw['h2_tag'])          ? $kw['h2_tag']          : '';
$h3    = !empty($kw['h3_tag'])          ? $kw['h3_tag']          : '';
$desc  = !empty($kw['meta_description'])? $kw['meta_description']: '';
$loc   = !empty($kw['location'])        ? $kw['location']        : '';
?>

<!-- Hero -->
<div class="kwp-hero">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>">Home</a></li>
      <?php if($loc): ?><li><a href="<?php echo base_url('location/'.urlencode($loc)); ?>"><?php echo htmlspecialchars($loc); ?></a></li><?php endif; ?>
      <li class="active"><?php echo htmlspecialchars($kw['keyword']); ?></li>
    </ol>
    <?php if($loc): ?><span class="kwp-badge"><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($loc); ?></span><?php endif; ?>
    <h1><?php echo htmlspecialchars($h1); ?></h1>
    <?php if($desc): ?><p class="kwp-lead"><?php echo htmlspecialchars($desc); ?></p><?php endif; ?>
    <a href="<?php echo base_url('sign-up'); ?>" class="kwp-btn-primary"><i class="fa fa-user-plus"></i> Register Now — It's Free</a>
    <?php if($loc): ?><a href="<?php echo base_url('location/'.urlencode($loc)); ?>" class="kwp-btn-outline"><i class="fa fa-th-large"></i> More in <?php echo htmlspecialchars($loc); ?></a><?php endif; ?>
  </div>
</div>

<!-- Trust bar -->
<div class="kwp-trust">
  <div class="container">
    <div class="kwp-trust-inner">
      <div class="kwp-trust-item"><i class="fa fa-truck"></i> Free Delivery on Orders</div>
      <div class="kwp-trust-item"><i class="fa fa-shield"></i> Trade-Only Wholesale</div>
      <div class="kwp-trust-item"><i class="fa fa-star"></i> 10+ Years Experience</div>
      <div class="kwp-trust-item"><i class="fa fa-phone"></i> 07414 560342</div>
      <div class="kwp-trust-item"><i class="fa fa-map-marker"></i> Hounslow, TW4 6BL</div>
    </div>
  </div>
</div>

<!-- Features -->
<div class="kwp-features">
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-sm-6" style="margin-bottom:24px;">
        <div class="kwp-feat-card">
          <div class="kwp-feat-icon"><i class="fa fa-pound-sign fa-gbp"></i><i class="fa fa-money"></i></div>
          <h4>Lowest UK Prices</h4>
          <p>Trade-only pricing with guaranteed best rates for registered wholesalers.</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6" style="margin-bottom:24px;">
        <div class="kwp-feat-card">
          <div class="kwp-feat-icon"><i class="fa fa-truck"></i></div>
          <h4>Free Delivery</h4>
          <p>Free nationwide delivery on qualifying orders. Fast dispatch from Hounslow.</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6" style="margin-bottom:24px;">
        <div class="kwp-feat-card">
          <div class="kwp-feat-icon"><i class="fa fa-boxes"></i><i class="fa fa-th-large"></i></div>
          <h4>Huge Stock Range</h4>
          <p>Thousands of products across smoking accessories, electronics, stationery & more.</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6" style="margin-bottom:24px;">
        <div class="kwp-feat-card">
          <div class="kwp-feat-icon"><i class="fa fa-user-check"></i><i class="fa fa-check-circle"></i></div>
          <h4>Easy Registration</h4>
          <p>Register online in minutes and get instant access to wholesale pricing.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Main content + sidebar -->
<div class="kwp-content">
  <div class="container">
    <div class="row">
      <!-- Left content -->
      <div class="col-md-8">
        <div class="kwp-content-box">
          <?php if($h2): ?><h2><?php echo htmlspecialchars($h2); ?></h2><?php endif; ?>
          <?php if($h3): ?><h3><?php echo htmlspecialchars($h3); ?></h3><?php endif; ?>
          <?php if($desc): ?><p><?php echo htmlspecialchars($desc); ?></p><?php endif; ?>
          <?php if(!$h2 && !$h3 && !$desc): ?>
          <h2>Wholesale <?php echo htmlspecialchars($kw['keyword']); ?></h2>
          <p>MMS Wholesale is your trusted UK trade-only supplier based in Hounslow. We supply shopkeepers, off-licences, and retailers with the best wholesale prices on a wide range of products.</p>
          <?php endif; ?>
        </div>

        <div class="kwp-info-cards" style="margin-top:30px;">
          <div class="kwp-info-card">
            <i class="fa fa-check-circle"></i>
            <div>
              <h5>Register for Exclusive Prices</h5>
              <p>Create a free trade account to unlock wholesale pricing, special offers and bulk discounts.</p>
            </div>
          </div>
          <div class="kwp-info-card">
            <i class="fa fa-shipping-fast fa-truck"></i>
            <div>
              <h5>Fast & Free Delivery</h5>
              <p>Order online and receive free delivery straight to your shop or warehouse across the UK.</p>
            </div>
          </div>
          <div class="kwp-info-card">
            <i class="fa fa-tags"></i>
            <div>
              <h5>Best Wholesale Prices</h5>
              <p>We guarantee the lowest trade prices in the UK with no hidden fees or minimum order surprises.</p>
            </div>
          </div>
          <div class="kwp-info-card">
            <i class="fa fa-headset fa-phone"></i>
            <div>
              <h5>Dedicated Trade Support</h5>
              <p>Our team is available Mon–Sat 9am–8pm to help with orders, stock queries and account setup.</p>
            </div>
          </div>
        </div>

        <div style="margin-top:36px;padding:30px;background:linear-gradient(135deg,#fff3ec,#fff8f4);border-radius:14px;border:1px solid #ffd0b0;text-align:center;">
          <h3 style="color:#ff6000;font-weight:800;margin:0 0 10px;">Ready to Start Saving?</h3>
          <p style="color:#666;margin:0 0 20px;">Join hundreds of UK retailers already buying wholesale with MMS.</p>
          <a href="<?php echo base_url('sign-up'); ?>" class="kwp-btn-primary" style="font-size:16px;padding:14px 40px;">
            <i class="fa fa-user-plus"></i> Create Free Trade Account
          </a>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-md-4">
        <div class="kwp-contact-box" style="margin-bottom:24px;">
          <h4><i class="fa fa-phone"></i> Get in Touch</h4>
          <p>Speak to our wholesale team today for pricing and availability.</p>
          <a href="tel:07414560342">07414 560342</a>
        </div>

        <div class="kwp-sidebar-card">
          <h4><i class="fa fa-info-circle" style="color:#ff6000;margin-right:6px;"></i> Quick Info</h4>
          <ul>
            <?php if($loc): ?><li><i class="fa fa-map-marker"></i> Location: <?php echo htmlspecialchars($loc); ?></li><?php endif; ?>
            <li><i class="fa fa-truck"></i> Free delivery available</li>
            <li><i class="fa fa-clock-o"></i> Mon–Sat, 9am–8pm</li>
            <li><i class="fa fa-map-pin"></i> Unit D2, Tamian Way, TW4 6BL</li>
            <li><i class="fa fa-star"></i> 10+ years in wholesale</li>
          </ul>
        </div>

        <?php if(!empty($kw['meta_keywords'])): ?>
        <div class="kwp-sidebar-card">
          <h4><i class="fa fa-tags" style="color:#ff6000;margin-right:6px;"></i> Related Terms</h4>
          <div style="display:flex;flex-wrap:wrap;gap:6px;">
            <?php foreach(array_slice(explode(',', $kw['meta_keywords']), 0, 10) as $tag): $tag = trim($tag); if(!$tag) continue; ?>
            <span style="background:#fff3ec;color:#ff6000;border:1px solid #ffd0b0;border-radius:20px;padding:3px 10px;font-size:12px;"><?php echo htmlspecialchars($tag); ?></span>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <div class="kwp-sidebar-card">
          <h4><i class="fa fa-th-large" style="color:#ff6000;margin-right:6px;"></i> Why MMS Wholesale?</h4>
          <ul>
            <li><i class="fa fa-check"></i> UK trade-only supplier</li>
            <li><i class="fa fa-check"></i> Lowest guaranteed prices</li>
            <li><i class="fa fa-check"></i> 1000s of products in stock</li>
            <li><i class="fa fa-check"></i> Fast nationwide delivery</li>
            <li><i class="fa fa-check"></i> Easy online ordering</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CTA -->
<div class="kwp-cta">
  <div class="container">
    <h2>Start Buying Wholesale Today</h2>
    <p>Register for free and get access to the UK's best trade prices — <?php echo $loc ? 'serving '.htmlspecialchars($loc).' and beyond' : 'nationwide delivery available'; ?>.</p>
    <a href="<?php echo base_url('sign-up'); ?>" class="kwp-btn-primary" style="font-size:16px;padding:15px 44px;margin-right:12px;">
      <i class="fa fa-user-plus"></i> Register Free
    </a>
    <a href="<?php echo base_url('contact-us'); ?>" class="kwp-btn-outline" style="font-size:15px;padding:13px 32px;">
      <i class="fa fa-envelope"></i> Contact Us
    </a>
  </div>
</div>
