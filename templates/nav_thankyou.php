<div id="navigation" class="page-nav-cart">
    <div class="container flex">
        <div class="site-logo">
            <a href="<?php echo get_option('home'); ?>/">
                <?php include (TEMPLATEPATH . '/images/logo2022.svg'); ?></a>
        </div>
        <div class="site-logo-mobile">
            <a href="<?php echo get_option('home'); ?>/">
                <?php include (TEMPLATEPATH . '/images/vouchers/svg/mobile_logo.svg'); ?>
            </a>
        </div>
        <!-- start: cart_nav -->
        <div class="cart_nav desktop">
            <a href="<?php echo get_option('home'); ?>/" class="btn_exitcheckout">
                <span>exit checkout</span>
                <?php include (TEMPLATEPATH . '/images/vouchers/svg/icon_close.svg'); ?>
            </a>
        </div>
        <!-- end: cart_nav -->
    </div>
</div>