<?php
include ("../../db.php");

if ($_POST) {
    $nombredelpuesto = (isset($_POST['nombredelpuesto'])? $_POST['nombredelpuesto']:"");
    $sentencia = $conexion->prepare("insert into tbl_puestos(nombredelpuesto) values (:nombredelpuesto)");
    $sentencia->bindParam(":nombredelpuesto", $nombredelpuesto);
    $sentencia->execute();
    $mensaje = "Registro Creado";
    header("Location:principal.php?mensaje=". $mensaje);
}   
?>

<?php include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">DATOS DEL PUESTO</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombredelpuesto" class="form-label">Nombre del Puesto:</label>
                <input type="text" class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId"
                    placeholder="Nombre del puesto" />
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-danger" href="principal.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>