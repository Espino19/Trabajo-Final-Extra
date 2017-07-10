
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
      </header>
      <section class="contenido">
          <article>
              <form action="index.php" method="POST">
                  <p>Nombre del producto</p>
                     <input type="text" name="nombre" placeholder='Producto' >
                  <p>Codigo</p>
                     <input type="text" name="codigo" placeholder='####'>
                     <br><br>
                    <input class="boton" type="submit" name="buscar" value="Buscar">
                    <input class="boton" type="submit" name="res" value="Todos los Articulos">
              </form>
          </article>
          
          <section >
              <div>
                      <?php 
                          
                          $cnx = mysqli_connect("localhost","root","","inventario");
                          
                          if ($_REQUEST['res']) {
                             $sql = "SELECT articulo.nombre_a , articulo.precio_v , almacen.existencias , articulo.codigo , articulo.descripcion 
                                      FROM almacen,articulo 
                                      WHERE almacen.id_a = articulo.id_a";

                                      $busca = mysqli_query($cnx, $sql);
                                  $i = 0;
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

                              if ($_POST['nombre'] == NULL && $_POST['codigo'] == NULL) { 
                                  echo "Has dejado los campos vacios";
                               }else{

                                      if ($_POST['nombre'] != NULL && $_POST['codigo'] == NULL ) {
                                          $sql = "SELECT articulo.nombre_a , articulo.precio_v , almacen.existencias , articulo.codigo , articulo.descripcion 
                                                  FROM almacen,articulo 
                                                  WHERE almacen.id_a = articulo.id_a
                                                  AND articulo.nombre_a = '".$_POST['nombre']."'";     
                                      }elseif ($_POST['nombre'] == NULL && $_POST['codigo'] != NULL ) {
                                          $sql = "SELECT articulo.nombre_a , articulo.precio_v , almacen.existencias , articulo.codigo , articulo.descripcion 
                                                  FROM almacen,articulo 
                                                  WHERE almacen.id_a = articulo.id_a
                                                  AND articulo.codigo = '".$_POST['codigo']."'";
                                      }elseif ($_POST['nombre'] != NULL && $_POST['codigo'] != NULL ) {
                                                  $sql = "SELECT articulo.nombre_a , articulo.precio_v , almacen.existencias , articulo.codigo , articulo.descripcion 
                                                  FROM almacen,articulo 
                                                  WHERE almacen.id_a = articulo.id_a
                                                  AND articulo.nombre_a = '".$_POST['nombre']."'
                                                  AND articulo.codigo = '".$_POST['codigo']."'";   
                                      }

                                      $busca = mysqli_query($cnx, $sql);

                                      echo "<table border = '2'>";
                                      echo "<tr class='co-dif'> " ;
                                          echo "<td class='unoo'>NOMBRE</td>";
                                          echo "<td class='doso'>PRECIO</td>";
                                          echo "<td class='treso'>EXISTENCIA</td>";
                                          echo "<td class='cuatroo'>CODIGO</td>";
                                          echo "<td class='ciincoo'>DESCRIPCION</td>";
                                      echo "</tr>"; 
                                      while ($ar = mysqli_fetch_array($busca)) {
                                          if($i % 2 == 0){
                                              $color = 'couno';
                                          }else{
                                              $color = 'codos';
                                          }  
                                            echo "<tr class='".$color."'>";
                                              echo "<td class='uno'>".$ar[0]."</td>";
                                              echo "<td class='dos'>".$ar[1]."</td>";
                                              echo "<td class='tres'>".$ar[2]."</td>";
                                              echo "<td class='cuatro'>".$ar[3]."</td>";
                                              echo "<td class='cinco'>".$ar[4]."</td>";
                                            echo "</tr>";  
                                          
                                          $i = $i + 1; 
                                      }
                                      echo "</table>"; 
                               }
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
