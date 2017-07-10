<?php
	$server = "localhost";
	$usuario = "root";
	$contraseña = "";
	$bd = "inventario";

	$conexion = mysqli_connect($server, $usuario, $contraseña, $bd)
		or die("error de conexion");

		$RFC = $_POST['RFC'];
		$proveedor = $_POST['nombre_p'];
		$direccion = $_POST['dir'];
		$cp = $_POST['cp'];
		$tel = $_POST['tel'];
		$corr = $_POST['corr'];

		$insertar = "INSERT into proveedor values ('$proveedor', '$direccion', '$cp', '$tel', '$corr', '$RFC')";

		$resultado = mysqli_query ($conexion, $insertar)
		or die("error al insertar");
		mysqli_close($conexion);
		echo "Datos insertados correctamente";


?>