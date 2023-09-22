<?php

	require_once "libs/Mobile_Detect.php";


	/*
	 *	WP HOOK THINGS
	 */

	// acf disable hiding of custom fields
	add_filter('acf/settings/remove_wp_meta_box', '__return_false');


	// saves acf fields to json files in template
	add_filter('acf/settings/save_json', 'my_acf_json_save_point');
	function my_acf_json_save_point( $path ) {
		$path = get_stylesheet_directory() . '/acf-json';
		return $path;
	}


	function order_request_filter($order_request, $order_id) {

		// $order = wc_get_order( $order_id );
		// mail('gerhard@ninjasforhire.co.za', 'order', print_r($order, true));


//		global $woocommerce;
//    	$items = $woocommerce->cart->get_cart();

        $order = wc_get_order( $order_id );
        $items = $order->get_items();

        foreach( $items as $item ){
            $order_prod = $item->get_product();
            if($order_prod->get_sku() == 'TESTING') {
                var_dump('yes');
                $order_request['customParameters[elecID]'] = 'Vending_'.$order_id;
            } else {
                var_dump('no');
                $order_request['customParameters[1foryouID]'] = 'Vending_'.$order_id;
            }
        }
//die();
//    	mail('philip@ninjasforhire.co.za', 'items', print_r($order_request, true));

		return $order_request;
	}
	add_filter( 'order_request_filter', 'order_request_filter', 10, 2 );


	// add acf options page
	if( function_exists('acf_add_options_page') ) {
		// add parent
		$parent = acf_add_options_page(array(
			'page_title' 	=> 'Options',
			'menu_title' 	=> 'Site Options',
			'redirect' 		=> false
		));
	}


	// remove block library css
	function smartwp_remove_wp_block_library_css(){
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
	}
	add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );


	// dequeue scripts
	function nfh_dequeue_script() {
		wp_dequeue_script( 'jquery' );
	}
	add_action( 'wp_print_scripts', 'nfh_dequeue_script', 100 );


	// add woocommerce support
	function nfh_add_woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}
	add_action( 'after_setup_theme', 'nfh_add_woocommerce_support' );



	/*
	 *	1FORYOU
	 */

	// remove address fields from checkout
	function ninja_products_less_fields( $fields ) {

//		unset($fields['billing']['billing_first_name']);
//		unset($fields['billing']['billing_last_name']);
//		unset($fields['billing']['billing_email']);
		unset($fields['billing']['billing_company']);
		unset($fields['billing']['billing_address_1']);
		unset($fields['billing']['billing_address_2']);
		unset($fields['billing']['billing_city']);
		unset($fields['billing']['billing_postcode']);
		unset($fields['billing']['billing_country']);
		unset($fields['billing']['billing_state']);
		unset($fields['billing']['billing_phone']);

		// remove ship to a diffirent address
		add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false');

		//Removes Additional Info title and Order Notes
		add_filter( 'woocommerce_enable_order_notes_field', '__return_false',9999 );

	    return $fields;

	}
	add_filter( 'woocommerce_checkout_fields' , 'ninja_products_less_fields' );


	// only specific payment gateways per specific products
	function conditional_payment_gateways( $available_gateways ) {

		global $nf;

		if ( is_admin() ) {
			return $available_gateways;
		}

		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

			$prod_variable = $prod_simple = $prod_subscription = false;
			$product = wc_get_product($cart_item['product_id']);

			if ( $product->get_slug() == 'electricity-voucher' ) {
				unset($available_gateways['peach-payments']);
			}
			if ( $product->get_slug() == '1foryou-voucher' ) {
				unset($available_gateways['1foryou_gateway']);
			}
		}

	    return $available_gateways;
	}
	//add_filter('woocommerce_available_payment_gateways', 'conditional_payment_gateways', 10, 1);


	// hide additional info on product
	function nfh_hide_wp_head() {

		if ( is_product() ) {
		    ?><style type="text/css">.quantity, .buttons_added, .product_title, .woocommerce-product-gallery, .product_meta, .reset_variations, p.price { width:0; height:0; display: none !important; visibility: hidden; }</style><?php
		}
	}
	add_action( 'wp_head', 'nfh_hide_wp_head' );


	// forward to checkout on add to cart
//	function nfh_redirect_checkout_add_cart() {
//		return wc_get_checkout_url();
//	}
//	add_filter( 'woocommerce_add_to_cart_redirect', 'nfh_redirect_checkout_add_cart' );


	// hide added to cart message
	add_filter( 'wc_add_to_cart_message_html', '__return_false' );


	// empty cart before adding new product to cart
//	function nfh_remove_cart_item_before_add_to_cart( $passed, $product_id, $quantity ) {
//		if( ! WC()->cart->is_empty() ) {
//			WC()->cart->empty_cart();
//		}
//		return $passed;
//	}
//	add_filter( 'woocommerce_add_to_cart_validation', 'nfh_remove_cart_item_before_add_to_cart', 20, 3 );


	// change add to cart text to custom
	function nfh_custom_cart_button_text() {
		return __( 'Next Step', 'woocommerce' );
	}
	add_filter( 'add_to_cart_text', 'nfh_custom_cart_button_text' );
	add_filter( 'woocommerce_product_single_add_to_cart_text', 'nfh_custom_cart_button_text' );


	// set thumbnail sizes
	if (function_exists('add_theme_support')) {
		add_theme_support('post-thumbnails');
		add_image_size('image-feature', 750, '', true);
		add_image_size('image-partner', 250, '', true);
	}


	add_theme_support( 'html5', array(
		'gallery',
	) );

	function fb_unautop_4_img( $content ) {
		$content = preg_replace(
			'/<p>\\s*?(<a rel=\"attachment.*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s',
			'<figure>$1</figure>',
			$content
		);
		return $content;
	}
	add_filter( 'the_content', 'fb_unautop_4_img', 99 );

	require( dirname( __FILE__ ) . '/includes/cpt-services.php');
	require( dirname( __FILE__ ) . '/includes/cpt-support.php');
	require( dirname( __FILE__ ) . '/includes/cpt-network.php');
	require( dirname( __FILE__ ) . '/includes/cpt-terms.php');

	// Functions
	require( dirname( __FILE__ ) . '/functions/page_intro.php');
	require( dirname( __FILE__ ) . '/functions/post_filter.php');

	// disable admin bar
	show_admin_bar(false);


	// enable custom menu support
	if (function_exists('add_theme_support')) {
		add_theme_support( 'menus' );
	}

	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
				// 'primary-menu' => __( 'Primary Menu' ),
				'nav-menu-primary' => __( 'Nav Menu Primary' ),
				'main-menu-primary' => __( 'Main Menu Primary' ),
				'main-menu-secondary' => __( 'Main Menu Secondary' ),
				'footer-menu' => __( 'Footer Company Menu' )
			)
		);
	}





	// post-decorator-accounts
	add_action( 'rest_api_init', function () {
		register_rest_route('ofy-remote/v1', '/post-meter-check', array(
			'methods' => 'POST,GET',
			'callback' => 'ofy_meter_check'
		));
	} );


	function ofy_meter_check( WP_REST_Request $request ) {

		global $nf;

		$thetoken = get_sf_token();

		$validKeys = array(
			'meter_no',
			'amount'
		);

		$postdata = $nf->clean_array($_POST, $validKeys);

		$access_token = $thetoken->access_token;

		$request_id = '';

		// format amount
		$amount = $postdata['amount'];
		if ($amount == '0.00') {
			$amount = 'none';
		} else {
			$amount = str_replace(".","",$amount);
		}

		$meter_number = $postdata['meter_no'];

		//$account_number = '2273-8313-5962-2725';
		$account_number = '6104708186';

		//$entitytag = '{\\"storeId\\":\\"store01\\",\\"tillId\\":\\"till03\\"}';
		$entitytag = 'torsten-test-coct-fbe-000003';

		$requestId = $meter_number.'_'.date("d-m-Y_H-i-s");;
		$acquirer = '';


		if (isset($amount) && !empty($amount) && isset($meter_number) && !empty($meter_number)) {

			if ( $amount == 'none' ) {
				$amount = '0';
			}

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  //CURLOPT_URL => 'https://api.flashswitch.flash-group.com/electricity/1.0.0/lookup',
			  CURLOPT_URL => 'https://api.flashswitch.flash-group.com/electricityCoCT/1.0.0/lookup',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
			   "acquirer": {
			     "account": {
			       "accountNumber": "'.$account_number.'"
			     },
			     "entityTag": "'.$entitytag.'"
			   },
			   "amount": '.$amount.',
			   "meterNumber": "'.$meter_number.'",
			   "requestId": "'.$requestId.'"
			 }',
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json',
			    'Accept: application/json',
			    'Authorization: Bearer '.$access_token
			  ),
			));

			$response = curl_exec($curl);

			//$nf->mail_print_r( 'gerhard@ninjasforhire.co.za', $response, 'response lookup' );

			curl_close($curl);
			return $response;

		}

	}



	/*
	 * helpers
	 */


	function nfh_format_amount($amount) {

		$amount = number_format($amount, 2, '.', '');
        nfh_order_details_logging(111, 'Amount '. $amount);
		$amount = trim(str_replace(',','',$amount));
        nfh_order_details_logging(111,'Amount '. $amount);
		$amount = trim(str_replace('.','',$amount));
        nfh_order_details_logging(111, 'Amount '. $amount);

		return $amount;
	}

	function nfh_encode_orderid($str) {

		$part1 = base64_encode($str);
		$part2 = base64_encode($part1);
		$part3 = base64_encode($part2);

		return $part3;
	}

	function nfh_decode_orderid($str) {

		$part1 = base64_decode($str);
		$part2 = base64_decode($part1);
		$part3 = base64_decode($part2);

		return $part3;
	}


	/*
	 * voucher token for thank you page
	 */

	add_action( 'rest_api_init', function () {
		register_rest_route('nfh-remote/v1', '/get-token-thankyou', array(
			'methods' => 'POST,GET',
			'callback' => function () {
				return nfh_thankyou_token();
			}
		));
	} );

	function nfh_thankyou_token() {

		if ( isset($_POST['key']) && !empty($_POST['key']) ) {

			$key = nfh_decode_orderid($_POST['key']);

			if (is_numeric($key)) {
				$token = get_post_meta( $key, '1FORYOU_purchase_token' );
			}
		}

		if (isset($token) && !empty($token)) {
			return $token;
		} else {
			return 'error';
		}

	}


	add_action( 'rest_api_init', function () {
		register_rest_route('nfh-remote/v1', '/get-token-thankyou2', array(
			'methods' => 'POST,GET',
			'callback' => function () {
				return nfh_thankyou_token2();
			}
		));
	} );

	function nfh_thankyou_token2() {

		if ( isset($_POST['key']) && !empty($_POST['key']) ) {

			$key = nfh_decode_orderid($_POST['key']);

			if (is_numeric($key)) {
				$serialno = get_post_meta( $key, '1FORYOU_purchase_serialno' );
			}
		}

		if (isset($serialno) && !empty($serialno)) {
			return $serialno;
		} else {
			return 'error';
		}

	}


	/*
	 * voucher integration
	 */

	function nfh_payment_complete_voucher( $order_id ) {

		global $wpdb, $nf;

		$order = wc_get_order( $order_id );
		$order_data = $order->get_data();
		$order_id = $order_data['id'];

		$nf->mail_print_r( 'gerhard@ninjasforhire.co.za', $order_data, '1foryou order_data' );
		$nf->mail_print_r( 'gerhard@ninjasforhire.co.za', $order_id, '1foryou order_id' );

		// log
		nfh_order_process_logging( $order_id, 'log: payment complete' );


		$order_items_arr = array();
		foreach ( $order->get_items() as  $item_key => $item_values ) {
			$item_data = $item_values->get_data();

			if ( $item_data['product_id'] == ID_1FORYOU ) {

				// log
				nfh_order_process_logging( $order_id, 'log: 1foryou voucher product process start' );

				// check for failed order
				if ($order_data['status'] == 'failed') {

					// log
					nfh_order_process_logging( $order_id, 'log: 1foryou order status failed' );

					exit;
				}


				$order_items = array();
				$order_items_i = 0;
				foreach ($order_data['line_items'] as $kod => $od) {

					//$item_id = $od->get_id();
					$order_items_i++;

					$prod = wc_get_product($od->get_product_id());

					$order_items[$order_items_i] = array(
						'product_id' => $od->get_product_id(),
						'variation_id' => $od->get_variation_id(),
						'name' => $od->get_name(),
						'total' => $od->get_total(),
						'voucher-amount' => $od->get_meta( 'voucher-amount', true ),
						'how' => $od->get_meta( 'How would you like to receive your voucher?', true ),
						'user-email' => $od->get_meta( 'Email address', true ),
						'user-mobile' => $od->get_meta( 'Mobile number', true ),
						'sku' => $prod->get_sku()
					);

					// log
					nfh_order_process_logging( $order_id, 'log: product_id: ' . $od->get_product_id());
					nfh_order_process_logging( $order_id, 'log: variation_id: ' . $od->get_variation_id());
					nfh_order_process_logging( $order_id, 'log: name ' . $od->get_name());
					nfh_order_process_logging( $order_id, 'log: total ' . $od->get_total());
					nfh_order_process_logging( $order_id, 'log: voucher-amount ' . $od->get_meta( 'voucher-amount', true ) );
					nfh_order_process_logging( $order_id, 'log: user-email ' . $od->get_meta( 'Email address', true ) );
					nfh_order_process_logging( $order_id, 'log: user-mobile ' . $od->get_meta( 'Mobile number', true ) );
					nfh_order_process_logging( $order_id, 'log: sku ' . $prod->get_sku() );


					if ( trim($order_items[$order_items_i]['sku']) == '1FORYOU' ) {

						if ( $order_items[$order_items_i]['how'] == 'Email' ) {

							$buyvouchers_1fa_receive = 'email';
							$buyvouchers_1fa_email = $order_items[$order_items_i]['user-email'];
							$buyvouchers_1fa_mobile = '';

							nfh_order_process_logging( $order_id, 'log: method email' );

						} else if ( $order_items[$order_items_i]['how'] == 'SMS' ) {

							$buyvouchers_1fa_receive = 'sms';
							$buyvouchers_1fa_email = '';
							$buyvouchers_1fa_mobile = $order_items[$order_items_i]['user-mobile'];

							nfh_order_process_logging( $order_id, 'log: method sms' );

						}

						$buyvouchers_1fa_vtype = '1FORYOU';
						$buyvouchers_1fa_custom = '';

						if ( $order_items[$order_items_i]['total'] == '20' || $order_items[$order_items_i]['total'] == '50' || $order_items[$order_items_i]['total'] == '100' ) {
							$buyvouchers_1fa_type = 'R'.$order_items[$order_items_i]['total'];

							// log
							nfh_order_process_logging( $order_id, 'log: voucher type: set price selection' );
						} else {
							$buyvouchers_1fa_type = 'RVAR';
							$buyvouchers_1fa_custom = number_format($order_items[$order_items_i]['total'], 2);
							$buyvouchers_1fa_custom = str_replace(",", "", $buyvouchers_1fa_custom);

							// log
							nfh_order_process_logging( $order_id, 'log: voucher type: var price selection' );
						}

						$datajson = '{
							"buyvouchers_1fa_vtype":"'.$buyvouchers_1fa_vtype.'",
							"buyvouchers_1fa_type":"'.$buyvouchers_1fa_type.'",
							"buyvouchers_1fa_custom":"'.$buyvouchers_1fa_custom.'",
							"buyvouchers_1fa_receive":"'.$buyvouchers_1fa_receive.'",
							"buyvouchers_1fa_email":"'.$buyvouchers_1fa_email.'",
							"buyvouchers_1fa_mobile":"'.$buyvouchers_1fa_mobile.'"
						}';

						$dataarray = $datajson;
						$dataarray = json_decode( $dataarray );
						$dataarray = json_decode(json_encode($dataarray), true);



						$voucher_amount = $order_items[$order_items_i]['total'];
						$voucher_data = array(
							'amount' => $voucher_amount,
							'order_id' => $order_id
						);
//						$purchase = purchase_1FORYOU_voucher($voucher_data);


						// add to db for ftp process
						$ftp_data = array(
							'product_id' => $dataarray['buyvouchers_1fa_vtype'],
							'product_desc' => $dataarray['buyvouchers_1fa_vtype'],
							'trans_reference_client' => $order_id,
							'trans_reference_flash' => $purchase['transactionId'],
							'transaction_amount' => $purchase['voucher']['amount'],
							'transaction_status' => '',
							'unsuccessful_response' => ''
						);


						// log
						nfh_order_process_logging( $order_id, 'log: product_id ' . $dataarray['buyvouchers_1fa_vtype'] );
						nfh_order_process_logging( $order_id, 'log: product_desc ' . $dataarray['buyvouchers_1fa_vtype'] );
						nfh_order_process_logging( $order_id, 'log: trans_reference_client ' . $order_id );
						nfh_order_process_logging( $order_id, 'log: trans_reference_flash ' . $purchase['transactionId'] );
						nfh_order_process_logging( $order_id, 'log: transaction_amount' . $purchase['voucher']['amount'] );


						// save order data to order
						update_post_meta( $order_id, 'buyvouchers_1FORYOU_vtype', $dataarray['buyvouchers_1fa_vtype'] );
						update_post_meta( $order_id, 'buyvouchers_1FORYOU_type', $dataarray['buyvouchers_1fa_type'] );
						update_post_meta( $order_id, 'buyvouchers_1FORYOU_custom', $dataarray['buyvouchers_1fa_custom'] );
						update_post_meta( $order_id, 'buyvouchers_1FORYOU_receive', $dataarray['buyvouchers_1fa_receive'] );
						update_post_meta( $order_id, 'buyvouchers_1FORYOU_email', $dataarray['buyvouchers_1fa_email'] );
						update_post_meta( $order_id, 'buyvouchers_1FORYOU_mobile', $dataarray['buyvouchers_1fa_mobile'] );


						nfh_order_process_logging( $order_id, 'log: buyvouchers_1FORYOU_type ' . $dataarray['buyvouchers_1fa_type'] );
						nfh_order_process_logging( $order_id, 'log: buyvouchers_1FORYOU_custom ' . $dataarray['buyvouchers_1fa_custom'] );
						nfh_order_process_logging( $order_id, 'log: buyvouchers_1FORYOU_receive ' . $dataarray['buyvouchers_1fa_receive'] );
						nfh_order_process_logging( $order_id, 'log: buyvouchers_1FORYOU_email ' . $dataarray['buyvouchers_1fa_email'] );
						nfh_order_process_logging( $order_id, 'log: buyvouchers_1FORYOU_mobile ' . $dataarray['buyvouchers_1fa_mobile'] );
						nfh_order_process_logging( $order_id, 'log: responseMessage before ' . $purchase['responseMessage'] );

						if ($purchase['responseMessage'] == 'Success') {

							nfh_order_process_logging( $order_id, 'log: responseMessage in success' );

							update_post_meta( $order_id, '1FORYOU_purchase_token', $purchase['voucher']['pin'] );
							update_post_meta( $order_id, '1FORYOU_purchase_expiry', $purchase['voucher']['expiryDate'] );
							update_post_meta( $order_id, '1FORYOU_purchase_transactionid', $purchase['transactionId'] );
							update_post_meta( $order_id, '1FORYOU_purchase_serialno', $purchase['voucher']['serialNumber'] );

							$item_id = $kod;

							nfh_order_process_logging( $order_id, 'log: item_id ' . $item_id );

							wc_update_order_item_meta($item_id, 'transactionID', $purchase['transactionId']);
							wc_update_order_item_meta($item_id, 'serialNumber', $purchase['voucher']['serialNumber']);

							nfh_order_process_logging( $order_id, 'log: transactionID ' . $purchase['transactionId'] );
							nfh_order_process_logging( $order_id, 'log: serialNumber ' . $purchase['voucher']['serialNumber'] );

							// remove when more than 1 products
							update_post_meta( $order_id, '_billing_last_name', $purchase['transactionId'] );
							update_post_meta( $order_id, '_shipping_last_name', $purchase['transactionId'] );
							update_post_meta( $order_id, '_billing_first_name', $purchase['voucher']['serialNumber'] );
							update_post_meta( $order_id, '_shipping_first_name', $purchase['voucher']['serialNumber'] );

							nfh_order_process_logging( $order_id, 'log: updated user order name to serial and key' );

							if ($dataarray['buyvouchers_1fa_receive'] == 'email') {

								nfh_order_process_logging( $order_id, 'log: sending email' );

								send_1FORYOU_voucher_email($dataarray['buyvouchers_1fa_email'], $purchase['voucher']['pin'], $purchase['voucher']['expiryDate'], $purchase['voucher']['serialNumber'], $voucher_amount);

							} else if ($dataarray['buyvouchers_1fa_receive'] == 'sms') {

								nfh_order_process_logging( $order_id, 'log: sending sms' );

								send_1FORYOU_voucher_sms($dataarray['buyvouchers_1fa_mobile'], $purchase['voucher']['pin'], $purchase['voucher']['expiryDate'], $purchase['voucher']['serialNumber'], $voucher_amount);

							}

							$datalog = json_encode($dataarray);

							nfh_order_process_logging( $order_id, 'log: success datalog ' . $datalog );

							//$nf->log_output($datalog,'nfh_payment_complete_voucher');

							$ftp_data['transaction_status'] = 'Successful';

							$order->update_status( 'completed' );

							nfh_order_process_logging( $purchase_json, 'log: done Successful' );

						} else {

							nfh_order_process_logging( $order_id, 'log: responseMessage in failure' );

							$purchase_json = json_encode($purchase);

							nfh_order_process_logging( $purchase_json, 'log: purchase json' );

							$purchase_json = urlencode( $purchase_json );

							$ftp_data['transaction_status'] = $purchase_json;
							$ftp_data['unsuccessful_response'] = 'Unsuccessful';

							nfh_order_process_logging( $purchase_json, 'log: done Unsuccessful' );

						}

						$wpdb->insert( 'nfh_voucher_ftpdata', $ftp_data );

						break;

					}
				}

				// log
				nfh_order_process_logging( $order_id, 'log: 1foryou voucher product process end' );

			} else if ($item_data['product_id'] == ID_ELECTRIC ) {

				// log
				nfh_order_process_logging( $order_id, 'log: electricity voucher product process start' );

				// check for failed order
				if ($order_data['status'] == 'failed') {

					// log
					nfh_order_process_logging( $order_id, 'log: electricity order status failed' );

					exit;
				}

				$order_items = array();
				$order_items_i = 0;
				foreach ($order_data['line_items'] as $kod => $od) {

					$order_items_i++;

					$prod = wc_get_product($od->get_product_id());

					$order_items[$order_items_i] = array(
						'product_id' => $od->get_product_id(),
						'variation_id' => $od->get_variation_id(),
						'name' => $od->get_name(),
						'meter_number' => $od->get_meta( 'Meter number', true ),
						'total' => $od->get_total(),
						'how' => $od->get_meta( 'How would you like to receive your electricity pin?', true ),
						'user-email' => $od->get_meta( 'Email address', true ),
						'user-mobile' => $od->get_meta( 'Mobile number', true ),
						'sku' => $prod->get_sku()
					);


					// log
					nfh_order_process_logging( $order_id, 'log: product_id: ' . $od->get_product_id());
					nfh_order_process_logging( $order_id, 'log: variation_id: ' . $od->get_variation_id());
					nfh_order_process_logging( $order_id, 'log: name ' . $od->get_name());
					nfh_order_process_logging( $order_id, 'log: total ' . $od->get_total());
					nfh_order_process_logging( $order_id, 'log: user-email ' . $od->get_meta( 'Email address', true ) );
					nfh_order_process_logging( $order_id, 'log: user-mobile ' . $od->get_meta( 'Mobile number', true ) );
					nfh_order_process_logging( $order_id, 'log: sku ' . $prod->get_sku() );


					if ( trim($order_items[$order_items_i]['sku']) == 'ELECTRIC' ) {

						if ( $order_items[$order_items_i]['how'] == 'Email' ) {

							$buyvouchers_1fa_receive = 'email';
							$buyvouchers_1fa_email = $order_items[$order_items_i]['user-email'];
							$buyvouchers_1fa_mobile = '';

							nfh_order_process_logging( $order_id, 'log: method email' );

						} else if ( $order_items[$order_items_i]['how'] == 'SMS' ) {

							$buyvouchers_1fa_receive = 'sms';
							$buyvouchers_1fa_email = '';
							$buyvouchers_1fa_mobile = $order_items[$order_items_i]['user-mobile'];

							nfh_order_process_logging( $order_id, 'log: method sms' );

						}

						$buyvouchers_1fa_vtype = 'ELECTRIC';
						$buyvouchers_1fa_type = 'RVAR';
						$buyvouchers_1fa_custom = number_format($order_items[$order_items_i]['total'], 2);
						$buyvouchers_1fa_custom = str_replace(",", "", $buyvouchers_1fa_custom);

						// log
						nfh_order_process_logging( $order_id, 'log: voucher type: var price selection' );


						$datajson = '{
							"buyvouchers_1fa_vtype":"'.$buyvouchers_1fa_vtype.'",
							"buyvouchers_1fa_type":"'.$buyvouchers_1fa_type.'",
							"buyvouchers_1fa_custom":"'.$buyvouchers_1fa_custom.'",
							"buyvouchers_1fa_receive":"'.$buyvouchers_1fa_receive.'",
							"buyvouchers_1fa_email":"'.$buyvouchers_1fa_email.'",
							"buyvouchers_1fa_mobile":"'.$buyvouchers_1fa_mobile.'"
						}';

						//$nf->mail_print_r( 'gerhard@ninjasforhire.co.za', $datajson, 'datajson' );

						$dataarray = $datajson;
						$dataarray = json_decode( $dataarray );
						$dataarray = json_decode(json_encode($dataarray), true);


						$voucher_amount = $order_items[$order_items_i]['total'];
						$voucher_data = array(
							'amount' => $voucher_amount,
							'order_id' => $order_id,
							'meter_number' => $order_items[$order_items_i]['meter_number']
						);
						$purchase = purchase_ELECTRICITY_voucher($voucher_data);


						// log
						nfh_order_process_logging( $order_id, 'log: product_id ' . $dataarray['buyvouchers_1fa_vtype'] );
						nfh_order_process_logging( $order_id, 'log: product_desc ' . $dataarray['buyvouchers_1fa_vtype'] );
						nfh_order_process_logging( $order_id, 'log: trans_reference_client ' . $order_id );
						nfh_order_process_logging( $order_id, 'log: trans_reference_flash ' . $purchase['transactionId'] );
						nfh_order_process_logging( $order_id, 'log: transaction_amount' . $purchase['billingInfo']['amount'] );


						// save order data to order
						update_post_meta( $order_id, 'buyvouchers_ELECTRIC_vtype', $dataarray['buyvouchers_1fa_vtype'] );
						update_post_meta( $order_id, 'buyvouchers_ELECTRIC_type', $dataarray['buyvouchers_1fa_type'] );
						update_post_meta( $order_id, 'buyvouchers_ELECTRIC_custom', $dataarray['buyvouchers_1fa_custom'] );
						update_post_meta( $order_id, 'buyvouchers_ELECTRIC_receive', $dataarray['buyvouchers_1fa_receive'] );
						update_post_meta( $order_id, 'buyvouchers_ELECTRIC_email', $dataarray['buyvouchers_1fa_email'] );
						update_post_meta( $order_id, 'buyvouchers_ELECTRIC_mobile', $dataarray['buyvouchers_1fa_mobile'] );


						nfh_order_process_logging( $order_id, 'log: buyvouchers_ELECTRIC_type ' . $dataarray['buyvouchers_1fa_type'] );
						nfh_order_process_logging( $order_id, 'log: buyvouchers_ELECTRIC_custom ' . $dataarray['buyvouchers_1fa_custom'] );
						nfh_order_process_logging( $order_id, 'log: buyvouchers_ELECTRIC_receive ' . $dataarray['buyvouchers_1fa_receive'] );
						nfh_order_process_logging( $order_id, 'log: buyvouchers_ELECTRIC_email ' . $dataarray['buyvouchers_1fa_email'] );
						nfh_order_process_logging( $order_id, 'log: buyvouchers_ELECTRIC_mobile ' . $dataarray['buyvouchers_1fa_mobile'] );
						nfh_order_process_logging( $order_id, 'log: responseMessage before ' . $purchase['responseMessage'] );


						if ($purchase['responseMessage'] == 'Success') {


							nfh_order_process_logging( $order_id, 'log: responseMessage in success' );


							update_post_meta( $order_id, 'ELECTRIC_purchase_token_1', $purchase['tokens'][0]['pin'] );
							update_post_meta( $order_id, 'ELECTRIC_purchase_serialno_1', $purchase['tokens'][0]['serialNumber'] );

							if ( isset($purchase['tokens'][1]['pin']) && !empty($purchase['tokens'][1]['pin']) ) {
								update_post_meta( $order_id, 'ELECTRIC_purchase_token_2', $purchase['tokens'][1]['pin'] );
								update_post_meta( $order_id, 'ELECTRIC_purchase_serialno_2', $purchase['tokens'][1]['serialNumber'] );
							}

							if ( isset($purchase['tokens'][2]['pin']) && !empty($purchase['tokens'][2]['pin']) ) {
								update_post_meta( $order_id, 'ELECTRIC_purchase_token_3', $purchase['tokens'][2]['pin'] );
								update_post_meta( $order_id, 'ELECTRIC_purchase_serialno_3', $purchase['tokens'][2]['serialNumber'] );
							}

							update_post_meta( $order_id, 'ELECTRIC_purchase_transactionid', $purchase['transactionId'] );


							$item_id = $kod;

							nfh_order_process_logging( $order_id, 'log: item_id ' . $item_id );

							wc_update_order_item_meta($item_id, 'transactionID', $purchase['transactionId']);

							nfh_order_process_logging( $order_id, 'log: transactionID ' . $purchase['transactionId'] );


							// remove when more than 1 products
							update_post_meta( $order_id, '_billing_last_name', $purchase['transactionId'] );
							update_post_meta( $order_id, '_shipping_last_name', $purchase['transactionId'] );
							update_post_meta( $order_id, '_billing_first_name', $purchase['tokens'][0]['serialNumber'] );
							update_post_meta( $order_id, '_shipping_first_name', $purchase['tokens'][0]['serialNumber'] );

							nfh_order_process_logging( $order_id, 'log: updated user order name to serials and key' );


							if ($dataarray['buyvouchers_1fa_receive'] == 'email') {

								nfh_order_process_logging( $order_id, 'log: sending email' );

								send_ELECTRICITY_voucher_email( $dataarray['buyvouchers_1fa_email'], $purchase );

							} else if ($dataarray['buyvouchers_1fa_receive'] == 'sms') {

								nfh_order_process_logging( $order_id, 'log: sending sms' );

								send_ELECTRICITY_voucher_sms($dataarray['buyvouchers_1fa_mobile'], $purchase, $voucher_amount);

							}


							$datalog = json_encode($dataarray);

							nfh_order_process_logging( $order_id, 'log: success datalog ' . $datalog );


							$ftp_data['transaction_status'] = 'Successful';

							$order->update_status( 'completed' );

							nfh_order_process_logging( $purchase_json, 'log: done Successful' );

						} else {

							nfh_order_process_logging( $order_id, 'log: responseMessage in failure' );

							$purchase_json = json_encode($purchase);

							nfh_order_process_logging( $purchase_json, 'log: purchase json' );

							$purchase_json = urlencode( $purchase_json );

							$ftp_data['transaction_status'] = $purchase_json;
							$ftp_data['unsuccessful_response'] = 'Unsuccessful';

							nfh_order_process_logging( $purchase_json, 'log: done Unsuccessful' );

						}

						$wpdb->insert( 'nfh_voucher_ftpdata', $ftp_data );

						break;

					}
				}

				// log
				nfh_order_process_logging( $order_id, 'log: electricity voucher product process end' );

			} else {

                //GIFT VOUCHER CODE HERE

                nfh_order_process_logging( $order_id, 'log: Gift voucher product process start' );

                if ($order_data['status'] == 'failed') {

                    // log
                    nfh_order_process_logging( $order_id, 'log: Gift order status failed' );

                    exit;
                }

                $order_items = array();
                $order_items_i = 0;

                $orderCounter = 0;
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $orderCounter++;


                    $_product =  wc_get_product( $cart_item['data']->get_id());

                    $order_items_i++;

                    $order_items[$order_items_i] = array(
                        'product_id' => $cart_item['data']->get_id(),
                        'name' => $_product->get_title(),
                        'total' => WC()->cart->cart_contents[$cart_item_key]['line_total'],
                        'voucher-amount' => (WC()->cart->cart_contents[$cart_item_key]['line_total']/WC()->cart->cart_contents[$cart_item_key]['quantity']),
                        'quantity' => WC()->cart->cart_contents[$cart_item_key]['quantity'],
                        'how' => WC()->cart->cart_contents[$cart_item_key]['del_method'],
                        'del-value' => WC()->cart->cart_contents[$cart_item_key]['del_value'],
                        'sku' => $_product->get_sku()
                    );

                    nfh_order_process_logging( $order_id, 'log: order num ' . $order_items_i);
                    // log
                    nfh_order_process_logging( $order_id, 'log: product_id: ' . $cart_item['data']->get_id());
                    nfh_order_process_logging( $order_id, 'log: name ' . $_product->get_title());
                    nfh_order_process_logging( $order_id, 'log: total ' . WC()->cart->cart_contents[$cart_item_key]['line_total']);
                    nfh_order_process_logging( $order_id, 'log: quantity ' . WC()->cart->cart_contents[$cart_item_key]['quantity']);
//                    nfh_order_process_logging( $order_id, 'log: voucher-amount ' . $od->get_meta( 'voucher-amount', true ) );
                    nfh_order_process_logging( $order_id, 'log: del-method ' . WC()->cart->cart_contents[$cart_item_key]['del_method'] );
                    nfh_order_process_logging( $order_id, 'log: del-value ' . WC()->cart->cart_contents[$cart_item_key]['del_value'] );
                    nfh_order_process_logging( $order_id, 'log: sku ' . $_product->get_sku() );

                    $voucher_del_method = WC()->cart->cart_contents[$cart_item_key]['del_method'];
                    $voucher_del_value = WC()->cart->cart_contents[$cart_item_key]['del_value'];

                    nfh_order_process_logging( $order_id, 'log: method '.$voucher_del_method );

                    $datajson = '{
							"buyvouchers_1fa_vtype":"'.$buyvouchers_1fa_vtype.'",
							"buyvouchers_1fa_type":"'.$buyvouchers_1fa_type.'",
							"buyvouchers_1fa_custom":"'.$buyvouchers_1fa_custom.'",
							"buyvouchers_1fa_receive":"'.$voucher_del_method.'",
							"buyvouchers_1fa_email":"'.$voucher_del_value.'",
							"buyvouchers_1fa_mobile":"'.$voucher_del_value.'"
						}';

                    $dataarray = $datajson;
                    $dataarray = json_decode( $dataarray );
                    $dataarray = json_decode(json_encode($dataarray), true);

                    $voucher_amount = $order_items[$order_items_i]['total'];

                    $voucher_data = array(
                        'amount' => WC()->cart->cart_contents[$cart_item_key]['line_total'],
                        'order_id' => $order_id,
                        'prod_id' => get_field('voucher_id', $cart_item['data']->get_id())
                    );

                    nfh_order_process_logging( $order_id, 'log: product_id ' . get_field('voucher_id', $cart_item['data']->get_id()) );

//                    die();

                    $purchase = purchase_GIFT_voucher($voucher_data);

                    nfh_order_process_logging( $order_id, 'log: Purchase Status ' . $purchase['responseMessage'] );
//
//                    die();

                    // log
                    nfh_order_process_logging( $order_id, 'log: product_id ' . $cart_item['data']->get_id() );
                    nfh_order_process_logging( $order_id, 'log: product_desc ' . $_product->get_title()  );
                    nfh_order_process_logging( $order_id, 'log: trans_reference_client ' . $order_id );
                    nfh_order_process_logging( $order_id, 'log: trans_reference_flash ' . $purchase['transactionId'] );
                    nfh_order_process_logging( $order_id, 'log: transaction_amount' . $purchase['voucher']['amount'] );


                    // save order data to order
                    nfh_order_details_logging($order_id ,'Voucher Type : GIFT Voucher');
                    nfh_order_details_logging($order_id ,'Voucher Price : '. $purchase['voucher']['amount']);
                    nfh_order_details_logging($order_id ,'Voucher Delivery Method : '. WC()->cart->cart_contents[$cart_item_key]['del_method']);
                    nfh_order_details_logging($order_id ,'Voucher Delivery Value : '. WC()->cart->cart_contents[$cart_item_key]['del_value']);

//                    nfh_order_details_logging( $order_id, 'buyvouchers_1FORYOU_vtype', $dataarray['buyvouchers_1fa_vtype'] );
//                    nfh_order_details_logging( $order_id, 'buyvouchers_1FORYOU_type', $dataarray['buyvouchers_1fa_type'] );
//                    nfh_order_details_logging( $order_id, 'buyvouchers_1FORYOU_custom', $dataarray['buyvouchers_1fa_custom'] );
//                    nfh_order_details_logging( $order_id, 'buyvouchers_1FORYOU_receive', $dataarray['buyvouchers_1fa_receive'] );
//                    nfh_order_details_logging( $order_id, 'buyvouchers_1FORYOU_email', $dataarray['buyvouchers_1fa_email'] );
//                    nfh_order_details_logging( $order_id, 'buyvouchers_1FORYOU_mobile', $dataarray['buyvouchers_1fa_mobile'] );

                    nfh_order_process_logging( $order_id, 'log: buyvouchers_1FORYOU_type Gift Voucher' );
                    nfh_order_process_logging( $order_id, 'log: responseMessage before ' . $purchase->responseMessage );


                    if ($purchase['responseMessage'] == 'Success') {
//                        die();

                        nfh_order_process_logging( $order_id, 'log: responseMessage in success' );

                        nfh_order_details_logging( $order_id, '1FORYOU_purchase_token', $purchase['voucher']['pin'] );
                        nfh_order_details_logging( $order_id, '1FORYOU_purchase_expiry', $purchase['voucher']['expiryDate'] );
                        nfh_order_details_logging( $order_id, '1FORYOU_purchase_transactionid', $purchase['transactionId'] );
                        nfh_order_details_logging( $order_id, '1FORYOU_purchase_serialno', $purchase['voucher']['serialNumber'] );

                        $item_id = $kod;

                        nfh_order_process_logging( $order_id, 'log: item_id ' . $item_id );

                        wc_update_order_item_meta($item_id, 'transactionID', $purchase['transactionId']);
                        wc_update_order_item_meta($item_id, 'serialNumber', $purchase['voucher']['serialNumber']);

                        nfh_order_process_logging( $order_id, 'log: transactionID ' . $purchase['transactionId'] );
                        nfh_order_process_logging( $order_id, 'log: serialNumber ' . $purchase['voucher']['serialNumber'] );

                        // remove when more than 1 products
                        nfh_order_details_logging( $order_id, '_billing_last_name', $purchase['transactionId'] );
                        nfh_order_details_logging( $order_id, '_shipping_last_name', $purchase['transactionId'] );
                        nfh_order_details_logging( $order_id, '_billing_first_name', $purchase['voucher']['serialNumber'] );
                        nfh_order_details_logging( $order_id, '_shipping_first_name', $purchase['voucher']['serialNumber'] );

                        nfh_order_process_logging( $order_id, 'log: updated user order name to serial and key' );

                        if ($dataarray['buyvouchers_1fa_receive'] == 'Email') {

                            nfh_order_process_logging( $order_id, 'log: sending email' );

                            send_1FORYOU_voucher_email($dataarray['buyvouchers_1fa_email'], $purchase['voucher']['pin'], $purchase['voucher']['expiryDate'], $purchase['voucher']['serialNumber'], $voucher_amount);

                        } else if ($dataarray['buyvouchers_1fa_receive'] == 'Number') {

                            nfh_order_process_logging( $order_id, 'log: sending sms' );

                            send_1FORYOU_voucher_sms($dataarray['buyvouchers_1fa_mobile'], $purchase['voucher']['pin'], $purchase['voucher']['expiryDate'], $purchase['voucher']['serialNumber'], $voucher_amount);

                        }

                        $datalog = json_encode($dataarray);

                        nfh_order_process_logging( $order_id, 'log: success datalog ' . $datalog );

                        //$nf->log_output($datalog,'nfh_payment_complete_voucher');

                        $ftp_data['transaction_status'] = 'Successful';

                        $order->update_status( 'completed' );

                        nfh_order_process_logging( $purchase_json, 'log: done Successful' );

                    } else {

                        nfh_order_process_logging( $order_id, 'log: responseMessage in failure' );

                        $purchase_json = json_encode($purchase);

                        nfh_order_process_logging( $purchase_json, 'log: purchase json' );

                        $purchase_json = urlencode( $purchase_json );

                        $ftp_data['transaction_status'] = $purchase_json;
                        $ftp_data['unsuccessful_response'] = 'Unsuccessful';

                        nfh_order_process_logging( $purchase_json, 'log: done Unsuccessful' );

                    }

                    $wpdb->insert( 'nfh_voucher_ftpdata', $ftp_data );

//                    break;
                }

                nfh_order_process_logging( $order_id, 'log: Gift voucher product process end' );

            }

		}

		// log
		nfh_order_process_logging( $order_id, 'log: woocommerce_order_status_processing completed' );

	}
	add_action( 'woocommerce_order_status_processing', 'nfh_payment_complete_voucher', 10, 1 );



	// $consumer_key = '4pWJdkjE8sg7cnFj3HDHg0fPsLga';
	// $consumer_secret = 'xF9CFRQZ6V8Axmr_OIzplY31lAka';

	function get_sf_token() {

		global $nf;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.flashswitch.flash-group.com/token',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Basic b1d5eFhFazBHdk1OZGRaV19FRWNud2JDQTU0YTpGbzlhMkp1YnBJNVR3ekJFNV9XQVo2YTNZVFlh',
		    'Content-Type: application/x-www-form-urlencoded'
		  ),
		));

		$response = curl_exec($curl);

		nfh_order_process_logging( $order_id, 'log: get_sf_token reponse ' . $response );

		curl_close($curl);

		$response = json_decode($response);

		return $response;

	}


	function get_sf_token_test() {

		global $nf;


		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.flashswitch.flash-group.com/token',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Basic b1d5eFhFazBHdk1OZGRaV19FRWNud2JDQTU0YTpGbzlhMkp1YnBJNVR3ekJFNV9XQVo2YTNZVFlh',
		    'Content-Type: application/x-www-form-urlencoded',
		    'Cookie: dtCookie=v_4_srv_4_sn_64318707A9C4B28380C0C5BB42D2FAF6_perc_100000_ol_0_mul_1_app-3A2a47b4349c902b6d_1'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$response = json_decode($response);

		return $response;

	}


	// purchase ELECTRICITY voucher
	function purchase_ELECTRICITY_voucher($data) {

		global $nf;

		$order_id = $data['order_id'];

		// log
		nfh_order_process_logging( $order_id, 'log: entered purchase_ELECTRICITY_voucher' );

		$meter_number = $data['meter_number'];

		// log
		nfh_order_process_logging( $order_id, 'log: meter_number purchase_ELECTRICITY_voucher ' . $meter_number );

		$amount = nfh_format_amount($data['amount']);
		if ($amount === '000') {
			$amount = 0;
		}

		// log
		nfh_order_process_logging( $order_id, 'log: amount purchase_ELECTRICITY_voucher ' . $amount );

		$thetoken = get_sf_token_test();

		// log
		nfh_order_process_logging( $order_id, 'log: thetoken purchase_ELECTRICITY_voucher ' . $thetoken->access_token );


		//$account_number = '8920-4920-1665-5180';
		$account_number = '6104708186';

		//$entitytag = '{\\"storeId\\":\\"store01\\",\\"tillId\\":\\"till03\\"}';
		$entitytag = 'torsten-test-coct-fbe-000001';

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  //CURLOPT_URL => 'https://api.flashswitch.flash-group.com/electricity/1.0.0/purchase',
		  CURLOPT_URL => 'https://api.flashswitch.flash-group.com/electricityCoCT/1.0.0/purchase',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		    "acquirer": {
		        "account": {
		            "accountNumber": "'.$account_number.'"
		        },
		        "entityTag": "'.$entitytag.'"
		    },
		    "amount": '.$amount.',
		    "meterNumber": "'.$meter_number.'",
		    "requestId": "1000000'.$order_id.'"
		}',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Accept: */*',
		    'Authorization: Bearer '.$thetoken->access_token,
		    'Cookie: dtCookie=v_4_srv_4_sn_64318707A9C4B28380C0C5BB42D2FAF6_perc_100000_ol_0_mul_1_app-3A2a47b4349c902b6d_1'
		  ),
		));

		$response = curl_exec($curl);
		//mail('gerhard@ninjasforhire.co.za', 'response purchase_ELECTRICITY_voucher', print_r($response, true));


		// log
		nfh_order_process_logging( $order_id, 'log: response 1 purchase_ELECTRICITY_voucher ' . $response );

		curl_close($curl);


		// on fail of 1st curl
		if ( strpos( strtolower($response), 'error' ) !== false ||  strpos( strtolower($response), 'bad' ) !== false ) {

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.flashswitch.flash-group.com/electricity/1.0.0/purchase',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
			    "acquirer": {
			        "account": {
			            "accountNumber": "8920-4920-1665-5180"
			        },
			        "entityTag": "{\\"storeId\\":\\"store01\\",\\"tillId\\":\\"till03\\"}"
			    },
			    "amount": '.$amount.',
			    "meterNumber": "'.$meter_number.'",
			    "requestId": "2000000'.$order_id.'"
			}',
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json',
			    'Accept: */*',
			    'Authorization: Bearer '.$thetoken->access_token,
			    'Cookie: dtCookie=v_4_srv_4_sn_64318707A9C4B28380C0C5BB42D2FAF6_perc_100000_ol_0_mul_1_app-3A2a47b4349c902b6d_1'
			  ),
			));

			$response = curl_exec($curl);
			mail('gerhard@ninjasforhire.co.za', 'response purchase_ELECTRICITY_voucher 2', print_r($response, true));

			// log
			nfh_order_process_logging( $order_id, 'log: response 2 purchase_ELECTRICITY_voucher (after 1st failed) ' . $response );

			curl_close($curl);

		}

		$response = json_decode($response, true);

		return $response;
	}

    // purchase GIFT voucher HERE
    function purchase_GIFT_voucher($data) {

        global $nf;

        $order_id = $data['order_id'];
        $prod_id = $data['prod_id'];

        // log
        nfh_order_details_logging( $order_id, 'log: entered purchase_GIFT_voucher' );

        $amount = $data['amount'];

        nfh_order_details_logging( $order_id, 'log: amount purchase_GIFT_voucher ' . $amount );

        $thetoken = get_sf_token();

        nfh_order_details_logging( $order_id, 'log: thetoken purchase_GIFT_voucher ' . $thetoken->access_token );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.flashswitch.flash-group.com/giftvoucher/2.0.0/purchase',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                      "requestId": "'.$order_id.'",
                      "amount": '.$data['amount'].',
                      "productCode": "'.$prod_id.'",
                      "acquirer": {
                        "account": {
                          "accountNumber": "8920-4920-1665-5180"
                        },
                        "entityTag": "torsten-test-coct-fbe-000001"
                      }
                    }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer '.$thetoken->access_token.''
            ),
        ));

        $response = curl_exec($curl);
        nfh_order_details_logging( $order_id ,'purchase attempt');

        // log
        nfh_order_process_logging( $order_id, 'log: response 1 purchase_GIFT_voucher ' . $response );

        curl_close($curl);



        if ( strpos( strtolower($response), 'error' ) !== false ||  strpos( strtolower($response), 'bad' ) !== false ) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.flashswitch.flash-group.com/giftvoucher/2.0.0/purchase',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                      "requestId": "'.$order_id.'",
                      "amount": '.$amount.',
                      "productCode": "'.$prod_id.'",
                      "acquirer": {
                        "account": {
                          "accountNumber": "8920-4920-1665-5180"
                        },
                        "entityTag": "torsten-test-coct-fbe-000001"
                      }
                    }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Bearer '.$thetoken->access_token.''
                ),
            ));

            $response = curl_exec($curl);

            // log
            nfh_order_process_logging( $order_id, 'log: response 2 purchase_GIFT_voucher (failed) ' . $response );

            curl_close($curl);

        }

        $response = json_decode($response, true);

        nfh_order_process_logging( $order_id, 'log: decoded ' . $response );

        return $response;
    }

	// purchase 1FORYOU voucher
	function purchase_1FORYOU_voucher($data) {

		global $nf;

		$order_id = $data['order_id'];

		// log
		nfh_order_process_logging( $order_id, 'log: entered purchase_1FORYOU_voucher' );

		$amount = nfh_format_amount($data['amount']);

		nfh_order_process_logging( $order_id, 'log: amount purchase_1FORYOU_voucher ' . $amount );

		$thetoken = get_sf_token();

		nfh_order_process_logging( $order_id, 'log: thetoken purchase_1FORYOU_voucher ' . $thetoken->access_token );


		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.flashswitch.flash-group.com/1foryou/1.0.0/purchase',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		   "requestId": "'.$order_id.'",
		   "amount": '.$amount.',
		   "acquirer": {
		     "account": {
		       "accountNumber": "2273-8313-5962-2725"
		     },
		     "entityTag": "entityReferenceTag"
		   }
		 }',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Accept: application/json',
		    'Authorization: Bearer '.$thetoken->access_token.''
		  ),
		));

		$response = curl_exec($curl);

		// log
		nfh_order_process_logging( $order_id, 'log: response 1 purchase_1FORYOU_voucher ' . $response );

		curl_close($curl);


		if ( strpos( strtolower($response), 'error' ) !== false ||  strpos( strtolower($response), 'bad' ) !== false ) {

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.flashswitch.flash-group.com/1foryou/1.0.0/purchase',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
			   "requestId": "'.$order_id.'",
			   "amount": '.$amount.',
			   "acquirer": {
			     "account": {
			       "accountNumber": "2273-8313-5962-2725"
			     },
			     "entityTag": "entityReferenceTag"
			   }
			 }',
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json',
			    'Accept: application/json',
			    'Authorization: Bearer '.$thetoken->access_token.''
			  ),
			));

			$response = curl_exec($curl);

			// log
			nfh_order_process_logging( $order_id, 'log: response 2 purchase_1FORYOU_voucher (failed) ' . $response );

			curl_close($curl);

		}

		$response = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', $response), true);

		return $response;
	}



	function send_ELECTRICITY_voucher_sms( $mobile_number, $purchase, $voucher_amount ) {

		// api url: https://flash.everlytic.net/api/2.0/production/sms/message
		// username: Devin
		// api key: g8jeXItAiM95qy7fp0mwsMaQy7jhAgzy_8

		$token = chunk_split($token, 4, ' ');

		$message = $purchase['meterInfo']['utilityInfo']['name'].' ';
		$message .= date("j M Y", strtotime($purchase['transactionDate'])).' ';

		$message .= 'AMT: R'.number_format((str_replace(".", "", $purchase['amount'])/100),2).' ';
		$message .= 'UNITS: '.$purchase['billingInfo']['units'].' '.$purchase['billingInfo']['unit'].' ';
		if ($purchase['billingInfo']['fixedCharges'] != 0) {
			$message .= 'SC: R'.number_format(($purchase['billingInfo']['fixedCharges']/100),2).' ';
		}
		if ($purchase['billingInfo']['fbe'] != 0) {
			$message .= 'FBE: '.$purchase['billingInfo']['fbe'].' '.$purchase['billingInfo']['unit'].' ';
		}
		if ($purchase['billingInfo']['arrearAmount'] != 0) {
			$message .= 'DEBT: '.$purchase['billingInfo']['arrearAmount'].' ';
		}
		if ($purchase['billingInfo']['refundAmount'] != 0) {
			$message .= 'REFUND: '.$purchase['billingInfo']['refundAmount'].' ';
		}


		// tokens
		foreach ($purchase['tokens'] as $tokens) {

			if ($tokens['type'] == 'Key Change Token') {
				$message .= 'KCT: '.$tokens['pin'].' ';
			} else if ($tokens['type'] == 'FBE') {
				$message .= 'FBE: '.$tokens['pin'].' ';
			} else {
				$message .= 'TOKEN: '.$tokens['pin'].' ';
			}
		}


		$message .= 'TARRIFF: '.$purchase['billingInfo']['tariffName'].' ';

		$url = 'https://flash.everlytic.net/api/2.0/production/sms/message';

		$post = json_encode(['message' => $message,'mobile_number' => $mobile_number]);
		$username = 'Devin';
		$apiKey = 'g8jeXItAiM95qy7fp0mwsMaQy7jhAgzy_8';
		$cSession = curl_init();
		$headers = array(
			'Content-Type:application/json',
			'Content-Length:'.strlen($post)
		);
		curl_setopt($cSession, CURLOPT_URL, $url);
		curl_setopt($cSession, CURLOPT_USERPWD, $username . ":" . $apiKey);
		curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cSession, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($cSession, CURLOPT_POSTFIELDS, $post);
		curl_setopt($cSession, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($cSession);

		//mail('gerhard@ninjasforhire.co.za', 'result send_ELECTRICITY_voucher_sms', print_r($result, true));

		curl_close($cSession);

		print_r($result);

	}


	function send_ELECTRICITY_voucher_email( $email_address, $purchase ) {

		global $nf;


	//	$nf->mail_print_r( 'gerhard@ninjasforhire.co.za', $purchase, 'purchase email' );

		$baseurl = get_option('home').'/emailer';

		$message = $purchase['meterInfo']['utilityInfo']['name'].'<br>';
		$message .= date("j M Y", strtotime($purchase['transactionDate'])).'<br>';
		$message .= 'Ref: '.$purchase['transactionId'].'<br>';
		$message .= 'VAT Number: 4500193497<br><br>';

		$message .= 'Meter no: '.$purchase['meterInfo']['meterNumber'].'<br>';

		$Amount = number_format((float)$purchase['billingInfo']['amount'], 2, '.', '');
		$message .= 'Amount: R'.number_format((str_replace(".", "", $Amount)/100),2).'<br>';

		$taxAmount = number_format((float)$purchase['billingInfo']['taxAmount'], 2, '.', '');

		$message .= 'VAT Amount: R'.number_format((str_replace(".", "", $taxAmount)/100),2).'<br>';

		$fixedCharges = number_format((float)$purchase['billingInfo']['fixedCharges'], 2, '.', '');
		if ($purchase['billingInfo']['fixedCharges'] != 0) {
			$message .= 'Service Charge: R'.number_format((str_replace(".", "", $fixedCharges)/100),2).'<br>';
		}

		$message .= 'Total: R'.number_format(($purchase['amount']/100),2).'<br>';
		$message .= 'Units: '.$purchase['billingInfo']['units'].' '.$purchase['billingInfo']['unit'].'<br>';
		if ($purchase['billingInfo']['fbe'] != 0) {
			$message .= 'FBE: '.$purchase['billingInfo']['fbe'].' '.$purchase['billingInfo']['unit'].'<br>';
		}

		$arrearAmount = number_format((float)$purchase['billingInfo']['arrearAmount'], 2, '.', '');
		if ($purchase['billingInfo']['arrearAmount'] != 0) {
			$message .= 'Debt: R'.$arrearAmount.'<br>';
		}
		if ($purchase['billingInfo']['refundAmount'] != 0) {
			$message .= 'Refund: '.$purchase['billingInfo']['refundAmount'].'<br>';
		}
		// if (isset($purchase['billingInfo']['vatNumber']) && !empty($purchase['billingInfo']['vatNumber'])) {
		// 	$message .= 'VAT Number: '.$purchase['billingInfo']['vatNumber'].'<br>';
		// }





		$message .= '<br>';

		// tokens
		foreach ($purchase['tokens'] as $tokens) {

			if ($tokens['type'] == 'Key Change Token') {
				$message .= 'Key Change Token: '.$tokens['pin'].'<br>';
			} else if ($tokens['type'] == 'FBE') {
				$message .= 'FBE: '.$tokens['pin'].'<br>';
			} else {
				$message .= 'Token: '.$tokens['pin'].'<br>';
			}
		}


		$message .= '<br>';

		$message .= 'Tarriff: '.$purchase['billingInfo']['tariffName'].'<br>';
		//$message .= 'Call Centre: '.$purchase['meterInfo']['utilityInfo']['callCentre'].' ';
		$message .= 'Call Centre: 0860103089<br>';


		$email_message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
			<head>
			<title></title>
			<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
			<meta name="format-detection" content="date=no" />
			<meta name="format-detection" content="address=no" />
			<meta name="format-detection" content="telephone=no" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

			<style type="text/css">
			body {
				margin:0px;
				padding:0px;
			}

			p {
				margin:0px;
				padding:0px;
				display:none !important;
			}

			h1, h2, h3, h4, h5, h6 {
				color: #000 !important;
				line-height: 100%;
			}

			img {
				-ms-interpolation-mode: bicubic;
			}

			a img {
				border:none !important;
			}

			body {
				-webkit-text-size-adjust:none;
				-ms-text-size-adjust:none;
			}

			a[x-apple-data-detectors] {
				color: inherit !important;
				text-decoration: none !important;
				font-size: inherit !important;
				font-family: inherit !important;
				font-weight: inherit !important;
				line-height: inherit !important;
			}

			a[href^=tel],a[href^=sms]{
				color:inherit;
				cursor:default;
				text-decoration:underline;
			}

			.ExternalClass {
				width:100%;
			}

			.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
				line-height: 100%;
			}

			#outlook a {
				padding:0;
			}

			table, td {
				border-collapse: collapse;
				border-spacing: 0;
				mso-line-height-rule: exactly;
				mso-margin-bottom-alt: 0;
				mso-margin-top-alt: 0;
				mso-table-lspace: 0pt;
				mso-table-rspace: 0pt;
			}

			.custom-table {background-image: url('.$baseurl.'/images/bg.png) !important; background-repeat: repeat !important}

			@media screen and (max-width: 480px) {
				.wtm {width:100% !important; height:auto !important;}
				.nomob {display:none !important;}

				.pnone {padding:0px !important}
				.pfull {padding-top:20px !important; padding-bottom:20px !important; padding-left:15px !important; padding-right:15px !important}
				.pvert {padding-top:20px !important; padding-bottom:20px !important; padding-left:0px !important; padding-right:0px !important}
				.pvert2 {padding-top:15px !important; padding-bottom:15px !important; padding-left:0px !important; padding-right:0px !important}
				.phor {padding-top:0px !important; padding-bottom:0px !important; padding-left:15px !important; padding-right:15px !important}
				.phortop {padding-top:15px !important; padding-bottom:0px !important; padding-left:15px !important; padding-right:15px !important}
				.phorbot {padding-top:0px !important; padding-bottom:15px !important; padding-left:15px !important; padding-right:15px !important}
				.pbot {padding-top:0px !important; padding-bottom:20px !important; padding-left:0px !important; padding-right:0px !important}
				.pbot2 {padding-top:0px !important; padding-bottom:15px !important; padding-left:0px !important; padding-right:0px !important}
				.ptop {padding-top:20px !important; padding-bottom:0px !important; padding-left:0px !important; padding-right:0px !important}
				.ptop2 {padding-top:15px !important; padding-bottom:0px !important; padding-left:0px !important; padding-right:0px !important}

				.font13 {font-size:13px !important; line-height:19px !important}
				.font15 {font-size:15px !important; line-height:21px !important}
				.font18 {font-size:18px !important; line-height:24px !important}
				.font20 {font-size:20px !important; line-height:26px !important}
				.font22 {font-size:22px !important; line-height:28px !important}
				.font24 {font-size:24px !important; line-height:30px !important}
				.font32 {font-size:32px !important; line-height:38px !important}
				.font40 {font-size:40px !important; line-height:44px !important}

				.custom-bg {background-color: #000000 !important}
				.text-center {text-align: center !important}
			}

			</style>

			<!--[if gte mso 9]>
			<xml>
			  <o:OfficeDocumentSettings>
				<o:AllowPNG/>
				<o:PixelsPerInch>96</o:PixelsPerInch>
			 </o:OfficeDocumentSettings>
			</xml>
			<![endif]-->

			</head>

			<body style="padding:0; margin:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:100%">
			<table style="table-layout:fixed; width:100% !important" border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
			<tr>
			<td valign="top">
			<table style="width:600px; background-color:#ffffff" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wtm">
			<tr>
			<td class="pfull font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #ffffff; line-height: 17px; padding: 20px; mso-line-height-rule:exactly; font-weight: normal" align="center" bgcolor="#000000">Practise social distancing by keeping a safe distance (at least 1.8m) between yourself and others.</td>
			</tr>
			<tr>
			<td class="pfull" style="padding: 30px 40px">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td><img style="display: block" border="0" style="display:block" border="0" src="'.$baseurl.'/images/1foryou_logo.png" alt="1foryou" width="58" height="39" /></td>
			</tr>
			<tr>
			<td class="pvert font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 14; color: #000000; line-height: 19px; padding: 30px 0px 20px 0px; mso-line-height-rule:exactly; font-weight: bold">Hi there,</td>
			</tr>
			<tr>
			<td class="pbot font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 14; color: #000000; line-height: 19px; padding: 0px 0px 30px 0px; mso-line-height-rule:exactly; font-weight: normal">Thanks for supporting 1ForYou.</td>
			</tr>
			<tr>
			<td>
			<table width="100%" class="custom-table" bgcolor="#efefef" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td class="phor" style="padding: 0px 20px">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td class="font15" style="font-family: Helvetica, Arial, sans-serif; font-size: 17px; color: #000000; line-height: 21px; padding: 20px 0px; mso-line-height-rule:exactly; font-weight: bold; border-bottom: 1px solid #dbdcdd">Your Electricity Voucher details are:</td>
			</tr>
			<tr>
			<td style="padding: 20px 0px">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">

			<tr>
				<td class="pbot2 font15" style="font-family: Helvetica, Arial, sans-serif; font-size: 17px; color: #000000; line-height: 21px; padding: 0px 0px 20px 0px; mso-line-height-rule:exactly;">

					'.$message.'
					<br><br>
					TOKEN VALID FOR 36 MONTHS ONLY

					<br><br>

				</td>
			</tr>

			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td class="ptop" style="padding: 30px 0px">
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td class="pbot2 font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000; line-height: 19px; padding: 0px 0px 20px 0px; mso-line-height-rule:exactly; font-weight: normal">Visit <a style="color: #ff5f00; font-weight: bold" href="https://www.1foryou.com">www.1foryou.com</a> to see the full list of 1ForYou partners and learn more about 1ForYou.</td>
			</tr>
			<tr>
			<td class="pbot2 font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000; line-height: 19px; padding: 0px 0px 20px 0px; mso-line-height-rule:exactly; font-weight: normal">The 1ForYou app lets you pay, top up, buy electricity, airtime, pay bills and much more! Download the 1ForYou app here: <a style="color: #ff5f00; font-weight: bold" href="https://1foryou.com/oneforyou-app/">(Play Store link)</a></td>
			</tr>
			<tr>
			<td class="pbot font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000; line-height: 19px; padding: 0px 0px 30px 0px; mso-line-height-rule:exactly; font-weight: normal">Have a great day further,</td>
			</tr>
			<tr>
			<td class="font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000; line-height: 19px; padding: 0px; mso-line-height-rule:exactly; font-weight: normal">The 1ForYou Team.</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td>
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td><img style="display: block" border="0" src="'.$baseurl.'/images/horse_top.png" alt="" width="277" height="20" /></td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td>
			<table class="wtm" style="width: 277px" width="277" cellpadding="0" cellspacing="0" border="0" align="left">
			<tr>
			<td bgcolor="#000000"><img style="display: block" border="0" src="'.$baseurl.'/images/horse_middle.png" alt="" width="277" height="280" /></td>
			</tr>
			<tr>
			<td class="custom-bg"><img style="display: block" border="0" src="'.$baseurl.'/images/horse_lower.png" alt="" width="277" height="20" /></td>
			</tr>
			</table>

			<!--[if mso]></td><td valign="top"><![endif]-->

			<table class="wtm" style="width: 323px" width="323" bgcolor="#000000" cellpadding="0" cellspacing="0" border="0" align="left">
			<tr>
			<td class="nomob"><img style="display: block" border="0" src="'.$baseurl.'/images/spacer.png" alt="" width="1" height="280" /></td>
			<td class="pfull" style="padding: 0px 0px 0px 30px" valign="top">
			<table class="wtm" style="width: 198" width="198" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td class="pnone" style="padding-top: 50px"><img style="display: block" border="0" src="'.$baseurl.'/images/The1FORYOUpartnernetwork.png" alt="" width="198" height="53" /></td>
			</tr>
			<tr>
			<td style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #ffffff; line-height: 17px; padding: 15px 0px 20px 0px; mso-line-height-rule:exactly; font-weight: normal">Our network is constantly growing, with new partners joining every month. Stay up to date with where you can use your vouchers.</td>
			</tr>
			<tr>
			<td><a href="https://1foryou.com/#our_partners"><img style="display: block" border="0" src="'.$baseurl.'/images/btn_network.png" alt="" width="162" height="32" /></a></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td class="pfull" style="padding: 30px 40px">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td>
			<table class="wtm" style="width: 434px" width="434" cellpadding="0" cellspacing="0" border="0" align="left">
			<tr>
			<td class="text-center" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #74767c; line-height: 18px; padding: 0px; mso-line-height-rule:exactly; font-weight: bold"><a style="color: #74767c" href="https://1foryou.com/">1ForYou Website</a>&nbsp; | &nbsp;<a style="color: #74767c" href="https://1foryou.com/terms">1ForYou T&amp;Cs</a>&nbsp; | &nbsp;<a style="color: #74767c" href="mailto:hello@1foryou.com">Contact us</a></td>
			</tr>
			</table>

			<!--[if mso]></td><td><![endif]-->

			<table class="wtm" style="width: 86px" width="86" cellpadding="0" cellspacing="0" border="0" align="left">
			<tr>
			<td class="ptop" align="center">
			<table cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
			<td style="padding-right: 10px"><a href="https://www.facebook.com/1foryouza/"><img style="display: block" border="0" src="'.$baseurl.'/images/icon_facebook.png" alt="Facebook" width="14" height="14" /></a></td>
			<td style="padding-right: 10px"><a href="https://www.instagram.com/1foryouza/"><img style="display: block" border="0" src="'.$baseurl.'/images/icon_insta.png" alt="Instagram" width="14" height="14" /></a></td>
			<td style="padding-right: 10px"><a href="https://twitter.com/1foryouza"><img style="display: block" border="0" src="'.$baseurl.'/images/icon_twitter.png" alt="Twitter" width="14" height="14" /></a></td>
			<td><a href="https://www.youtube.com/channel/UCCcrVZWVxgaX-5MAT8qxjvw"><img style="display: block" border="0" src="'.$baseurl.'/images/icon_youtube.png" alt="Youtube" width="14" height="14" /></a></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td class="pvert" style="padding: 30px 0px 20px 0px">
			<table class="wtm" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td align="center">
			<table cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
			<td><img style="display: block" border="0" src="'.$baseurl.'/images/flash_logo.png" alt="Flash logo" width="62" height="25" /></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td class="text-center" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #74767c; line-height: 18px; padding: 0px; mso-line-height-rule:exactly; font-weight: bold">&copy;1ForYou - Part of the <a style="color: #000000" href="https://flash.co.za/">Flash Group</a> | All rights reserved</a></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</body>

			<script type="text/javascript" src="http://livejs.com/live.js"></script>

			</html>';

		$subject = 'Your 1ForYou Voucher';

		$headers = array();
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		$headers[] = 'From: 1ForYou <no-reply@1foryou.com>';

		wp_mail( $email_address, $subject, $email_message, $headers );

	}




	function send_1FORYOU_voucher_sms( $mobile_number, $token, $expirydate, $serialnumber, $voucher_amount ) {

		// api url: https://flash.everlytic.net/api/2.0/production/sms/message
		// username: Devin
		// api key: g8jeXItAiM95qy7fp0mwsMaQy7jhAgzy_8

		$token = chunk_split($token, 4, ' ');

		$message = 'Your R'.$voucher_amount.' 1ForYou voucher: '.$token.' Expiry date: '.$expirydate. ' Serial: '.$serialnumber;

		$url = 'https://flash.everlytic.net/api/2.0/production/sms/message';

		$post = json_encode(['message' => $message,'mobile_number' => $mobile_number]);
		$username = 'Devin';
		$apiKey = 'g8jeXItAiM95qy7fp0mwsMaQy7jhAgzy_8';
		$cSession = curl_init();
		$headers = array(
			'Content-Type:application/json',
			'Content-Length:'.strlen($post)
		);
		curl_setopt($cSession, CURLOPT_URL, $url);
		curl_setopt($cSession, CURLOPT_USERPWD, $username . ":" . $apiKey);
		curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cSession, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($cSession, CURLOPT_POSTFIELDS, $post);
		curl_setopt($cSession, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($cSession);

		curl_close($cSession);

		print_r($result);

	}

	function send_1FORYOU_voucher_email( $email_address, $voucher, $expiry, $serial, $value ) {

		$baseurl = get_option('home').'/emailer';

		$voucher = chunk_split($voucher, 4, ' ');

		$email_message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
			<head>
			<title></title>
			<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
			<meta name="format-detection" content="date=no" />
			<meta name="format-detection" content="address=no" />
			<meta name="format-detection" content="telephone=no" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

			<style type="text/css">
			body {
				margin:0px;
				padding:0px;
			}

			p {
				margin:0px;
				padding:0px;
				display:none !important;
			}

			h1, h2, h3, h4, h5, h6 {
				color: #000 !important;
				line-height: 100%;
			}

			img {
				-ms-interpolation-mode: bicubic;
			}

			a img {
				border:none !important;
			}

			body {
				-webkit-text-size-adjust:none;
				-ms-text-size-adjust:none;
			}

			a[x-apple-data-detectors] {
				color: inherit !important;
				text-decoration: none !important;
				font-size: inherit !important;
				font-family: inherit !important;
				font-weight: inherit !important;
				line-height: inherit !important;
			}

			a[href^=tel],a[href^=sms]{
				color:inherit;
				cursor:default;
				text-decoration:underline;
			}

			.ExternalClass {
				width:100%;
			}

			.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
				line-height: 100%;
			}

			#outlook a {
				padding:0;
			}

			table, td {
				border-collapse: collapse;
				border-spacing: 0;
				mso-line-height-rule: exactly;
				mso-margin-bottom-alt: 0;
				mso-margin-top-alt: 0;
				mso-table-lspace: 0pt;
				mso-table-rspace: 0pt;
			}

			.custom-table {background-image: url('.$baseurl.'/images/bg.png) !important; background-repeat: repeat !important}

			@media screen and (max-width: 480px) {
				.wtm {width:100% !important; height:auto !important;}
				.nomob {display:none !important;}

				.pnone {padding:0px !important}
				.pfull {padding-top:20px !important; padding-bottom:20px !important; padding-left:15px !important; padding-right:15px !important}
				.pvert {padding-top:20px !important; padding-bottom:20px !important; padding-left:0px !important; padding-right:0px !important}
				.pvert2 {padding-top:15px !important; padding-bottom:15px !important; padding-left:0px !important; padding-right:0px !important}
				.phor {padding-top:0px !important; padding-bottom:0px !important; padding-left:15px !important; padding-right:15px !important}
				.phortop {padding-top:15px !important; padding-bottom:0px !important; padding-left:15px !important; padding-right:15px !important}
				.phorbot {padding-top:0px !important; padding-bottom:15px !important; padding-left:15px !important; padding-right:15px !important}
				.pbot {padding-top:0px !important; padding-bottom:20px !important; padding-left:0px !important; padding-right:0px !important}
				.pbot2 {padding-top:0px !important; padding-bottom:15px !important; padding-left:0px !important; padding-right:0px !important}
				.ptop {padding-top:20px !important; padding-bottom:0px !important; padding-left:0px !important; padding-right:0px !important}
				.ptop2 {padding-top:15px !important; padding-bottom:0px !important; padding-left:0px !important; padding-right:0px !important}

				.font13 {font-size:13px !important; line-height:19px !important}
				.font15 {font-size:15px !important; line-height:21px !important}
				.font18 {font-size:18px !important; line-height:24px !important}
				.font20 {font-size:20px !important; line-height:26px !important}
				.font22 {font-size:22px !important; line-height:28px !important}
				.font24 {font-size:24px !important; line-height:30px !important}
				.font32 {font-size:32px !important; line-height:38px !important}
				.font40 {font-size:40px !important; line-height:44px !important}

				.custom-bg {background-color: #000000 !important}
				.text-center {text-align: center !important}
			}

			</style>

			<!--[if gte mso 9]>
			<xml>
			  <o:OfficeDocumentSettings>
				<o:AllowPNG/>
				<o:PixelsPerInch>96</o:PixelsPerInch>
			 </o:OfficeDocumentSettings>
			</xml>
			<![endif]-->

			</head>

			<body style="padding:0; margin:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:100%">
			<table style="table-layout:fixed; width:100% !important" border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
			<tr>
			<td valign="top">
			<table style="width:600px; background-color:#ffffff" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wtm">
			<tr>
			<!-- <td style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #000000; line-height: px; padding: 20px; mso-line-height-rule:exactly; font-weight: normal" align="center">Is this not displaying properly? <a style="color: #ff5f00; font-weight: bold" href="#Online">View online</a>.</td>
			</tr> -->
			<tr>
			<td class="pfull font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #ffffff; line-height: 17px; padding: 20px; mso-line-height-rule:exactly; font-weight: normal" align="center" bgcolor="#000000">Practise social distancing by keeping a safe distance (at least 1.8m) between yourself and others.</td>
			</tr>
			<tr>
			<td class="pfull" style="padding: 30px 40px">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td><img style="display: block" border="0" style="display:block" border="0" src="'.$baseurl.'/images/1foryou_logo.png" alt="1foryou" width="58" height="39" /></td>
			</tr>
			<tr>
			<td class="pvert font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 14; color: #000000; line-height: 19px; padding: 30px 0px 20px 0px; mso-line-height-rule:exactly; font-weight: bold">Hi there,</td>
			</tr>
			<tr>
			<td class="pbot font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 14; color: #000000; line-height: 19px; padding: 0px 0px 30px 0px; mso-line-height-rule:exactly; font-weight: normal">Thanks for supporting 1ForYou.</td>
			</tr>
			<tr>
			<td>
			<table width="100%" class="custom-table" bgcolor="#efefef" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td class="phor" style="padding: 0px 20px">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td class="font15" style="font-family: Helvetica, Arial, sans-serif; font-size: 17px; color: #000000; line-height: 21px; padding: 20px 0px; mso-line-height-rule:exactly; font-weight: bold; border-bottom: 1px solid #dbdcdd">Your 1ForYou Voucher details are:</td>
			</tr>
			<tr>
			<td style="padding: 20px 0px">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #ff5f00; line-height: 16px; padding: 0px 0px 5px 0px; mso-line-height-rule:exactly; font-weight: bold">Value:</td>
			</tr>
			<tr>
			<td class="pbot2 font15" style="font-family: Helvetica, Arial, sans-serif; font-size: 17px; color: #000000; line-height: 21px; padding: 0px 0px 20px 0px; mso-line-height-rule:exactly; font-weight: bold">'.$value.'</td>
			</tr>
			<tr>
			<td style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #ff5f00; line-height: 16px; padding: 0px 0px 5px 0px; mso-line-height-rule:exactly; font-weight: bold">1ForYou PIN:</td>
			</tr>
			<tr>
			<td class="pbot2 font15" style="font-family: Helvetica, Arial, sans-serif; font-size: 17px; color: #000000; line-height: 21px; padding: 0px 0px 20px 0px; mso-line-height-rule:exactly; font-weight: bold">'.$voucher.'</td>
			</tr>
			<tr>
			<td style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #ff5f00; line-height: 16px; padding: 0px 0px 5px 0px; mso-line-height-rule:exactly; font-weight: bold">Serial Number:</td>
			</tr>
			<tr>
			<td class="font15" style="font-family: Helvetica, Arial, sans-serif; font-size: 17px; color: #000000; line-height: 21px; padding: 0px; mso-line-height-rule:exactly; font-weight: bold">'.$serial.'</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td class="ptop" style="padding: 30px 0px">
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td class="pbot2 font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000; line-height: 19px; padding: 0px 0px 20px 0px; mso-line-height-rule:exactly; font-weight: normal">Visit <a style="color: #ff5f00; font-weight: bold" href="https://www.1foryou.com">www.1foryou.com</a> to see the full list of 1ForYou partners and learn more about 1ForYou.</td>
			</tr>
			<tr>
			<td class="pbot2 font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000; line-height: 19px; padding: 0px 0px 20px 0px; mso-line-height-rule:exactly; font-weight: normal">The 1ForYou app lets you pay, top up, buy electricity, airtime, pay bills and much more! Download the 1ForYou app here: <a style="color: #ff5f00; font-weight: bold" href="https://1foryou.com/oneforyou-app/">(Play Store link)</a></td>
			</tr>
			<tr>
			<td class="pbot font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000; line-height: 19px; padding: 0px 0px 30px 0px; mso-line-height-rule:exactly; font-weight: normal">Have a great day further,</td>
			</tr>
			<tr>
			<td class="font13" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000; line-height: 19px; padding: 0px; mso-line-height-rule:exactly; font-weight: normal">The 1ForYou Team.</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td>
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td><img style="display: block" border="0" src="'.$baseurl.'/images/horse_top.png" alt="" width="277" height="20" /></td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td>
			<table class="wtm" style="width: 277px" width="277" cellpadding="0" cellspacing="0" border="0" align="left">
			<tr>
			<td bgcolor="#000000"><img style="display: block" border="0" src="'.$baseurl.'/images/horse_middle.png" alt="" width="277" height="280" /></td>
			</tr>
			<tr>
			<td class="custom-bg"><img style="display: block" border="0" src="'.$baseurl.'/images/horse_lower.png" alt="" width="277" height="20" /></td>
			</tr>
			</table>

			<!--[if mso]></td><td valign="top"><![endif]-->

			<table class="wtm" style="width: 323px" width="323" bgcolor="#000000" cellpadding="0" cellspacing="0" border="0" align="left">
			<tr>
			<td class="nomob"><img style="display: block" border="0" src="'.$baseurl.'/images/spacer.png" alt="" width="1" height="280" /></td>
			<td class="pfull" style="padding: 0px 0px 0px 30px" valign="top">
			<table class="wtm" style="width: 198" width="198" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td class="pnone" style="padding-top: 50px"><img style="display: block" border="0" src="'.$baseurl.'/images/The1FORYOUpartnernetwork.png" alt="" width="198" height="53" /></td>
			</tr>
			<tr>
			<td style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #ffffff; line-height: 17px; padding: 15px 0px 20px 0px; mso-line-height-rule:exactly; font-weight: normal">Our network is constantly growing, with new partners joining every month. Stay up to date with where you can use your vouchers.</td>
			</tr>
			<tr>
			<td><a href="https://1foryou.com/#our_partners"><img style="display: block" border="0" src="'.$baseurl.'/images/btn_network.png" alt="" width="162" height="32" /></a></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td class="pfull" style="padding: 30px 40px">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td>
			<table class="wtm" style="width: 434px" width="434" cellpadding="0" cellspacing="0" border="0" align="left">
			<tr>
			<td class="text-center" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #74767c; line-height: 18px; padding: 0px; mso-line-height-rule:exactly; font-weight: bold"><a style="color: #74767c" href="https://1foryou.com/">1ForYou Website</a>&nbsp; | &nbsp;<a style="color: #74767c" href="https://1foryou.com/terms">1ForYou T&amp;Cs</a>&nbsp; | &nbsp;<a style="color: #74767c" href="mailto:hello@1foryou.com">Contact us</a></td>
			</tr>
			</table>

			<!--[if mso]></td><td><![endif]-->

			<table class="wtm" style="width: 86px" width="86" cellpadding="0" cellspacing="0" border="0" align="left">
			<tr>
			<td class="ptop" align="center">
			<table cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
			<td style="padding-right: 10px"><a href="https://www.facebook.com/1foryouza/"><img style="display: block" border="0" src="'.$baseurl.'/images/icon_facebook.png" alt="Facebook" width="14" height="14" /></a></td>
			<td style="padding-right: 10px"><a href="https://www.instagram.com/1foryouza/"><img style="display: block" border="0" src="'.$baseurl.'/images/icon_insta.png" alt="Instagram" width="14" height="14" /></a></td>
			<td style="padding-right: 10px"><a href="https://twitter.com/1foryouza"><img style="display: block" border="0" src="'.$baseurl.'/images/icon_twitter.png" alt="Twitter" width="14" height="14" /></a></td>
			<td><a href="https://www.youtube.com/channel/UCCcrVZWVxgaX-5MAT8qxjvw"><img style="display: block" border="0" src="'.$baseurl.'/images/icon_youtube.png" alt="Youtube" width="14" height="14" /></a></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td class="pvert" style="padding: 30px 0px 20px 0px">
			<table class="wtm" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td align="center">
			<table cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
			<td><img style="display: block" border="0" src="'.$baseurl.'/images/flash_logo.png" alt="Flash logo" width="62" height="25" /></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td class="text-center" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #74767c; line-height: 18px; padding: 0px; mso-line-height-rule:exactly; font-weight: bold">&copy;1ForYou - Part of the <a style="color: #000000" href="https://flash.co.za/">Flash Group</a> | All rights reserved</a></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</body>

			<script type="text/javascript" src="http://livejs.com/live.js"></script>

			</html>';

		$subject = 'Your 1ForYou Voucher';

		$headers = array();
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		$headers[] = 'From: 1ForYou <no-reply@1foryou.com>';

		wp_mail( $email_address, $subject, $email_message, $headers );

	}


	function get_voucher_info() {

		$thetoken = get_sf_token();

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.switchfox.flash-group.com/giftvoucher/1.0.0/getvouchersinfo",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
			"Accept: application/json",
			"Authorization: Bearer ".$thetoken->access_token.""
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;

	}


	// generate-csv-report
	add_action( 'rest_api_init', function () {
		register_rest_route('nfh-remote/v1', '/generate-csv-report', array(
			'methods' => 'POST,GET',
			'callback' => 'nfh_generate_report'
		));
	} );

	function nfh_generate_report() {

		global $wpdb, $nf;

		$entries_header = array(
			'product id',
			'product description',
			'transaction reference_client',
			'transaction reference flash',
			'amount',
			'date',
			'time',
			'transaction_status',
			'unsuccessful_response'
		);

		$entries = $wpdb->get_results( "SELECT * FROM nfh_voucher_ftpdata WHERE sent='0'", ARRAY_A );

		if ( !empty($entries) ) {

			//$local_dir = '/var/www/wp-content/uploads/1voucher/';
			$local_dir = '/home/t7gb43417494473/html/wp-content/uploads/1voucher/';
			$target_file_name = date("Y-m-d-H-i-s") . '-' . strtolower($nf->random_value(3)) . '.csv';
			$local_file = $local_dir . $target_file_name;

			$file = fopen($local_file,"w");

			fputcsv($file, $entries_header);

			foreach ($entries as $line) {

				$line_id = $line['id'];

				unset($line['id']);
				unset($line['sent']);

				fputcsv($file, $line);

				$linedata = array(
					'sent' => '1'
				);

				$linewhere = array(
					'id' => $line_id
				);

				$wpdb->update( 'nfh_voucher_ftpdata', $linedata, $linewhere );
			}

			fclose($file);

			nfh_ftpput_report( $local_file, $target_file_name);

		}

		http_response_code(200);

	}


	function nfh_ftpput_report( $localfile, $filename) {

		global $wpdb, $nf;

		$ch = curl_init();

		$fp = fopen($localfile, 'r');

		curl_setopt($ch, CURLOPT_URL, 'sftp://1ForYou:ZUbw9cdGyVa63AcS@Transfer.flash.co.za/'.$filename);
		curl_setopt($ch, CURLOPT_PORT, 22);
		curl_setopt($ch, CURLOPT_UPLOAD, 1);
		curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
		curl_setopt($ch, CURLOPT_INFILE, $fp);
		curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localfile));
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_exec ($ch);

		$error_no = curl_errno($ch);
		$error_msg = curl_error($ch);

		curl_close($ch);

		if ($error_no == 0) {
			$output = 'File uploaded succesfully.';
			$nf->mail_print_r('info@ninjasforhire.co.za',error_get_last(),'1foryou: File uploaded succesfully');
		} else {
			$output = 'File upload error: ' . $error_msg;
			$nf->mail_print_r('info@ninjasforhire.co.za',error_get_last(),'1foryou csv upload failure');
			$nf->mail_print_r('info@ninjasforhire.co.za',$error_msg,'1foryou csv upload error message');
		}
		//echo $output;

		//echohttp_response_code(200);

	}



	/*
	 * super user settings
	 */


	$current_user = wp_get_current_user();
	if($current_user->user_login != 'ninjasforhire') {

		add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

		add_action('admin_menu', 'remove_menus', 102);
		function remove_menus() {

			global $submenu;

				remove_submenu_page( 'index.php', 'update-core.php' );
				remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );

			//remove_menu_page( 'pods' );

				remove_submenu_page( 'users.php', 'roles' );
				remove_submenu_page( 'users.php', 'role-new' );

			remove_menu_page( 'edit-comments.php' );
			remove_menu_page( 'link-manager.php' );
			remove_menu_page( 'tools.php' );

				remove_submenu_page( 'options-general.php', 'pagenavi' );
				remove_submenu_page( 'options-general.php', 'members-settings' );
				remove_submenu_page( 'options-general.php', 'options-permalink.php' );
				remove_submenu_page( 'options-general.php', 'options-media.php' );
				remove_submenu_page( 'options-general.php', 'options-reading.php' );
				remove_submenu_page( 'options-general.php', 'options-discussion.php' );

			remove_menu_page( 'edit.php?post_type=acf-field-group' );

				remove_submenu_page( 'options-general.php', 'wp-postviews/postviews-options.php' );

			remove_menu_page ( 'themes.php' );
			if($current_user->user_login != 'peachpayments') {
				remove_menu_page ( 'plugins.php' );
			}
			remove_menu_page ( 'duplicator' );

			remove_meta_box( 'tagsdiv-post_tag', 'post', 'Normal' );
			remove_meta_box( 'tagsdiv-post_tag', 'page', 'Normal' );

		}

		// remove updates from admin bar
		function disable_bar_updates() {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu('updates');
		}
		add_action( 'wp_before_admin_bar_render', 'disable_bar_updates' );

		// Custom Dashboard Function
		function remove_dashboard_widgets() {

			global $wp_meta_boxes;

			unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
			unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
			unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
			unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
			unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

		}

		// unset widgets
		add_action( 'widgets_init', 'my_unregister_widgets' );
		function my_unregister_widgets() {
			unregister_widget( 'WP_Widget_Pages' );
			unregister_widget( 'WP_Widget_Calendar' );
			unregister_widget( 'WP_Widget_Archives' );
			unregister_widget( 'WP_Widget_Links' );
			unregister_widget( 'WP_Widget_Categories' );
			unregister_widget( 'WP_Widget_Recent_Posts' );
			unregister_widget( 'WP_Widget_Search' );
			unregister_widget( 'WP_Widget_Tag_Cloud' );
			unregister_widget( 'WP_Widget_RSS' );
			unregister_widget( 'WP_Widget_Text' );
			unregister_widget( 'WP_Widget_Meta' );
			unregister_widget( 'WP_Widget_Recent_Comments' );
			unregister_widget( 'WP_Nav_Menu_Widget' );
			unregister_widget( 'FrmShowForm' );  //formidable
			unregister_widget( 'FrmListEntries' );  //formidable
		}

		// hide specific pages in back-end
		add_action( 'pre_get_posts' ,'exclude_this_page' );
		function exclude_this_page( $query ) {

			$pagearr = array(534,570,567,532);

			if( !is_admin() ) {
				return $query;
			}

			global $pagenow;

			if( 'edit-pages.php' == $pagenow ) {
				$query->set( 'post__not_in', $pagearr );
			}
			if( 'edit.php' == $pagenow && ( get_query_var('post_type') && 'page' == get_query_var('post_type') ) ) {
				$query->set( 'post__not_in', $pagearr );
			}

			return $query;
		}

		add_action('pre_user_query','admin_pre_user_query');
		function admin_pre_user_query($user_search) {
		  $user = wp_get_current_user();
		  if ($user->ID!=1) {
			global $wpdb;
			$user_search->query_where = str_replace('WHERE 1=1',
			  "WHERE 1=1 AND {$wpdb->users}.ID<>1",$user_search->query_where);
		  }
		}

		// hide plugins
		function hide_plugins() {
			global $wp_list_table;
			$hidearr = array(
				'ninja-embed-plugin/ninja_embed_plugin.php',
				'advanced-custom-fields/acf.php',
				'wp-postviews/wp-postviews.php'
			);
			$myplugins = $wp_list_table->items;
			foreach ($myplugins as $key => $val) {
				if (in_array($key,$hidearr)) {
					unset($wp_list_table->items[$key]);
				}
			}
		}
		add_action( 'pre_current_active_plugins', 'hide_plugins' );

		remove_action( 'load-update-core.php', 'wp_update_plugins' );
		//add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );

	}

	// custom admin styles
	add_action('admin_head', 'my_custom_styles');
	function my_custom_styles() {
		echo '
			<style type="text/css">

				#wp-version-message {
					display: none;
				}

			</style>
		';
	}

function sponsored_logos() {

	ob_start(); ?>
	<?php
	if( have_rows('sponsored_logos') ): ?>
		<div class="sponsored-wrapper">
			<?php while ( have_rows('sponsored_logos') ) : the_row(); ?>
				<div class="logo">
					<img src="<?php the_sub_field('logo'); ?>" alt="">
				</div>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
	<?php return ob_get_clean();
}
add_shortcode( 'logos', 'sponsored_logos' );



function misha_my_load_more_scripts() {

	global $wp_query;

	// In most cases it is already included on the page and this line can be removed
	wp_enqueue_script('jquery');

	// register our main script but do not enqueue it yet
	wp_register_script( 'my_loadmore', get_stylesheet_directory_uri() . '/dist/js/loadmore.js', array('jquery') );

	// now the most interesting part
	// we have to pass parameters to myloadmore.js script but we can get the parameters values only in PHP
	// you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
	wp_localize_script( 'my_loadmore', 'misha_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );

	wp_enqueue_script( 'my_loadmore' );
}

add_action( 'wp_enqueue_scripts', 'misha_my_load_more_scripts' );

function misha_loadmore_ajax_handler(){
	global $nf;

	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';

	// it is always better to use WP_Query but not here
	query_posts( $args );

	if (have_posts()):
		$count = 0;
		$post_no = 0;
		while ( have_posts() ) : the_post();
			$post_no++;
			$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
			$cat = get_the_category();
		?>

			<div class="news-row card-group card-<?php echo $post_no;?> flex">
				<a href="<?php the_permalink(); ?>" class="card">
					<div class="card-inner" animate>

						<div class="card-image">

							<img src="<?php echo $nf->image($image,351,384); ?>" alt="">

						</div>
						<?php
							if( have_rows('sponsored_logos') ): ?>
								<div class="sponsored">
									<?php while ( have_rows('sponsored_logos') ) : the_row(); ?>

										<img src="<?php the_sub_field('logo'); ?>" alt="">

									<?php endwhile; ?>
								</div>
							<?php endif; ?>


						<h5>

							<?php echo $cat[0]->name ?> / <?php echo get_the_date('d.m.y'); ?>

						</h5>
						<h3 class="title">

							<?php the_title(); ?>

						</h3>
						<div class="card-body">

							<?php the_excerpt(); ?>

						</div>
						<div class="btn flex">

							<div class="button button-secondary" target="">Read More
							<span class="hvr-forward"><?php include (TEMPLATEPATH . '/images/svg/arrow-right.svg'); ?></span>
							</div>

						</div>
					</div>
				</a>
			</div>
		<?php endwhile; ?>
	<?php endif;
	die;
}
add_action('wp_ajax_loadmore', 'misha_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_loadmore', 'misha_loadmore_ajax_handler');



function Generate_Featured_Image( $image_url, $post_id  ){
	$upload_dir = wp_upload_dir();
	$image_data = file_get_contents($image_url);
	$filename = basename($image_url);
	if(wp_mkdir_p($upload_dir['path']))
	  $file = $upload_dir['path'] . '/' . $filename;
	else
	  $file = $upload_dir['basedir'] . '/' . $filename;
	file_put_contents($file, $image_data);

	$wp_filetype = wp_check_filetype($filename, null );
	$attachment = array(
		'post_mime_type' => '.jpg',
		'post_title' => sanitize_file_name($filename),
		'post_content' => '',
		'post_status' => 'inherit'
	);
	$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
	$res1= wp_update_attachment_metadata( $attach_id, $attach_data );
	$res2= set_post_thumbnail( $post_id, $attach_id );
}



// add_action( 'rest_api_init', function () {
// 	register_rest_route( 'nfh-remote/v1', '/instagramend', array(
// 		'methods' => 'POST,GET',
// 		'callback' => function() {
// 			return instaendpoint( $_POST );
// 		}

// 	) );
// } );



/*
 * Voucher Purchases
 */

// allow for custom prices on name your price voucher
function woocommerce_custom_price_to_cart_item( $cart_object ) {
	if( !WC()->session->__isset( "reload_checkout" )) {
		foreach ( $cart_object->cart_contents as $key => $value ) {
			if( isset( $value["custom_price"] ) ) {
				$value['data']->set_price($value["custom_price"]);
			}
		}
	}
}
add_action( 'woocommerce_before_calculate_totals', 'woocommerce_custom_price_to_cart_item', 99 );


// custom checout field values
function kia_checkout_field_defaults( $fields ) {

//	$fields['billing']['billing_first_name'] = 'Firstname';

//	$fields['billing']['billing_last_name'] = 'Surname';

	$fields['billing']['billing_email'] = 'hello@1foryou.com';
	$fields['billing']['billing_company'] = '1ForYou';
	$fields['billing']['billing_address_1'] = 'billing_address_1';
	$fields['billing']['billing_address_2'] = 'billing_address_2';
	$fields['billing']['billing_city'] = 'Cape Town';
	$fields['billing']['billing_postcode'] = '8001';
	$fields['billing']['billing_country'] = 'South Africa';
	$fields['billing']['billing_state'] = 'Western Cape';
	$fields['billing']['billing_phone'] = '0839035274';

	return $fields;

}
add_filter( 'woocommerce_checkout_fields' , 'kia_checkout_field_defaults' );

function change_billing_email_checkout_field_value( $order, $data ){

//	$order->set_billing_first_name( 'Firstname' );
//	$order->set_billing_last_name( 'Surname' );
	$order->set_billing_address_1( 'billing_address_1' );
	$order->set_billing_postcode( '8001' );
	$order->set_billing_city( 'Cape Town' );
	$order->set_billing_state( 'WC' );
	$order->set_billing_country( 'ZA' );
}
add_action( 'woocommerce_checkout_create_order', 'change_billing_email_checkout_field_value', 10, 2 );



function nfh_order_details_logging( $order_id, $message ) {
    global $wpdb;
    $wpdb->insert('wp_custom_orders_log', array(
        'OrderID' => $order_id,
        'Message' => $message,
        'Date' => date("l jS \of F Y h:i:s A"),
    ));
}

// process logging for each step tied together with order number
function nfh_order_process_logging( $order_id, $message ) {

    global $wpdb;

	// setting folder for logs
	//$folder = '/usr/www/users/nnjsfrhre/onevoucher/wp-content/order_process_logging';
	$folder = get_stylesheet_directory() . '/order_process_logging';
	if( !is_dir($folder) ){
		mkdir($folder);
	}

	// check if file for order exist
	$output_filename = 'order_'.$order_id.'.txt';
	if(!is_file($folder.'/'.$output_filename)){

	    $contents = 'Order: ' . $order_id . "\r\n" . PHP_EOL;

		$fp1 = fopen($folder.'/'.$output_filename, 'a');
		fwrite($fp1, $contents);
	}

	$add_data = $message . '' . "\r\n" . PHP_EOL;
	$fp2 = fopen($folder.'/'.$output_filename, 'a');
	fwrite($fp2, $add_data);

    $wpdb->insert('wp_checkout_log', array(
        'OrderID' => $order_id,
        'Message' => $message,
        'Date' => date("l jS \of F Y h:i:s A"),
    ));

	return true;

}


// instagram
function instaendpoint___x($data) {

	global $nf;

	$args = array(
		'post_type' => 'instagram',
		'posts_per_page' => -1,
	);

	$the_query = new WP_Query( $args );
	$insta_posts = array();
	if ( $the_query->have_posts() ) {
	    while ( $the_query->have_posts() ) : $the_query->the_post();
	    	$insta_posts[] = get_field('image_id');
	    endwhile;
	}
	wp_reset_postdata();


	// Get all the Ids we need
	$instaidsraw = array();
	foreach ($data as $a) {
		foreach ($a as $b) {
			foreach ($b as $c) {
				$instaidsraw[] = array(
					'id' => $c[0],
					'url' => $c[1]
				);
			}
		}
	}

	$instaids = array_reverse($instaidsraw);

	foreach ($instaids as $m) {

		if (in_array ( $m['id'] , $insta_posts)) {
			//echo "yes we have this, do nothing";

		} else {
			//echo "nope we need to add it in\n";
			//echo $m->media_url;

			$post_id = wp_insert_post(array (
			   'post_type' => 'instagram',
			   'post_title' => $m['id'],
			   'post_status' => 'publish',
			));

			if ($post_id) {
				update_post_meta($post_id, 'image_id', $m['id'] );
				update_post_meta($post_id, 'set_to_carousel', '1' );


				$image_url        = $m['url']; // Define the image URL here
				$image_name       = 'instagram.png';
				$upload_dir       = wp_upload_dir(); // Set upload folder
				$image_data       = file_get_contents($image_url); // Get image data
				$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
				$filename         = basename( $unique_file_name ); // Create image file name

				// Check folder permission and define file location
				if( wp_mkdir_p( $upload_dir['path'] ) ) {
				    $file = $upload_dir['path'] . '/' . $filename;
				} else {
				    $file = $upload_dir['basedir'] . '/' . $filename;
				}

				// Create the image  file on the server
				file_put_contents( $file, $image_data );

				// Check image file type
				$wp_filetype = wp_check_filetype( $filename, null );

				// Set attachment data
				$attachment = array(
				    'post_mime_type' => $wp_filetype['type'],
				    'post_title'     => sanitize_file_name( $filename ),
				    'post_content'   => '',
				    'post_status'    => 'inherit'
				);

				// Create the attachment
				$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

				// Include image.php
				require_once(ABSPATH . 'wp-admin/includes/image.php');

				// Define attachment metadata
				$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

				// Assign metadata to attachment
				wp_update_attachment_metadata( $attach_id, $attach_data );

				// And finally assign featured image to post
				set_post_thumbnail( $post_id, $attach_id );
			}

		}
	}
}



	// set transaction id
	// function set_trans_id($order_id){

	// 	global $nf;

	// 	$order = wc_get_order( $order_id );



	// 	$order->set_transaction_id('hello_world_002');

	// 	$order->save();

	// 	$nf->mail_print_r( 'gerhard@ninjasforhire.co.za', $order, 'order' );

	// }
	// add_action( 'woocommerce_new_order', 'set_trans_id',  1, 1  );
	// add_action( 'woocommerce_before_pay_action', 'update_order_transaction_id' , 10, 1 );



//Make sure each item added to cart is treated seperately
function separate_individual_cart_items( $cart_item_data, $product_id ) {
    $unique_cart_item_key = md5( microtime() . rand() );
    $cart_item_data['unique_key'] = $unique_cart_item_key;

    return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'separate_individual_cart_items', 10, 2 );


function my_enqueue() {
    wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/js/my-ajax-script.js', array('jquery') );
    wp_localize_script( 'ajax-script', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue' );


function get_cart_details() {

    $response = array();

    $response['state'] = true;
    $response['cart_count'] = WC()->cart->get_cart_contents_count();
    $response['cart_total'] = WC()->cart->get_total();

    echo json_encode($response);

    wp_die();
}

add_action( 'wp_ajax_nopriv_get_cart_details', 'get_cart_details' );
add_action( 'wp_ajax_get_cart_details', 'get_cart_details' );

function delete_cart_item() {

    $remove_prod = WC()->cart->remove_cart_item( $_POST['key'] );

    $response = array();

    $response['state'] = $remove_prod;
    $response['cart_count'] = WC()->cart->get_cart_contents_count();
    $response['cart_total'] = WC()->cart->get_total();

    echo json_encode($response);

//    return json_encode($response);

    wp_die();
}

add_action( 'wp_ajax_nopriv_delete_cart_item', 'delete_cart_item' );
add_action( 'wp_ajax_delete_cart_item', 'delete_cart_item' );

function quantity_cart_item() {

//    var_dump($_POST['key']);
//    var_dump($_POST['quant']);

    $update_quantity = WC()->cart->set_quantity( $_POST['key'], $_POST['quant'] );

    var_dump($update_quantity);

    wp_die();
}

add_action( 'wp_ajax_nopriv_quantity_cart_item', 'quantity_cart_item' );
add_action( 'wp_ajax_quantity_cart_item', 'quantity_cart_item' );

function add_cart_item() {

    $prod_details = explode('&',$_POST['prodData']);

    var_dump($prod_details);
    if (strpos($prod_details[0], 'selected') !== false) {
        $product = explode('=', $prod_details[0])[1];
        $quantity = explode('=', $prod_details[1])[1];
    } else {
        $product = explode('=', $prod_details[2])[1];
        $quantity = explode('=', $prod_details[3])[1];
        $price = explode('=', $prod_details[1])[1];
    }

    $add_prod = WC()->cart->add_to_cart( $product, $quantity,0,array(),array('custom_price' => $price) );

    wp_die();
}

add_action( 'wp_ajax_nopriv_add_cart_item', 'add_cart_item' );
add_action( 'wp_ajax_add_cart_item', 'add_cart_item' );


function reload_cart() {

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $product = $cart_item['data'];
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];
        $price = WC()->cart->get_product_price( $product );
        $cp = $cart_item['custom_price'];
        $subtotal = WC()->cart->get_product_subtotal( $product, $cart_item['quantity'] );
        $link = $product->get_permalink( $cart_item );
        $attributes = $product->get_attributes();
        $whatever_attribute = $product->get_attribute( 'whatever' );
        $whatever_attribute_tax = $product->get_attribute( 'pa_whatever' );
        $meta = wc_get_formatted_cart_item_data( $cart_item );
        $tags = get_the_terms( $product_id, 'product_tag' );
        $tag_logo = get_field('tag_logo', 'product_tag_'.$tags[0]->term_id);


        ?>
        <div class="cart-item">

            <div class="cart_item_top">

                <img src="<?php echo $tag_logo; ?>"/>

                <div class="cart_item_top_info">
                    <h3><?php echo $tags[0]->name; ?></h3>
                    <span>3 Month membership (R190)</span>
                    <button class="editcartitem">
                        <span>Edit</span>
                        <?php include (TEMPLATEPATH . '/images/vouchers/svg/icon_edit.svg'); ?>
                    </button>
                </div>

                <div onclick="removeProd(this)" data-prod_id="<?php echo $product_id; ?>" data-cart_key="<?php echo $cart_item_key; ?>" class="remove-prod">
                </div>

            </div>

            <div class="cart_item_lower">

                <div class="number_spinner">
                        <span class="ns-btn" data-cart_key="<?php echo $cart_item_key; ?>" onclick="AdjustQuantity(this)">
                        <a data-dir="dwn"><?php include (TEMPLATEPATH . '/images/vouchers/svg/spinner_minus.svg'); ?></a>
                        </span>

                    <input type="number" class="pl-ns-value" value="<?php echo $quantity; ?>"  min="0" max="10000">
                    <span class="ns-btn" data-cart_key="<?php echo $cart_item_key; ?>" onclick="AdjustQuantity(this)">
                        <a data-dir="up"><?php include (TEMPLATEPATH . '/images/vouchers/svg/spinner_plus.svg'); ?></a>
                        </span>
                </div>

                <span class="price">
                   <?php
                   if($cp) {
                       echo 'R'.$cp.'.00';
                   } else {
                       echo $price;
                   } ?>
                </span>
            </div>

        </div>
    <?php }

    wp_die();
}

add_action( 'wp_ajax_nopriv_reload_cart', 'reload_cart' );
add_action( 'wp_ajax_reload_cart', 'reload_cart' );


add_action('wp_ajax_getupdateOrderMeta', 'updateOrderMeta');
add_action('wp_ajax_nopriv_getupdateOrderMeta', 'updateOrderMeta');

function updateOrderMeta() {

    global $woocommerce;


    if($_POST['delType'] == 'Single'){

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

            $woocommerce->cart->cart_contents[$cart_item_key]['del_method'] = $_POST['delMethod'];
            $woocommerce->cart->cart_contents[$cart_item_key]['del_value'] = $_POST['delValue'];
            $woocommerce->cart->set_session();
        }

    } else {
        foreach ($_POST['cartItems'] as $cartItem) {
            $method = explode('|',$cartItem)[2];
            $val = explode('|',$cartItem)[1];
            $key = explode('|',$cartItem)[0];

            $woocommerce->cart->cart_contents[$key]['del_method'] = $method;
            $woocommerce->cart->cart_contents[$key]['del_value'] = $val;
            $woocommerce->cart->set_session();
        }
    }

    die(); }


// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_phone']);
    return $fields;
}


function my_admin_menu() {
    add_menu_page(
        __( 'Log Page', 'order-logs' ),
        __( 'Log Page', 'order-logs' ),
        'manage_options',
        'order-logs',
        'my_order_logs',
        'dashicons-schedule',
        1
    );
}

add_action( 'admin_menu', 'my_admin_menu' );


function my_order_logs() {
    ?>
    <h1>
        <?php esc_html_e( 'Order Logs', 'my-plugin-textdomain' ); ?>

        <form action="/wp-admin/admin.php?page=order-logs" method="POST">
            <label for="order_number">Order Number</label>
            <input name="order_number" id="order_number" type="text" />
            <input type="hidden" value="get_order">
            <button>Get Order</button>
        </form>
        <?php


        if($_POST['order_number']){
            global $wpdb;
            $checkout_logs = $wpdb->get_results( "SELECT * FROM wp_custom_orders_log WHERE OrderID =".$_POST['order_number'] , ARRAY_A );
            $order_logs = $wpdb->get_results( "SELECT * FROM wp_checkout_log WHERE OrderID =".$_POST['order_number'] , ARRAY_A );
            ?>
                <h3>Order Detail Logs</h3>
                <table id="checkout-logs">
                    <thead>
                        <tr>
                            <td>Order ID</td>
                            <td>Message</td>
                            <td>Time</td>
                        </tr>
                    </thead>

                        <?php foreach ($checkout_logs as $log){ ?>
                        <tr>
                            <td><?php echo $log['OrderID'];?></td>
                            <td><?php echo $log['Message'];?></td>
                            <td><?php echo $log['Date'];?></td>
                        </tr>
                       <?php } ?>

                </table>

            <h3>Checkout Process Logs</h3>
            <table id="checkout-logs">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Message</td>
                    <td>Time</td>
                </tr>
                </thead>

                <?php foreach ($order_logs as $log){ ?>
                    <tr>
                        <td><?php echo $log['OrderID'];?></td>
                        <td><?php echo $log['Message'];?></td>
                        <td><?php echo $log['Date'];?></td>
                    </tr>
                <?php } ?>

            </table>

        <?php }
        ?>
    </h1>
    <?php



}

?>
