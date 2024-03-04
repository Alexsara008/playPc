<?php 
//agrgamos base de datos
include("../../bd.php");

if($_POST){

    // para resepcionar eseos datos en la BD, vamos a recepcionar dato por dato
    // si s envia informacion nosoteros la iguales a esa variable de lo contrario no le ponemos nada
    $nombreconfiguracion= (isset($_POST['nombreconfiguracion']))?$_POST['nombreconfiguracion'] : "";
    $valor = (isset($_POST['valor']))?$_POST['valor'] : "";

 
    $sentencia=$conexion->prepare("INSERT INTO `tbl_configuraciones` (`ID`, `nombreconfiguracion`, `valor`) 
    VALUES (NULL, :nombreconfiguracion, :valor);");

    // necesitamos que cuando se encuentre la instrucción SQL y se encuentre la palabra icono me pongo la palabra reemplada por esta $icono
    $sentencia->bindParam(":nombreconfiguracion",$nombreconfiguracion);
    $sentencia->bindParam(":valor",$valor);
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
    <div class="card-body">
        <form action="" method="post">

            <div class="mb-3">
              <label for="nombreconfiguracion" class="form-label">Nombre de la configuración</label>
              <input type="text"
                class="form-control" name="nombreconfiguracion" id="nombreconfiguracion" aria-describedby="helpId" placeholder="">
            </div>

            <div class="mb-3">
              <label for="valor" class="form-label">Valor</label>
              <input type="text"
                class="form-control" name="valor" id="valor" aria-describedby="helpId" placeholder="Valor de la configuración">
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>

            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>

    </div>

</div>


<?php include("../../templates/footer.php"); ?>