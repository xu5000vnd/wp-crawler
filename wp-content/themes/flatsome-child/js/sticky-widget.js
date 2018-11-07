jQuery(document).ready(function($){
	var sPageURL = window.location.search.substring(1).split('&');
	if(sPageURL[0] != 'uxb_iframe' && ! jQuery.browser.mobile && $('#shop-sidebar').length){
		sticky(".col.large-3.hide-for-medium ");
	}
	else if(sPageURL[0] != 'uxb_iframe' && ! jQuery.browser.mobile && $('.custom-product-page').length){
		sticky(".col.medium-4.small-12.large-4");
	}
});


function sticky(targetClass){
	jQuery(document).ready(function($){
		
			var topelm = $(targetClass).offset().top;
			var headbot = $('header').offset().top +70;
			$(window).scroll(function(){
				var stopelm  = $(targetClass).offset().top + $(targetClass).height();
				var botelm = 0;
				if($(targetClass).is('div')){
					botelm = $(this).scrollTop() + $('.sidebar-wrapper').height();
					$(targetClass + ' .col-inner').css('width',$(targetClass + ' .col-inner').width() + 'px');
					$(targetClass + ' .col-inner').css('height',$(targetClass + ' .col-inner').height() + 'px');
				}
				else if($(targetClass).is('section')) {
					$(targetClass).css('width',$(targetClass).width() + 'px');
					$(targetClass).css('height',$(targetClass).height() + 'px');
					$(targetClass).css('z-index','9');
				}
				if(($(this).scrollTop()) >= topelm && (botelm <= stopelm) ){
					if($(targetClass).is('div')){
						if($(targetClass + ' .col-inner').hasClass('wg-end')){
							$(targetClass + ' .col-inner').removeClass('wg-end');
						}
						$(targetClass + ' .col-inner').removeClass('wg-normal').addClass('wg-sticky');
						$(targetClass + ' .col-inner').css('height',$(targetClass + ' .col-inner').height() + 'px');
					}
					else if($(targetClass).is('section')){
						if($('.header-wrapper').hasClass('stuck')){
							if($(targetClass).hasClass('menu-normal')){
								$(targetClass).removeClass('menu-normal').addClass('menu-sticky');
							}
							$(targetClass).addClass('menu-sticky');
							$(targetClass).css('top',headbot + 'px');
							
						}
						else {
							$(targetClass).removeClass('menu-sticky').addClass('menu-normal');
							$(targetClass).css('top',0 + 'px');
						}
					}
				}
				else if($(this).scrollTop() < topelm){
					if($(targetClass).is('div')){
						if($(targetClass + ' .col-inner').hasClass('wg-end')){
							$(targetClass + ' .col-inner').removeClass('wg-end');
						}
						$(targetClass + ' .col-inner').css('width',$(targetClass + ' .col-inner').width() + 'px');
						$(targetClass + ' .col-inner').css('height',$(targetClass + ' .col-inner').height() + 'px');
						$(targetClass + ' .col-inner').removeClass('wg-sticky').addClass('wg-normal');
					}
					else if($(targetClass).is('section')){
						$(targetClass).removeClass('menu-sticky').addClass('menu-normal');
						$(targetClass).css('top',0+'px');
					}
				}
				else if($(this).scrollTop() >= topelm && (botelm) >= (stopelm)  ){
					$(targetClass + ' .col-inner').css('width',$(targetClass + ' .col-inner').width() + 'px');
					$(targetClass + ' .col-inner').css('height',$(targetClass + ' .col-inner').height() + 'px');
					$(targetClass + ' .col-inner').removeClass('wg-sticky').addClass('wg-end');
				}
			});
		
	});
}
