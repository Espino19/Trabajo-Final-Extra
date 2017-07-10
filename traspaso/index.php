<!DOCTYPE html>
<html>
<head>
	<title>Traspasos</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset = 'UTF8'>
	<link rel="stylesheet" type="text/css" href="../style/stilop.css">
    <link rel="stylesheet" type="text/css" href="../style/fonts.css">
<body>
 <header>   
            <nav>
              <ul>
                    <li><a href="#"><span class="primero" ><i class="icon icon-office"></i></span> Taller</a>
                        <ul>
                            <li><a href="../tienda/index.php">Tienda</a></li>
                            <li><a href="../almacen/index.php">Almacen</a></li>
                            <li><a href="../traspaso/index.php">Traspaso</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><span class="segundo" ><i class="icon icon-pencil"></i></span> Registro</a>
                        <ul>
                           <li><a href="../registros/form.php">Provedor</a></li>
                           <li><a href="../registros/index.php">Articulo</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><span class="tercero" ><i class="icon icon-book"></i></i></span> Reporte</a>
                        <ul>
                           <li><a href="../reporte/index.php">Reportes</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><span class="cuarto" ><i class="icon icon-cog"></i></span> Configuracion</a>
                        <ul>
                           <li><a href="../configuracion/index.php">Limites</a></li>
                        </ul>
                    </li>
                     </ul>
                    </li>
                </nav>
           
           <div class="titulo">
              <h1> TALLER MOTORIZADOS </h1>
          </div>
 </header>

 <section>
      <div class="contenedor">
		  <div class="cuadrante">	 
			 <div class="divuno">
			     <form action="index.php" method="POST" autocomplete='on'>
			     	 <label class="aco">BUSQUEDA</label><br>
			     	 <label>Nombre del articulo</label>
			     	 <input type="text" name="text" placeholder="Articulo">
			     	 <input class="boton" type="submit" value="buscar" name="enviar" >
			     	 <input class="boton" type="submit" value="Todos" name="todo" >
			     </form>
             </div>
             <div class="divdos">
			     <form action="index.php" method="POST" autocomplete='on'>
			         <label class="aco2">MOVIMIENTOS</label><br>
			         <label>Ingresa el codigo</label>
			     	 <input type="text" name="code" placeholder="Codigo">
			     	 <label>cantidad</label>
			     	 <input type="text" name="cantidad" placeholder="Cantidad">
			     	 <input class="boton" type="submit" value="Tienda" name="pasar" >
			     	 <input class="boton" type="submit" value="Almacen" name="regresar" >
			     </form>
			</div>       
			<div class="divtres">     
			     <form action="index.php" method="POST">
					<label class="aco"> PERDIDAS</label><br>
					<label>Codigo</label> 
					<input type="text" name="id" placeholder="Codigo">
					<label >Cantidad</label>
					<input type="text" name="ac" placeholder="Cantidad">

				    <input class="boton" type="submit" value="Almacen" name="uno">
				    <input class="boton" type="submit" value="Tienda" name="dos">
			     </form>	
			</div>
		</div>	
	    <div class="divcuatro">     
			          <?php  
			                    if (isset($_REQUEST['pasar']) && $_POST['code'] != NULL && $_POST['cantidad'] != NULL) {
			                             $con = mysqli_connect("localhost","root","","inventario");
				                         $sql =  "SELECT tienda.existencias,almacen.existencias,articulo.id_a,articulo.nombre_a,articulo.codigo,almacen.limite
												  FROM almacen,tienda,articulo									 
						   					      WHERE almacen.id_a = tienda.id_a
												  AND articulo.id_a = tienda.id_a
												  AND articulo.id_a = almacen.id_a
			                                      AND articulo.codigo = '".$_POST['code']."' ";
				                         $busca = mysqli_query($con,$sql);

				                         while ($ar = mysqli_fetch_array($busca)) {
				                         		if ($ar[1] >= $_POST['cantidad']) {
					                         	     $resti = $ar[0] + $_POST['cantidad'];
							                         $resal = $ar[1] - $_POST['cantidad'];
							                         $id = $ar[2];

							                         $sumar = "UPDATE tienda SET existencias = '".$resti."' WHERE id_a = '".$id."'";
													 $restar = "UPDATE almacen SET existencias = '".$resal."' WHERE id_a = '".$id."'";
													 mysqli_query($con, "INSERT INTO entrada_tienda VALUES('','".$id."','".$_POST['cantidad']."', NOW())");
		                                                      
													 $comprobar = mysqli_query($con, $sumar);
													 $comprobar2 = mysqli_query($con, $restar);
                                                     
													 if($resal <= $ar[5]){
				                                           $br = mysqli_query($con,"SELECT id_a FROM reporte_almacen WHERE id_a ='".$ar[2]."'");
				                                           $re = mysqli_fetch_array($br);
                                                        if ($re[0] == NULL) {
		                                                      mysqli_query($con, "INSERT INTO reporte_almacen VALUES('','".$ar[3]."','".$ar[4]."','".$ar[2]."','".$ar[5]."','".$resal."',NOW())");
		                                                      echo "<script type='text/javascript'> alert('insercion exitosa'); </script>";
                                                  		}elseif($ar[1] >= 0 && $_POST['cantidad'] <= $ar[1]){
		                                                        mysqli_query ($con, "UPDATE reporte_almacen set existencias = '".$resal."' WHERE id_a ='".$re[0]."'" );
		                                                        echo "<script type='text/javascript'> alert('ACTUALIZACION EXITOSA'); </script>";
                                               		 	}else{
                                                     		echo "<script type='text/javascript'> alert('LA CANTIDAD INGRESADA ES MENOR A LA EXISTENTE EN LA TIENDA'); </script>";
                                                      	}   
                                      				}

                                      				if($resal > $ar[5]){
				                                           $br = mysqli_query($con,"SELECT id_a FROM reporte WHERE id_a ='".$id."'");
				                                           $re = mysqli_fetch_array($br);
                                                        if ($re[0] != NULL) {
		                                                      mysqli_query($con, "DELETE FROM reporte WHERE id_a = '".$re[0]."'");
		                                                      echo "<script type='text/javascript'> alert('SE A SUPERADO EL LIMITE EN ALMACEN'); </script>";
                                                  		}else{
                                                     		  echo "<script type='text/javascript'> alert('MENSAJE DE PREVENCION EN ALMACEN'); </script>";
                                                      	}   
                                      			 }

													 if ($comprobar) {
													 		$sql =  "SELECT articulo.codigo,articulo.nombre_a,almacen.existencias,tienda.existencias 
													              FROM almacen,articulo,tienda 
																  WHERE almacen.id_a = articulo.id_a
																  AND tienda.id_a = articulo.id_a
																  AND articulo.nombre_a = '".$ar[3]."'";
								                        	 $busca = mysqli_query($con,$sql);
											
												 			echo "<table border = '5'>";
						                                      echo "<tr class='co-dif'> " ;
						                                          echo "<td class='unoo'><label>CODIGO</label></td>";
						                                          echo "<td class='doso'>NOMBRE</td>";
						                                          echo "<td class='treso'>EXIS. ALMACEN</td>";
						                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
						                                      echo "</tr>";
						                                      $i=0; 
						                                      while ($ar = mysqli_fetch_array($busca)) {
						                                          if($i % 2 == 0){
						                                              $color = 'couno';
						                                          }else{
						                                              $color = 'codos';
						                                          }  
						                                            echo "<tr class='".$color."'>";
						                                              echo "<td class='uno'><label>".$ar[0]."</label></td>";
						                                              echo "<td class='dos'><label>".$ar[1]."</label></td>";
						                                              echo "<td class='tres'>".$ar[2]."</td>";
						                                              echo "<td class='cuatro'>".$ar[3]."</td>";
						                                            echo "</tr>";  
						                                          
						                                          $i = $i + 1; 
						                                      }
						                                    echo "</table>"; 
												    }
					                        }else{
					                        	$sql =  "SELECT articulo.codigo,articulo.nombre_a,almacen.existencias,tienda.existencias 
												              FROM almacen,articulo,tienda 
															  WHERE almacen.id_a = articulo.id_a
															  AND articulo.id_a = tienda.id_a";
													  $busca = mysqli_query($con,$sql);
													
													  echo "<table border = '5'>";
					                                      echo "<tr class='co-dif'> " ;
					                                          echo "<td class='unoo'><label>CODIGO</label></td>";
					                                          echo "<td class='doso'>NOMBRE</td>";
					                                          echo "<td class='treso'>EXIS. ALMACEN</td>";
					                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
					                                      echo "</tr>"; 
					                                      $i=0;
					                                      while ($ar = mysqli_fetch_array($busca)) {
					                                          if($i % 2 == 0){
					                                              $color = 'couno';
					                                          }else{
					                                              $color = 'codos';
					                                          }  
					                                            echo "<tr class='".$color."'>";
					                                              echo "<td class='uno'><label>".$ar[0]."</label></td>";
					                                              echo "<td class='dos'><label>".$ar[1]."</label></td>";
					                                              echo "<td class='tres'>".$ar[2]."</td>";
					                                              echo "<td class='cuatro'>".$ar[3]."</td>";
					                                            echo "</tr>";  
					                                          
					                                          $i = $i + 1; 
					                                      }
					                                  echo "</table>"; 
					                        	echo "<label class='msg'>Esa cantidad pasa los limites</label>";
					                        }
				                         }
											 
			                    }elseif(isset($_REQUEST['pasar']) && $_POST['code'] == NULL && $_POST['cantidad'] != NULL){
			                    	echo "no ingresastes el codigo del producto";
			                    }elseif (isset($_REQUEST['pasar']) && $_POST['code'] != NULL && $_POST['cantidad'] == NULL) {
			                    	echo "no ingresastes la cantidad";
			                    }elseif(isset($_REQUEST['pasar']) && $_POST['code'] == NULL && $_POST['cantidad'] == NULL){
			                    	echo "TIENES QUE LLENAR LOS CAMPOS DE MOVIMIENTOS";
			                    }

			            ?>  

			            <?php  
			                    $con = mysqli_connect("localhost","root","","inventario");
			                    if (isset($_REQUEST['todo'])) {
			             	              $sql =  "SELECT articulo.codigo,articulo.nombre_a,almacen.existencias,tienda.existencias 
									              FROM almacen,articulo,tienda 
												  WHERE almacen.id_a = articulo.id_a
												  AND articulo.id_a = tienda.id_a";
										  $busca = mysqli_query($con,$sql);
										
										 echo "<table border = '5'>";
					                                      echo "<tr class='co-dif'> " ;
					                                          echo "<td class='unoo'><label>CODIGO</label></td>";
					                                          echo "<td class='doso'>NOMBRE</td>";
					                                          echo "<td class='treso'>EXIS. ALMACEN</td>";
					                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
					                                      echo "</tr>";
					                                      $i=0; 
					                                      while ($ar = mysqli_fetch_array($busca)) {
					                                          if($i % 2 == 0){
					                                              $color = 'couno';
					                                          }else{
					                                              $color = 'codos';
					                                          }  
					                                            echo "<tr class='".$color."'>";
					                                              echo "<td class='uno'><label>".$ar[0]."</label></td>";
					                                              echo "<td class='dos'><label>".$ar[1]."</label></td>";
					                                              echo "<td class='tres'>".$ar[2]."</td>";
					                                              echo "<td class='cuatro'>".$ar[3]."</td>";
					                                            echo "</tr>";  
					                                          
					                                          $i = $i + 1; 
					                                      }
					                                  echo "</table>"; 

			                    }elseif(isset($_REQUEST['enviar']) && $_POST['text'] != NULL) {
				                         $sql =  "SELECT articulo.codigo,articulo.nombre_a,almacen.existencias,tienda.existencias 
									              FROM almacen,articulo,tienda 
												  WHERE almacen.id_a = articulo.id_a
												  AND tienda.id_a = articulo.id_a
												  AND articulo.nombre_a = '".$_POST['text']."'";
				                         $busca = mysqli_query($con,$sql);
										
											 echo "<table border = '5'>";
					                                      echo "<tr class='co-dif'> " ;
					                                          echo "<td class='unoo'><label>CODIGO</label></td>";
					                                          echo "<td class='doso'>NOMBRE</td>";
					                                          echo "<td class='treso'>EXIS. ALMACEN</td>";
					                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
					                                      echo "</tr>"; 
					                                      while ($ar = mysqli_fetch_array($busca)) {
					                                          if($i % 2 == 0){
					                                              $color = 'couno';
					                                          }else{
					                                              $color = 'codos';
					                                          }  
					                                            echo "<tr class='".$color."'>";
					                                              echo "<td class='uno'><label>".$ar[0]."</label></td>";
					                                              echo "<td class='dos'><label>".$ar[1]."</label></td>";
					                                              echo "<td class='tres'>".$ar[2]."</td>";
					                                              echo "<td class='cuatro'>".$ar[3]."</td>";
					                                            echo "</tr>";  
					                                          
					                                          $i = $i + 1; 
					                                      }
					                                  echo "</table>";  
			                    }elseif (isset($_REQUEST['enviar']) && $_POST['text'] == NULL){
									echo "TIENES QUE LLENAR LOS CAMPOS DE MOVIMIENTOS";
								}
			            ?> 
			      <?php        
			           if (isset($_REQUEST['regresar']) && $_POST['code'] != NULL && $_POST['cantidad'] != NULL) {
			                             $con = mysqli_connect("localhost","root","","inventario");
				                         $sql =  "SELECT tienda.existencias,almacen.existencias,articulo.id_a,articulo.nombre_a
												  FROM almacen,tienda,articulo									 
						   					      WHERE almacen.id_a = tienda.id_a
												  AND articulo.id_a = tienda.id_a
												  AND articulo.id_a = almacen.id_a
			                                      AND articulo.codigo = '".$_POST['code']."' ";
				                         $busca = mysqli_query($con,$sql);

				                         while ($ar = mysqli_fetch_array($busca)) {
				                         	if ($ar[0] >= $_POST['cantidad']) {
				                         	     $resti = $ar[0] - $_POST['cantidad'];
						                         $resal = $ar[1] + $_POST['cantidad'];
						                         $id = $ar[2];

						                         $sumar = "UPDATE tienda SET existencias = '".$resti."' WHERE id_a = '".$id."'";
												 $restar = "UPDATE almacen SET existencias = '".$resal."' WHERE id_a = '".$id."'";

												 $comprobar = mysqli_query($con, $sumar);
												 $comprobar2 = mysqli_query($con, $restar);
                                                 
                                                 if($resal > $ar[5]){
				                                           $br = mysqli_query($con,"SELECT id_a FROM reporte_almacen WHERE id_a ='".$id."'");
				                                           $re = mysqli_fetch_array($br);
                                                        if ($re[0] != NULL) {
		                                                      mysqli_query($con, "DELETE FROM reporte_almacen WHERE id_a = '".$re[0]."'");
		                                                      echo "<script type='text/javascript'> alert('SE HA SUPERADO EL LIMITE'); </script>";
                                                  		}else{
                                                     		echo "<script type='text/javascript'> alert('MENSAJE DE PREVENCION'); </script>";
                                                      	}   
                                      			 }

												 if ($comprobar) {
													 	$sql =  "SELECT articulo.codigo,articulo.nombre_a,almacen.existencias,tienda.existencias 
													              FROM almacen,articulo,tienda 
																  WHERE almacen.id_a = articulo.id_a
																  AND tienda.id_a = articulo.id_a
																  AND articulo.nombre_a = '".$ar[3]."'";
								                         $busca = mysqli_query($con,$sql);
										
											 			echo "<table border = '5'>";
					                                      echo "<tr class='co-dif'> " ;
					                                          echo "<td class='unoo'><label>CODIGO</label></td>";
					                                          echo "<td class='doso'>NOMBRE</td>";
					                                          echo "<td class='treso'>EXIS. ALMACEN</td>";
					                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
					                                      echo "</tr>"; 
					                                      while ($ar = mysqli_fetch_array($busca)) {
					                                          if($i % 2 == 0){
					                                              $color = 'couno';
					                                          }else{
					                                              $color = 'codos';
					                                          }  
					                                            echo "<tr class='".$color."'>";
					                                              echo "<td class='uno'><label>".$ar[0]."</label></td>";
					                                              echo "<td class='dos'><label>".$ar[1]."</label></td>";
					                                              echo "<td class='tres'>".$ar[2]."</td>";
					                                              echo "<td class='cuatro'>".$ar[3]."</td>";
					                                            echo "</tr>";  
					                                          
					                                          $i = $i + 1; 
					                                      }
					                                    echo "</table>"; 
												 }
					                        }else{
					                        	$sql =  "SELECT articulo.codigo,articulo.nombre_a,almacen.existencias,tienda.existencias 
												              FROM almacen,articulo,tienda 
															  WHERE almacen.id_a = articulo.id_a
															  AND articulo.id_a = tienda.id_a";
													  $busca = mysqli_query($con,$sql);
													
													  echo "<table border = '5'>";
					                                      echo "<tr class='co-dif'> " ;
					                                          echo "<td class='unoo'><label>CODIGO</label></td>";
					                                          echo "<td class='doso'>NOMBRE</td>";
					                                          echo "<td class='treso'>EXIS. ALMACEN</td>";
					                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
					                                      echo "</tr>"; 
					                                      while ($ar = mysqli_fetch_array($busca)) {
					                                          $i=0;
					                                          if($i % 2 == 0){
					                                              $color = 'couno';
					                                          }else{
					                                              $color = 'codos';
					                                          }  
					                                            echo "<tr class='".$color."'>";
					                                              echo "<td class='uno'><label>".$ar[0]."</label></td>";
					                                              echo "<td class='dos'><label>".$ar[1]."</label></td>";
					                                              echo "<td class='tres'>".$ar[2]."</td>";
					                                              echo "<td class='cuatro'>".$ar[3]."</td>";
					                                            echo "</tr>";  
					                                          
					                                          $i = $i + 1; 
					                                      }
					                                  echo "</table>"; 
					                        	echo "Esa cantidad pasa los limites";
					                        }
				                         }
											 
			                    }elseif(isset($_REQUEST['pasar']) && $_POST['code'] == NULL && $_POST['cantidad'] != NULL){
			                    	echo "no ingresastes el codigo del producto";
			                    }elseif (isset($_REQUEST['pasar']) && $_POST['code'] != NULL && $_POST['cantidad'] == NULL) {
			                    	echo "no ingresastes la cantidad";
			                    }elseif(isset($_REQUEST['regresar']) && $_POST['code'] == NULL && $_POST['cantidad'] == NULL){
			                    	echo "TIENES QUE LLENAR LOS CAMPOS DE MOVIMIENTOS";
			                    }
			            ?>

			            <?php

							$con = mysqli_connect("localhost", "root", "","inventario");

							if(isset($_REQUEST['uno'])){
									$id = $_POST['id'];
									$ac = $_POST['ac'];


									$bus= mysqli_query($con,"SELECT almacen.id_a,almacen.existencias,articulo.existencias,articulo.nombre_a,articulo.codigo,almacen.existencias FROM almacen,articulo WHERE almacen.id_a = articulo.id_a AND articulo.codigo = '".$id."'");
									if ($id == NULL) {
									       echo "<label class = 'centro'>NO HAS INGRESADO EL CODIGO DEL ARTICULO</label>";
									}elseif ($ac == NULL) {
										   echo "<label class = 'centro'>NO HAS INGRESADO LA CANTIDAD DE LA PERDIDA</label>";
									}else{

                                        while ($arra = mysqli_fetch_array($bus)) {
                                            if($arra[0]!=NULL){
                                            	$sum=0;
												if ($ac > 0 &&  $ac <= $arra[1]) {
													$sum = $arra[1] - $ac;
										            echo "=".$sum;
										            $su = $arra[2] - $ac;
										            echo "=".$su;
													mysqli_query ($con, "UPDATE articulo set existencias = '".$su."' WHERE id_a ='".$arra[0]."'" );
													mysqli_query ($con, "UPDATE almacen set existencias = '".$sum."' WHERE id_a ='".$arra[0]."'" );

													$sql =  "SELECT articulo.codigo,articulo.nombre_a,almacen.existencias,tienda.existencias 
												              FROM almacen,articulo,tienda 
															  WHERE almacen.id_a = articulo.id_a
															  AND tienda.id_a = articulo.id_a
															  AND articulo.nombre_a = '".$arra[3]."'";
							                         $busca = mysqli_query($con,$sql);
										
											 			echo "<table border = '5'>";
					                                      echo "<tr class='co-dif'> " ;
					                                          echo "<td class='unoo'><label>CODIGO</label></td>";
					                                          echo "<td class='doso'>NOMBRE</td>";
					                                          echo "<td class='treso'>EXIS. ALMACEN</td>";
					                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
					                                      echo "</tr>"; 
					                                      while ($ar = mysqli_fetch_array($busca)) {
					                                          $i=0;
					                                          if($i % 2 == 0){
					                                              $color = 'couno';
					                                          }else{
					                                              $color = 'codos';
					                                          }  
					                                            echo "<tr class='".$color."'>";
					                                              echo "<td class='uno'><label>".$ar[0]."</label></td>";
					                                              echo "<td class='dos'><label>".$ar[1]."</label></td>";
					                                              echo "<td class='tres'>".$ar[2]."</td>";
					                                              echo "<td class='cuatro'>".$ar[3]."</td>";
					                                            echo "</tr>";  
					                                          
					                                          $i = $i + 1; 
					                                      }
					                                    echo "</table>"; 
												}else{
													echo "<label class = 'centro'>LA CANTIDAD DE BAJA ES MENOR A LA EXISTENTE</label>";
												}
												if($sum <= $arra[1]){
				                                           $br = mysqli_query($con,"SELECT id_a FROM reporte_almacen WHERE id_a ='".$arra[0]."'");
				                                           $re = mysqli_fetch_array($br);
                                                        if ($re[0] == NULL) {
		                                                      mysqli_query($con, "INSERT INTO reporte_almacen VALUES('','".$arra[3]."','".$arra[4]."','".$arra[0]."','".$arra[5]."','".$sum."')");
		                                                      echo "<script type='text/javascript'> alert('insercion exitosa'); </script>";
                                                  		}elseif($arra[1] >= 0 && $_POST['cantidad'] <= $arra[1]){
		                                                        mysqli_query ($con, "UPDATE reporte_almacen set existencias = '".$sum."' WHERE id_a ='".$re[0]."'" );
		                                                        echo "<script type='text/javascript'> alert('ACTUALIZACION EXITOSA'); </script>";
                                               		 	}else{
                                                     		echo "<script type='text/javascript'> alert('LA CANTIDAD INGRESADA ES MENOR A LA EXISTENTE EN LA TIENDA'); </script>";
                                                      	}   
                                      			}	
									        }else{
									        	echo "<label class = 'centro'>ESCRIBISTES MAL EL ARTICULO O NO EXISTE</label>";
							 				}
							 			 }
							 		}	 	
							 	}elseif(isset($_REQUEST['dos'])) {
							        $id = $_POST['id'];
									$ac = $_POST['ac'];

									$bus= mysqli_query($con,"SELECT tienda.id_a,tienda.existencias,articulo.existencias,articulo.nombre_a,articulo.codigo,tienda.limite 
										                     FROM tienda,articulo 
										                     WHERE tienda.id_a = articulo.id_a 
										                     AND articulo.codigo = '".$id."'");
									if ($id == NULL) {
									       echo "<label class = 'centro'>NO HAS INGRESADO EL CODIGO DEL ARTICULO</label>";
									}elseif ($ac == NULL) {
										   echo "<label class = 'centro'>NO HAS INGRESADO LA CANTIDAD DE LA PERDIDA</label>";
									}else{    
                                        while ($arra = mysqli_fetch_array($bus)) {
                                        	$sum=0;
                                            if($arra[0]!=NULL){
													if ($ac > 0 &&  $ac <= $arra[1]) {
														$sum = $arra[1] - $ac;
											            $su = $arra[2] - $ac;
											            echo "=".$su;
														mysqli_query ($con, "UPDATE articulo set existencias = '".$su."' WHERE id_a ='".$arra[0]."'" );
														mysqli_query ($con, "UPDATE tienda set existencias = '".$sum."' WHERE id_a ='".$arra[0]."'" );

														$sql =  "SELECT articulo.codigo,articulo.nombre_a,almacen.existencias,tienda.existencias 
													              FROM almacen,articulo,tienda 
																  WHERE almacen.id_a = articulo.id_a
																  AND tienda.id_a = articulo.id_a
																  AND articulo.nombre_a = '".$arra[3]."'";
								                         $busca = mysqli_query($con,$sql);
											
												 			echo "<table border = '5'>";
						                                      echo "<tr class='co-dif'> " ;
						                                          echo "<td class='unoo'><label>CODIGO</label></td>";
						                                          echo "<td class='doso'>NOMBRE</td>";
						                                          echo "<td class='treso'>EXIS. ALMACEN</td>";
						                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
						                                      echo "</tr>"; 
						                                      while ($ar = mysqli_fetch_array($busca)) {
						                                          if($i % 2 == 0){
						                                              $color = 'couno';
						                                          }else{
						                                              $color = 'codos';
						                                          }  
						                                            echo "<tr class='".$color."'>";
						                                              echo "<td class='uno'><label>".$ar[0]."</label></td>";
						                                              echo "<td class='dos'><label>".$ar[1]."</label></td>";
						                                              echo "<td class='tres'>".$ar[2]."</td>";
						                                              echo "<td class='cuatro'>".$ar[3]."</td>";
						                                            echo "</tr>";  
						                                          
						                                          $i = $i + 1; 
						                                      }
						                                    echo "</table>"; 
													}else{
														echo "<label class = 'centro'>LA CANTIDAD INGRESADA ES MENOR A LA EXISTENTE EN LA TIENDA</label>";
													}	
										    }else{
										        	echo "<label class = 'centro'>EL ARTICULO NO EXISTE O FUE ESCRITO DE MANERA ERRONEA/label>";
								 		    }
								 		    if($sum <= $arra[5]){
		                                           $br = mysqli_query($con,"SELECT id_a FROM reporte WHERE id_a ='".$arra[0]."'");
		                                           $re = mysqli_fetch_array($br);
                                                  if ($re[0] == NULL) {
                                                      mysqli_query($con, "INSERT INTO reporte VALUES('','".$arra[3]."','".$arra[4]."','".$arra[0]."','".$arra[5]."','".$sum."')");
                                                      echo "<script type='text/javascript'> alert('insercion exitosa'); </script>";
                                                  }elseif($arra[1] >= 0 && $ac <= $arra[1]){
		                                                  	mysqli_query ($con, "UPDATE reporte set existencias = '".$sum."' WHERE id_a ='".$re[0]."'" );
		                                                  	#echo "<script type='text/javascript'> alert('ACTUALIZACION EXITOSA'); </script>";
		                                           }else{
		                                               # echo "<script type='text/javascript'> alert('LA CANTIDAD INGRESADA ES MENOR A LA EXISTENTE EN LA TIENDA'); </script>";
		                                            }  	
                                            }
							 		    }
							 		}	
							 	}	 	
			           ?>         
			 </div>
     </div>			 
</section>
</body>
</html>