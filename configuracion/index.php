<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Configuracion</title>
    <link rel="stylesheet" type="text/css" href="../style/estilocf.css">
    <link rel="stylesheet" type="text/css" href="../style/fonts.css">
</head>
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
                           <li><a href="index.php">Limites</a></li>
                        </ul>
                    </li>
                     </ul>
                    </li>
                </nav>
           <div class="titulo">
              <h1> TALLER MOTORIZADOS </h1>
          </div>
   </header>

   <article>
   	     <div>
   	     	<div class="izquierda">
   	     	     <h3>BUSQUEDA</h3>
			     <form action="index.php" method="POST" autocomplete='on'>
			     	 <label>Nombre del Articulo</label>
			     	 <input type="text" name="text" placeholder="Ingresa el Articulo">
			     	 <input  class="boton" type="submit" value="buscar" name="enviar" >
			     	 <input class="boton" type="submit" value="Todos los Articulos" name="todo" >
			     </form>
                 <div class="separador"></div>
                 <h3>LIMITES</h3>
			     <form action="index.php" method="POST" autocomplete='on'>
			         <label>Ingresa el codigo</label>
			     	 <input type="text" name="code" placeholder="codigo del producto">
			     	 <label>Limite Min. de articulo</label>
			     	 <input type="text" name="limi1" placeholder="Limite de la almacen">
			     	 <input type="text" name="limi2" placeholder="Limite de la tienda">
			     	 <input class="boton" type="submit" value="Establecer" name="pasar">
			     </form>  
			</div>     
            <div class="derecha">
				            <?php  
				                     $con = mysqli_connect("localhost","root","","inventario");
							               if(isset($_REQUEST['pasar'])) {     
							                    if ($_POST['code'] != NULL && $_POST['limi1'] != NULL && $_POST['limi2'] == NULL ) {
							                            
								                         $sql =  "SELECT tienda.existencias , almacen.existencias , articulo.id_a , tienda.limite ,almacen.limite
																  FROM almacen,tienda,articulo									 
										   					      WHERE almacen.id_a = tienda.id_a
																  AND articulo.id_a = tienda.id_a
																  AND articulo.id_a = almacen.id_a
							                                      AND articulo.codigo = '".$_POST['code']."' ";
								                         $busca = mysqli_query($con,$sql);

								                         while ($ar = mysqli_fetch_array($busca)) {
										                         
																 $alma = "UPDATE almacen SET limite = '".$_POST['limi1']."' WHERE id_a = '".$ar[2]."'";

																 $comprobar = mysqli_query($con, $alma);

																 if ($comprobar) {
																 	$sql =  "SELECT articulo.codigo , articulo.nombre_a , almacen.existencias , almacen.limite , tienda.existencias, tienda.limite
																              FROM almacen,articulo,tienda 
																			  WHERE almacen.id_a = articulo.id_a
																			  AND articulo.id_a = tienda.id_a";
																	  $busca = mysqli_query($con,$sql);
																	
																	  echo "<table border = '5'>";
						                                      echo "<tr class='co-dif'> " ;
								                                          echo "<td class='unoo'><label>CODIGO</label></td>";
								                                          echo "<td class='doso'>NOMBRE</td>";
								                                          echo "<td class='treso'>EXIS. ALMACEN</td>";
								                                          echo "<td class='cuatroo'>A.M. ALMACEN </td>";
								                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
								                                          echo "<td class='cuatroo'>A.M. TIENDA</td>";
								                                      echo "</tr>"; 
								                                      while ($exis = mysqli_fetch_array($busca)) {
								                                          if($i % 2 == 0){
								                                              $color = 'couno';
								                                          }else{
								                                              $color = 'codos';
								                                          }  
								                                            echo "<tr class='".$color."'>";
								                                              echo "<td class='uno'><label>".$exis[0]."</label></td>";
								                                              echo "<td class='dos'><label>".$exis[1]."</label></td>";
								                                              echo "<td class='tres'>".$exis[2]."</td>";
								                                              echo "<td class='cuatro'>".$exis[3]."</td>";
								                                              echo "<td class='cuatro'>".$exis[4]."</td>";
								                                              echo "<td class='cuatro'>".$exis[5]."</td>";
								                                            echo "</tr>";  
								                                          
								                                          $i = $i + 1; 
								                                      }
						                                       echo "</table>"; 
								                         }
													}		 
							                    }elseif ($_POST['code'] != NULL && $_POST['limi1'] == NULL && $_POST['limi2'] != NULL ) {
							                    	$sql =  "SELECT articulo.codigo , articulo.nombre_a , almacen.existencias , almacen.limite , tienda.existencias, tienda.limite , articulo.id_a
																  FROM almacen,tienda,articulo									 
										   					      WHERE almacen.id_a = tienda.id_a
																  AND articulo.id_a = tienda.id_a
																  AND articulo.id_a = almacen.id_a
							                                      AND articulo.codigo = '".$_POST['code']."' ";
								                         $busca = mysqli_query($con,$sql);

								                         while ($ar = mysqli_fetch_array($busca)) {
										                         
																 $alma = "UPDATE tienda SET limite = '".$_POST['limi2']."' WHERE id_a = '".$ar[6]."'";

																 $comprobar = mysqli_query($con, $alma);

																 if ($comprobar) {
																 	$sql =  "SELECT articulo.codigo , articulo.nombre_a , almacen.existencias , almacen.limite , tienda.existencias, tienda.limite , articulo.id_a
																              FROM almacen,articulo,tienda 
																			  WHERE almacen.id_a = articulo.id_a
																			  AND articulo.id_a = tienda.id_a";
																	  $busca = mysqli_query($con,$sql);
																	
																	  echo "<table border = '5'>";
						                                      echo "<tr class='co-dif'> " ;
								                                          echo "<td class='unoo'><label>CODIGO</label></td>";
								                                          echo "<td class='doso'>NOMBRE</td>";
								                                          echo "<td class='treso'>EXIS. ALMACEN</td>";
								                                          echo "<td class='cuatroo'>A.M. ALMACEN </td>";
								                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
								                                          echo "<td class='cuatroo'>A.M. TIENDA</td>";
								                                      echo "</tr>"; 
								                                      while ($exis = mysqli_fetch_array($busca)) {
								                                          if($i % 2 == 0){
								                                              $color = 'couno';
								                                          }else{
								                                              $color = 'codos';
								                                          }  
								                                            echo "<tr class='".$color."'>";
								                                              echo "<td class='uno'><label>".$exis[0]."</label></td>";
								                                              echo "<td class='dos'><label>".$exis[1]."</label></td>";
								                                              echo "<td class='tres'>".$exis[2]."</td>";
								                                              echo "<td class='cuatro'>".$exis[3]."</td>";
								                                              echo "<td class='cuatro'>".$exis[4]."</td>";
								                                              echo "<td class='cuatro'>".$exis[5]."</td>";
								                                            echo "</tr>";  
								                                          
								                                          $i = $i + 1; 
								                                      }
						                                       echo "</table>"; 
																 }
								                         }
							                    
							                    }elseif ($_POST['code'] != NULL && $_POST['limi1'] != NULL && $_POST['limi2'] != NULL ) {
							                    	$sql =  "SELECT articulo.codigo , articulo.nombre_a , almacen.existencias , almacen.limite , tienda.existencias, tienda.limite, articulo.id_a
																  FROM almacen,tienda,articulo									 
										   					      WHERE almacen.id_a = tienda.id_a
																  AND articulo.id_a = tienda.id_a
																  AND articulo.id_a = almacen.id_a
							                                      AND articulo.codigo = '".$_POST['code']."' ";
								                         $busca = mysqli_query($con,$sql);

								                         while ($ar = mysqli_fetch_array($busca)) {
										                         
																 $alma = "UPDATE almacen SET limite = '".$_POST['limi1']."' WHERE id_a = '".$ar[6]."'";
																 $tien = "UPDATE tienda SET limite = '".$_POST['limi2']."' WHERE id_a = '".$ar[6]."'";

																 $comprobar = mysqli_query($con, $alma);
																 $comprobar2 = mysqli_query($con, $tien);

																 if ($comprobar) {
																 	$sql =  "SELECT articulo.codigo , articulo.nombre_a , almacen.existencias , almacen.limite , tienda.existencias, tienda.limite
																              FROM almacen,articulo,tienda 
																			  WHERE almacen.id_a = articulo.id_a
																			  AND articulo.id_a = tienda.id_a";
																	  $busca = mysqli_query($con,$sql);
																	
																	  
																	  echo "<table border = '5'>";
						                                      echo "<tr class='co-dif'> " ;
								                                          echo "<td class='unoo'><label>CODIGO</label></td>";
								                                          echo "<td class='doso'>NOMBRE</td>";
								                                          echo "<td class='treso'>EXIS. ALMACEN</td>";
								                                          echo "<td class='cuatroo'>A.M. ALMACEN </td>";
								                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
								                                          echo "<td class='cuatroo'>A.M. TIENDA</td>";
								                                      echo "</tr>"; 
								                                      while ($exis = mysqli_fetch_array($busca)) {
								                                          $i=0;
								                                          if($i % 2 == 0){
								                                              $color = 'couno';
								                                          }else{
								                                              $color = 'codos';
								                                          }  
								                                            echo "<tr class='".$color."'>";
								                                              echo "<td class='uno'><label>".$exis[0]."</label></td>";
								                                              echo "<td class='dos'><label>".$exis[1]."</label></td>";
								                                              echo "<td class='tres'>".$exis[2]."</td>";
								                                              echo "<td class='cuatro'>".$exis[3]."</td>";
								                                              echo "<td class='cuatro'>".$exis[4]."</td>";
								                                              echo "<td class='cuatro'>".$exis[5]."</td>";
								                                            echo "</tr>";  
								                                          
								                                          $i = $i + 1; 
								                                      }
						                                       echo "</table>"; 
																 }
								                         }
							                    
							                	}elseif($_POST['code'] == NULL && $_POST['limi1'] != NULL && $_POST['limi2'] != NULL){
							                    	echo "no ingresastes el codigo del producto";
							                    }elseif ($_POST['code'] != NULL && $_POST['cantidad'] == NULL) {
							                    	echo "no ingresastes la cantidad";
							                    }
							                }
				            ?>  

				            <?php  
				                    $con = mysqli_connect("localhost","root","","inventario");
				                    if (isset($_REQUEST['todo'])) {
				             	              $sql =  "SELECT articulo.codigo , articulo.nombre_a , almacen.existencias , almacen.limite , tienda.existencias, tienda.limite 
										              FROM almacen,articulo,tienda 
													  WHERE almacen.id_a = articulo.id_a
													  AND articulo.id_a = tienda.id_a";
											  $busca = mysqli_query($con,$sql);
											
											   echo "<table border = '5'>";
						                                      echo "<tr class='co-dif'> " ;
						                                          echo "<td class='unoo'><label>CODIGO</label></td>";
						                                          echo "<td class='doso'>NOMBRE</td>";
						                                          echo "<td class='treso'>EXIS. ALMACEN</td>";
						                                          echo "<td class='cuatroo'>A.M. ALMACEN </td>";
						                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
						                                          echo "<td class='cuatroo'>A.M. TIENDA</td>";
						                                      echo "</tr>"; 
						                                      while ($exis = mysqli_fetch_array($busca)) {
						                                      		$i=0;
						                                          if($i % 2 == 0){
						                                              $color = 'couno';
						                                          }else{
						                                              $color = 'codos';
						                                          }  
						                                            echo "<tr class='".$color."'>";
						                                              echo "<td class='uno'><label>".$exis[0]."</label></td>";
						                                              echo "<td class='dos'><label>".$exis[1]."</label></td>";
						                                              echo "<td class='tres'>".$exis[2]."</td>";
						                                              echo "<td class='cuatro'>".$exis[3]."</td>";
						                                              echo "<td class='cuatro'>".$exis[4]."</td>";
						                                              echo "<td class='cuatro'>".$exis[5]."</td>";
						                                            echo "</tr>";  
						                                          
						                                          $i = $i + 1; 
						                                      }
						                           echo "</table>"; 
								    }elseif(isset($_REQUEST['enviar']) && $_POST['text'] != NULL) {
					                         $sql =  "SELECT articulo.codigo , articulo.nombre_a , almacen.existencias , almacen.limite , tienda.existencias, tienda.limite
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
						                                          echo "<td class='cuatroo'>A.M. ALMACEN </td>";
						                                          echo "<td class='cuatroo'>EXIS. TIENDA</td>";
						                                          echo "<td class='cuatroo'>A.M. TIENDA</td>";
						                                      echo "</tr>"; 
						                                      while ($exis = mysqli_fetch_array($busca)) {
						                                          $i=0;
						                                          if($i % 2 == 0){
						                                              $color = 'couno';
						                                          }else{
						                                              $color = 'codos';
						                                          }  
						                                            echo "<tr class='".$color."'>";
						                                              echo "<td class='uno'><label>".$exis[0]."</label></td>";
						                                              echo "<td class='dos'><label>".$exis[1]."</label></td>";
						                                              echo "<td class='tres'>".$exis[2]."</td>";
						                                              echo "<td class='cuatro'>".$exis[3]."</td>";
						                                              echo "<td class='cuatro'>".$exis[4]."</td>";
						                                              echo "<td class='cuatro'>".$exis[5]."</td>";
						                                            echo "</tr>";  
						                                          
						                                          $i = $i + 1; 
						                                      }
						                           echo "</table>"; 	  
				                    }

				            ?> 
            </div>
   	  </div>
   </article>

   <footer></footer>
</body>
</html>