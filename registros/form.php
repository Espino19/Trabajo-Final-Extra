
<html>
<head>
	<title>REGISTRO DEL PROVEDOR</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../style/estilorp.css">
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
          <form action="form.php" method="POST">
               <h1>Taller de motos</h1>  
               <label>RFC</label>
               <input type="text" name="RFC" placeholder="RFC"/>
               <label>Proveedor</label> 
               <input type="text" name="nombre_p" placeholder="Nombre de la Empresa"/>
               <label>Direccion</label>  
               <input type="text" name="dir" placeholder="Calle ###  colonia"/>
               <label>Codigo Postal</label> 
               <input type="text" name="cp" placeholder="No."/>
               <label>Telefono</label>   
               <input type="text" name="tel" placeholder="Telefono"/>
               <label>Correo</label> 
               <input type="text" name="corr" placeholder="Taller@hotmail.com"/>
               <input class="boton" type="submit" value="Insertar" name="insertar">
          </form>  
     </section>  
       <?php
           if (isset($_REQUEST['insertar'])) {
            
                $server = "localhost";
                $usuario = "root";
                $contraseña = "";
                $bd = "inventario";

                $conexion = mysqli_connect($server, $usuario, $contraseña, $bd);

                  $rfc = $_POST['RFC'];
                  $proveedor = $_POST['nombre_p'];
                  $direccion = $_POST['dir'];
                  $cp = $_POST['cp'];
                  $tel = $_POST['tel'];
                  $corr = $_POST['corr'];
                  
                  $buscame = mysqli_query($conexion, "SELECT RFC FROM proveedor WHERE RFC = '".$rfc."'");
                  $ar = mysqli_fetch_array($buscame);
                  if ($ar[0] == NULL) {
                        if ($rfc !=NULL && $proveedor != NULL && $direccion != Null && $cp != Null && $tel != Null && $corr != Null) {
                            $insertar = "INSERT into proveedor values ('$proveedor', '$direccion', '$cp', '$tel',  '$rfc','$corr')";
                            $resultado = mysqli_query ($conexion, $insertar);
                        }else{
                            echo "TE FALTO LLENAR UN CAMPO";
                        }
                  }else{
                    echo "EL PROVEDOR YA EXISTE";
                  }
            }
        ?>
</body> 
</html>
