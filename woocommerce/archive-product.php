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

$queried_object = get_queried_object();
$isDialogShow = false;
$tagSlug = "";
$categorySlug = "";
if ( $queried_object instanceof WP_Term && 'product_tag' === $queried_object->taxonomy ) {
    // Retrieve the tag slug
        
    $tagSlug = $queried_object->slug;
    $isDialogShow = true;

}
else if ( $queried_object instanceof WP_Term && 'product_cat' === $queried_object->taxonomy){
    $categorySlug = $queried_object->slug;
}
//var_dump($isDialogShow); exit();

?>

<!-- start:  voucher_intro -->
<div class="container voucher_intro ">
    <h1>
        <span class="vertical-reveal-outer">
            <span class="vertical-reveal-inner visible">Buy vouchers</span>
        </span>
    </h1>
   <!--  <p>
        <span class="vertical-reveal-outer">
            <span class="vertical-reveal-inner visible">Buy vouchers for all your favourites with fast digital delivery. </span>
        </span>
    </p> -->
</div>
<!-- end:  voucher_intro -->
<!-- start:  shop_listing -->
<div class="container">
    <div class="shop_listing">
        <div class="side_bar">

            <div class="col_links">
 

            <h5>CATEGORIES</h5>

                <h4 class="mobile-cat-select">
                    
                    <span>
                        <?php include (TEMPLATEPATH . '/images/vouchers/svg/icon_shopall.svg'); ?></span>
                        <a>Shop All</a>
                         <!--  <a href="<?php //echo get_site_url(); ?>/shop-listing">Shop All</a> -->
                    
                </h4>


                <ul>
                    <li <?php if($categorySlug == "" ){?> class="active" <?php } ?>>
                    <span>
                        <?php include (TEMPLATEPATH . '/images/vouchers/svg/icon_shopall.svg'); ?></span>
                        <a href="<?php echo get_site_url(); ?>/shop-listing">Shop All</a>
                    </li>
                    <?php
                    $term_args = array('taxonomy' => 'product_cat', 'exclude' => 45, 'order' => 'ASC');
                    $prod_cats = get_terms( $term_args );
                    foreach ($prod_cats as $prod_cat) { ?>
                    
                        <li <?php if($prod_cat->slug == $categorySlug){?> class="active" <?php } ?>>
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
                    $numTerms = wp_count_terms( 'product_tag',array(
                        'hide_empty'=> true
                    ));
//                    var_dump($numTerms);
                    $prod_args = array('taxonomy' => 'product_tag', 'order' => 'ASC', );

                    
                    
                    if($categorySlug != ""){
                        // global $wpdb;
                        $category = get_term_by('slug', $categorySlug, 'product_cat');
                        // $sql = "
                        //     SELECT t.*, tt.term_taxonomy_id, tt.taxonomy, tt.description, tt.parent, t.term_order 
                        //     FROM {$wpdb->terms} t JOIN {$wpdb->termmeta} tm ON t.term_id = tm.term_id JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id 
                        //     WHERE tt.taxonomy = 'product_tag' AND tm.meta_key = 'tag_category' AND ( tm.meta_value LIKE '%\"{$category->term_id}\"%' )
                        // ";
                        
                        // $prod_tags = $wpdb->get_results( $sql );
                        // $numTerms = count($prod_tags);

                        $prod_args = array(
                            'taxonomy'   => 'product_tag',
                            // 'exclude' => $old_posts,
                            'meta_query' => array(
                                array(
                                    'key'       => 'tag_category',
                                    'value'     => $category->term_id,
                                    'compare'   => 'LIKE'
                                )
                            )
                        );
                        $prod_tags = get_terms( $prod_args);    
                    }
                    else{
                        $prod_tags = get_terms( $prod_args);    
                    }
                    
                    $numTerms = count($prod_tags);
                    $active_terms = array();
                    $term_count = 0;
                    foreach ($prod_tags as $prod_tag) {
                        $term_count ++;

                        if($term_count > 8){
                            break;
                        }

                        $tag_logo = get_field('tag_logo', 'product_tag_'.$prod_tag->term_id);
                        $from_price = get_field('from_price', 'product_tag_'.$prod_tag->term_id);
                        $new = get_field('new', 'product_tag_'.$prod_tag->term_id);
                        if(!$tag_logo){
                            $tag_logo = "https://place-hold.it/474x314?text=Image Pending&italic=true";
                        }
                        $active_terms[] = $prod_tag->term_id;
                        ?>
                        <div class="prod-box-outer">
                            <div class="prod-box">
                                <?php if ($new) { ?>
                                    <div class="new_tag">NEW</div>
                                <?php } ?>
                                <div class="prod-logo">
                                    <img src="<?php echo $tag_logo; ?>" />
                                </div>
                                <h3>
                                    <?php echo $prod_tag->name; ?>
                                </h3>
                                <?php if($prod_tag->description){ ?>
                                    <p><?php echo $prod_tag->description; ?></p>
                                <?php } else { ?>
                                    <p>Custom Voucher</p>
                                <?php } ?>
                                <strong>From R<?php echo $from_price; ?></strong>
                            </div>
                            <div class="add-prod button button-primary" id="<?php echo $prod_tag->term_id; ?>" data-url="/product-tag/<?php echo $prod_tag->slug;?>">Choose Voucher +</div>
                        </div>
                <?php }

               ?>


                <!-- Start: Download -->
                <div class="prod-box-outer img-only" style="background-image:url('<?php bloginfo('stylesheet_directory'); ?>/images/vouchers/covers/cover_downloadapp_new.png')">
                    <a href="https://flash.co.za/app"></a>
                </div>
                <!-- End: -->

                 <!-- Start: Download -->
                <div class="prod-box-outer img-only double-size" style="display:none; background-image:url('<?php bloginfo('stylesheet_directory'); ?>/images/vouchers/covers/cover_downloadapp_new.png')">
                    <a href="https://flash.co.za/app"></a>
                </div>
                <!-- End: -->

            </div>
            <!-- end: shop_list_flex -->
            <!-- start: listing_loadmore -->
            <div class="listing_loadmore">
                <div class="loadmore_txt">You’ve viewed <span class="current-post-count"><?php echo $term_count; ?></span> of <span class="max-post-count"><?php echo $numTerms; ?></span> vouchers</div>
                <div class="loadmore_progress">
                    <div class="progress_box">
                        <div class="progress_complete" style="width:<?php echo ($term_count/$numTerms)*100 ?>%"></div>
                    </div>
                </div>
                <?php if($term_count != $numTerms) { ?>
                    <a class="button button-primary" href="javascript:void(0);" 
                    <?php if($categorySlug != ""){?>data_cat = "<?php echo $category->term_id;?>" <?php }?>
                    onclick="loadMorePosts(<?php echo $term_count; ?>, '<?php echo implode('|',$active_terms); ?>')">Load more</a>
                <?php } ?>
            </div>
            <!-- end: listing_loadmore -->
        </div>
        <!-- start: shop_list -->
    </div>
</div>
<!-- end: shop_listing -->
 
<div class="product-popups" id="prod-popup" <?php echo $isDialogShow ? "" : "style='display: none;'"?>>
    <?php
            $prod_tags = get_terms( 'product_tag' );
            $term_count = 0;
            
            foreach ($prod_tags as $prod_tag) {
//                var_dump($prod_tag);
                $term_count ++;

                if($term_count > 8){
//                    break;
                }

                $tag_logo = get_field('tag_logo', 'product_tag_'.$prod_tag->term_id);
                $tag_content = get_field('popup_content', 'product_tag_'.$prod_tag->term_id);

                if(!$tag_logo){
                    $tag_logo = "https://place-hold.it/345x229?text=Image Pending&italic=true";
                }
                // Get the queried object
                
                // Check if it's a WP_Term object representing a product tag
                
        ?>
        <div class="prod-info-popup" data-popup="<?php echo $prod_tag->term_id; ?>" <?php echo $tagSlug === $prod_tag->slug ? "":  'style="display: none"' ; ?>>
        <div class="image-column">
            <img class="prod-logo" src="<?php echo $tag_logo; ?>" />
        </div>
        <div class="product-info-column">
            <h2>
                <?php echo $prod_tag->name; ?>
            </h2>
            <!-- start static html -->
            <?php if($prod_tag->description){ ?>
                <h5><?php echo $prod_tag->description; ?></h5>
            <?php } else { ?>
                <h5>Custom Voucher</h5>
            <?php } ?>
            <div class="voucher_details_block">
                <h6>Details</h6>
                <div class="detail_list_voucher">
                   <?php echo $tag_content; ?>
                </div>
            </div>
            <div class="voucher_select_amount">
                <strong>Select voucher amount</strong>
            </div>
            <div class="voucher_select_amount pop-validation" style="display: none;">
                <strong style="color:red;">Please select an option</strong>
            </div>
            <div class="voucher_select_amount pop-validation-amount-range" style="display: none;">
                <strong style="color:red;">Please enter amount between R50-R4000</strong>
            </div>
            <div class="voucher_select_amount pop-validation-amount-limit" style="display: none;">
                <strong style="color:red;" class="cart-totals">Cart may not exceed R7,000.  Current cart total:&nbsp;<span class="total-amount"><?php echo WC()->cart->get_total(); ?></span></strong>
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
                        $name =   $prod_tag->slug;
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
                                    <input type="radio" name="Prod<?php echo get_the_ID(); ?>" id="<?php echo $name.$custom_price['prices']; ?>" value="<?php echo $custom_price['prices']; ?>">
                                    <label for="<?php echo $name.$custom_price['prices']; ?>">
                                        <span><?php echo $custom_price['label']; ?></span>
                                    </label>
                                <?php } ?>
                                <div class="custom_amt">
                                    <h5>Or enter own amount</h5>
                                </div>
                                <div class="custom_amt_input">
                                    <input placeholder="Own Amount" class="nameYP" name="your_price" type="number">
                                    <span>Min R50, Max R4000.</span>
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
                        <button type="submit" class="add-prod-ajax">Add to Cart</button>
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
        <button type="submit" class="add-prod-ajax">Add to Cart</button>
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