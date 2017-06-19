// ###########################################################
// Guardado de array en localStorage
// ###########################################################
function saveArray(name, array) {
	localStorage.setItem(name, JSON.stringify(array));
}


// ###########################################################
// Obtencion de array en localStorage
// ###########################################################
function getArray(name) {
	var array = localStorage.getItem(name);
	return JSON.parse(array);
}
