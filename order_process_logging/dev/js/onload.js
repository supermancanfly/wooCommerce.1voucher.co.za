$(function() {


	$('.voucher_details_block h6').click(function(){
		$(this).toggleClass('open');
		$(this).parent('div').removeClass('active');
		$('.detail_list_voucher').slideToggle(300);
	});

 // Footer Links Dropdown - Mobile
    if ($(window).width() < 1024) {
        var footer_col_links = document.querySelectorAll(".side_bar h4");
        for (var i = 0; i < footer_col_links.length; i++) {
            $(footer_col_links[i]).on('click', function() {
                if ($(this).parent().hasClass('active')) {
                    $(this).parent().removeClass('active');
                } else {
                    $('.side_bar').removeClass('active');
                    $(this).parent().addClass('active');
                }
            });
        }
    }
	

	var ticker = document.querySelectorAll('.ticker-inner');
	if (ticker.length != 0) {

		if ($(window).width() < 960) {
			var width = ticker[0].children[0].offsetWidth * 8.4;
		} else {
			var width = ticker[0].children[0].offsetWidth * 4;
		}

		for (var i = 0; i < ticker.length; i++) {

			ticker[i].setAttribute("style", "width:" + width + "px");
		}
	}


	var supportMobileSelect = document.getElementsByClassName('support-tab-row');
	Array.prototype.forEach.call(supportMobileSelect, function(element) {

		var setText = document.querySelectorAll('.' + element.classList[1] + ' .dropdown-menu > li a');

		$('.' + element.classList[1] + ' .ae-select-content').text($(setText[0]).text());
		var newOptions = $('.' + element.classList[1] + ' .dropdown-menu > li');
		newOptions.click(function() {
			console.log(this);
			$('.' + element.classList[1] + ' .ae-select-content').text($(this).text());
		});

	});


	$('.tab-content:first-child').show();
	$('.tab-nav-link').bind('click', function(e) {
		$this = $(this);
		$tabs = $this.parent().parent().next();
		$target = $($this.data("target")); // get the target from data attribute
		$this.siblings().removeClass('active');
		$target.siblings().css("display", "none")
		$this.addClass('active');
		$target.fadeIn("fast");
	});

	$('.tab-nav-link:first-child').trigger('click');

	$('.ae-dropdown').on('click', function() {
		$('.dropdown-menu').toggleClass('ae-hide');
	});



	var accItem = document.getElementsByClassName('accordionItem');
	var accHD = document.getElementsByClassName('accordionItemHeading');

	for (i = 0; i < accHD.length; i++) {
		accHD[i].addEventListener('click', toggleItem, false);

	}

	function toggleItem() {
		var itemClass = this.parentNode.className;
		for (i = 0; i < accItem.length; i++) {
			accItem[i].className = 'accordionItem close';
		}
		if (itemClass == 'accordionItem close') {
			this.parentNode.className = 'accordionItem open';
		}
	}



	var continuousElements = document.getElementsByClassName('data-bg')
	for (var i = 0; i < continuousElements.length; i++) {
	  new Waypoint({
		element: continuousElements[i],
		handler: function() {
			$('.page-nav,.page-nav-cart').toggleClass(this.element.dataset.bg);
		},
		offset: '88px'
	  })
	}



	var continuousElements1 = document.querySelectorAll('[animate]')
	for (var i = 0; i < continuousElements1.length; i++) {
	  new Waypoint({
		element: continuousElements1[i],
		handler: function() {
			$(this.element).find('.vertical-reveal-inner').addClass('visible');
		},
		  offset: '80%'
	  })
	}

	var continuousElements2 = document.querySelectorAll('[animate-secondary]')
	for (var i = 0; i < continuousElements2.length; i++) {
	  new Waypoint({
		element: continuousElements2[i],
		handler: function(direction) {
			$(this.element).find('.col').addClass('visible');
		},
		  offset: '70%'
	  })
	}


	$(window).on('scroll', function () {

		var scrollTop = $(window).scrollTop();

		if ( $('.home-services').length ) {
			var serviceselementOffset = $('.home-services').offset().top;
			var servicedistance = (serviceselementOffset - scrollTop);
			var servicedis = servicedistance * 0.1;

			if ( $(window).width() > 960 ) {
				document.querySelector(".home-services-right").style.top = "-" + servicedis + "px";
				document.querySelector(".home-services-left").style.top = servicedis + "px";
			}
		}

		if ( $('.news-competitions').length ) {
			var newselementOffset = $('.news-competitions').offset().top;
			var newsdistance = (newselementOffset - scrollTop);
			var newsdis = newsdistance * 0.1;

			if ( $(window).width() > 960 ) {
				document.querySelector(".home-news-1").style.top = "-" + newsdis + "px";
				document.querySelector(".home-news-2").style.top = newsdis + "px";
			}
		}

	});



	var body = document.querySelector("body");
	var termsbutton = document.querySelector("#termsbutton");
	var termsbuttonclose = document.querySelector(".termsbuttonclose");

	if (termsbutton) {

		termsbutton.addEventListener("click", function(e) {
			e.preventDefault();
			termsbuttonclose.classList.toggle("is-active");
			body.classList.toggle("terms-active");
		});

		termsbuttonclose.addEventListener("click", function() {
			termsbuttonclose.classList.toggle("is-active");
			body.classList.toggle("terms-active");
		});
	}



	$('select').selectric({ disableOnMobile: false, nativeOnMobile: false });

	var navIndex = $('.slide-nav-index');
	var $slickElementLeft = $('.slider-for');
	var $slickElementRight = $('.slider-nav');
	var $slickElement = $slickElementLeft;

	$slickElementLeft.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {

		$(this).find('.vertical-reveal-inner').addClass('visible');

		var i = (currentSlide ? currentSlide : 0) + 1;

		$(navIndex).html('0' + i + ' <span>/ 0' + slick.slideCount + '</span>');

	});

	slideArrows = document.getElementById("slider-arrows");
	slideDots = document.getElementById("slider-dots");

	$($slickElementLeft).slick({
		asNavFor: $slickElementRight,
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		appendArrows: slideArrows,
		arrows: false,
		appendDots: slideDots,
		autoplay: true,
		autoplaySpeed: 10000,
		fade: true,
		autoplay: true,
		autoplaySpeed: 5000,
		 adaptiveHeight: false,

			responsive: [
		
		{
			breakpoint: 767,
			settings: {
					 adaptiveHeight: true

			}
		}]
	});
	$($slickElementRight).slick({
		asNavFor: $slickElementLeft,
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: false,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 10000,
		fade: true
	});


	$('.home-carousel-prev').click(function(){
		$slickElement.slick('slickPrev');
	} );

	$('.home-carousel-next').click(function(e){
		e.preventDefault();
		$slickElement.slick('slickNext');
	} );

	$($slickElement).on('beforeChange', function(event, slick, currentSlide, nextSlide){
	  $(this).find('.vertical-reveal-inner').removeClass('visible');
	});


	// Partner Network carousel
	var partnerIndex = $('.partner-index-nav');
	var $slickPartner = $('.partner-rows');

	$slickPartner.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {

		var i = (currentSlide ? currentSlide : 0) + 1;

		if (slick.slideCount > 1) {
			$(partnerIndex).html('0' + i + ' <span>/ 0' + slick.slideCount + '</span>');
		} else {
			$(partnerIndex).html('');
		}

	});


	var partnerArrows = document.getElementById("partner-arrow-nav");

	$($slickPartner).slickFilterable({
		filterName: 'filter-heading',
		filter: function(category, slider, settings) {
			return $(this).hasClass(category);
		},
		slick: {
			infinite: false,
			dots: false,
			appendArrows: partnerArrows,
			//arrows: false,
			prevArrow: $('.partner-carousel-prev'),
			nextArrow: $('.partner-carousel-next'),
			responsive: [{
					breakpoint: 3000,
					settings: {
						slidesPerRow: 5,
						rows: 4,
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesPerRow: 2,
						rows: 4,
					}
				},

				{
					breakpoint: 330,
					settings: {
						slidesPerRow: 2,
						rows: 4,
					}
				}

			]
		}

	});


	// Support Slider
	var slickSupport = document.getElementsByClassName('support-caro');
	Array.prototype.forEach.call(slickSupport, function (element) {

		var slickSupportCaro = $('.'+element.classList[1]);
		var supportIndex = $('.support-index-'+element.classList[1]);
		var supportArrows = $('.support-arrow-'+element.classList[1]);

		var arrowNext = $('.support-arrow-'+element.classList[1]+'-next');
		var arrowPrev = $('.support-arrow-'+element.classList[1]+'-prev');

		slickSupportCaro.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
		  var i = (currentSlide ? currentSlide : 0) + 1;


		  if (slick.slideCount > 1) {
			  $(supportIndex).html('0' + i + ' <span>/ 0' + slick.slideCount + '</span>');
		  } else {
			  $(partnerIndex).html('');
		  }
		});

		$(slickSupportCaro).slick({
			infinite: false,
			dots: false,
			appendArrows: supportArrows,
			arrows: true,
			slidesPerRow: 1,
			rows: 5,
			fade: true,
			prevArrow: arrowPrev,
			nextArrow: arrowNext,
		});
	});


	// Instagram Media Carousel
	instagram = document.getElementById("igmedia");
	instaArrows = document.getElementById("insta-arrow-nav");

	$('#sbi_images, .slider-insta').slick({
		infinite: false,
		dots: false,
		prevArrow: $('.insta-carousel-prev'),
		nextArrow: $('.insta-carousel-next'),

		appendArrows: instaArrows,
		arrows: true,
		responsive: [{
				breakpoint: 3000,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 1400,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 330,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			}
		]

	});

	




	// Paralax Settings
	// Intro circle
	var intro = document.getElementsByClassName('secondary-img-img');
	new simpleParallax(intro, {
		delay: 0,
		orientation: 'down',
		scale: 1.5,
		overflow: true,
		maxTransition: 70
	});



	// Handles Formidable field labels

	$('input, textarea').on('focus', function(){

		 // $(this).closest('.frm_form_field').addClass('focused just-focus'); 
 

		 if ($(this).val() === '') {
		 	$(this).closest('.frm_form_field').addClass('focused just-focus');  
		 } else {
		 	$(this).closest('.frm_form_field').removeClass('focused');	 
		 }


	});

	$('input, textarea').on('blur', function(){
		if ($(this).val() === '') {
			$(this).closest('.frm_form_field').removeClass('focused just-focus');
		} else {
			$(this).closest('.frm_form_field').removeClass('just-focus focused');
		}
	});


	$('.tab-nav-link').bind('click', function(e) {

	  $this = $(this);
	  $tabs = $this.parent().parent().next();
	  $target = $($this.data("target")); // get the target from data attribute

		$parent = $target;

		if ($parent[0].children[0].classList[1] === 'tab-left') {
			$("." + $parent[0].children[1].children[0].children[0].classList[1]).slick('reinit');
		} else {
			$("." + $parent[0].children[0].classList[1]).slick('reinit');
		}
	});


	$(document).on('click', 'a[href^="#"]', function (event) {
		event.preventDefault();

		$('html, body').animate({
			scrollTop: $($.attr(this, 'href')).offset().top
		}, 500);
	});


	//Popups

	$('.open-popup-link').magnificPopup({
	  type:'inline',
	  midClick: true ,
	  callbacks: {
		open: function() {

		  if (this.currItem.src == "#site-terms") {
			  $('.mfp-bg').addClass('bg-light');
		  }

		  if (this.currItem.src == "#competition-terms") {
			  $('.mfp-bg').addClass('bg-light');
		  }

		  if (this.currItem.src == "#page-menu") {
			  // $('.mfp-bg').addClass('bg-dark');
			   $('.mfp-bg').addClass('bg-light');
		  }
		}
	  }
	});


	$('#postfilter').selectric().on('change', function() {

		var filter = $('#filter');

		$.ajax({
			url:filter.attr('action'),
			data:filter.serialize(),
			type:filter.attr('method'),
			beforeSend:function(xhr){
				filter.find('button').text('Processing...');
			},
			success:function(data){
				filter.find('button').text('Apply filter');
				$('#response').html(data);
			}
		});

		return false;

	});



	/*
	 * selectric for buy page
	 */

	$('select[name=buyvouchers_1fa_vtype]').on('selectric-change', function(e) {
		var value = $(this).val();
		if (value == '1FORYOU') {
			$('.buyvouchers_step1_next').removeClass('inactive');
		} else if (value == 'ELECTRICITY') {
			$('.buyvouchers_step1_next').removeClass('inactive');
		} else {
			$('.buyvouchers_step1_next').addClass('inactive');
		}
	});


});

function copyToClipboard(element) {

	var $temp = $("<input>");

	$("body").append($temp);
	$temp.val($(element).text()).select();
	document.execCommand("copy");
	$temp.remove();

	var tooltip = document.getElementById("link-copy");

	$(tooltip).addClass('copied').delay(3000).queue(function(n) {
		$(this).removeClass('copied'); n();
	});
}



// $(window).on('load',function(){
	 

// 	$("a.scroller").click(function(event){
// 		event.preventDefault();	  
// 		var full_url = this.href;	  
// 		var parts = full_url.split("#");
// 		var trgt = parts[1];	  
// 		var target_offset = $("#"+trgt).offset();
// 		var target_top = target_offset.top - 100;	  
// 		$('html, body').animate({scrollTop:target_top}, 500);
// 	});

// });

$('.add-prod').on('click', function() {
	var pop_ref = $(this).attr('id');
	$('[data-popup='+pop_ref+']').fadeIn();
	$('.product-popups').fadeIn();
	console.log(pop_ref);

});

$('.close-pop').on('click', function(){
	$('.product-popups').fadeOut();
	$('.prod-info-popup').fadeOut();
});

$(document).mouseup(function(e)
{
	var container = $(".prod-info-popup");

	if (!container.is(e.target) && container.has(e.target).length === 0)
	{
		container.fadeOut();
		$('.product-popups').fadeOut();
	}

});

function closeCart() {
	$('.cart-popup').removeClass('show-cart');
}

$('.custom-price-select input').on('click', function(){
	var holder = $(this).parent();

	holder.find('.nameYP').val(this.value);
});

$('#open-cart').on('click', function() {
	$('.cart-popup').addClass('show-cart');
});

$(document).mouseup(function(e)
{
	var container = $(".cart-holder");

	if (!container.is(e.target) && container.has(e.target).length === 0)
	{
		// container.hide('fast');
		$('.cart-popup').removeClass('show-cart');
	}

});


$( ".prodAddForm" ).on( "submit", function( event ) {
	event.preventDefault();
	var prod_holder = $(this).parent().parent();
	var img = $(prod_holder).find('.prod-logo').attr('src');
	var name = $(prod_holder).find('h2').text();
	addProd($( this ).serialize(),img,name);
});

function addProd(e, img, name) {
	event.preventDefault()
	jQuery.ajax({
		type: "post",
		dataType: "json",
		url: my_ajax_object.ajax_url,
		data : {action: "add_cart_item", prodData: e},
		success: function(data){
			$('.cart_empty').hide();
			reloadCart();
			$('.voucher_added_cart').fadeIn();
			$('.voucher_added_cart .v_top_logo img').attr('src', img);
			$('.popup-voucher-name').text(name);
			$('.cart-footer').show();
		},
		error: function(msg){
			$('.cart_empty').hide();
			reloadCart();
			$('.voucher_added_cart').fadeIn();
			$('.voucher_added_cart .v_top_logo img').attr('src', img);
			$('.popup-voucher-name').text(name);
			$('.cart-footer').show();
		}
	});
}

function EditCartItem(e) {
	console.log(e);
	$('.cart-popup').removeClass('show-cart');


	jQuery.ajax({
		type: "post",
		dataType: "json",
		url: my_ajax_object.ajax_url,
		data : {action: "edit_cart_item", key: $(e).attr('data-cart_key')},
		success: function(data){
			$('.edit-cart-item').append(data.responseText);
			console.log(data.responseText);
			$('.edit-cart-item').fadeIn();
			// console.log(data);
		},
		error: function(msg){
			$('.edit-cart-item').html(msg.responseText);
			console.log(msg.responseText);
			$('.edit-cart-item').fadeIn();
		}
	});
}

function AdjustQuantity(e){

	var parent = $(e).parent();

	var number = $(parent).find('.pl-ns-value').val();

	jQuery.ajax({
		type: "post",
		dataType: "json",
		url: my_ajax_object.ajax_url,
		data : {action: "quantity_cart_item", key: $(e).attr('data-cart_key'), quant: number},
		success: function(data){
			reloadCart();


		},
		error: function(msg){

			reloadCart();

		}
	});
}

function getcartDetails(){
	jQuery.ajax({
		type: "post",
		dataType: "json",
		url: my_ajax_object.ajax_url,
		data : {action: "get_cart_details" },
		success: function(data){
			if(data.state == true){

				$('.cart-quant').text(data.cart_count);
				$('.cart_items').text(data.cart_count);
				$('.cart-totals .total-amount').html(data.cart_total);
				$('.woo-total').html(data.cart_total);

				if(data.cart_count == 0) {
					$('.cart_empty').fadeIn();
					$('.cart-footer').hide();
					$('#cart-container').hide();
					$('#cart-page-empty').fadeIn();
				}

				if(data.cart_count > 5) {
					$('.voucherlimit').fadeIn();
					$('.vlimit').fadeIn();
					$('.continue-checkout').addClass('disable-checkout');
				} else {
					$('.voucherlimit').fadeOut();
					$('.vlimit').fadeOut();
					$('.continue-checkout').removeClass('disable-checkout');
				}

			}

		},
		error: function(data){


		}
	});

}

function removeProd(e) {
	$(e).parent().parent().addClass('focus');
	jQuery.ajax({
		type: "post",
		dataType: "json",
		url: my_ajax_object.ajax_url,
		data : {action: "delete_cart_item", id: $(e).attr('data-product_id'), key: $(e).attr('data-cart_key')},
		success: function(data){
			if(data.state == true){
				$(e).parent().parent().fadeOut().remove();
				getcartDetails();
			}
		},
		error: function(msg){

		}
	});
}

function reloadCart() {
	jQuery.ajax({
		type: "post",
		dataType: "json",
		url: my_ajax_object.ajax_url,
		data : { action: "reload_cart" },
		success: function(data){
			$('.cart-list').html(data.responseText);
			$('.product-popups').fadeOut();
			$('.prod-info-popup').fadeOut();
			getcartDetails();
		},
		error: function(data){
			$('.cart-list').html(data.responseText);
			$('.product-popups').fadeOut();
			$('.prod-info-popup').fadeOut();
			getcartDetails();
		}
	});



}

function loadMorePosts(e) {
	jQuery.ajax({
		type: "post",
		dataType: "json",
		url: my_ajax_object.ajax_url,
		data : { action: "load_more_prods" , postAmount: e},
		success: function(data){
			$('.shop_list_flex').append(data.responseText);
			loadPostPopups(e)
		},
		error: function(data){
			$('.shop_list_flex').append(data.responseText);
			loadPostPopups(e)
		}
	});
}

function loadPostPopups(e) {

	// jQuery.ajax({
	// 	type: "post",
	// 	dataType: "json",
	// 	url: my_ajax_object.ajax_url,
	// 	data : { action: "load_more_prods_popups" , postAmount: e},
	// 	success: function(data){
	// 		console.log(data.responseText);
	// 	},
	// 	error: function(data){
	// 		$('.product-popups').append(data.responseText);
	// 		console.log(data.responseText);
	// 	}
	// });
}


$('.close_pop').on('click', function() {
	$('.voucher_added_cart').fadeOut();
});

$('.v_added_btns .btn_view').on('click', function() {
	$('.voucher_added_cart').fadeOut();
	$('.cart-popup').addClass('show-cart');
});

$('.v_added_btns .btn_checkout').on('click', function() {
	$('.voucher_added_cart').fadeOut();
	window.location.href = '/checkout'
});


var numberSpinner = (function() {

  $('.number_spinner>.ns-btn>a').click(function() {
    var btn = $(this),
      oldValue = btn.closest('.number_spinner').find('input').val().trim(),
      newVal = 0;

    if (btn.attr('data-dir') === 'up') {
      newVal = parseInt(oldValue) + 1;
    } else {
      if (oldValue > 1) {
        newVal = parseInt(oldValue) - 1;
      } else {
        newVal = 1;
      }
    }
    btn.closest('.number_spinner').find('input').val(newVal);
  });
  $('.number_spinner>input').keypress(function(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
  });
})();


function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}