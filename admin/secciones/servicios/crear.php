<?php 
// me conecto a la base de datos
include("../../bd.php");

//ingreso de datos a la base de datos
if($_POST){

    // para recepcionar eseos datos en la BD, vamos a recepcionar dato por dato
    // si s envia informacion nosoteros la iguales a esa variable de lo contrario no le ponemos nada
    $icono = (isset($_POST['icono']))?$_POST['icono'] : "";
    $titulo = (isset($_POST['titulo']))?$_POST['titulo'] : "";
    $descripcion = (isset($_POST['descripcion']))?$_POST['descripcion'] : "";
 
    $sentencia=$conexion->prepare("INSERT INTO `tbl_servicios` (`ID`, `icono`, `titulo`, `descripcion`) 
    VALUES (NULL, :icono, :titulo, :descripcion);");

    // necesitamos que cuando se encuentre la instrucción SQL y se encuentre la palabra icono me pongo la palabra reemplada por esta $icono
    $sentencia->bindParam(":icono",$icono); 
    $sentencia->bindParam(":titulo",$titulo);
    $sentencia->bindParam(":descripcion",$descripcion);
    $sentencia->execute();

        // el header sirve para redireccionar a otra página
        $mensaje="Registro ingresado con éxito";
        header("Location: index.php?mensaje".$mensaje);
}


include("../../templates/header.php"); 
?>

<div class="card">

    <div class="card-header">
        Crear Servicios
    </div>

    <div class="card-body">
    <!-- el enctype sirve para subir archivos - como adjuntar un imágen, archivo  pdf--->
        <form action="" enctype="multipart/form-data"  method="post"> 
        <div class="mb-3">
          <label for="" class="form-label">Icono: </label>
          <input type="text"
            class="form-control" name="icono" id="icono" aria-describedby="helpId" placeholder="Icono">
        </div>

        <div class="mb-3">
          <label for="titulo" class="form-label">Título</label>
          <input type="text"
            class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Título">
        </div>

        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <input type="text"
            class="form-control" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripción">
        </div>

        <button type="submit" class="btn btn-success">Agregar</button>

        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>

</div>


<?php include("../../templates/footer.php"); ?>