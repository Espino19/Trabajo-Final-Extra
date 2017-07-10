<html>
<head>
	<title>Registro</title>
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>


<section>
	  <div class="contenido">
	  <div class="llenar">
	  	  <form action="formulario.php" method="post" name"form">
			  <h1>   Taller de motos </h1> 
			    <label> Nombre del proveedor </label>
			    <input type=" text" name="nombre">
			    <label> Nombre del articulo</label>  
			    <input type="text" name="nombre_a"/>
			    <label>  codigo del producto </label>
			    <input type="text" name="id"/>
			    <label>  codigo de la tienda </label>
			    <input type="text" name="codigo"/>
			    <label>  Precio del proveedor</label>
			    <input type="text" name="precio_p"/>
			    <label>  Precio venta</label> 
			    <input type="text" name="precio_v"/>
			    <label>  Precio Mayoreo</label> 
			    <input type="text" name="precio_m"/>
			    <label>  Cantidad</label> 
			    <input type="text" name="existencias"/>
			    <label for="mensaje">  Descripcion </label>
			    <textarea name="desc"> </textarea>  
			     <input type="submit" value="insertar">
			    
			</form>

		</div>
		<div class="llena">
		<form name="form1" method="post" action="formulario.php" id="cdr" >
		  <h3>Buscar Articulo  </h3>
		      <p>
		        <input name="busca"  type="text" id="busqueda">
		        <input type="submit" name="Submit" value="buscar" />
		        </p>
		     
		</form>
		   </div>
		</form>

		
		 


		<p>

		<div class="llen">
		<form action="formulario.php" method="POST">
				<h3> Actualizar articulo</h3>
				<p>ID <input type="text" name="id"></p>
				<p>existencia <input type="text" name="ac"></p>

			    <input type="submit" value="actualizar" name="1">
		</form>		

		</p>


	  </div>
	      <?php

		$con = mysqli_connect("localhost", "root", "","inventario");

		$id = $_POST['id'];
		$ac = $_POST['ac'];


		$bus= mysqli_query($con,"SELECT id_a,existencias FROM almacen WHERE id_a = '".$id."'");
		$bu = mysqli_query($con,"SELECT id_a, existencias FROM articulo WHERE id_a = '".$id."'");
		 	$arra = mysqli_fetch_array($bus);
		 	$arr = mysqli_fetch_array($bu);

				if($arra[0]!=NULL ){
		            $sum = $arra[1] + $ac;
		            echo "=".$sum;
		            $su = $arr[1] + $ac;
		            echo "=".$sum;
		mysqli_query ($con, "UPDATE articulo set existencias = '".$sum."' WHERE id_a ='".$id."'" );
		mysqli_query ($con, "UPDATE almacen set existencias = '".$su."' WHERE id_a ='".$id."'" );
		                      }
		 	else{

		 		echo "Revisa bien el articulo cabron, no lo encuentra por que te equivocaste pendejo, pendejo chabelo";
		 	}  

?>
		<?php

		while($f = mysql_fetch_array($busqueda)){

		echo '<tr>';
		echo '<td width="19">'.$f['id_a'].'</td>';
		echo '<td width="61">'.$f['codigo'].'</td>';
		echo '<td width="157">'.$f['nombre_a'].'</td>';
		echo '<td width="221">'.$f['precio_p'].'</td>';
		echo '<td width="176">'.$f['precio_v'].'</td>';
		echo '<td width="73">'.$f['precio_m'].'</td>';
		echo '<td width="118">'.$f['existencias'].'</td>';
		echo '<td width="103">'.$f['descripcion'].'</td>';

		echo '</tr>';

		}

		?>

		 <?php

		mysql_connect("localhost","root","");
		mysql_select_db("inventario");
		if($_POST['busca']!= ""){
		$busqueda=mysql_query("SELECT * FROM articulo WHERE id_a = '$_POST[busca]'");
		?>
		<table width="1166" border="1" id="tab">
		   <tr>
		     <td width="19">id_a </td>
		     <td width="61">codigo</td>
		     <td width="157">articulo</td>
		     <td width="221">Precio_p</td>
		     <td width="176">precio_v</td>
		     <td width="73">precio_m</td>
		     <td width="118">existencias</td>
		     <td width="103">descripcion</td>
		 
		   </tr>
		   <?php
			$server = "localhost";
			$usuario = "root";
			$contraseña = "";
			$bd = "inventario";

			$conexion = mysqli_connect($server, $usuario, $contraseña, $bd)
				or die("error de conexion");
		 		$nombre_p = $_POST['nombre'];
		 		$id = $_POST['id'];
				$nombre_a = $_POST['nombre_a'];
				$precio_p = $_POST['precio_p'];
				$precio_v = $_POST['precio_v'];
				$precio_m = $_POST['precio_m'];
				$cantidad = $_POST['existencias'];
				$codigo = $_POST['codigo'];
		        $des = $_POST['desc'];
				$RFC = $_POST['RFC'];

					$consultar = "SELECT codigo FROM articulo WHERE codigo = '".$codigo."'";
			        $con = mysqli_query($conexion , $consultar);
			        $array = mysqli_fetch_array($con);

			        $consul = "SELECT nombre_p FROM proveedor WHERE nombre_p = '".$nombre_p."'";
			        $conn = mysqli_query($conexion , $consul);
			        $arrayy = mysqli_fetch_array($conn);


		            if($arrayy[0] != NULL ){
					       if($array[0] == NULL){
								 mysqli_query($conexion,"INSERT into articulo values ('".$id."','".$codigo."','".$nombre_a."' , '".$precio_p."', '".$precio_v."', '".$precio_m."', '".$cantidad."','".$desc."')");
					             mysqli_query($conexion,"INSERT into almacen values ('".$id."','".$cantidad."')");

					        }else{
						          $cons = "SELECT existencias FROM articulo WHERE codigo = '".$codigo."'";
						          $conex = "SELECT existencias FROM almacen WHERE codigo = '".$codigo."'";

						          $con = mysqli_query($conexion , $cons , $conex);
						          $arra = mysqli_fetch_array($con);
						          
						          echo "arra".$arra[0];
						          echo "cantidad ".$cantidad;
						          $res = $arra[0] + $cantidad;

						          mysqli_query($conexion,"UPDATE articulo SET existencias = '".$res."' WHERE codigo = '".$codigo."'");
						          mysqli_query($conexion,"UPDATE almacen SET existencias = '".$res."' WHERE codigo = '".$codigo."' ");  
					          
					        }
					}else{
						echo "Este provedor no existe o lo escribistes mal";
					}        
		?>
	  </div>
</section>
<footer></footer>
		
</body>


</html>

