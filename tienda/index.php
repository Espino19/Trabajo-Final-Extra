
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Taller Motorizado</title>
<link rel="stylesheet" type="text/css" href="../style/stylo.css">
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
                           <li><a href="../configuracion/index.php">Limites</a></li>
                        </ul>
                    </li>
                </ul>    
           </nav>
           <div class="titulo">
              <h1> TALLER MOTORIZADOS </h1>
          </div>
           
      </header>
      
      <section class="contenido">
          <article>
              <form action="index.php" method="POST">
                  <p>Nombre del producto</p>
                     <input type="text" name="nombre" placeholder='Producto'>
                  <p>Codigo</p>
                     <input type="text" name="codigo" placeholder='####'>
                    <input class="boton" type="submit" name="buscar" value="Buscar">
                    <input class="boton" type="submit" name="res" value="Todos los Articulos">
              </form>

              <form action="index.php" method="POST">
                  <p>codigo</p>
                     <input class="prueba" type="text" name="cod" placeholder='Codigo' >
                  <p>Cantidad</p>
                     <input type="text" name="cantidad" placeholder='cantidad'>
                     <br><br>
                    <input class="boton" type="submit" name="venta" value="Venta">
              </form>
          </article>
          
          <section>
              <div>
                  <?php 
                      
                      $cnx = mysqli_connect("localhost","root","","inventario");
                      
                      if ($_REQUEST['res']) {
                         $sql = "SELECT articulo.nombre_a , articulo.precio_v , tienda.existencias , articulo.codigo , articulo.descripcion 
                                  FROM tienda,articulo 
                                  WHERE tienda.id_a = articulo.id_a";

                                  $busca = mysqli_query($cnx, $sql);

                              echo "<table border = '5'>";
                                      echo "<tr class='co-dif'> " ;
                                          echo "<td class='unoo'><label>NOMBRE</label></td>";
                                          echo "<td class='doso'>PRECIO</td>";
                                          echo "<td class='treso'>EXISTENCIA</td>";
                                          echo "<td class='cuatroo'>CODIGO</td>";
                                          echo "<td class='ciincoo'><label>DESCRIPCION</label></td>";
                                      echo "</tr>"; 
                                      while ($ar = mysqli_fetch_array($busca)) {
                                          if($i % 2 == 0){
                                              $color = 'couno';
                                          }else{
                                              $color = 'codos';
                                          }  
                                            echo "<tr class='".$color."'>";
                                              echo "<td class='uno'><label>".$ar[0]."</label></td>";
                                              echo "<td class='dos'>".$ar[1]."</td>";
                                              echo "<td class='tres'>".$ar[2]."</td>";
                                              echo "<td class='cuatro'>".$ar[3]."</td>";
                                              echo "<td class='cinco'><label>".$ar[4]."</label></td>";
                                            echo "</tr>";  
                                          
                                          $i = $i + 1; 
                                      }
                                  echo "</table>"; 
                      }elseif ($_REQUEST['buscar']) {

                          if ($_POST['nombre'] == NULL && $_POST['codigo'] == NULL ) { 
                              echo "Has dejado los campos vacios";
                           }else{

                                  if ($_POST['nombre'] != NULL && $_POST['codigo'] == NULL ) {
                                      $sql = "SELECT articulo.nombre_a , articulo.precio_v , tienda.existencias , articulo.codigo , articulo.descripcion 
                                              FROM tienda,articulo 
                                              WHERE tienda.id_a = articulo.id_a
                                              AND articulo.nombre_a = '".$_POST['nombre']."'";     
                                  }elseif ($_POST['nombre'] == NULL && $_POST['codigo'] != NULL ) {
                                      $sql = "SELECT articulo.nombre_a , articulo.precio_v , tienda.existencias , articulo.codigo , articulo.descripcion 
                                              FROM tienda,articulo 
                                              WHERE tienda.id_a = articulo.id_a
                                              AND articulo.codigo = '".$_POST['codigo']."'";
                                  }

                                  $busca = mysqli_query($cnx, $sql);

                                    echo "<table border = '5'>";
                                      echo "<tr class='co-dif'> " ;
                                          echo "<td class='unoo'><label>NOMBRE</label></td>";
                                          echo "<td class='doso'>PRECIO</td>";
                                          echo "<td class='treso'>EXISTENCIA</td>";
                                          echo "<td class='cuatroo'>CODIGO</td>";
                                          echo "<td class='ciincoo'><label>DESCRIPCION</label></td>";
                                      echo "</tr>"; 
                                      while ($ar = mysqli_fetch_array($busca)) {
                                          if($i % 2 == 0){
                                              $color = 'couno';
                                          }else{
                                              $color = 'codos';
                                          }  
                                            echo "<tr class='".$color."'>";
                                              echo "<td class='uno'><label>".$ar[0]."</label></td>";
                                              echo "<td class='dos'>".$ar[1]."</td>";
                                              echo "<td class='tres'>".$ar[2]."</td>";
                                              echo "<td class='cuatro'>".$ar[3]."</td>";
                                              echo "<td class='cinco'><label>".$ar[4]."</label></td>";
                                            echo "</tr>";  
                                          
                                          $i = $i + 1; 
                                      }
                                  echo "</table>";
                           }
                      }
      
                  ?>

                  <?php 
                          $cnx = mysqli_connect("localhost","root","","inventario");

                          if(isset($_REQUEST['venta'])){
                            if($_POST['cod'] != NULL && $_POST['cantidad'] != NULL) {
                              $bus = mysqli_query($cnx, "SELECT articulo.id_a,articulo.existencias,tienda.existencias,tienda.limite,articulo.nombre_a,articulo.codigo
                                                            FROM articulo,tienda
                                                            WHERE articulo.id_a = tienda.id_a
                                                            AND articulo.codigo = '".$_POST['cod']."'");
                             
                              $restar = $_POST['cantidad'];
                                  while($ar = mysqli_fetch_array($bus)){
                                      if($ar[2] > 0){
                                          if ($ar[0] != NULL) {
                                              $co = $ar[0];
                                              $res = $ar[1] - $restar;
                                              $res2 = $ar[2] - $restar;
                                              
                                              mysqli_query($cnx, "UPDATE articulo SET existencias = '".$res."' WHERE id_a = '".$co."'");
                                              mysqli_query($cnx, "UPDATE tienda SET existencias = '".$res2."' WHERE id_a = '".$co."'");
                                              mysqli_query($cnx, "INSERT INTO reporte_venta VALUES('' , '".$_POST['cod']."' , '".$restar."' , NOW())");

                                          }else{
                                            echo "<script type='text/javascript'> alert('Este Articulo No Existe'); </script>";
                                          }
                                      }else{
                                          echo "<h1>cantidad insuficiente</h1>";  
                                      }

                                      if($res2 <= $ar[3]){
                                           $br = mysqli_query($cnx,"SELECT id_a FROM reporte WHERE id_a ='".$ar[0]."'");
                                           $re = mysqli_fetch_array($br);
                                                  if ($re[0] == NULL) {
                                                      mysqli_query($cnx, "INSERT INTO reporte VALUES('','".$ar[4]."','".$ar[5]."','".$ar[0]."','".$ar[3]."','".$res2."',NOW() )");
                                                      echo "<script type='text/javascript'> alert('EL ARTICULO A LLEGADO A SU MINIMA EXISTENCIA'); </script>";
                                                  }elseif($ar[2] >= 0 && $restar <= $ar[2]){
                                                        mysqli_query ($cnx, "UPDATE reporte set existencias = '".$res2."' WHERE id_a ='".$ar[0]."'" );
                                                        echo "<script type='text/javascript'> alert('ACTUALIZACION EXITOSA'); </script>";
                                               }else{
                                                     echo "<script type='text/javascript'> alert('LA CANTIDAD INGRESADA ES MENOR A LA EXISTENTE EN LA TIENDA'); </script>";
                                                }   
                                      }
                                  }    
                            }
                             $sql = "SELECT articulo.nombre_a , articulo.precio_v , tienda.existencias , articulo.codigo , articulo.descripcion 
                                              FROM tienda,articulo 
                                              WHERE tienda.id_a = articulo.id_a
                                              AND articulo.codigo = '".$_POST['cod']."'";

                                  $busca = mysqli_query($cnx, $sql);

                              echo "<table border = '5'>";
                                      echo "<tr class='co-dif'> " ;
                                          echo "<td class='unoo'><label>NOMBRE</label></td>";
                                          echo "<td class='doso'>PRECIO</td>";
                                          echo "<td class='treso'>EXISTENCIA</td>";
                                          echo "<td class='cuatroo'>CODIGO</td>";
                                          echo "<td class='ciincoo'><label>DESCRIPCION</label></td>";
                                      echo "</tr>"; 
                                      while ($ar = mysqli_fetch_array($busca)) {
                                          if($i % 2 == 0){
                                              $color = 'couno';
                                          }else{
                                              $color = 'codos';
                                          }  
                                            echo "<tr class='".$color."'>";
                                              echo "<td class='uno'><label>".$ar[0]."</label></td>";
                                              echo "<td class='dos'>".$ar[1]."</td>";
                                              echo "<td class='tres'>".$ar[2]."</td>";
                                              echo "<td class='cuatro'>".$ar[3]."</td>";
                                              echo "<td class='cinco'><label>".$ar[4]."</label></td>";
                                            echo "</tr>";  
                                          
                                          $i = $i + 1; 
                                      }
                                  echo "</table>"; 
                        }  

                       ?>
              </div>
          </section>
      </section>

      <footer>
          <div class="pie">
             
          </div>
      </footer>
</body>
</html>
