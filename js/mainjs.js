function create_dates() {
	var d = new Date();
	var preSelect = document.getElementById("0");
	d.setDate(d.getDate() + 1);
	preSelect.innerHTML = d.toDateString();
	//Dynamically creates dates for the next 2 weeks and makes them into elements.
	for (i = 0; i < 13; i++) {
		d.setDate(d.getDate() + 1);
		var opt = document.createElement("option");
		var node = document.createTextNode(d.toDateString());
		var sel = document.getElementById("dates");
		opt.appendChild(node);
		sel.appendChild(opt);
	}
}