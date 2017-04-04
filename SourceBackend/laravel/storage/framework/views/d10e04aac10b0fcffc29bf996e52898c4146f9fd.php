

<?php $__env->startSection('contenido'); ?>

	<script type="text/javascript">
		function eliminarUsuario(){
			var idUsuario = $("#id_usuario").html();
			$("#datos").attr('name', 'idUsuario');
			$("#datos").attr('value', idUsuario);
			var datos_token = $("#token");
			var datos_enviar = new FormData(datos_token[0]);
			$.ajax({
				type: "post",
				url: "eliminar_usuario",
				contentType: false,
				processData: false,
				data : datos_enviar, 
				cache : false,
				mimeType : false,
				async : false,
				success: function(datos_recibidos){
					window.setTimeout('location.reload()', 500);
					//console.log(datos_recibidos);
				}		
			});
		}

		function confirmar_eliminar_usuario(id_area){
		$("#id_usuario").html(id_area);
		$("#ventana_confirmacion_usuario").modal('show');
		$(".mensaje_alerta").html("¿Está seguro que desea eliminar est Usuario?");
	}
	</script>	
	<div class="container">
		<form id="token" ><!--Se usa para enviar información que contiene el token de seguridad-->
			<?php echo e(csrf_field()); ?>	
			<input id="datos" name="prueba" value="soy la prueba" hidden>
		</form>
		
		<div class="titulo_pagina row" id="titulo_ingresar_servicio">
			<blockquote class="page-header" style="padding-top:0px;">
				<h5 id="titulo_pagina">Edíte los usuarios<small>Usuarios...</small></h5>
			</blockquote>
		</div>

		<?php for($i = 1; $i < count($usuarios); $i++): ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<p><strong>Correo electrónico: </strong><?php echo e($usuarios[$i]->email); ?></p>
				</div>
				<div class="panel-body">
					<p><strong>Username: </strong><?php echo e($usuarios[$i]->name); ?></p>
					<a class="enlace_modal btn" onclick="confirmar_eliminar_usuario(<?php echo e($usuarios[$i]->id); ?>)">Eliminar</a>
				</div>
				<div class="panel-footer">
					<p><strong>Nombre: </strong><?php echo e($usuarios[$i]->user_name); ?></p>
				</div>
			</div>
		<?php endfor; ?>

	</div>


	<div id="ventana_confirmacion_usuario" class="modal fade">'<!--*********esta es la ventana de confirmación para eliminar areas**************-->
	    <div class="modal-dialog">
		    <div class="modal-content">
		        
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
			          &times;
			          </button>          
			        </div>

			        <div class="modal-body " id="ventana_alerta">
				          <div id="id_usuario" hidden=""></div>
					          <div class="blockquote-box blockquote-danger clearfix">
						        	<div class="square pull-left">
						            	<span class="glyphicon glyphicon-record glyphicon-lg"></span>
									</div>
								<h4>Eliminando Usuario...</h4>
					            <p id="mensaje_alerta" class="alert mensaje_alerta"></p>
					      	  </div>   
				          
				        </div>

				        <div class="modal_footer text-right">              
				          <a class="btn enlace_modal" onclick="eliminarUsuario()" data-dismiss="modal"><h4>Si</h4></a>
				          <a class="btn enlace_modal" data-dismiss="modal"><h4>No</h4></a>
				        </div>

			      </div>        
		    </div>
	</div>
	<style type="text/css">
.blockquote-box.blockquote-danger{border-color:#D43F3A}
.blockquote-box.blockquote-danger .square{background-color:#D9534F;color:#FFF}
.blockquote-box{border-right:5px solid #E6E6E6;margin-bottom:25px}

.glyphicon-lg{font-size:3em}
.blockquote-box .square{width:100px;min-height:50px;margin-right:22px;text-align:center!important;background-color:#E6E6E6;padding:20px 0}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.administrar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>