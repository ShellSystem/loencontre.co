@extends('layouts.administrar')

@section('contenido')
<head>
	<script type="text/javascript">
		function enviarArea(){//***************formulario categori**************************
			var datos_area = $("#formulario_nueva_area");
			var datos_enviar = new FormData(datos_area[0]);
			$.ajax({
				url :"nueva_area", 
				type : "post",
				contentType: false,
				processData: false,
				data : datos_enviar, 
				cache : false,
				mimeType : false,
				async : false,
				success: function(datos_recibidos){				
					if(datos_recibidos != 1){//existen errores
						datos = JSON.parse(datos_recibidos);//convertimos el objeto json en un array				
						gestionar_alertas_nueva_area(datos);
					}
					else{
						$("#error_form_area").hide();
						$("#exito_form_area").html(' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Se ha agregado una nueva Área!');
						$("#exito_form_area").show();
						window.setTimeout('location.reload()', 2000);
					}
				}
			});
			return false;		
		}

		function gestionar_alertas_nueva_area(datos_recibidos){
		$("#exito_form_area").hide();
		$("#error_form_area").hide();
		
		if (datos_recibidos.length >= 1) {//existen errores
			$("#error_form_area").html("<h4>Existen los siguientes problemas:</h4>")
			for (var i = 0; i < datos_recibidos.length; i++) {
				$("#error_form_area").append('<span class="glyphicon glyphicon-check" aria-hidden="true"></span> '+datos_recibidos[i] + '</br>');
			}
		}
		//$("#alerta_error_articulo").html(datos_recibidos);	
		$("#error_form_area").show();
	}

	function enviarNuevoServicio(){//*******************************************servicio**************************
			var datos_servicio = $("#form_nuevo_servicio");
			var datos_enviar = new FormData(datos_servicio[0]);		
			$.ajax({
				url :"nuevo_servicio", 
				type : "post",
				contentType: false,
				processData: false,
				data : datos_enviar, 
				cache : false,
				mimeType : false,
				async : false,
				success: function(datos_recibidos){		
					console.log(datos_recibidos);
					if (datos_recibidos != 1) {//existen errores
						datos = JSON.parse(datos_recibidos);//convertimos el objeto json en un array				
						gestionar_alertas_nuevo_servicio(datos);
					}else{
						$("#alerta_error_servicio").hide();
						$("#alerta_exito_servicio").html(' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Se ha gregado un nuevo Servicio! </br>');
						$("#alerta_exito_servicio").append('Clic <a href="anadir_servicio"><strong>aquí</strog></a> para añadir otro servicio');
						$("#alerta_exito_servicio").show();
					}					
				}
			});
			return false;		
		}

		function gestionar_alertas_nuevo_servicio(datos_recibidos){
		$("#alerta_exito_servicio").hide();
		$("#alerta_error_servicio").hide();
		//$("#alerta_exito_articulo").html();
		//$("#alerta_error_articulo").html();
		
		if (datos_recibidos.length >= 1) {//existen errores
				$("#alerta_error_servicio").html("<h4>Existen los siguientes problemas:</h4>")
				for (var i = 0; i < datos_recibidos.length; i++) {
					$("#alerta_error_servicio").append('<span class="glyphicon glyphicon-check" aria-hidden="true"></span> '+datos_recibidos[i] + '</br>');
				}
		}
		//$("#alerta_error_articulo").html(datos_recibidos);	
		$("#alerta_error_servicio").show();
		
	}

	function agregar_tarea(){//esta funcion se usa para agregar un cuatro de texto de ingreso de tarea al final de la lista de taras
			var tareas = $("#grupo_tareas input");
			var cantidad_tareas = tareas.length;
			var numero_tarea = cantidad_tareas +1;
			var tarea = '<input type="text" name="tarea_'+numero_tarea+'" class="form-control" placeholder="Servicio número '+numero_tarea+'">'
			$("#grupo_tareas").append(tarea);
		}
	</script>
</head>
<body>
	<div class="container panel panel-default">


		<div class="titulo_pagina row" id="titulo_ingresar_servicio">
			<blockquote class="page-header" style="padding-top:0px;">
				<h5 id="titulo_pagina">Ingrese un servicio <small>Servicios</small></h5>
			</blockquote>
		</div>		

		
		<form  id="form_nuevo_servicio" action="#"  method="post" enctype="multipart/form-data">
			{{csrf_field()}}

			<div class="row" data-toggle="tooltip" data-placement="top" title="Un Área de trabajo agrupa servicios que tengan algun aspecto en común">
					
					<div class="form-group col-xs-7 col-xs-offset-3 text-center"> <!--categoría-->							
						<label for="area"><p class="opcion_formulario"><small>Área de trabajo</small></p></label>
						<div id="select_area">
							<select id="selector_area" name="area" class="form-control">					
								 @foreach($areas as $area)
							       <option> {{$area->nombre}} </option>
								@endforeach	
							</select>							
						</div>
					</div>

			</div><!--div fila 1-->											

			<div class="row" data-toggle="tooltip" data-placement="top" title="Un Área de trabajo agrupa servicios que tengan algun aspecto en común">
				<div class="col-xs-1 col-xs-offset-8 ">
					<a id="boton_agregar_area" href="#ventana_agregar_area" role="button" class="btn btn-default btn-sm boton_formulario" data-toggle="modal">Ingrese un área</a>								
				</div>	

			</div><!--div fila 2-->
			

			<!--******************alertas para Área************************************-->
			<div class="row">
				<div id="alerta_exito_area" class="row alert alert-success" role="alert" hidden>
				</div>
			</div>	

			<div class="row">
				<div id="alerta_error_area" class="row alert alert-warning" role="alert" hidden>
				</div>
			</div>	
			<!--******************fin de alertas para Área************************************-->
			
			<div class="row">
				<div  class="form-group col-xs-11 col-xs-offset-1">
					<label for="nombre"><p class="opcion_formulario"><small>Nombre:</small></p></label>
					<input type="text" name="nombre_servicio" class="form-control" placeholder="Nombre del servicio" required>
				</div>			
			</div>
			
			<div class="row">			
				<div class="form-group col-xs-11 col-xs-offset-1">
					<label for="descripcion"><p class="opcion_formulario"><small>Descripción:</small></p></label>
					<textarea class="form-control" name="descripcion_servicio" rows="7" placeholder="Digite una descripción para el servicio" required></textarea>
				</div>			
			</div><!--div fila 3-->

			<div class="row">
				<div id="grupo_tareas" class="form-group col-xs-11 col-xs-offset-1">
					<label for="autor"><p class="">GOOD FIRM, ofrece los siguientes servicios:</p></label>
					<script>
						for (var i = 1; i < 4; i++) {
							var tarea = '<input type="text" name="tarea_'+i+'" class="form-control" placeholder="Servicio número: '+i+'">'
							$("#grupo_tareas").append(tarea);
						}
					</script>
				</div>
				<div class="col-xs-1 col-xs-offset-11">
					<a class="btn btn-default" onclick="agregar_tarea()"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
				</div>
			</div>

			<!--*******************************alerta para el servicio*************************-->
			<div class="row ">
				<div id="alerta_exito_servicio" class="row alert alert-success text-center" role="alert" hidden>
				</div>

				<div id="alerta_error_servicio" class="row alert alert-warning text-center" role="alert" hidden>
				</div>
			</div><!--*******************************final alerta para el servicio*************************-->

			<div class="row">
				
				<div class="form-group col-xs-1 col-xs-offset-5">
					<input type="button" id="boton_nuevo_servicio" name="nombre_boton" value="Añadir" onclick="enviarNuevoServicio()" class="btn btn-default boton_formulario_servicio">
				</div>

				<div class="form-group col-xs-1 col-xs-offset-1">
					<button type="button" id="nuevo_articulo" onclick="cargar_editar_articulos()" class="btn btn-default boton_formulario">Cancelar</button>
				</div>

			</div>

		</form>	


		<div class="row" id="ventana_nueva_categoria">

			<div id="ventana_agregar_area" class="modal fade">
					
				<div class="modal-dialog">

					<div class="modal-content">
						
						<div class="modal-header" id="cabecera_modal">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-tittle" id="">Nueva Área</h4>		
						</div>			
						
						<form id="formulario_nueva_area" action="#" method="post">
							{{csrf_field()}}

							<div class="modal-body">												
								<div class="row">							
									<div class="form-group col-xs-12">
										<label for="nombre_area" required><p class="opcion_formulario">Nombre</p></label>
										<input type="text" name="nombre_area" class="form-control" placeholder="Nombre del área" required>
									</div>						
								</div><!--fila 1-->

								<div class="row">						
									<div class="form-group col-xs-13">
										<label for="descripcion"><p class="opcion_formulario">Descripción</p></label>
										<textarea name="descripcion_area" class="form-control" placeholder="escriba una descripcion para el área" required></textarea>
									</div>
								</div><!--fila 2-->

								<div class="row">
						
									<!--************************alertas para area********************-->
									<div class="row">
										<div id="exito_form_area" class="row alert alert-success text-center" role="alert" hidden>
										</div>
									</div>	

									<div class="row">
										<div id="error_form_area" class="row alert alert-warning text-center" role="alert" hidden>
										</div>
									</div>				
									<!--************************fin alertas********************-->


								</div>

							</div><!--cuerpo de la ventana-->
							<div class="modal-footer">
								<input id="boton_nueva_categoria" type="button" onclick="enviarArea()" name="btn_nueva_area" class="btn btn-default" value="Agregar">
								<a href="#" data-dismiss="modal" class="btn btn-default">Cancelar</a>
							</div>

						</form>			

					</div><!--modal content-->

				</div><!--modal dialog-->
			</div>	
		</div>		
	</div><!--div container panel-->
</body>
@stop