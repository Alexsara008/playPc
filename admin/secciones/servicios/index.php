<?php 

// me conecto a la base de datos
include("../../bd.php");


//BORRAR REGISTROS
if(isset($_GET['txtID'])){
//borrar registros de la tabla con el id correspondiente
//si hubo un envío con GET lo tenemos si no no
$txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
$sentencia=$conexion->prepare("DELETE FROM `tbl_servicios` WHERE id = :id;");
// necesitamos que cuando se encuentre la instrucción SQL y se encuentre la palabra icono me pongo la palabra reemplada por esta $icono
$sentencia->bindParam(":id",$txtID);
$sentencia->execute();
}

  



//seleccionar registros de la tabla
$sentencia=$conexion->prepare("SELECT * FROM `tbl_servicios`;");
$sentencia->execute();

//de la sentancia vamos a seleccionar todos los registros que nos llegan
//creamos la variable lista_servicios y le asignamos el resultado de la sentencia
$lista_servicios=$sentencia->fetchAll(PDO::FETCH_ASSOC);


include("../../templates/header.php"); ?>



<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar Registros</a>
 
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Icono</th>
                        <th scope="col">Título</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- EL foreach es un ciclo que nos permite recorrer un arreglo -->
                     <?php foreach($lista_servicios as $registros){ ?> 
                    <tr class="">
                        <td scope="row"> <?php  echo $registros['ID']; ?> </td>
                        <td> <?php echo $registros['icono']; ?> </td>
                        <td> <?php echo $registros['titulo']; ?> </td>
                        <td> <?php echo $registros['descripcion']; ?> </td>
                        <td>
                            <a name="" id="" class="btn btn-info" href="editar.php?txtID= <?php echo $registros['ID']; ?>" role="button">Editar</a>
                            <!-- cuando se aplasta en eliminar se va a enviar un id para que se ejecutado en este caso eliminado -->
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