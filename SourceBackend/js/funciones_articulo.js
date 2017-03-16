$(document).ready(function(){
	actualizar_categorias();
});

	//var f = $(this);
$("#nuevo_articulo").submit(function(event){//se encarga del envio del formulario para agregar un articulo
	event.stopPropagation();
	event.preventDefault();
	
	var datos_articulo = $("#nuevo_articulo");
	var datos_enviar = new FormData(datos_articulo[0]);	
	
	$.ajax({
		url : "../../articulo_controller.class.php", 
		type : "post",
		contentType: false,
		processData: false,
		data : datos_enviar, 
		cache : false,
		mimeType : false,
		async : false,
		success: function(datos_recibidos){
			gestionar_alertas_nuevo_articulo(datos_recibidos);			
		}		
	});	
	return false;
});	
		
function gestionar_alertas_nuevo_articulo(datos_recibidos){
	$("#alerta_exito_articulo").hide();
	$("#alerta_error_articulo").hide();
	
	if(datos_recibidos == 1){
		$("#alerta_exito_articulo").show();
		$("#alerta_exito_articulo").html("<p>Se ha agregado un nuevo articulo</p>");	
		$("#nuevo_articulo")[0].reset();
	}else{
		$("#alerta_error_articulo").show();
		$("#alerta_error_articulo").html(datos_recibidos);	
	}
}

//se encarga del envio del formulario para agregar un articulo
$("#formulario_nueva_categoria").submit(function(e){//*******************************************formulario categoria**************************
		var datos_categoria = $(this).serialize();		
			$.ajax({
				type: "post",
				url: "../../articulo_controller.class.php",
				data: datos_categoria,
				async: false,
				//dataType: "xml",
				success: function(datos_recibidos){
					gestionar_alertas_categoria(datos_recibidos);
					actualizar_categorias();
					$("#formulario_nueva_categoria")[0].reset();
					$("#ventana_agregar_categoria").modal('hide');
				}
			});
			return false;		
		});		

function gestionar_alertas_categoria(datos_recibidos){
		$("#alerta_exito_categoria_xs").hide();
		$("#alerta_exito_categoria_md").hide();
		$("#alerta_error_categoria_xs").hide();
		$("#alerta_error_categoria_md").hide();
	
	if(datos_recibidos == 1){
		$("#alerta_exito_categoria_xs").show();
		$("#alerta_exito_categoria_xs").html("<p>Se ha añadido una nueva categoría</p>");
		

		//alertas para los tamaños md y lg
		$("#alerta_exito_categoria_md").show();
		$("#alerta_exito_categoria_md").html("<p>Se ha añadido una nueva categoría</p>");
	}
	else{
		//alertas para los tamaños xs y sm
		$("#alerta_error_categoria_xs").show();
		$("#alerta_error_categoria_xs").html(datos_recibidos);
		

		//alertas para los tamaños md y lg
		$("#alerta_error_categoria_md").show();
		$("#alerta_error_categoria_md").html(datos_recibidos);
	}	
}

function mostrar_categorias(categorias){

		var anadir_selector = '<select id="selector_categoria" name="categoria" class="form-control">';//debemos agregar un nuevo selector
		for (var i = 0; i < categorias.length; i++) {
			anadir_selector += '<option>'+ categorias[i].nombre_categoria + '</option>';
		}								
		anadir_selector += '</select>';
		$("#select_catego option").remove();//limpiamos las opciones 
		$("#select_catego").html(anadir_selector);//agrgramos nuevas opciones
}

function actualizar_categorias(){//se encagrga de hacer la petición de un json con todas las categorías
	var datos = {opcion_categorias: 'categorias'};
	$.ajax({
		type: "post",
		url: "../../articulo_controller.class.php",
		data: datos,
		async: false,
		success: function(datos_recibidos){		
			var categorias = JSON.parse(datos_recibidos);//convertimos el objeto json en un array				
			mostrar_categorias(categorias);	
		}
	});
}