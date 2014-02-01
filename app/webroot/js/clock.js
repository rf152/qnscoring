function setClock() {
	var time = new Date();
	var strTime = new String();
	var strMins = time.getUTCMinutes();
	var strHour = time.getUTCHours();
	var strMinsStart = "";
	var strHourStart = "";
	if (strMins < 10) {
		strMinsStart = "0";
	}
	if (strHour < 10) {
		strHourStart = "0";
	}
	strTime = strHourStart + strHour + ":" + strMinsStart + strMins;
	//alert("Updating clock: " + strTime);
	//alert(document.getElementById('clock').innerHtml);
	document.getElementById('clock').innerHtml = strTime;
	setTimeout('setClock()', 6000);
}
setTimeout('setClock()', 6000);
