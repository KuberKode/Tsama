
if (typeof XMLHttpRequest == "undefined") {
	XMLHttpRequest = function () {
	  	if(window.ActiveXObject){
	  		return new ActiveXObject("Microsoft.XMLHTTP");
	  	}
	  	return null;
	}
}

var elBackdrop = null;
var elFormMain = null;

function ajax(options){

	this.valid = false;
	this.finished = function(){};
	this.async = true;
	this.url = location.href;
	this.node = null;
	this.headers = null;
	this.data = null;

	var aInstance = this;

	if(typeof options != 'undefined'){
		if (typeof options.url != 'undefined' ) { this.url = options.url; }
		if (typeof options.async != 'undefined' ) { this.async = options.async; }
		if (typeof options.node != 'undefined' ) { this.node = options.node;}
		if (typeof options.headers != 'undefined' ) { this.headers = options.headers; }
		if (typeof options.data != 'undefined' ) { this.data = encodeURIComponent(options.data); }		
	}
	
	if(!this.node){ 
		this.node = document.createElement("div");
		document.body.appendChild(this.node);
	}
	
	this.xhr = new XMLHttpRequest();

	if(this.xhr){ this.valid = true; }
	
	this.xhr.responseType = "text";	
	
	this.success = function(e){
		if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
			//alert(this.responseText);
			aInstance.node.innerHTML = this.responseText;
			aInstance.finished();
		}
	};

	this.get = function(getOptions){
		if(this.valid){
			if(typeof getOptions != 'undefined'){
				if (typeof getOptions.url != 'undefined' ) { aInstance.url = getOptions.url; }
				if (typeof getOptions.async != 'undefined' ) { aInstance.async = getOptions.async; }
				if (typeof getOptions.node != 'undefined' ) { aInstance.node = getOptions.node;}	
				if (typeof getOptions.success != 'undefined' ) { aInstance.success = getOptions.success; }				
			}
			this.xhr.open('GET', this.url, this.async);
			this.xhr.setRequestHeader('Content-Type', 'text/plain');
			this.xhr.onload = aInstance.success;
			this.xhr.send(null);
		}
	}

	this.post = function(postOptions){
		if(this.valid){
			if(typeof postOptions != 'undefined'){
				if (typeof postOptions.url != 'undefined' ) { aInstance.url = postOptions.url; }
				if (typeof postOptions.async != 'undefined' ) { aInstance.async = postOptions.async; }
				if (typeof postOptions.node != 'undefined' ) { aInstance.node = postOptions.node;}
				if (typeof postOptions.headers != 'undefined' ) { aInstance.headers = postOptions.headers;}
				if (typeof postOptions.data != 'undefined' ) { aInstance.data = encodeURIComponent(postOptions.data);}
				if (typeof postOptions.success != 'undefined' ) { aInstance.success = postOptions.success; }
			}
			this.xhr.open('POST', this.url, this.async);
			
			this.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			
			this.xhr.onload = aInstance.success;			
			this.xhr.onreadystatechange = function() { // Call a function when the state changes.
				if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
						// Request finished. Do processing here.
				}
			}

			this.xhr.send(aInstance.data);
		}
	}
	this.head = function(options){
		if(this.valid){
			if(typeof options != 'undefined'){}
		}
	}

	return false;	
}

function CancelForm(){
	var docBody = document.body;
	
	docBody.removeChild(elFormMain);
	elFormMain = null;
	docBody.removeChild(elBackdrop);
	elBackdrop = null;
	
	docBody.style.overflow = "auto";
	
	return false;
}

function SubmitForm(obj){
	//alert( obj.action );
	//TODO: validate action
	var urlLocation = obj.action;
	//get inner form area
	//alert(elFormMain.firstChild.className);
	var elFormInner = elFormMain.firstChild;
	//TODO: AJAX POST
	var x = new ajax({
		url: urlLocation,
		node: elFormInner
	});
	
	x.get();
	//TODO: Reload Farms
	
	return false;
}

function ShowForm(formName){
	var docBody = document.body;
	
	if(elBackdrop != null){
		docBody.removeChild(elBackdrop);
		elBackdrop = null;
	}
	
	elBackdrop = document.createElement("div");
	elBackdrop.className = "backdrop";
	
	if(elFormMain != null){
		docBody.removeChild(elFormMain);
		elFormMain = null;
	}
	
	elFormMain = document.createElement("div");
	elFormMain.className = "form-outer";
	
	var elFormInner = document.createElement("div");
	elFormInner.className = "form-inner";
	
	//TODO: Loading, Reload
	
	var btnClose = document.createElement("img");
	btnClose.className = "btn-close";
	btnClose.src =  "content/media/images/close.png";
	btnClose.style.width="24px";
	btnClose.style.height="24px";
	
	var btnCloseOver = new Image();
	btnCloseOver.src =  "content/media/images/close-hover.png";
	
	var btnCloseOriginal = new Image();
	btnCloseOriginal.src =  "content/media/images/close.png";
	
	btnClose.onmouseover = function(){
		btnClose.src = btnCloseOver.src;
	}
	btnClose.onmouseout = function(){
		btnClose.src = btnCloseOriginal.src;
	}
	
	btnClose.onclick = function(){
		CancelForm();
	}
	
	var urlLocation = baseUrl + "form/"+formName;
	
	var x = new ajax({
		url: urlLocation,
		node: elFormInner
	});
	
	x.get();
	
	docBody.style.overflow = "hidden";
	
	elFormMain.appendChild(elFormInner);
	
	docBody.appendChild(elBackdrop);
	elFormMain.appendChild(btnClose);
	docBody.appendChild(elFormMain);

	return false;
}