<?php
include ("../../db.php");

// Listar Usuarios
$sentencia = $conexion->prepare("select * from tbl_usuarios");
$sentencia->execute();
$lista_tbl_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Eliminar Usuarios
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID']))? $_GET['txtID']:"";
    $sentencia = $conexion->prepare("delete from tbl_usuarios where id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje = "Registro Eliminado";
    header("Location:principal.php?mensaje=".$mensaje);
}
?>

<?php include("../../templates/header.php"); ?>

<h3>Usuarios</h3>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-success" href="crear.php" role="button">Agregar Usuario</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table id="tabla_id" class="table display" >
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del Usuario</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Email</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tbl_usuarios as $registro) {?>
                        <tr class="">
                            <td scope="row"><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['usuario']; ?></td>
                            <td><?php echo $registro['pass']; ?></td>
                            <td><?php echo $registro['correo']; ?></td>
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

<?php include("../../templates/footer.php"); ?>