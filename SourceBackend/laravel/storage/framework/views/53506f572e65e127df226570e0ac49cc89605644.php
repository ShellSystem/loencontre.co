
<?php $__env->startSection('contenido'); ?>
<body>
	<div class="container">


		<div class="panel panel-default">

			<div class="panel-heading">
				<h1 class="titulo_articulo">Politica de privacidad para Facebook</h1><small class="conteido-articulo">Un poco sobre nosotros...</small><br>
			</div>			

			<div class="panel-body">											
				<p class="parrafo_articulo">
					La política general de privacidad publicada se aplica a los contenidos proporcionados por y para el uso de la aplicación <strong>GoodFirmColombia</strong>.</p>
				<p class="parrafo_articulo">
					Como usuario registrado de Facebook , también está sujeto a la política de privacidad de Facebook. Por favor verifique en su cuenta de la configuración de privacidad de Facebook para obtener más información.
				</p>

				<h3>Recopilación de información acerca de usted</h3>

				<p class="parrafo_articulo">Recopilamos distintos tipos de información sobre los usuarios de la aplicación , por dos razones principales :</p>

				<ol>
					<li>Para mostrar el nombre del usuario y su imagen cuando se envía un comentario.</li>
					<li>Para llevar un registro de las actividades del usuario dentro de la aplicación.</li>
					<li>Para podernos contactar con usted en caso se ser neceario.</li>
				</ol>

				<h3>Compartir su información con nosotros</h3>
				<p class="parrafo_articulo">
					Al publicar un comentario, por primera vez , se le presentará una página de permisos de Facebook, que le asesorará acerca de la información de Facebook va a compartir con la aplicación y otros usuarios de Facebook . Entonces podrá decidir si desea o no compartir su información de Facebook mediante el uso de la aplicación. Si usted decide no conceder el permiso no será capaz de enviar comentarios en el App .

					Al otorgar el permiso de enviar se aceptan compartir sus datos de usuario de Facebook ( incluyendo su nombre, foto de perfil , ID de usuario y cualquier otra información que decida compartir según la configuración de su cuenta de Facebook ) .

				<h3>Aviso legal y cómo ponerse en contacto con nosotros</h3>
				<p class="parrafo_articulo">
					Si usted tiene alguna pregunta relacionada con Let It Guide o Apploading sobre el uso de los datos personales por favor envíe un correo electrónico a support@letitguide.com</p>
				</p>
					
			</div>
				
			<div class="panel-footer">
				<div class="fb-share-button" 
		data-href="http://www.your-domain.com/your-page.html" 
		data-layout="button_count">dd
	</div>
			</div>

		</div>
		<div class="row">
			<div id="informacion" class="row alert alert-warning text-center" role="alert" hidden>
			</div>
		</div>

	</div>

	</div>
</body>
<style type="text/css">


</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.publico', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>