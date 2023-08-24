


/* account
======================================================== */

if(document.querySelectorAll('.login-remember').length > 0){
		
	window.addEventListener('load', function(){
		var forgotpasswordfield = document.querySelectorAll('[title="Forgot Password"]')[0];
		var remembermeform = document.querySelectorAll('.login-remember')[0];
		
		remembermeform.appendChild(forgotpasswordfield);
	});
	
	
	jQuery('p.login-password, 	p.login-username').addClass('smartplaceholder');
}




/* form popup
======================================================== */

		

	
	if(document.querySelectorAll('.bc-account-addresses__add-button').length > 0){
	

		const targetNode = document.querySelectorAll('.bc-account-addresses__list')[0];
		const config = { attributes: true, childList: false, subtree: false };
		const callback = function(mutationsList, observer) {
			
		  	for(var i = 0; i < mutationsList.length; i++){
		        if (mutationsList[i].type === 'attributes') {
					smartplaceholders();
		        }
		    }
		};
		
		const observer = new MutationObserver(callback);
		
		observer.observe(targetNode, config);

	}





/* wish list details
======================================================== */

jQuery('.wishlist-details .bc-wish-list-product-row').each(function(){
	jQuery(this).removeClass('bc-wish-list-product-row').addClass('product-link-direct').addClass('show');
	
});
