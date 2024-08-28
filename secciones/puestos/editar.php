<?php
include ("../../db.php");

// Carga los datos del puesto
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID']))? $_GET['txtID']:"";

    $sentencia = $conexion->prepare("select * from tbl_puestos where id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $nombredelpuesto = $registro["nombredelpuesto"];
}

// Actualiza los datos del puesto
if ($_POST) {
    $txtID = (isset($_POST['txtID']))? $_POST['txtID']:"";
    $nombredelpuesto = (isset($_POST['nombredelpuesto'])? $_POST['nombredelpuesto']:"");
    $sentencia = $conexion->prepare("update tbl_puestos set nombredelpuesto=:nombredelpuesto
        where id=:id");
    $sentencia->bindParam(":nombredelpuesto", $nombredelpuesto);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje = "Registro Actualizado";
    header("Location:principal.php?mensaje=".$mensaje);
}
?>

<?php include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">DATOS DEL PUESTO</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" value="<?php echo $txtID;?>"
                    class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId"
                    placeholder="ID" />
            </div>
            <div class="mb-3">
                <label for="nombredelpuesto" class="form-label">Nombre del Puesto:</label>
                <input type="text" <input type="text" value="<?php echo $nombredelpuesto;?>"
                    class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId"
                    placeholder="Nombre del puesto" />
            </div>
            <button type="submit" class="btn btn-warning">Actualizar</button>
            <a name="" id="" class="btn btn-danger" href="principal.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>