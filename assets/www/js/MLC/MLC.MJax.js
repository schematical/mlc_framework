MJax.BS = {};
MJax.BS.ScrollTo = function(mixSelector){
	 $('html, body').animate({
            scrollTop: ($(mixSelector).offset().top - 75)
     }, 2000);
};
MJax.Alert = MJax.BS.Alert = function(strHtml){
	var jModal = $('#divModal');
	jModal.find('#pBody').html(strHtml);
	jModal.modal('show');
};
MJax.BS.HideAlert = function(strHtml){
	var jModal = $('#divModal');
	jModal.modal('hide');
};
MJax.BS.CtlAlert = function(mixEle, strHtml, strType){
	
	var jEle = $(mixEle);
	var jAlert = $('<div class="alert mlc-bs-alert"><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
	if(typeof(strType) != 'undefined'){
		jAlert.addClass('alert-' + strType);
	}
	jAlert.append(strHtml);
	jEle.before(jAlert);
};
MJax.BS.ClearCtlAlerts = function(){
	$('.mlc-bs-alert').remove();
}
MJax.BS.AnimateOpen = function(mixEle){
	var jEle = $(mixEle);
	
	var intHeight = jEle.attr('data-orig-height');
	if(typeof intHeight == 'undeifined'){
		return console.log("Error: No original height found");
	}
	jEle.animate({
            height: intHeight
    }, 2000);
    MJax.BS.ScrollTo(jEle);
}
MJax.BS.AnimateClosed = function(mixEle){
	var jEle = $(mixEle);
	var intHeight = jEle.height();
	jEle.attr('data-orig-height', intHeight);
	if(typeof intHeight == 'undeifined'){
		return console.log("Error: No original height found");
	}
	jEle.animate({
            height: 0
    }, 2000);
   // MJax.BS.ScrollTo(jEle);
}
//Init stuff

$(function(){
	$('body').on(
		'click',
		'[data-mlc-scroll]',
		function(){
			var strTo = '#' + $(this).attr('data-mlc-scroll');
			MJax.BS.ScrollTo(strTo);
			return false;
		}
	);
	$('.mjax-bs-animate-hiden').each(
		function(){
			var jThis = $(this);	
			jThis.attr('data-orig-height', jThis.height())
			jThis.css('height', '0Px')
			.css('overflow','hidden');			
		}
	);
})


