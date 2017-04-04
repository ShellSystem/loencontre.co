@extends('layouts.publico')

@section('contenido')
<script type="text/javascript">
	function nuevo_articulo(){		
		var datos_articulo = $("#nuevo_articulo");
		var datos_enviar = new FormData(datos_articulo[0]);
		//console.log(datos_articulo);
		$.ajax({
			url :"{{ URL::asset('servicios1') }}", 
			type : "post",
			contentType: false,
			processData: false,
			data : datos_enviar, 
			cache : false,
			mimeType : false,
			async : false,
			success: function(datos_recibidos){				
				//console.log("dats: " +datos_recibidos);				
			}		

		});	
		//console.log("pasó");
	}
</script>
<body>
	

	<script type="text/javascript">

		function compartir(){

			window.fbAsyncInit = function() {
		    FB.init({
		      appId      : '1150011068423173',
		      xfbml      : true,
		      version    : 'v2.8'
		    });	    
console.log("i");
		    FB.getLoginStatus(function(response){

		    	//console.log(response);
		    	if(response.status == 'connected'){	    		
		    		FB.api(
					    "/10154725983869231_10154741752564231/comments",					    
					    {'summary': true},
					    function (response) {
					    	console.log(response);
					      
					    }
					);

					FB.api(
					    "/10154725983869231_10154741752564231/likes",					    
					    {'summary': true},
					    function (response) {
					    	console.log(response);
					      
					    }
					);

					FB.api(
					    "/10209944644640123/picture",
					    function (response) {
					      console.log(response);
					    }
					);
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
</body>
	<div class="container">
		<form  id="nuevo_articulo" action="#" onsubmit="enviar_formulario()" method="post" enctype="multipart/form-data">
			{{csrf_field()}}
			<input type="file" class="" name="archivo" id="imagen_articulo">
			
			<input type="text" name="texto">
				<input type="submit" name="">

		</form>
		<iframe style="" src="http://docs.google.com/viewer?url=goodfirmcolombia.co/laravel/storage/app/archivos/prueba.xlsx&embedded=true" width="600" height="780"></iframe>


		<iframe style="" src="http://docs.google.com/viewer?url=goodfirmcolombia.co/laravel/storage/app/archivos_articulos/hoja.docx&embedded=true" width="600" height="780"></iframe>

		<div onclick="compartir()" class="btn">
			hola
		</div>
	</div>
@stop