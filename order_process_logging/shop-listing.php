<?php
/*
    Template Name: Shop Listing
*/
get_header();
$detect = new Mobile_Detect;
$terms = get_terms( 'product_tag' );
$term_array = array();
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
        $term_array[] = $term->name;
    }
}
?>

<!-- start:  voucher_intro -->
<div class="container voucher_intro ">
    <h1>
        <span class="vertical-reveal-outer">
            <span class="vertical-reveal-inner visible">Buy vouchers</span>
        </span>
    </h1>
    <p>
        <span class="vertical-reveal-outer">
            <span class="vertical-reveal-inner visible">Buy vouchers for all your favourites with fast digital delivery. </span>
        </span>
    </p>
</div>
<!-- end:  voucher_intro -->
<!-- start:  shop_listing -->
<div class="container">
    <div class="shop_listing">
        <div class="side_bar">

            <div class="col_links">
 

            <h4>CATEGORIES</h4>
                <ul>
                    <li>
                    <span>
                        <?php include (TEMPLATEPATH . '/images/vouchers/svg/icon_shopall.svg'); ?></span>
                        <a href="<?php echo get_site_url(); ?>/shop-listing">Shop All</a>
                    </li>
                    <?php
                    $term_args = array('taxonomy' => 'product_cat', 'exclude' => 45);
                    $prod_cats = get_terms( $term_args );
                    foreach ($prod_cats as $prod_cat) { ?>
                        <li>
                            <span>
                                <?php echo get_field('product_category_icon', 'product_cat_'.$prod_cat->term_id); ?>
                            </span>
                            <a href="<?php echo get_term_link($prod_cat->term_id); ?>"><?php echo $prod_cat->name; ?></a>
                        </li>
                    <?php }
                    ?>
                </ul>
            </div>

        </div>
        <!-- start: shop_list -->
        <div class="shop_list">
            <div class="prods"></div>
            <!-- start: shop_list_flex -->
            <div class="shop_list_flex">
                <?php
                    $numTerms = wp_count_terms( 'product_tag');
                    $prod_args = array('taxonomy' => 'product_tag');
                    $prod_tags = get_terms( $prod_args);

                    $term_count = 0;
                    foreach ($prod_tags as $prod_tag) {
                        $term_count ++;

                        if($term_count > 8){
                            break;
                        }

                        $tag_logo = get_field('tag_logo', 'product_tag_'.$prod_tag->term_id);
                        $from_price = get_field('from_price', 'product_tag_'.$prod_tag->term_id);
                        if(!$tag_logo){
                            $tag_logo = "https://place-hold.it/474x314?text=Image Pending&italic=true";
                        }
                        ?>
                        <div class="prod-box-outer">
                            <div class="prod-box">
                                <div class="new_tag">NEW</div>
                                <div class="prod-logo">
                                    <img src="<?php echo $tag_logo; ?>" />
                                </div>
                                <h3>
                                    <?php echo $prod_tag->name; ?>
                                </h3>
                                <p>  <?php echo $prod_tag->description; ?></p>
                                <strong>From R<?php echo $from_price; ?></strong>
                            </div>
                            <div class="add-prod button button-primary" id="<?php echo $prod_tag->term_id; ?>">Choose Voucher +</div>
                        </div>
                <?php }

               ?>


                <!-- Start: Download -->
                <div class="prod-box-outer img-only" style="background-image:url('<?php bloginfo('stylesheet_directory'); ?>/images/vouchers/covers/cover_downloadapp_new.png')">
                    <a href="<?php bloginfo('url'); ?>/oneforyou-app/"></a>
                </div>
                <!-- End: -->

                 <!-- Start: Download -->
                <div class="prod-box-outer img-only double-size" style="display:none; background-image:url('<?php bloginfo('stylesheet_directory'); ?>/images/vouchers/covers/cover_downloadapp_new.png')">
                    <a href="<?php bloginfo('url'); ?>/oneforyou-app/"></a>
                </div>
                <!-- End: -->

            </div>
            <!-- end: shop_list_flex -->
            <!-- start: listing_loadmore -->
            <div class="listing_loadmore">
                <div class="loadmore_txt">You’ve viewed <?php echo $term_count-1; ?> of <?php echo $numTerms; ?> vouchers</div>
                <div class="loadmore_progress">
                    <div class="progress_box">
                        <div class="progress_complete" style="width:<?php echo ($term_count/$numTerms)*100 ?>%"></div>
                    </div>
                </div>
                <?php if($term_count != $numTerms) { ?>
                    <a class="button button-primary" href="javascript:void(0);" onclick="loadMorePosts(<?php echo $term_count; ?>)">Load more</a>
                <?php } ?>
            </div>
            <!-- end: listing_loadmore -->
        </div>
        <!-- start: shop_list -->
    </div>
</div>
<!-- end: shop_listing -->
<div class="product-popups" style="display: none;">
    <?php
            $prod_tags = get_terms( 'product_tag' );
            $term_count = 0;
            foreach ($prod_tags as $prod_tag) {
                $term_count ++;

                if($term_count > 8){
//                    break;
                }

                $tag_logo = get_field('tag_logo', 'product_tag_'.$prod_tag->term_id);
                if(!$tag_logo){
                    $tag_logo = "https://place-hold.it/345x229?text=Image Pending&italic=true";
                }
        ?>
        <div class="prod-info-popup" data-popup="<?php echo $prod_tag->term_id; ?>" style="display: none">
        <div class="image-column">
            <img class="prod-logo" src="<?php echo $tag_logo; ?>" />
        </div>
        <div class="product-info-column">
            <h2>
                <?php echo $prod_tag->name; ?>
            </h2>
            <!-- start static html -->
            <h5>Custom voucher</h5>
            <div class="voucher_details_block">
                <h6>Details</h6>
                <div class="detail_list_voucher">
                    <ul>
                        <li>Delivered via email or SMS after purchase.</li>
                        <li>Choose delivery method for each voucher during checkout.</li>
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                    </ul>
                </div>
            </div>
            <div class="voucher_select_amount">
                <strong>Select voucher amount</strong>
            </div>
            <!-- end static html -->
            <form class="prodAddForm" method="POST" action="">
            <?php

                    $args = array('post_type' => 'product', 'order' => 'ASC', 'orderby' => 'meta_value_num',
                        'meta_key' => '_price','product_tag' => $prod_tag->slug);

                    $loop = new WP_Query($args);

                    while ($loop->have_posts()) : $loop->the_post();
                        $product = wc_get_product( get_the_ID() );

                        $has_custom_price = get_field('name_your_price', get_the_ID());
                        $price_name = get_field('product_front_end_name', get_the_ID());
                        $name =  strtolower(str_replace(' ', '_', get_the_title()));
                        if(!$has_custom_price) { ?>
                        <input type="radio" id="<?php echo $name; ?>" name="selected_prod" value="<?php echo get_the_ID(); ?>">
                            <?php if($price_name) { ?>
                                <label for="<?php echo $name; ?>"><span><?php echo $price_name . ' - R' . $product->get_price(); ?></span></label>
                            <?php } else { ?>
                                <label for="<?php echo $name; ?>"><span>R<?php echo $product->get_price(); ?></span></label>
                            <?php } ?>

                <?php } else {
                                $custom_prices = get_field('custom_prices', get_the_ID()); ?>
                <div class="custom-price-select">
                    <?php foreach ($custom_prices as $custom_price) { ?>
                    <input type="radio" name="Prod<?php echo get_the_ID(); ?>" id="<?php echo $custom_price['prices']; ?>" value="<?php echo $custom_price['prices']; ?>">
                    <label for="<?php echo $custom_price['prices']; ?>"><span>
                            <?php echo $price_name; ?></span></label>
                    <?php } ?>
                    <div class="custom_amt">
                        <h5>Or enter custom amount</h5>
                    </div>
                    <div class="custom_amt_input">
                        <input placeholder="Custom Amount" class="nameYP" name="your_price" type="number">
                        <span>Min R170, max R1000.</span>
                    </div>
                    <input name="selected_prod" value="<?php echo get_the_ID(); ?>" type="hidden">
                </div>
                <?php } ?>
                <?php endwhile; ?>
                <div class="voucher_addcart">
                    <div class="voucher_counter">
                        <!-- start: number_spinner -->
                        <div class="number_spinner">
                            <span class="ns-btn">
                                <a data-dir="dwn">
                                    <?php include (TEMPLATEPATH . '/images/vouchers/svg/spinner_minus.svg'); ?></a>
                            </span>
                            <!--  <input type="number" id="quantity" name="quantity" min="0" max="10000"> -->
                            <input type="number" class="pl-ns-value" value="1" id="quantity" name="quantity" min="0" max="10000">
                            <span class="ns-btn">
                                <a data-dir="up">
                                    <?php include (TEMPLATEPATH . '/images/vouchers/svg/spinner_plus.svg'); ?></a>
                            </span>
                        </div>
                        <!-- end: number_spinner -->
                        <input type="hidden" name="addToCart" value="yes">
                    </div>
                    <div class="voucher_btn">
                        <button type="submit" class="add-prod add-prod-ajax">Add to Cart</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="close-pop">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="0.707031" width="24" height="1" transform="rotate(45 0.707031 0)" fill="black" />
                <rect y="16.9707" width="24" height="1" transform="rotate(-45 0 16.9707)" fill="black" />
            </svg>
        </div>
    </div>
    <?php }

    ?>
</div>




<!-- start:  voucher_addcart fixed_mobile -->
<div class="voucher_addcart fixed_mobile" style="display: none;">
    <div class="voucher_counter">
        <!-- start: number_spinner -->
        <div class="number_spinner">
            <span class="ns-btn">
                <a data-dir="dwn">
                    <?php include (TEMPLATEPATH . '/images/vouchers/svg/spinner_minus.svg'); ?></a>
            </span>
            <!--  <input type="number" id="quantity" name="quantity" min="0" max="10000"> -->
            <input type="number" class="pl-ns-value" value="1" id="quantity" name="quantity" min="0" max="10000">
            <span class="ns-btn">
                <a data-dir="up">
                    <?php include (TEMPLATEPATH . '/images/vouchers/svg/spinner_plus.svg'); ?></a>
            </span>
        </div>
        <!-- end: number_spinner -->
        <input type="hidden" name="addToCart" value="yes">
    </div>
    <div class="voucher_btn">
        <button type="submit" class="add-prod add-prod-ajax">Add to Cart</button>
    </div>
</div>
<!-- end:  voucher_addcart fixed_mobile -->

<!-- start: fixed_back -->
<div class="fixed_shadow" style="display: none;"></div>
<div class="fixed_back" style="display: none;">
    <a href=""><?php include (TEMPLATEPATH . '/images/vouchers/svg/icon_back.svg'); ?></a>
    <h3>Netflix</h3>
    <a href=""><?php include (TEMPLATEPATH . '/images/vouchers/svg/icon_close.svg'); ?></a>
</div>
<!-- end: fixed_back -->



<?php

    if($_POST['addToCart'] == 'yes') {

        WC()->cart->add_to_cart( $_POST['selected_prod'], $_POST['quantity'],0,array(),array('custom_price' => $_POST['your_price']) );

    }

?>
<!-- start: voucher_added_cart -->
<div class="voucher_added_cart" style="display: none;">
    <div class="v_added_top">
        <button class="close_pop">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="0.707031" width="24" height="1" transform="rotate(45 0.707031 0)" fill="black" />
                <rect y="16.9707" width="24" height="1" transform="rotate(-45 0 16.9707)" fill="black" />
            </svg>
        </button>
        <div class="v_top_logo">
            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/vouchers/covers/cover_netflix.png" alt="">
        </div>
        <div class="v_top_info">
            <h5>Voucher added to cart</h5>
            <span class="popup-voucher-name">Netflix Custom Voucher</span>
        </div>
    </div>
    <div class="v_added_btns">
        <button class="btn_view">View cart</button>
        <button class="btn_checkout">checkout</button>
    </div>
</div>
<!-- end: voucher_added_cart -->



<?php get_footer(); ?>