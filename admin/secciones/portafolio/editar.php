<?php 

//agregamos la base de datos
include("../../bd.php");

if(isset($_GET['txtID'])){

    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("SELECT * FROM tbl_portafolio WHERE id=:id;");
    $sentencia->bindParam(':id',$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    $titulo=$registro['titulo'];
    $subtitulo=$registro['subtitulo'];
    $imagen=$registro['imagen'];
    $descripcion=$registro['descripcion'];
    $cliente=$registro['cliente'];
    $categoria=$registro['categoria'];
    $url=$registro['url'];
}

if($_POST){

    //  ACTUALIZAR REGISTROS
        //recepcionamos los valores que estan en el formulario
        $txtID=isset($_POST['txtID']) ? $_POST['txtID']: "";
        $titulo=isset($_POST['titulo']) ? $_POST['titulo']: "";
        $subtitulo=isset($_POST['subtitulo']) ? $_POST['subtitulo']: "";
        $descripcion=isset($_POST['descripcion']) ? $_POST['descripcion']: "";
        $cliente=isset($_POST['cliente']) ? $_POST['cliente']: "";
        $categoria=isset($_POST['categoria']) ? $_POST['categoria']: "";
        $url=isset($_POST['url']) ? $_POST['url']: "";

        $sentencia=$conexion->prepare("UPDATE tbl_portafolio
        SET 
        titulo=:titulo, 
        subtitulo=:subtitulo, 
        descripcion=:descripcion,
        cliente=:cliente,
        categoria=:categoria,
        url=:url
        WHERE id = :id;"); //el id es el que se va a editar

        
        $sentencia->bindParam(':titulo',$titulo);
        $sentencia->bindParam(':subtitulo',$subtitulo);
        $sentencia->bindParam(':descripcion',$descripcion);
        $sentencia->bindParam(':cliente',$cliente);
        $sentencia->bindParam(':categoria',$categoria);
        $sentencia->bindParam(':url',$url);
        $sentencia->bindParam(':id',$txtID);
        $sentencia->execute();

        
        // el header sirve para redireccionar a otra página
        $mensaje="Registro actualizado con éxito";
        header("Location: index.php?mensaje".$mensaje);

        //ACTUALIZAR IMAGEN
        if($_FILES["imagen"]["name"]!=""){  //primero validamos si hay una imagen

            //TRAEMOS EL dato que estaba arriba de recpcion de daros
        $imagen=isset($_FILES['imagen']['name']) ? $_FILES['imagen']['name']: "";
        $fecha_imagen=new DateTime();
        // vamos a preguntar si imagen es diferente de vacio
        $nombre_archivo_imagen=($imagen!="")? $fecha_imagen->getTimestamp()."_".$imagen:""; 
        // si imagen es diferente de vacio vamos a concatenar el timestamp con el nombre de la imagen
        //AGREGAR LA IMAGEN
        $tmp_imagen= $_FILES['imagen']['tmp_name'];
        move_uploaded_file($tmp_imagen,"../../../assets/img/portfolio/".$nombre_archivo_imagen);

        //BORRADO DEL ARCHIVO ANTERIOR
        //vamos a seleccionar la imagen que le corresponde a ese ID
        $sentencia=$conexion->prepare("SELECT imagen FROM tbl_portafolio WHERE id=:id;");
        $sentencia->bindParam(':id',$txtID);
        $sentencia->execute();
        $registro_imagen=$sentencia->fetch(PDO::FETCH_LAZY);

        //BORRADO DE LA IMG
        if(isset($registro_imagen['imagen'])){
            //si existe la imagen vamos a eliminarla
            // la funcion file_exists nos va a decir si existe o no la imagen
            if(file_exists("../../../assets/img/portfolio/".$registro_imagen['imagen'])){
            unlink("../../../assets/img/portfolio/".$registro_imagen['imagen']);
            }
        }



        $sentencia=$conexion->prepare("UPDATE tbl_portafolio SET imagen=:imagen WHERE id = :id;");
        $sentencia->bindParam(':imagen',$nombre_archivo_imagen);
        $sentencia->bindParam(':id',$txtID);
        $sentencia->execute();


        }
}


include("../../templates/header.php"); ?>




<div class="card">
    <div class="card-header">
        Crear
    </div>
    <div class="card-body">
        <form action=""  enctype="multipart/form-data" method="post">

            <div class="mb-3">
              <label for="txtID" class="form-label">ID</label>
              <input type="text"
                class="form-control" readonly value=" <?php echo $txtID; ?> " name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
            </div>


            <div class="mb-3">
              <label for="titulo" class="form-label">Título:</label>
              <input type="text"
                class="form-control"  value="<?php echo $titulo;?>" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Título">
            </div>

            <div class="mb-3">
              <label for="subtitulo" class="form-label">Subtítulo:</label>
              <input type="text"
                class="form-control"  value="<?php echo $subtitulo;?>" name="subtitulo" id="subtitulo" aria-describedby="helpId" placeholder="Subtítulo">
            </div>

            <!-- capturar la imagen - debemos poner tipo file   -->
            <div class="mb-3">
              <label for="imagen" class="form-label">Imagen:</label>
              <img width="70" src="../../../assets/img/portfolio/<?php echo $imagen; ?> " alt="">
              <input type="file"  class="form-control" name="imagen" id="imagen" placeholder="Imagen" aria-describedby="fileHelpId">
            </div>

            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción:</label>
              <input type="text"
                class="form-control"  value="<?php echo $descripcion;?>" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripción">
            </div>

            <div class="mb-3">
              <label for="cliente" class="form-label">Cliente:</label>
              <input type="text"
                class="form-control"  value="<?php echo $cliente;?>" name="cliente" id="cliente" aria-describedby="helpId" placeholder="Cliente">
            </div>

            <div class="mb-3">
              <label for="categoria" class="form-label">Categoria:</label>
              <input type="text"
                class="form-control" value="<?php echo $categoria;?>" name="categoria" id="categoria" aria-describedby="helpId" placeholder="Categoria">
            </div>

            <div class="mb-3">
              <label for="url" class="form-label">URL:</label>
              <input type="text"
                class="form-control"  value="<?php echo $url;?>" name="url" id="url" aria-describedby="helpId" placeholder="URL del sitio">
            </div>


            <button type="submit" class="btn btn-success">Actualizar</button>

            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>

</div>

<?php include("../../templates/footer.php"); ?>