<?php $__env->startSection('contenido'); ?>
<head>	
	<script type="text/javascript">
		function meGusta(idArticulo){			
			$("#datos").attr('name', 'idArticulo');
			$("#datos").attr('value', idArticulo);
			var datos_token = $("#token");
			var datos_enviar = new FormData(datos_token[0]);
			$.ajax({
				type: "post",
				url: "<?php echo e(URL::asset('home/articulos/me-gusta')); ?>",
				contentType: false,
				processData: false,
				data : datos_enviar, 
				cache : false,
				mimeType : false,
				async : false,
				success: function(datos_recibidos){
					//console.log(datos_recibidos);
					//window.setTimeout('location.reload()', 500);	
				}		
			});
		}

		function noMeGusta(idArticulo){
			$("#datos").attr('name', 'idArticulo');
			$("#datos").attr('value', idArticulo);
			var datos_token = $("#token");
			var datos_enviar = new FormData(datos_token[0]);
			$.ajax({
				type: "post",
				url: "<?php echo e(URL::asset('home/articulos/no-me-gusta')); ?>",
				contentType: false,
				processData: false,
				data : datos_enviar, 
				cache : false,
				mimeType : false,
				async : false,
				success: function(datos_recibidos){
					//console.log(datos_recibidos);
					//window.setTimeout('location.reload()', 500);	
				}		
			});
		}

	</script>
</head>
<body>
<script>

	function pedir_comentarios(){
		FB.api(
		    "/"+userID+'_'+id+"/comments",
		    function (response) {
		    	console.log(response)
		      
		    }
		);
	}

	function guardarPost(postId, usuarioId, articuloId){
		console.log('post '+ postId);
		console.log('usuario '+ usuarioId);
		$("#post_id").attr('value', postId);
		$("#usuario_id").attr('value', usuarioId);
		$("#articulo_id").attr('value', articuloId);
		var datos_token = $("#token");
		var datos_enviar = new FormData(datos_token[0]);
		$.ajax({
			type: "post",
			url: "<?php echo e(URL::asset('facebok_post')); ?>",
			contentType: false,
			processData: false,
			data : datos_enviar, 
			cache : false,
			mimeType : false,
			async : false,
			success: function(datos_recibidos){
				console.log(datos_recibidos);
				//window.setTimeout('location.reload()', 500);	
			}		
		});
	}

	function share(userID, articuloId){
		var ruta = $("#ruta").attr('content');
		FB.ui({
        method : 'share',
        href : ruta,
	    }, function(response) {
	        if (response && !response.error_code) {
				var post_id = response.post_id;
				console.log(userID+'_'+post_id);
				guardarPost(userID+'_'+post_id, userID, articuloId);

	    	} else {
	            //alert('Error while posting.');
	        }
	    });

	}

	
	function compartir(articuloId){
		$("#informacion").append('<p>Problemante su navegador esté boloqueando la venta emergente de <strong>Facebook</strong>, por favor permitale el acceso dando un clic en la esquina superior derecha de su pantalla</p>');
		$("#informacion").show();
		//console.log(articuloId);
		window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '1150011068423173',
	      xfbml      : true,
	      version    : 'v2.8'
	    });	    

	    FB.getLoginStatus(function(response){
	    	//console.log(response);
	    	if(response.status == 'connected'){	    		
	    		share(response.authResponse.userID, articuloId);//se comparte el contenido
	    	}
	    	else{
	    		FB.login(function(response){
	    			if(response.status == 'connected'){
			    		console.log('conectados');
			    		share(response.authResponse.userID, articuloId);//se comparte el contenido
			    	}
			    	else{
			    		console.log('no se puede conectar');	
			    	}
	    		});
	    	}
	    });
	  };

	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "//connect.facebook.net/en_US/sdk.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	    	
	}  

</script>
	<div class="container">
		<form id="token" ><!--Se usa para enviar información que contiene el token de seguridad-->
			<?php echo e(csrf_field()); ?>	
			<input id="datos" name="prueba" value="soy la prueba" hidden>
			<input id="post_id" name="post_id" value="" hidden>
			<input id="usuario_id" name="usuario_id" value="" hidden>
			<input id="articulo_id" name="articulo_id" value="" hidden>
		</form>
		<div class="titulo_pagina row" id="titulo_ingresar_articulo">
			<blockquote class="page-header" style="padding-top:0px;">
				<h5 id="titulo_pagina">Artículos de interés<small><?php echo e($categoria->nombre); ?></small></h5>
			</blockquote>
		</div>

		<div class="panel panel-default">

			<div class="panel-heading">
				<h1 class="titulo_articulo"><?php echo e($articulo->titulo); ?></h1><small class="conteido-articulo">Por: <strong><?php echo e($articulo->autor); ?></strong> - Publicado: <?php echo e($articulo->fecha); ?></small><br>

				<div class="row col-md-offset-9">
					<a  class="btn" onclick="compartir(<?php echo e($articulo->id); ?>)">
						<span><img src="http://goodfirmcolombia.co/laravel/storage/app/public/facebook-logo.png" class="img-responsive" width="40"></span>										
					</a>
						<a onclick="meGusta(<?php echo e($articulo->id); ?>)" class="btn btn-default">
							<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>					
						</a>				
						<a onclick="noMeGusta(<?php echo e($articulo->id); ?>)" class="btn btn-default">
							<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>					
						</a>	
				</div>

			</div>			

			<div class="panel-body">											
				<?php if($articulo->ruta_imagen != 'null'): ?>
					<div class="col-xs-8">
						<img src="<?php echo e($articulo->ruta_imagen); ?>" class="img-responsive img-thumbnail imagen-articulo" >	
					</div>
				<?php endif; ?>
				<div >
					<p  class="conteido-articulo"><?php echo $articulo->contenido; ?></p>	
				</div>			
			</div>
				<?php if(count($archivos) > 0): ?>
					<?php $__currentLoopData = $archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
						<div class="panel-heading">
							<h2 class="titulo_articulo">Archivos anexos:</h2>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-xs-5">
									<div class="jumbotron center-block">
										<p><?php echo e($archivo->nombre); ?></p>									 	
									 	<p><a class="btn btn-primary" href="<?php echo e($archivo->ruta); ?>" role="button">Descargar</a></p>
									</div>
								</div>
								<div class="col-xs-8">
									<iframe style="" src="http://docs.google.com/viewer?url=<?php echo e($archivo->ruta); ?>&embedded=true" width="600" height="780"></iframe>
								</div>
							</div>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
				<?php endif; ?>

			<div class="panel-footer">
				<a  class="btn" onclick="compartir(<?php echo e($articulo->id); ?>)">
					<span><img src="http://goodfirmcolombia.co/laravel/storage/app/public/facebook-logo.png" class="img-responsive" width="40"></span>										
				</a>
				<a onclick="meGusta(<?php echo e($articulo->id); ?>)" class="btn btn-default">
					<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>					
				</a>				
				<a onclick="noMeGusta(<?php echo e($articulo->id); ?>)" class="btn btn-default">
					<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>					
				</a>				
			</div>

		</div>
		<div class="row">
			<div id="informacion" class="row alert alert-warning text-center" role="alert" hidden>
			</div>
		</div>

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3>Comentarios:</h3>
			</div>
			<div class="panel-body">
				<?php $__currentLoopData = $comentarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comentario): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

					<div class="panel panel-default">
						<div class="panel-heading">
							<p> <strong><?php echo e($comentario->autor); ?> </strong>dice:</p>
						</div>
						<div class="panel-body">
							<p><?php echo e($comentario->contenido); ?></p>							
						</div>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
			</div>

			<div class="panel-footer">
				<form   class="form-horizontal" id="nuevo_articulo" action="/nuevo_comentario" method="post" >
					<?php echo e(csrf_field()); ?>

				 	<div hidden>
				 		<input id="name" type="text" class="form-control" name="idArticulo" value="<?php echo e($articulo->id); ?>" hidden>
				 	</div>
					 <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Nombre</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="nombre" required autofocus>
                            </div>
                     </div>

                     <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Email</label>
                            <div class="col-md-6">
                                <input id="name" type="email" class="form-control" name="mail" required autofocus>
                            </div>
                     </div>

                     <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Comentario</label>
                            <div class="col-md-6">
                                <textarea id="comentario" name="comentario" class="form-control" rows="3" placeholder="Por favor deje un comentario..."></textarea>
                            </div>
                     </div>

                     <div class="form-group">
                           
                           <div class="col-md-4 col-md-offset-4">
                           	<input id="name" type="submit" class="form-control" name="name">
                            </div>
                     </div>

				</form>
			</div>

		</div>
	</div>

	
</body>
<style type="text/css">
	.st_facebook_custom{
	background: url("http://goodfirmcolombia.co/laravel/storage/app/public/facebook-logo.png") no-repeat scroll left top transparent;
	padding:0px 16px 0 0;
} 
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.publico', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>