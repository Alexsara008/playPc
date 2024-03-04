<?php 
// agregamos la base de datos
include("../../bd.php");

if($_POST){

    //recepcionamos los valores que estamos poniendo en el formulario
    $titulo=isset($_POST['titulo']) ? $_POST['titulo']: "";
    $subtitulo=isset($_POST['subtitulo']) ? $_POST['subtitulo']: "";
    // recepcionamos la imagen
    $imagen=isset($_FILES['imagen']['name']) ? $_FILES['imagen']['name']: ""; //si viene algo vamos a recibir el nombre de la imagen de lo contrario vamos a recibir un string vacio
    $descripcion=isset($_POST['descripcion']) ? $_POST['descripcion']: "";
    $cliente=isset($_POST['cliente']) ? $_POST['cliente']: "";
    $categoria=isset($_POST['categoria']) ? $_POST['categoria']: "";
    $url=isset($_POST['url']) ? $_POST['url']: "";

    //VAMOS A SUBIR LA IMAGEN
    $fecha_imagen=new DateTime();
    // vamos a preguntar si imagen es diferente de vacio
    $nombre_archivo_imagen=($imagen!="")? $fecha_imagen->getTimestamp()."_".$imagen:""; 
    // si imagen es diferente de vacio vamos a concatenar el timestamp con el nombre de la imagen
    //AGREGAR LA IMAGEN
    $tmp_imagen= $_FILES['imagen']['tmp_name'];
    if($tmp_imagen!=""){
        move_uploaded_file($tmp_imagen,"../../../assets/img/portfolio/".$nombre_archivo_imagen);
    } 


    //INSERTAMOS LOS DATOS EN LA BASE DE DATOS
    $sentencia=$conexion->prepare("INSERT INTO `tbl_portafolio` (`ID`, `titulo`, `subtitulo`, `imagen`, `descripcion`, `cliente`, `categoria`, `url`) 
    VALUES (NULL, :titulo, :subtitulo, :imagen, :descripcion, :cliente, :categoria, :url);");
    
    $sentencia->bindParam(":titulo",$titulo);
    $sentencia->bindParam(":subtitulo",$subtitulo);
    $sentencia->bindParam(":imagen",$nombre_archivo_imagen);
    $sentencia->bindParam(":descripcion",$descripcion);
    $sentencia->bindParam(":cliente",$cliente);
    $sentencia->bindParam(":categoria",$categoria);
    $sentencia->bindParam(":url",$url);
    
    
    $sentencia->execute();

    // el header sirve para redireccionar a otra página
    $mensaje="Registro ingresado con éxito";
    header("Location: index.php?mensaje".$mensaje);
}

include("../../templates/header.php"); 
?>

<div class="card">
    <div class="card-header">
        Crear
    </div>
    <div class="card-body">
        <form action=""  enctype="multipart/form-data" method="post">

            <div class="mb-3">
              <label for="titulo" class="form-label">Título:</label>
              <input type="text"
                class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Título">
            </div>

            <div class="mb-3">
              <label for="subtitulo" class="form-label">Subtítulo:</label>
              <input type="text"
                class="form-control" name="subtitulo" id="subtitulo" aria-describedby="helpId" placeholder="Subtítulo">
            </div>

            <!-- capturar la imagen - debemos poner tipo file   -->
            <div class="mb-3">
              <label for="imagen" class="form-label">Imagen:</label>
              <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Imagen" aria-describedby="fileHelpId">
            </div>

            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción:</label>
              <input type="text"
                class="form-control" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripción">
            </div>

            <div class="mb-3">
              <label for="cliente" class="form-label">Cliente:</label>
              <input type="text"
                class="form-control" name="cliente" id="cliente" aria-describedby="helpId" placeholder="Cliente">
            </div>

            <div class="mb-3">
              <label for="categoria" class="form-label">Categoria:</label>
              <input type="text"
                class="form-control" name="categoria" id="categoria" aria-describedby="helpId" placeholder="Categoria">
            </div>

            <div class="mb-3">
              <label for="url" class="form-label">URL:</label>
              <input type="text"
                class="form-control" name="url" id="url" aria-describedby="helpId" placeholder="URL del sitio">
            </div>


            <button type="submit" class="btn btn-success">Agregar</button>

            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>

</div>

<?php include("../../templates/footer.php"); ?>