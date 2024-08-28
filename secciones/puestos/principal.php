<?php

include ("../../db.php");

// Eliminar Puestos
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID']))? $_GET['txtID']:"";
    $sentencia = $conexion->prepare("delete from tbl_puestos where id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje = "Registro Eliminado";
    header("Location:principal.php?mensaje=".$mensaje);
}

// Listar Puestos
$sentencia = $conexion->prepare("select * from tbl_puestos");
$sentencia->execute();
$lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include ("../../templates/header.php"); ?>

<h3>Puestos</h3>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-success" href="crear.php" role="button">Agregar Puesto</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table id="tabla_id" class="table display">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del Puesto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tbl_puestos as $registro) {?>
                        <tr class="">
                            <td scope="row"><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['nombredelpuesto']; ?></td>
                            <td><a name="btneditar" id="btneditar" class="btn btn-warning"
                                    href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>
                                <a name="btneliminar" id="btneliminar" class="btn btn-danger"
                                    href="javascript:borrar(<?php echo $registro['id']; ?>)" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include ("../../templates/footer.php"); ?>