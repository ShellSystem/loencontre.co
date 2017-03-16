function cargar_agregar_articulo(){
	$("#contenido_administrar").load("../articulo/ingresar_articulo.html");
	$("#opciones_administrar li").removeClass("active");
	$("#link_agregar_articulo").addClass("active");
	$("#link_articulos").addClass("active");
}

function cargar_editar_articulos(){
	$("#contenido_administrar").load("../articulo/editar_articulos.html");
	$("#opciones_administrar li").removeClass("active");
	$("#link_ver_articulos").addClass("active");
	$("#link_articulos").addClass("active");
}

function cargar_categorias(){
	$("#opciones_administrar li").removeClass("active");
	$("#link_categorias").addClass("active");
	$("#contenido_administrar").load("../articulo/categorias.html");
	$("#link_articulos").addClass("active");
}

function cargar_agregar_servicio(){
	$("#opciones_administrar li").removeClass("active");
	$("#link_agregar_servcio").addClass("active");
	$("#contenido_administrar").load("../servicios/agregar_servicio.html");
	$("#link_servicios").addClass("active");
}

function cargar_editar_areas(){
	$("#opciones_administrar li").removeClass("active");
	$("#link_editar_areas").addClass("active");
	$("#contenido_administrar").load("../servicios/editar_areas.html");
	$("#link_servicios").addClass("active");
}

function cargar_editar_servicios(){
	$("#opciones_administrar li").removeClass("active");
	$("#link_editar_servicios").addClass("active");
	$("#contenido_administrar").load("../servicios/editar_servicios.html");
	$("#link_servicios").addClass("active");
}

