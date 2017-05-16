
<?php $__env->startSection('contenido'); ?>
<head>
	<script type="text/javascript">
		function gestionar_servicios(id_area){
		var visible = $("#visible_lista_servicio").html();
		if (visible == "true") {			
			ocultar_servicios(id_area);
			$("#visible_lista_servicio").html("false");
		}else if (visible == "false") {
				mostrar_servicios(id_area);
				$("#visible_lista_servicio").html("true");
			}		
	}

	function mostrar_servicios(id_area){
		$('#lista_servicios_'+id_area).show();
		$('#span_'+ id_area).removeClass('glyphicon-menu-down');
		$('#span_'+ id_area).addClass('glyphicon-menu-up');
	}

	function ocultar_servicios(id_area){
		$('#lista_servicios_'+id_area).hide();	
		$('#span_'+ id_area).removeClass('glyphicon-menu-up');
		$('#span_'+ id_area).addClass('glyphicon-menu-down');
	}

	function eliminar_area(){
		var idArea = $("#id_area").html();
		$("#datos").attr('name', 'idArea');
		$("#datos").attr('value', idArea);
		var datos_token = $("#token");
		var datos_enviar = new FormData(datos_token[0]);
		$.ajax({
			type: "post",
			url: "administrar/eliminar_area",
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

	
	function confirmar_eliminar_area(id_area){
		$("#id_area").html(id_area);
		$("#ventana_confirmacion_area").modal('show');
		$(".mensaje_alerta").html("¿Está seguro que desea eliminar esta área?. si lo hace, se eliminaran todos los servicios que pertenecen a ella...");
	}
	</script>
</head>
<body>
	<div class="container ">
		<div class="row">

			<div class="titulo_pagina row" id="titulo_ingresar_articulo">
				<blockquote class="page-header" style="padding-top:0px;">
					<h5 id="titulo_pagina">Edíte sus áreas <small>Áreas</small></h5>
				</blockquote>
			</div>	

			<form id="token" ><!--Se usa para enviar información que contiene el token de seguridad-->
				<?php echo e(csrf_field()); ?>	
				<input id="datos" name="prueba" value="soy la prueba" hidden>
			</form>
			<div class="panel panel-default">
			<div class="panel-heading"></div>
			
			<div class="container">
				<?php if(count($areas) == 0): ?>
				<h2>No existen Áreas para editar...</h2>
				<?php endif; ?>

				<?php for($i = 0; $i < count($areas); $i++): ?>					
					<?php if($i == 0): ?>
						<div id="item_' + id_area + '" class="row list-group-item  categoria" onclick="gestionar_servicios(<?php echo e($areas[$i]['id']); ?>)">)">
							<div class="titulo_categoria col-xs-12" >
								<blockquote>
									<h4 class="titulo_categoria">
										<?php echo e($areas[$i]['nombre']); ?>

									</h4>
									<span id="span_<?php echo e($areas[$i]['id']); ?>" class="glyphicon glyphicon-menu-up" aria-hidden="true"></span>
								</blockquote>
							</div>

							<div class="col-xs-1 boton_eliminar_categoria ">
								<a class="btn enlace_modal"  onclick="confirmar_eliminar_area(<?php echo e($areas[$i]['id']); ?>)" >Eliminar<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</div>

						</div>

						<div class="panel_lista text-center" id="lista_servicios_<?php echo e($areas[$i]['id']); ?>">
							<div id="visible_lista_servicio" class="list-group" hidden>true</div>
							<?php if(count($areas[$i]['servicios']) > 0): ?>
								<?php $__currentLoopData = $areas[$i]['servicios']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
									<div class="list-group-item  btn-default item_titulo">
										<h4 class="articulo_categoria ">
											<small>---
											 <?php echo e($servicio->nombre); ?>

											</small>
										</h4>
									</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
							<?php else: ?>
								<div class="list-group-item  btn-default item_titulo">
									<h4 class="articulo_categoria ">
										<small>---
										No existen servicios pertenecientes a esta área
										</small>
									</h4>
								</div>
							<?php endif; ?>
						</div>
					<?php else: ?>
						<div id="item_' + id_area + '" class="row list-group-item  categoria" onclick="gestionar_servicios(<?php echo e($areas[$i]['id']); ?>)">)">
							<div class="titulo_categoria col-xs-12" >
								<blockquote>
									<h4 class="titulo_categoria">
										<?php echo e($areas[$i]['nombre']); ?>

									</h4>
									<span id="span_<?php echo e($areas[$i]['id']); ?>" class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
								</blockquote>
							</div>

							<div class="col-xs-1 boton_eliminar_categoria ">
								<a class="btn enlace_modal"  onclick="confirmar_eliminar_area(<?php echo e($areas[$i]['id']); ?>)" >Eliminar<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</div>

						</div>
						<div class="panel_lista text-center" id="lista_servicios_<?php echo e($areas[$i]['id']); ?>" hidden>
							<div id="visible_lista_servicio" class="list-group" hidden>false</div>
							<?php if(count($areas[$i]['servicios']) > 0): ?>
								<?php $__currentLoopData = $areas[$i]['servicios']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
									<div class="list-group-item  btn-default item_titulo">
										<h4 class="articulo_categoria ">
											<small>---
											 <?php echo e($servicio->nombre); ?>

											</small>
										</h4>
									</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
							<?php else: ?>
								<div class="list-group-item  btn-default item_titulo">
									<h4 class="articulo_categoria ">
										<small>---
										No existen servicios pertenecientes a esta área
										</small>
									</h4>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
						
				<?php endfor; ?>
				<div class="list-group text-center" id="lista_areas">
				<!--acá se cargan las categorias como una lista-->
				</div>
				</div>
			</div>

		</div>
	
	</div>





<div id="ventana_confirmacion_area" class="modal fade">'<!--*********esta es la ventana de confirmación para eliminar areas**************-->
    <div class="modal-dialog">
      <div class="modal-content">
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          &times;
          </button>          
        </div>

        <div class="modal-body " id="ventana_alerta">
          <div id="id_area" hidden=""></div>
          <div class="blockquote-box blockquote-danger clearfix">
        	<div class="square pull-left">
            	<span class="glyphicon glyphicon-record glyphicon-lg"></span>
			</div>
			<h4>Eliminando área...</h4>
            <p id="mensaje_alerta" class="alert mensaje_alerta"></p>
      	  </div>   
          
        </div>

        <div class="modal_footer text-right">              
          <a class="btn enlace_modal" onclick="eliminar_area()" data-dismiss="modal"><h4>Si</h4></a>
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