<!DOCTYPE html>
<html>
<head>
	<title>Reporte</title> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../style/estilor.css">
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
                           <li><a href="index.php">Reportes</a></li>
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
    	  	  <div class="izquierda">
    	  	      <form action="index.php" method="POST">
    	  	  	  	   <input type="submit" name="ventas" value="Ventas">
    	  	  	  	   <input type="submit" name="entradas" value="Entrada Almacen">
    	  	  	  	   <input type="submit" name="entradados" value="Entrada Tienda">
    	  	  	  	   <input type="submit" name="pet" value="Por pedir en Tienda">
    	  	  	  	   <input type="submit" name="pea" value="Por pedir Almacen">
    	  	  	  </form>
    	  	  </div>

    	  	  <div class="derecha"></div>
    	  	       <?php 
                        $cnx = mysqli_connect("localhost","root","","inventario");

                        if (isset($_REQUEST['entradas'])) {
		                        $en = mysqli_query($cnx,"SELECT articulo.codigo,articulo.nombre_a,entrada_almacen.RFC,entrada_almacen.cantidad,entrada_almacen.f_e
		                        	                     FROM articulo,entrada_almacen
		                        	                     WHERE articulo.id_a = entrada_almacen.id_a"
		                        	                     );
                            echo "<h3>REPORTE DE ARTICULOS QUE ENTRARON A LA TIENDA</h3>";
		                        echo "<table border = '5'>";
                                      echo "<tr class='co-dif'> " ;
                                          echo "<td class='eaunoo'><label>CODIGO</label></td>";
                                          echo "<td class='eadoso'><label>NOMBRE</label></td>";
                                          echo "<td class='eatreso'><label>PROVEDOR</label></td>";
                                          echo "<td class='eacuatroo'><label>CANTIDAD</label></td>";
                                          echo "<td class='eacincoo'><label>FECHA</label></td>"; 
                                      echo "</tr>"; 
                                      while ($ar = mysqli_fetch_array($en)) {
                                          $i=0;
                                          if($i % 2 == 0){
                                              $color = 'couno';
                                          }else{
                                              $color = 'codos';
                                          }  
                                            echo "<tr class='".$color."'>";
                                              echo "<td class='eauno'><label>".$ar[0]."</label></td>";
                                              echo "<td class='eados'><label>".$ar[1]."</label></td>";
                                              echo "<td class='eatres'><label>".$ar[2]."</label></td>";
                                              echo "<td class='eacuatro'><label>".$ar[3]."</label></td>";
                                              echo "<td class='eacinco'><label>".$ar[4]."</label></td>";
                                            echo "</tr>";  
                                          
                                          $i = $i + 1; 
                                      }
                                  echo "</table>"; 
                        }

                         
                         if (isset($_REQUEST['entradados'])) {
		                        $en = mysqli_query($cnx,"SELECT articulo.codigo,articulo.nombre_a,entrada_tienda.cantidad,entrada_tienda.f_e_t
		                        	                     FROM articulo,entrada_tienda
		                        	                     WHERE articulo.id_a = entrada_tienda.id_a"
		                        	                     );
                            echo "<h3>REPORTE DE LOS ARTICULOS GUARDADOS EN ALMACEN</h3>";
		                        echo "<table border = '5'>";
                                      echo "<tr class='co-dif'> " ;
                                          echo "<td class='etunoo'><label>CODIGO</label></td>";
                                          echo "<td class='etdoso'>NOMBRE</td>";
                                          echo "<td class='ettreso'>CANTIDAD</td>";
                                          echo "<td class='etcuatroo'><label>FECHA</label></td>"; 
                                      echo "</tr>"; 
                                      while ($ar = mysqli_fetch_array($en)) {
                                          $i=0;
                                          if($i % 2 == 0){
                                              $color = 'couno';
                                          }else{
                                              $color = 'codos';
                                          }  
                                            echo "<tr class='".$color."'>";
                                              echo "<td class='etuno's><label>".$ar[0]."</label></td>";
                                              echo "<td class='etdos'><label>".$ar[1]."</label></td>";
                                              echo "<td class='ettres'><label>".$ar[2]."</label></td>";
                                              echo "<td classs='etcuatro'><label>".$ar[3]."</label></td>";
                                            echo "</tr>";  
                                          
                                          $i = $i + 1; 
                                      }
                                    echo "</table>"; 

                         }

                         if (isset($_REQUEST['pet'])) {
                         	   $en = mysqli_query($cnx,"SELECT nombre_a,codigo,id_a,limite,existencias,fecha FROM reporte");
                               echo "<h3>ARTICULOS QUE TE FALTAN EN LA TIENDA</h3>";
                               echo "<table border = '5'>";
                                      echo "<tr class='co-dif'> " ;
                                          echo "<td class='faunoo'><label>NOMBRE</label></td>";
                                          echo "<td class='fadoso'>CODIGO</td>";
                                          echo "<td class='fatreso'>ID ARTICULO</td>";
                                          echo "<td class='facuatro'><label>LIMITE</label></td>";
                                          echo "<td class='facincoo'><label>EXIS.</label></td>";
                                          echo "<td class='faseiso'><label>U. REGISTRO</label></td>";    
                                      echo "</tr>"; 
                                      while ($ar = mysqli_fetch_array($en)) {
                                          $i=0;
                                          if($i % 2 == 0){
                                              $color = 'couno';
                                          }else{
                                              $color = 'codos';
                                          }  
                                             echo "<tr class='".$color."'>";
                                              echo "<td class='fauno's><label>".$ar[0]."</label></td>";
                                              echo "<td class='fados'><label>".$ar[1]."</label></td>";
                                              echo "<td class='fatres'><label>".$ar[2]."</label></td>";
                                              echo "<td class='facuatro'><label>".$ar[3]."</label></td>";
                                              echo "<td class='facinco'><label>".$ar[4]."</label></td>";
                                              echo "<td class='faseis'><label>".$ar[5]."</label></td>";
                                            echo "</tr>";   
                                          
                                          $i = $i + 1; 
                                      }
                                    echo "</table>";  
                         }

                         if (isset($_REQUEST['pea'])) {
                         	   $en = mysqli_query($cnx,"SELECT nombre_a,codigo,id_a,limite,existencias,fecha_m
                         	   	                        FROM reporte_almacen");
                              echo "<h3>REPORTE DE LOS ARTICULOS QUE TE FALTAN EN ALMACEN</h3>";
                               echo "<table border = '5'>";
                                      echo "<tr class='co-dif'> " ;
                                          echo "<td class='faunoo'><label>NOMBRE</label></td>";
                                          echo "<td class='fadoso'>CODIGO</td>";
                                          echo "<td class='fatreso'>ID ARTICULO</td>";
                                          echo "<td class='facuatroo'><label>LIMITE</label></td>";
                                          echo "<td class='facincoo'><label>EXIS.</label></td>";
                                          echo "<td class='faseiso'><label>U. REGISTRO</label></td>";  
                                      echo "</tr>"; 
                                      while ($ar = mysqli_fetch_array($en)) {
                                          $i=0;
                                          if($i % 2 == 0){
                                              $color = 'couno';
                                          }else{
                                              $color = 'codos';
                                          }  
                                            echo "<tr class='".$color."'>";
                                              echo "<td class='fauno's><label>".$ar[0]."</label></td>";
                                              echo "<td class='fados'><label>".$ar[1]."</label></td>";
                                              echo "<td class='fatres'><label>".$ar[2]."</label></td>";
                                              echo "<td class='facuatro'><label>".$ar[3]."</label></td>";
                                              echo "<td class='facinco'><label>".$ar[4]."</label></td>";
                                              echo "<td class='faseis'><label>".$ar[5]."</label></td>";
                                            echo "</tr>";  
                                          
                                          $i = $i + 1; 
                                      }
                                    echo "</table>";  
                         }

                         if (isset($_REQUEST['ventas'])) {
                         	   $en = mysqli_query($cnx,"SELECT reporte_venta.codigo,articulo.nombre_a,reporte_venta.cantidad,reporte_venta.fecha_v,articulo.precio_v 
                         	   	                        FROM reporte_venta,articulo
                         	   	                        WHERE reporte_venta.codigo = articulo.codigo");
                              echo "<h3>REPORTE DE VENTAS</h3>";
                               echo "<table border = '5'>";
                                      echo "<tr class='co-dif'> " ;
                                          echo "<td class='etunoo'><label>CODIGO</label></td>";
                                          echo "<td class='etdoso'>NOMBRE</td>";
                                          echo "<td class='ettreso'>CANTIDAD</td>";
                                          echo "<td class='etcuatroo'><label>FECHA DE VENTA</label></td>";
                                      echo "</tr>"; 
                                      while ($ar = mysqli_fetch_array($en)) {
                                           $i=0;
                                          if($i % 2 == 0){
                                              $color = 'couno';
                                          }else{
                                              $color = 'codos';
                                          }  
                                            echo "<tr class='".$color."'>";
                                              echo "<td class='etuno'><label>".$ar[0]."</label></td>";
                                              echo "<td class='etdos'><label>".$ar[1]."</label></td>";
                                              echo "<td class='ettres'><label>".$ar[2]."</label></td>";
                                              echo "<td classs='etcuatro'>".$ar[3]."</td>";
                                            echo "</tr>";  
                                          
                                          $i = $i + 1; 
                                      }
                                    echo "</table>";  
                         }
                                  
    	  	        ?>
    	      </div>
    </section>
</body>
                                  

</html>                                  
