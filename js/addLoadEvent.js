function addLoadEvent_fb() {
	var fboldonload = window.onload;
	if (typeof window.onload != 'function'){
		window.onload = function(){
			enableTooltips();
		};
	} else {
		window.onload = function(){
			fboldonload();
			func();
		}
	}
}
addLoadEvent_fb();