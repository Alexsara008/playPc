<?php 
// base de datos
include("../../bd.php");
if($_POST){
    //recepcionamos los datos
    $fecha=(isset($_POST['fecha']))?$_POST['fecha']:"";
    $titulo=(isset($_POST['titulo']))?$_POST['titulo']:"";
    $descripcion=(isset($_POST['descripcion']))?$_POST['descripcion']:"";
    //recepcionamos la imagen
    $imagen=(isset($_FILES['imagen']['name']))?$_FILES['imagen']['name']:"";


        //VAMOS A SUBIR LA IMAGEN
        $fecha_imagen=new DateTime();
        // vamos a preguntar si imagen es diferente de vacio
        $nombre_archivo_imagen=($imagen!="")? $fecha_imagen->getTimestamp()."_".$imagen:""; 
        // si imagen es diferente de vacio vamos a concatenar el timestamp con el nombre de la imagen
        //AGREGAR LA IMAGEN
        $tmp_imagen= $_FILES['imagen']['tmp_name'];
        if($tmp_imagen!=""){
            move_uploaded_file($tmp_imagen,"../../../assets/img/about/".$nombre_archivo_imagen);
        }


    //INSERTAMOS LOS DATOS EN LA BASE DE DATOS
    $sentencia=$conexion->prepare("INSERT INTO `tbl_entradas` (`ID`, `fecha`, `titulo`, `descripcion`, `imagen`)
    VALUES (NULL, :fecha, :titulo, :descripcion, :imagen);");

    $sentencia->bindParam(":fecha",$fecha);
    $sentencia->bindParam(":titulo",$titulo);
    $sentencia->bindParam(":descripcion",$descripcion);
    $sentencia->bindParam(":imagen",$nombre_archivo_imagen);  //ese nuevo nombre ponemos para que se agrege a la BD
    $sentencia->execute();

        // el header sirve para redireccionar a otra página
        $mensaje="Registro ingresado con éxito";
        header("Location: index.php?mensaje".$mensaje);

}



include("../../templates/header.php"); ?>


    <div class="card">
        <div class="card-header">
            Crear
        </div>
        <form action=""  enctype="multipart/form-data" method="post">
        <div class="card-body">

            <div class="mb-3">
              <label for="fecha" class="form-label">Fecha:</label>
              <input type="date"
                class="form-control" name="fecha" id="fecha" aria-describedby="helpId" placeholder="Fecha">
            </div>
        
            <div class="mb-3">
          <label for="titulo" class="form-label">Título:</label>
          <input type="text"
            class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Título">
            </div>

            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción:</label>
              <input type="text"
                class="form-control" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripción">
            </div>

            <div class="mb-3">
              <label for="imagen" class="form-label">Imagen:</label>
              <input type="file"
                class="form-control" name="imagen" id="imagen" aria-describedby="helpId" placeholder="Imagen">
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

            </form>
        </div>
    </div>



<?php include("../../templates/footer.php"); ?>