<?php 
// base de datos
include("../../bd.php");

if(isset($_GET['txtID'])){

    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("SELECT * FROM tbl_entradas WHERE id=:id;");
    $sentencia->bindParam(':id',$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    $fecha=$registro['fecha'];
    $titulo=$registro['titulo'];
    $descripcion=$registro['descripcion'];
    $imagen=$registro['imagen'];


}
//actualizar registros
if($_POST){
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    //recepcionamos los datos
    $fecha=(isset($_POST['fecha']))?$_POST['fecha']:"";
    $titulo=(isset($_POST['titulo']))?$_POST['titulo']:"";
    $descripcion=(isset($_POST['descripcion']))?$_POST['descripcion']:"";
    //recepcionamos la imagen
    $imagen=(isset($_FILES['imagen']['name']))?$_FILES['imagen']['name']:"";


    $sentencia=$conexion->prepare("UPDATE tbl_entradas
        SET 
        fecha=:fecha, 
        titulo=:titulo, 
        descripcion=:descripcion
        WHERE id = :id;"); //el id es el que se va a editar

        $sentencia->bindParam(':fecha',$fecha);
        $sentencia->bindParam(':titulo',$titulo);
        $sentencia->bindParam(':descripcion',$descripcion);
        $sentencia->bindParam(':id',$txtID);
 
        $sentencia->execute();

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
                move_uploaded_file($tmp_imagen,"../../../assets/img/about/".$nombre_archivo_imagen);
        
                //BORRADO DEL ARCHIVO ANTERIOR
                //vamos a seleccionar la imagen que le corresponde a ese ID
                $sentencia=$conexion->prepare("SELECT imagen FROM tbl_entradas WHERE id=:id;");
                $sentencia->bindParam(':id',$txtID);
                $sentencia->execute();
                $registro_imagen=$sentencia->fetch(PDO::FETCH_LAZY);
        
                //BORRADO DE LA IMG
                if(isset($registro_imagen['imagen'])){
                    //si existe la imagen vamos a eliminarla
                    // la funcion file_exists nos va a decir si existe o no la imagen
                    if(file_exists("../../../assets/img/about/".$registro_imagen['imagen'])){
                    unlink("../../../assets/img/about/".$registro_imagen['imagen']);
                    }
                }
        
        
        
                $sentencia=$conexion->prepare("UPDATE tbl_entradas SET imagen=:imagen WHERE id = :id;");
                $sentencia->bindParam(':imagen',$nombre_archivo_imagen);
                $sentencia->bindParam(':id',$txtID);
                $sentencia->execute();
                
                $imagen=$nombre_archivo_imagen;
        
                // el header sirve para redireccionar a otra página
                $mensaje="Registro actualizado con éxito";
                header("Location: index.php?mensaje".$mensaje);
        
                }
        
}


include("../../templates/header.php"); ?>

<div class="card">
        <div class="card-header">
            Editar
        </div>
        <form action=""  enctype="multipart/form-data" method="post">
        <div class="card-body">
            <div class="mb-3">
              <label for="txtID" class="form-label">ID:</label>
              <input type="text"
                class="form-control" readonly value="<?php  echo $txtID ?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="">
            </div>


            <div class="mb-3">
              <label for="fecha" class="form-label">Fecha:</label>
              <input type="date"
                class="form-control"  value="<?php  echo $fecha ?>" name="fecha" id="fecha" aria-describedby="helpId" placeholder="Fecha">
            </div>
        
            <div class="mb-3">
          <label for="titulo" class="form-label">Título:</label>
          <input type="text"
            class="form-control"  value="<?php  echo $titulo ?>" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Título">
            </div>

            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción:</label>
              <input type="text"
                class="form-control"  value="<?php  echo $descripcion ?>" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripción">
            </div>

            <div class="mb-3">
              <label for="imagen" class="form-label">Imagen:</label>
              <img width="70" src="../../../assets/img/about/<?php echo $imagen; ?> " alt="">
              <input type="file"
                class="form-control" name="imagen" id="imagen" aria-describedby="helpId" placeholder="Imagen">
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

            </form>
        </div>
    </div>




<?php include("../../templates/footer.php"); ?>