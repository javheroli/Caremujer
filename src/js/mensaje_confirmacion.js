/*para poder mostrar los vinculos en la parte responsive */

function mensajeConfirmacionBorrar() {
	var elemento = document.getElementById("borrar");
	if(confirm("¿Está seguro de que desea eliminar esta cita?")){
		 document.formborrar.submit();
	}
}

function mensajeConfirmacionAnular() {
	var elemento = document.getElementById("anular");
	if(confirm("¿Está seguro de que desea anular esta cita?")){
		 document.formanular.submit();
	}
}

function mensajeConfirmacionPedir() {
	var elemento = document.getElementById("pedircita");
	if(confirm("¿Está seguro de que desea pedir esta cita?")){
		 document.formpedircita.submit();
	}
}

