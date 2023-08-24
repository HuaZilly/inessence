/* Modernizr
======================================================== */

function isTouchDevice() {
    return 'ontouchstart' in document.documentElement;
}

(function(){

	if (isTouchDevice()) {
		document.getElementsByTagName('html')[0].classList.add('touch');
	}
	else {
		document.getElementsByTagName('html')[0].classList.add('no-touch');
	}


	/*	
		BROWSER:					BROWSER ENGINE:
		
		Chrome						WebKit
		Safari						Webkit
		Firefox						Gecko
		Opera						Webkit
		IE Edge						Webkit
		IE 10						Trident/6.0
		IE 11						Trident/7.0
	*/
	
	if(navigator.userAgent.indexOf('Trident/6') > -1){
		document.getElementsByTagName('html')[0].classList.add('ie10');
	}
	if(navigator.userAgent.indexOf('Trident/7') > -1){
		document.getElementsByTagName('html')[0].classList.add('ie11');
	}

//IE 11 	"Mozilla/5.0 (Windows NT 6.1; Trident/7.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; rv:11.0) like Gecko\"
	
})();









/* Make Safari on iOS apply the active state by default, by adding a touchstart event listener to the document body or to each element.
======================================================== */

window.onload = function() {
	if(/iP(hone|ad)/.test(window.navigator.userAgent)) {
		document.body.addEventListener('touchstart', function() {}, false);
    }
};








/* Lazy loading
========================================================================================================= */


var lazyImages = [].slice.call(document.querySelectorAll(".lazyload"));
var active = false;

function lazyLoad() {
    if (active === false) {
      active = true;

      setTimeout(function() {
	      
	      
	      
	      
	      
	      
        lazyImages.forEach(function(lazyImage) {
	        	var theoffset = (window.innerHeight/2);
	        

	          if ((lazyImage.getBoundingClientRect().top <= window.innerHeight + theoffset) && getComputedStyle(lazyImage).display !== "none") {
//           if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {

				if(lazyImage.getAttribute('data-background-image-url')){
					

						/* Background 
						----------------------------------- */
						bkgdImage = document.createElement('img');
						
						bkgdImage.src = lazyImage.getAttribute('data-background-image-url');
						lazyImage.style.backgroundImage = lazyImage.getAttribute('data-background-image-url');
						lazyImage.style.backgroundImage = "url("+lazyImage.getAttribute('data-background-image-url')+")";
		
						bkgdImage.onload = function() {
				            lazyImage.classList.remove("lazy");
						}
				}else {
					
						/* Image
						----------------------------------- */
		
			            lazyImage.src = lazyImage.dataset.src;
			            lazyImage.srcset = lazyImage.dataset.srcset;

						if (lazyImage.complete) {
						            lazyImage.classList.remove("lazy");
						} else {
						  lazyImage.addEventListener('load', function() {
						            lazyImage.classList.remove("lazy");
				            })
						}
				}


	            lazyImages = lazyImages.filter(function(image) {
	              return image !== lazyImage;
	            });

            if (lazyImages.length === 0) {
              document.removeEventListener("scroll", lazyLoad);
              window.removeEventListener("resize", lazyLoad);
              window.removeEventListener("orientationchange", lazyLoad);
            }
          }
        });

        active = false;
      }, 200);
    }
  };
  document.addEventListener("scroll", lazyLoad);
  window.addEventListener("load", lazyLoad);
  window.addEventListener("resize", lazyLoad);
  window.addEventListener("orientationchange", lazyLoad);
			
			
			
			
			
			


/* Hamburger
======================================================== */

if(document.getElementById('open-menu')){
	var menuButton = document.getElementById('open-menu'),
		theHTML = document.getElementsByTagName('html')[0],
		menu = document.getElementById('menu');
	
	menuButton.addEventListener('click', function(){
		if(this.classList.contains('open')){
			this.classList.remove('open');
			menu.classList.remove('open');
			
			theHTML.classList.remove('menu-open');
		} else {
			this.classList.add('open');		
			menu.classList.add('open');
			theHTML.classList.add('menu-open');		
		}
	});
}






/* Dropdown menu
======================================================== */


function dropDown(){
	if(window.innerWidth < 1250){
		jQuery('.menu-item-has-children > a').on('click', function(e){
			e.preventDefault();	
			
			
			
			var theParent = jQuery(this).parent();
			var theSubmenu = jQuery(theParent).children('.sub-menu');
			
			

			if(jQuery(theParent).hasClass('open')){
				jQuery('.menu-item-has-children').removeClass('open');
				jQuery(theParent).removeClass('open');
				
				jQuery(theSubmenu).removeClass('open');
			}else {
				jQuery('.menu-item-has-children').removeClass('open');
				jQuery(theParent).addClass('open');
		
				jQuery(theSubmenu).addClass('open');		
			}
		});
		
	}else {
		jQuery('.menu-item-has-children > a').off('click');
	}
		
}

document.addEventListener('DOMContentLoaded', dropDown);
window.addEventListener('resize', dropDown);










/* search form
======================================================== */






document.addEventListener('DOMContentLoaded', function(){
	var opensearch = document.getElementById('opensearch'),
		closesearch = document.getElementById('closesearch'),
		searchforms = document.querySelectorAll('.search-form-wrap'),
		theHTML = document.getElementsByTagName('html')[0];
		searchResults = document.getElementById('search-results-box');



	function closeSearchform(){
		
		theHTML.classList.remove('search-show');
		setTimeout(function(){
			theHTML.classList.remove('search-open');
		},10);

		searchResults.classList.remove('open');
		
		for (i = 0; i < searchforms.length; i++) {
			searchforms[i].classList.remove('show');
			searchforms[i].classList.remove('open');
		}
	}
	
	function openSearchform(){
		theHTML.classList.add('search-open');

		setTimeout(function(){
			theHTML.classList.add('search-show');
		},10);

		searchResults.classList.add('open');
		
		for (i = 0; i < searchforms.length; i++) {
			let theSearchForm = searchforms[i];
			theSearchForm.classList.add('open');
			setTimeout(function(){
				theSearchForm.classList.add('show');
			
			}, 10);
		}
		
	}
		
		
	opensearch.addEventListener('click', 
		function(e){
			e.preventDefault();	
			openSearchform()
		}
	);
	closesearch.addEventListener('click', 
		function(e){
			e.preventDefault();	

			closeSearchform()
		}
	);
		
		
	
	

});







/* footer menu
======================================================== */

document.addEventListener('DOMContentLoaded', function(){
	

	
	var footermenulink = document.querySelectorAll('.open-footer-submenu');
	var footermenu = document.querySelectorAll('.footer-submenu');
	
	for (i = 0; i < footermenulink.length; i++) {
		footermenulink[i].addEventListener('mouseenter', function(e){
			e.preventDefault();	
			var selVal = this.getAttribute('data-menu');
			
			jQuery('.footer-submenu').removeClass('open');
			
			this.classList.add('open');
			document.querySelectorAll('.footer-submenu[data-menu="'+selVal+'"]')[0].classList.add('open');
	
		});
	}



	for (i = 0; i < footermenu.length; i++) {
		footermenu[i].addEventListener('mouseleave', function(e){
			this.classList.remove('open');

			var selVal = this.getAttribute('data-menu');
			document.querySelectorAll('.open-footer-submenu[data-menu="'+selVal+'"]')[0].classList.remove('open');
			
	
		});
	}


});



/* Qty buttons
======================================================== */

window.addEventListener('load', function(){
		
	setTimeout(function(){
		

	if(document.querySelectorAll('.decrease-qty').length > 0){
		var decreaseqtyBtn = document.querySelectorAll('.decrease-qty');
		
		for (i = 0; i < decreaseqtyBtn.length; i++) {
						
			decreaseqtyBtn[i].addEventListener('click', function(){
				var numberField = this.nextElementSibling;				
				var currentValue = parseFloat( numberField.value );
				var newValue = currentValue - 1;

				if(currentValue != 1){
					numberField.value = newValue;
				}

				jQuery(numberField).trigger('change');
			});
			
			
		}
		
	
	}
	if(document.querySelectorAll('.increase-qty').length > 0){
		var increaseqtyBtn = document.querySelectorAll('.increase-qty');
		
		for (i = 0; i < increaseqtyBtn.length; i++) {
			
				
				
			increaseqtyBtn[i].addEventListener('click', function(){
				var numberField = this.previousElementSibling;				
				var currentValue = parseFloat( numberField.value );
				var newValue = currentValue + 1;
				
 				numberField.value = newValue;

				

				
// 				jQuery(numberField).trigger('change');
				jQuery(numberField).trigger('change');
			});
			
			
		}
		
	
	}

	}, 500);
});


/* variable products
======================================================== */

window.addEventListener('load', function(){
	
	jQuery('input[type="radio"]').each(function(){
		var radioGroup = this.getAttribute('name');
		
		jQuery('input[name="'+radioGroup+'"]:first').prop("checked", true);
	
	});
	
	
	// The cloned - and + changes themain one.
	jQuery('.increase-qty-clone').click(function(){
		jQuery('.increase-qty').trigger('click');
	});
	jQuery('.decrease-qty-clone').click(function(){
		jQuery('.decrease-qty').trigger('click');
	});

	
	
	
	// whenever the quaty changes

	jQuery('.bc-product-form__quantity-input').on('change', function(){
		console.log(jQuery(this).val());
		jQuery('#quantity_input_clone').val(jQuery('.bc-product-form__quantity-input').val());		
	});
	

	// whenever you click this button the main one gets clicked
	jQuery('#addtobutton_clone').click(function(){
		jQuery('.bc-btn--add_to_cart').trigger('click');

        jQuery('html, body').animate({
            scrollTop: 0
        }, 500);


	});

		
		
});





/* filter
======================================================== */

if(document.getElementById('openfilter')){
	
	document.addEventListener('DOMContentLoaded', function(){
		var filter = document.getElementById('filter_menu'),
			openfilter = document.getElementById('openfilter');
		
		openfilter.addEventListener('click', function(e){
			e.preventDefault();	
			if(this.classList.contains('open')){
				this.classList.remove('open');
				filter.classList.remove('open');
			}else {
				this.classList.add('open');
				filter.classList.add('open');
	
			}
		})
		
	});

	
	document.addEventListener('DOMContentLoaded', function(){
	
	
	
	
			jQuery('.filter .heading').on('click', function(e){
				e.preventDefault();	
				
				
				
				var theParent = jQuery(this).parent();
				var theSubmenu = jQuery(theParent).children('ul');
				
				
				if(jQuery(theParent).hasClass('open')){
					jQuery(theParent).removeClass('open');
					
					jQuery(theSubmenu).removeClass('open');
				}else {
					jQuery(theParent).addClass('open');
			
					jQuery(theSubmenu).addClass('open');		
				}
			});
	
	
	});






	/* Filter
	--------------------------------------------------------- */

	// give all the boxes filters
	function giveAllboxesFilters (){
		
		var boxes = document.querySelectorAll('.product-link-direct');
		
		for (i = 0; i < boxes.length; i++) {
			var bcwrapper = boxes[i].children[0];
			var bcwrapperInner = bcwrapper.children[0]
			var classNames = bcwrapperInner.getAttribute('data-class');


 			jQuery(boxes[i]).addClass(classNames);
 			
 			
 			boxes[i].setAttribute('data-rating', bcwrapperInner.getAttribute('data-rating'));
 			boxes[i].setAttribute('data-date', bcwrapperInner.getAttribute('data-date'));
 			boxes[i].setAttribute('data-price', bcwrapperInner.getAttribute('data-price'));

					
		}		
	}

	
	document.addEventListener('DOMContentLoaded', function(){
		giveAllboxesFilters();
		
	});




	function resetFilterCat(){


		// loop through the checkboxes
		// if it has a checked class
		jQuery('.facetwp-checkbox.checked').each(function(){
			
			var groupName = jQuery(this).parent().attr('data-name');

			jQuery('.shopall[data-name="'+groupName+'"]').removeAttr('checked');

		});
		
		
		
		
		

	}


    jQuery(document).on('facetwp-loaded', function() {
			
			var checkboxes = document.querySelectorAll('.facetwp-facet-categories .facetwp-checkbox');
			var lazyImages = [].slice.call(document.querySelectorAll(".lazyload"));

			for (i = 0; i < checkboxes.length; i++) {
				if(checkboxes[i].getAttribute('data-value').indexOf('ml') == -1){
					checkboxes[i].classList.add('hidden');
				}
			}
			
			resetFilterCat();

			giveAllboxesFilters();


	        lazyImages.forEach(function(lazyImage) {

					if(lazyImage.getAttribute('data-background-image-url')){
						
	
							/* Background 
							----------------------------------- */
							bkgdImage = document.createElement('img');
							
							bkgdImage.src = lazyImage.getAttribute('data-background-image-url');
							lazyImage.style.backgroundImage = lazyImage.getAttribute('data-background-image-url');
							lazyImage.style.backgroundImage = "url("+lazyImage.getAttribute('data-background-image-url')+")";
			
							bkgdImage.onload = function() {
					            lazyImage.classList.remove("lazy");
							}
					}else {
						
							/* Image
							----------------------------------- */
			
				            lazyImage.src = lazyImage.dataset.src;
				            lazyImage.srcset = lazyImage.dataset.srcset;
	
							if (lazyImage.complete) {
							            lazyImage.classList.remove("lazy");
							} else {
							  lazyImage.addEventListener('load', function() {
							            lazyImage.classList.remove("lazy");
					            })
							}
					}
	
	
		            lazyImages = lazyImages.filter(function(image) {
		              return image !== lazyImage;
		            });
		    });
	





	
	});




	/* sort
	======================================================== */

	document.getElementById('sort-results').addEventListener('change', function(){
		
		var productTile = jQuery(".product-link-direct");
		var wrapper = this.parentNode;
		
		wrapper.classList.add('touched');

		switch (this.value) {
			case 'latest':

				productTile.sort(function(a, b){
				    return jQuery(a).data("date")-jQuery(b).data("date")
				});
				jQuery(".product-link-direct-wrap").html(productTile);


			break;
			case 'popular':
		  	
		  	
				productTile.sort(function(a, b){
				    return jQuery(b).data("rating")-jQuery(a).data("rating")
				});
				jQuery(".product-link-direct-wrap").html(productTile);


		    break;
			case 'pricelowtohigh':

				productTile.sort(function(a, b){
				    return jQuery(a).data("price")-jQuery(b).data("price")
				});
				jQuery(".product-link-direct-wrap").html(productTile);


		    break;
			case 'pricehightolow':


				productTile.sort(function(a, b){
				    return jQuery(b).data("price")-jQuery(a).data("price")
				});
				jQuery(".product-link-direct-wrap").html(productTile);


		    break;
		}

		lazyLoad();

		
	});
	

};








/* squares
======================================================== */


if(document.querySelectorAll('.square-rollover').length > 0){
	
	document.addEventListener('DOMContentLoaded', function(){
		var squares = document.querySelectorAll('.square-rollover');
		
	
		for (i = 0; i < squares.length; i++) {
	
			squares[i].addEventListener('click', function(e){
				e.preventDefault();	
				if(this.classList.contains('open')){
					this.classList.remove('open');
					filter.classList.remove('open');
				}else {
					this.classList.add('open');
					filter.classList.add('open');
		
				}
			})
			
		};
		
	});
}











/* Trigger function on custom scroll position
======================================================== */


function highlightBit(){

	jQuery('.addclass-on-focus').each(function(){
		if(
			jQuery(this).offset().top < (jQuery(window).scrollTop() + window.innerHeight)
		){
			jQuery(this).addClass('active');
		}else {
			jQuery(this).removeClass('active');
		}
	});



}
window.addEventListener('load', highlightBit);
document.addEventListener('scroll', highlightBit);









/* symbol list
======================================================== */

var symbollist = new Swiper('.symbol-list', {
	pagination: {
		el: '.swiper-pagination',
	},
	  autoHeight: true,

	slidesPerView: 2,
    breakpoints: {
        600: {
          slidesPerView: 2,
        },
        480: {
          slidesPerView: 1,
        },

	}
});



/* symbol list
======================================================== */


if(document.querySelectorAll('.changeslide').length > 0){
	var slideButton = document.querySelectorAll('.changeslide');

	var resetSlideButtons = function(){
		for (i = 0; i < slideButton.length; i++) {
			slideButton[i].classList.remove('open');	
		}
	}

	var featureswiper = new Swiper('.feature-swiper', {
      effect: 'fade',
	  autoHeight: true,

	  on: {
	    slideChange: function () {

			resetSlideButtons();
			
			setTimeout(function(){
				var selVal = document.querySelectorAll('.swiper-slide-active')[0].getAttribute('data-slidenumber');
	
				document.querySelectorAll('.changeslide[data-slidenumber="'+selVal+'"]')[0].classList.add('open');
				
			}, 500);

	    }
	  },
	
	});
	
	
	for (i = 0; i < slideButton.length; i++) {
		slideButton[i].addEventListener('click', function(e){
			
			e.preventDefault();
			
			var selVal = this.getAttribute('data-slidenumber');
			var theSlide = document.querySelectorAll('.swiper-slide[data-slidenumber="'+selVal+'"]')[0];

			console.log(selVal);
			featureswiper.slideTo(selVal  - 1);
	
		});
	}
	
}











/* home switcher
======================================= */


if(document.querySelectorAll('.home-swiper').length > 0){
	var slideButton = document.querySelectorAll('.changeslide');

	var resetSlideButtons = function(){
		for (i = 0; i < slideButton.length; i++) {
			slideButton[i].classList.remove('active');	
		}
	}

	var featureswiper = new Swiper('.home-swiper', {
      effect: 'fade',
      autoplay: {
        delay: 5000,
	},	
	  on: {
	    slideChange: function () {

			resetSlideButtons();
			
			setTimeout(function(){
				var selVal = document.querySelectorAll('.swiper-slide-active')[0].getAttribute('data-slidenumber');
	
				document.querySelectorAll('.changeslide[data-slidenumber="'+selVal+'"]')[0].classList.add('active');
				
			}, 500);

	    }
	  },
	
	});
	
	
	for (i = 0; i < slideButton.length; i++) {
		slideButton[i].addEventListener('click', function(e){
			
			e.preventDefault();
			
			var selVal = this.getAttribute('data-slidenumber');
			var theSlide = document.querySelectorAll('.swiper-slide[data-slidenumber="'+selVal+'"]')[0];

			console.log(selVal);
			featureswiper.slideTo(selVal  - 1);
	
		});
	}
	
}











/* load the rest
======================================= */

if(document.getElementById('showallreviews')){
	document.getElementById('showallreviews').addEventListener('click', function(e){
		e.preventDefault();
		
		jQuery('.reviews .review').addClass('active');
		
		jQuery('#showallreviews, #reviewcount').fadeOut();
		
		
	})
	
}


/* product image switcher
======================================= */


if(document.querySelectorAll('.image-switcher').length > 0){
	var slideButton = document.querySelectorAll('.image-switcher-thumbnails a');


	var featureswiper = new Swiper('.image-switcher', {
	      effect: 'fade',
		  autoHeight: true,
		    on: {
			    init: function () {
			    
			    	var mainSlide = parseFloat( jQuery('.main-image').attr('data-slidenumber') );
			    	
					this.slideTo(mainSlide);
			    
			    },
			},

	      
	});
	
	
	for (i = 0; i < slideButton.length; i++) {
		slideButton[i].addEventListener('click', function(e){
			
			e.preventDefault();
			
			var selVal = this.getAttribute('data-slidenumber');
			var theSlide = document.querySelectorAll('.swiper-slide[data-slidenumber="'+selVal+'"]')[0];

			featureswiper.slideTo(selVal  - 1);
			
			console.log(selVal);
	
		});
	}
	
	

	
}




/* sticky header
======================================= */

document.addEventListener("DOMContentLoaded", function() {
	var active = false;
	
	var header = document.getElementById('header');
	
	function stickyheader() {
		if (active === false) {
			active = true;
			
			if(window.pageYOffset > header.offsetHeight){
				header.classList.add('sticky');

			}else {
				header.classList.remove('sticky');

			}
			

			setTimeout(function() {
				active = false;
			}, 200);
		}
	};
	document.addEventListener("scroll", stickyheader);
});





/* add to cart
======================================= */

if(document.getElementById('addtocartsticky')){
	
	document.addEventListener("DOMContentLoaded", function() {
		var active = false;
		
		function addtocartsticky() {
			if (active === false) {
				active = true;
				
				if((window.pageYOffset + window.innerHeight)> (document.getElementById('source-wrap').offsetTop )){
					document.getElementById('addtocartsticky').classList.add('show');

					jQuery('.product-page-description').removeClass('show');

				}else {
					document.getElementById('addtocartsticky').classList.remove('show');					

					jQuery('.product-page-description').addClass('show');
				}
				
	
				setTimeout(function() {
					active = false;
				}, 200);
			}
		};
		document.addEventListener("scroll", addtocartsticky);
	});





	jQuery('.product-page-description-spacer').outerHeight(
		jQuery('.product-page-description').outerHeight()
	).outerWidth(
		jQuery('.product-page-description').outerWidth()
	);

	jQuery('.product-page-description').outerWidth(
		jQuery('.product-page-description').outerWidth()
	);

	
	jQuery('.product-page-description').css('top', jQuery('.product-page-description-spacer').offset().top).addClass('fixed');
	


}	


/* toggle
======================================= */

// jQuery('.toggle-truncate').on('click', function(e){
// 	e.preventDefault();
// 	var parentContainer = jQuery('.truncate');
	
// 	if(jQuery(this).hasClass('active')){
// 		jQuery(this).removeClass('active').html('Read more');
// 		jQuery(parentContainer).removeClass('active');
// 	}else {
// 		jQuery(this).addClass('active').html('Read less');
// 		jQuery(parentContainer).addClass('active');
// 	}
	
// })

jQuery('.toggle-truncate').on('click', function(e){
	e.preventDefault();
	
	var truncateTag = jQuery(e.currentTarget).closest('.truncate');
	if(truncateTag.hasClass('active')){
		truncateTag.removeClass('active');
		jQuery(e.currentTarget).html('Read more');
	}else{
		truncateTag.addClass('active');
		jQuery(e.currentTarget).html('Read Less');
	}
});







/* Collapse
======================================= */


jQuery('.collapse-content').each(function(){
	var tabHeight = jQuery(this).height();
	jQuery(this).css('height', tabHeight);
});

jQuery('.collapse-btn, .collapse-content').addClass("close");
jQuery('.collapse-btn.default-open, .collapse-content.default-open').removeClass("close");



jQuery('.collapse-btn').click(function(e){
	var selBtn = jQuery(this).attr('data-collapse');
	e.preventDefault();
	
	if(jQuery(this).hasClass('close')){
		jQuery(this).removeClass('close');					

		jQuery('.collapse-content[data-collapse="'+selBtn+'"]').removeClass('close');					
	}else {
		jQuery(this).addClass('close');					

		jQuery('.collapse-content[data-collapse="'+selBtn+'"]').addClass('close');										
	}
});




/* smart placeholders
======================================= */

function smartplaceholders(){
	

	if(document.querySelectorAll('.smartplaceholder').length > 0){
	
		var inputs = document.querySelectorAll('.smartplaceholder input, .smartplaceholder textarea');
		
		for (i = 0; i < inputs.length; i++) {
	
			var selVal = inputs[i].getAttribute('id');
			
			var theLabel = document.querySelectorAll('label[for="'+selVal+'"]')[0].parentNode;
	
			if(inputs[i].value){
				theLabel.classList.add('active');
			}else {
				theLabel.classList.remove('active');
			}
	
	
			 
			inputs[i].addEventListener('focus', function(){
	
				var selVal = this.getAttribute('id');
				var theLabel = document.querySelectorAll('label[for="'+selVal+'"]')[0].parentNode;
	
	
				theLabel.classList.add('active');
			});
	
			inputs[i].addEventListener('blur', function(){
	
				var selVal = this.getAttribute('id');
				var theLabel = document.querySelectorAll('label[for="'+selVal+'"]')[0].parentNode;
	
	
				if(this.value){
					theLabel.classList.add('active');
				}else {
					theLabel.classList.remove('active');
				}
			});
		}
	}




	if(document.querySelectorAll('.bc-form__control').length > 0){
	
		var inputs = document.querySelectorAll('.bc-form__control input, .bc-form__control select, .bc-form__control textarea');
		
		for (i = 0; i < inputs.length; i++) {
	
			var theLabel = inputs[i].parentElement;
	
	
			if(inputs[i].value){
				theLabel.classList.add('active');
			}else {
				theLabel.classList.remove('active');
			}
	
	
			 
			inputs[i].addEventListener('focus', function(){
	
				var theLabel = this.parentElement;
	
				theLabel.classList.add('active');
			});
	
			inputs[i].addEventListener('blur', function(){
	
				var theLabel = this.parentElement;
	
	
				if(this.value){
					theLabel.classList.add('active');
				}else {
					theLabel.classList.remove('active');
				}
			});
		}
	}
}



jQuery('.bc-account-addresses__add-button').on('click', smartplaceholders());


window.addEventListener('load', function(){
	smartplaceholders();

	if(document.querySelectorAll('.page-id-wish-lists').length > 0){
		

		const targetNode = document.querySelectorAll('.page-id-wish-lists')[0];
		const config = { attributes: true, childList: false, subtree: false };
		const callback = function(mutationsList, observer) {
			
		  	for(var i = 0; i < mutationsList.length; i++){
		        if (mutationsList[i].type === 'subtree') {
					smartplaceholders();
	
		        }else if(mutationsList[i].type === 'childList'){
			        console.log('childList');
	
					smartplaceholders();
				        
	
		        }else {
					smartplaceholders();
		        }
		    }
		};
		
		const observer = new MutationObserver(callback);
		
		observer.observe(targetNode, config);
	
	}





});



/* placeholders in subscribe
======================================================== */

function subscribePlaceholders (){
	if(document.querySelectorAll('.FormComponent__StyledFormComponentWrapper-e0xun6-0').length > 0){
		document.querySelectorAll('.FormComponent__StyledFormComponentWrapper-e0xun6-0')[3].classList.add('last-field');
	}
	if(document.querySelectorAll('.ResetElements__Div-sc-8e6zl9-0 ').length > 0){
	
		var inputs = document.querySelectorAll('.ResetElements__Div-sc-8e6zl9-0  input');
		
		for (i = 0; i < inputs.length; i++) {
	
			
			var theLabel = inputs[i].parentElement;
	

	
			 
			inputs[i].addEventListener('focus', function(){
				
	
				var theLabel = this.parentElement;
	
	
				theLabel.classList.add('active');
			});
	
			inputs[i].addEventListener('blur', function(){
	
			var theLabel = this.parentElement;
	
	
				if(this.value){
					theLabel.classList.add('active');
				}else {
					theLabel.classList.remove('active');
				}
			});
		}
	}

	
}


window.addEventListener('load', function(){
	setTimeout(function(){
		if(document.querySelectorAll('.klaviyo-form-PsGjGA').length > 0){
		 	subscribePlaceholders();
		}		
	}, 1000);

	if(document.querySelectorAll('.klaviyo-form-PsGjGA').length > 0){
		

		const targetNode = document.querySelectorAll('.klaviyo-form-PsGjGA')[0];
		const config = { attributes: false, childList: true, subtree: true };
		const callback = function(mutationsList, observer) {
			
		  	for(var i = 0; i < mutationsList.length; i++){
		        if (mutationsList[i].type === 'subtree') {
					subscribePlaceholders();
					
					console.log('subtree');
	
		        }else if(mutationsList[i].type === 'childList'){
			        console.log('childList');
	
					subscribePlaceholders();
				        
	
		        }else {
					subscribePlaceholders();
		        }
		    }
		};
		
		const observer = new MutationObserver(callback);
		
		observer.observe(targetNode, config);
	
	}





});





/* Trigger function on custom scroll position
======================================================== */


function highlightBit(){

	jQuery('.addclass-on-focus').each(function(){
		if(
			jQuery(this).offset().top < (jQuery(window).scrollTop() + window.innerHeight)
		){
			jQuery(this).addClass('active');
		}else {
			jQuery(this).removeClass('active');
		}
	});



}
window.addEventListener('load', highlightBit);
document.addEventListener('scroll', highlightBit);


/* review form
======================================================== */

if(document.querySelectorAll('.open-write-review-form').length > 0){
	var formArea = document.getElementById('write-review-form');
	var btns = document.querySelectorAll('.open-write-review-form');
	
	
	for (i = 0; i < btns.length; i++) {
	
		btns[i].addEventListener('click', function(e){
			e.preventDefault();
			
	
			jQuery(formArea).slideDown();

	        jQuery('html, body').animate({
	            scrollTop: jQuery(formArea).offset().top - 120
	        }, 500);

		});
		
	};

}


/* registration form
======================================================== */

if(document.getElementById('registration-part1')){
	
	var part1 = document.getElementById('registration-part1');
	var part2btn = document.getElementById('part2btn');
	var part1email = document.getElementById('part1email');
	var part1pass = document.getElementById('part1pass');
	var part2 = document.getElementById('registration-part2');
	var part2email = document.getElementById('bc-account-register-email');
	var part2pass = document.getElementById('bc-account-register-password');

	
	
	part1email.addEventListener('keyup', function(){
		part2email.value = this.value;
	});

	part1pass.addEventListener('keyup', function(){
		part2pass.value = this.value;
	});
	
	
	part2btn.addEventListener('click', function(e){
		e.preventDefault();

		part1.classList.add('hide');

		smartplaceholders();
		
		part2.classList.remove('hide');
		
		sessionStorage.registrationinit = true;

	});


	window.addEventListener('load', function(){
		
		if(sessionStorage.registrationinit != undefined){
			
			part1.classList.add('hide');
			smartplaceholders();
			part2.classList.remove('hide');

			
		}
	});

	
}


/* auto width - select
======================================================== */



if(document.getElementById('sort-results')){
	var searchFilter = document.getElementById('sort-results');
	
	
	searchFilter.addEventListener('change', function(){
	
		var selectedOption = this.options[this.selectedIndex].text;
	

 		this.style.width = ((selectedOption.length * 7) + 90) + 'px';
		

	});
	
}


/* search
======================================================== */



document.addEventListener('DOMContentLoaded', function(){




		//setup before functions
		var typingTimer;                //timer identifier
		var doneTypingInterval = 200;  //time in ms (5 seconds)




		var searchformfields = document.querySelectorAll('.searchfield');
		var searchResults = document.getElementById('search-results-box');


		for (i = 0; i < searchformfields.length; i++) {
			



			searchformfields[i].addEventListener('keyup', function(){


				var searchTerm = this.value;


			    clearTimeout(typingTimer);
			        typingTimer = setTimeout(function(){
				        
// 				        console.log(searchTerm);



	

							if (searchTerm.length > 0) {
	
	
									var request = new XMLHttpRequest();
									
									jQuery('.search-form').addClass('searching');	
									jQuery('.search-form .viewallbtn').addClass('hidden');	
									
									console.log(themeURL+'/search-results.php?s='+searchTerm+'');
										
									
				
									request.open('GET', themeURL+'/search-results.php?s='+searchTerm+'', true);
									
				
									request.onload = function() {
									  if (request.status >= 200 && request.status < 400) {
				
									    var resp = request.responseText;
				
									    
				
										var content = document.createElement('div');
										
										jQuery(searchResults).empty();
				
										content.setAttribute('id', 'searchresultswrapper');
										content.innerHTML = request.responseText;
										searchResults.appendChild(content);
										
				
										searchResults.classList.add('open');
				
										jQuery('#searchresultswrapper').prepend(jQuery(".search-result.high-priority"));
				
				
										jQuery('.search-form').removeClass('searching');						    
										jQuery('.search-form .viewallbtn').removeClass('hidden');
										
										jQuery('#viewallsearchresults').on('click', function(e){
											e.preventDefault();
											
											jQuery('#desktopsearch').submit();
											
										});
									   }
									};
									
									request.onerror = function() {
									  // There was a connection error of some sort
									};
									
									request.send();

							} else {
	
								jQuery(searchResults).empty();
			
								searchResults.classList.remove('open');
							}
			

		





				        
				        
			        }, doneTypingInterval);
			    


				
					




 			});
		
		}
});


/* cart page
======================================================== */

if(document.getElementById('cart-count')){	
/*
	function freeshippingpercentagebar (amount, total){
		var progressbar = document.getElementById('progressbar');
		var progressbarwrap = document.getElementById('checkoutprogress');
		var progressbarwrapouter = document.getElementById('checkoutprogresswrap');
		
		
		var percentage = total/100 * amount;
		if(amount >= 100){
			progressbar.style.width = 100+'%';
			progressbarwrap.classList.remove('hide');
			progressbarwrapouter.classList.remove('hide');
		}else if(amount <= 0){
			progressbar.style.width = 0+'%';
			progressbarwrap.classList.add('hide');
			progressbarwrapouter.classList.add('hide');
			
		}else {
			
			console.log(amount);
			progressbar.style.width = percentage+'%'
			progressbarwrap.classList.remove('hide');
			progressbarwrapouter.classList.remove('hide');

		}

	}


	function freeshippingqualified(){
		var amountrquired = parseFloat( document.getElementById('checkoutprogress').getAttribute('data-amountrequired') );
		var amountleftObj = document.getElementById('amountleft');
		var amountinCart = 0;
		var amountleft = (amountrquired - amountinCart).toFixed(2);





		if(document.querySelectorAll('.bc-cart-subtotal__amount')[0] != undefined){
			var amountinCart = parseFloat(document.querySelectorAll('.bc-cart-subtotal__amount')[0].innerHTML.replace('$', ''));
			var amountleft = (amountrquired - amountinCart).toFixed(2);

		}

		
		if(document.querySelectorAll('.bc-cart-item').length == 0){
			document.getElementById('freeshipping_msg').classList.add('hide');
			document.getElementById('amountleft_msg').classList.add('hide');
			
		}else if(amountinCart > amountrquired){

			
			amountleftObj.innerHTML = '$' + amountleft;


			document.getElementById('freeshipping_msg').classList.remove('hide');
			document.getElementById('amountleft_msg').classList.add('hide');
		}else {
			
			amountleftObj.innerHTML = '$' + amountleft;


			document.getElementById('freeshipping_msg').classList.add('hide');
			document.getElementById('amountleft_msg').classList.remove('hide');
	
		}
		
		freeshippingpercentagebar(amountinCart, amountrquired);
	}
*/





	
	function updateCart(){

		//location.reload();
		var noOfitems = document.querySelectorAll('.bc-cart-item').length;
		var totals = 	document.querySelectorAll('.printtotal');
		
		if(noOfitems == 0){
			document.getElementById('cart-count').innerHTML = '('+ noOfitems + ' item)';		
			
			for (i = 0; i < totals.length; i++) {
				
				totals[i].innerHTML = '$0.00';
			
			}
			
			
		}else if(noOfitems == 1){
			for (i = 0; i < totals.length; i++) {
				var subTotal = document.querySelectorAll('.bc-cart-subtotal__amount')[0].innerHTML;
				
				totals[i].innerHTML = subTotal;
			
			}

			document.getElementById('cart-count').innerHTML = '('+ noOfitems + ' item)';		
		}else {
			for (i = 0; i < totals.length; i++) {
				var subTotal = document.querySelectorAll('.bc-cart-subtotal__amount')[0].innerHTML;
				
				totals[i].innerHTML = subTotal;
			
			}


			document.getElementById('cart-count').innerHTML = '('+ noOfitems + ' items)';
		}
		//freeshippingqualified();
		
	}






	const targetNode = document.querySelectorAll('.bc-cart')[0];
	const config = { attributes: true, childList: false, subtree: false };
	const callback = function(mutationsList, observer) {	
	  	for(var i = 0; i < mutationsList.length; i++){
	        if (mutationsList[i].type === 'attributes') {
				updateCart();
				setTimeout(function(){ location.reload(); }, 2500);
				//setTimeout(function(){ location.reload(); }, 700);
	        	//updateCart();
				
	        }
	    }
	};
	const observer = new MutationObserver(callback);	
	observer.observe(targetNode, config);



	window.addEventListener('load', function(){
		updateCart();
	});

	

	jQuery('.triggercheckout').click(function(e){
		e.preventDefault();
		

		jQuery('.bc-cart-actions__checkout-button').trigger('click');

	})


}





/* backtoptop
======================================= */

jQuery('.backtotop').on('click', function(e){
	
    jQuery('html, body').animate({
        scrollTop: 0
    }, 500);
	
});

function showbacktotop(){
	
	
	
	if(
		(window.pageYOffset + window.innerHeight) == document.body.offsetHeight
		
	){
		jQuery('.backtotop').removeClass('show');
	}else if( window.pageYOffset > window.innerHeight ) {
		jQuery('.backtotop').addClass('show');
		
	}else {
		jQuery('.backtotop').removeClass('show');
		
	}
}

window.addEventListener('load', showbacktotop);
document.addEventListener('scroll', showbacktotop);



/* search button
======================================= */

jQuery('.trigger-search-btn').click(function(){
	jQuery('.search-btn-hidden').trigger('click');
});



/* change "cart" to "bag"
======================================= */

function changeCartWord (){
	

	var addtocartmessageWrapper = document.querySelectorAll('.bc-ajax-add-to-cart__message-wrapper');
	
	var addtocartmessage = document.querySelectorAll('.bc-ajax-add-to-cart__message-wrapper > *');
	
	
	for (i = 0; i < addtocartmessage.length; i++) {
		var cartMessage = addtocartmessage[i].innerHTML;
		var newMessage = cartMessage.replace('cart', 'bag');
	
	
		addtocartmessage[i].innerHTML = newMessage;
		
	}
}

if(document.querySelectorAll('.bc-ajax-add-to-cart__message-wrapper').length > 0){

	var addtocartmessageWrapper = document.querySelectorAll('.bc-ajax-add-to-cart__message-wrapper');

	for (i = 0; i < addtocartmessageWrapper.length; i++) {
		
	
		const targetNode = addtocartmessageWrapper[i];
		const config = { attributes: false, childList: true, subtree: false };
		const callback = function(mutationsList, observer) {
			
		  	for(var i = 0; i < mutationsList.length; i++){
		        if (mutationsList[i].type === 'childList') {
					changeCartWord();
		        }
		    }
		};
		
		const observer = new MutationObserver(callback);
		
		observer.observe(targetNode, config);
	}	

}




/* reason (contact page option)
======================================= */

jQuery('.wpcf7-form-control.wpcf7-select').on('click', function(){
	
	jQuery('.wpcf7-form-control.wpcf7-select option').each(function() {
	    if ( jQuery(this).val() == 'Reason' ) {
	       jQuery(this).remove();
	    }
	});


});



/* home - about section
======================================================== */

jQuery('.expand-btn').click(function(){
	
	jQuery('.expand').slideDown();
	jQuery(this).fadeOut();
});


/* search results page
======================================================== */


window.addEventListener('load', function(){
	jQuery('.search-results-page').prepend(jQuery(".search-result-card.high-priority"));
	lazyLoad();
	jQuery('.search-results-page').addClass('ready');
});

/* 
     * ATTR Watcher 
     *
     * $(ele).attrchange(function(attrName){
     *      if (attrName === 'class') {
     *          // Do something
     *      }
     * });
     */

var MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;
jQuery.fn.attrchange = function(callback) {
	if (MutationObserver) {
		var options = {
			subtree: false,
			attributes: true
		};

		var observer = new MutationObserver(function(mutations) {
			mutations.forEach(function(e) {
				callback.call(e.target, e.attributeName);
			});
		});

		return this.each(function() {
			observer.observe(this, options);
		});

	}
}

 /* Track customer group price difference */
 jQuery(".bc-product__price--base").attrchange(function(attrName){
	if (attrName === 'class') {
		console.log('cambio');
		if (jQuery(this).hasClass('bc-show-current-price') && jQuery(this).text() !== jQuery(this).parent().children('.bc-product__price--cgOrig').text()) {
			console.log(jQuery(this).text(), jQuery(this).parent().children('.bc-product__price--cgOrig').text());
			jQuery(this).parent().children('.bc-product__price--cgOrig').addClass('show bc-product__original-price');
		}
	}
});


const $ = jQuery;

// GIFT CERTIFICATE - ON SELECT CHANGE UPDATE AMOUNT
$('#select-amount').on('change', function(e){
	$('#bc-gift-purchase-amount').val(parseInt($(e.currentTarget).val()));
});

$("#loginform #wp-submit").click(function(){
	$(".loader-wrapper").show();
});
$("#registration-part2 .bc-btn--register").click(function(){
	//$(".loader-wrapper").show();
});