<?php $__env->startSection('contenido'); ?>
<head>
<script type="text/javascript">
	function mostrar_panel_servicio(id_servicio){
		console.log(id_servicio);
		var visible = $("#visible_"+id_servicio).html();		
		if (visible == 'false') {
			$("#cuerpo_servicio_"+id_servicio).show();	
			$("#visible_"+id_servicio).html("true");
			$("#span_"+id_servicio).removeClass("glyphicon-menu-down")
			$("#span_"+id_servicio).addClass("glyphicon-menu-up")
		}else if (visible == 'true') {
			$("#cuerpo_servicio_"+id_servicio).hide();	
			$("#visible_"+id_servicio).html("false");
			$("#span_"+id_servicio).removeClass("glyphicon-menu-up")
			$("#span_"+id_servicio).addClass("glyphicon-menu-down")
		}
		

	}

	function confirmacion_eliminar_servicio(id_servicio){
		$("#id_servicio").html(id_servicio);
		$("#ventana_confirmacion_servicio").modal('show');
		$(".mensaje_alerta").html("¿Está seguro que desea eliminar este servicio?");
	}

	function eliminar_servicio(){
		var idServicio = $("#id_servicio").html();
		$("#datos").attr('name', 'idServicio');
		$("#datos").attr('value', idServicio);
		var datos_token = $("#token");
		var datos_enviar = new FormData(datos_token[0]);
		$.ajax({
			type: "post",
			url: "<?php echo e(URL::asset('administrar/eliminar_servicio')); ?>",
			contentType: false,
			processData: false,
			data : datos_enviar, 
			cache : false,
			mimeType : false,
			async : false,
			success: function(datos_recibidos){
				//console.log(datos_recibidos);
				window.setTimeout('location.reload()', 500);	
			}		
		});
	}

</script>
</head>
<body>
	<div class="container" id="editar_servicios">

		<form id="token" ><!--Se usa para enviar información que contiene el token de seguridad-->
			<?php echo e(csrf_field()); ?>	
			<input id="datos" name="prueba" value="soy la prueba" hidden>
		</form>

		<div class="titulo_pagina row" id="titulo_ingresar_articulo">
			<blockquote class="page-header" style="padding-top:0px;">
				<h5 id="titulo_pagina">Edíte sus servicios<small>Servicios</small></h5>
			</blockquote>
		</div>

		<div class="row panel-group " id="panel_servicios">
			<?php if(count($servicios) == 0): ?>
				<h2>No existen Servicios para editar...</h2>
			<?php endif; ?>

			<?php for($i = 0; $i < count($servicios); $i++): ?>

				<?php if($i == 0): ?>
					<div id="panel_servicio" class="panel panel-default " >
						
						<div class="btn btn-default col-xs-13 panel-head" onclick="mostrar_panel_servicio(<?php echo e($servicios[$i]['id']); ?>)">
							<p id="visible_<?php echo e($servicios[$i]['id']); ?>" class="tareas_servicio" hidden>true</p>
								<h3 class="titulo_servicio">
									<?php echo e($servicios[$i]['nombre']); ?>    			    	
									<small><span id="span_<?php echo e($servicios[$i]['id']); ?>" class="glyphicon glyphicon-menu-up" aria-hidden="true"></span></small>
								</h3>
						</div>

						<div id="cuerpo_servicio_<?php echo e($servicios[$i]['id']); ?>" class="panel-body">
							
							<div class="row">
								<div class="col-xs-8">
									<h3 titulo_area>
									</h3>
									<p class="descripcion_servicio text-justify">
										<?php echo e($servicios[$i]['descripcion']); ?>

									</p>
								</div>

								<div class="col-xs-5">
									<h3 class="titulo_area">
										<?php echo e($servicios[$i]['area']); ?> <br> 
										<small class="descripcion_area text-justify">
											<?php echo e($servicios[$i]['descripcionArea']); ?>

										</small>
									</h3>
								</div>
							</div>


							<div class="row">
								<div class="col-xs-12">
									<ul id="tareas_servicio_<?php echo e($servicios[$i]['id']); ?>" class="tareas_servicio">
										<?php $__currentLoopData = $servicios[$i]['tareas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
										    <li>
												<?php echo e($tarea->nombre); ?>

											</li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
									</ul>
								</div>
							</div>
							
							<div class="panel-footer">
								<a  class="btn boton_eliminar_articulo enlace_modal" onclick="confirmacion_eliminar_servicio(<?php echo e($servicios[$i]['id']); ?>)">
									Eliminar
									<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
								</a>
							</div>
						</div>
					</div>
				<?php else: ?>

					<div id="panel_servicio" class="panel panel-default " >
						
						<div class="btn btn-default col-xs-13 panel-head" onclick="mostrar_panel_servicio(<?php echo e($servicios[$i]['id']); ?>)">
							<p id="visible_<?php echo e($servicios[$i]['id']); ?>" class="tareas_servicio" hidden>false</p>
								<h3 class="titulo_servicio">
									<?php echo e($servicios[$i]['nombre']); ?>  
									<small><span id="span_<?php echo e($servicios[$i]['id']); ?>" class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></small>  			    	
								</h3>
						</div>

						<div id="cuerpo_servicio_<?php echo e($servicios[$i]['id']); ?>" class="panel-body " hidden>
							<div class="row">
								<div class="col-xs-8">
									<h3 titulo_area>
									</h3>
									<p class="descripcion_servicio text-justify">
										<?php echo e($servicios[$i]['descripcion']); ?>

									</p>
								</div>

								<div class="col-xs-5">
									<h3 class="titulo_area">
										<?php echo e($servicios[$i]['area']); ?> <br> 
										<small class="descripcion_area text-justify">
											<?php echo e($servicios[$i]['descripcionArea']); ?>

										</small>
									</h3>
								</div>
							</div>


							<div class="row">
								<div class="col-xs-12">
									<ul id="tareas_servicio_<?php echo e($servicios[$i]['id']); ?>" class="tareas_servicio">
										<?php $__currentLoopData = $servicios[$i]['tareas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
										    <li>
												<?php echo e($tarea->nombre); ?>

											</li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
									</ul>
								</div>
							</div>

							<div class="panel-footer">
								<a  class="btn boton_eliminar_articulo enlace_modal" onclick="confirmacion_eliminar_servicio(<?php echo e($servicios[$i]['id']); ?>)">
									Eliminar
									<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
								</a>
							</div>
						</div>
					</div>

				<?php endif; ?>
			<?php endfor; ?>
		</div>

		<script>
			//pedir_servicios();
		</script>

	</div>



	<div id="ventana_confirmacion_servicio" class="modal fade">'<!--*********esta es la ventana de confirmación para eliminar articulos**************-->
	    <div class="modal-dialog">
	      <div class="modal-content">
	        
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
	          &times;
	          </button>          
	        </div>

	        <div class="modal-body " id="ventana_alerta">
	          <div id="id_servicio" hidden=""></div>
		          <div class="blockquote-box blockquote-danger clearfix">
		        	<div class="square pull-left">
		            	<span class="glyphicon glyphicon-record glyphicon-lg"></span>
					</div>
					<h4>Eliminando servicio...</h4>
		            <p id="mensaje_alerta" class="alert mensaje_alerta"></p>
		      	  </div>   
	          
	          
	        </div>

	        <div class="modal_footer text-right">              
	          <a class="btn enlace_modal" onclick="eliminar_servicio()" data-dismiss="modal"><h4>Si</h4></a>
	          <a class="btn enlace_modal" data-dismiss="modal"><h4>No</h4></a>
	        </div>

	      </div>        
	    </div>
	</div>
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