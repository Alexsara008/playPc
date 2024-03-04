<?php 
//agregamos la base de datos
include("../../bd.php");

//BORRAR REGISTROS
if(isset($_GET['txtID'])){
    //borrar registros de la tabla con el id correspondiente
    //si hubo un envío con GET lo tenemos si no no
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("DELETE FROM `tbl_usuarios` WHERE id = :id;");
    // necesitamos que cuando se encuentre la instrucción SQL y se encuentre la palabra icono me pongo la palabra reemplada por esta $icono
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    }


//seleccionar registros de la tabla
$sentencia=$conexion->prepare("SELECT * FROM `tbl_usuarios`;");
$sentencia->execute();

//de la sentancia vamos a seleccionar todos los registros que nos llegan
//creamos la variable lista_servicios y le asignamos el resultado de la sentencia
$lista_usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Crear Usuario</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th> ID </th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($lista_usuarios as $registros) { ?>
                    <tr class="">
                        <td> <?php echo $registros['ID']; ?> </td>
                        <td scope="row"> <?php echo $registros['usuario']; ?> </td>
                        <td> <?php echo $registros['password']; ?> </td>
                        <td><?php echo $registros['correo']; ?></td>
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