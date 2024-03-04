<?php
// me conecto a la base de datos
include("../../bd.php");

//RECUEPRA REGISTROS
if(isset($_GET['txtID'])){ //AQUI ESTAMOS DETECTANDO QUE NOS ENVIARON UN ID MEDIANTE LA URL txtId
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";  //tenemos un txtId que lo que hace es recueprar el dato en la variable txtID
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_servicios` WHERE id = :id;");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    //Vamos almacenar los datros en una variable llamada registros
    //utilizamos el FETCH_LAZY para que nos traiga los datos de la base de datos, solo un registro
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    //leemos todos los datos que privienen de ese selección
    $icono = $registro['icono'];
    $titulo = $registro['titulo'];
    $descripcion = $registro['descripcion'];

    }

//QUE SE EDITEN LOS REGISTROS
if($_POST){
    print_r($_POST);

    $txtID=(isset($_POST['txtID']))?$_POST['txtID'] : "";
    $icono = (isset($_POST['icono']))?$_POST['icono'] : "";
    $titulo = (isset($_POST['titulo']))?$_POST['titulo'] : "";
    $descripcion = (isset($_POST['descripcion']))?$_POST['descripcion'] : "";

    $sentencia=$conexion->prepare("UPDATE tbl_servicios
    SET icono=:icono, titulo=:titulo, descripcion=:descripcion
    WHERE id = :id;"); //el id es el que se va a editar

    $sentencia->bindParam(":icono",$icono);
    $sentencia->bindParam(":titulo",$titulo);
    $sentencia->bindParam(":descripcion",$descripcion);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();

    // el header sirve para redireccionar a otra página
    $mensaje="Registro actualizado con éxito";
    header("Location: index.php?mensaje".$mensaje);
}


include("../../templates/header.php"); ?>

<div class="card">

    <div class="card-header">
        Editar Servicios
    </div>

    <div class="card-body">
    <!-- el enctype sirve para subir archivos - como adjuntar un imágen, archivo  pdf--->
        <form action="" enctype="multipart/form-data"  method="post">

        <div class="mb-3">
          <label for="txtID" class="form-label">ID: </label>
          <!-- le pondemos readonly para que no se pueda editar -->
          <input readonly value=" <?php echo $txtID; ?> " type="text"
            class="form-control" name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
        </div>

        <div class="mb-3">
          <label for="" class="form-label">Icono: </label>
          <input  value=" <?php echo $icono; ?> " type="text"
            class="form-control" name="icono" id="icono" aria-describedby="helpId" placeholder="Icono">
        </div>

        <div class="mb-3">
          <label for="titulo" class="form-label">Título</label>
          <input  value=" <?php echo $titulo; ?> " type="text"
            class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Título">
        </div>

        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <input  value=" <?php echo $descripcion; ?> " type="text"
            class="form-control" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripción">
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>

        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>

</div>


<?php include("../../templates/footer.php"); ?>