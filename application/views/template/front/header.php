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
    <title><?php echo isset($pageTitle) ? $pageTitle.' | '.SITE_NAME : SITE_NAME; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/img/demos/shop/logo-shop.png'); ?>" type="image/x-icon">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
                                                        <div class="nav-cat-header">
                                                            <i class="fa fa-th-list"></i>
                                                            <a href="<?php echo base_url('categories/'.$cat->category_slug); ?>"><?php echo $cat->category_name; ?></a>
                                                        </div>
                                                        <div class="row">
                                                        <?php
                                                        $children = getCategoryChildren($cat->id);
                                                        if(!empty($children)):
                                                            $i = 0;
                                                            foreach($children as $child):
                                                                if($i % 10 == 0) echo '<div class="col-md-4"><ul class="dropdown-mega-sub-nav">';
                                                        ?>
                                                        <li>
                                                            <a href="<?php echo base_url('categories/'.$child->category_slug); ?>"><?php echo $child->category_name; ?></a>
                                                            <?php
                                                            $grandchildren = getCategoryChildren($child->id);
                                                            if(!empty($grandchildren)):
                                                            ?>
                                                            <ul class="dropdown-mega-sub-nav" style="padding-left:10px;">
                                                            <?php foreach($grandchildren as $gc): ?>
                                                            <li><a href="<?php echo base_url('categories/'.$gc->category_slug); ?>" style="font-size:12px;color:#888;"><i class="fa fa-angle-right"></i> <?php echo $gc->category_name; ?></a></li>
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
                <li>
                    <span class="mmenu-toggle"></span>
                    <a href="<?php echo base_url('categories/'.$cat->category_slug); ?>"><?php echo $cat->category_name; ?></a>
                    <?php $children = getCategoryChildren($cat->id); if(!empty($children)): ?>
                    <ul>
                        <?php foreach($children as $child): ?>
                        <li>
                            <span class="mmenu-toggle"></span>
                            <a href="<?php echo base_url('categories/'.$child->category_slug); ?>"><?php echo $child->category_name; ?></a>
                            <?php $grandchildren = getCategoryChildren($child->id); if(!empty($grandchildren)): ?>
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
