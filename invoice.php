<?php

include_once '../../../wp-load.php';
include_once("/wp-config.php");
include_once("/wp-includes/wp-db.php");

global $wpdb;

//die();

$sql = "SELECT *  FROM wp_posts WHERE post_type LIKE 'shop_order' AND `post_password` LIKE '{$_POST["ReferenceNumber"]}'";

$results = $wpdb->get_results($sql);
$order = new WC_Order($results[0]->ID);

ob_start();
 ?>
<html>
<head>
    <style>

        body {font-family: 'circular';
        }
        p {	margin: 0pt; font-family: 'circular';}
        table.items {
            /*border: 0.1mm solid #000000;*/
        }
        td {  }
        .items td {
            /*border-left: 0.1mm solid #000000;*/
            /**/
            /*border-bottom: 0.1mm solid #000000;*/
            border: 0.1mm solid #000000;
            height: 38px;
            /*line-height: 38px;*/
            text-align: left;
            padding: 15px 15px;
        }

        table thead td { background-color: #EEEEEE;
            text-align: left;
            border: 0.1mm solid #000000;
            font-variant: small-caps;
            font-size:15px;
            height: 25px !important;
        }
        .items td.blanktotal {
            background-color: #EEEEEE;
            border: 0.1mm solid #000000;
            background-color: #FFFFFF;
            border: 0mm none #000000;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
            text-align: left;
        }
        .items td.totals {
            text-align: left;
            border: 0.1mm solid #000000;
        }
        .items td.cost {
            text-align: "." center;
        }

        svg {
            max-width: 20px;
            transform: scale(0.3);
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="50%" style="color:#000; "><span style="font-weight: bold; font-size: 14pt;"><svg width="159" height="43" viewBox="0 0 159 43" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_697_1949)">
<path d="M50.5 10.0596H53.6232L59.9642 28.3008L66.2737 10.0596H69.4284L61.5882 31.9232H58.3087L50.5 10.0596Z" fill="black"/>
<path d="M67.834 24.1158C67.834 19.4934 71.488 15.9011 76.0486 15.9011C80.6093 15.9011 84.2948 19.4934 84.2948 24.1158C84.2948 28.7382 80.6093 32.3304 76.0486 32.3304C71.488 32.3304 67.834 28.7382 67.834 24.1158ZM81.5777 24.1158C81.5777 20.961 79.1732 18.5566 76.0486 18.5566C72.9241 18.5566 70.5512 20.961 70.5512 24.1158C70.5512 27.2705 72.9556 29.675 76.0486 29.675C79.1417 29.675 81.5777 27.2705 81.5777 24.1158Z" fill="black"/>
<path d="M99.7227 16.3071V31.9244H97.0055V29.675C95.8492 31.5184 94.132 32.3304 91.9456 32.3304C88.2916 32.3304 85.8857 29.8944 85.8857 25.8962V16.3071H88.6029V25.7398C88.6029 28.3006 90.0706 29.7381 92.4764 29.7381C94.8822 29.7381 97.0055 28.2704 97.0055 24.5849V16.3085H99.7227V16.3071Z" fill="black"/>
<path d="M101.563 24.1158C101.563 19.4934 105.061 15.9011 109.778 15.9011C112.87 15.9011 115.494 17.5251 116.682 19.9927L114.402 21.304C113.621 19.6484 111.873 18.5552 109.779 18.5552C106.656 18.5552 104.282 20.9597 104.282 24.1144C104.282 27.2691 106.656 29.6434 109.779 29.6434C111.903 29.6434 113.621 28.5502 114.495 26.9262L116.806 28.2691C115.495 30.7051 112.84 32.3291 109.778 32.3291C105.061 32.3291 101.563 28.7368 101.563 24.1144V24.1158Z" fill="black"/>
<path d="M131.984 22.3356V31.9246H129.267V22.492C129.267 19.9311 127.8 18.4937 125.394 18.4937C122.988 18.4937 120.865 19.9613 120.865 23.6469V31.9233H118.147V10.0596H120.865V18.5554C122.021 16.7119 123.738 15.8999 125.925 15.8999C129.579 15.8999 131.984 18.3359 131.984 22.3342V22.3356Z" fill="black"/>
<path d="M142.072 29.7684C144.227 29.7684 145.789 28.7685 146.569 27.4888L148.881 28.8C147.506 30.9233 145.132 32.3292 142.009 32.3292C136.98 32.3292 133.638 28.8 133.638 24.1146C133.638 19.4291 136.949 15.8999 141.821 15.8999C146.693 15.8999 149.598 19.7734 149.598 24.1461C149.598 24.5521 149.566 24.9581 149.505 25.3641H136.418C136.949 28.1759 139.167 29.7684 142.072 29.7684ZM136.418 22.9898H146.851C146.381 19.8982 144.165 18.4607 141.822 18.4607C138.886 18.4607 136.856 20.2726 136.418 22.9898Z" fill="black"/>
<path d="M159 16.0261V18.8681C156.658 18.7749 154.128 19.9613 154.128 23.6469V31.9232H151.411V16.3073H154.128V18.9312C155.128 16.7449 157.033 16.0261 159 16.0261Z" fill="black"/>
<path d="M36.2342 0H6.0516C2.70896 0 0 2.70896 0 6.0516V36.2342C0 39.5768 2.70896 42.2858 6.0516 42.2858H36.2342C39.5755 42.2858 42.2858 39.5768 42.2858 36.2342V6.0516C42.2858 2.70896 39.5768 0 36.2342 0ZM17.4635 16.6584C17.4635 16.8751 17.3456 17.0657 17.1714 17.1933C16.9917 17.325 16.6652 17.5444 16.4787 17.6501C16.262 17.7735 16 17.7858 15.7915 17.6501L10.2488 14.9493C9.85923 14.7011 9.85649 14.1332 10.2433 13.8795L16.4787 9.20497C16.9025 8.9279 17.4649 9.23103 17.4649 9.73716V16.6556L17.4635 16.6584ZM27.6026 35.857C27.6026 36.6073 26.7659 37.0558 26.1418 36.6402L19.5059 32.2263C19.2439 32.0521 19.0861 31.7517 19.0861 31.4362C19.0861 25.4916 19.0861 7.66601 19.0861 7.66601C19.0861 6.91573 19.9201 6.46721 20.5456 6.88144L26.5409 10.8523C27.2034 11.2912 27.6026 12.0333 27.6026 12.8274V35.857Z" fill="black"/>
</g>
<defs>
<clipPath id="clip0_697_1949">
<rect width="159" height="42.2844" fill="white"/>
</clipPath>
</defs>
</svg>
</span></td>
<td width="50%" style="text-align: right;">
<span style="font-size: 12px;"><strong>Website:</strong> www.1voucher.co.za</span><br />
<span style="font-size: 12px;"><strong>Email:</strong> hello@1voucher.co.za</span><br />
<span style="font-size: 12px;"><strong>Tel:</strong> 086 169 3333</span>
</td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: left; padding-top: 3mm; ">
This statement is valid for a period of 90 days from the date of order. Download your statement should you require it for longer than the stipulated number of days
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<hr style="margin:0; padding: 0; height: 0;" />
<table width="100%" style="margin-bottom: 50px; margin-top: 50px;">
    <tbody>
    <tr>
        <td style="text-align: left;">
            <div style="font-size: 16px; line-height: 20px; letter-spacing: 0.005em; padding-bottom: 10px;"><strong>ORDER SUMMARY</strong></div>
            <div style="font-size: 12px; line-height: 20px; padding-bottom: 10px;"><strong>Order Number: </strong> #<?php echo $order->get_id(); ?></div>
            <div style="font-size: 12px; line-height: 20px; padding-bottom: 10px;"><strong>Date: </strong> <?php echo $order->get_date_paid()->date('d M Y'); ?></div>
        </td>
        <td style="text-align: right;"><span style="font-size: 12px;"><strong>Client name: </strong><?php echo $order->get_billing_first_name().' '.$order->get_billing_last_name(); ?></span></td>
    </tr>
    </tbody>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>
    <tr>
        <td width="20%"><strong>VOUCHER</strong></td>
        <td width="20%"><strong>STATUS</strong></td>
        <td width="20%"><strong>DELIVERED TO</strong></td>
        <td width="20%"><strong>EXPIRY</strong></td>
        <td width="20%"><strong>VOUCHER SERIAL</strong></td>
        <td width="20%"><strong>QUANTITY</strong></td>
        <td width="20%"><strong>AMOUNT</strong></td>
    </tr>
    </thead>
    <tbody>

    <?php $count = 0;
    foreach ( $order->get_items() as $item_key => $item ) {
        $count++;
        $order_meta = $order->get_meta('Cart_ID_'.$count);
        $order_delivery_method = $order->get_meta('DelValue - '.$order_meta);
        $voucher_code = $order->get_meta('serialNumber - '.$order_meta);
        $voucher_exp = $order->get_meta('VoucherExpiry - '.$order_meta);
        $product_id = $item->get_product_id();
        $product_title = get_the_title($product_id);
        $quantity = $item->get_quantity();
        $total = $item->get_total();
        $order_meta = $item->get_meta('_Cart_ID_1');
        $terms = get_the_terms( $product_id, 'product_tag' );
        $tag_logo = get_field('tag_logo', 'product_tag_'.$terms[0]->term_id);
        $trans_id = wc_get_order_item_meta( $item_key, 'Cart_ID_1', true );
        $serial = wc_get_order_item_meta( $item_key, 'serialNumber', true );
        if(!$tag_logo){
            $tag_logo = "https://place-hold.it/345x229?text=Image Pending&italic=true";
        }
        ?>

        <tr>
            <td align="left"><span style="font-size: 11px;"><?php echo $product_title; ?></span></td>
            <td align="left"><span style="font-size: 11px;"><?php if($voucher_code){
                    echo 'Voucher Sent';
                } else {
                    echo 'Something went wrong For assistance contact us on 086 1693 333 or email hello@1voucher.co.za” to the something went wrong message';
                } ?></span></td>
            <td><span style="font-size: 11px;"><?php echo $order_delivery_method; ?></span></td>
            <td align="left" class="cost"><span style="font-size: 11px;"><?php if($voucher_exp){ echo $voucher_exp; } else { echo 'N/A';} ?></span></td>
            <td align="left" class="cost"><span style="font-size: 11px;"><?php echo $voucher_code; ?></span></td>
            <td align="left" class="cost"><span style="font-size: 11px;"><?php echo $quantity; ?></span></td>
            <td align="left" class="cost"><span style="font-size: 11px;">R<?php echo $total; ?></span></td>
        </tr>
    <?php } ?>
    <tr>
        <td class="blanktotal" colspan="5" rowspan="7"></td>
        <td class="totals"><strong>Total:</strong></td>
        <td class="totals cost"><strong>R<?php echo $order->get_total(); ?></strong></td>
    </tr>
    <tr>
        <td class="totals"><strong>Balance Due:</strong></td>
        <td class="totals cost"><strong>R<?php echo $order->get_total(); ?></strong></td>
    </tr>
    </tbody>
</table>
</body>
</html>
<?php
$output = ob_get_contents();
ob_end_clean();

//    $path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
require_once get_template_directory().'/mpdf/vendor/autoload.php';


$mpdf = new \Mpdf\Mpdf([
'margin_left' => 20,
'margin_right' => 15,
'margin_top' => 48,
'margin_bottom' => 25,
'margin_header' => 10,
'margin_footer' => 10
]);

$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("1ForYou. - Invoice");
$mpdf->SetAuthor("1ForYou.");
//$mpdf->SetWatermarkText("Paid");
//$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');

$mpdf->WriteHTML($output);

$name = $_POST['ReferenceNumber'].'.pdf';
$mpdf->Output($name, 'D');
