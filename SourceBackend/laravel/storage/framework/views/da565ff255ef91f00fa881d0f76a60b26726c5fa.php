<?php $__env->startSection('contenido'); ?>
<head>
	<meta property="og:url"      content="<?php echo e($articulo->ruta); ?>" />
	<meta property="og:type"               content="article" />
	<meta property="og:title"              content="<?php echo e($articulo->titulo); ?>" />
	<meta property="og:description"        content="<?php echo e($articulo->titulo); ?>" />
	<meta property="og:image"              content="<?php echo e($articulo->ruta_imagen); ?>" />
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

	function share(){
		var ruta = $("#ruta").attr('content');
	    //console.log(ruta);
		 FB.ui({
        method : 'share',
        href : 'https://www.youtube.com/watch?v=CBTOGVb_cQg&list=RDMMzakKvbIQ28o&index=10',
	    }, function(response) {
	        if (response && !response.error_code) {
	            alert('Posting completed.');
	        } else {
	            alert('Error while posting.');
	        }
	    });



	}
	function compartir(){
		window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '1150011068423173',
	      xfbml      : true,
	      version    : 'v2.8'
	    });	    

	    FB.getLoginStatus(function(response){
	    	if(response.status == 'connected'){
	    		console.log('conectados');
	    		share();
	    	}
	    	else{
	    		FB.login(function(response){
	    			if(response.status == 'connected'){
			    		console.log('conectados');
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
					<a  class="btn boton_eliminar_articulo enlace_modal" onclick="compartir()">
					<span class="glyphicon glyphicon-share" aria-hidden="true"></span>
					compartir en Facebook
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
				<div>

					<p class="conteido-articulo"><?php echo $articulo->contenido; ?></p>	
				</div>			
			</div>

			<div class="panel-footer">
				<a  class="btn boton_eliminar_articulo enlace_modal enlace" onclick="compartir()">
					<span class="glyphicon glyphicon-share" aria-hidden="true"></span>
					compartir en Facebook					
				</a>
				<a onclick="meGusta(<?php echo e($articulo->id); ?>)" class="btn btn-default">
					<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>					
				</a>				
				<a onclick="noMeGusta(<?php echo e($articulo->id); ?>)" class="btn btn-default">
					<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>					
				</a>				
			</div>

		</div>

	</div>
</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.publico', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>