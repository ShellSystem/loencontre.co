var indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;

var dataBase = null;

var count = 1;


// ###########################################################
// Inicializacion de base de datos local
// ###########################################################
function startDB(name,collection) {
	dataBase = indexedDB.open(name);
	dataBase.onupgradeneeded = function (e) {

		active = dataBase.result;

		object = active.createObjectStore(collection, {keyPath : 'id'});
		object.createIndex('by_name', 'name', { unique : false });
		object.createIndex('by_link', 'link', { unique : true });
	};

	dataBase.onsuccess = function (e) {
		console.log('Base de datos cargada correctamente');
	};

	dataBase.onerror = function (e)  {
		console.log('Error cargando la base de datos');
	};
}


// ###########################################################
// Agregado de elemento a la coleccion
// ###########################################################
function addDB(collection, element) {
	var active = dataBase.result;
	var data = active.transaction([collection], "readwrite");
	var object = data.objectStore(collection);      
	var request = object.put(element);          

	request.onerror = function (e) {
		console.log(request.error.name + '\n\n' + request.error.message);
	};

	data.oncomplete = function (e) {
		count++;
		console.log('Objeto agregado correctamente');
		str = count.toString();
		if (str.substr(-3) === '000'){
			$.showLoading((members.length-count) + ' miembros restantes para finalizar.');
		}
		console.log(count +" - " + members.length);
		if (count >= members.length) {
			$.showLoading('Clasificando por nombre ...');
			classifierMembersFacebookName();
		}
	};
}


// ###########################################################
// Agregado de array a la base de datos local
// ###########################################################
function saveDB(collection, array) {
	for (var i = array.length - 1; i >= 0; i--) {
		addDB(collection, array[i]);
	}
}

// ###########################################################
// Recuperacion de los elementos en la base de datos local
// ###########################################################
function loadAllDB(collection) {
	var active = dataBase.result;
	var data = active.transaction([collection], "readonly");
	var object = data.objectStore(collection);

	var elements = [];

	object.openCursor().onsuccess = function (e) {

		var result = e.target.result;

		if (result === null) {
			return;
		}

		elements.push(result.value);
		result.continue();

	};

	data.oncomplete = function () {
		if (elements.length == 0) {
			refresh('');
		}else{
			members = elements;
			$.showLoading('Numero de miembros: ' + members.length);
			$.showLoading('Clasificando por nombre ...');
			classifierMembersFacebookName(nameDetect);
		}
	};
}

startDB("loencontre.co", "members");



