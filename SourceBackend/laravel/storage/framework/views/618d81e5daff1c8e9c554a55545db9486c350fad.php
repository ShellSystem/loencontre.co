<?php $__env->startSection('contenido'); ?>

<head> 
	<meta charset="utf-8">
	<script src="../public/js/tinymce/tinymce.min.js"></script>
	<script>
		tinymce.init({selector : "#textarea_contenido", 
						theme: 'modern',
						plugins : "fullpage",
						fullpage_default_font_size: "20px",
						fullpage_default_text_color: "#666666",
						fullpage_default_font_family: "'Open sans', sans-serif",				
						fullpage_default_font_langcode: "es",
						
						toolbar:'fontcolorselect | bold | italic | alignleft | alingnright | alignjustify | bullist | numlist | fontsizeselect | fontselect',
						menubar: false		
				});

	</script>



	
	<script type="text/javascript">


	function nuevo_articulo(){
		tinyMCE.triggerSave();
		var datos_articulo = $("#nuevo_articulo");
		var datos_enviar = new FormData(datos_articulo[0]);
		//console.log(datos_articulo);
		$.ajax({
			url :"nuevo_articulo", 
			type : "post",
			contentType: false,
			processData: false,
			data : datos_enviar, 
			cache : false,
			mimeType : false,
			async : false,
			success: function(datos_recibidos){				
				//console.log("dats: " +datos_recibidos);
				if (datos_recibidos != 1) {//existen errores
					datos = JSON.parse(datos_recibidos);//convertimos el objeto json en un array				
					gestionar_alertas_nuevo_articulo(datos);
				}else{
					$("#alerta_error_articulo").hide();
					$("#alerta_exito_articulo").html(' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Se ha agregado un nuevo Artículo! </br>');
					$("#alerta_exito_articulo").append('Clic <a href="anadir_articulo"><strong>aquí</strog></a> para añadir otro árticulo');
					$("#alerta_exito_articulo").show();
				}
			}		

		});	
		//console.log("pasó");
	}

	function gestionar_alertas_nuevo_articulo(datos_recibidos){
		$("#alerta_exito_articulo").hide();
		$("#alerta_error_articulo").hide();
		//$("#alerta_exito_articulo").html();
		//$("#alerta_error_articulo").html();
		
		if (datos_recibidos.length >= 1) {//existen errores
				$("#alerta_error_articulo").html("<h4>Existen los siguientes problemas:</h4>")
				for (var i = 0; i < datos_recibidos.length; i++) {
					$("#alerta_error_articulo").append('<span class="glyphicon glyphicon-check" aria-hidden="true"></span> '+datos_recibidos[i] + '</br>');
				}
		}
		//$("#alerta_error_articulo").html(datos_recibidos);	
		$("#alerta_error_articulo").show();
		
	}

	function gestionar_alertas_nueva_categoria(datos_recibidos){
		$("#exito_form_categoria").hide();
		$("#error_form_categoria").hide();
		
		if (datos_recibidos.length >= 1) {//existen errores
			$("#error_form_categoria").html("<h4>Existen los siguientes problemas:</h4>")
			for (var i = 0; i < datos_recibidos.length; i++) {
				$("#error_form_categoria").append('<span class="glyphicon glyphicon-check" aria-hidden="true"></span> '+datos_recibidos[i] + '</br>');
			}
		}
		//$("#alerta_error_articulo").html(datos_recibidos);	
		$("#error_form_categoria").show();
	}



	function nueva_categoria(){
		var datos_categoria = $("#formulario_nueva_categoria");
			var datos_enviar = new FormData(datos_categoria[0]);
		//	console.log(datos_enviar);
			$.ajax({
				url :"nueva_categoria", 
				type : "post",
				contentType: false,
				processData: false,
				data : datos_enviar, 
				cache : false,
				mimeType : false,
				async : false,
				success: function(datos_recibidos){				
					//console.log("dats: " +datos_recibidos);
					if(datos_recibidos != 1){//existen errores
						datos = JSON.parse(datos_recibidos);//convertimos el objeto json en un array				
						gestionar_alertas_nueva_categoria(datos);
					}
					else{
						$("#error_form_categoria").hide();
						$("#exito_form_categoria").html(' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Se ha agregado una nueva categoría!');
						$("#exito_form_categoria").show();
						window.setTimeout('location.reload()', 2000);
					}
				}		

			});	
		
	}
</script>
</head>
<!--**************************¨*************contenedor******************************************-->
<div class="container panel panel-default">

	<!--***************************titulo**************-->
	<div class="titulo_pagina row" id="titulo_ingresar_articulo">
		<blockquote class="page-header" style="padding-top:0px;">
			<h5 id="titulo_pagina">Ingrese un Post <small>Artículos</small></h5>
		</blockquote>
        
	</div>	
	<!--***************************Final titulo**************-->

    

 

	<!--*******************************************************inicio formulario****************************************************-->	
	<form  id="nuevo_articulo" action="#" onsubmit="enviar_formulario()" method="post" enctype="multipart/form-data">

		<?php echo e(csrf_field()); ?>

		
		<div class="row" data-toggle="tooltip" data-placement="top" title="Una categoría agrupa artículos que tengan algun aspecto en común">

			<!--***************************categoaría**************-->
			<div class="form-group col-md-5 col-md-offset-1 text-center"> <!--categoría-->							
				<label for="categoria"><p class="opcion_formulario">Categoría</p></label>
				<div id="select_catego">
					<select id="selector_categoria" name="categoria" class="form-control">			
					   <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
					       <option> <?php echo e($categoria['nombre']); ?> </option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>		
					</select>
				</div>
			</div>

			<!--***************************boton visible en sx y xm**************-->
			<div class="row visible-sm-block visible-xs-block">
				<div class="col-xs-1 col-xs-offset-9 ">
					<a href="#ventana_agregar_categoria" role="button" class="btn btn-default btn-sm boton_formulario boton_categoria" data-toggle="modal">Nueva categoría</a><!--este div está definido en el archivo agregar_categoria.html-->
									
				</div>						

			</div><!--div fila 2 crear categoría visible en sm y xs-->			



			<div class="row">				

				<!--************************alertas para categoria sm y xs********************-->
				<div class="row visible-xs-block visible-sm-block">
					<div id="alerta_exito_categoria_xs" class="row alert alert-success text-center" role="alert" hidden>
					</div>
				</div>	

				<div class="row visible-xs-block visible-sm-block">
					<div id="alerta_error_categoria_xs" class="row alert alert-warning text-center" role="alert" hidden>
					</div>
				</div>				
				<!--************************fin alertas********************-->

				<!--************************titulo********************-->
				<div class="form-group col-md-6 text-center"><!--título-->							
					<label for="titulo_articulo"><p class="opcion_formulario">Título</p></label>
					<input type="text" name="titulo_articulo" class="form-control" placeholder="Título del articulo" required="true">
				</div>

				<!--************************boton visible en md y lg********************-->
				<div class="row visible-md-block visible-lg-block"">
					<div class="col-md-1 col-md-offset-4 ">
						<a id="boton_prueba" href="#ventana_agregar_categoria" role="button" class="btn btn-default btn-sm boton_categoria boton_formulario" data-toggle="modal">Nueva categoría</a>
								
					</div>			


				</div>

			</div><!--div-->				
			
		</div><!--div fila categoria y titulo-->		

		<!--******************alertas para categoría visible en md y lg************************************-->
		<div class="row visible-md-block visible-lg-block">
			<div id="alerta_exito_categoria_md" class="row alert alert-success" role="alert" hidden>
			</div>
		</div>	

		<div class="row visible-md-block visible-lg-block">
			<div id="alerta_error_categoria_md" class="row alert alert-warning" role="alert" hidden>
			</div>
		</div>	
		<!--******************fin alertas md y lg************************************-->
		

		<!--******************autor y fecha ************************************-->
		<div class="row">			
			<div class="form-group col-md-5 col-md-offset-1 text-center">
				<label for="autor"><p class="opcion_formulario">Autor</p></label>
				<input type="text" name="autor" class="form-control" placeholder="Autor" required>
			</div>

			<div class="form-group col-md-6 text-center">
				<label for="fecha"><p class="opcion_formulario">Fecha de publicación</p></label>
				<input id="fecha_articulo" type="date" name="fecha" class="form-control" placeholder="dd/mm/yyyy" required>					
			</div>
		</div>
		<!--******************fin autor y fecha ************************************-->

		<!--******************imagen************************************-->
		<div class="row">
			<div class="form-group col-xs-12 col-xs-offset-1">

				<label for="imagen"><p class="opcion_formulario">Imágen</p></label>				
				<input type="file" class="" name="imagen_articulo" id="imagen_articulo" />
				<p class="help-block">Búsque una imagen para este artículo...</p>

			</div>
		</div>
		<!--******************fin imagen************************************-->

		<!--******************  contenido************************************-->		
		<div class="row">	
			
			<div class="form-group col-md-11 col-md-offset-1">
				<label for="contenido"><p class="opcion_formulario">Contenido</p></label>

				<textarea id="textarea_contenido" name="contenido" class="form-control" rows="20" placeholder="Escriba el contenido del artículo..."></textarea>
				<div class="panel panel-default">		
				</div>
			</div>
		</div><!--div fila 4 contenido-->



		<!--*******************************alerta para el articulo*************************-->
		<div class="row ">
			<div id="alerta_exito_articulo" class="row alert alert-success text-center" role="alert" hidden>
			</div>

			<div id="alerta_error_articulo" class="row alert alert-warning text-center" role="alert" hidden>
			</div>
		</div>
		<!--*******************************final alerta para el articulo*************************-->


		<!--*******************************botones*************************-->
		<div class="row">			
			<div class="form-group col-xs-1 col-xs-offset-5">
				<button type="button" onclick="nuevo_articulo()" class="btn btn-default boton_formulario">Enviar</button>
			</div>

			<div class="form-group col-xs-1 col-xs-offset-1">
				<button type="button"  onclick="" class="btn btn-default boton_formulario">Cancelar</button>
			</div>

		</div>

	</form>
	<!--*******************************final cormulario*************************-->

</div>
<!--fin div container panel*********************-->



<div id="ventana_agregar_categoria" class="modal fade"><!--********ventana modal para agregar una categoria*********************-->
					
	<div class="modal-dialog">

		<div class="modal-content">
			
			<div class="modal-header" id="cabecera_modal">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;	</button>
				<h4 class="modal-tittle" id="">Nueva categoría</h4>		
			</div>
			
			
			<form id="formulario_nueva_categoria" onsubmit="nueva_categoria()" method="post">
			<?php echo e(csrf_field()); ?>

				<div class="modal-body">			
						
					<div class="row">							
						<div class="form-group col-xs-12">
							<label for="nombre_categoria" required><p class="opcion_formulario">Nombre</p></label>
							<input type="text" name="nombre_categoria" class="form-control" placeholder="Nombre de la categoria" required>
						</div>						
					</div><!--fila 1-->

					<div class="row">						
						<div class="form-group col-xs-13">
							<label for="descripcion"><p class="opcion_formulario">Descripción</p></label>
							<textarea name="descripcion_categoria" class="form-control" placeholder="escriba una descripcion" required></textarea>
						</div>
					</div><!--fila 2-->


					<div class="row">
						
						<!--************************alertas para categoria********************-->
						<div class="row">
							<div id="exito_form_categoria" class="row alert alert-success text-center" role="alert" hidden>
							</div>
						</div>	

						<div class="row">
							<div id="error_form_categoria" class="row alert alert-warning text-center" role="alert" hidden>
							</div>
						</div>				
						<!--************************fin alertas********************-->


					</div>

				</div><!--cuerpo de la ventana-->
				<div class="modal-footer">
					<button type="button" onclick="nueva_categoria()" class="btn btn-default boton_formulario">Crear</button>
					<a href="#" data-dismiss="modal" class="btn btn-default">Cancelar</a>
				</div>

			</form>			

		</div><!--modal content-->

	</div><!--modal dialog-->
</div>

<?php $__env->stopSection(); ?>






<?php echo $__env->make('layouts.administrar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>