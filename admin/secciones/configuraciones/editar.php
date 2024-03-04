<?php 
//agergar la conexión a la base de datos
include("../../bd.php");


//RECUEPRA REGISTROS
if(isset($_GET['txtID'])){ //AQUI ESTAMOS DETECTANDO QUE NOS ENVIARON UN ID MEDIANTE LA URL txtId
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";  //tenemos un txtId que lo que hace es recueprar el dato en la variable txtID
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_configuraciones` WHERE id = :id;");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    //Vamos almacenar los datos en una variable llamada registros
    //utilizamos el FETCH_LAZY para que nos traiga los datos de la base de datos, solo un registro
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    //leemos todos los datos que provienen de ese selección
    $nombreconfiguracion=$registro['nombreconfiguracion'];
    $valor=$registro['valor'];
    
    }

//QUE SE EDITEN LOS REGISTROS
if($_POST){
    print_r($_POST);

    $txtID=(isset($_POST['txtID']))?$_POST['txtID'] : "";
    $nombreconfiguracion = (isset($_POST['nombreconfiguracion']))?$_POST['nombreconfiguracion'] : "";
    $valor = (isset($_POST['valor']))?$_POST['valor'] : "";

    $sentencia=$conexion->prepare("UPDATE tbl_configuraciones
    SET nombreconfiguracion=:nombreconfiguracion, valor=:valor
    WHERE id = :id;"); //el id es el que se va a editar

    $sentencia->bindParam(":nombreconfiguracion",$nombreconfiguracion);
    $sentencia->bindParam(":valor",$valor);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();

    // el header sirve para redireccionar a otra página
    $mensaje="Registro actualizado con éxito";
    header("Location: index.php?mensaje".$mensaje);
}


include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">
        Crear
    </div>
    <div class="card-body">
        <form action="" method="post">

            <div class="mb-3">
              <label for="txtID" class="form-label">ID:</label>
              <input type="text"
                class="form-control" value="<?php echo $txtID ?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
            </div>

            <div class="mb-3">
              <label for="nombreconfiguracion" class="form-label">Nombre de la configuración:</label>
              <input type="text"
                class="form-control"  value="<?php echo $nombreconfiguracion ?>"  name="nombreconfiguracion" id="nombreconfiguracion" aria-describedby="helpId" placeholder="">
            </div>

            <div class="mb-3">
              <label for="valor" class="form-label">Valor:</label>
              <input type="text"
                class="form-control"  value="<?php echo $valor ?>"  name="valor" id="valor" aria-describedby="helpId" placeholder="Valor de la configuración">
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>

            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>

    </div>

</div>

<?php include("../../templates/footer.php"); ?>