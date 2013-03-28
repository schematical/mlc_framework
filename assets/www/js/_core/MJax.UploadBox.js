MJax.UploadBox = {
	regex:null,
	intBytesUploaded:0,
	intBytesTotal:0,
	intPreviousBytesLoaded:0,
	max_filesize:1048576, // 1MB
	objTimer:0,
	strResultFileSize:'',
	Init:function(strSelector){
		var jEle = $(strSelector);
		$('body').on('change', strSelector,MJax.UploadBox.FileSelected);
	},
	Alert:function(strAlert){
		alert(strAlert);
	},
	FileSelected:function(objEvent) {
	
	    // get selected file element
	    var  jUploadBox = $(this);
 
	    if(MJax.UploadBox.regex != null){
		    if (! rFilter.test( jUploadBox.type)) {
		        MJax.UploadBox.Alert('Not a valid file type');
		        return;
		    }
		}
	
	    // little test for filesize
	    if ( jUploadBox.size > MJax.UploadBox.max_filesize) {
	        MJax.UploadBox.Alert('File is too big');
	        return;
	    }
	
	  
	    // prepare HTML5 FileReader
	    var objReader = new FileReader();
	    objReader.onload = function(e){    };
	
	    // read selected file as DataURL
	    objReader.readAsDataURL(jUploadBox);
	    MJax.UploadBox.StartUploading(jUploadBox);
	},
	DoInnerUpdates:function() { // we will use this function to display upload speed
	    var iCB = iBytesUploaded;
	    var iDiff = iCB - intPreviousBytesLoaded;
	
	    // if nothing new loaded - exit
	    if (iDiff == 0)
	        return;
	
	    intPreviousBytesLoaded = iCB;
	    iDiff = iDiff * 2;
	    var iBytesRem = iBytesTotal - intPreviousBytesLoaded;
	    var secondsRemaining = iBytesRem / iDiff;
	
	    // update speed info
	    var iSpeed = iDiff.toString() + 'B/s';
	    if (iDiff > 1024 * 1024) {
	        iSpeed = (Math.round(iDiff * 100/(1024*1024))/100).toString() + 'MB/s';
	    } else if (iDiff > 1024) {
	        iSpeed =  (Math.round(iDiff * 100/1024)/100).toString() + 'KB/s';
	    }
	
	    //document.getElementById('speed').innerHTML = iSpeed;
	    //document.getElementById('remaining').innerHTML = '| ' + secondsToTime(secondsRemaining);        
	},
	UploadProgress:function(objEvent) { // upload process in progress
	    if (objEvent.lengthComputable) {
	        iBytesUploaded = objEvent.loaded;
	        iBytesTotal = objEvent.total;
	        var intPercentComplete = Math.round(objEvent.loaded * 100 / objEvent.total);
	        var iBytesTransfered = bytesToSize(iBytesUploaded);
	
	        //document.getElementById('progress_percent').innerHTML = iPercentComplete.toString() + '%';
	        //document.getElementById('progress').style.width = (iPercentComplete * 4).toString() + 'px';
	        //document.getElementById('b_transfered').innerHTML = iBytesTransfered;
	        if (intPercentComplete == 100) {
	            //var oUploadResponse = document.getElementById('upload_response');
	            //oUploadResponse.innerHTML = '<h1>Please wait...processing</h1>';
	            //oUploadResponse.style.display = 'block';
	        }
	    } else {
	        //document.getElementById('progress').innerHTML = 'unable to compute';
	    }
	},
	UploadFinish:function(objEvent) { // upload successfully finished
		clearInterval(MJax.UploadBox.objTimer);
	    //MJax.LoadMainPageLoadCallback(objEvent.target.responseText);
	    
	    
	},
	UploadError:function(objEvent) { // upload error
	    clearInterval(MJax.UploadBox.objTimer);
	},  
	UploadAbort:function(objEvent) { // upload abort
        clearInterval(MJax.UploadBox.objTimer);
	},
	StartUploading:function(jTarget) {
		window.URL = window.URL || window.webkitURL || window.mozURL;
	    // cleanup all temp states
	    intPreviousBytesLoaded = 0;
   
    
    	var objFormData = new FormData($('body')[0]); 
    
        var strFormState = $("#MJaxForm__FormState").attr('value');
       
        var strId = jTarget.attr('id');
        if((typeof strId == 'undefined')|| (strId.length == 0)){
        	var jTarget = $(strSelector);
        	strId = jTarget.attr('id');
        }
        objFormData.append('action', 'control_event');
        objFormData.append('control_id', strId);
        objFormData.append('event', 'upload');
        objFormData.append('MJaxForm__FormState', strFormState);
        
        for(var i = 0; i < MJax.arrControls.length; i++){
        	jControl = $('#' + MJax.arrControls[i]);
        	if(jControl.is('div')){
        		//DO nothing
        	}else if(jControl.attr('type') == 'checkbox'){
        		objFormData.append(MJax.arrControls[i], jControl.is(':checked'));
        	}else{
           		objFormData.append(MJax.arrControls[i], jControl.val());
           	}
        }
        
        objFormData.append(jTarget.attr('id'), jTarget[0].files[0]);//URL.createObjectURL(jTarget[0].files[0]));
        
         var jXhr = $.ajax({
              url: MJax.strCurrPageUrl,
              success: MJax.LoadMainPageLoadCallback,
              data:objFormData,
              dataType:'xml',
              type:'POST',
              xhr: function() {  // custom xhr
		            myXhr = $.ajaxSettings.xhr();
		            if(myXhr.upload){ // check if upload property exists
		                myXhr.upload.addEventListener('progress', MJax.UploadBox.UploadProgress, false);					   
					    myXhr.addEventListener('load', MJax.UploadBox.UploadFinish, false);
					    myXhr.addEventListener('error', MJax.UploadBox.UploadError, false);
					    myXhr.addEventListener('abort', MJax.UploadBox.UploadAbort, false);
		            }
		            return myXhr;
		     },
	        cache: false,
	        contentType: false,
	        processData: false
        });
        
	    // set inner timer
	    MJax.UploadBox.objTimer = setInterval(MJax.UploadBox.DoInnerUpdates, 300);
	}
	
}


function secondsToTime(secs) { // we will use this function to convert seconds in normal time format
    var hr = Math.floor(secs / 3600);
    var min = Math.floor((secs - (hr * 3600))/60);
    var sec = Math.floor(secs - (hr * 3600) -  (min * 60));

    if (hr < 10) {hr = "0" + hr; }
    if (min < 10) {min = "0" + min;}
    if (sec < 10) {sec = "0" + sec;}
    if (hr) {hr = "00";}
    return hr + ':' + min + ':' + sec;
};

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};





