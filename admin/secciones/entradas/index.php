<?php 
// incluimos base de datos
include("../../bd.php");

//ELIMINAR REGISTROS
//Recepcionamos el id del registro que vamos a eliminar
if(isset($_GET['txtID'])){

    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
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

    $sentencia=$conexion->prepare("DELETE FROM tbl_entradas WHERE id=:id;");
    $sentencia->bindParam(':id',$txtID);
    $sentencia->execute();

    }



//seleccionar registros de la tabla
$sentencia=$conexion->prepare("SELECT * FROM `tbl_entradas`;");
$sentencia->execute();
//de la sentancia vamos a seleccionar todos los registros que nos llegan
//creamos la variable lista_servicios y le asignamos el resultado de la sentencia
$lista_entradas=$sentencia->fetchAll(PDO::FETCH_ASSOC);




include("../../templates/header.php"); ?>


<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar Entradas</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Título</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($lista_entradas as $registros) { ?>
                    <tr class="">
                        <td scope="row"> <?php echo $registros['ID']; ?> </td>
                        <td> <?php echo $registros['fecha']; ?> </td>
                        <td> <?php echo $registros['titulo']; ?> </td>
                        <td> <?php echo $registros['descripcion']; ?> </td>
                        <td> 
                        <img width="70" src="../../../assets/img/about/<?php echo $registros['imagen']; ?> " alt="">
                        </td>

                        <td>
                        <a name="" id="" class="btn btn-info" href="editar.php?txtID= <?php echo $registros['ID']; ?>" role="button">Editar</a> 
                        <a name="" id="" class="btn btn-danger" href="index.php?txtID= <?php echo $registros['ID']; ?> " role="button">Eliminar</a>
                        </td>
                        
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        
    </div>

</div>


<?php include("../../templates/footer.php"); ?> 