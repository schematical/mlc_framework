var MJax = {
    ControlType:new Object(),
    /*-------*/
    strCurrPageUrl:null,
    objCurrPostData:{},
    arrControls:new Array(),
    blnFadeOnLoad:false,
    objTransitions:new Object(),
    objExtensions:new Object(),    
    Init:function(){        
        var arrLocationParts = document.location.toString().split("/");
        this.strCurrPageUrl = MJax.GetDocAncorLocation();
        /*
        if(this.strCurrPageUrl != MJax.GetDocRealLocation()){
        	//Removed for hypespark
            //document.location = this.strCurrPageUrl;
            return;
        }*/
        
        $('.MJaxLink').click(function(e){
            var strHref = $(this).attr('href');
            MJax.LoadMainPage(strHref, {action:'change_page'}, true);
            e.preventDefault();
        });
        //Call back setup
        this.funMainPageLoad = function(){};


        //ControlSpecific
        /*$('.MJaxLinkButton').each(function(){
            var jThis = $(this);
            jThis.data('href', jThis.attr('href'));
            jThis.attr('href', 'javascript:');
        });*/
     
        //Set Up AjaxTransitions
        
        this.objTransitions.None = function(strControlId, strHtml){
        	/*if(strControlId == 'mainWindow'){
        		var strSelector = "body";
        	}else{*/
        		var strSelector = "#" + strControlId;
        	//}
        	var jEle = $(strSelector);
        	
        	if((jEle.length > 0)){
	        	if(
	        		(jEle[0].nodeName == 'DIV')
	        	){
	            	jEle.html(strHtml);
		        }else{
		           	jEle.val(strHtml);
	           	}
            }else{
            	MLog("Missing DOM element '#" + strControlId + "'");
            }
            MJax.EndTransition();
        }
        this.objTransitions.Slide = function(strControlId, strHtml){
            $("#" + strControlId).html(strHtml);
            MJax.EndTransition();
        }
        this.objTransitions.Fade = function(strControlId, strHtml){
            $("#" + strControlId).fadeOut(1000, function(){$(this).html(strHtml).fadeIn(1000, MJax.EndTransition);});
        }
        this.objTransitions.SetValue = function(strControlId, strHtml){
            $("#" + strControlId).val(strHtml);
        }

        //Set up extensions
        this.objExtensions.MJaxUploadPanel = {
            Read:function(strControlId){
                var jPnlUpload = $('#' . strControlId);
                if(jPnlUpload.attr('initCall') == 'true'){
                    jPnlUpload.attr('initCall', 'false');
                    return false;
                }else{

                    var s = jQuery.extend({}, jQuery.ajaxSettings, s);
                    var xml = {}
                    var pnlUpload = document.getElementById(strControlId);
                    try
                    {
                        if(pnlUpload.contentWindow)
                        {
                             xml.responseText = pnlUpload.contentWindow.document.body?pnlUpload.contentWindow.document.body.innerHTML:null;
                             xml.responseXML = pnlUpload.contentWindow.document.XMLDocument?pnlUpload.contentWindow.document.XMLDocument:pnlUpload.contentWindow.document;

                        }else if(pnlUpload.contentDocument)
                        {
                            xml.responseText = pnlUpload.contentDocument.document.body?pnlUpload.contentDocument.document.body.innerHTML:null;
                            xml.responseXML = pnlUpload.contentDocument.document.XMLDocument?pnlUpload.contentDocument.document.XMLDocument:pnlUpload.contentDocument.document;
                        }
                    }catch(e)
                    {
                        alert(e.toString());
                        jQuery.handleError(s, xml, null, e);
                    }

                    var objResponse = JSON.parse(xml.responseText);
                    if(objResponse.success == 'true'){
                        var objEvent = new Object();
                        objEvent.target = pnlUpload;
                        MJax.TriggerControlEvent(objEvent, strControlId, 'uploadsuccess', objResponse);
                    }
                    return objResponse;
                }
            }
        }
    },
    GetDocAncorLocation:function(){
        var arrLocationParts = document.location.toString().split("/");

        var arrCurrPageParts = document.location.toString().split("#");
        if(arrCurrPageParts.length == 1){
           if((arrLocationParts[3] == undefined) || (arrLocationParts[3].length == 0)){
                return 'index.php';
           }else{
        	   var strLocation = "/";
	           for(i = 3; i < arrLocationParts.length; i++){
	           		strLocation += arrLocationParts[i];
	           		if(i < arrLocationParts.length - 1){
	        			strLocation += "/";
	        		}
	           }
               return strLocation;
           }
        }else{
           return arrCurrPageParts[1]; 
        }
    },
    GetDocRealLocation:function(){
        var arrLocationParts = document.location.toString().split("/");
        if(arrLocationParts[3] == undefined){
            return 'index.php';
        }else{
        	var strLocation = "/";
        	for(i = 3; i < arrLocationParts.length; i++){
        		strLocation += arrLocationParts[i];
        		if(i < arrLocationParts.length - 1){
        			strLocation += "/";
        		}
        	}
            var arrCurrPageParts = strLocation.split("#");
            if(arrCurrPageParts.length == 1){
               return strLocation;
            }else{
               return arrCurrPageParts[0];
            }
        }
    },
    UpdateDocLocation:function(){
        document.location = this.GetDocRealLocation() + "#" + this.strCurrPageUrl;

    },
    LoadMainPage:function(strUrl, objData, blnFade){
        if(blnFade == undefined){
            blnFade = false;
        }
        MJax.blnFadeOnLoad = blnFade;
        this.strCurrPageUrl = strUrl;
        if(objData == undefined){
            this.objCurrPostData = {};
        }else{
            this.objCurrPostData = objData;
        }
        
        for(var i = 0; i < this.arrControls.length; i++){
        	jControl = $('#' + this.arrControls[i]);
        	if(jControl.is('div')){
        		//DO nothing
        	}else if(jControl.attr('type') == 'checkbox'){
        		this.objCurrPostData[this.arrControls[i]] = jControl.is(':checked');
        	}else{
           		this.objCurrPostData[this.arrControls[i]] = jControl.val();
           	}
        }
        
        var jXhr = $.ajax({
              url: MJax.strCurrPageUrl,
              success: MJax.LoadMainPageLoadCallback,
              data:MJax.objCurrPostData,
              dataType:'xml',
              error: MJax.LoadMainPageLoadFail,
              type:'POST'
        });

        //$("#mainWindow").load(MJax.strCurrPageUrl + " #mainWindow", MJax.objCurrPostData, MJax.LoadMainPageLoadCallback);
        MJax.objCurrPostData = {};
        return jXhr;
        
    },
    LoadMainPageLoadCallback:function(strData, strTextStatus, xmlResponse){
        var jData = $(strData);
        
             var jCollControls = jData.find('controls').children();
             for(var i = 0; i < jCollControls.length; i++){
                 var jControl = $(jCollControls[i]);
                 //MLog(jData);
                 var objCurrTransition = MJax.objTransitions[jControl.attr('transition')];
                 if(typeof objCurrTransition == 'undefined'){
                     objCurrTransition = MJax.objTransitions['None'];
                 }
                 $("#" + jControl.attr('id')).attr('style', jControl.attr('style'));
                 var strValue = jControl.attr('value');
                 if(typeof strValue == 'undefined'){
                 	try{
                 		strValue = jControl.html();
                 	}catch(e){
                 		strValue = jControl.text();
                 	}
                 }
                 objCurrTransition(jControl.attr('id'), strValue);
                 
             }
               
             jCollControls = jData.find('action');
             for(i = 0; i < jCollControls.length; i++){
                 jControl = $(jCollControls[i]);
                 var strText = jControl.text();
                 eval(strText);
             }
        if(typeof  MJax.funMainPageLoad != 'undefined'){
        	MJax.funMainPageLoad();
        }
    },
    LoadMainPageLoadFail:function(jXhr, strTextStaus, strErrorThrown){
    	
    	if(typeof(MJax.Alert) != 'undefined'){
    		MJax.Alert(
    			
    			jXhr.responseText
    		);
    	}
    },
    TriggerControlEvent:function(objEvent, strSelector, strEvent, objData){
        var jTarget = $(strSelector);//$(objEvent.target);
        if(typeof objEvent.preventDefault != 'undefined'){
        	objEvent.preventDefault();
        }
        var jFormState = $("#MJaxForm__FormState");
        var strFormState = jFormState.attr('value');
        if(typeof objData == 'undefined'){
            objData = new Object();
        }
        var strId = jTarget.attr('id');
        if((typeof strId == 'undefined')|| (strId.length == 0)){
        	var jTarget = $(strSelector);
        	strId = jTarget.attr('id');
        }
        objData.action = 'control_event';
        objData.control_id = strId;
        objData.event = strEvent;
        objData.MJaxForm__FormState = strFormState;
        if(objEvent.type == 'keypress'){
            objData.keyCode = objEvent.keyCode;
        }
        
        return MJax.LoadMainPage(MJax.strCurrPageUrl, objData);
        
    },
    ClearRegisteredControls:function(){
        this.arrControls = new Array();
    },
    RegisterControl:function(strControlId){
        this.arrControls[this.arrControls.length] = strControlId;
    },
    EndTransition:function(){
        $('body').trigger('transitionend');
    },
    OpenNewTab:function(strUrl){
		  window.open(strUrl, '_blank');
		  window.focus();
    }
};
/*
MJax.ControlType.ScrollBar = {
    Init:function(){
        var jParent = $('scrollBar_holder').parent();
        jParent.css('width', jParent.css('width'));
        var intScale = jParent.css('height');
        $('scrollBar_slider').css('height', )
    }
};
*/
function MLog(mixObject){
	if(typeof console != 'undefined'){
		console.log(mixObject);
	}
}
