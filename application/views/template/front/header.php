<?php
$logginUserArr = $this->session->userdata('front_logged_in');
$pageSlug = $this->uri->segment('1');
$userId = $logginUserArr ? $logginUserArr['id'] : '';
$cartProductArr = getUserCartProduct($userId);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php
    if(!empty($productDetails) && !empty($productDetails['meta_title'])) echo htmlspecialchars($productDetails['meta_title']).' | '.SITE_NAME;
    elseif(isset($pageTitle)) echo $pageTitle.' | '.SITE_NAME;
    else echo SITE_NAME;
    ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/img/demos/shop/logo-shop.png'); ?>" type="image/x-icon">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php if(!empty($productDetails)): $seo = $productDetails; ?>
<?php elseif(!empty($kw)): $seo = $kw; ?>
<?php endif; ?>
<?php if(!empty($seo)): ?>
<?php if(!empty($seo['meta_description'])): ?><meta name="description" content="<?php echo htmlspecialchars($seo['meta_description']); ?>"><?php endif; ?>
<?php if(!empty($seo['meta_keywords'])): ?><meta name="keywords" content="<?php echo htmlspecialchars($seo['meta_keywords']); ?>"><?php endif; ?>
<?php if(!empty($seo['meta_heading'])): ?><meta name="heading" content="<?php echo htmlspecialchars($seo['meta_heading']); ?>"><?php endif; ?>
<?php if(!empty($seo['robots'])): ?><meta name="robots" content="<?php echo htmlspecialchars($seo['robots']); ?>"><?php endif; ?>
<?php if(!empty($seo['revisit_after'])): ?><meta name="revisit-after" content="<?php echo htmlspecialchars($seo['revisit_after']); ?>"><?php endif; ?>
<?php if(!empty($seo['author'])): ?><meta name="author" content="<?php echo htmlspecialchars($seo['author']); ?>"><?php endif; ?>
<?php if(!empty($seo['subject'])): ?><meta name="subject" content="<?php echo htmlspecialchars($seo['subject']); ?>"><?php endif; ?>
<?php if(!empty($seo['owner'])): ?><meta name="owner" content="<?php echo htmlspecialchars($seo['owner']); ?>"><?php endif; ?>
<?php if(!empty($seo['coverage'])): ?><meta name="coverage" content="<?php echo htmlspecialchars($seo['coverage']); ?>"><?php endif; ?>
<?php if(!empty($seo['language'])): ?><meta name="language" content="<?php echo htmlspecialchars($seo['language']); ?>"><?php endif; ?>
<?php if(!empty($seo['distribution'])): ?><meta name="distribution" content="<?php echo htmlspecialchars($seo['distribution']); ?>"><?php endif; ?>
<?php if(!empty($seo['country'])): ?><meta name="country" content="<?php echo htmlspecialchars($seo['country']); ?>"><?php endif; ?>
<?php if(!empty($seo['cache_control'])): ?><meta name="cache-control" content="<?php echo htmlspecialchars($seo['cache_control']); ?>"><?php endif; ?>
<?php if(!empty($seo['geo_region'])): ?><meta name="geo.region" content="<?php echo htmlspecialchars($seo['geo_region']); ?>"><?php endif; ?>
<?php if(!empty($seo['geo_place_name'])): ?><meta name="geo.placename" content="<?php echo htmlspecialchars($seo['geo_place_name']); ?>"><?php endif; ?>
<?php if(!empty($seo['geo_position'])): ?><meta name="geo.position" content="<?php echo htmlspecialchars($seo['geo_position']); ?>"><?php endif; ?>
<?php if(!empty($seo['icbm'])): ?><meta name="ICBM" content="<?php echo htmlspecialchars($seo['icbm']); ?>"><?php endif; ?>
<?php if(!empty($seo['og_locale'])): ?><meta property="og:locale" content="<?php echo htmlspecialchars($seo['og_locale']); ?>"><?php endif; ?>
<?php if(!empty($seo['og_type'])): ?><meta property="og:type" content="<?php echo htmlspecialchars($seo['og_type']); ?>"><?php endif; ?>
<?php $ogTitle = !empty($seo['og_title']) ? $seo['og_title'] : (!empty($seo['meta_title']) ? $seo['meta_title'] : $seo['product_name']); ?>
<meta property="og:title" content="<?php echo htmlspecialchars($ogTitle); ?>">
<?php $ogUrl = !empty($seo['og_url']) ? $seo['og_url'] : current_url(); ?>
<meta property="og:url" content="<?php echo htmlspecialchars($ogUrl); ?>">
<?php if(!empty($seo['og_site_name'])): ?><meta property="og:site_name" content="<?php echo htmlspecialchars($seo['og_site_name']); ?>"><?php endif; ?>
<?php if(!empty($seo['og_description'])): ?><meta property="og:description" content="<?php echo htmlspecialchars($seo['og_description']); ?>"><?php endif; ?>
<?php $ogImg = !empty($seo['og_image']) ? $seo['og_image'] : (!empty($seo['image']) ? SHOW_PRODUCT_PATH.$seo['image'] : ''); ?>
<?php if($ogImg): ?><meta property="og:image" content="<?php echo htmlspecialchars($ogImg); ?>"><?php endif; ?>
<?php if(!empty($seo['og_tag'])): ?><meta property="og:tag" content="<?php echo htmlspecialchars($seo['og_tag']); ?>"><?php endif; ?>
<?php if(!empty($seo['twitter_site'])): ?><meta name="twitter:card" content="summary_large_image"><meta name="twitter:site" content="<?php echo htmlspecialchars($seo['twitter_site']); ?>"><?php endif; ?>
<?php if(!empty($seo['twitter_description'])): ?><meta name="twitter:description" content="<?php echo htmlspecialchars($seo['twitter_description']); ?>"><?php endif; ?>
<?php if(!empty($seo['instagram'])): ?><meta name="instagram" content="<?php echo htmlspecialchars($seo['instagram']); ?>"><?php endif; ?>
<?php if(!empty($seo['facebook'])): ?><meta name="facebook" content="<?php echo htmlspecialchars($seo['facebook']); ?>"><?php endif; ?>
<?php if(!empty($seo['youtube'])): ?><meta name="youtube" content="<?php echo htmlspecialchars($seo['youtube']); ?>"><?php endif; ?>
<?php $canonical = !empty($seo['canonical']) ? $seo['canonical'] : current_url(); ?>
<link rel="canonical" href="<?php echo htmlspecialchars($canonical); ?>">
<?php endif; ?>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/animate/animate.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/simple-line-icons/css/simple-line-icons.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/owl.carousel/assets/owl.carousel.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/owl.carousel/assets/owl.theme.default.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/magnific-popup/magnific-popup.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/theme.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/theme-elements.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/theme-blog.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/theme-shop.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/rs-plugin/css/settings.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/rs-plugin/css/layers.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/rs-plugin/css/navigation.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/skins/skin-shop-5.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/demos/demo-shop-5.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css'); ?>">
    <script src="<?php echo base_url('assets/vendor/modernizr/modernizr.min.js'); ?>"></script>
</head>

<div class="body">
    <header id="header" data-plugin-options='{"stickyEnabled": false}'>
        <div class="header-body" id="siteHeader">
            <div class="header-top">
                <div class="container">
                    <div class="dropdowns-container">
                        <div class="header-column">
                            <div class="header-logo">
                                <a href="<?php echo base_url(); ?>">
                                    <img alt="<?php echo SITE_NAME; ?>" width="111" height="51" src="<?php echo base_url('assets/images/img/demos/shop/logo-shop.png'); ?>">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="top-menu-area">
                        <a href="#">Links <i class="fa fa-caret-down"></i></a>
                        <ul class="top-menu">
                            <?php if($logginUserArr): ?>
                            <li><a href="<?php echo base_url('my-account'); ?>">My Account</a></li>
                            <li><a href="<?php echo base_url('wish-list'); ?>">My Wishlist</a></li>
                            <li><a href="<?php echo base_url('sign-out'); ?>">Log Out</a></li>
                            <?php endif; ?>
                            <li><a href="tel:07414560342" style="color:#ccc;"><i class="fa fa-phone" style="color:#ff6000;margin-right:4px;"></i>07414 560342</a></li>
                            <div class="cart-dropdown">
                                <a href="<?php echo base_url('cart-list'); ?>" class="cart-dropdown-icon">
                                    <i class="minicart-icon"></i>
                                    <span class="cart-info">
                                        <span class="cart-qty"><?php echo count($cartProductArr); ?></span>
                                        <span class="cart-text">item(s)</span>
                                    </span>
                                </a>
                            </div>
                        </ul>
                    </div>
                    <?php if($logginUserArr): ?>
                    <p class="welcome-msg"><i class="fa fa-user-circle" style="color:#ff6000;"></i> WELCOME <?php echo strtoupper($logginUserArr['first_name'].' '.$logginUserArr['last_name']); ?> &nbsp;|&nbsp; <a href="<?php echo base_url('wholesale'); ?>" class="welcome-wholesale-btn">Wholesale</a></p>
                    <?php else: ?>
                    <p class="welcome-msg"><i class="fa fa-user-circle" style="color:#ff6000;"></i> WELCOME GUEST &nbsp;|&nbsp; <a href="<?php echo base_url('sign-in'); ?>">Login</a> &nbsp;|&nbsp; <a href="<?php echo base_url('wholesale'); ?>" class="welcome-wholesale-btn">Wholesale</a></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="header-container container">
                <div class="header-row">
                    <div class="header-column">
                        <div class="row">
                            <div class="cart-area">
                                <div class="custom-block">
                                    <i class="fa fa-phone" style="display:none;"></i>
                                </div>
                            </div>
                            <a href="#" class="mmenu-toggle-btn" title="Toggle menu">
                                <i class="fa fa-bars"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header-container header-nav">
                <div class="container">
                    <div class="header-nav-main">
                        <nav>
                            <ul class="nav nav-pills" id="mainNav">
                                <li class="dropdown <?php echo $pageSlug==''?'active':''; ?>">
                                    <a href="<?php echo base_url(); ?>">Home</a>
                                </li>
                                <li class="<?php echo $pageSlug=='all-products'?'active':''; ?>">
                                    <a href="<?php echo base_url('all-products'); ?>">Shop</a>
                                </li>
                                <?php if(!empty($isActiveCategories)): foreach($isActiveCategories as $cat): ?>
                                <li class="dropdown dropdown-mega-small <?php echo ($pageSlug=='categories'&&$this->uri->segment(2)==$cat->category_slug)?'active':''; ?>">
                                    <a href="<?php echo base_url('categories/'.$cat->category_slug); ?>" class="dropdown-toggle"><?php echo $cat->category_name; ?> <i class="fa fa-angle-down nav-arrow"></i></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="dropdown-mega-content dropdown-mega-content-small">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                        <?php
                                                        $children = getCategoryChildren($cat->id);
                                                        if(!empty($children)):
                                                            $i = 0;
                                                            foreach($children as $child):
                                                                if($i % 10 == 0) echo '<div class="col-md-4"><ul class="dropdown-mega-sub-nav">';
                                                                $grandchildren = getCategoryChildren($child->id);
                                                        ?>
                                                        <li class="nav-sub-item<?php echo !empty($grandchildren) ? ' has-sub' : ''; ?>">
                                                            <div class="nav-sub-row">
                                                                <a href="<?php echo base_url('categories/'.$child->category_slug); ?>" class="nav-sub-link"><?php echo $child->category_name; ?></a>
                                                                <?php if(!empty($grandchildren)): ?><span class="nav-sub-toggle"><i class="fa fa-angle-down nav-sub-arrow"></i></span><?php endif; ?>
                                                            </div>
                                                            <?php if(!empty($grandchildren)): ?>
                                                            <ul class="nav-grandchild-list">
                                                            <?php foreach($grandchildren as $gc): ?>
                                                            <li><a href="<?php echo base_url('categories/'.$gc->category_slug); ?>"><?php echo $gc->category_name; ?></a></li>
                                                            <?php endforeach; ?>
                                                            </ul>
                                                            <?php endif; ?>
                                                        </li>
                                                        <?php
                                                                $i++;
                                                                if($i % 10 == 0) echo '</ul></div>';
                                                            endforeach;
                                                            if($i % 10 != 0) echo '</ul></div>';
                                                        endif;
                                                        ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <?php endforeach; endif; ?>
                                <li class="nav-contact-us <?php echo $pageSlug=='contact-us'?'active':''; ?>">
                                    <a href="<?php echo base_url('contact-us'); ?>">Contact Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Nav -->
    <div class="mobile-nav">
        <div class="mobile-nav-wrapper">
            <ul class="mobile-side-menu">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li><a href="<?php echo base_url('all-products'); ?>">Shop</a></li>
                <?php if(!empty($isActiveCategories)): foreach($isActiveCategories as $cat): ?>
                <?php $children = getCategoryChildren($cat->id); ?>
                <li<?php if(!empty($children)): ?> class="has-children"<?php endif; ?>>
                    <?php if(!empty($children)): ?><span class="mmenu-toggle"></span><?php endif; ?>
                    <a href="<?php echo base_url('categories/'.$cat->category_slug); ?>"><?php echo $cat->category_name; ?></a>
                    <?php if(!empty($children)): ?>
                    <ul>
                        <?php foreach($children as $child): ?>
                        <?php $grandchildren = getCategoryChildren($child->id); ?>
                        <li<?php if(!empty($grandchildren)): ?> class="has-children"<?php endif; ?>>
                            <?php if(!empty($grandchildren)): ?><span class="mmenu-toggle"></span><?php endif; ?>
                            <a href="<?php echo base_url('categories/'.$child->category_slug); ?>"><?php echo $child->category_name; ?></a>
                            <?php if(!empty($grandchildren)): ?>
                            <ul>
                                <?php foreach($grandchildren as $gc): ?>
                                <li><a href="<?php echo base_url('categories/'.$gc->category_slug); ?>"><?php echo $gc->category_name; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php endforeach; endif; ?>
                <li><a href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
            </ul>
        </div>
    </div>
    <div id="mobile-menu-overlay"></div>

    <?php echo $this->session->flashdata('success') ? '<div class="container" style="margin-top:10px;"><div class="alert alert-success">'.$this->session->flashdata('success').'</div></div>' : ''; ?>
    <?php echo $this->session->flashdata('error') ? '<div class="container" style="margin-top:10px;"><div class="alert alert-danger">'.$this->session->flashdata('error').'</div></div>' : ''; ?>

<div role="main" class="main">
