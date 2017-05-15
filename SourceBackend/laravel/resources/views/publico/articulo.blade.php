@extends('layouts.publico')
@section('contenido')
<head>	
	<script type="text/javascript">
		function meGusta(idArticulo){			
			$("#datos").attr('name', 'idArticulo');
			$("#datos").attr('value', idArticulo);
			var datos_token = $("#token");
			var datos_enviar = new FormData(datos_token[0]);
			$.ajax({
				type: "post",
				url: "{{ URL::asset('home/articulos/me-gusta') }}",
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
				url: "{{ URL::asset('home/articulos/no-me-gusta') }}",
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
			url: "{{ URL::asset('facebok_post') }}",
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
			{{csrf_field()}}	
			<input id="datos" name="prueba" value="soy la prueba" hidden>
			<input id="post_id" name="post_id" value="" hidden>
			<input id="usuario_id" name="usuario_id" value="" hidden>
			<input id="articulo_id" name="articulo_id" value="" hidden>
		</form>
		<div class="titulo_pagina row" id="titulo_ingresar_articulo">
			<blockquote class="page-header" style="padding-top:0px;">
				<h5 id="titulo_pagina">Artículos de interés<small>{{$categoria->nombre}}</small></h5>
			</blockquote>
		</div>

		<div class="panel panel-default">

			<div class="panel-heading">
				<h1 class="titulo_articulo">{{$articulo->titulo}}</h1><small class="conteido-articulo">Por: <strong>{{$articulo->autor}}</strong> - Publicado: {{$articulo->fecha}}</small><br>

				<div class="row col-md-offset-9">
					<a  class="btn" onclick="compartir({{$articulo->id}})">
						<span><img src="http://goodfirmcolombia.co/laravel/storage/app/public/facebook-logo.png" class="img-responsive" width="40"></span>										
					</a>
						<a onclick="meGusta({{$articulo->id}})" class="btn btn-default">
							<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>					
						</a>				
						<a onclick="noMeGusta({{$articulo->id}})" class="btn btn-default">
							<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>					
						</a>	
				</div>

			</div>			

			<div class="panel-body">											
				@if($articulo->ruta_imagen != 'null')
					<div class="col-xs-8">
						<img src="{{$articulo->ruta_imagen}}" class="img-responsive img-thumbnail imagen-articulo" >	
					</div>
				@endif
				<div >
					<p  class="conteido-articulo">{!!$articulo->contenido!!}</p>	
				</div>			
			</div>
				@if(count($archivos) > 0)
					@foreach($archivos as $archivo)
						<div class="panel-heading">
							<h2 class="titulo_articulo">Archivos anexos:</h2>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-xs-5">
									<div class="jumbotron center-block">
										<p>{{$archivo->nombre}}</p>									 	
									 	<p><a class="btn btn-primary" href="{{$archivo->ruta}}" role="button">Descargar</a></p>
									</div>
								</div>
								<div class="col-xs-8">
									<iframe style="" src="http://docs.google.com/viewer?url={{$archivo->ruta}}&embedded=true" width="600" height="780"></iframe>
								</div>
							</div>
						</div>
					@endforeach
				@endif

			<div class="panel-footer">
				<a  class="btn" onclick="compartir({{$articulo->id}})">
					<span><img src="http://goodfirmcolombia.co/laravel/storage/app/public/facebook-logo.png" class="img-responsive" width="40"></span>										
				</a>
				<a onclick="meGusta({{$articulo->id}})" class="btn btn-default">
					<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>					
				</a>				
				<a onclick="noMeGusta({{$articulo->id}})" class="btn btn-default">
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
				@foreach($comentarios as $comentario)

					<div class="panel panel-default">
						<div class="panel-heading">
							<p> <strong>{{$comentario->autor}} </strong>dice:</p>
						</div>
						<div class="panel-body">
							<p>{{$comentario->contenido}}</p>							
						</div>
					</div>
				@endforeach
			</div>

			<div class="panel-footer">
				<form   class="form-horizontal" id="nuevo_articulo" action="/nuevo_comentario" method="post" >
					{{csrf_field()}}
				 	<div hidden>
				 		<input id="name" type="text" class="form-control" name="idArticulo" value="{{$articulo->id}}" hidden>
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
@stop