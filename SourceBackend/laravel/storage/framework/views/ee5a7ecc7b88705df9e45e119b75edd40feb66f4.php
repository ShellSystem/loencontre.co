<?php $__env->startSection('contenido'); ?>
<head>	
	<script src="<?php echo e(URL::asset('/js/chart/Chart.bundle.min.js')); ?>"></script>
	<script type="text/javascript">	
		
		function paginar_articulos(){			
			//console.log($('meta[name="csrf-token"]').attr('content'));			
    		var datos_token = $("#token");
			var datos_enviar = new FormData(datos_token[0]);
			$.ajax({
				type: "post",
				url: "<?php echo e(URL::asset('administrar/cantidad_articulos')); ?>",
				contentType: false,
				processData: false,
				data : datos_enviar, 
				cache : false,
				mimeType : false,
				async : false,
				success: function(datos_recibidos){						
					//console.log(datos_recibidos);
					var cantidad_articulos = datos_recibidos;					
					organizar_paginas(cantidad_articulos);
				}
			});
		}

		function organizar_paginas(cantidad_articulos){
			var cantidad_paginas = Math.floor(Number(cantidad_articulos)/4) + 1;//se divide en cuatro porque se muestran 4 articulos por página		
			for (var i = 1; i <= cantidad_paginas; i++) {
				//var numero_pagina = '<li><a class="btn" onclick="pedir_pagina(' + i + ')">' + i + '</a></li>';
				var numero_pagina = '<li><a href="../editar_articulos/'+ i+'"  class="btn">' + i + '</a></li>';
				$("#paginacion_articulos").append(numero_pagina);
			}
		}

		function mostrar_ventana_modal(idArticulo){			
			$("#datos").attr('name', 'idArticulo');
			$("#datos").attr('value', idArticulo);
			var datos_token = $("#token");
			var datos_enviar = new FormData(datos_token[0]);
			$.get({
				type: "post",
				url: "<?php echo e(URL::asset('editar_articulo')); ?>",
				contentType: false,
				processData: false,
				data : datos_enviar, 
				cache : false,
				mimeType : false,
				async : false,
				success: function(datos_recibidos){					
					var articulo = JSON.parse(datos_recibidos);
					$("#id_articulo_ventana_modal").html(articulo.id_articulo);					
					$("#titulo_articulo_modal").html(articulo.titulo +  '<small> Categoría: ' + articulo.categoria + '</small>');
					$("#categoria_articulo").html(articulo.categoria);
					$("#contenido_articulo").html(articulo.contenido);					
					$("#autor_articulo").html('Escrito por: <strong>' +  articulo.autor + '.</strong> | Se publicó en este sitio en la fecha: ' + articulo.fecha);	
					}
				});			
			$("#ventana_modal").modal('show');
			return false;
		}

		function mostrarEstadisticas(idArticulo){			
			$("#datos").attr('name', 'idArticulo');
			$("#datos").attr('value', idArticulo);
			var datos_token = $("#token");
			var datos_enviar = new FormData(datos_token[0]);
			$.post({
				type: "post",
				url: "<?php echo e(URL::asset('pedir_estadisticas')); ?>",
				contentType: false,
				processData: false,
				data : datos_enviar, 
				cache : false,
				mimeType : false,
				async : false,
				success: function(datos_recibidos){					
					var articulo = JSON.parse(datos_recibidos);
					$("#id_articulo_ventana_modal").html(articulo.id_articulo);					
					$("#titulo_articulo_modal").html("<h3>Estadisticas del artículo</3><small>"+ articulo.titulo+ "</small>");	
					$("#contenido_articulo").html('<dl>' 
						 + '<dt>Cantidad de visitas:</dt><dd>'+articulo.cantidad_visitas+'</dd>'						 
						 + '<dt>Cantidad de Me gusta:</dt><dd>'+articulo.cantidad_me_gusta+'</dd>'
						 + '<dt>Cantidad de no Me gusta:</dt><dd>'+articulo.cantidad_no_me_gusta+'</dd>'
						 + '</dl>'
					);
					$("#contenido_articulo").append('<canvas id="canvas"></canvas>');
					var datos = {
						labels : [
								"Visitas", 
								"Me gusta", 
								"No me gusta"
						],
						datasets : [
							{
								label : "Estadisticas Artículo",
								data : [
									articulo.cantidad_visitas,
									articulo.cantidad_me_gusta,
									articulo.cantidad_no_me_gusta
								],
								
								backgroundColor: [
								"black", 
								"blue", 
								"red"
								]
							}
						]
						
					};
					var canvas = document.getElementById('canvas').getContext('2d');					
					$("#ventana_modal").modal('show');
					window.pie =  new Chart(canvas, {
						type : 'bar',
						data : datos,
						options : {
							resposive : true,
							title : {
								display : true,
								text : "Grafico"
							}
						}
					});
					return false;
				}	
			});						

		}

		function confirmacion_eliminar_articulo_modal(){			
			$("#mensaje_alerta").html("Está seguro que desea eliminar el artículo seleccionado?");
			var id_articulo = $("#id_articulo_ventana_modal").html();			
			$("#id_articulo").html(id_articulo);//copiamos el id a un campo en la ventana de confirmación
			$("#ventana_confirmacion").modal('show');//esta ventana está definida en el archivo administrar_articulo.html 				
		}

		function confirmacion_eliminar_articulo(id_articulo){			
			$("#mensaje_alerta").html("Está seguro que desea eliminar el artículo seleccionado?");
			$("#id_articulo").html(id_articulo);
			$("#ventana_confirmacion").modal('show');//esta ventana está definida en el archivo administrar_articulo.html 				
		}

		function eliminar_articulo(){					
			var idArticulo = $("#id_articulo").html();			
			$("#datos").attr('name', 'idArticulo');
			$("#datos").attr('value', idArticulo);
			var datos_token = $("#token");
			var datos_enviar = new FormData(datos_token[0]);
			$.ajax({
				type: "post",
				url: "<?php echo e(URL::asset('eliminar_articulo')); ?>",
				contentType: false,
				processData: false,
				data : datos_enviar, 
				cache : false,
				mimeType : false,
				async : false,
				success: function(datos_recibidos){											
					window.setTimeout('location.reload()', 500);					
				}
			});
		}
	</script>
</head>
<body> 
	
	<div class="container" id="editar_articulos"><!--este formulario se creó para enviar datos genericos al controlador-->
		<form id="token" >
			<?php echo e(csrf_field()); ?>	
			<input id="datos" name="prueba" value="soy la prueba" hidden>
		</form>
		
			<div class="titulo_pagina row" id="titulo_ver_articulo">
				<blockquote class="page-header" style="padding-top:0px;">
					<h5 id="titulo_pagina">Artículos<small>Edíte sus artículos</small></h5>
				</blockquote>
			</div>	
			<?php if(count($articulos) == 0): ?>
				<h2>No existen Artículos para editar...</h2>
			<?php endif; ?>
			<div class="row" id="div_articulos"><!--*********aquí se cargan los articulos**************-->
				<?php $__currentLoopData = $articulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $articulo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
					<div class="col-md-6">
						<div class="thumbnail thumbnail_editar row" >
							<div id="<?php echo e($articulo['id_articulo']); ?>" class="scroll caption scroll_editar">
									<div id="imagen_cuadro_articulo" class="col-xs-13">
										<?php if($articulo['ruta_imagen'] != 'null'): ?>
    										<img src="<?php echo e($articulo['ruta_imagen']); ?>" class="img-responsive"">	
										<?php endif; ?>
									</div>
									<div class="col-xs-13" >
										<h3 class="titulo_cuadro_articulo"><?php echo e($articulo['titulo']); ?></h3>
									</div>
									<div class="col-xs-13" >
										<p id="parrafo_articulo" class="parrafo_articulo"><?php echo e($articulo['resumen']); ?></p>
									</div>
							</div>
							<div class="">
								<a id="" class="btn boton_enviar_articulo enlace_modal" onclick="mostrar_ventana_modal(<?php echo e($articulo['id_articulo']); ?>)">
									<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
									Ver
									
								</a>
								<a id="" class="btn boton_enviar_articulo enlace_modal" onclick="mostrarEstadisticas(<?php echo e($articulo['id_articulo']); ?>)">
									<span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
									Ver Estadisticas
									
								</a>
								<a  class="btn boton_eliminar_articulo enlace_modal" onclick="confirmacion_eliminar_articulo(<?php echo e($articulo['id_articulo']); ?>)">
									<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
									Eliminar	
								</a>
							</div>
						</div>
					</div>				    
				<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
				<script>					
					//mostrar_pagina(1);//este metodo se define en la cabecera del archivo
				</script>		

			</div>

			<ul class="pagination col-xs-13" id="paginacion_articulos">
				<script>
				$(document).ready(function(){
					paginar_articulos();	
				});				
				</script>
			</ul>


			<div id="ventana_modal" class="modal fade">'<!--*********aquí se carga el articulo para editar**************-->
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
							</button>
							<div id="id_articulo_ventana_modal" hidden></div>							
						</div>
						<div class="modal-body scroll " id="contenido_modal">
							<blockquote>
								<h3 id="titulo_articulo_modal" class=""></h3>
							</blockquote>
							<h5 id="categoria_articulo" class=""></h5>
							<p id="contenido_articulo" class=""></p>
							<h5 id="autor_articulo"></h5>
						</div>
						<div class="modal_footer">							
							<a class="btn boton_eliminar_articulo enlace_modal" onclick="confirmacion_eliminar_articulo_modal()" data-dismiss="modal">
							<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminar Artículo</a>
						</div>
					</div>				
				</div>
			</div>
			
			<!--*********esta es la ventana de confirmación para eliminar articulos**************-->
			<div id="ventana_confirmacion" class="modal fade">'
			    <div class="modal-dialog">
			      <div class="modal-content">
			        
				        <div class="modal-header">
				          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
				          &times;
				          </button>          
				        </div>

				        <div class="modal-body " id="ventana_alerta">
				          <div id="id_articulo" hidden=""></div>				          	
					        <div class="blockquote-box blockquote-danger clearfix">
					        	<div class="square pull-left">
			                    	<span class="glyphicon glyphicon-record glyphicon-lg"></span>
								</div>
								<h4>Eliminando artículo...</h4>
					            <p id="mensaje_alerta" class="alert"></p>
					        </div>			          
				        </div>

				        <div class="modal_footer text-right">              
				          <a class="btn enlace_modal" onclick="eliminar_articulo()" data-dismiss="modal"><h4>Si</h4></a>
				          <a class="btn enlace_modal" data-dismiss="modal"><h4>No</h4></a>
				        </div>

			      </div>        
			    </div>
			</div>




	</div><!--cierra div container-->

</body>
<style type="text/css">
.blockquote-box.blockquote-danger{border-color:#D43F3A}
.blockquote-box.blockquote-danger .square{background-color:#D9534F;color:#FFF}
.blockquote-box{border-right:5px solid #E6E6E6;margin-bottom:25px}

.glyphicon-lg{font-size:3em}
.blockquote-box .square{width:100px;min-height:50px;margin-right:22px;text-align:center!important;background-color:#E6E6E6;padding:20px 0}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.administrar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>