
<?php 

/**
para crear la base de datos debemos tener creado un usuario con el nombre goodFirm y contraseña goodFirm
**/

$ruta_servidor = 'localhost';
$usuario = 'goodfirm_usuario';
$contrasena = ',eE_qW$Sh5KR';
$conexion = mysql_connect($ruta_servidor, $usuario, $contrasena);
if($conexion){
	print("conexión exitosa <br/>");
}else{
	die("No se ha podido conectar con el nombre de usuario $usuario");
}

mysql_query("SET FOREIGN_KEY_CHECKS=0", $conexion);

$ruta_archivo = 'database.sql';

$consultas = explode(";", file_get_contents($ruta_archivo));


foreach ($consultas as $consulta) {	
	if(strchr($consulta, "/*")){		
		//no ejecuta código si alguna consulta está comentariada		
	}
	else{
		echo "ejecuta";
		mysql_query($consulta);//se envía la consulta
		echo mysql_errno($conexion) . " " . mysql_error($conexion) .  "<br />";
	}
}

mysql_close($conexion);

 ?>