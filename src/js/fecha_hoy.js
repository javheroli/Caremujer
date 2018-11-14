/*para poder mostrar los vinculos en la parte responsive */

function fechaActual() {

    var  fecha = document.getElementById("fecha");
    var f = new Date();
    var dd = f.getDate();
	var mm = f.getMonth()+1; //hoy es 0!
	var yyyy = f.getFullYear();
	if(dd<10){
		dd='0'+dd
	} 
	if(mm<10) {
		mm='0'+mm
	} 
	fecha.setAttribute("min",yyyy+"-"+mm+"-"+dd);
}