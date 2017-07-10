<html>
<head>
	<title>Registro del Articulo</title>
  <link rel="stylesheet" type="text/css" href="../style/stylo.css">
  <link rel="stylesheet" type="text/css" href="../style/estilora.css">
  <link rel="stylesheet" type="text/css" href="../style/fonts.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                           <li><a href="index.php">Articulo</a></li>
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
      <div class="izquierda">
            <div class="divuno">
                <form action="index.php" method="post" name"form">
                    <h3>   Registro Provedor </h3>  
                    <label>  RFC del Provedor</label> <input type=" text" name="RFC">
                    <label>  Nombre del articulo</label>  <input type="text" name="nombre_a"/>
                    <label>  codigo del producto</label> <input type="text" name="id"/>
                    <label>  codigo de la tienda</label> <input type="text" name="codigo"/>
                    <label> Precio del proveedor</label><input type="text" name="precio_p"/>
                    <label>  Precio venta</label> <input type="text" name="precio_v"/>
                    <label>  Precio Mayoreo</label> <input type="text" name="precio_m"/>
                    <label>  Cantidad</label> <input type="text" name="existencias"/>
                    <label>  Descripcion</label> <textarea name="desc">  </textarea>
                    <input type="submit" value="INSERTAR" name="enviar">
                 </form>
            </div>
            <div class="separador"></div>
            <div class="divdos">
                <?php
                    $conexion = mysqli_connect("localhost","root","","inventario") or die("error de conexion");
                    if (isset($_REQUEST['enviar'])) {
                          
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

                            $consul = "SELECT RFC FROM proveedor WHERE RFC = '".$RFC."'";
                            $conn = mysqli_query($conexion , $consul);
                            $arrayy = mysqli_fetch_array($conn);


                            if($arrayy[0] != NULL ){
                                   if($array[0] == NULL){
                                         $a= mysqli_query($conexion,"INSERT into articulo values ('".$id."','".$codigo."','".$nombre_a."' , '".$precio_p."', '".$precio_v."', '".$precio_m."', '".$cantidad."','".$des."')");
                                         $o=mysqli_query($conexion,"INSERT INTO almacen VALUES('".$id."','".$cantidad."','0')");
                                         $p=mysqli_query($conexion,"INSERT into tienda values ('".$id."','0','0')");

                                         $ca=mysqli_query($conexion,"INSERT INTO entrada_almacen VALUES('','".$id."','".$RFC."','".$cantidad."',NOW())");
                                         if ($ca && $o && $a && $p && $ca) {
                                            echo "<script type='text/javascript'> alert('REGISTRO EXITOSO'); </script>";
                                                        
                                         }else{
                                            echo "<script type='text/javascript'> alert('NO SE PUDO REGISTRAR'); </script>";
                                         }
                                    }
                            }else{
                                echo "<script type='text/javascript'> alert('LE RECOMIENDO REGISTRAR AL PROVEDOR'); </script>";
                                                        
                            } 
                        }           
                ?>
            </div> 

            <div class="divtres">
              <form action="index.php" method="POST">
                  <h3> Actualizar articulo</h3>
                  <label>Codigo</label> 
                  <input type="text" name="id">
                  <label>Cantidad</label> 
                  <input type="text" name="ac">

                    <input type="submit" value="actualizar" name="1">
              </form> 
            </div>  
           
            <div>
              <?php
               
              $con = mysqli_connect("localhost", "root", "","inventario");

               if (isset($_POST['id'])) {
                    $id= $_POST['id'];
                    }
               if (isset($_POST['ac'])) {
                    $ac= $_POST['ac'];
                    }
                          

              if (isset($_REQUEST['1'])) {
                

              $bus= mysqli_query($con,"SELECT articulo.id_a , articulo.existencias , almacen.existencias 
                                       FROM articulo,almacen 
                                       WHERE articulo.id_a = almacen.id_a 
                                       AND articulo.codigo = '".$id."' ");
                $arra = mysqli_fetch_array($bus);

                  if($arra[0]!=NULL ){
                          $su = $arra[1] + $ac;
                          $sum = $arra[2] + $ac;
                          mysqli_query ($con, "UPDATE articulo set existencias = '".$su."' WHERE id_a ='".$arra[0]."'" );
                          mysqli_query ($con, "UPDATE almacen set existencias = '".$sum."' WHERE id_a ='".$arra[0]."'" );
                          echo "<script type='text/javascript'> alert('Se ha agregado la nueva Cantidad'); </script>";
                 }else{
                    echo "Revisa que el articulo esta bien escrito";
                }  
                   }
                 ?>
            </div>
            <div class="separador"></div>
            <div class="divtres">
                        <form action="index.php"  method="POST" name="form"> 
                        <H3> Actualizar articulo</H3> 
                        <label>articulo a modificar</label><input name="busc" type="text" placeholder="codigo del articulo">
                       
                        <label>Nombre</label> <input type="text" name="name">
                        <label>ID</label> <input type="text" name="aid">
                        <label>codigo</label> <input type="text" name="code">
                        <input type="submit" value="actualizar" name="envio">
                        </form>
            </div>
               
            <div>
                  <?php

                 $cnx= mysqli_connect("localhost","root","","inventario");
                 if (isset($_POST['envio'])) {
                   
                   if (isset($_POST['name'])) {
                      $name= $_POST['name'];
                     
                   }
                   if (isset($_POST['aid'])) {
                      $aid= $_POST['aid'];
                   }
                  if (isset($_POST['code'])) {
                      $code= $_POST['code'];
                   }
                   if (isset($_POST['busc'])) {
                      $busc= $_POST['busc'];
                   }
                   $bs= mysqli_query($cnx,"SELECT nombre_a,id_a,codigo FROM articulo WHERE codigo = '".$busc."'");

                   $ar= mysqli_fetch_array($bs);

                   if ($ar[1]!=NULL) {
                     mysqli_query($cnx, "UPDATE articulo set nombre_a = '".$name."' , id_a = '".$aid."', codigo = '".$code."' WHERE codigo ='".$busc."'" );
                   }
                 }
                  ?>
            </div>
      </div>
        
      <div class="arriba">
           <form method="post" action="index.php">
               <h3>Buscar Articulo  </h3>
               <input name="busc"  type="text" placeholder="Nombre del Articulo">
               <input type="submit" name="bsc" value="Buscar"/>
           </form>
      </div> 
      
      <div class="abajo">
             <?php
                  $cnx = mysqli_connect("localhost","root","","inventario");
                 if (isset($_REQUEST['bsc'])) {
                  
                        if($_POST['busc'] != NULL){
                          $busqueda=mysqli_query($cnx,"SELECT codigo,nombre_a,precio_p,existencias,descripcion
                                                       FROM articulo WHERE nombre_a = '".$_POST['busc']."'");
                        
                                        echo "<table border = '2'>";
                                            echo "<tr class='co-dif'> " ;
                                                echo "<td class='unoo'>CODIGO</td>";
                                                echo "<td class='doso'>NOMBRE</td>";
                                                echo "<td class='treso'>PRECIO DEL PROVEDOR</td>";
                                                echo "<td class='cuatroo'>EXISTENCIA</td>";
                                                echo "<td class='cincoo'>DESCRIPCION</td>";
                                            echo "</tr>"; 
                                            while ($ar = mysqli_fetch_array($busqueda)) {
                                                 $i=0;
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
                                                    echo "<td class='cinco'><label>".$ar[4]."</label></td>";
                                                  echo "</tr>";  
                                                
                                                $i = $i + 1; 
                                            }
                                        echo "</table>"; 
                        }
                  }                     
              ?>                      
      </div>
  </section>     
</body>
</html>