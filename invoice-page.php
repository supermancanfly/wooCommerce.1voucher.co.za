<?php
/*
    Template Name: Invoice Generator
*/

get_header();

global $woocommerce;

$invoice_template = get_template_directory_uri().'/invoice.php';

?>
<style>
.cta_buynow { right: 20px !important; }  
@media (min-width:1024px) {
.cta_buynow { right: 0px !important; }  
}
</style> 

<div class="data-bg" data-bg="theme-light-bg"></div>
<div class="section invoicevouchers-page white-bg">

<div class="container">
<div class="invoicevouchers-outer">

    <!-- start: invoicevouchers_left -->
    <div class="invoicevouchers_left">
        <h6>Order Statement</h6>
        <h2>Download YOUR 1voucher Order Summary.</h2>
    </div>
    <!-- end: invoicevouchers_left -->

    <!-- start: invoicevouchers_right -->
    <div class="invoicevouchers_right">

        <!-- start : invoice_vouchers -->
        <div class="invoice_vouchers">
            <h3>Get your order Summary.</h3>
            <p>Enter your 10 digit 1Voucher reference number number to download & view your order statement.</p>

            <div class="order-validation" style="display: none;">
                <ul id="validation-messages">

                </ul>
            </div>

            <form class="getYourInoivce" method="post" action="<?php echo $invoice_template; ?>">
               
                <input type="text" placeholder="Reference Number" name="ReferenceNumber" id="ReferenceNumber" value="<?php echo $_GET['id']; ?>"  required/>
                <input type="hidden" name="html">

                <div class="checkbox_inv">
                    <input type="checkbox" id="confirmation" name="confirmation" required>
                    <label for="confirmation">Confirmation</label>
                </div>

                <!-- codenote: button below currently has 'inactive' class  -->
                <button class="btn_getinvoice button button-primary">Get PDF</button>
                

            </form>
        </div>
        <!-- end : invoice_vouchers -->

    </div>
    <!-- end : invoicevouchers_right -->

</div>
</div>

</div>

<script>
jQuery( document ).ready(function() {
    jQuery( ".btn_getinvoice" ).on( "click", function( event ) {
        event.preventDefault();

        var formdata = $( '.getYourInoivce' ).serialize();

        var validation = true;

        $('#validation-messages').html('');
        $('.order-validation').hide();

        if($('#ReferenceNumber').val() == ''){
            $('#validation-messages').append('<li>Please enter a valid reference</li>')
            $('.order-validation').show();
            validation = false;
        }

        if($('#confirmation').prop('checked')==false){
            $('#validation-messages').append('<li>Please accept confirmation</li>')
            $('.order-validation').show();
            validation = false;
        }


        if(validation == true){
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: my_ajax_object.ajax_url,
                data : {action: "generate_invoice", reference: formdata},
                success: function(data){
                    if(data.responseText === "no"){
                        $('#validation-messages').append('<li>Invalid or expired reference, please contact support</li>')
                        $('.order-validation').show();
                    } else {
                        $('.getYourInoivce').submit();
                    }
                },
                error: function(msg){
                    if(msg.responseText === "no"){
                        $('#validation-messages').append('<li>Invalid or expired reference, please contact support</li>')
                        $('.order-validation').show();
                    } else {
                        $('.getYourInoivce').submit();
                    }
                }
            });
        }
    });

});

</script>

<?php get_footer();

?>
