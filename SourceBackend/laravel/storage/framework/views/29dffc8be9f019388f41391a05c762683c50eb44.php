<?php $__env->startSection('carrusel'); ?>
	<div class="container">
		<div id="carousel-example-generic" class="carousel slide cuadro_carrusel" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		  	<?php for($i = 1; $i <= count($servicios); $i++): ?>
		  		<li data-target="#carousel-example-generic" data-slide-to="<?php echo e($i); ?>"></li>
		  	<?php endfor; ?>		    
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
		   <?php for($i = 0; $i < count($servicios); $i++): ?>
		   	<?php if($i == 0): ?>
		   		<div class="item active">		      
		   			<div class="row " >
		   				<div class="col-xs-13 ">
		   					<div class="row ">
		   						<div class="panel-body carrusel">
		   							<div class="col-xs-4 col-xs-offset-9 nuestro_servicios">
		   							<a href="<?php echo e($servicios[$i]->ruta); ?>" class="enlace_modal">
		   								<h4></h4>
		   								<small class="btn" >Sobre nuestros servicios...
		   								</small>
		   							</a>
		   							</div>

		   							<div class="col-xs-11 col-xs-offset-1">
										<h3 class="titulo_carrusel">
											<?php echo e($servicios[$i]->nombre); ?>

										</h3>
									</div>

									<div class="col-xs-11 col-xs-offset-1">
										<p class="parrafo_carrusel">
											<?php echo e($servicios[$i]->descripcion); ?>

										</p>
									</div>
									<div class="col-xs-3 col-xs-offset-9">
										<a href="<?php echo e($servicios[$i]->ruta); ?>" class="enlace_modal">Ver servicio</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		   	<?php else: ?>
		   		<div class="item">		
		   			<div class="row " >
		   				<div class="col-xs-13 ">
		   					<div class="row ">
		   						<div class="panel-body carrusel">
		   							<div class="col-xs-4 col-xs-offset-9 nuestro_servicios">
		   							<a href="<?php echo e($servicios[$i]->ruta); ?>">
		   								<h4></h4>
		   								<small class="" >Sobre nuestros servicios...
		   								</small>
		   							</a>
		   							</div>

		   							<div class="col-xs-11 col-xs-offset-1">
										<h3 class="titulo_carrusel">
											<?php echo e($servicios[$i]->nombre); ?>

										</h3>
									</div>

									<div class="col-xs-11 col-xs-offset-1">
										<p class="parrafo_carrusel">
											<?php echo e($servicios[$i]->descripcion); ?>

										</p>
									</div>
									<div class="col-xs-3 col-xs-offset-9">
										<a href="<?php echo e($servicios[$i]->ruta); ?>" class="enlace_modal">Ver servicio</a>
									</div>
								</div>
							</div>
						</div>
					</div>
			    </div>
		   	<?php endif; ?>		    
		    <?php endfor; ?>
		  </div>

		  <!-- Controls -->
		  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<head>
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
				var ruta = window.location.origin + "/goodfirm/public/home/pagina/"+i; 

				var numero_pagina = '<li><a href="'+ruta+'" class="btn">' + i + '</a></li>';
				$("#paginacion_articulos").append(numero_pagina);
			}
		}
		</script>
		<script>
		$(document).ready(function(){//se encarga de procesar los parametros que entran
		    var string_parametros = window.location.search.substr(1);
		    var arreglo_parametros = string_parametros.split ("&");
		    var parametros = {};

		    for ( var i = 0; i < arreglo_parametros.length; i++) {
		        var aux = arreglo_parametros[i].split("=");
		        parametros[aux[0]] = aux[1];
		    }

		    if(parametros['mostrar_articulo']){
				mostrar_ventana_modal_ver(parametros['mostrar_articulo']);
		      console.log('hola ' + parametros['mostrar_articulo'])
		    }		    
		});

		function mostrar_articulos(articulos){
			$("#div_ver_articulos").html("")
			for (var i = 0; i < articulos.length; i++) {

				var imagen = "";
				if (articulos[i].nombre_imangen != "" && articulos[i].nombre_imangen != "sin_imagen" && articulos[i].nombre_imangen != null) {//verificamos que el articulo tenga un nombre de imagen válido
					imagen = '<img src="../includes/imagenes/articulos/' +articulos[i].nombre_imangen +'" class="img-responsive img-rounded imagen_ver">';
				}

				var html = '<div class="col-md-5 col-xs-11 col-xs-offset-1" onclick="mostrar_ventana_modal_ver('+articulos[i].id_articulo+')">'
								
								+ '<div class="thumbnail thumbnail_ver row" >'									
									+ '<div id="" class="col-xs-13">'
											+ imagen
									+'</div>'

									+ '<div id="' +articulos[i].id_articulo +'" class="scroll caption caption_ver" >'										

										+ '<div class="col-xs-13" >'
											+'<h3 class="titulo_cuadro_articulo">' + articulos[i].titulo + '</h3>'
										+'</div>'

										+ '<div class="col-xs-13" >'

											+ '<p id="parrafo_articulo" class="parrafo_articulo">' + articulos[i].resumen + '</p>'
										+'</div>'

									+'</div>'//cierre caption

									+'<div class="">'
										+ '<a id="' +articulos[i].titulo +'" class="btn boton_enviar_articulo enlace_modal" onclick="mostrar_ventana_modal_ver('+articulos[i].id_articulo+')">'
										+ 'ver'
										+ '</a>'
										+ '<a  class="btn boton_eliminar_articulo enlace_modal" onclick="compartir_ariticulo('+articulos[i].id_articulo+')">compartir en Facebook'																		
										+ '</a>'						
									+'</div>'

							+'</div>'
						+"</div>";

				$("#div_ver_articulos").append(html);								
			}				
		}			

		function compartir_ariticulo(id_articulo){
			console.log(id_articulo);
		}

		function mostrar_ventana_modal_ver(id_articulo){
			$("#articulo_ventana_modal").html(id_articulo);
			var datos_enviar = {
						pedir_articulo : 'pedir_articulo',
						id : id_articulo
						};
			$.post("../../articulo_controller.class.php", datos_enviar, function(datos_recibidos){			
				var articulo = JSON.parse(datos_recibidos);
				$("#titulo_articulo_modal").html(articulo.titulo +  '<small> Categoría: ' + articulo.categoria + '</small>');
				//$("#categoria_articulo").html(articulo.categoria);
				$("#contenido_articulo").html(articulo.contenido);
				$("#autor_articulo").html('Escrito por: <strong>' +  articulo.autor + '.</strong> | Se publicó en este sitio en la fecha: ' + articulo.fecha);		
			});
			//$("#titulo_ventana_modal").html();
			$("#ventana_modal").modal('show');
			return false;
		}

		function paginar_articulos_ver(){
			var datos_enviar = {
				pedir_articulos : 'cantidad_articulos'
			}
			$.ajax({
				type: "post",
				url: "../../articulo_controller.class.php",
				data: datos_enviar,
				async: false,
				success: function(datos_recibidos){						
					//console.log(datos_recibidos);
					var cantidad_articulos = datos_recibidos;					
					organizar_paginas_ver(cantidad_articulos);
				}
			});
		}

		function organizar_paginas_ver(cantidad_articulos){
			var cantidad_paginas = Math.floor(Number(cantidad_articulos)/4) + 1;//se divide en cuatro porque se muestran 4 articulos por página		
			for (var i = 1; i <= cantidad_paginas; i++) {
				var numero_pagina = '<li><a class="btn" onclick="ver_pagina(' + i + ')">' + i + '</a></li>';
				$("#paginacion_articulos").append(numero_pagina);
			}
		}

		function ver_pagina(numero_pagina){
			var datos_enviar = {
				pedir_articulos : 'pagina',
				numero_pagina : numero_pagina
			}
			$.ajax({
				type: "post",
				url: "../../articulo_controller.class.php",
				data: datos_enviar,
				async: false,
				success: function(datos_recibidos){				
					var articulos = JSON.parse(datos_recibidos);
					if(articulos[0].titulo == null){
						var html = '<blockquote><h4 class="articulo_categoria"><small>No tiene ningun artículo para editar<small></h4><blockquote>'
						$("#div_articulos").append(html);					
					}
					else{							
						mostrar_articulos(articulos);							
					}
					
				}
			});
		}

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
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
      FB.login(function(response) {
		   console.log(response);
		 }, {scope: 'public_profile,email'});
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      //document.getElementById('status').innerHTML = 'Please log ' +        'into this app.';
       FB.login(function(response) {
		   console.log(response);
		 }, {scope: 'public_profile,email'});
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      //document.getElementById('status').innerHTML = 'Please log ' +        'into Facebook.';
      FB.login(function(response) {
		   console.log(response);
		 }, {scope: 'public_profile,email'});
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {  	
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '297200220634770',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.5' // use graph api version 2.5
  });



  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  //inicia sesión automaticamenteFB.getLoginStatus(function(response) {
  //inicia sesión automaticamente  statusChangeCallback(response);
  //inicia sesión automaticamente});

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }

  

</script>

	<div class="container" id="ver_articulos">

	<form id="token" >
			<?php echo e(csrf_field()); ?>	
			<input id="datos" name="prueba" value="soy la prueba" hidden>
	</form>
		
			<div class="titulo_pagina row" id="titulo_ver_articulo">
				<blockquote class="page-header" style="padding-top:0px;">
					<h5 id="titulo_pagina">Artículos<small>Algunos artículos de interés</small></h5>
				</blockquote>
			</div>	
			<div id="status">
			</div>
			
	</div>
			<?php if(count($articulos) == 0): ?>
			<div class="container">
				<h2>No existen Artículos para ver...</h2>
				</div>
			<?php endif; ?>
	<div id="ver_arti" class="">
			
			<div class="row " id="div_ver_articulos"><!--*********aquí se cargan los articulos**************-->
				<?php $__currentLoopData = $articulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $articulo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
					<div class="col-md-5 col-xs-11 col-xs-offset-1" >
						<div class="thumbnail thumbnail_ver row" >						
							<div id="" class="col-xs-13">
								<?php if($articulo['ruta_imagen'] != 'null'): ?>
									<img src="<?php echo e($articulo['ruta_imagen']); ?>" class="img-responsive img-rounded imagen_ver"">	
								<?php endif; ?>
							</div>

							<div id="<?php echo e($articulo['id_articulo']); ?>" class="scroll caption caption_ver" >
								<div class="col-xs-13" >
									<h3 class="titulo_cuadro_articulo"><?php echo e($articulo['titulo']); ?></h3>
								</div>

								<div class="col-xs-13" >
									<p id="parrafo_articulo" class="parrafo_articulo"><?php echo e($articulo['resumen']); ?></p>
								</div>
							</div><!--cierre caption-->
						
							<div class="">
								<a href="<?php echo e($articulo['ruta']); ?>" class="btn boton_enviar_articulo enlace_modal">
									<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> ver
								</a>
								<a  class="btn boton_eliminar_articulo enlace_modal" onclick="checkLoginState()">
									<span class="glyphicon glyphicon-share" aria-hidden="true"></span>
									compartir en Facebook
								</a>
								<a onclick="meGusta(<?php echo e($articulo['id_articulo']); ?>)" class="btn btn-default">
									<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>					
								</a>				
								<a onclick="noMeGusta(<?php echo e($articulo['id_articulo']); ?>)" class="btn btn-default">
									<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>					
								</a>
							</div>

						</div>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
			</div>

			<div class="container">
			<nav>
				<ul class="pagination col-xs-12" id="paginacion_articulos">
					<script>				
					paginar_articulos();
					</script>
				</ul>
			</nav>
			</div>	

	</div><!--cierra div container-->

</body>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.publico', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>