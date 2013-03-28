MJax.Stripe = {
	jForm:null,
	Init:function(strKey, mixFormSelector){
		 Stripe.setPublishableKey(strKey);
		 MJax.Stripe.jForm = $(mixFormSelector);
 	},
    StripeResponseHandler:function(strStatus, objResponse) {
    	var jForm = MJax.Stripe.jForm;
    	var objData = {};
    	objData[jForm.attr('id')] = objResponse;
    	if (objResponse.error) {
	        // Show the errors on the form
	        MJax.TriggerControlEvent({}, '#' + jForm.attr('id'), 'stripe_payment_error', objData);
	    } else {
    		MJax.TriggerControlEvent({}, '#' + jForm.attr('id'), 'stripe_payment_success', objData);
        }
    },
 
    Submit:function() {
    	var jForm = MJax.Stripe.jForm;
    	var objData = {
          number: jForm.find('.card-number').val(),
          cvc: jForm.find('.card-cvc').val(),
          exp_month: jForm.find('.card-expiry-month').val(),
          exp_year: jForm.find('.card-expiry-year').val()
        };
        if(jForm.find('.card-address1').length != 0){
        	objData.address_line1 = jForm.find('.card-address1').val();
        	objData.address_line2 = jForm.find('.card-address2').val();
        	objData.address_city = jForm.find('.card-city').val();
        	objData.address_state = jForm.find('.card-state').val();
        	objData.address_zip = jForm.find('.card-zip').val();
        }
        Stripe.createToken(
        	objData, 
        	MJax.Stripe.StripeResponseHandler
        );
	}
	
	
};