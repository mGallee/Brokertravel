$('#example').popover(show);

function request_travel(url){
	fenster = window.open(url,"Popupfenster", "width=880,height=600, top=200, left=200");
	fenster.focus();
	return false;
}