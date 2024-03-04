<?php 
//agregamos la base de datos
include("../../bd.php");

if(isset($_GET['txtID'])){

    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("SELECT * FROM tbl_equipo WHERE id=:id;");
    $sentencia->bindParam(':id',$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    $imagen=$registro['imagen'];
    $nombrecompleto=$registro['nombrecompleto'];
    $puesto=$registro['puesto'];
    $twitter=$registro['twitter'];
    $facebook=$registro['facebook'];
    $linkedin=$registro['linkedin'];

}

if($_POST){

        //  ACTUALIZAR REGISTROS
        //recepcionamos los valores que estan en el formulario
        $txtID=isset($_POST['txtID']) ? $_POST['txtID']: "";
        $nombrecompleto=isset($_POST['nombrecompleto']) ? $_POST['nombrecompleto']: "";
        $puesto=isset($_POST['puesto']) ? $_POST['puesto']: "";
        $twitter=isset($_POST['twitter']) ? $_POST['twitter']: "";
        $facebook=isset($_POST['facebook']) ? $_POST['facebook']: "";
        $linkedin=isset($_POST['linkedin']) ? $_POST['linkedin']: "";

        $sentencia=$conexion->prepare("UPDATE tbl_equipo
        SET 
        nombrecompleto=:nombrecompleto, 
        puesto=:puesto, 
        twitter=:twitter,
        facebook=:facebook,
        linkedin=:linkedin
        WHERE id = :id;"); //el id es el que se va a editar

        
        $sentencia->bindParam(':nombrecompleto',$nombrecompleto);
        $sentencia->bindParam(':puesto',$puesto);
        $sentencia->bindParam(':twitter',$twitter);
        $sentencia->bindParam(':facebook',$facebook);
        $sentencia->bindParam(':linkedin',$linkedin);
        $sentencia->bindParam(':id',$txtID);

        $sentencia->execute();

                // el header sirve para redireccionar a otra página
                $mensaje="Registro actualizado con éxito";
                header("Location: index.php?mensaje".$mensaje);

        //ACTUALIZAR IMAGEN
        if($_FILES["imagen"]["name"]!=""){  //primero validamos si hay una imagen

            //TRAEMOS EL dato que estaba arriba de recepcion de datos
        $imagen=isset($_FILES['imagen']['name']) ? $_FILES['imagen']['name']: "";
        $fecha_imagen=new DateTime();
        // vamos a preguntar si imagen es diferente de vacio
        $nombre_archivo_imagen=($imagen!="")? $fecha_imagen->getTimestamp()."_".$imagen:""; 
        // si imagen es diferente de vacio vamos a concatenar el timestamp con el nombre de la imagen

        //AGREGAR LA IMAGEN
        $tmp_imagen= $_FILES['imagen']['tmp_name'];
        move_uploaded_file($tmp_imagen,"../../../assets/img/team/".$nombre_archivo_imagen);

        //BORRADO DEL ARCHIVO ANTERIOR
        //vamos a seleccionar la imagen que le corresponde a ese ID
        $sentencia=$conexion->prepare("SELECT imagen FROM tbl_equipo WHERE id=:id;");
        $sentencia->bindParam(':id',$txtID);
        $sentencia->execute();
        $registro_imagen=$sentencia->fetch(PDO::FETCH_LAZY);

        //BORRADO DE LA IMG
        if(isset($registro_imagen['imagen'])){
            //si existe la imagen vamos a eliminarla
            // la funcion file_exists nos va a decir si existe o no la imagen
            if(file_exists("../../../assets/img/team/".$registro_imagen['imagen'])){
            unlink("../../../assets/img/team/".$registro_imagen['imagen']);
            }
        }

        $sentencia=$conexion->prepare("UPDATE tbl_equipo SET imagen=:imagen WHERE id = :id;");
        $sentencia->bindParam(':imagen',$nombre_archivo_imagen);
        $sentencia->bindParam(':id',$txtID);
        $sentencia->execute();



        }
}
include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">
        Datos de la persona
    </div>
    <div class="card-body">
        <form action=""  enctype="multipart/form-data" method="post">

        <div class="mb-3">
          <label for="txtID" class="form-label">ID</label>
          <input type="text"
            class="form-control"  readonly  value="<?php echo $txtID;?>"  name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
        </div>

        <div class="mb-3">
          <label for="imagen" class="form-label">Imagen:</label>
          <img width="70" src="../../../assets/img/team/<?php echo $imagen;?> " alt="">
          <input type="file" class="form-control" name="imagen" id="imagen" aria-describedby="helpId" placeholder="Imagen">
        </div>

        <div class="mb-3">
          <label for="nombrecompleto" class="form-label">Nombre completo:</label>
          <input type="text" 
          class="form-control" value="<?php echo $nombrecompleto;?>"  name="nombrecompleto" id="nombrecompleto" aria-describedby="helpId" placeholder="Nonbre Completo">
        </div>

        <div class="mb-3">
          <label for="puesto" class="form-label">Puesto:</label>
          <input type="text" class="form-control" value="<?php echo $puesto;?>" name="puesto" id="puesto" aria-describedby="helpId" placeholder="Puesto">
        </div>

        <div class="mb-3">
          <label for="twitter" class="form-label">Twitter:</label>
          <input type="text" class="form-control" value="<?php echo $twitter;?>" name="twitter" id="twitter" aria-describedby="helpId" placeholder="Twitter">
        </div>

        <div class="mb-3">
          <label for="facebook" class="form-label">Facebook:</label>
          <input type="text"
        class="form-control" value="<?php echo $facebook;?>" name="facebook" id="facebook" aria-describedby="helpId" placeholder="Facebook">
        </div>

        <div class="mb-3">
          <label for="linkedin" class="form-label">Linkedin:</label>
          <input type="text"
            class="form-control"  value="<?php echo $linkedin;?>" name="linkedin" id="linkedin" aria-describedby="helpId" placeholder="Linkedin">
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>

        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>

    </div>

</div>

<?php include("../../templates/footer.php"); ?>