<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        <?php bloginfo('name'); ?>
        <?php wp_title('|', true, 'left'); ?>
    </title>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="SKYPE_TOOLBAR" CONTENT="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
    <!--[if lt IE 9]><script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.png?v=<?php echo time(); ?>" type="image/x-icon">
    <link rel="icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.png?v=<?php echo time(); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/dist/css/main.css?v=<?php echo time(); ?>">
    <?php wp_head(); ?>
    <?php if( get_field('add_to_head','options') ): ?>
    <?php the_field('add_to_head','options'); ?>
    <?php endif; ?>
</head>
<?php
$body_class = "";
if (is_post_type_archive('support')) {
 	$body_class = "support-body";
}
 else if(is_page('about')){
	$body_class = "about-body";
}
 else if(is_page('cart')){
    $body_class = "cart-page";
}
 else if(is_page('checkout')){
    $body_class = "checkout-page";
}
else if(is_page('oneforyou-app')){
	$body_class = "oneforyouapp-body";
} ?>

<body id="page" class="<?php echo $body_class; ?>">
    <?php if( get_field('add_inside_body_tag','options') ): ?>
    <?php the_field('add_inside_body_tag','options'); ?>
    <?php endif; ?>
    <?php //include (TEMPLATEPATH . '/templates/preloader.php'); ?>
    <?php
    if (is_page('cart') ||  is_page('checkout') ) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        if (strpos($url,'checkout/order-received') !== false) {
            include (TEMPLATEPATH . '/templates/nav_thankyou.php');
        } else {
            include (TEMPLATEPATH . '/templates/nav_cart.php');
        }

    }
    if (!is_page('sign-up-thank-you') && !is_page('cart') && !is_page('checkout')) {
        include (TEMPLATEPATH . '/templates/nav.php');
    }
    ?>