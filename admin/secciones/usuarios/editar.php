<?php 

//agregamos la base de datos
include("../../bd.php");

//RECUPERAMOS    REGISTROS
if(isset($_GET['txtID'])){ //AQUI ESTAMOS DETECTANDO QUE NOS ENVIARON UN ID MEDIANTE LA URL txtId
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";  //tenemos un txtId que lo que hace es recueprar el dato en la variable txtID
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_usuarios` WHERE id = :id;");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    //Vamos almacenar los datros en una variable llamada registros
    //utilizamos el FETCH_LAZY para que nos traiga los datos de la base de datos, solo un registro
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    //leemos todos los datos que privienen de ese selección
    $usuario = $registro['usuario'];
    $password = $registro['password'];
    $correo = $registro['correo'];

    }


//QUE SE EDITEN LOS REGISTROS
if($_POST){
    print_r($_POST);

    $txtID=(isset($_POST['txtID']))?$_POST['txtID'] : "";
    $usuario=(isset($_POST['usuario']))?$_POST['usuario'] : "";
    $password=(isset($_POST['password']))?$_POST['password'] : "";
    $correo=(isset($_POST['correo']))?$_POST['correo'] : "";

    $sentencia=$conexion->prepare("UPDATE tbl_usuarios
    SET usuario=:usuario, password=:password, correo=:correo
    WHERE id = :id;"); //el id es el que se va a editar

    $sentencia->bindParam(":usuario",$usuario);
    $sentencia->bindParam(":password",$password);
    $sentencia->bindParam(":correo",$correo);
    $sentencia->bindParam(":id",$txtID);

    $sentencia->execute();

    // el header sirve para redireccionar a otra página
    $mensaje="Registro actualizado con éxito";
    header("Location: index.php?mensaje".$mensaje);
}

include("../../templates/header.php"); ?>


<div class="card">
    <div class="card-header">
        Usuario
    </div>
    <div class="card-body">
        <form action="" method="post">

        <div class="mb-3">
          <label for="txtID" class="form-label">ID:</label>
          <input type="text"
            class="form-control" readonly value="<?php echo $txtID ?>"  name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
        </div>

        <div class="mb-3">
          <label for="usuario" class="form-label">Nombre del usuario</label>
          <input type="text"
            class="form-control"  value="<?php echo $usuario ?>" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Nombre del usuario">
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password"
            class="form-control"  value="<?php echo $password ?>" name="password" id="password" aria-describedby="helpId" placeholder="Password">
        </div>

        
        <div class="mb-3">
          <label for="correo" class="form-label">Correo:</label>
          <input type="email"
            class="form-control"  value="<?php echo $correo ?>" name="correo" id="correo" aria-describedby="helpId" placeholder="Correo">
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>

        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
</div>

<?php include("../../templates/footer.php"); ?>