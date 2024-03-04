<?php
//VALIDAMOS LA SESIÓN
session_start();

//VALIDAMOS LOS DATOS PARA EL LOGIN
if($_POST){
  // incluimos la conexion a la base de datos
  include("./bd.php");

  //vamos a recepcionar los datos del formulario
  $usuario=(isset($_POST['usuario']))?$_POST['usuario']:"";
  $contrasena=(isset($_POST['contrasena']))?$_POST['contrasena']:"";

  //selecciona todos los registros y contabilizalos también cuando busque esa informacion 
  //en la tabla usuarios pero buscar bajo cierta condiciones
  //cuando el usuario sea = al q enviaron y la conraseña igual
  $sentencia=$conexion->prepare("SELECT *, count(*) as n_usuario 
  FROM `tbl_usuarios`
  WHERE usuario = :usuario AND password = :contrasena;");

  $sentencia->bindParam(":usuario",$usuario);
  $sentencia->bindParam(":contrasena",$contrasena);
  $sentencia->execute();

  //creamos la variable lista_servicios y le asignamos el resultado de la sentencia
  //vamos a recuperar los datos
  //utilizamos fetch y FETCH_LAZY para que nos traiga los datos q tenemos
  $lista_usuarios=$sentencia->fetch(PDO::FETCH_LAZY);

  if($lista_usuarios['n_usuario']>0){
    //si existe el usuatio lo voy a guardar en una variable de sesión
    $_SESSION['usuario']=$lista_usuarios['usuario'];
    $_SESSION['logueado']=true;
    //Vamos a redireccionar a la página de inicio
    header("Location:index.php");
  }else{
    $mensaje="Error: El usuario o contraseña son incorrectos";
  }

}

?>


<!doctype html>
<html lang="en">

<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>
  <main>
    <!-- con este container le divido en dos bs5-grid -->
      <div class="container">
        <div class="row">

          <div class="col-4">
             
          </div>

          <div class="col-4">
            <!-- bs5-card-head-foot -->
            <br>
            <br>

            <!-- vamos a validar que el mensaje exista -->
            <?php if(isset($mensaje)){?>
            <!-- vamos a mostrar un $mensaje -->
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              <strong> <?php echo $mensaje ?> </strong> 
            </div>
            
            <script>
              var alertList = document.querySelectorAll('.alert');
              alertList.forEach(function (alert) {
                new bootstrap.Alert(alert)
              })
            </script>
            
            <?php } ?>
            
            <!-- fin de mostrar el $mensaje -->
            
            <div class="card">              
              <div class="card-header">
                Login
              </div>
              <div class="card-body">

                <!-- agregamos un método form post-->
                <form action="" method="post">
                  <!-- bs5-form-input -->
                  <div class="mb-3">
                    <label for="usuario" class="form-label">Nombre</label>
                    <input type="text"
                      class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="">
                  </div>

                  <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password"
                      class="form-control" name="contrasena" id="contrasena" aria-describedby="helpId" placeholder="">
                  </div>
                  <!-- bs5-button-a -->
                  <input name="" id="" class="btn btn-primary" type="submit" value="Entrar">



                </form>


              </div>
              <div class="card-footer text-muted">
  
              </div>
            </div>
          </div>
          
        </div>
      </div>
  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>