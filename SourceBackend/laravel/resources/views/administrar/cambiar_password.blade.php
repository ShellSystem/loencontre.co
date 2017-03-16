@extends('layouts.administrar')

@section('contenido')
<script type="text/javascript">
	
</script>
	<div class="container">
		
		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3>Actualice su contraseña</h3>
			</div>
			<div class="panel-body">
				<form   class="form-horizontal" id="nuevo_articulo" action="/nuevo-password" method="post" >
					{{csrf_field()}}
				 	
					 <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Nueva contraseña</label>
                            <div class="col-md-6">
                                <input id="name" type="password" class="form-control" name="pass" required autofocus>
                            </div>
                     </div>

                     <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Cofirme la contraseña</label>
                            <div class="col-md-6">
                                <input id="name" type="password" class="form-control" name="confirm" required>
                            </div>
                     </div>

                     <div class="form-group">
                           
                           <div class="col-md-4 col-md-offset-4">
                           	<input id="name" type="submit" class="form-control" name="name">
                            </div>
                     </div>

				</form>
			</div>

			<div class="panel-footer">
				<!--*******************************alerta para el articulo*************************-->
				@if(isset($alerta))
					<div class="row ">
						<div id="alerta_error_articulo" class="row alert alert-warning text-center" role="alert">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {{$alerta}}
						</div>
					</div>
				@endif
				@if(isset($exito))
					<div class="row ">
						<div id="alerta_exito_articulo" class="row alert alert-success text-center" role="alert">
							<span class="glyphicon glyphicon-ok" aria-hidden="true"></span >{{$exito}}
						</div>
					</div>
				@endif
				<!--*******************************final alerta para el articulo*************************-->
			</div>

		</div>

	</div>
@stop