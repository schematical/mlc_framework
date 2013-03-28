var MJax = {
    ControlType:new Object(),
    /*-------*/
    strCurrPageUrl:null,
    objCurrPostData:{},
    arrControls:new Array(),
    blnFadeOnLoad:false,
    Init:function(){
        
        var arrLocationParts = document.location.toString().split("/");
        this.strCurrPageUrl = MJax.GetDocAncorLocation();
        
        if(this.strCurrPageUrl != MJax.GetDocRealLocation()){
            document.location = this.strCurrPageUrl;
            return;
        }
        
        $('.MJaxLink').click(function(e){
            var strHref = $(this).attr('href');
            MJax.LoadMainPage(strHref, {action:'change_page'}, true);
            e.preventDefault();
        });
        //Call back setup
        this.funMainPageLoad = function(){};


        //ControlSpecific
        $('.MJaxLinkButton').each(function(){
            var jThis = $(this);
            jThis.data('href', jThis.attr('href'));
            jThis.attr('href', 'javascript:');
        });

        
    },
    GetDocAncorLocation:function(){
        var arrLocationParts = document.location.toString().split("/");

        var arrCurrPageParts = document.location.toString().split("#");
        if(arrCurrPageParts.length == 1){
           if((arrLocationParts[3] == undefined) || (arrLocationParts[3].length == 0)){
                return 'index.php';
           }else{
                return arrLocationParts[3];
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
            var arrCurrPageParts = arrLocationParts[3].split("#");
            if(arrCurrPageParts.length == 1){
               return arrLocationParts[3];
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
            this.objCurrPostData[this.arrControls[i]] = $('#' + this.arrControls[i]).attr('value');
        }
        if(MJax.blnFadeOnLoad){
            $("#mainWindow").animate(
                {"height":"2Px"},
                450,
                MJax.LoadMainPageShrinkCallback
            );
        }else{
            MJax.LoadMainPageShrinkCallback();
        }
    },
    LoadMainPageShrinkCallback:function(){
        if(MJax.blnFadeOnLoad){
            $("#mainWindow").css('display','none');
        }
        
        $.ajax({
              url: MJax.strCurrPageUrl,
              success: MJax.LoadMainPageLoadCallback,
              data:MJax.objCurrPostData,
              dataType:'xml',
              type:'POST'
        });
        
        //$("#mainWindow").load(MJax.strCurrPageUrl + " #mainWindow", MJax.objCurrPostData, MJax.LoadMainPageLoadCallback);
        MJax.objCurrPostData = {};
    },
    LoadMainPageLoadCallback:function(strData, strTextStatus, xmlResponse){
        var xmlBody = xmlResponse.responseXML.firstChild;
        var xmlControl = null;
        var strControlId = null;
        
        for(var i = 0; i < xmlBody.childNodes.length; i++){
            if(xmlBody.childNodes[i].tagName == 'controls'){
                for(var ii = 0; ii < xmlBody.childNodes[i].childNodes.length; ii++){
                    xmlControl = xmlBody.childNodes[i].childNodes[ii];
                    if(xmlControl.tagName == 'control'){
                        strControlId = xmlControl.getAttribute('id');
                        
                        $("#" + strControlId).html(xmlControl.firstChild.nodeValue);                         
                    }
                    
                }
            }
            if(xmlBody.childNodes[i].tagName == 'actions'){
                for(var ii = 0; ii < xmlBody.childNodes[i].childNodes.length; ii++){
                    xmlControl = xmlBody.childNodes[i].childNodes[ii];
                    if(xmlControl.tagName == 'action'){
                        eval(xmlControl.firstChild.nodeValue);
                    }

                }
            }
        }
        if(MJax.blnFadeOnLoad){
            MJax.AutoAdjustHeight(MJax.LoadMainPageGrowCallback);
        }else{
            MJax.LoadMainPageGrowCallback();
        }
        MJax.UpdateDocLocation();
    },
    LoadMainPageGrowCallback:function(){
       MJax.funMainPageLoad();
        //alert($("#mainWindow").css('height'));
    },
    TriggerControlEvent:function(objEvent, strSelector, strEvent){
        var jTarget = $(objEvent.target);
        
        var strFormState = $("#MJaxForm__FormState").attr('value');
        var objData = {
            action:'control_event',
            control_id:jTarget.attr('id'),
            event:strEvent,
            MJaxForm__FormState:strFormState
        };
        if(objEvent.type == 'keypress'){
            objData.keyCode = objEvent.keyCode;
        }
        
        MJax.LoadMainPage(MJax.strCurrPageUrl, objData);
    },
    ClearRegisteredControls:function(){
        this.arrControls = new Array();
    },
    RegisterControl:function(strControlId){
        this.arrControls[this.arrControls.length] = strControlId;
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